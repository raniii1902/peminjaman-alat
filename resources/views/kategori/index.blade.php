@extends('layouts.admin')

@section('title', 'Data Kategori')

@section('styles')
<style>
    .kategori-page { max-width: 1100px; display: grid; gap: 18px; }
    .hero {
        background: linear-gradient(140deg, #1e3a8a 0%, #0f172a 100%);
        border-radius: 18px;
        padding: 22px;
        color: #f8fafc;
        box-shadow: 0 16px 34px rgba(15, 23, 42, 0.2);
        display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap;
    }
    .hero h2 { margin: 0 0 6px 0; font-size: 26px; font-weight: 800; }
    .hero p { margin: 0; color: #cbd5e1; font-size: 14px; }
    .btn-add {
        background: rgba(255,255,255,.16); border: 1px solid rgba(255,255,255,.35);
        color: #fff; padding: 10px 14px; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 13px;
        display: inline-flex; align-items: center; gap: 8px;
    }
    .alert {
        background: #dcfce7; border: 1px solid #86efac; color: #166534;
        border-radius: 12px; padding: 12px 14px; font-size: 13px; font-weight: 600;
    }
    .table-card {
        background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; overflow: hidden;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
    }
    .table-wrap { overflow-x: auto; }
    .data-table { width: 100%; min-width: 680px; border-collapse: collapse; }
    .data-table thead { background: #6c63ff; color: #fff; }
    .data-table th, .data-table td { padding: 14px 16px; text-align: left; font-size: 14px; border-bottom: 1px solid #e2e8f0; }
    .data-table tbody tr:hover { background: #f8fafc; }
    .cell-strong { font-weight: 700; color: #0f172a; }
    .action-group { display: inline-flex; gap: 8px; flex-wrap: wrap; }
    .btn-action { border: none; border-radius: 8px; padding: 7px 12px; font-size: 12px; font-weight: 700; text-decoration: none; display: inline-flex; gap: 6px; align-items: center; cursor: pointer; }
    .btn-edit { background: #eef2ff; color: #4c51bf; }
    .btn-delete { background: #fee2e2; color: #991b1b; }
    .empty-state { padding: 20px; text-align: center; color: #64748b; background: #f8fafc; }
</style>
@endsection

@section('content')
<div class="kategori-page">
    <section class="hero">
        <div>
            <h2>Data Kategori</h2>
            <p>Kelola kategori laptop agar data lebih rapi dan mudah dipilah.</p>
        </div>
        <a href="{{ route('kategori.create') }}" class="btn-add"><i class="fa-solid fa-plus"></i> Tambah Kategori</a>
    </section>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <section class="table-card">
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $index => $k)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="cell-strong">{{ $k->nama_kategori }}</td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('kategori.edit', $k) }}" class="btn-action btn-edit">
                                        <i class="fa-solid fa-pen"></i> Edit
                                    </a>
                                    <form action="{{ route('kategori.destroy', $k) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-action btn-delete" onclick="return confirm('Yakin ingin hapus?')">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="empty-state">Belum ada data kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
