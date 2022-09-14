<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        $user = request()->user();
        return inertia()->render('User/Profile', [
            'user' => $user
        ]);
    }

    public function authSessionKeys(Request $request)
    {
        $inputs = $request->all();

        $user = auth()->user();
        $user->telegram_session = $inputs['session'];
        $user->save();
        return response()->json(['status' => 'Session stored '], 200);
    }
}
