@extends('layouts.admin')

@section('title', 'Edit User')

@section('styles')
<style>
        .user-edit-page {
            max-width: 1100px;
            width: 100%;
        }

        .form-header {
            margin-bottom: 32px;
        }

        .form-title {
            font-size: 26px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 4px;
        }

        .form-subtitle {
            color: #64748b;
            font-size: 14px;
        }

        .card-form {
            background: white;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
            padding: 28px 30px;
        }

        .info-badge {
            background: #f0f4ff;
            border-left: 3px solid #667eea;
            padding: 12px 14px;
            border-radius: 6px;
            font-size: 13px;
            color: #4c51bf;
            margin-bottom: 20px;
        }

        .error-banner {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 24px;
        }

        .error-list {
            list-style: none;
        }

        .error-list li {
            margin-bottom: 6px;
            font-size: 13px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        label {
            display: block;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input, select {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 6px;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
        }

        .btn-cancel {
            background: #f1f5f9;
            color: #475569;
            padding: 11px 24px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #e2e8f0;
        }

        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 11px 28px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        @media (max-width: 768px) {
            .user-edit-page {
                max-width: 100%;
            }

            .card-form {
                padding: 22px;
            }
        }
    </style>
@endsection

@section('content')

<div class="user-edit-page">
    <div class="form-header">
        <h1 class="form-title"><i class="fas fa-user-edit"></i> Edit User</h1>
        <p class="form-subtitle">Ubah informasi pengguna di bawah</p>
    </div>

    <div class="card-form">
        <div class="info-badge">
            <i class="fas fa-info-circle"></i> ID: {{ $u->id_user }} | Terdaftar: {{ optional($u->created_at)->format('d M Y H:i') ?? '-' }}
        </div>

        @if($errors->any())
            <div class="error-banner">
                <strong>Terdapat Kesalahan</strong>
                <ul class="error-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.update', $u->id_user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap <span style="color:#dc2626;">*</span></label>
                <input 
                    type="text" 
                    id="nama_lengkap"
                    name="nama_lengkap" 
                    value="{{ old('nama_lengkap', $u->nama_lengkap) }}"
                    required
                >
                @error('nama_lengkap')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="username">Username <span style="color:#dc2626;">*</span></label>
                <input 
                    type="text" 
                    id="username"
                    name="username" 
                    value="{{ old('username', $u->username) }}"
                    required
                >
                @error('username')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="role">Role / Hak Akses <span style="color:#dc2626;">*</span></label>
                <select id="role" name="role" required>
                    <option value="admin" {{ old('role', $u->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="petugas" {{ old('role', $u->role) == 'petugas' ? 'selected' : '' }}>Petugas</option>
                    <option value="peminjam" {{ old('role', $u->role) == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                </select>
                @error('role')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('user.index') }}" class="btn-cancel">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
