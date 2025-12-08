<?php

namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriKlinisController extends Controller
{
    public function index()
    {
        // Ambil semua kategori klinis dengan kode tindakan terapi
        $kategoriKlinis = DB::table('kategori_klinis')
            ->leftJoin('kode_tindakan_terapi', 'kategori_klinis.idkategori_klinis', '=', 'kode_tindakan_terapi.idkategori_klinis')
            ->select(
                'kategori_klinis.idkategori_klinis',
                'kategori_klinis.nama_kategori_klinis',
                DB::raw('GROUP_CONCAT(CONCAT(kode_tindakan_terapi.kode, " - ", kode_tindakan_terapi.deskripsi_tindakan_terapi) SEPARATOR "||") as kode_list')
            )
            ->groupBy('kategori_klinis.idkategori_klinis', 'kategori_klinis.nama_kategori_klinis')
            ->get();

        return view('admin.kategoriklinis.index', compact('kategoriKlinis'));
    }

    public function create()
    {
        return view('admin.kategoriklinis.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori_klinis' => 'required|string|max:50|unique:kategori_klinis,nama_kategori_klinis',
        ], [
            'nama_kategori_klinis.required' => 'Nama kategori klinis wajib diisi',
            'nama_kategori_klinis.unique' => 'Nama kategori klinis sudah ada',
            'nama_kategori_klinis.max' => 'Nama kategori klinis maksimal 50 karakter'
        ]);

        // Ambil ID terakhir dan tambah 1
        $lastId = DB::table('kategori_klinis')->max('idkategori_klinis') ?? 0;
        $newId = $lastId + 1;

        DB::table('kategori_klinis')->insert([
            'idkategori_klinis' => $newId,
            'nama_kategori_klinis' => ucwords(strtolower($validated['nama_kategori_klinis']))
        ]);
        
        return redirect()->route('kategoriklinis.index')
                         ->with('success', 'Data kategori klinis berhasil ditambahkan!');
    }

    public function show($id)
    {
        $kategoriKlinis = DB::table('kategori_klinis')
            ->where('idkategori_klinis', $id)
            ->first();
        
        if (!$kategoriKlinis) {
            return redirect()->route('kategoriklinis.index')
                           ->with('error', 'Data tidak ditemukan!');
        }
        
        return view('admin.kategoriklinis.show', compact('kategoriKlinis'));
    }

    public function edit($id)
    {
        $kategoriKlinis = DB::table('kategori_klinis')
            ->where('idkategori_klinis', $id)
            ->first();
        
        if (!$kategoriKlinis) {
            return redirect()->route('kategoriklinis.index')
                           ->with('error', 'Data tidak ditemukan!');
        }
        
        return view('admin.kategoriklinis.edit', compact('kategoriKlinis'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_kategori_klinis' => 'required|string|max:50|unique:kategori_klinis,nama_kategori_klinis,' . $id . ',idkategori_klinis',
        ], [
            'nama_kategori_klinis.required' => 'Nama kategori klinis wajib diisi',
            'nama_kategori_klinis.unique' => 'Nama kategori klinis sudah ada',
            'nama_kategori_klinis.max' => 'Nama kategori klinis maksimal 50 karakter'
        ]);

        DB::table('kategori_klinis')
            ->where('idkategori_klinis', $id)
            ->update([
                'nama_kategori_klinis' => ucwords(strtolower($validated['nama_kategori_klinis']))
            ]);
        
        return redirect()->route('kategoriklinis.index')
                         ->with('success', 'Data kategori klinis berhasil diupdate!');
    }

    public function destroy($id)
    {
        try {
            // Cek apakah ada kode_tindakan_terapi yang menggunakan kategori klinis ini
            $kodeTindakanCount = DB::table('kode_tindakan_terapi')
                                   ->where('idkategori_klinis', $id)
                                   ->count();
            
            if ($kodeTindakanCount > 0) {
                return redirect()->route('kategoriklinis.index')
                                 ->with('error', 'Data tidak dapat dihapus! Masih ada ' . $kodeTindakanCount . ' kode tindakan/terapi yang menggunakan kategori klinis ini.');
            }
            
            DB::table('kategori_klinis')
                ->where('idkategori_klinis', $id)
                ->delete();
            
            return redirect()->route('kategoriklinis.index')
                             ->with('success', 'Data kategori klinis berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('kategoriklinis.index')
                             ->with('error', 'Gagal menghapus data! Error: ' . $e->getMessage());
        }
    }

}
