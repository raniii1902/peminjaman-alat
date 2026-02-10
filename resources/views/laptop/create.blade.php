@extends('layouts.admin')

@section('content')

<style>
    body {
        background: #f4f6fb;
    }

    .card-form {
        max-width: 1200px; /* super lebar */
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
        font-size: 34px; /* super besar */
    }

    .form-group {
        margin-bottom: 35px;
    }

    label {
        font-weight: 700;
        font-size: 18px; /* lebih besar */
        margin-bottom: 12px;
        display: block;
        color: #444;
    }

    input, select {
        width: 100%;
        padding: 20px 22px; /* sangat lega */
        border-radius: 15px;
        border: 1px solid #ddd;
        background: #f9f9ff;
        font-size: 18px; /* besar */
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
        display: flex;               /* bikin flex container */
        justify-content: flex-end;   /* tombol tetap di kanan */
        gap: 30px;                   /* jarak antar tombol */
    }

    .btn-back {
        background: #eaeaea;
        padding: 14px 26px;
        border-radius: 12px;
        text-decoration: none;
        color: #333;
        font-weight: 600;
        font-size: 16px;
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
    <h2>Tambah Laptop</h2>

    <form action="{{ route('laptop.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Nama Laptop</label>
            <input type="text" name="nama_laptop" placeholder="Contoh: Asus VivoBook" required>
        </div>

        <div class="form-group">
            <label>Stok Laptop</label>
            <input type="number" name="stok" placeholder="Masukkan jumlah stok" required>
        </div>

        <div class="form-group">
            <label>Kategori Laptop</label>
            <select name="id_kategori" required>
                <option value="" disabled selected>-- Pilih Kategori Laptop --</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->id_kategori }}">
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="actions">
            <a href="{{ route('laptop.index') }}" class="btn-back">Batal</a>
            <button type="submit" class="btn-save">Simpan Laptop</button>
        </div>
    </form>
</div>

@endsection
