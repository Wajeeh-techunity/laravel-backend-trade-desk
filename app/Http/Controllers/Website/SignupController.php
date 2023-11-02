<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class SignupController extends Controller
{
    public function signup(Request $request)
    {

//        dd($request->all());
        $request->validate([
            'name' => 'required',
            'email'=>'required|unique:users',
            'password' => 'required|min:8|confirmed',
            'g-recaptcha-response' => 'required|captcha',
        ]);
//        dd(json_encode($request->permissions));
//        dd($request->all());

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
        ]);

        return back()->with('success-mesg', 'User Created Successfully!');
    }
}
