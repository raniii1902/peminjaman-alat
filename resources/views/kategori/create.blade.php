@extends('layouts.admin')

@section('content')
<h1>Tambah Kategori</h1>

<!-- Tampilkan error validasi -->
@if ($errors->any())
    <div style="background:#f8d7da;color:#721c24;padding:10px;margin-bottom:15px;border-radius:8px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Form Tambah Kategori -->
<form action="{{ route('kategori.store') }}" method="POST">
    @csrf
    <input type="text" 
           name="nama_kategori" 
           placeholder="Nama Kategori" 
           required 
           style="padding:10px;width:300px;margin-right:10px;border-radius:8px;border:1px solid #ccc;">
    
    <button type="submit" class="btn-add">
        <i class="fa-solid fa-plus"></i> Tambah
    </button>
</form>
@endsection

@section('styles')
<style>
    .btn-add {
        background: #6C63FF;
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: 0.3s;
    }
    .btn-add:hover {
        background: #5A54E8;
    }
    input[type="text"] {
        font-size: 14px;
    }
</style>
@endsection
