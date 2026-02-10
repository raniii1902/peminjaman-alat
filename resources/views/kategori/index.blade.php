@extends('layouts.admin') <!-- pakai layout dashboard admin -->

@section('content')
<h1>Data Kategori</h1>

<!-- Notifikasi sukses -->
@if(session('success'))
    <div style="background:#d4edda;color:#155724;padding:10px;margin-bottom:15px;border-radius:8px;">
        {{ session('success') }}
    </div>
@endif

<!-- Tombol Tambah Kategori -->
<a href="{{ route('kategori.create') }}" class="btn-add"><i class="fa-solid fa-plus"></i> Tambah Kategori</a>

<!-- Tabel Data Kategori -->
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kategori</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($kategori as $index => $k)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $k->nama_kategori }}</td>
                <td>
    <a href="{{ route('kategori.edit', $k) }}" class="action-btn edit-btn">
        <i class="fa-solid fa-pen"></i> Edit
    </a>

    <form action="{{ route('kategori.destroy', $k) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button class="action-btn delete-btn" onclick="return confirm('Yakin ingin hapus?')">
            <i class="fa-solid fa-trash"></i> Hapus
        </button>
    </form>
</td>
                    <form action="{{ route('kategori.destroy', $k->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="action-btn delete-btn" onclick="return confirm('Yakin ingin hapus?')">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

@section('styles')
<style>
    .btn-add {
        background: #6C63FF;
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 500;
        margin-bottom: 20px;
        display: inline-block;
        transition: 0.3s;
    }

    .btn-add:hover {
        background: #5A54E8;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }

    table th, table td {
        padding: 15px 20px;
        text-align: left;
    }

    table th {
        background: #6C63FF;
        color: white;
        font-weight: 600;
    }

    table tr:nth-child(even) {
        background: #f9f9f9;
    }

    table tr:hover {
        background: #f1f1f1;
    }

    .action-btn {
        padding: 5px 12px;
        border-radius: 8px;
        color: white;
        text-decoration: none;
        font-size: 14px;
        margin-right: 5px;
        transition: 0.3s;
    }

    .edit-btn {
        background: #ffa500;
    }

    .edit-btn:hover {
        background: #ff8c00;
    }

    .delete-btn {
        background: #ff5e57;
    }

    .delete-btn:hover {
        background: #ff3b30;
    }
</style>
@endsection
