@extends('layouts.peminjam')

@section('content')

<h2 style="margin-bottom:25px;">Menu Peminjam</h2>

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px;">
    <a href="{{ route('peminjam.alat') }}" style="display:block;background:white;padding:20px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.06);text-decoration:none;color:#2d3748;">
        <div style="font-weight:700;margin-bottom:8px;">Daftar Alat</div>
        <div style="font-size:13px;color:#718096;">Lihat daftar alat dan ketersediaan.</div>
    </a>
    <a href="{{ route('peminjam.ajukan') }}" style="display:block;background:white;padding:20px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.06);text-decoration:none;color:#2d3748;">
        <div style="font-weight:700;margin-bottom:8px;">Ajukan Peminjaman</div>
        <div style="font-size:13px;color:#718096;">Pilih alat, isi tanggal, kirim pengajuan.</div>
    </a>
    <a href="{{ route('peminjam.pengembalian') }}" style="display:block;background:white;padding:20px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.06);text-decoration:none;color:#2d3748;">
        <div style="font-weight:700;margin-bottom:8px;">Pengembalian</div>
        <div style="font-size:13px;color:#718096;">Konfirmasi pengembalian dan lihat status.</div>
    </a>
    <a href="{{ route('peminjam.peminjaman') }}" style="display:block;background:white;padding:20px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.06);text-decoration:none;color:#2d3748;">
        <div style="font-weight:700;margin-bottom:8px;">Peminjaman Saya</div>
        <div style="font-size:13px;color:#718096;">Lihat semua riwayat peminjaman.</div>
    </a>
</div>

@endsection
