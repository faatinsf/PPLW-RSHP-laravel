<?php

namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JenisHewanController extends Controller
{
    public function index()
    {
        $jenisHewan = DB::table('jenis_hewan')->get();
        return view('admin.jenis-hewan.index', compact('jenisHewan'));
    }

    public function create()
    {
        return view('admin.jenis-hewan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jenis_hewan' => 'required|string|max:100|unique:jenis_hewan,nama_jenis_hewan',
        ], [
            'nama_jenis_hewan.required' => 'Nama jenis hewan wajib diisi',
            'nama_jenis_hewan.unique' => 'Nama jenis hewan sudah ada'
        ]);

        DB::table('jenis_hewan')->insert([
            'nama_jenis_hewan' => ucwords(strtolower($validated['nama_jenis_hewan']))
        ]);
        
        return redirect()->route('jenis-hewan.index')
                         ->with('success', 'Data jenis hewan berhasil ditambahkan!');
    }

    public function show($id)
    {
        $jenisHewan = DB::table('jenis_hewan')->where('idjenis_hewan', $id)->first();
        return view('admin.jenis-hewan.show', compact('jenisHewan'));
    }

    public function edit($id)
    {
        $jenisHewan = DB::table('jenis_hewan')->where('idjenis_hewan', $id)->first();
        
        if (!$jenisHewan) {
            return redirect()->route('jenis-hewan.index')
                           ->with('error', 'Data tidak ditemukan!');
        }
        
        return view('admin.jenis-hewan.edit', compact('jenisHewan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_jenis_hewan' => 'required|string|max:100|unique:jenis_hewan,nama_jenis_hewan,' . $id . ',idjenis_hewan',
        ], [
            'nama_jenis_hewan.required' => 'Nama jenis hewan wajib diisi',
            'nama_jenis_hewan.unique' => 'Nama jenis hewan sudah ada'
        ]);

        DB::table('jenis_hewan')
            ->where('idjenis_hewan', $id)
            ->update([
                'nama_jenis_hewan' => ucwords(strtolower($validated['nama_jenis_hewan']))
            ]);
        
        return redirect()->route('jenis-hewan.index')
                         ->with('success', 'Data jenis hewan berhasil diupdate!');
    }

    public function destroy($id)
    {
        try {
            // Cek apakah ada ras_hewan yang menggunakan jenis_hewan ini
            $rasCount = DB::table('ras_hewan')
                         ->where('idjenis_hewan', $id)
                         ->count();
            
            if ($rasCount > 0) {
                return redirect()->route('jenis-hewan.index')
                                 ->with('error', 'Data tidak dapat dihapus! Masih ada ' . $rasCount . ' ras hewan yang menggunakan jenis hewan ini.');
            }
            
            DB::table('jenis_hewan')->where('idjenis_hewan', $id)->delete();
            return redirect()->route('jenis-hewan.index')
                             ->with('success', 'Data jenis hewan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('jenis-hewan.index')
                             ->with('error', 'Gagal menghapus data! Error: ' . $e->getMessage());
        }
    }
}