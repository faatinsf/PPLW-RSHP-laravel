<?php

namespace App\Http\Controllers;
        
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{   
    public function index()
{
    $roles = DB::table('role')
        ->leftJoin('role_user', 'role.idrole', '=', 'role_user.idrole')
        ->leftJoin('user', 'role_user.iduser', '=', 'user.iduser')
        ->select(
            'role.*',
            DB::raw('COUNT(user.iduser) as jumlah_user')
        )
        ->groupBy('role.idrole')
        ->get();

    return view('admin.role.index', compact('roles'));
}



    public function create()
    {
        return view('admin.role.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateRole($request);
        $this->createRole($validated);
        
        return redirect()->route('role.index')
                         ->with('success', 'Data role berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $role = DB::table('role')->where('idrole', $id)->first();
        return view('admin.role.edit', compact('role'));
    }

     public function update(Request $request, $id)
    {
        $validated = $this->validateRoleUpdate($request, $id);
        $this->updateRole($id, $validated);
        
        return redirect()->route('role.index')
                         ->with('success', 'Data role berhasil diupdate!');
    }
    
    public function destroy($id)
    {
        try {
            DB::table('role')->where('idrole', $id)->delete();
            return redirect()->route('role.index')
                             ->with('success', 'Data role berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('role.index')
                             ->with('error', 'Gagal menghapus data!');
        }
    }

    private function validateRole($request)
    {
        return $request->validate([
            'nama_role' => 'required|string|max:50|unique:role,nama_role',
            'keterangan' => 'nullable|string|max:255'
        ]);
    }

    private function validateRoleUpdate($request, $id)
    {
        return $request->validate([
            'nama_role' => 'required|string|max:50|unique:role,nama_role,' . $id,
            'keterangan' => 'nullable|string|max:255'
        ]);
    }

    private function formatNamaRole($nama)
    {
        return ucwords(strtolower($nama));
    }

    private function createRole($data)
    {
        DB::table('role')->insert([
            'nama_role' => $this->formatNamaRole($data['nama_role']),
            'keterangan' => $data['keterangan'] ?? null,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    private function updateRole($id, $data)
    {
        DB::table('role')
            ->where('idrole', $id)
            ->update([
                'nama_role' => $this->formatNamaRole($data['nama_role']),
                'keterangan' => $data['keterangan'] ?? null,
                'updated_at' => now()
            ]);
    }
}
