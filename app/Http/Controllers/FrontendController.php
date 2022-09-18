<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function authenticateServers()
    {
        return inertia()->render('Servers/Auth');
    }

    public function authenticateIG()
    {
        
    }
}
