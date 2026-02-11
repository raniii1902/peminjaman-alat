@extends('layouts.admin')

@section('title', 'Data Peminjaman')

@section('styles')
<style>
    .loan-page { max-width: 1200px; display: grid; gap: 18px; }
    .hero {
        background: linear-gradient(140deg, #1e3a8a 0%, #0f172a 100%);
        border-radius: 18px;
        padding: 22px;
        color: #f8fafc;
        box-shadow: 0 16px 34px rgba(15, 23, 42, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    .hero h2 { margin: 0 0 6px 0; font-size: 26px; font-weight: 800; }
    .hero p { margin: 0; color: #cbd5e1; font-size: 14px; line-height: 1.6; }
    .btn-add {
        background: rgba(255,255,255,.16);
        border: 1px solid rgba(255,255,255,.35);
        color: #fff;
        padding: 10px 14px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 700;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .alert {
        background: #dcfce7;
        border: 1px solid #86efac;
        color: #166534;
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 13px;
        font-weight: 600;
    }
    .alert-error {
        background: #fee2e2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }
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
    .date-badge {
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
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 6px 10px;
        font-size: 12px;
        font-weight: 700;
    }
    .status-dipinjam { background: #fef3c7; color: #b45309; }
    .status-terlambat { background: #fee2e2; color: #b91c1c; }
    .status-dikembalikan { background: #dcfce7; color: #166534; }
    .status-menunggu { background: #e0f2fe; color: #0c4a6e; }
    .action-group { display: inline-flex; gap: 8px; flex-wrap: wrap; }
    .btn-action {
        border: none;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-view { background: #dbeafe; color: #1d4ed8; }
    .btn-return { background: #dcfce7; color: #166534; }
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
<div class="loan-page">
    <section class="hero">
        <div>
            <h2>Data Peminjaman</h2>
            <p>Halaman ini digunakan untuk memproses data peminjaman: cek detail pinjaman dan proses pengembalian.</p>
        </div>
        <a href="{{ route('peminjaman.create') }}" class="btn-add">
            <i class="fas fa-plus"></i> Input Peminjaman
        </a>
    </section>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <section class="table-card">
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Laptop</th>
                        <th>Tgl Pinjam</th>
                        <th>Status</th>
                        <th>Aksi Proses</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $no => $p)
                    <tr>
                        <td>{{ $no + 1 }}</td>
                        <td><span class="user-badge"><i class="fas fa-user"></i> {{ $p->user->nama_lengkap ?? '-' }}</span></td>
                        <td><span class="laptop-text">{{ $p->laptop->nama_laptop ?? '-' }}</span></td>
                        <td>
                            <span class="date-badge">
                                <i class="fas fa-calendar-day"></i>
                                {{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d M Y') }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge status-{{ $p->status }}">
                                <i class="fas fa-circle-info"></i> {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('peminjaman.show', $p->id_peminjaman) }}" class="btn-action btn-view">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                @if(in_array($p->status, ['dipinjam', 'terlambat']))
                                <form action="{{ route('peminjaman.update', $p->id_peminjaman) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn-action btn-return">
                                        <i class="fas fa-rotate-left"></i> Proses Pengembalian
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-state">Belum ada data peminjaman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
