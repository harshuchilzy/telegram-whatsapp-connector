<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Events\WhatsappEvent;
use App\Models\Action;
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

    public function sendWhatsapp($message, $collection = null)
    {
        $client = new Client();
        $res = $client->request('POST', env('TELESAPP_SERVER') . '/forward-msg', [
            'form_params' => [
                'to' => setting('whatsappNumber'),
                'message' => $message
            ]
        ]);

        
        $response_data = '';
        // If the status code is 200 theng et the body contents
        if ($res->getStatusCode() == 200) {
            $response_data = $res->getBody()->getContents();
        }

        $actionData = Action::create([
            'model' => $collection !== null AND !is_string($collection) ? get_class($collection) : '',
            'model_id' => $collection!== null AND !is_string($collection) ? $collection->id : 0,
            'action' => 'whatsapp',
            'log' => $message,
            'status' => $response_data
        ]);
    }
}
