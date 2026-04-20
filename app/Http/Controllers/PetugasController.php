<?php

namespace App\Http\Controllers;

use App\Models\Laptop;
use App\Models\Peminjaman;
use App\Models\LogAktifitas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PetugasController extends Controller
{
    public function dashboard()
    {
        Peminjaman::syncOverdueStatuses();

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
        Peminjaman::syncOverdueStatuses();

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

        $peminjaman->update([
            'status' => 'dipinjam',
            'verified_at' => now(),
        ]);

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
        Peminjaman::syncOverdueStatuses();

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
        Peminjaman::syncOverdueStatuses();

        $validated = $request->validate([
            'kondisi_pengembalian' => 'required|in:baik,buruk',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status === 'dikembalikan') {
            return redirect()->back()->with('error', 'Peminjaman sudah dikembalikan.');
        }

        $returnedAt = now();
        $denda = $peminjaman->calculateDenda($returnedAt);

        $peminjaman->update([
            'tgl_kembali' => $returnedAt,
            'status' => 'dikembalikan',
            'denda' => $denda,
            'status_pembayaran_denda' => $denda > 0 ? 'belum_bayar' : null,
            'tgl_bayar_denda' => null,
            'kondisi_pengembalian' => $validated['kondisi_pengembalian'],
        ]);

        $laptop = Laptop::find($peminjaman->id_laptop);
        if ($laptop) {
            $laptop->increment('stok', (int) ($peminjaman->jumlah_pinjam ?? 1));
        }

        if (auth()->check()) {
            LogAktifitas::create([
                'id_user' => auth()->user()->id_user,
                'aksi_admin' => 'Mengonfirmasi pengembalian #' . $peminjaman->id_peminjaman . ' - ' . ($peminjaman->user->nama_lengkap ?? '-'),
                'waktu' => now(),
            ]);
        }

        return redirect()->back()->with('success', $denda > 0
            ? 'Status pengembalian diperbarui. Denda: Rp ' . number_format($denda, 0, ',', '.')
            : 'Status pengembalian diperbarui.');
    }

    public function laporan(Request $request)
    {
        Peminjaman::syncOverdueStatuses();

        $start = $request->query('start');
        $end = $request->query('end');
        $keyword = trim((string) $request->query('q', ''));

        $query = Peminjaman::with(['user', 'laptop'])->orderByDesc('tgl_pinjam');

        if ($start) {
            $query->whereDate('tgl_pinjam', '>=', $start);
        }
        if ($end) {
            $query->whereDate('tgl_pinjam', '<=', $end);
        }
        if ($keyword !== '') {
            $keywordLike = '%' . $keyword . '%';
            $query->where(function ($q) use ($keywordLike, $keyword) {
                $q->whereHas('laptop', function ($laptopQuery) use ($keywordLike) {
                    $laptopQuery->where('nama_laptop', 'like', $keywordLike);
                })->orWhereHas('user', function ($userQuery) use ($keywordLike) {
                    $userQuery->where('nama_lengkap', 'like', $keywordLike);
                })->orWhere('status', 'like', $keywordLike);

                // Jika user mengetik "laptop", tampilkan semua data alat laptop.
                if (str_contains(strtolower($keyword), 'laptop')) {
                    $q->orWhereHas('laptop', function ($laptopQuery) {
                        $laptopQuery->whereNotNull('id_laptop');
                    });
                }
            });
        }

        $totalFrekuensiPinjam = (clone $query)->count();
        $laporan = (clone $query)->limit(500)->get();
        $laporanPerAlat = (clone $query)
            ->get()
            ->groupBy('id_laptop')
            ->map(function ($rows) {
                $first = $rows->first();

                return [
                    'nama_alat' => $first?->laptop?->nama_laptop ?? '-',
                    'total_pinjam' => $rows->count(),
                    'tanggal_pinjam' => $rows->pluck('tgl_pinjam')
                        ->filter()
                        ->map(fn ($tgl) => Carbon::parse($tgl)->format('d M Y'))
                        ->unique()
                        ->values(),
                    'peminjam' => $rows->pluck('user.nama_lengkap')
                        ->filter()
                        ->unique()
                        ->values(),
                    'kondisi_baik' => $rows->where('kondisi_pengembalian', 'baik')->count(),
                    'kondisi_buruk' => $rows->where('kondisi_pengembalian', 'buruk')->count(),
                    'belum_dikembalikan' => $rows->whereIn('status', ['menunggu', 'dipinjam', 'terlambat'])->count(),
                ];
            })
            ->sortByDesc('total_pinjam')
            ->values();

        return view('petugas.laporan', compact('laporan', 'laporanPerAlat', 'start', 'end', 'keyword', 'totalFrekuensiPinjam'));
    }

    public function downloadLaporan(Request $request): StreamedResponse
    {
        Peminjaman::syncOverdueStatuses();

        $start = $request->query('start');
        $end = $request->query('end');
        $keyword = trim((string) $request->query('q', ''));

        $query = Peminjaman::with(['user', 'laptop'])->orderBy('tgl_pinjam');
        if ($start) {
            $query->whereDate('tgl_pinjam', '>=', $start);
        }
        if ($end) {
            $query->whereDate('tgl_pinjam', '<=', $end);
        }
        if ($keyword !== '') {
            $keywordLike = '%' . $keyword . '%';
            $query->where(function ($q) use ($keywordLike, $keyword) {
                $q->whereHas('laptop', function ($laptopQuery) use ($keywordLike) {
                    $laptopQuery->where('nama_laptop', 'like', $keywordLike);
                })->orWhereHas('user', function ($userQuery) use ($keywordLike) {
                    $userQuery->where('nama_lengkap', 'like', $keywordLike);
                })->orWhere('status', 'like', $keywordLike);

                if (str_contains(strtolower($keyword), 'laptop')) {
                    $q->orWhereHas('laptop', function ($laptopQuery) {
                        $laptopQuery->whereNotNull('id_laptop');
                    });
                }
            });
        }

        $rows = $query->get();

        $filename = 'laporan_peminjaman_' . ($start ?: 'all') . '_to_' . ($end ?: 'all') . '.csv';

        return response()->streamDownload(function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['No', 'Nama', 'Alat', 'Tgl Pinjam', 'Tgl Kembali', 'Status', 'Kondisi Pengembalian', 'Denda']);
            $no = 1;
            foreach ($rows as $row) {
                fputcsv($handle, [
                    $no++,
                    $row->user->nama_lengkap ?? '-',
                    $row->laptop->nama_laptop ?? '-',
                    $row->tgl_pinjam,
                    $row->tgl_kembali,
                    $row->status,
                    $row->kondisi_pengembalian ?? '-',
                    $row->denda ?? 0,
                ]);
            }
            fclose($handle);
        }, $filename);
    }
}
