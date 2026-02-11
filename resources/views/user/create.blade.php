@extends('layouts.admin')

@section('title', 'Tambah User')

@section('styles')
<style>
    .user-form-page { max-width: 1000px; display: grid; gap: 18px; }
    .hero {
        background: linear-gradient(140deg, #1e3a8a 0%, #0f172a 100%);
        border-radius: 18px;
        padding: 22px;
        color: #f8fafc;
        box-shadow: 0 16px 34px rgba(15, 23, 42, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    .hero h1 { margin: 0 0 6px 0; font-size: 26px; font-weight: 800; }
    .hero p { margin: 0; color: #cbd5e1; font-size: 14px; }
    .btn-back {
        background: rgba(255,255,255,.16);
        border: 1px solid rgba(255,255,255,.35);
        color: #fff;
        padding: 10px 14px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 700;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
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
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 12px 14px;
        border-radius: 10px;
        margin-bottom: 14px;
        font-size: 13px;
    }
    .form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; }
    .form-group { display: grid; gap: 8px; }
    .form-label {
        font-weight: 700;
        color: #334155;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: .35px;
    }
    .required { color: #dc2626; }
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
    .form-note { font-size: 12px; color: #64748b; }
    .form-error { font-size: 12px; color: #dc2626; font-weight: 600; }
    .form-actions {
        margin-top: 16px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        flex-wrap: wrap;
    }
    .btn-cancel {
        background: #e2e8f0;
        color: #334155;
        padding: 9px 13px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 700;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-submit {
        background: #4f46e5;
        color: #fff;
        border: none;
        padding: 9px 14px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    @media (max-width: 900px) { .form-grid { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')
<div class="user-form-page">
    <section class="hero">
        <div>
            <h1><i class="fas fa-user-plus"></i> Tambah User</h1>
            <p>Tambahkan akun baru dengan role yang sesuai kebutuhan sistem.</p>
        </div>
        <a href="{{ route('user.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </section>

    <section class="form-card">
        @if($errors->any())
            <div class="error-box">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.store') }}" method="POST">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label" for="nama_lengkap">Nama Lengkap <span class="required">*</span></label>
                    <input class="form-input" type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Contoh: Maharani Putri" required>
                    @error('nama_lengkap') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="username">Username <span class="required">*</span></label>
                    <input class="form-input" type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Contoh: maharani123" required>
                    <div class="form-note">Minimal 4 karakter</div>
                    @error('username') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password <span class="required">*</span></label>
                    <input class="form-input" type="password" id="password" name="password" placeholder="Minimal 8 karakter" required>
                    <div class="form-note">Gunakan huruf, angka, dan simbol</div>
                    @error('password') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="role">Role <span class="required">*</span></label>
                    <select class="form-input" id="role" name="role" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="peminjam" {{ old('role') == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                    </select>
                    @error('role') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('user.index') }}" class="btn-cancel"><i class="fas fa-arrow-left"></i> Batal</a>
                <button type="submit" class="btn-submit"><i class="fas fa-check-circle"></i> Simpan</button>
            </div>
        </form>
    </section>
</div>
@endsection

