<?php

namespace App\Http\Controllers;

use App\Models\Laptop;
use App\Models\Kategori;
use App\Models\LogAktifitas;
use Illuminate\Http\Request;

class LaptopController extends Controller
{
    public function index()
    {
        $laptops = Laptop::with('kategori')->get();
        return view('laptop.index', compact('laptops'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('laptop.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_laptop' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'stok' => 'required|integer|min:0',
        ]);

        $laptop = Laptop::create($validated);

        if (auth()->check()) {
            LogAktifitas::create([
                'id_user' => auth()->user()->id_user,
                'aksi_admin' => 'Menambah alat inventaris: ' . $laptop->nama_laptop,
                'waktu' => now(),
            ]);
        }
        return redirect('/laptop')->with('success', 'Alat inventaris ditambahkan');
    }

    public function edit($id)
    {
        $laptop = Laptop::find($id);
        $kategori = Kategori::all();
        return view('laptop.edit', compact('laptop','kategori'));
    }

    public function update(Request $request, $id)
    {
        $laptop = Laptop::findOrFail($id);
        $validated = $request->validate([
            'nama_laptop' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'stok' => 'required|integer|min:0',
        ]);
        $laptop->update($validated);

        if (auth()->check()) {
            LogAktifitas::create([
                'id_user' => auth()->user()->id_user,
                'aksi_admin' => 'Memperbarui alat inventaris: ' . $laptop->nama_laptop,
                'waktu' => now(),
            ]);
        }
        return redirect('/laptop')->with('success', 'Alat inventaris diperbarui');
    }

    public function destroy($id)
    {
        $laptop = Laptop::findOrFail($id);
        $nama = $laptop->nama_laptop;
        $laptop->delete();

        if (auth()->check()) {
            LogAktifitas::create([
                'id_user' => auth()->user()->id_user,
                'aksi_admin' => 'Menghapus alat inventaris: ' . $nama,
                'waktu' => now(),
            ]);
        }
        return redirect('/laptop')->with('success', 'Alat inventaris dihapus');
    }
}
