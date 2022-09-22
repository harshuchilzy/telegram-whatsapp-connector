<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function settings(){
        $settings = setting()->all();
        return inertia()->render('Settings/Settings', [
            'settings' => $settings
        ]);
    }

    public function store(Request $request){
        $inputs = $request->all();
        unset( $inputs['isDirty']);
        unset( $inputs['__rememberable']);
        foreach($inputs as $label => $setting){
            if(is_array($setting) or empty($setting)){continue;}
            setting()->set($label, $setting);
            setting()->save();
        }
        return redirect()->route('settings')->with('success', 'Settings updated!');
    }
}
