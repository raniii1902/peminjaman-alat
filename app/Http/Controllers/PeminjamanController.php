<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Laptop;

class PengembalianController extends Controller
{
    /**
     * Tampilkan daftar peminjaman yang belum dikembalikan
     */
    public function index()
    {
        $peminjaman = Peminjaman::with(['user', 'laptop'])
            ->where('status', 'dipinjam')
            ->orWhere('status', 'terlambat')
            ->latest()
            ->get();
            
        return view('pengembalian.index', compact('peminjaman'));
    }

    /**
     * Proses pengembalian laptop
     */
    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'kondisi' => 'required|in:baik,rusak',
            'keterangan' => 'nullable|string',
        ]);

        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);
        
        // Update status peminjaman
        $peminjaman->update([
            'tanggal_kembali' => now(),
            'status' => 'dikembalikan',
            'kondisi_kembali' => $request->kondisi,
            'keterangan' => $request->keterangan,
        ]);

        // Update stok laptop (tambah 1)
        $laptop = Laptop::find($peminjaman->laptop_id);
        $laptop->increment('stok');

        return redirect()->route('pengembalian.index')
            ->with('success', 'Laptop berhasil dikembalikan!');
    }

    /**
     * Tampilkan detail peminjaman untuk dikembalikan
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['user', 'laptop'])->findOrFail($id);
        
        // Hitung denda jika terlambat
        $tanggal_harus_kembali = $peminjaman->tanggal_harus_kembali;
        $hari_terlambat = now()->diffInDays($tanggal_harus_kembali, false);
        
        $denda = 0;
        if ($hari_terlambat < 0) {
            $denda = abs($hari_terlambat) * 5000; // Rp 5.000 per hari
        }
        
        return view('pengembalian.show', compact('peminjaman', 'denda', 'hari_terlambat'));
    }

    /**
     * Riwayat pengembalian
     */
    public function riwayat()
    {
        $pengembalian = Peminjaman::with(['user', 'laptop'])
            ->where('status', 'dikembalikan')
            ->latest('tanggal_kembali')
            ->paginate(20);
            
        return view('pengembalian.riwayat', compact('pengembalian'));
    }

    /**
     * Cetak bukti pengembalian
     */
    public function cetak($id)
    {
        $peminjaman = Peminjaman::with(['user', 'laptop'])->findOrFail($id);
        
        return view('pengembalian.cetak', compact('peminjaman'));
    }
}