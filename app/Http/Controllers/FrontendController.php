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
        // $account_headers = $this->headers;
        // $accessToken = $this->authenticateIG();
        // $accounts = Http::withHeaders($account_headers)->withToken($accessToken)->get(setting('igPathUrl').'/accounts');
        // $orders = Http::withHeaders($account_headers)->withToken($accessToken)->get(setting('igPathUrl').'/workingorders');
        // $positions = Http::withHeaders($account_headers)->withToken($accessToken)->get(setting('igPathUrl').'/positions');
        
        return inertia()->render('Dashboard');
    }

    public function fetchAccounts(Request $request)
    {
        $accessToken = $this->authenticateIG();
        $response = Http::withHeaders($this->headers)->withToken($accessToken)->get(setting('igPathUrl').'/accounts' );
        $accounts = json_decode($response->body());
        return response()->json($accounts);
    }

    public function fetchCurrentTrades($path){
        // $path = $request->input('path');
        $accessToken = $this->authenticateIG();
        $response = Http::withHeaders($this->headers)->withToken($accessToken)->get(setting('igPathUrl').'/' . $path);
        $data = json_decode($response->body());
        return response()->json($data);
    }
    
    public function messages(){
        $messages = Message::where('action', '!=', 'accepted')->where('action', '!=', 'unidentified')->orderBy('created_at', 'desc')->paginate(15);
        $accepted = Message::where('action', 'LIKE' , '%accepted%')->where('action', '!=', 'unidentified')->orderBy('created_at', 'desc')->paginate(15);
        $unidentified = Message::where('action', 'unidentified')->orderBy('created_at', 'desc')->paginate(15);

        return inertia()->render('Messages/Index', [
            'messages' => $messages,
            'accepted' => $accepted,
            'unidentified' => $unidentified
        ]);
        
    }

    public function history()
    {
        return inertia()->render('Account/History');
    }

    public function fetchHistory(Request $request)
    {
        $dates = $request->input('dates');
        $dates = implode('/', $dates);
        $accessToken = $this->authenticateIG();
        $history = Http::withHeaders($this->headers)->withToken($accessToken)->get(setting('igPathUrl').'/history/activity/' . $dates);
        return $history;
    }
}
