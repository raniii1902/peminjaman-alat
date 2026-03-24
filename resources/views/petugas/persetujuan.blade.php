@extends('layouts.petugas')

@section('title', 'Persetujuan Peminjaman')

@section('styles')
<style>
    .approval-page { max-width: 1200px; display: grid; gap: 18px; }
    .hero {
        background: linear-gradient(140deg, #1e3a8a 0%, #0f172a 100%);
        border-radius: 18px;
        padding: 22px;
        color: #f8fafc;
        box-shadow: 0 16px 34px rgba(15, 23, 42, 0.2);
    }
    .hero h2 { margin: 0 0 6px 0; font-size: 26px; font-weight: 800; }
    .hero p { margin: 0; color: #cbd5e1; font-size: 14px; line-height: 1.6; }
    .alert {
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 13px;
        font-weight: 600;
    }
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
    .date-badge, .late-badge {
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
    .late-badge.late { background: #fee2e2; color: #b91c1c; }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
    }
    .status-dipinjam { background: #fef3c7; color: #b45309; }
    .status-terlambat { background: #fee2e2; color: #b91c1c; }
    .btn-action {
        border: none;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-approve { background: #dcfce7; color: #166534; }
    .btn-pending { background: #f1f5f9; color: #475569; }
    .btn-return { background: #dbeafe; color: #1d4ed8; }
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
<div class="approval-page">
    <section class="hero">
        <h2>Persetujuan Peminjaman</h2>
        <p>Kelola pengajuan menunggu dan pantau data inventaris PPLG seperti laptop dan proyektor yang belum dikembalikan dalam satu halaman.</p>
    </section>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <section class="section-card">
        <div class="section-head">Pengajuan Menunggu</div>
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alat</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menunggu as $no => $p)
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
                            <form action="{{ route('petugas.setujui', $p->id_peminjaman) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn-action btn-approve">
                                    <i class="fas fa-check"></i> Setujui
                                </button>
                            </form>
                            <form action="{{ route('petugas.tunda', $p->id_peminjaman) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn-action btn-pending">
                                    <i class="fas fa-hourglass-half"></i> Menunggu
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty-state">Tidak ada pengajuan menunggu.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="section-card">
        <div class="section-head">Alat Belum Kembali</div>
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alat</th>
                        <th>Tgl Pinjam</th>
                        <th>Keterlambatan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($belumKembali as $no => $p)
                    @php
                        $due = \Carbon\Carbon::parse($p->tgl_pinjam)->addDays(7);
                        $lateDays = now()->greaterThan($due) ? now()->diffInDays($due) : 0;
                    @endphp
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
                            <span class="late-badge {{ $lateDays > 0 ? 'late' : '' }}">
                                <i class="fas fa-hourglass-half"></i>
                                {{ $lateDays > 0 ? $lateDays . ' hari' : '-' }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge {{ $p->status == 'terlambat' ? 'status-terlambat' : 'status-dipinjam' }}">
                                <i class="fas fa-circle-info"></i> {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('petugas.kembalikan', $p->id_peminjaman) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn-action btn-return">
                                    <i class="fas fa-rotate-left"></i> Perbarui Pengembalian
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty-state">Tidak ada data alat belum kembali.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
