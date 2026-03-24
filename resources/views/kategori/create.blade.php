@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('styles')
<style>
    .kategori-create-page {
        max-width: 1100px;
        display: grid;
        gap: 18px;
        width: 100%;
    }

    .hero {
        background: linear-gradient(140deg, #1e3a8a 0%, #0f172a 100%);
        border-radius: 18px;
        padding: 22px;
        color: #f8fafc;
        box-shadow: 0 16px 34px rgba(15, 23, 42, 0.2);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .page-title {
        font-size: 26px;
        font-weight: 800;
        margin: 0 0 6px 0;
    }

    .page-subtitle {
        color: #cbd5e1;
        font-size: 14px;
        margin: 0;
    }

    .form-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 24px;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.06);
    }

    .error-banner {
        background: #fee2e2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 14px 16px;
        border-radius: 10px;
        margin-bottom: 18px;
        font-size: 13px;
    }

    .error-banner ul {
        margin: 8px 0 0 18px;
    }

    .form-grid {
        display: grid;
        gap: 16px;
    }

    .form-group label {
        display: block;
        font-weight: 700;
        color: #334155;
        margin-bottom: 8px;
        font-size: 13px;
    }

    .required {
        color: #dc2626;
    }

    .form-group input {
        width: 100%;
        padding: 11px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        background: #f8fafc;
        transition: all 0.2s ease;
    }

    .form-group input:focus {
        outline: none;
        border-color: #2563eb;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 8px;
    }

    .btn-primary {
        background: #4f46e5;
        color: #ffffff;
        padding: 9px 14px;
        border-radius: 10px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-secondary {
        background: rgba(255,255,255,.16);
        border: 1px solid rgba(255,255,255,.35);
        color: #fff;
        padding: 10px 14px;
        border-radius: 10px;
        font-weight: 700;
        text-decoration: none;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    @media (max-width: 768px) {
        .form-card { padding: 20px; }
    }
</style>
@endsection

@section('content')
<div class="kategori-create-page">
    <section class="hero">
        <div>
            <h1 class="page-title"><i class="fa-solid fa-folder-plus"></i> Tambah Kategori</h1>
            <p class="page-subtitle">Buat kategori baru untuk pengelompokan inventaris PPLG seperti laptop dan proyektor.</p>
        </div>
        <a href="{{ route('kategori.index') }}" class="btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </section>

    <section class="form-card">
        @if ($errors->any())
            <div class="error-banner">
                <strong>Periksa kembali input Anda</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('kategori.store') }}" method="POST" class="form-grid">
            @csrf
            <div class="form-group">
                <label for="nama_kategori">Nama Kategori <span class="required">*</span></label>
                <input
                    id="nama_kategori"
                    type="text"
                    name="nama_kategori"
                    placeholder="Contoh: Ultrabook, Gaming, Office"
                    value="{{ old('nama_kategori') }}"
                    required
                >
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-plus"></i> Simpan Kategori
                </button>
            </div>
        </form>
    </section>
</div>
@endsection
