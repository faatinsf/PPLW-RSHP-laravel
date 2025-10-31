<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // 🧩 Tampilkan semua role beserta user yang memiliki role tersebut
    public function index()
    {
        // Ambil semua role + relasi user-nya
        $roles = Role::with(['roleUsers.user'])->get();

        // Tampilkan ke view role/index.blade.php
        return view('admin.role.index', compact('roles'));
    }

    // 🧩 Simpan role baru dari form
    public function store(Request $request)
    {
        $request->validate([
            'nama_role' => 'required|string|max:255|unique:role,nama_role',
        ]);

        Role::create(['nama_role' => $request->nama_role]);

        return redirect()->route('admin.role.index')->with('success', 'Role berhasil ditambahkan!');
    }

    // 🧩 Tampilkan detail role
    public function show($id)
    {
        $role = Role::with(['roleUsers.user'])->findOrFail($id);
        return view('role.show', compact('role'));
    }

    // 🧩 Update role
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'nama_role' => 'required|string|max:255|unique:role,nama_role,' . $role->idrole . ',idrole',
        ]);

        $role->update(['nama_role' => $request->nama_role]);

        return redirect()->route('admin.role.index')->with('success', 'Role berhasil diperbarui!');
    }

    // 🧩 Hapus role
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('admin.role.index')->with('success', 'Role berhasil dihapus!');
    }
}
