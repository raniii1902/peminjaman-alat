@extends('layouts.admin')

@section('title', 'Kelola User')

@section('styles')
<style>
    .user-page { max-width: 1200px; display: grid; gap: 18px; }
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
    .btn-add-new {
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
    .alert-success {
        background: #dcfce7;
        border: 1px solid #86efac;
        color: #166534;
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .table-container {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
    }
    .table-wrap { overflow-x: auto; }
    table { width: 100%; min-width: 920px; border-collapse: collapse; }
    thead { background: #6C63FF; color: #fff; }
    th, td { padding: 14px 16px; text-align: left; font-size: 14px; border-bottom: 1px solid #e2e8f0; }
    tbody tr:hover { background: #f8fafc; }
    .role-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        text-transform: capitalize;
    }
    .role-badge.admin { background: #ede9fe; color: #5b21b6; }
    .role-badge.petugas { background: #fef3c7; color: #b45309; }
    .role-badge.peminjam { background: #dbeafe; color: #1d4ed8; }
    .action-buttons { display: inline-flex; gap: 8px; flex-wrap: wrap; }
    .btn-action {
        padding: 7px 12px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }
    .btn-edit { background: #eef2ff; color: #4c51bf; }
    .btn-delete { background: #fee2e2; color: #991b1b; }
    .empty-state { text-align: center; padding: 28px 20px; color: #64748b; }
    .empty-state i { font-size: 40px; color: #cbd5e0; margin-bottom: 10px; }
</style>
@endsection

@section('content')
<div class="user-page">
    <section class="hero">
        <div>
            <h1><i class="fas fa-users"></i> Kelola User</h1>
            <p>Pantau, ubah, dan kelola akun pengguna sistem.</p>
        </div>
        <a href="{{ route('user.create') }}" class="btn-add-new">
            <i class="fas fa-user-plus"></i> Tambah User
        </a>
    </section>

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <section class="table-container">
        <div class="table-wrap">
            @if($user->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Terdaftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user as $index => $u)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $u->nama_lengkap }}</strong></td>
                                <td><code style="background:#f1f5f9;padding:4px 8px;border-radius:6px;">{{ $u->username }}</code></td>
                                <td><span class="role-badge {{ $u->role }}">{{ $u->role }}</span></td>
                                <td>{{ optional($u->created_at)->format('d M Y') ?? '-' }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('user.edit', $u->id_user) }}" class="btn-action btn-edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('user.destroy', $u->id_user) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete" onclick="return confirm('Yakin ingin menghapus user ini?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <p>Belum ada user terdaftar.</p>
                    <a href="{{ route('user.create') }}" class="btn-add-new">
                        <i class="fas fa-user-plus"></i> Tambah User Pertama
                    </a>
                </div>
            @endif
        </div>
    </section>
</div>
@endsection

