<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


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
    public function update(Request $request, User $user)
    {
        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }
        if(!empty($request->name)){
            $user->name = $request->name;
        }
        if(!empty($request->email)){
            $user->email = $request->email;
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users'.$user->id,
            'password_confirm' => ['same:password']
        ]);
        $user = User::find($request->id);
        // $user->update(([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]));
        $user->save();
        
        return redirect()->route('user.profile')->with('success', 'User updated!');
    }
}
