@extends('layouts.admin')

@section('content')

<style>
    body {
        background: #f4f6fb;
    }

    .card-form {
        max-width: 950px;
        margin: 40px auto;
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        padding: 35px 45px;
    }

    .card-form h2 {
        font-weight: 700;
        color: #2f2f2f;
        margin-bottom: 8px;
    }

    .subtitle {
        color: #888;
        margin-bottom: 30px;
        font-size: 14px;
    }

    .grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }

    .form-group {
        margin-bottom: 22px;
    }

    label {
        font-size: 14px;
        font-weight: 600;
        color: #444;
        margin-bottom: 8px;
        display: block;
    }

    input, select {
        width: 100%;
        padding: 13px 15px;
        border-radius: 10px;
        border: 1px solid #ddd;
        background: #f9f9ff;
        transition: 0.25s;
        font-size: 14px;
    }

    input:focus, select:focus {
        border-color: #6C63FF;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(108,99,255,0.15);
        outline: none;
    }

    .note {
        font-size: 12px;
        color: #999;
        margin-top: 5px;
    }

    .error-text {
        color: #e74c3c;
        font-size: 13px;
        margin-top: 5px;
    }

    .actions {
        margin-top: 35px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-back {
        background: #eaeaea;
        padding: 11px 20px;
        border-radius: 8px;
        text-decoration: none;
        color: #333;
        font-weight: 500;
    }

    .btn-save {
        background: #6C63FF;
        color: white;
        border: none;
        padding: 11px 22px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: .3s;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(108,99,255,0.3);
    }

    @media(max-width:768px){
        .grid{
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="card-form">
    <h2>Tambah User Baru</h2>
    <div class="subtitle">Isi data di bawah untuk menambahkan pengguna ke sistem.</div>

    <form action="{{ route('user.store') }}" method="POST">
        @csrf

        <div class="grid">
            <!-- KIRI -->
            <div>
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Contoh: Maharani Putri" required>
                    @error('nama_lengkap')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Minimal 8 karakter" required>
                    <div class="note">Gunakan kombinasi huruf & angka</div>
                    @error('password')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- KANAN -->
            <div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="Tanpa spasi" required>
                    @error('username')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Role / Hak Akses</label>
                    <select name="role">
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                        <option value="peminjam">Peminjam</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="actions">
            <a href="{{ route('user.index') }}" class="btn-back">Batal</a>
            <button type="submit" class="btn-save">Simpan User</button>
        </div>
    </form>
</div>

@endsection
