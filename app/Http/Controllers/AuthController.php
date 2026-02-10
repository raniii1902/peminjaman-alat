<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login (pakai role)
    public function login(Request $request)
    {
        // 🔹 Ambil hanya username & password
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            // 🔹 Regenerate session untuk keamanan
            $request->session()->regenerate();

            // 🔥 CEK ROLE
            if (Auth::user()->role == 'admin') {
                return redirect('/dashboard-admin');
            }

            return redirect('/dashboard'); // selain admin
        }

        return back()->with('error', 'Username atau password salah');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
