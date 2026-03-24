@extends('layouts.admin')

@section('title', 'Data Pengembalian')

@section('styles')
<style>
    .return-page {
        max-width: 1200px;
        display: grid;
        gap: 18px;
    }

    .return-hero {
        background: linear-gradient(140deg, #1e3a8a 0%, #0f172a 100%);
        border-radius: 18px;
        padding: 22px;
        color: #f8fafc;
        box-shadow: 0 16px 34px rgba(15, 23, 42, 0.2);
    }

    .return-title {
        margin: 0 0 6px 0;
        font-size: 26px;
        font-weight: 800;
    }

    .return-subtitle {
        margin: 0;
        color: #cbd5e1;
        font-size: 14px;
        line-height: 1.6;
    }

    .table-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
    }

    .table-wrap {
        overflow-x: auto;
    }

    .return-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 980px;
    }

    .return-table thead {
        background: #6c63ff;
        color: #fff;
    }

    .return-table th,
    .return-table td {
        padding: 14px 16px;
        text-align: left;
        font-size: 14px;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: top;
    }

    .return-table tbody tr:hover {
        background: #f8fafc;
    }

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

    .laptop-text {
        color: #0f172a;
        font-weight: 700;
    }

    .time-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        background: #f1f5f9;
        color: #334155;
        padding: 5px 10px;
        font-weight: 600;
        font-size: 12px;
        white-space: nowrap;
    }

    .status-done {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        background: #dcfce7;
        color: #166534;
        padding: 5px 10px;
        font-weight: 700;
        font-size: 12px;
    }

    .btn-view {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        background: #dbeafe;
        color: #1d4ed8;
    }

    .empty-state {
        padding: 22px;
        text-align: center;
        color: #64748b;
        background: #f8fafc;
    }

    .pager {
        margin-top: 6px;
    }
</style>
@endsection

@section('content')
<div class="return-page">
    <section class="return-hero">
        <h2 class="return-title">Data Pengembalian</h2>
        <p class="return-subtitle">Riwayat pengembalian alat PPLG yang sudah selesai, lengkap dengan detail peminjam dan waktu transaksi.</p>
    </section>

    <section class="table-card">
        <div class="table-wrap">
            <table class="return-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Alat</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengembalian as $no => $p)
                    <tr>
                        <td>{{ $pengembalian->firstItem() + $no }}</td>
                        <td>
                            <span class="user-badge">
                                <i class="fas fa-user"></i>
                                {{ $p->user->nama_lengkap ?? '-' }}
                            </span>
                        </td>
                        <td><span class="laptop-text">{{ $p->laptop->nama_laptop ?? '-' }}</span></td>
                        <td>
                            <span class="time-badge">
                                <i class="fas fa-calendar-day"></i>
                                {{ $p->tgl_pinjam ? \Carbon\Carbon::parse($p->tgl_pinjam)->format('d M Y') : '-' }}
                            </span>
                        </td>
                        <td>
                            <span class="time-badge">
                                <i class="fas fa-clock"></i>
                                {{ $p->tgl_kembali ? \Carbon\Carbon::parse($p->tgl_kembali)->format('d M Y, H:i') : '-' }}
                            </span>
                        </td>
                        <td>
                            <span class="status-done">
                                <i class="fas fa-circle-check"></i>
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('peminjaman.show', $p->id_peminjaman) }}" class="btn-view">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty-state">Belum ada data pengembalian.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="pager">
        {{ $pengembalian->links() }}
    </div>
</div>
@endsection
