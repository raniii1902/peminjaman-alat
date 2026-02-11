<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Laptop;
use App\Models\LogAktifitas;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with(['user', 'laptop'])
            ->whereIn('status', ['menunggu', 'dipinjam', 'terlambat'])
            ->latest()
            ->get();

        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $laptop = Laptop::where('stok', '>', 0)->get();
        return view('peminjaman.create', compact('laptop'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_laptop' => 'required|exists:laptop,id_laptop',
        ]);

        $laptop = Laptop::findOrFail($request->id_laptop);

        if ($laptop->stok <= 0) {
            return back()->with('error', 'Stok laptop tidak tersedia!');
        }

        // Simpan data sebagai pengajuan yang menunggu persetujuan petugas.
        $peminjaman = Peminjaman::create([
            'id_user'     => auth()->user()->id_user,
            'id_laptop'   => $request->id_laptop,
            'tgl_pinjam'  => now(),
            'tgl_kembali' => null,
            'status'      => 'menunggu',
            'denda'       => 0,
        ]);

        if (auth()->check()) {
            LogAktifitas::create([
                'id_user' => auth()->user()->id_user,
                'aksi_admin' => 'Membuat pengajuan peminjaman #' . $peminjaman->id_peminjaman . ' - ' . $laptop->nama_laptop,
                'waktu' => now(),
            ]);
        }

        return redirect()->route('peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil dibuat dan menunggu persetujuan.');
    }

    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if (!in_array($peminjaman->status, ['dipinjam', 'terlambat'])) {
            return redirect()->route('peminjaman.index')
                ->with('error', 'Peminjaman belum disetujui untuk diproses pengembalian.');
        }

        $peminjaman->update([
            'tgl_kembali' => now(),
            'status'      => 'dikembalikan',
            'denda'       => 0,
        ]);

        $laptop = Laptop::find($peminjaman->id_laptop);
        if ($laptop) {
            $laptop->increment('stok');
        }

        if (auth()->check()) {
            LogAktifitas::create([
                'id_user' => auth()->user()->id_user,
                'aksi_admin' => 'Mengembalikan peminjaman #' . $peminjaman->id_peminjaman,
                'waktu' => now(),
            ]);
        }

        return redirect()->route('peminjaman.index')
            ->with('success', 'Laptop berhasil dikembalikan!');
    }

    public function riwayat()
    {
        $pengembalian = Peminjaman::with(['user', 'laptop'])
            ->where('status', 'dikembalikan')
            ->latest('tgl_kembali')
            ->paginate(20);

        return view('pengembalian.riwayat', compact('pengembalian'));
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with(['user', 'laptop'])->findOrFail($id);
        return view('peminjaman.show', compact('peminjaman'));
    }
}
