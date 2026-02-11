@extends('layouts.petugas')

@section('content')

<h2 style="margin-bottom:25px;">Menu Petugas</h2>

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px;">
    <a href="{{ route('petugas.persetujuan') }}" style="display:block;background:white;padding:20px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.06);text-decoration:none;color:#2d3748;">
        <div style="font-weight:700;margin-bottom:8px;">Menyetujui Peminjaman</div>
        <div style="font-size:13px;color:#718096;">Cek alat belum kembali, cek keterlambatan, perbarui status pengembalian alat.</div>
    </a>
    <a href="{{ route('petugas.pengembalian') }}" style="display:block;background:white;padding:20px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.06);text-decoration:none;color:#2d3748;">
        <div style="font-weight:700;margin-bottom:8px;">Memantau Pengembalian</div>
        <div style="font-size:13px;color:#718096;">Pantau pengembalian, cek keterlambatan, dan update status.</div>
    </a>
    <a href="{{ route('petugas.laporan') }}" style="display:block;background:white;padding:20px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.06);text-decoration:none;color:#2d3748;">
        <div style="font-weight:700;margin-bottom:8px;">Mencetak Laporan</div>
        <div style="font-size:13px;color:#718096;">Pilih periode dan cetak atau unduh laporan.</div>
    </a>
</div>

@endsection
