@extends('layouts.admin')

@section('styles')
<style>
    .log-page {
        max-width: 1200px;
        display: grid;
        gap: 18px;
    }

    .log-hero {
        background: linear-gradient(140deg, #1e3a8a 0%, #0f172a 100%);
        border-radius: 18px;
        padding: 22px;
        color: #f8fafc;
        box-shadow: 0 16px 34px rgba(15, 23, 42, 0.2);
    }

    .log-title {
        margin: 0 0 6px 0;
        font-size: 26px;
        font-weight: 800;
    }

    .log-subtitle {
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

    .log-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 760px;
    }

    .log-table thead {
        background: #6c63ff;
        color: #fff;
    }

    .log-table th,
    .log-table td {
        padding: 14px 16px;
        text-align: left;
        font-size: 14px;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: top;
    }

    .log-table tbody tr:hover {
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

    .aksi-text {
        color: #0f172a;
        font-weight: 600;
        line-height: 1.5;
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

    .empty-state {
        padding: 22px;
        text-align: center;
        color: #64748b;
        background: #f8fafc;
    }

    .pager {
        margin-top: 6px;
    }

    @media (max-width: 768px) {
        .log-title {
            font-size: 22px;
        }

        .log-subtitle {
            font-size: 13px;
        }
    }
</style>
@endsection

@section('content')
<div class="log-page">
    <section class="log-hero">
        <h2 class="log-title">Log Aktifitas</h2>
        <p class="log-subtitle">Pantau semua aktivitas admin/petugas terbaru untuk memastikan proses sistem tetap terkontrol.</p>
    </section>

    <section class="table-card">
        <div class="table-wrap">
            <table class="log-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Aksi</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $no => $log)
                    <tr>
                        <td>{{ $logs->firstItem() + $no }}</td>
                        <td>
                            <span class="user-badge">
                                <i class="fas fa-user"></i>
                                {{ $log->user->nama_lengkap ?? '-' }}
                            </span>
                        </td>
                        <td><div class="aksi-text">{{ $log->aksi_admin }}</div></td>
                        <td>
                            <span class="time-badge">
                                <i class="fas fa-clock"></i>
                                {{ optional($log->waktu)->format('d M Y, H:i') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty-state">Belum ada data aktivitas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="pager">
        {{ $logs->links() }}
    </div>
</div>
@endsection
