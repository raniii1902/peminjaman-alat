<?php

namespace App\Http\Controllers;

use App\Models\Laptop;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamController extends Controller
{
    public function dashboard()
    {
        Peminjaman::syncOverdueStatuses();

        $userId = auth()->user()->id_user;

        $totalMenunggu = Peminjaman::where('id_user', $userId)->where('status', 'menunggu')->count();
        $totalDipinjam = Peminjaman::where('id_user', $userId)->whereIn('status', ['dipinjam', 'terlambat'])->count();
        $totalTerlambat = Peminjaman::where('id_user', $userId)->where('status', 'terlambat')->count();
        $totalDikembalikan = Peminjaman::where('id_user', $userId)->where('status', 'dikembalikan')->count();

        return view('peminjam.dashboard', compact(
            'totalMenunggu',
            'totalDipinjam',
            'totalTerlambat',
            'totalDikembalikan'
        ));
    }

    public function menu()
    {
        return redirect()->route('peminjam.dashboard');
    }

    public function peminjaman()
    {
        Peminjaman::syncOverdueStatuses();

        $peminjaman = Peminjaman::with('laptop')
            ->where('id_user', auth()->user()->id_user)
            ->latest()
            ->get();

        return view('peminjam.peminjaman', compact('peminjaman'));
    }

    public function alat()
    {
        $laptop = Laptop::with('kategori')
            ->orderBy('nama_laptop')
            ->get();
        return view('peminjam.alat', compact('laptop'));
    }

    public function pengembalian()
    {
        Peminjaman::syncOverdueStatuses();

        $aktif = Peminjaman::with('laptop')
            ->where('id_user', auth()->user()->id_user)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->latest()
            ->get();

        $riwayat = Peminjaman::with('laptop')
            ->where('id_user', auth()->user()->id_user)
            ->where('status', 'dikembalikan')
            ->latest('tgl_kembali')
            ->limit(50)
            ->get();

        return view('peminjam.pengembalian', compact('aktif', 'riwayat'));
    }

    public function create()
    {
        $laptop = Laptop::where('stok', '>', 0)
            ->orderBy('nama_laptop')
            ->get();
        return view('peminjam.ajukan', compact('laptop'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_laptop' => 'required|exists:laptop,id_laptop',
            'tgl_pinjam' => 'required|date',
        ]);

        $laptop = Laptop::findOrFail($request->id_laptop);
        if ($laptop->stok <= 0) {
            return back()->with('error', 'Stok alat tidak tersedia!');
        }

        DB::transaction(function () use ($request, $laptop) {
            Peminjaman::create([
                'id_user' => auth()->user()->id_user,
                'id_laptop' => $request->id_laptop,
                'tgl_pinjam' => $request->tgl_pinjam,
                'tgl_kembali' => null,
                'status' => 'menunggu',
                'denda' => 0,
            ]);

            $laptop->decrement('stok');
        });

        return redirect()->route('peminjam.peminjaman')
            ->with('success', 'Pengajuan berhasil dikirim, stok alat dikurangi, dan sekarang menunggu persetujuan petugas.');
    }

    public function konfirmasiPengembalian(Request $request, $id)
    {
        Peminjaman::syncOverdueStatuses();

        $peminjaman = Peminjaman::where('id_user', auth()->user()->id_user)->findOrFail($id);

        if ($peminjaman->status === 'dikembalikan') {
            return back()->with('error', 'Peminjaman sudah dikembalikan.');
        }

        $returnedAt = now();
        $denda = $peminjaman->calculateDenda($returnedAt);

        $peminjaman->update([
            'tgl_kembali' => $returnedAt,
            'status' => 'dikembalikan',
            'denda' => $denda,
        ]);

        $laptop = Laptop::find($peminjaman->id_laptop);
        if ($laptop) {
            $laptop->increment('stok');
        }

        return back()->with('success', $denda > 0
            ? 'Pengembalian berhasil dikonfirmasi. Denda: Rp ' . number_format($denda, 0, ',', '.')
            : 'Pengembalian berhasil dikonfirmasi.');
    }
}
