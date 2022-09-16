<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Events\WhatsappEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsappController extends Controller
{
    public function receiveQR(Request $request)
    {   
        $qrCode = $request->get('qr');
        event(new WhatsappEvent($qrCode));
        return response()->json(['status' => 'success'], 200);
    }
}
