@extends('layouts.admin')

@section('title', 'Daftar Inventaris')

@section('styles')
<style>
    .laptop-page {
        max-width: 1200px;
        display: grid;
        gap: 18px;
    }

    .laptop-hero {
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

    .hero-title {
        margin: 0 0 6px 0;
        font-size: 26px;
        font-weight: 800;
    }

    .hero-subtitle {
        margin: 0;
        color: #cbd5e1;
        font-size: 14px;
        line-height: 1.6;
    }

    .btn-primary {
        background: rgba(255, 255, 255, 0.16);
        border: 1px solid rgba(255, 255, 255, 0.35);
        color: #ffffff;
        padding: 10px 14px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .alert-success {
        background: #dcfce7;
        border: 1px solid #86efac;
        color: #166534;
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 13px;
        font-weight: 600;
    }

    .table-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.06);
    }

    .table-wrap {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 760px;
    }

    .data-table thead {
        background: #6C63FF;
        color: #ffffff;
    }

    .data-table th,
    .data-table td {
        padding: 14px 16px;
        text-align: left;
        font-size: 14px;
        border-bottom: 1px solid #e2e8f0;
    }

    .data-table tbody tr:hover {
        background: #f8fafc;
    }

    .cell-strong {
        font-weight: 700;
        color: #0f172a;
    }

    .stock-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        padding: 6px 10px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 12px;
    }

    .stock-ok {
        background: #dcfce7;
        color: #166534;
    }

    .stock-low {
        background: #fee2e2;
        color: #991b1b;
    }

    .action-group {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-action {
        border: none;
        border-radius: 8px;
        padding: 7px 12px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-edit {
        background: #eef2ff;
        color: #4c51bf;
    }

    .btn-delete {
        background: #fee2e2;
        color: #991b1b;
    }

    .empty-state {
        padding: 20px;
        text-align: center;
        color: #64748b;
        font-size: 14px;
        background: #f8fafc;
    }
</style>
@endsection

@section('content')
<div class="laptop-page">
    <div class="laptop-hero">
        <div>
            <h2 class="hero-title">Daftar Inventaris PPLG</h2>
            <p class="hero-subtitle">Kelola data inventaris seperti laptop dan proyektor beserta ketersediaan stok dengan tampilan yang rapi dan cepat dipantau.</p>
        </div>
        <a href="{{ route('laptop.create') }}" class="btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Alat
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-card">
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Alat</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laptops as $no => $laptop)
                    <tr>
                        <td>{{ $no+1 }}</td>
                        <td class="cell-strong">{{ $laptop->nama_laptop }}</td>
                        <td>{{ $laptop->kategori->nama_kategori }}</td>
                        <td>
                            <span class="stock-badge {{ $laptop->stok > 0 ? 'stock-ok' : 'stock-low' }}">
                                {{ $laptop->stok }}
                            </span>
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('laptop.edit',$laptop->id_laptop) }}" class="btn-action btn-edit">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>
                                <form action="{{ route('laptop.destroy',$laptop->id_laptop) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty-state">Belum ada data inventaris.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
