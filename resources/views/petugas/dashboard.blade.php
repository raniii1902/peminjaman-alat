@extends('layouts.petugas')

@section('title', 'Dashboard Petugas')

@section('styles')
<style>
    .petugas-dashboard {
        display: grid;
        gap: 20px;
    }

    .petugas-hero {
        position: relative;
        overflow: hidden;
        border-radius: 20px;
        padding: 26px;
        color: #eef6ff;
        background:
            radial-gradient(circle at 12% 18%, rgba(255, 255, 255, 0.24), transparent 46%),
            radial-gradient(circle at 86% 90%, rgba(16, 185, 129, 0.22), transparent 36%),
            linear-gradient(140deg, #0f3d91 0%, #0f172a 100%);
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.24);
    }

    .petugas-hero::after {
        content: '';
        position: absolute;
        width: 230px;
        height: 230px;
        border-radius: 999px;
        background: rgba(34, 211, 238, 0.14);
        top: -90px;
        right: -80px;
    }

    .hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 12px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.28);
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .35px;
    }

    .hero-title {
        margin-top: 12px;
        font-size: clamp(24px, 3vw, 32px);
        line-height: 1.2;
        font-weight: 700;
    }

    .hero-subtitle {
        margin-top: 8px;
        color: rgba(226, 232, 240, 0.9);
        line-height: 1.6;
        max-width: 660px;
    }

    .hero-date {
        padding: 10px 14px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.24);
        font-size: 13px;
        color: #dbeafe;
        font-weight: 500;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 14px;
    }

    .quick-card {
        text-decoration: none;
        color: #0f172a;
        background: #fff;
        border: 1px solid #dbe5f3;
        border-radius: 16px;
        padding: 16px;
        display: grid;
        gap: 8px;
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }

    .quick-card:hover {
        transform: translateY(-3px);
        border-color: #bfdbfe;
        box-shadow: 0 14px 28px rgba(30, 64, 175, 0.12);
    }

    .quick-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .quick-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #1d4ed8;
        background: #dbeafe;
    }

    .quick-title {
        font-size: 16px;
        font-weight: 700;
    }

    .quick-desc {
        font-size: 13px;
        color: #64748b;
        line-height: 1.5;
    }

    .panel {
        background: #fff;
        border: 1px solid #dbe5f3;
        border-radius: 18px;
        padding: 20px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
    }

    .panel-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 14px;
        color: #0f172a;
        font-size: 16px;
        font-weight: 700;
    }

    .panel-title i {
        color: #0ea5e9;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
        gap: 12px;
    }

    .stat-card {
        border: 1px solid #dbe5f3;
        border-radius: 14px;
        background: linear-gradient(180deg, #f8fbff 0%, #f1f6ff 100%);
        padding: 14px;
        display: grid;
        gap: 8px;
    }

    .stat-label {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .stat-value {
        font-size: 30px;
        font-weight: 700;
        line-height: 1;
        color: #0f172a;
    }

    .stat-meta {
        font-size: 12px;
        color: #475569;
    }

    .status-wait { color: #d97706; }
    .status-loan { color: #2563eb; }
    .status-late { color: #dc2626; }
    .status-done { color: #16a34a; }

    @media (max-width: 768px) {
        .petugas-hero,
        .panel {
            padding: 16px;
            border-radius: 14px;
        }

        .hero-date {
            width: 100%;
            text-align: center;
        }

        .stat-value {
            font-size: 25px;
        }
    }
</style>
@endsection

@section('content')
<div class="petugas-dashboard">
    <section class="petugas-hero">
        <div class="hero-content">
            <div>
                <span class="hero-badge"><i class="fas fa-user-gear"></i> Dashboard Petugas</span>
                <h1 class="hero-title">Halo, {{ auth()->user()->nama_lengkap ?? 'Petugas' }}</h1>
                <p class="hero-subtitle">Pantau peminjaman, verifikasi persetujuan, dan proses pengembalian laptop dari satu halaman kerja.</p>
            </div>
            <div class="hero-date">
                <i class="fas fa-calendar-days"></i>
                {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </section>

    <section class="quick-actions">
        <a class="quick-card" href="{{ route('petugas.persetujuan') }}">
            <div class="quick-head">
                <span class="quick-icon"><i class="fas fa-check"></i></span>
                <i class="fas fa-arrow-up-right-from-square" style="font-size:12px;color:#60a5fa;"></i>
            </div>
            <div class="quick-title">Persetujuan</div>
            <div class="quick-desc">Proses pengajuan yang menunggu validasi petugas.</div>
        </a>

        <a class="quick-card" href="{{ route('petugas.pengembalian') }}">
            <div class="quick-head">
                <span class="quick-icon"><i class="fas fa-rotate-left"></i></span>
                <i class="fas fa-arrow-up-right-from-square" style="font-size:12px;color:#60a5fa;"></i>
            </div>
            <div class="quick-title">Pengembalian</div>
            <div class="quick-desc">Pilih peminjaman, konfirmasi pengembalian, lalu cek status.</div>
        </a>

        <a class="quick-card" href="{{ route('petugas.laporan') }}">
            <div class="quick-head">
                <span class="quick-icon"><i class="fas fa-file-lines"></i></span>
                <i class="fas fa-arrow-up-right-from-square" style="font-size:12px;color:#60a5fa;"></i>
            </div>
            <div class="quick-title">Laporan</div>
            <div class="quick-desc">Lihat ringkasan data pinjam dan ekspor laporan.</div>
        </a>
    </section>

    <section class="panel">
        <div class="panel-title"><i class="fas fa-chart-column"></i> Ringkasan Status Peminjaman</div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Menunggu</div>
                <div class="stat-value">{{ $totalMenunggu }}</div>
                <div class="stat-meta status-wait">Belum diproses</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Dipinjam</div>
                <div class="stat-value">{{ $totalDipinjam }}</div>
                <div class="stat-meta status-loan">Sedang berjalan</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Terlambat</div>
                <div class="stat-value">{{ $totalTerlambat }}</div>
                <div class="stat-meta status-late">Perlu tindak lanjut</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Dikembalikan</div>
                <div class="stat-value">{{ $totalDikembalikan }}</div>
                <div class="stat-meta status-done">Transaksi selesai</div>
            </div>
        </div>
    </section>
</div>
@endsection
