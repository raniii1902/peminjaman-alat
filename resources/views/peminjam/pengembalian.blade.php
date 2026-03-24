@extends('layouts.peminjam')

@section('title', 'Pengembalian')

@section('styles')
<style>
    .return-page { max-width: 1200px; display: grid; gap: 18px; }
    .hero {
        background: linear-gradient(140deg, #1e3a8a 0%, #0f172a 100%);
        border-radius: 18px;
        padding: 22px;
        color: #f8fafc;
        box-shadow: 0 16px 34px rgba(15, 23, 42, 0.2);
    }
    .hero h2 { margin: 0 0 6px 0; font-size: 26px; font-weight: 800; }
    .hero p { margin: 0; color: #cbd5e1; font-size: 14px; line-height: 1.6; }
    .alert { border-radius: 12px; padding: 12px 14px; font-size: 13px; font-weight: 600; }
    .alert-success { background: #dcfce7; border: 1px solid #86efac; color: #166534; }
    .alert-error { background: #fee2e2; border: 1px solid #fecaca; color: #991b1b; }
    .section-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }
    .section-head {
        padding: 14px 16px;
        border-bottom: 1px solid #e2e8f0;
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        background: #f8fafc;
    }
    .table-wrap { overflow-x: auto; }
    .data-table { width: 100%; min-width: 900px; border-collapse: collapse; }
    .data-table thead { background: #6C63FF; color: #fff; }
    .data-table th, .data-table td {
        padding: 14px 16px;
        text-align: left;
        font-size: 14px;
        border-bottom: 1px solid #e2e8f0;
    }
    .data-table tbody tr:hover { background: #f8fafc; }
    .laptop-text { font-weight: 700; color: #0f172a; }
    .date-badge, .status-badge, .fine-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 6px 10px;
        font-size: 12px;
        font-weight: 700;
    }
    .date-badge { background: #f1f5f9; color: #334155; }
    .status-menunggu { background: #e0f2fe; color: #0c4a6e; }
    .status-dipinjam { background: #fef3c7; color: #b45309; }
    .status-terlambat { background: #fee2e2; color: #b91c1c; }
    .status-dikembalikan { background: #dcfce7; color: #166534; }
    .fine-badge { background: #fef3c7; color: #92400e; }
    .btn-return {
        border: none;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #dbeafe;
        color: #1d4ed8;
    }
    .empty-state {
        padding: 20px;
        text-align: center;
        color: #64748b;
        background: #f8fafc;
        font-size: 14px;
    }
</style>
@endsection

@section('content')
<div class="return-page">
    <section class="hero">
        <h2>Pengembalian</h2>
        <p>Konfirmasi pengembalian pinjaman aktif dan lihat riwayat pengembalian Anda. Batas pinjam 7 hari, denda keterlambatan Rp 5.000 per hari.</p>
    </section>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <section class="section-card">
        <div class="section-head">Peminjaman Aktif</div>
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Alat</th>
                        <th>Tgl Pinjam</th>
                        <th>Status</th>
                        <th>Estimasi Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aktif as $no => $p)
                    <tr>
                        <td>{{ $no + 1 }}</td>
                        <td class="laptop-text">{{ $p->laptop->nama_laptop ?? '-' }}</td>
                        <td>
                            <span class="date-badge">
                                <i class="fas fa-calendar-day"></i>
                                {{ $p->tgl_pinjam ? \Carbon\Carbon::parse($p->tgl_pinjam)->format('d M Y') : '-' }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge status-{{ $p->status }}">
                                <i class="fas fa-circle-info"></i> {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td>
                            <span class="fine-badge">
                                <i class="fas fa-money-bill-wave"></i>
                                Rp {{ number_format($p->calculateDenda(), 0, ',', '.') }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('peminjam.pengembalian.konfirmasi', $p->id_peminjaman) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn-return">
                                    <i class="fas fa-rotate-left"></i> Konfirmasi Pengembalian
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-state">Tidak ada peminjaman aktif.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="section-card">
        <div class="section-head">Riwayat Pengembalian</div>
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Alat</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $no => $p)
                    <tr>
                        <td>{{ $no + 1 }}</td>
                        <td class="laptop-text">{{ $p->laptop->nama_laptop ?? '-' }}</td>
                        <td>
                            <span class="date-badge">
                                <i class="fas fa-calendar-day"></i>
                                {{ $p->tgl_pinjam ? \Carbon\Carbon::parse($p->tgl_pinjam)->format('d M Y') : '-' }}
                            </span>
                        </td>
                        <td>
                            <span class="date-badge">
                                <i class="fas fa-clock"></i>
                                {{ $p->tgl_kembali ? \Carbon\Carbon::parse($p->tgl_kembali)->format('d M Y, H:i') : '-' }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge status-{{ $p->status }}">
                                <i class="fas fa-circle-check"></i> {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td>
                            <span class="fine-badge">
                                <i class="fas fa-money-bill-wave"></i>
                                Rp {{ number_format($p->denda ?? 0, 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-state">Belum ada data pengembalian.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
