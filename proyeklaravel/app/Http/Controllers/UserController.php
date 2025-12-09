<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // 🧩 Tampilkan daftar user di halaman
    public function index()
    {
        // Ambil semua user beserta relasi role-nya
        $users = User::with(['roleUser.role', 'pemilik'])->get();

        return view('admin.user.index', compact('users'));
    }

    public function create()
{
    $roles = DB::table('role')->get();
    return view('admin.user.create', compact('roles'));
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
    

    // 🧩 Hapus user
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus!');
    }

    
    public function edit($id)
    {
        $user = DB::table('user')->where('iduser', $id)->first();
        $roles = DB::table('role')->get();
        return view('admin.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $validated = $this->validateUserUpdate($request, $id);
        $this->updateUser($id, $validated);
        
        return redirect()->route('user.index')
                         ->with('success', 'Data user berhasil diupdate!');
    }

    public function editPassword($id)
    {
        $user = DB::table('user')->where('iduser', $id)->first();
        return view('admin.user.edit-password', compact('user'));
    }

    public function updatePassword(Request $request, $id)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required'
        ]);

        DB::table('user')
            ->where('iduser', $id)
            ->update([
                'password' => Hash::make($validated['password']),
                'updated_at' => now()
            ]);
        
        return redirect()->route('user.index')
                         ->with('success', 'Password berhasil diubah!');
    }

    private function validateUserUpdate($request, $id)
    {
        return $request->validate([
            'nama_user' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:user,username,' . $id . ',iduser',
            'email' => 'required|email|max:100|unique:user,email,' . $id . ',iduser',
            'idrole' => 'required|exists:role,idrole'
        ]);
    }

    private function updateUser($id, $data)
    {
        DB::table('user')
            ->where('iduser', $id)
            ->update([
                'nama_user' => $data['nama_user'],
                'username' => $data['username'],
                'email' => $data['email'],
                'idrole' => $data['idrole'],
                'updated_at' => now()
            ]);
    }
}

