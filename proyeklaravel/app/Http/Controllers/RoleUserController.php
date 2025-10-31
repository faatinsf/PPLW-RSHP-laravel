<?php

namespace App\Http\Controllers;

use App\Models\RoleUser;
use Illuminate\Http\Request;

class RoleUserController extends Controller
{
    public function index()
    {
        // Ambil semua data role_user beserta relasi user dan role
        $roleUsers = RoleUser::with(['user', 'role'])->get();

        // Kirim ke view
        return view('admin.roleuser.index', compact('roleUsers'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'iduser' => 'required|exists:user,iduser',
            'idrole' => 'required|exists:role,idrole',
            'status' => 'required|string|max:50',
        ]);

        RoleUser::create($validated);
        return redirect()->route('admin.roleuser.index')->with('success', 'Role User berhasil ditambahkan');
    }

    public function show($id)
    {
        $roleUser = RoleUser::with(['user', 'role'])->findOrFail($id);
        return view('admin.roleuser.show', compact('roleUser'));
    }

    public function edit($id)
    {
        $roleUser = RoleUser::findOrFail($id);
        return view('admin.roleuser.edit', compact('roleUser'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'iduser' => 'required|exists:user,iduser',
            'idrole' => 'required|exists:role,idrole',
            'status' => 'required|string|max:50',
        ]);

        $roleUser = RoleUser::findOrFail($id);
        $roleUser->update($validated);

        return redirect()->route('admin.roleuser.index')->with('success', 'Role User berhasil diperbarui');
    }

    public function destroy($id)
    {
        $roleUser = RoleUser::findOrFail($id);
        $roleUser->delete();

        return redirect()->route('admin.roleuser.index')->with('success', 'Role User berhasil dihapus');
    }
}
