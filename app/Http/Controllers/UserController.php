<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        $user = request()->user();
        return inertia()->render('User/Profile');
    }
}
