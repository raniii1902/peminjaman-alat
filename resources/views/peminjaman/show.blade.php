@extends('layouts.admin')

@section('styles')
<style>
    .detail-page {
        max-width: 1000px;
        display: grid;
        gap: 18px;
    }

    .detail-hero {
        background: linear-gradient(140deg, #1e3a8a 0%, #0f172a 100%);
        border-radius: 18px;
        padding: 22px;
        color: #f8fafc;
        box-shadow: 0 16px 34px rgba(15, 23, 42, 0.2);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .detail-title {
        margin: 0 0 6px 0;
        font-size: 26px;
        font-weight: 800;
    }

    .detail-subtitle {
        margin: 0;
        color: #cbd5e1;
        font-size: 14px;
        line-height: 1.6;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.16);
        border: 1px solid rgba(255, 255, 255, 0.35);
        color: #fff;
        text-decoration: none;
        font-weight: 700;
        font-size: 13px;
        padding: 10px 14px;
    }

    .detail-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 220px 1fr;
    }

    .detail-row {
        display: contents;
    }

    .detail-label,
    .detail-value {
        padding: 14px 16px;
        border-bottom: 1px solid #e2e8f0;
        font-size: 14px;
    }

    .detail-label {
        background: #f8fafc;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: .4px;
    }

    .detail-value {
        color: #0f172a;
        font-weight: 700;
    }

    .value-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        background: #eef2ff;
        color: #3730a3;
        padding: 5px 10px;
        font-size: 12px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 800;
    }

    .status-dipinjam {
        background: #fef3c7;
        color: #b45309;
    }

    .status-dikembalikan {
        background: #dcfce7;
        color: #166534;
    }

    .status-terlambat {
        background: #fee2e2;
        color: #b91c1c;
    }

    .status-menunggu {
        background: #e0f2fe;
        color: #0c4a6e;
    }

    .status-default {
        background: #e2e8f0;
        color: #334155;
    }

    @media (max-width: 768px) {
        .detail-title {
            font-size: 22px;
        }

        .detail-subtitle {
            font-size: 13px;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .detail-label {
            border-bottom: none;
            padding-bottom: 6px;
        }

        .detail-value {
            padding-top: 0;
        }
    }
</style>
@endsection

@section('content')
<div class="detail-page">
    <section class="detail-hero">
        <div>
            <h2 class="detail-title">Detail Peminjaman</h2>
            <p class="detail-subtitle">Informasi lengkap data peminjaman laptop dan status prosesnya.</p>
        </div>
        <a href="{{ route('peminjaman.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </section>

    <section class="detail-card">
        <div class="detail-grid">
            <div class="detail-row">
                <div class="detail-label">Nama Peminjam</div>
                <div class="detail-value">
                    <span class="value-badge"><i class="fas fa-user"></i> {{ $peminjaman->user->nama_lengkap ?? '-' }}</span>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Laptop</div>
                <div class="detail-value">{{ $peminjaman->laptop->nama_laptop ?? '-' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Tanggal Pinjam</div>
                <div class="detail-value">
                    <span class="value-badge">
                        <i class="fas fa-calendar-day"></i>
                        {{ $peminjaman->tgl_pinjam ? \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d M Y') : '-' }}
                    </span>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Tanggal Kembali</div>
                <div class="detail-value">
                    <span class="value-badge">
                        <i class="fas fa-clock"></i>
                        {{ $peminjaman->tgl_kembali ? \Carbon\Carbon::parse($peminjaman->tgl_kembali)->format('d M Y, H:i') : '-' }}
                    </span>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Status</div>
                <div class="detail-value">
                    @php
                        $statusClass = match($peminjaman->status) {
                            'dipinjam' => 'status-dipinjam',
                            'dikembalikan' => 'status-dikembalikan',
                            'terlambat' => 'status-terlambat',
                            'menunggu' => 'status-menunggu',
                            default => 'status-default',
                        };
                    @endphp
                    <span class="status-badge {{ $statusClass }}">
                        <i class="fas fa-circle-info"></i> {{ ucfirst($peminjaman->status) }}
                    </span>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
