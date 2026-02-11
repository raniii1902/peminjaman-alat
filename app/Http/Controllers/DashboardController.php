<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Laptop;
use App\Models\LogAktifitas;
use App\Models\Peminjaman;
use App\Models\User;

class DashboardController extends Controller
{
    public function admin()
    {
        $stats = [
            'totalUser' => User::count(),
            'totalKategori' => Kategori::count(),
            'totalLaptop' => Laptop::count(),
            'totalPeminjaman' => Peminjaman::count(),
            'totalPengembalian' => Peminjaman::where('status', 'dikembalikan')->count(),
        ];

        $recentLogs = LogAktifitas::with('user')
            ->latest('waktu')
            ->limit(5)
            ->get();

        return view('dashboard_admin', compact('stats', 'recentLogs'));
    }

    public function index()
    {
        return view('dashboard');
    }
}
