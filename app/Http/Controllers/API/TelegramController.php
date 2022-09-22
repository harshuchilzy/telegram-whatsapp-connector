<?php

namespace App\Http\Controllers\API;

use App\Events\TelegramEvent;
use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Filter;
use App\Models\Message;
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
            event(new TelegramEvent($content));
            $message = Message::create([
                'direction' => 'incoming',
                'sender' => $content['phone'],
                'message' => $content['text'],
            ]);

            $this->doTrade($content['text'], $message);
            
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

        $currency = array_filter($filtered, function($data){
            return $data['type'] == 'currency';
        });
        $currency = array_values($currency)[0]['data'];
        
        $token = $this->getIGToken();
        $epic = $this->pickMarketByCurrency($currency, $token);

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
        $entryPoint = $entryPoints[0]; //give the entry value "1.2233" etc

        $stopLosses = array_filter($filtered, function($data){
            return $data['type'] == 'stop-loss';
        });
        foreach($stopLosses as $sl){
            $stopLostPoints = $this->filterTradeValues($message, $sl['data']);
        }
        $stopLoss = $stopLostPoints[0]; //gives the stop loss value "1.2211" etc

        $profitFilters = array_filter($filtered, function($data){
            return $data['type'] == 'take-profit';
        });
        foreach($profitFilters as $tp){
            $takeProfits = $this->filterTradeValues($message, $tp['data']);
        }

        $body = [
            "epic" => $epic['epic'],
            "expiry" => "-",
            "direction" => $tradeType,
            "size" => '1',
            // "orderType" => "LIMIT", // Market
            "level" => $entryPoint,
            "guaranteedStop" => "false",
            "stopLevel" => $stopLoss, //stop loss
            "stopDistance" => null,
            "forceOpen" => "false",
            // "limitLevel" => $takeprofit, //take profit
            "limitDistance" => null,
            "quoteId" => null,
            "currencyCode" => setting('igCurrency')
        ];

        // Sell
        if($tradeType == 'SELL' AND (floatval($epic['bid']) < floatval($entryPoint) AND floatval($entryPoint) > floatval($takeProfits[0])) ){ //QUESTION THIS
            $apiPath = '/positions/otc';
            $body['orderType'] = 'LIMIT';
            unset($body['quoteId']);

        }elseif($tradeType == 'SELL' AND (floatval($epic['bid']) > floatval($entryPoint))){
            $body['type'] = 'STOP';
            $body['timeInForce'] = "GOOD_TILL_CANCELLED";
            $apiPath = '/workingorders/otc';
            unset($body['quoteId']);
            unset($body['forceOpen']);
        }
        // Buy
        elseif($tradeType == 'BUY' AND (floatval($epic['offer'] > floatval($entryPoint) and floatval($entryPoint) < $takeProfits[0]))){
            $apiPath = '/positions/otc';
            $body['orderType'] = 'LIMIT';
        }elseif($tradeType == 'BUY' AND (floatval($epic['offer'] > floatval($entryPoint)))){
            $apiPath = '/workingorders/otc';
            $body['orderType'] = 'LIMIT';
        }
        else{
            (new WhatsappController)->sendWhatsapp('MISSED TRADE', $messageCollection);
            $messageCollection->action = 'rejected';
            $messageCollection->save();
            return;
        }

        $headers = $this->headers;

        $takeProfits[] = $takeProfits[0];
        $headers = $this->headers;
        $sendTrades = 0;
        foreach($takeProfits as $profit){
            
            if($sendTrades >= 1){
                $body['limitLevel'] = $takeProfits[0];
            }else{
                $body['limitLevel'] = $profit;
            }

            $response = Http::withHeaders($headers)->withToken($token)->post(setting('igPathUrl').$apiPath, $body);
            $tradeBody = $response->body();
            $tradeBody = json_decode($tradeBody);
            if(!empty($tradeBody->errorCode)){
                (new WhatsappController)->sendWhatsapp('ERROR IN TRADE ' . $tradeBody->errorCode, $messageCollection);
                $messageCollection->action = 'rejected';
                $messageCollection->save();
            }else{
                $dealRef[] = $tradeBody->dealReference;
            }
            $sendTrades++;
        }

        if(!empty($dealRef)){
            foreach($dealRef as $ref){
                $dealConfirmation = Http::withHeaders($this->headers)->withToken($token)->get(setting('igPathUrl').'/confirms/' . $ref);
                $body = $dealConfirmation->body();
                $body = json_decode($body);
                $this->saveToAction($messageCollection, 'igAPI', $dealConfirmation->body(), $body->dealStatus, $messageCollection);
                //Send Whatsapp Message
                $message = Message::get()->first();
                $create_time = $message->created_at->format('H:i:s');
                $update_time = $message->updated_at->format('H:i:s');
                $duration =  intval($update_time) - intval($create_time);
                $tot_seconds =  $duration / 3600;
                (new WhatsappController)->sendWhatsapp('Deal Status: ' .$body->dealStatus . ', Reason: ' . $body->reason, $messageCollection . 'Trade created'.$tot_seconds);
                $messageCollection->action = $body->dealStatus;
                $messageCollection->save();
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
                    $epics[] = array(
                        'epic' => $epic,
                        'bid' => $data->bid, //current value for sell
                        'offer' => $data->offer, //current value for buy
                        'market_status' => $data->marketStatus
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
            'model_id' => $collection!== null ? $collection->id : '',
            'action' => $action,
            'log' => $log,
            'status' => $status
        ]);
        return $actionData;
    }

    

    public function test()
    {
        // $msg = 'EURUSD SELL @ 0.9960

        // TP: 0.9956 (scalper)
        // TP: 0.9953 (intraday)
        // TP: 0.9955 (swing)
        // SL: 0.9978

        // ▪️Use money management 2-3%';

        // $filtered = $this->filter_data($msg);

        // $stopLosses = array_filter($filtered, function($data){
        //     return $data['type'] == 'stop-loss';
        // });
        // foreach($stopLosses as $sl){
        //     $stopLostPoints = $this->filterTradeValues($msg, $sl['data']);
        // }

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

        // $profitFilters = array_filter($filtered, function($data){
        //     return $data['type'] == 'take-profit';
        // });
        // foreach($profitFilters as $tp){
        //     $takeProfits = $this->filterTradeValues($msg, $tp['data']);
        // }
            
        // echo '<pre>';
        // print_r($takeProfits);
        // echo '</pre>';
        
        // echo '<pre>';
        // print_r($entryPoints[0]);
        // echo '</pre>';

        $message = Message::get()->first();
        $create_time = $message->created_at->format('H:i:s');
        $update_time = $message->updated_at->format('H:i:s');
        $duration =  intval($update_time) - intval($create_time);

        // $create_time = $message->created_at;
        // $update_time = $message->updated_at;
        // $duration =  strtotime($update_time) - strtotime($create_time);
        dd ($duration/3600);
    }
}
