<?php

namespace App\Http\Controllers\API;

use App\Events\TelegramEvent;
use App\Http\Controllers\Controller;
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
            // 'X-IG-API-KEY' => '3699ffa0f7aceda59e386f92e2d9b465e9cedb2f',
            'X-IG-API-KEY' => setting('igApiKey'),
            // 'IG-ACCOUNT-ID' => 'Z4YNKA'
            'IG-ACCOUNT-ID' => setting('igAccId')

        ];
    }
    public function webhook(Request $request)
    {
        $type = $request->get('type');
        if($type == 'incoming-telegram'){
            $content = $request->get('content');
            event(new TelegramEvent($content));
            Message::create([
                'direction' => 'incoming',
                'sender' => $content['phone'],
                'message' => $content['text']
            ]);

            $this->doTrade($content['text']);
            
            return response('success', 200);
        }elseif($type == 'qr'){
            $code = $request->get('qr');
            Log::info('Telegram QR' . $code);
            event(new TelegramEvent(['qr' => $code]));
            return response('recieved', 200);
        }
    }

    public function doTrade($message)
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

        if($tradeType == 'SELL' AND (floatval($epic['bid']) < floatval($entryPoint) AND floatval($entryPoint > $profit)) ){
            
        }

        if($tradeType == 'SELL' AND (floatval($epic['bid']) < floatval($entryPoint) AND floatval($entryPoint) > floatval($takeProfits[0])) ){
            $apiPath = '/positions/otc';
        }elseif($tradeType == 'SELL' AND (floatval($epic['bid']) > floatval($entryPoint))){
            $apiPath = '/workingorders/otc';
        }else{
            (new WhatsappController)->sendWhatsapp('MISSED TRADE');
        }

        foreach($takeProfits as $profit){
            
            $body = [
                "epic" => $epic['epic'],
                "expiry" => "-",
                "direction" => $tradeType,
                "size" => '1',
                "orderType" => "LIMIT", // Market
                "level" => $entryPoint,
                "guaranteedStop" => "false",
                "stopLevel" => $profit,
                "stopDistance" => null,
                "forceOpen" => "false",
                "limitLevel" => $stopLoss,
                "limitDistance" => null,
                "quoteId" => null,
                "currencyCode" => setting('igCurrency')
            ];

            

            $headers = $this->headers;
    
            // $response = Http::withHeaders($headers)->withToken($token)->post('https://demo-api.ig.com/gateway/deal/positions/otc', $body);
            $response = Http::withHeaders($headers)->withToken($token)->post(setting('igPathUrl').'/positions/otc', $body);
            $body = $response->body();
            $body = json_decode($body);
            Log::info($response->body());
            $dealRef[] = $body->dealReference;
        }

        foreach($dealRef as $ref){
            $dealConfirmation = Http::withHeaders($this->headers)->withToken($token)->get(setting('igPathUrl').'/confirms/' . $ref);
            $body = $dealConfirmation->body();
            $body = json_decode($body);

            //Send Whatsapp Message
            (new WhatsappController)->sendWhatsapp('Deal Status: ' .$body->dealStatus . ', Reason: ' . $body->reason);
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
            // "identifier" => "harshanalaravel",
            "identifier" => setting('igUsername'),
            "password" => setting('igPassword')
            // "password" => "Elakiri123"
        ];
        $headers = $this->headers;
        $headers['VERSION'] = '3';

        $response = Http::withHeaders($headers)->post(setting('igPathUrl').'/session', $body);
        $body = $response->body();
        $body = json_decode($body);
        $accessToken = $body->oauthToken->access_token;
        // Log::info('Token ' . $accessToken);
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

    public function createPosition($epic, $direction, $size, $level, $stopLevel, $currencyCode)
    {
        # code...
    }

    public function callToIG($method, $endPoint, $data){
        $response = Http::withHeaders($this->headers)->{$method}(setting('igPathUrl') . $endPoint, $data);

    }

    public function test()
    {
        $msg = 'EURUSD SELL @ 0.9998

        TP: 1.00298 (scalper) 
        TP: 1.0012 (intraday) 
        TP: 0.9666 (swing)
        SL: 1.7878
        
        ▪️Use money management 2-3%';

        $filtered = $this->filter_data($msg);

        $stopLosses = array_filter($filtered, function($data){
            return $data['type'] == 'stop-loss';
        });
        foreach($stopLosses as $sl){
            $stopLostPoints = $this->filterTradeValues($msg, $sl['data']);
        }

        $tradeFilters = array_filter($filtered, function($data){
            return $data['type'] == 'trade';
        });
        $tradeType = array_values($tradeFilters)[0]['data'];
        // foreach($tradeFilters as $trade){
        //     $trades = $this->filterTradeValues($msg, $trade['data']);
        // }

        $entryFilters = array_filter($filtered, function($data){
            return $data['type'] == 'entry';
        });
        foreach($entryFilters as $entry){
            $entryPoints = $this->filterTradeValues($msg, $entry['data']);
        }

        $profitFilters = array_filter($filtered, function($data){
            return $data['type'] == 'take-profit';
        });
        foreach($profitFilters as $tp){
            $takeProfits = $this->filterTradeValues($msg, $tp['data']);
        }
            
        // echo '<pre>';
        // print_r($entryFilters);
        // echo '</pre>';
        
        echo '<pre>';
        print_r($entryPoints[0]);
        echo '</pre>';


    }
}
