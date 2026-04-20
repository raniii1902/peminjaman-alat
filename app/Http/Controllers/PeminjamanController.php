<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Laptop;
use App\Models\LogAktifitas;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        Peminjaman::syncOverdueStatuses();

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
            'jumlah_pinjam' => 'nullable|integer|min:1',
        ]);

        $laptop = Laptop::findOrFail($request->id_laptop);
        $jumlahPinjam = (int) ($request->jumlah_pinjam ?? 1);

        if ($laptop->stok <= 0) {
            return back()->with('error', 'Stok alat tidak tersedia!');
        }
        if ($jumlahPinjam > (int) $laptop->stok) {
            return back()->with('error', 'Jumlah pinjam melebihi stok alat yang tersedia!')->withInput();
        }

        // Pengajuan baru langsung me-reserve stok agar tidak dipinjam ganda.
        $peminjaman = DB::transaction(function () use ($request, $laptop, $jumlahPinjam) {
            $peminjaman = Peminjaman::create([
                'id_user'     => auth()->user()->id_user,
                'id_laptop'   => $request->id_laptop,
                'jumlah_pinjam' => $jumlahPinjam,
                'tgl_pinjam'  => now(),
                'tgl_kembali' => null,
                'status'      => 'menunggu',
                'denda'       => 0,
            ]);

            $laptop->decrement('stok', $jumlahPinjam);

            return $peminjaman;
        });

        if (auth()->check()) {
            LogAktifitas::create([
                'id_user' => auth()->user()->id_user,
                'aksi_admin' => 'Membuat pengajuan peminjaman #' . $peminjaman->id_peminjaman . ' - ' . $laptop->nama_laptop,
                'waktu' => now(),
            ]);
        }

        return redirect()->route('peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil dibuat, stok alat dikurangi, dan sekarang menunggu persetujuan.');
    }

    public function update(Request $request, $id)
    {
        Peminjaman::syncOverdueStatuses();

        $peminjaman = Peminjaman::findOrFail($id);

        if (!in_array($peminjaman->status, ['dipinjam', 'terlambat'])) {
            return redirect()->route('peminjaman.index')
                ->with('error', 'Peminjaman belum disetujui untuk diproses pengembalian.');
        }

        $returnedAt = now();
        $denda = $peminjaman->calculateDenda($returnedAt);

        $peminjaman->update([
            'tgl_kembali' => $returnedAt,
            'status'      => 'dikembalikan',
            'denda'       => $denda,
            'status_pembayaran_denda' => $denda > 0 ? 'belum_bayar' : null,
            'tgl_bayar_denda' => null,
        ]);

        $laptop = Laptop::find($peminjaman->id_laptop);
        if ($laptop) {
            $laptop->increment('stok', (int) ($peminjaman->jumlah_pinjam ?? 1));
        }

        if (auth()->check()) {
            LogAktifitas::create([
                'id_user' => auth()->user()->id_user,
                'aksi_admin' => 'Mengembalikan peminjaman #' . $peminjaman->id_peminjaman,
                'waktu' => now(),
            ]);
        }

        return redirect()->route('peminjaman.index')
            ->with('success', $denda > 0
                ? 'Alat berhasil dikembalikan dengan denda Rp ' . number_format($denda, 0, ',', '.')
                : 'Alat berhasil dikembalikan!');
    }

    public function riwayat()
    {
        Peminjaman::syncOverdueStatuses();

        $totalDenda = Peminjaman::where('status', 'dikembalikan')
            ->where('denda', '>', 0)
            ->sum('denda');

        $pengembalian = Peminjaman::with(['user', 'laptop'])
            ->where('status', 'dikembalikan')
            ->latest('tgl_kembali')
            ->paginate(20);

        return view('pengembalian.riwayat', compact('pengembalian', 'totalDenda'));
    }

    public function bayarDenda($id)
    {
        $peminjaman = Peminjaman::with('user')->findOrFail($id);

        if ($peminjaman->status !== 'dikembalikan') {
            return redirect()->route('pengembalian.index')
                ->with('error', 'Denda hanya bisa dibayar untuk alat yang sudah dikembalikan.');
        }

        if ($peminjaman->isDendaLunas()) {
            return redirect()->route('pengembalian.index')
                ->with('success', 'Denda untuk peminjam tersebut sudah lunas.');
        }

        if (!$peminjaman->hasDenda()) {
            return redirect()->route('pengembalian.index')
                ->with('error', 'Peminjaman ini tidak memiliki denda.');
        }

        $peminjaman->update([
            'denda' => 0,
            'status_pembayaran_denda' => 'lunas',
            'tgl_bayar_denda' => now(),
        ]);

        if (auth()->check()) {
            LogAktifitas::create([
                'id_user' => auth()->user()->id_user,
                'aksi_admin' => 'Mencatat pembayaran denda peminjaman #' . $peminjaman->id_peminjaman . ' untuk ' . ($peminjaman->user->nama_lengkap ?? '-'),
                'waktu' => now(),
            ]);
        }

        return redirect()->route('pengembalian.index')
            ->with('success', 'Pembayaran denda langsung dicatat untuk peminjam ' . ($peminjaman->user->nama_lengkap ?? '-') . '.');
    }

    public function show($id)
    {
        Peminjaman::syncOverdueStatuses();

        $peminjaman = Peminjaman::with(['user', 'laptop'])->findOrFail($id);
        return view('peminjaman.show', compact('peminjaman'));
    }
}
