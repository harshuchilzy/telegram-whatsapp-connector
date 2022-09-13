<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        return response()->json(['update'], 200);
    }

    public function inbox()
    {
        $messages = Message::all();
        return inertia()->render('Messages/MessageBox',[
            'messages' => $messages
        ]);
    }
}
