<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role ?? null;

        if (!$userRole || !in_array($userRole, $roles, true)) {
            if ($userRole === 'admin' && Route::has('dashboard.admin')) {
                return redirect()->route('dashboard.admin');
            }
            if ($userRole === 'petugas' && Route::has('petugas.dashboard')) {
                return redirect()->route('petugas.dashboard');
            }
            if ($userRole === 'peminjam' && Route::has('peminjam.dashboard')) {
                return redirect()->route('peminjam.dashboard');
            }

            abort(403);
        }

        return $next($request);
    }
}
