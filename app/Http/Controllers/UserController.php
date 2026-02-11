<?php

namespace App\Http\Controllers;

use App\Models\LogAktifitas;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = User::orderBy('created_at', 'desc')->get();
        return view('user.index', compact('user'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|min:4',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,petugas,peminjam',
        ]);

        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        if (auth()->check()) {
            LogAktifitas::create([
                'id_user' => auth()->user()->id_user,
                'aksi_admin' => 'Menambah user: ' . $user->nama_lengkap,
                'waktu' => now(),
            ]);
        }

        return redirect()->route('user.index')
            ->with('success', '✓ User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $u = User::findOrFail($id);
        return view('user.edit', compact('u'));
    }

    public function update(Request $request, $id)
    {
        $u = User::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username,' . $id . ',id_user|min:4',
            'role' => 'required|in:admin,petugas,peminjam',
        ]);

        $u->update([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'role' => $request->role,
        ]);

        if (auth()->check()) {
            LogAktifitas::create([
                'id_user' => auth()->user()->id_user,
                'aksi_admin' => 'Memperbarui user: ' . $u->nama_lengkap,
                'waktu' => now(),
            ]);
        }

        return redirect()->route('user.index')
            ->with('success', '✓ User berhasil diperbarui');
    }

    public function destroy($id)
    {
        $u = User::findOrFail($id);
        $nama = $u->nama_lengkap;
        $u->delete();

        if (auth()->check()) {
            LogAktifitas::create([
                'id_user' => auth()->user()->id_user,
                'aksi_admin' => 'Menghapus user: ' . $nama,
                'waktu' => now(),
            ]);
        }
        return redirect()->route('user.index')
            ->with('success', '✓ User berhasil dihapus');
    }
}
