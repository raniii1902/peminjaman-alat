@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('styles')
<style>
    :root {
        --dash-bg: #eef2f8;
        --panel: #ffffff;
        --panel-soft: #f6f9ff;
        --text-main: #0f172a;
        --text-muted: #64748b;
        --line: #dbe5f3;
        --accent: #2563eb;
        --accent-2: #0891b2;
        --ok: #16a34a;
        --warn: #d97706;
    }

    .dashboard-modern {
        display: grid;
        gap: 20px;
    }

    .hero-panel {
        position: relative;
        overflow: hidden;
        border-radius: 20px;
        padding: 28px;
        background:
            radial-gradient(circle at 8% 18%, rgba(255, 255, 255, 0.34), transparent 46%),
            radial-gradient(circle at 94% 84%, rgba(14, 165, 233, 0.20), transparent 40%),
            linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%);
        color: #f8fafc;
        box-shadow: 0 20px 44px rgba(15, 23, 42, 0.28);
    }

    .hero-panel::after {
        content: '';
        position: absolute;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: rgba(34, 211, 238, 0.18);
        right: -80px;
        top: -80px;
        filter: blur(4px);
    }

    .hero-top {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .hero-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 12px;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.36);
        background: rgba(255, 255, 255, 0.14);
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .4px;
    }

    .hero-title {
        margin-top: 14px;
        font-size: clamp(24px, 3vw, 34px);
        line-height: 1.2;
        font-weight: 700;
    }

    .hero-subtitle {
        margin-top: 8px;
        color: rgba(241, 245, 249, 0.86);
        max-width: 670px;
        line-height: 1.6;
    }

    .hero-date {
        padding: 10px 14px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.28);
        font-size: 13px;
        color: #dbeafe;
        font-weight: 500;
    }

    .quick-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 14px;
    }

    .quick-card {
        text-decoration: none;
        color: var(--text-main);
        background: var(--panel);
        border: 1px solid var(--line);
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
        align-items: center;
        justify-content: space-between;
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
        font-size: 16px;
    }

    .quick-arrow {
        color: #60a5fa;
        font-size: 12px;
    }

    .quick-title {
        font-size: 16px;
        font-weight: 700;
    }

    .quick-sub {
        color: var(--text-muted);
        font-size: 13px;
        line-height: 1.5;
    }

    .section-card {
        background: var(--panel);
        border: 1px solid var(--line);
        border-radius: 18px;
        padding: 20px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 14px;
    }

    .section-title i {
        color: #0ea5e9;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 12px;
    }

    .stat-card {
        border-radius: 14px;
        padding: 14px;
        border: 1px solid #dbe5f3;
        background: linear-gradient(180deg, #f8fbff 0%, #f1f6ff 100%);
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
        line-height: 1;
        font-weight: 700;
        color: #0f172a;
    }

    .stat-meta {
        font-size: 12px;
        color: #475569;
    }

    .badge-ok {
        color: var(--ok);
    }

    .badge-warn {
        color: var(--warn);
    }

    .activity-list {
        display: grid;
        gap: 10px;
    }

    .activity-item {
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        border-radius: 12px;
        padding: 12px 14px;
        display: grid;
        gap: 6px;
    }

    .activity-action {
        font-weight: 600;
        color: #0f172a;
        line-height: 1.5;
    }

    .activity-meta {
        font-size: 12px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .empty-state {
        border: 1px dashed #cbd5e1;
        border-radius: 12px;
        padding: 16px;
        text-align: center;
        color: #64748b;
        background: #f8fafc;
    }

    @media (max-width: 768px) {
        .hero-panel,
        .section-card {
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
<div class="dashboard-modern">
    <section class="hero-panel">
        <div class="hero-top">
            <div>
                <span class="hero-kicker"><i class="fas fa-shield-halved"></i> Dashboard Admin Peminjaman PPLG</span>
                <h1 class="hero-title">Selamat datang, {{ auth()->user()->nama_lengkap ?? 'Admin' }}</h1>
                <p class="hero-subtitle">Kelola data pengguna, inventaris PPLG, peminjaman, dan aktivitas sistem untuk laptop serta proyektor dalam satu panel yang rapi dan cepat diakses.</p>
            </div>
            <div class="hero-date">
                <i class="fas fa-calendar-days"></i>
                {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </section>

    <section class="quick-grid">
        <a class="quick-card" href="{{ route('user.index') }}">
            <div class="quick-head">
                <span class="quick-icon"><i class="fas fa-users"></i></span>
                <span class="quick-arrow"><i class="fas fa-arrow-up-right-from-square"></i></span>
            </div>
            <div class="quick-title">Kelola User</div>
            <div class="quick-sub">Tambah, ubah, dan hapus akun pengguna aplikasi.</div>
        </a>

        <a class="quick-card" href="{{ route('laptop.index') }}">
            <div class="quick-head">
                <span class="quick-icon"><i class="fas fa-laptop"></i></span>
                <span class="quick-arrow"><i class="fas fa-arrow-up-right-from-square"></i></span>
            </div>
            <div class="quick-title">Kelola Alat</div>
            <div class="quick-sub">Atur data inventaris PPLG seperti laptop dan proyektor beserta ketersediaannya.</div>
        </a>

        <a class="quick-card" href="{{ route('kategori.index') }}">
            <div class="quick-head">
                <span class="quick-icon"><i class="fas fa-folder-tree"></i></span>
                <span class="quick-arrow"><i class="fas fa-arrow-up-right-from-square"></i></span>
            </div>
            <div class="quick-title">Kelola Kategori</div>
            <div class="quick-sub">Kelompokkan inventaris PPLG agar pencarian dan laporan lebih mudah.</div>
        </a>

        <a class="quick-card" href="{{ route('log.index') }}">
            <div class="quick-head">
                <span class="quick-icon"><i class="fas fa-clock-rotate-left"></i></span>
                <span class="quick-arrow"><i class="fas fa-arrow-up-right-from-square"></i></span>
            </div>
            <div class="quick-title">Log Aktivitas</div>
            <div class="quick-sub">Pantau riwayat aksi admin dan petugas terbaru.</div>
        </a>

        <a class="quick-card" href="{{ route('peminjaman.index') }}">
            <div class="quick-head">
                <span class="quick-icon"><i class="fas fa-box-open"></i></span>
                <span class="quick-arrow"><i class="fas fa-arrow-up-right-from-square"></i></span>
            </div>
            <div class="quick-title">Data Peminjaman</div>
            <div class="quick-sub">Memproses data peminjaman: cek detail dan pengembalian.</div>
        </a>

        <a class="quick-card" href="{{ route('pengembalian.index') }}">
            <div class="quick-head">
                <span class="quick-icon"><i class="fas fa-rotate-left"></i></span>
                <span class="quick-arrow"><i class="fas fa-arrow-up-right-from-square"></i></span>
            </div>
            <div class="quick-title">Data Pengembalian</div>
            <div class="quick-sub">Kelola proses pengembalian dan pembaruan status.</div>
        </a>
    </section>

    <section class="section-card">
        <div class="section-title"><i class="fas fa-chart-column"></i> Ringkasan Data</div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total User</div>
                <div class="stat-value">{{ $stats['totalUser'] ?? 0 }}</div>
                <div class="stat-meta">Akun terdaftar di sistem</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Kategori</div>
                <div class="stat-value">{{ $stats['totalKategori'] ?? 0 }}</div>
                <div class="stat-meta">Kategori inventaris PPLG tersedia</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Alat</div>
                <div class="stat-value">{{ $stats['totalLaptop'] ?? 0 }}</div>
                <div class="stat-meta">Item inventaris PPLG tercatat</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Stok</div>
                <div class="stat-value">{{ $stats['totalStok'] ?? 0 }}</div>
                <div class="stat-meta">Jumlah unit yang tersedia di inventaris</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Peminjaman</div>
                <div class="stat-value">{{ $stats['totalPeminjaman'] ?? 0 }}</div>
                <div class="stat-meta badge-warn">Transaksi peminjaman keseluruhan</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Pengembalian</div>
                <div class="stat-value">{{ $stats['totalPengembalian'] ?? 0 }}</div>
                <div class="stat-meta badge-ok">Transaksi selesai dikembalikan</div>
            </div>
        </div>
    </section>

    <section class="section-card">
        <div class="section-title"><i class="fas fa-list-check"></i> Aktivitas Terbaru</div>

        @if(($recentLogs ?? collect())->count())
            <div class="activity-list">
                @foreach($recentLogs as $log)
                    <div class="activity-item">
                        <div class="activity-action">{{ $log->aksi_admin ?? '-' }}</div>
                        <div class="activity-meta">
                            <span><i class="fas fa-user"></i> {{ $log->user->nama_lengkap ?? '-' }}</span>
                            <span><i class="fas fa-clock"></i> {{ optional($log->waktu)->format('d M Y H:i') ?? '-' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">Belum ada aktivitas terbaru.</div>
        @endif
    </section>
</div>
@endsection
