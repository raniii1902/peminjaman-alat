@extends('layouts.petugas')

@section('title', 'Laporan Peminjaman')

@section('styles')
<style>
    .report-page { max-width: 1200px; display: grid; gap: 18px; }
    .hero {
        background: linear-gradient(140deg, #1e3a8a 0%, #0f172a 100%);
        border-radius: 18px;
        padding: 22px;
        color: #f8fafc;
        box-shadow: 0 16px 34px rgba(15, 23, 42, 0.2);
    }
    .hero h2 { margin: 0 0 6px 0; font-size: 26px; font-weight: 800; }
    .hero p { margin: 0; color: #cbd5e1; font-size: 14px; line-height: 1.6; }
    .filter-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        padding: 16px;
    }
    .filter-form {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: flex-end;
    }
    .field { display: grid; gap: 6px; min-width: 180px; }
    .field label {
        font-size: 12px;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .35px;
    }
    .field input {
        border: 1px solid #dbe3f0;
        background: #f8fafc;
        border-radius: 10px;
        padding: 9px 10px;
        font-size: 13px;
        color: #0f172a;
        outline: none;
    }
    .field input:focus {
        border-color: #6366f1;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12);
    }
    .btns { display: flex; gap: 8px; flex-wrap: wrap; }
    .btn {
        border: none;
        border-radius: 10px;
        padding: 9px 12px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-show { background: #4f46e5; color: #fff; }
    .btn-download { background: #dcfce7; color: #166534; }
    .btn-print { background: #fef3c7; color: #b45309; }
    .table-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }
    .table-wrap { overflow-x: auto; }
    .data-table { width: 100%; min-width: 980px; border-collapse: collapse; }
    .data-table thead { background: #6C63FF; color: #fff; }
    .data-table th, .data-table td {
        padding: 14px 16px;
        text-align: left;
        font-size: 14px;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: top;
    }
    .data-table tbody tr:hover { background: #f8fafc; }
    .user-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        background: #eef2ff;
        color: #3730a3;
        padding: 5px 10px;
        font-weight: 700;
        font-size: 12px;
    }
    .laptop-text { font-weight: 700; color: #0f172a; }
    .date-badge, .fine-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        background: #f1f5f9;
        color: #334155;
        padding: 5px 10px;
        font-weight: 600;
        font-size: 12px;
    }
    .fine-badge {
        background: #fef3c7;
        color: #92400e;
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
    }
    .status-menunggu { background: #e0f2fe; color: #0c4a6e; }
    .status-dipinjam { background: #fef3c7; color: #b45309; }
    .status-terlambat { background: #fee2e2; color: #b91c1c; }
    .status-dikembalikan { background: #dcfce7; color: #166534; }
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
<div class="report-page">
    <section class="hero">
        <h2>Laporan Peminjaman</h2>
        <p>Filter data berdasarkan periode, kemudian tampilkan, unduh CSV, atau cetak laporan.</p>
    </section>

    <section class="filter-card">
        <form method="GET" action="{{ route('petugas.laporan') }}" class="filter-form">
            <div class="field">
                <label>Periode Mulai</label>
                <input type="date" name="start" value="{{ $start }}">
            </div>
            <div class="field">
                <label>Periode Akhir</label>
                <input type="date" name="end" value="{{ $end }}">
            </div>
            <div class="btns">
                <button type="submit" class="btn btn-show"><i class="fas fa-filter"></i> Tampilkan</button>
                <a href="{{ route('petugas.laporan.download', ['start' => $start, 'end' => $end]) }}" class="btn btn-download">
                    <i class="fas fa-file-csv"></i> Unduh CSV
                </a>
                <button type="button" onclick="window.print()" class="btn btn-print">
                    <i class="fas fa-print"></i> Cetak
                </button>
            </div>
        </form>
    </section>

    <section class="table-card">
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alat</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $no => $p)
                    <tr>
                        <td>{{ $no + 1 }}</td>
                        <td><span class="user-badge"><i class="fas fa-user"></i> {{ $p->user->nama_lengkap ?? '-' }}</span></td>
                        <td><span class="laptop-text">{{ $p->laptop->nama_laptop ?? '-' }}</span></td>
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
                                <i class="fas fa-circle-info"></i> {{ ucfirst($p->status) }}
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
                        <td colspan="7" class="empty-state">Tidak ada data laporan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
