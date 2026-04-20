<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaptopController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LogAktifitasController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PeminjamController;

// Route Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route Register
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'register'])->middleware('guest');

// Unified dashboard redirect by role
Route::get('/dashboard', function () {
    $role = auth()->user()->role ?? null;
    if ($role === 'admin') {
        return redirect()->route('dashboard.admin');
    }
    if ($role === 'petugas') {
        return redirect()->route('petugas.dashboard');
    }
    if ($role === 'peminjam') {
        return redirect()->route('peminjam.dashboard');
    }

    return redirect('/login');
})->middleware('auth')->name('dashboard');

// Redirect root
Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard-admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::resource('user', UserController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('laptop', LaptopController::class);
    Route::resource('peminjaman', PeminjamanController::class);
    Route::get('pengembalian', [PeminjamanController::class, 'riwayat'])->name('pengembalian.index');
    Route::put('pengembalian/{id}/bayar-denda', [PeminjamanController::class, 'bayarDenda'])->name('pengembalian.bayar-denda');
    Route::get('log-aktifitas', [LogAktifitasController::class, 'index'])->name('log.index');
});

Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('petugas/dashboard', [PetugasController::class, 'dashboard'])->name('petugas.dashboard');
    Route::get('petugas/menu', [PetugasController::class, 'menu'])->name('petugas.menu');
    Route::get('petugas/persetujuan', [PetugasController::class, 'persetujuan'])->name('petugas.persetujuan');
    Route::put('petugas/persetujuan/{id}/setujui', [PetugasController::class, 'setujui'])->name('petugas.setujui');
    Route::put('petugas/persetujuan/{id}/menunggu', [PetugasController::class, 'tunda'])->name('petugas.tunda');
    Route::get('petugas/pengembalian', [PetugasController::class, 'pengembalian'])->name('petugas.pengembalian');
    Route::put('petugas/pengembalian/{id}/kembalikan', [PetugasController::class, 'kembalikan'])->name('petugas.kembalikan');
    Route::get('petugas/laporan', [PetugasController::class, 'laporan'])->name('petugas.laporan');
    Route::get('petugas/laporan/download', [PetugasController::class, 'downloadLaporan'])->name('petugas.laporan.download');
});

Route::middleware(['auth', 'role:peminjam'])->group(function () {
    Route::get('peminjam/dashboard', [PeminjamController::class, 'dashboard'])->name('peminjam.dashboard');
    Route::get('peminjam/menu', [PeminjamController::class, 'menu'])->name('peminjam.menu');
    Route::get('peminjam/alat', [PeminjamController::class, 'alat'])->name('peminjam.alat');
    Route::get('peminjam/pengembalian', [PeminjamController::class, 'pengembalian'])->name('peminjam.pengembalian');
    Route::put('peminjam/pengembalian/{id}', [PeminjamController::class, 'konfirmasiPengembalian'])->name('peminjam.pengembalian.konfirmasi');
    Route::get('peminjam/peminjaman', [PeminjamController::class, 'peminjaman'])->name('peminjam.peminjaman');
    Route::get('peminjam/ajukan', [PeminjamController::class, 'create'])->name('peminjam.ajukan');
    Route::post('peminjam/ajukan', [PeminjamController::class, 'store'])->name('peminjam.ajukan.store');
});
