@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('styles')
<style>
    .log-page {
        max-width: 1100px;
        display: grid;
        gap: 18px;
        width: 100%;
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
        padding: 22px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
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
        gap: 10px;
        flex-wrap: wrap;
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
        text-decoration: none;
    }

    .btn-ghost {
        background: #f8fafc;
        color: #475569;
        padding: 9px 14px;
        border-radius: 10px;
        font-weight: 700;
        border: 1px solid #e2e8f0;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .log-title {
            font-size: 22px;
        }
    }
</style>
@endsection

@section('content')
<div class="log-page">
    <section class="log-hero">
        <h2 class="log-title">Edit Kategori</h2>
        <p class="log-subtitle">Perbarui nama kategori agar pengelompokan inventaris PPLG tetap konsisten.</p>
    </section>

    <section class="table-card">
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

        <form action="{{ route('kategori.update', $kategori->id_kategori) }}" method="POST" class="form-grid">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama_kategori">Nama Kategori <span class="required">*</span></label>
                <input
                    id="nama_kategori"
                    type="text"
                    name="nama_kategori"
                    value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                    required
                >
            </div>

            <div class="form-actions">
                <a href="{{ route('kategori.index') }}" class="btn-ghost">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-pen"></i> Update Kategori
                </button>
            </div>
        </form>
    </section>
</div>
@endsection
