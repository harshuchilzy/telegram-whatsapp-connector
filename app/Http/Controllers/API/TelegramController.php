<?php

namespace App\Http\Controllers\API;

use App\Events\TelegramEvent;
use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Filter;
use App\Models\Message;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TelegramController extends Controller
{

    public function __construct()
    {
        $this->headers = [
            'Content-Type' => 'application/json; charset=UTF-8',
            'Accept' => 'application/json; charset=UTF-8',
            'X-IG-API-KEY' => setting('igApiKey'), 
            'IG-ACCOUNT-ID' => setting('igAccId')
        ];
    }
    public function webhook(Request $request)
    {
        $type = $request->get('type');
        if($type == 'incoming-telegram'){
            $content = $request->get('content');
            $messageText = str_replace('*', '', $content['text']);
            $message = Message::create([
                'direction' => 'incoming',
                'sender' => isset($content['phone']) ? $content['phone'] : '',
                'message' => $messageText,
                'action' => 'unidentified'
            ]);

            $this->doTrade($messageText, $message);
            event(new TelegramEvent($content));
            
            return response('success', 200);
        }elseif($type == 'qr'){
            $code = $request->get('qr');
            Log::info('Telegram QR' . $code);
            event(new TelegramEvent(['qr' => $code]));
            return response('recieved', 200);
        }
    }

    public function doTrade($message, $messageCollection)
    {
        $filtered = $this->filter_data($message);

        if(empty($filtered)){
            return;
        }

        $currency = array_filter($filtered, function($data){
            return $data['type'] == 'currency';
        });
        if(empty($currency)){
            return;
        }
        $currency = array_values($currency)[0]['data'];
        
        $token = $this->getIGToken();
        $market = $this->pickMarketByCurrency($currency, $token);
        Log::info($market);
        $tradeFilters = array_filter($filtered, function($data){
            return $data['type'] == 'trade';
        });
        $tradeType = array_values($tradeFilters)[0]['data'];        //buy or sell
        $tradeType = Str::upper($tradeType);

        $entryFilters = array_filter($filtered, function($data){
            return $data['type'] == 'entry';
        });
        foreach($entryFilters as $entry){
            $entryPoints = $this->filterTradeValues($message, $entry['data']);
        }
        if(!empty($entryPoints) and is_array($entryPoints)){
            $entryPoint = $entryPoints[0]; //give the entry value "1.2233" etc
        }
        $stopLosses = array_filter($filtered, function($data){
            return $data['type'] == 'stop-loss';
        });

        foreach($stopLosses as $sl){
            $stopLostPoints = $this->filterTradeValues($message, $sl['data']);
            if($stopLostPoints){ break; }
        }
        $stopLoss = $stopLostPoints[0]; //gives the stop loss value "1.2211" etc
        Log::info($stopLoss);

        $profitFilters = array_filter($filtered, function($data){
            return $data['type'] == 'take-profit';
        });
        foreach($profitFilters as $tp){
            $takeProfits = $this->filterTradeValues($message, $tp['data']);
        }

        if($tradeType == 'SELL' and empty($entryPoint)){
            $entryPoint = $market['bid'];
        }elseif($tradeType == 'BUY' and empty($entryPoint)){
            $entryPoint = $market['offer'];
        }

        $body = [
            "epic" => $market['epic'],
            "expiry" => "-",
            "direction" => $tradeType,
            "size" => '1',
            // "orderType" => "LIMIT", // Market
            "level" => number_format($entryPoint, 4, '.', ''),
            "guaranteedStop" => false,
            "stopLevel" => number_format($stopLoss, 4, '.', ''), //stop loss
            "forceOpen" => false,
            // "limitLevel" => $takeprofit, //take profit
            "currencyCode" => $market['instrumentCurrency'] == 'Spot Goud' ? 'USD' : $market['instrumentCurrency']
        ];

        $msgTemplate = $currency . ' ' . $tradeType . ' @ ' . number_format($entryPoint, 4,'.', '');

        // Sell
        if($tradeType == 'SELL' AND (floatval($market['bid']) < floatval($entryPoint) AND floatval($market['bid']) > floatval($takeProfits[0])) ){ //QUESTION THIS
            $apiPath = '/positions/otc';
            $body['orderType'] = 'LIMIT';
            $body['level'] = floatval($market['bid']); // Q2
        }elseif($tradeType == 'SELL' AND (floatval($market['bid']) > floatval($entryPoint))){
            $body['type'] = 'STOP';
            $body['timeInForce'] = "GOOD_TILL_CANCELLED";
            $apiPath = '/workingorders/otc';
            unset($body['forceOpen']);
        }

        // Buy
        // 1. Works when entry is larger than current value
        elseif($tradeType == 'BUY' AND (floatval($market['offer']) > floatval($entryPoint) and floatval($market['offer']) < floatval($takeProfits[0]))){
            $apiPath = '/positions/otc';
            $body['orderType'] = 'LIMIT';
            $body['level'] = floatval($market['offer']); // Q1
        }elseif($tradeType == 'BUY' AND (floatval($market['offer'] < floatval($entryPoint)))){
            $apiPath = '/workingorders/otc';
            $body['type'] = 'STOP';
            $body['timeInForce'] = 'GOOD_TILL_CANCELLED';
            unset($body['forceOpen']);
        }
        else{
            if($tradeType == 'BUY'){
                $marketEntry = $market['offer'];
            }else{
                $marketEntry = $market['bid'];
            }
            $errorMsg = $body['level'] > floatval($entryPoint) ? floatval($entryPoint) . ' is higher than market ' . $marketEntry : floatval($entryPoint) . ' is lower than market ' . $marketEntry;
            $errorMsgTP =  floatval($takeProfits[0]) > $body['level'] ? ' and TP1 '.floatval($takeProfits[0]).' is higher than market ' . $body['level'] : ' and TP1 '.floatval($takeProfits[0]).' is lower than market ' . $body['level'];
            // $tmpMsg = 'Trade: ' . $tradeType . ', Current: ' . $body['level'] . ', Entry: ' . floatval($entryPoint) . ', TP1: ' . floatval($takeProfits[0]); 
            (new WhatsappController)->sendWhatsapp('MISSED TRADE, ' . $msgTemplate . ' | ' . $errorMsg . $errorMsgTP, $messageCollection);
            $messageCollection->action = 'REJECTED | MISSED TRADE . ' . $msgTemplate . ' | ' . $errorMsg . $errorMsgTP;
            $messageCollection->save();
            return;
        }
        // $tmpMsg = 'Trade: ' . $tradeType . ', Current: ' .floatval($epic['offer']) . ', Entry: ' . floatval($entryPoint) . ', TP1: ' . floatval($takeProfits[0]) . ', API: ' . $apiPath; 
        // Log::info($tmpMsg);

        $takeProfits[] = $takeProfits[0]; // add additional TP to iterate +1
        $takeProfits[] = $takeProfits[0]; // add additional TP to iterate +1

        $headers = $this->headers;
        $sendTrades = 0;
        foreach($takeProfits as $profit){
            
            if($sendTrades >= 1){
                $body['limitLevel'] = number_format($takeProfits[0], 4,'.', '');
            }else{
                $body['limitLevel'] = number_format($profit, 4,'.', '');
            }

            Log::info('Looping');
            Log::info($body);
    
            $response = Http::withHeaders($headers)->withToken($token)->post(setting('igPathUrl').$apiPath, $body);
            $tradeBody = $response->body();
            $tradeBody = json_decode($tradeBody);
            $messageCollection->action = ($messageCollection->action == 'unidentified' ? '' : $messageCollection->action); //Clear the action column
            if(!empty($tradeBody->errorCode)){
                (new WhatsappController)->sendWhatsapp('ERROR IN TRADE ' . $tradeBody->errorCode, $messageCollection);
                $this->saveToAction($messageCollection, 'igAPI', $tradeBody->errorCode, 'trade failed');
                $messageCollection->action = $messageCollection->action ? $messageCollection->action . ', ' . 'TP: ' .$profit . ' ' . $tradeBody->errorCode : 'TP: ' .$profit . ' ' . $tradeBody->errorCode;
                $messageCollection->save();
            }else{
                $dealRef = $tradeBody->dealReference;
                $confirmation = Http::withHeaders($this->headers)->withToken($token)->get(setting('igPathUrl').'/confirms/' . $dealRef);
                $confirmation = json_decode($confirmation->body());
                $dealConfirmation[] = $confirmation;

                if($confirmation->dealStatus == 'REJECTED'){
                    $messageCollection->action = $messageCollection->action ? $messageCollection->action . ', ' . 'TP: ' .$profit . ' ' . $confirmation->reason : 'TP: ' .$profit . ' ' .$confirmation->reason;
                }else{
                    $messageCollection->action = $messageCollection->action ? $messageCollection->action . ', ' . 'TP: ' .$profit . ' ' . $confirmation->dealStatus : 'TP: ' .$profit . ' ' . $confirmation->dealStatus;
                }
                $messageCollection->save();
            }
            $sendTrades++;
        }

        if(!empty($dealConfirmation)){
            foreach($dealConfirmation as $ref){
                // $dealConfirmation = Http::withHeaders($this->headers)->withToken($token)->get(setting('igPathUrl').'/confirms/' . $ref);
                // $body = $ref->body();

                // $this->saveToAction($messageCollection, 'igAPI', $body, $body->dealStatus);
                $this->saveToAction(null, 'igAPI', json_encode($ref), $ref->dealStatus);
            
                // $updated_time = $messageCollection->updated_at;
                // $tot_seconds =  $updated_time->diffInMilliseconds(Carbon::now());
                // $tot_seconds =  '';


                //Send Whatsapp Message
                // (new WhatsappController)->sendWhatsapp('Deal Status: ' .$ref->dealStatus . ', Reason: ' . $ref->reason . ', TTP: '.$tot_seconds, null);
                (new WhatsappController)->sendWhatsapp($ref->dealStatus . ' - ' . $msgTemplate . ($ref->reason ? ', Reason: ' . $ref->reason : ''), null);

            }
        }
    }
    
    public function filter_data($message)
    {
        $filters = Filter::all()->toArray();
        $filters = array_map(function($data){
            return ['data' => $data['match_case'], 'exact' => $data['exact_match'], 'type' => $data['type']];
        }, $filters);

        $result = array_filter($filters, function($value) use ($message) {
            if($value['exact']){
                return str_contains($message, $value['data']) !== false;
            }
            return str_contains(Str::lower($message), Str::lower($value['data'])) !== false;
        });

        $result = array_values($result);
        return $result;
    }

    public function filterTradeValues($message, $needle)
    {
        $needle = Str::upper($needle);
        $message = Str::upper($message);
        preg_match_all('/'.$needle.'(\:)? \d*\.?\d*+/',$message, $matchedArray);

        $removeEmpty = array_map('array_filter', $matchedArray);
        $filteredData = array_filter($removeEmpty, function($data){
            return array_filter($data, function($filtered){
                return preg_match('~[0-9]+~', $filtered) ? true : false; 
            });
        });
        if(count($filteredData) <= 0){
            return null;
        }
        foreach($filteredData[0] as $key => $data){
            $data = str_replace($needle, '', $data);
            $values[] = (float) filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);  
        }
        return $values;
    }

    public function getIGToken()
    {
        $body = [
            "identifier" => setting('igUsername'),
            "password" => setting('igPassword')
        ];
        $headers = $this->headers;
        $headers['VERSION'] = '3';

        $response = Http::withHeaders($headers)->post(setting('igPathUrl').'/session', $body);
        $body = $response->body();
        $body = json_decode($body);
        $accessToken = $body->oauthToken->access_token;
        return $accessToken;
    }

    public function pickMarketByCurrency($currency, $token)
    {
        Log::info(setting('igPathUrl').'/markets?searchTerm=' . $currency);
        $response = Http::withHeaders($this->headers)->withToken($token)->get(setting('igPathUrl').'/markets?searchTerm=' . $currency);
        $markets = $response->body();
        $markets = json_decode($markets);

        foreach($markets as $market){
            foreach($market as $data){
                $epic = $data->epic;
                if(str_contains($epic, 'CFD')){
                    $instrumentCurrency = explode('/', $data->instrumentName);
                    $instrumentCurrency = end($instrumentCurrency);
                    $epics[] = array(
                        'epic' => $epic,
                        'bid' => $data->bid, //current value for sell
                        'offer' => $data->offer, //current value for buy
                        'market_status' => $data->marketStatus,
                        'instrumentCurrency' => $instrumentCurrency
                    );
                }
            }
        }
        return $epics[0];
    }

    public function saveToAction($collection = null, $action = '', $log = '', $status = '')
    {
        $actionData = Action::create([
            'model' => $collection!== null ? get_class($collection) : '',
            'model_id' => $collection!== null ? $collection->id : 0,
            'action' => $action,
            'log' => $log,
            'status' => $status
        ]);
        return $actionData;
    }

    

    public function test()
    {
        $msg = 'XAUUSD SELL NOW @ 1664-1667 SL : 1669 TP1 : 1651 TP2 : 1648';

        $filtered = $this->filter_data($msg);

        // echo '<pre>';
        // print_r(($filtered));
        // echo '</pre>';


        $stopLosses = array_filter($filtered, function($data){
            return $data['type'] == 'stop-loss';
        });
        foreach($stopLosses as $sl){
            $stopLostPoints = $this->filterTradeValues($msg, $sl['data']);
        }

        // $tradeFilters = array_filter($filtered, function($data){
        //     return $data['type'] == 'trade';
        // });
        // $tradeType = array_values($tradeFilters)[0]['data'];
        // foreach($tradeFilters as $trade){
        //     $trades = $this->filterTradeValues($msg, $trade['data']);
        // }

        // $entryFilters = array_filter($filtered, function($data){
        //     return $data['type'] == 'entry';
        // });
        // foreach($entryFilters as $entry){
        //     $entryPoints = $this->filterTradeValues($msg, $entry['data']);
        // }

        $profitFilters = array_filter($filtered, function($data){
            return $data['type'] == 'take-profit';
        });
        foreach($profitFilters as $tp){
            $takeProfits = $this->filterTradeValues($msg, $tp['data']);
        }
            
        echo '<pre>';
        print_r($stopLostPoints);
        echo '</pre>';
        
        // echo '<pre>';
        // print_r($entryPoints[0]);
        // echo '</pre>';

        // $message = Message::get()->first();
        // $create_time = $message->created_at->format('H:i:s');
        // $update_time = $message->updated_at->format('H:i:s');
        // $duration =  intval($update_time) - intval($create_time);

        // // $create_time = $message->created_at;
        // // $update_time = $message->updated_at;
        // // $duration =  strtotime($update_time) - strtotime($create_time);
        // dd ($duration/3600);
    }
}
