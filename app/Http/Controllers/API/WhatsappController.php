<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Events\WhatsappEvent;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsappController extends Controller
{
    // public function receiveQR(Request $request)
    // {   
    //     $qrCode = $request->get('qr');
    //     event(new WhatsappEvent($qrCode));
    //     return response()->json(['status' => 'success'], 200);
    // }
    // public $message;
    // public function __construct($message)
    // {
    //     $this->message = $message;
    // }

    public function webhook(Request $request)
    {
        $type = $request->get('type');
        if($type == 'qr'){
            event(new WhatsappEvent(['qr' => $request->get('content')]));
        }
    }

    public function sendWhatsapp($message)
    {
        $client = new Client();
        $res = $client->request('POST', env('TELESAPP_SERVER') . '/forward-msg', [
            'form_params' => [
                'to' => setting('whatsappNumber'),
                'message' => $message
            ]
        ]);
        
        // If the status code is 200 theng et the body contents
        if ($res->getStatusCode() == 200) {
            $response_data = $res->getBody()->getContents();
        }
    }
}
