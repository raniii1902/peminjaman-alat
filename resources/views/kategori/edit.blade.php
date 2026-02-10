@extends('layouts.admin')

@section('content')
<h1>Edit Kategori</h1>

@if ($errors->any())
    <div style="background:#f8d7da;color:#721c24;padding:10px;margin-bottom:15px;border-radius:8px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="text" name="nama_kategori" value="{{ $kategori->nama_kategori }}" required style="padding:10px;width:300px;margin-right:10px;border-radius:8px;border:1px solid #ccc;">
    <button type="submit" class="btn-add"><i class="fa-solid fa-pen"></i> Update</button>
</form>
@endsection
