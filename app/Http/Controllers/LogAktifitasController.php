<?php

namespace App\Http\Controllers;

use App\Models\LogAktifitas;

class LogAktifitasController extends Controller
{
    public function index()
    {
        $logs = LogAktifitas::with('user')
            ->latest('waktu')
            ->paginate(25);

        return view('log_aktifitas.index', compact('logs'));
    }
}
