<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public function settings()
    {
        $settings = setting();
        return inertia()->render('Telegram/Settings', [
            'appId' => setting('appId'),
            'appHash' => setting('appHash')
        ]);
    }

    public function storeSettings(Request $request)
    {
        $inputs['appId'] = $request->get('appId');
        $inputs['appHash'] = $request->get('appHash');
        foreach($inputs as $label => $setting){
            if(is_array($setting) or empty($setting)){continue;}
            setting()->set($label, $setting);
            setting()->save();
        }
        return redirect()->route('telegram.dashboard');
    }

    public function initClient()
    {
        return inertia()->render('Telegram/Dashboard', [
            'user' => auth()->user(),
            'appId' => setting('appId'),
            'appHash' => setting('appHash')
        ]);
    }

}
