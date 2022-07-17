<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        checking_role_session($this->session, $request->session()->has('roles'));
        
        $data = [
            'title' => "Login"
        ];

        return view('login', $data);
    }

    public function check(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // untuk check users
        $checking = [
            'username' => $username,
            'password' => $password,
            'active'   => 'y'
        ];

        if (Auth::attempt($checking)) {
            // untuk data users
            $users = Auth::user();

            // untuk mengaktifkan session
            $request->session()->put('id', $users->id);
            $request->session()->put('id_users', $users->id_users);
            $request->session()->put('nama', $users->nama);
            $request->session()->put('roles', $users->roles);
            $request->session()->put('foto', $users->foto);

            // untuk check role
            if ($users->roles === 'admin') {
                return redirect()->intended('admin');
            } else if ($users->roles === 'operator') {
                return redirect()->intended('operator');
            } else {
                return redirect()->intended('/');
            }
        } else {
            return redirect()->intended('/');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect()->intended('/');
    }
}