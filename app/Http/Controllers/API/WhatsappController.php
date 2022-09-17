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
        Log::info($qrCode);
        Log::info('QR received');

        event(new WhatsappEvent($qrCode));
        return response()->json(['status' => 'success'], 200);
    }

    public function webhook(Request $request)
    {
        $type = $request->get('type');
        
    }
}
