<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // 🧩 Tampilkan daftar user di halaman
    public function index()
    {
        // Ambil semua user beserta relasi role-nya
        $users = User::with(['roleUser.role', 'pemilik'])->get();

        return view('admin.user.index', compact('users'));
    }

    // 🧩 Simpan user baru dari form
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan!');
    }

    // 🧩 Tampilkan detail user
    public function show($id)
    {
        $user = User::with(['roleUser.role', 'pemilik'])->findOrFail($id);
        return view('user.show', compact('user'));
    }

    // 🧩 Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email,' . $user->iduser . ',iduser',
        ]);

        $user->update($request->only(['name', 'email']));

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui!');
    }

    // 🧩 Hapus user
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus!');
    }
}

