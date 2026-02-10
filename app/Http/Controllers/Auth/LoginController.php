<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username tidak boleh kosong!',
            'password.required' => 'Password tidak boleh kosong!',
        ]);

        // Cari user berdasarkan username
        $user = User::where('username', $request->username)->first();

        // Debug: Cek apakah user ditemukan
        if (!$user) {
            return back()->withErrors([
                'login' => 'Username tidak ditemukan!',
            ])->withInput($request->only('username'));
        }

        // Debug: Cek password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'login' => 'Password salah!',
            ])->withInput($request->only('username'));
        }

        // Login manual
        Auth::login($user);
        $request->session()->regenerate();

        // Redirect ke dashboard
        return redirect()->intended('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}