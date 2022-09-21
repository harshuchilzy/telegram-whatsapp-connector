<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class FrontendController extends Controller
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

    public function authenticateServers()
    {
        return inertia()->render('Servers/Auth');
    }

    public function authenticateIG()
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
        return $body;
    }

    public function userDetails()
    {
        $body = [
            // "identifier" => "harshanalaravel",
            "identifier" => setting('igUsername'),
            "password" => setting('igPassword')
            // "password" => "Elakiri123"
        ];
        $headers = $this->headers;
        $acoount_headers = $this->headers;
        $headers['VERSION'] = '3';

        $response = Http::withHeaders($headers)->post(setting('igPathUrl').'/session', $body);
        $body = $response->body();
        $body = json_decode($body);
        $accessToken = $body->oauthToken->access_token;
        $accounts = Http::withHeaders($acoount_headers)->withToken($accessToken)->get(setting('igPathUrl').'/accounts');
        $orders = Http::withHeaders($acoount_headers)->withToken($accessToken)->get(setting('igPathUrl').'/workingorders');
        $positions = Http::withHeaders($acoount_headers)->withToken($accessToken)->get(setting('igPathUrl').'/positions');
        // Log::info('Token ' . $accessToken);
        // print_r($orders->body());
        // return;
        return inertia()->render('Dashboard', [
            'accounts' => json_decode($accounts->body()),
            'orders' => json_decode($orders->body()),
            'positions' => json_decode($positions->body()),
        ]);
    }
    public function messages(){
        echo "dayz";
    }
}
