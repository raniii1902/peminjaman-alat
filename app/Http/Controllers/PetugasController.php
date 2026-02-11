<?php

namespace App\Http\Controllers;

use App\Models\Laptop;
use App\Models\Peminjaman;
use App\Models\LogAktifitas;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PetugasController extends Controller
{
    public function dashboard()
    {
        $totalMenunggu = Peminjaman::where('status', 'menunggu')->count();
        $totalDipinjam = Peminjaman::whereIn('status', ['dipinjam', 'terlambat'])->count();
        $totalTerlambat = Peminjaman::where('status', 'terlambat')->count();
        $totalDikembalikan = Peminjaman::where('status', 'dikembalikan')->count();

        return view('petugas.dashboard', compact(
            'totalMenunggu',
            'totalDipinjam',
            'totalTerlambat',
            'totalDikembalikan'
        ));
    }

    public function menu()
    {
        return view('petugas.menu');
    }

    public function persetujuan()
    {
        $menunggu = Peminjaman::with(['user', 'laptop'])
            ->where('status', 'menunggu')
            ->latest()
            ->get();

        $belumKembali = Peminjaman::with(['user', 'laptop'])
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->latest()
            ->get();

        return view('petugas.persetujuan', compact('menunggu', 'belumKembali'));
    }

    public function setujui(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
            return redirect()->route('petugas.persetujuan')
                ->with('error', 'Status peminjaman sudah diproses.');
        }

        $laptop = Laptop::findOrFail($peminjaman->id_laptop);
        if ($laptop->stok <= 0) {
            return redirect()->route('petugas.persetujuan')
                ->with('error', 'Stok laptop tidak tersedia.');
        }

        $peminjaman->update([
            'status' => 'dipinjam',
        ]);

        $laptop->decrement('stok');

        if (auth()->check()) {
            LogAktifitas::create([
                'id_user' => auth()->user()->id_user,
                'aksi_admin' => 'Menyetujui peminjaman #' . $peminjaman->id_peminjaman . ' - ' . ($peminjaman->user->nama_lengkap ?? '-') . ' (' . $laptop->nama_laptop . ')',
                'waktu' => now(),
            ]);
        }

        return redirect()->route('petugas.persetujuan')
            ->with('success', 'Peminjaman disetujui.');
    }

    public function tunda(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
            return redirect()->route('petugas.persetujuan')
                ->with('error', 'Status peminjaman sudah diproses.');
        }

        // Tetap pada status menunggu (tidak mengubah stok).
        $peminjaman->update([
            'status' => 'menunggu',
        ]);

        if (auth()->check()) {
            LogAktifitas::create([
                'id_user' => auth()->user()->id_user,
                'aksi_admin' => 'Menunda persetujuan peminjaman #' . $peminjaman->id_peminjaman . ' - ' . ($peminjaman->user->nama_lengkap ?? '-'),
                'waktu' => now(),
            ]);
        }

        return redirect()->route('petugas.persetujuan')
            ->with('success', 'Pengajuan tetap berstatus menunggu.');
    }

    public function pengembalian()
    {
        $belumKembali = Peminjaman::with(['user', 'laptop'])
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->latest()
            ->get();

        $sudahKembali = Peminjaman::with(['user', 'laptop'])
            ->where('status', 'dikembalikan')
            ->latest('tgl_kembali')
            ->limit(50)
            ->get();

        return view('petugas.pengembalian', compact('belumKembali', 'sudahKembali'));
    }

    public function kembalikan(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status === 'dikembalikan') {
            return redirect()->back()->with('error', 'Peminjaman sudah dikembalikan.');
        }

        $peminjaman->update([
            'tgl_kembali' => now(),
            'status' => 'dikembalikan',
            'denda' => 0,
        ]);

        $laptop = Laptop::find($peminjaman->id_laptop);
        if ($laptop) {
            $laptop->increment('stok');
        }

        if (auth()->check()) {
            LogAktifitas::create([
                'id_user' => auth()->user()->id_user,
                'aksi_admin' => 'Mengonfirmasi pengembalian #' . $peminjaman->id_peminjaman . ' - ' . ($peminjaman->user->nama_lengkap ?? '-'),
                'waktu' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Status pengembalian diperbarui.');
    }

    public function laporan(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $query = Peminjaman::with(['user', 'laptop'])->orderByDesc('tgl_pinjam');

        if ($start) {
            $query->whereDate('tgl_pinjam', '>=', $start);
        }
        if ($end) {
            $query->whereDate('tgl_pinjam', '<=', $end);
        }

        $laporan = $query->limit(200)->get();

        return view('petugas.laporan', compact('laporan', 'start', 'end'));
    }

    public function downloadLaporan(Request $request): StreamedResponse
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $query = Peminjaman::with(['user', 'laptop'])->orderBy('tgl_pinjam');
        if ($start) {
            $query->whereDate('tgl_pinjam', '>=', $start);
        }
        if ($end) {
            $query->whereDate('tgl_pinjam', '<=', $end);
        }

        $rows = $query->get();

        $filename = 'laporan_peminjaman_' . ($start ?: 'all') . '_to_' . ($end ?: 'all') . '.csv';

        return response()->streamDownload(function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['No', 'Nama', 'Laptop', 'Tgl Pinjam', 'Tgl Kembali', 'Status', 'Denda']);
            $no = 1;
            foreach ($rows as $row) {
                fputcsv($handle, [
                    $no++,
                    $row->user->nama_lengkap ?? '-',
                    $row->laptop->nama_laptop ?? '-',
                    $row->tgl_pinjam,
                    $row->tgl_kembali,
                    $row->status,
                    $row->denda ?? 0,
                ]);
            }
            fclose($handle);
        }, $filename);
    }
}
