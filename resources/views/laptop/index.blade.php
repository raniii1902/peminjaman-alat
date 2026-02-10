@extends('layouts.admin')

@section('content')

<h2 style="margin-bottom:25px;">Daftar Laptop</h2>

<a href="{{ route('laptop.create') }}" style="
    display:inline-block;
    margin-bottom:15px;
    background:#6C63FF;
    color:white;
    padding:10px 15px;
    border-radius:8px;
    text-decoration:none;
">
    + Tambah Laptop
</a>

<table style="width:100%; border-collapse: collapse; background:white; border-radius:10px; overflow:hidden;">
    <thead style="background:#6C63FF; color:white;">
        <tr>
            <th style="padding:12px;">No</th>
            <th style="padding:12px;">Nama Laptop</th>
            <th style="padding:12px;">Kategori</th>
            <th style="padding:12px;">Stok</th>
            <th style="padding:12px;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($laptops as $no => $laptop)
        <tr style="border-bottom:1px solid #eee;">
            <td style="padding:12px;">{{ $no+1 }}</td>
            <td style="padding:12px;">{{ $laptop->nama_laptop }}</td>
            <td style="padding:12px;">{{ $laptop->kategori->nama_kategori }}</td>
            <td style="padding:12px;">{{ $laptop->stok }}</td>
            <td style="padding:12px;">
                <a href="{{ route('laptop.edit',$laptop->id_laptop) }}">Edit</a> |
                <form action="{{ route('laptop.destroy',$laptop->id_laptop) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="border:none;background:none;color:red;">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
