<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\LogAktifitas;

class KategoriController extends Controller
{
    // Tampilkan semua kategori
    public function index()
    {
        $kategori = Kategori::all();
        return view('kategori.index', compact('kategori'));
    }

    // Tampilkan form tambah kategori
    public function create()
    {
        return view('kategori.create');
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori = Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        if (auth()->check()) {
            LogAktifitas::create([
                'id_user' => auth()->user()->id_user,
                'aksi_admin' => 'Menambah kategori: ' . $kategori->nama_kategori,
                'waktu' => now(),
            ]);
        }

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Tampilkan form edit kategori
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    // Update kategori
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        if (auth()->check()) {
            LogAktifitas::create([
                'id_user' => auth()->user()->id_user,
                'aksi_admin' => 'Memperbarui kategori: ' . $kategori->nama_kategori,
                'waktu' => now(),
            ]);
        }

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diupdate!');
    }

    // Hapus kategori
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $nama = $kategori->nama_kategori;
        $kategori->delete();

        if (auth()->check()) {
            LogAktifitas::create([
                'id_user' => auth()->user()->id_user,
                'aksi_admin' => 'Menghapus kategori: ' . $nama,
                'waktu' => now(),
            ]);
        }

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
