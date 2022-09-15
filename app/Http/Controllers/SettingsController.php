<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return inertia()->render('Settings/Settings');
    }
    public function store(Request $request)
    {
        return $request->all();
    }
}
