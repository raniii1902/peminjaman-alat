<?php

namespace App\Http\Controllers;

use App\Models\Laptop;
use App\Models\Kategori;
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
        Laptop::create($request->all());
        return redirect('/laptop')->with('success', 'Laptop ditambah');
    }

    public function edit($id)
    {
        $laptop = Laptop::find($id);
        $kategori = Kategori::all();
        return view('laptop.edit', compact('laptop','kategori'));
    }

    public function update(Request $request, $id)
    {
        Laptop::find($id)->update($request->all());
        return redirect('/laptop')->with('success', 'Laptop diupdate');
    }

    public function destroy($id)
    {
        Laptop::find($id)->delete();
        return redirect('/laptop')->with('success', 'Laptop dihapus');
    }
}
