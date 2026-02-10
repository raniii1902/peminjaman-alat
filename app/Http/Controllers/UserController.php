<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return view('user.index', compact('user'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'password'     => bcrypt($request->password),
            'role'         => $request->role,
        ]);

        return redirect()->route('user.index')
            ->with('success','User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $u = User::where('id_user', $id)->first();
        return view('user.edit', compact('u'));
    }

    public function update(Request $request, $id)
    {
        $u = User::where('id_user', $id)->first();

        $u->update([
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'role'         => $request->role,
        ]);

        return redirect()->route('user.index');
    }

    public function destroy($id)
    {
        User::where('id_user', $id)->delete();
        return redirect()->route('user.index');
    }
}
