<?php

namespace App\Http\Controllers\API;

use App\Events\TelegramEvent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
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
            return response('success', 200);
        }
    }
}
