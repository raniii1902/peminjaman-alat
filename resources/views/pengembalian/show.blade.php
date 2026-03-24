@extends('layouts.admin')

@section('content')

<h2>Detail Pengembalian</h2>

<div style="background:white;padding:20px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.06);max-width:600px;">

    <p><b>Nama Peminjam:</b> {{ $peminjaman->user->nama_lengkap }}</p>
    <p><b>Alat:</b> {{ $peminjaman->laptop->nama_laptop }}</p>
    <p><b>Tanggal Pinjam:</b> {{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d M Y') }}</p>
    <p><b>Status:</b> {{ ucfirst($peminjaman->status) }}</p>

    <br>

    <a href="{{ route('peminjaman.index') }}" style="
        padding:8px 12px;
        background:#6C63FF;
        color:white;
        border-radius:6px;
        text-decoration:none;
    ">Kembali</a>

</div>

@endsection
