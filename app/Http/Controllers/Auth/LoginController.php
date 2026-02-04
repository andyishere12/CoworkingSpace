<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function handleLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password harus diisi',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Tambahkan logika pengecekan role di sini
            if (auth::user()->role === 'manager') {
                return redirect()->intended('/manager/dashboard');
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang anda masukan salah',
        ])->onlyinput('email');
    }
}
