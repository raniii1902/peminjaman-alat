@extends('layouts.peminjam')

@section('title', 'Status Peminjaman')

@section('styles')
<style>
    .loan-page { max-width: 1200px; display: grid; gap: 18px; }
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
    .table-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        overflow: hidden;
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
    .date-badge, .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 6px 10px;
        font-size: 12px;
        font-weight: 700;
    }
    .date-badge { background: #f1f5f9; color: #334155; }
    .date-returned { background: #dcfce7; color: #166534; }
    .date-pending { background: #e2e8f0; color: #475569; }
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
<div class="loan-page">
    <section class="hero">
        <h2>Status Peminjaman</h2>
        <p>Pantau seluruh riwayat pengajuan dan status peminjaman laptop Anda.</p>
    </section>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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
                        <th>Laptop</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $no => $p)
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
                            @if($p->status === 'dikembalikan' && $p->tgl_kembali)
                                <span class="date-badge date-returned">
                                    <i class="fas fa-circle-check"></i>
                                    {{ \Carbon\Carbon::parse($p->tgl_kembali)->format('d M Y, H:i') }}
                                </span>
                            @else
                                <span class="date-badge date-pending">
                                    <i class="fas fa-hourglass-half"></i>
                                    Belum dikembalikan
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="status-badge status-{{ $p->status }}">
                                <i class="fas fa-circle-info"></i> {{ ucfirst($p->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty-state">Belum ada data peminjaman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
