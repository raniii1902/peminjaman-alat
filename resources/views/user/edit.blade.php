@extends('layouts.admin')

@section('content')

<div class="form-card-wide" style="margin:auto;">
    <h2>Edit User</h2>

    <form action="{{ route('user.update', $u->id_user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid-2">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ $u->nama_lengkap }}" required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="{{ $u->username }}" required>
            </div>

            <div class="form-group">
                <label>Role</label>
                <select name="role">
                    <option value="admin" {{ $u->role=='admin'?'selected':'' }}>Admin</option>
                    <option value="petugas" {{ $u->role=='petugas'?'selected':'' }}>Petugas</option>
                    <option value="peminjam" {{ $u->role=='peminjam'?'selected':'' }}>Peminjam</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn-save">Update User</button>
    </form>
</div>

@endsection
