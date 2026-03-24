@extends('layouts.peminjam')

@section('title', 'Daftar Alat')

@section('styles')
<style>
    .tools-page { max-width: 1200px; display: grid; gap: 18px; }
    .hero {
        background: linear-gradient(140deg, #1e3a8a 0%, #0f172a 100%);
        border-radius: 18px;
        padding: 22px;
        color: #f8fafc;
        box-shadow: 0 16px 34px rgba(15, 23, 42, 0.2);
    }
    .hero h2 { margin: 0 0 6px 0; font-size: 26px; font-weight: 800; }
    .hero p { margin: 0; color: #cbd5e1; font-size: 14px; line-height: 1.6; }
    .table-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }
    .table-wrap { overflow-x: auto; }
    .data-table { width: 100%; min-width: 860px; border-collapse: collapse; }
    .data-table thead { background: #6C63FF; color: #fff; }
    .data-table th, .data-table td {
        padding: 14px 16px;
        text-align: left;
        font-size: 14px;
        border-bottom: 1px solid #e2e8f0;
    }
    .data-table tbody tr:hover { background: #f8fafc; }
    .laptop-name { font-weight: 700; color: #0f172a; }
    .stock-badge, .avail-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 6px 10px;
        font-size: 12px;
        font-weight: 700;
    }
    .stock-ok, .avail-ok { background: #dcfce7; color: #166534; }
    .stock-empty, .avail-empty { background: #fee2e2; color: #991b1b; }
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
<div class="tools-page">
    <section class="hero">
        <h2>Daftar Alat</h2>
        <p>Lihat daftar inventaris PPLG seperti laptop dan proyektor, kategori, stok, dan ketersediaan sebelum melakukan pengajuan peminjaman.</p>
    </section>

    <section class="table-card">
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Alat</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Ketersediaan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laptop as $no => $l)
                    <tr>
                        <td>{{ $no + 1 }}</td>
                        <td class="laptop-name">{{ $l->nama_laptop }}</td>
                        <td>{{ $l->kategori->nama_kategori ?? '-' }}</td>
                        <td>
                            <span class="stock-badge {{ $l->stok > 0 ? 'stock-ok' : 'stock-empty' }}">
                                <i class="fas fa-box"></i> {{ $l->stok }}
                            </span>
                        </td>
                        <td>
                            @if($l->stok > 0)
                                <span class="avail-badge avail-ok"><i class="fas fa-circle-check"></i> Tersedia</span>
                            @else
                                <span class="avail-badge avail-empty"><i class="fas fa-circle-xmark"></i> Habis</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty-state">Tidak ada data alat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
