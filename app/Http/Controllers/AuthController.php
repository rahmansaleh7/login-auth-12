<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email|max:50',
            'password' => 'required|max:255',
        ]);
        if(Auth::attempt($request->only('email', 'password'),$request->remember)){
            if(Auth::user()->role == 'customer') return redirect('/customer');
            return redirect('/dashboard');
        }
        return back()->with('failed','Email atau password salah');
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:50',
            'password' => 'required|min:6|max:255',
            'confirm_password' => 'required|same:password',
        ]);

        $request['status'] = "active";
        $user = User::create($request->all());
        User::create(data);
        return redirect('/customer');
    }

    public function logout(){
        Auth::logout(Auth::user());
        return redirect('/login');
    }
}
