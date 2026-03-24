@extends('layouts.admin')

@section('content')

<style>
    body {
        background: #f4f6fb;
    }

    .card-form {
        max-width: 1200px;
        margin: 60px auto;
        background: #ffffff;
        border-radius: 25px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.12);
        padding: 60px 80px;
    }

    .card-form h2 {
        margin-bottom: 40px;
        font-weight: 800;
        color: #333;
        font-size: 34px;
    }

    .form-group {
        margin-bottom: 35px;
    }

    label {
        font-weight: 700;
        font-size: 18px;
        margin-bottom: 12px;
        display: block;
        color: #444;
    }

    input, select {
        width: 100%;
        padding: 20px 22px;
        border-radius: 15px;
        border: 1px solid #ddd;
        background: #f9f9ff;
        font-size: 18px;
        transition: 0.3s;
    }

    input:focus, select:focus {
        border-color: #6C63FF;
        background: #fff;
        box-shadow: 0 0 0 5px rgba(108,99,255,0.2);
        outline: none;
    }

    .actions {
        margin-top: 50px;
        display: flex;
        justify-content: flex-end;
        gap: 30px;
    }

    .btn-back {
        background: #eaeaea;
        padding: 14px 26px;
        border-radius: 12px;
        text-decoration: none;
        color: #333;
        font-weight: 600;
        font-size: 16px;
        border: none;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-back:hover {
        background: #d5d5d5;
    }

    .btn-save {
        background: #6C63FF;
        color: white;
        border: none;
        padding: 14px 32px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 18px;
        cursor: pointer;
        transition: .3s;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(108,99,255,0.35);
    }

    .info-box {
        background: #ECF0FE;
        border-left: 4px solid #6C63FF;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 25px;
        font-size: 14px;
        color: #334155;
    }

    .error-message {
        background: #fee2e2;
        color: #991b1b;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: 1px solid #fecaca;
    }

    @media(max-width: 1024px){
        .card-form {
            padding: 40px 50px;
            margin: 40px 20px;
        }

        .card-form h2 {
            font-size: 28px;
        }

        label, input, select, .btn-save {
            font-size: 16px;
        }

        .btn-back, .btn-save {
            padding: 12px 22px;
        }
    }

    @media(max-width: 768px){
        .card-form {
            padding: 30px 25px;
            margin: 30px 10px;
        }

        .card-form h2 {
            font-size: 24px;
        }

        label, input, select, .btn-save {
            font-size: 14px;
        }

        .btn-back, .btn-save {
            padding: 10px 18px;
        }
    }
</style>

<div class="card-form">
    <h2><i class="fas fa-book-open"></i> Pinjam Alat PPLG</h2>

    <div class="info-box">
        <i class="fas fa-info-circle"></i> Pilih alat seperti laptop atau proyektor yang ingin dipinjam dari daftar di bawah
    </div>

    @if ($errors->any())
        <div class="error-message">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('peminjaman.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="id_laptop">Pilih Alat <span style="color: #dc2626;">*</span></label>
            <select id="id_laptop" name="id_laptop" required>
                <option value="">-- Pilih Alat --</option>
                @forelse($laptop as $l)
                    <option value="{{ $l->id_laptop }}">
                        {{ $l->nama_laptop }} (Stok: {{ $l->stok }}) - {{ $l->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                    </option>
                @empty
                    <option value="" disabled>Tidak ada alat tersedia</option>
                @endforelse
            </select>
        </div>

        <div class="actions">
            <a href="{{ route('peminjaman.index') }}" class="btn-back">Batal</a>
            <button type="submit" class="btn-save"><i class="fas fa-check-circle"></i> Pinjam Sekarang</button>
        </div>
    </form>
</div>

@endsection
