<?php

namespace App\Http\Controllers;
use App\Models\Message;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class FrontendController extends Controller
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

    public function authenticateServers()
    {
        return inertia()->render('Servers/Auth');
    }

    public function authenticateIG()
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

    public function dashboard()
    {
        if(empty(setting('igPathUrl')) and empty(setting('igUsername')) and empty(setting('igPassword')) and empty(setting('igApiKey'))){
            return redirect()->route('settings');
        }
        $acoount_headers = $this->headers;
        $accessToken = $this->authenticateIG();
        $accounts = Http::withHeaders($acoount_headers)->withToken($accessToken)->get(setting('igPathUrl').'/accounts');
        $orders = Http::withHeaders($acoount_headers)->withToken($accessToken)->get(setting('igPathUrl').'/workingorders');
        $positions = Http::withHeaders($acoount_headers)->withToken($accessToken)->get(setting('igPathUrl').'/positions');
        
        return inertia()->render('Dashboard', [
            'accounts' => json_decode($accounts->body()),
            'orders' => json_decode($orders->body()),
            'positions' => json_decode($positions->body()),
        ]);
    }
    
    public function messages(){
        $messages = Message::where('action', 'rejected')->get();
        $accepted = Message::where('action', '!=', 'rejected')->get();
        return inertia()->render('Messages/Index', [
            'messages' => $messages,
            'accepted' => $accepted,
        ]);
        
    }
}
