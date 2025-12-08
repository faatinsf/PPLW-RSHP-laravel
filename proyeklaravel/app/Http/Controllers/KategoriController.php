<?php

namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = DB::table('kategori')->get();
        return view('admin.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'nama_kategori.unique' => 'Nama kategori sudah ada'
        ]);

        // Ambil ID terakhir dan tambah 1
        $lastId = DB::table('kategori')->max('idkategori') ?? 0;
        $newId = $lastId + 1;

        DB::table('kategori')->insert([
            'idkategori' => $newId,
            'nama_kategori' => ucwords(strtolower($validated['nama_kategori']))
        ]);
        
        return redirect()->route('kategori.index')
                         ->with('success', 'Data kategori berhasil ditambahkan!');
    }

    public function show($id)
    {
        $kategori = DB::table('kategori')->where('idkategori', $id)->first();
        return view('admin.kategori.show', compact('kategori'));
    }

    public function edit($id)
    {
        $kategori = DB::table('kategori')->where('idkategori', $id)->first();
        
        if (!$kategori) {
            return redirect()->route('kategori.index')
                           ->with('error', 'Data tidak ditemukan!');
        }
        
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori,' . $id . ',idkategori',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'nama_kategori.unique' => 'Nama kategori sudah ada'
        ]);

        DB::table('kategori')
            ->where('idkategori', $id)
            ->update([
                'nama_kategori' => ucwords(strtolower($validated['nama_kategori']))
            ]);
        
        return redirect()->route('kategori.index')
                         ->with('success', 'Data kategori berhasil diupdate!');
    }

    public function destroy($id)
    {
        try {
            // Cek apakah ada kode_tindakan_terapi yang menggunakan kategori ini
            $kodeTindakanCount = DB::table('kode_tindakan_terapi')
                                   ->where('idkategori', $id)
                                   ->count();
            
            if ($kodeTindakanCount > 0) {
                return redirect()->route('kategori.index')
                                 ->with('error', 'Data tidak dapat dihapus! Masih ada ' . $kodeTindakanCount . ' kode tindakan/terapi yang menggunakan kategori ini.');
            }
            
            DB::table('kategori')->where('idkategori', $id)->delete();
            return redirect()->route('kategori.index')
                             ->with('success', 'Data kategori berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('kategori.index')
                             ->with('error', 'Gagal menghapus data! Error: ' . $e->getMessage());
        }
    }
}
