<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Filter;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use function PHPSTORM_META\map;

class MessageController extends Controller
{
    public function incomingMessage(Request $request)
    {
        $message = $request->get('message');
        $sender = $request->get('sender');
        Message::create([
            'message' => $message,
            'sender' => $sender
        ]);

        $filtered = $this->filter_data($message);
        
        // Trade
        $trade = array_filter($filtered, function($data){
            return $data['type'] == 'trade';
        });
        if(!empty($trade)){
            // Call to Trade API
            $currency = array_filter($filtered, function($data){
                return $data['type'] == 'currency';
            });
            $currency = array_values($currency)[0]['data'];
            Log::info('Trade ' . $trade[0]['data'] . ', Currency: ' . $currency);

        }else{ //Unidentified - Notify by an email and whatsapp

        }
        
        return response()->json(['status' => 'success'], 200);
    }

    public function inbox()
    {
        $messages = Message::all();
        return inertia()->render('Messages/MessageBox',[
            'messages' => $messages
        ]);
    }

    public function test()
    {
        $string = 'EURUSD BUY @ 0.9910 (set point)
        TP: 0.9945 (scalper)
        TP: 0.9970 (intra-day)
        TP: 1.0045
        SL: 0.9845';

        $result = $this->filter_data($string);

        // $trade = array_filter($result, function($data){
        //     return $data['type'] == 'trade';
        // });

        // $currency = array_filter($result, function($data){
        //     return $data['type'] == 'currency';
        // });
        // print_r(array_values($currency)[0]['data']);
        echo '<pre>';
        print_r(array_values($result));
        echo '</pre>';

        return;
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
    
}
