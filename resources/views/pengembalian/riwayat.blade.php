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

    .return-metric {
        margin-top: 14px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-radius: 12px;
        background: rgba(15, 23, 42, 0.32);
        border: 1px solid rgba(148, 163, 184, 0.35);
    }

    .return-metric i {
        color: #facc15;
    }

    .return-metric-label {
        display: block;
        font-size: 12px;
        color: #cbd5e1;
        line-height: 1.3;
    }

    .return-metric-value {
        display: block;
        font-size: 18px;
        font-weight: 800;
        color: #f8fafc;
        line-height: 1.2;
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

    .denda-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 5px 10px;
        font-weight: 700;
        font-size: 12px;
        white-space: nowrap;
    }

    .denda-badge.has {
        background: #fee2e2;
        color: #b91c1c;
    }

    .denda-badge.none {
        background: #e2e8f0;
        color: #475569;
    }

    .payment-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 5px 10px;
        font-weight: 700;
        font-size: 12px;
        white-space: nowrap;
    }

    .payment-badge.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .payment-badge.paid {
        background: #dcfce7;
        color: #166534;
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

    .btn-pay {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        border: none;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        background: #dcfce7;
        color: #166534;
        cursor: pointer;
    }

    .action-stack {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
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
        <div class="return-metric">
            <i class="fas fa-sack-dollar"></i>
            <div>
                <span class="return-metric-label">Total Denda (Yang Kena Denda)</span>
                <span class="return-metric-value">Rp {{ number_format($totalDenda ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>
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
                        <th>Denda</th>
                        <th>Pembayaran</th>
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
                            @if(($p->denda ?? 0) > 0)
                                <span class="denda-badge has">
                                    <i class="fas fa-triangle-exclamation"></i>
                                    Rp {{ number_format($p->denda, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="denda-badge none">
                                    <i class="fas fa-check"></i>
                                    Tidak ada denda
                                </span>
                            @endif
                        </td>
                        <td>
                            @if(($p->denda ?? 0) > 0)
                                @if($p->status_pembayaran_denda === 'lunas')
                                    <span class="payment-badge paid">
                                        <i class="fas fa-circle-check"></i>
                                        Lunas
                                    </span>
                                    @if($p->tgl_bayar_denda)
                                        <div style="margin-top:6px;font-size:12px;color:#64748b;">
                                            {{ \Carbon\Carbon::parse($p->tgl_bayar_denda)->format('d M Y, H:i') }}
                                        </div>
                                    @endif
                                @else
                                    <span class="payment-badge pending">
                                        <i class="fas fa-clock"></i>
                                        Belum dibayar
                                    </span>
                                @endif
                            @else
                                <span class="payment-badge paid">
                                    <i class="fas fa-minus"></i>
                                    Tidak perlu bayar
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="status-done">
                                <i class="fas fa-circle-check"></i>
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="action-stack">
                                <a href="{{ route('peminjaman.show', $p->id_peminjaman) }}" class="btn-view">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                @if(($p->denda ?? 0) > 0 && $p->status_pembayaran_denda !== 'lunas')
                                    <form action="{{ route('pengembalian.bayar-denda', $p->id_peminjaman) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn-pay">
                                            <i class="fas fa-money-bill-wave"></i> Bayar Denda
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="empty-state">Belum ada data pengembalian.</td>
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
