<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username tidak boleh kosong!',
            'password.required' => 'Password tidak boleh kosong!',
        ]);

        if (Auth::attempt(
            ['username' => $credentials['username'], 'password' => $credentials['password']],
            $request->filled('remember')
        )) {
            $request->session()->regenerate();
            $role = auth()->user()->role ?? null;
            if ($role === 'admin') {
                return redirect()->intended(route('dashboard.admin'));
            }
            if ($role === 'petugas') {
                return redirect()->intended(route('petugas.dashboard'));
            }
            if ($role === 'peminjam') {
                return redirect()->intended(route('peminjam.dashboard'));
            }

            return redirect()->intended('/login');
        }

        return back()->withErrors([
            'username' => 'Username atau Password salah!',
        ])->withInput($request->only('username'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
