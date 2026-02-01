<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function prosesRegister(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name'     => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success','Register berhasil');
    }

    public function prosesLogin(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (auth()->attempt($credentials)) {
        $request->session()->regenerate();

        // Redirect berdasarkan role
        if(auth()->user()->role === 'admin') {
            return redirect('/dashboard');
        }

        return redirect('/'); // user biasa ke home
    }

    return back()->withErrors([
        'email' => 'Email atau password salah',
    ]);
}

public function logout(Request $request)
{
    auth()->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
}
}
