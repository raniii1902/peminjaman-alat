@extends('layouts.admin')

@section('content')
<div class="content">

    <div class="card">
        <div class="card-header">
            <h2>Data User</h2>
            <a href="{{ route('user.create') }}" class="btn-add">+ Tambah User</a>
        </div>

        <table class="table-user">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user as $i => $u)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $u->nama_lengkap }}</td>
                    <td>{{ $u->username }}</td>
                    <td>
                        <span class="badge">{{ ucfirst($u->role) }}</span>
                    </td>
                    <td class="aksi">
                        <a href="{{ route('user.edit', $u->id_user) }}" class="btn-edit">Edit</a>

                        <form action="{{ route('user.destroy', $u->id_user) }}" method="POST" onsubmit="return confirm('Hapus user ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
--