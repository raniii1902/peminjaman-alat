@extends('layouts.admin')

@section('title', 'Edit Inventaris')

@section('styles')
<style>
    .laptop-form-page {
        max-width: 1100px;
        display: grid;
        gap: 18px;
        width: 100%;
    }

    .form-hero {
        background: linear-gradient(140deg, #1e3a8a 0%, #0f172a 100%);
        border-radius: 18px;
        padding: 22px;
        color: #f8fafc;
        box-shadow: 0 16px 34px rgba(15, 23, 42, 0.2);
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

    .form-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        padding: 22px;
    }

    .error-box {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
        border-radius: 10px;
        padding: 12px 14px;
        margin-bottom: 14px;
        font-size: 13px;
    }

    .form-grid {
        display: grid;
        gap: 14px;
    }

    .form-group {
        display: grid;
        gap: 8px;
    }

    .form-label {
        font-weight: 700;
        font-size: 13px;
        color: #334155;
        text-transform: uppercase;
        letter-spacing: .35px;
    }

    .form-input {
        width: 100%;
        border: 1px solid #dbe3f0;
        background: #f8fafc;
        border-radius: 10px;
        padding: 11px 12px;
        font-size: 14px;
        color: #0f172a;
        outline: none;
    }

    .form-input:focus {
        border-color: #6366f1;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12);
    }

    .actions {
        margin-top: 16px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-back {
        background: #e2e8f0;
        color: #334155;
        border-radius: 10px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        padding: 9px 13px;
    }

    .btn-save {
        border: none;
        background: #4f46e5;
        color: #fff;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        padding: 9px 13px;
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<div class="laptop-form-page">
    <section class="form-hero">
        <h2 class="hero-title">Edit Inventaris PPLG</h2>
        <p class="hero-subtitle">Perbarui data inventaris seperti laptop atau proyektor agar informasi stok dan kategori tetap akurat.</p>
    </section>

    <section class="form-card">
        @if ($errors->any())
            <div class="error-box">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('laptop.update', $laptop->id_laptop) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Nama Alat</label>
                    <input class="form-input" type="text" name="nama_laptop" value="{{ old('nama_laptop', $laptop->nama_laptop) }}" placeholder="Contoh: Asus VivoBook / Proyektor Epson" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Stok Alat</label>
                    <input class="form-input" type="number" name="stok" value="{{ old('stok', $laptop->stok) }}" placeholder="Masukkan jumlah stok" min="0" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Kategori Alat</label>
                    <select class="form-input" name="id_kategori" required>
                        <option value="" disabled>-- Pilih Kategori Alat --</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id_kategori }}" @selected(old('id_kategori', $laptop->id_kategori) == $k->id_kategori)>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="actions">
                <a href="{{ route('laptop.index') }}" class="btn-back">Batal</a>
                <button type="submit" class="btn-save">Update Alat</button>
            </div>
        </form>
    </section>
</div>
@endsection
