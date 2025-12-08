<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KodeTindakanTerapiController extends Controller
{
    public function index()
    {
        // Ambil data dengan JOIN
        $kodeTindakan = DB::table('kode_tindakan_terapi')
            ->leftJoin('kategori', 'kode_tindakan_terapi.idkategori', '=', 'kategori.idkategori')
            ->leftJoin('kategori_klinis', 'kode_tindakan_terapi.idkategori_klinis', '=', 'kategori_klinis.idkategori_klinis')
            ->select(
                'kode_tindakan_terapi.*',
                'kategori.nama_kategori',
                'kategori_klinis.nama_kategori_klinis'
            )
            ->orderBy('kode_tindakan_terapi.kode', 'asc')
            ->get();

        return view('admin.kodetindakanterapi.index', compact('kodeTindakan'));
    }

    public function indexx()
    {
        // Untuk dokter
        $kodeTindakan = DB::table('kode_tindakan_terapi')
            ->leftJoin('kategori', 'kode_tindakan_terapi.idkategori', '=', 'kategori.idkategori')
            ->leftJoin('kategori_klinis', 'kode_tindakan_terapi.idkategori_klinis', '=', 'kategori_klinis.idkategori_klinis')
            ->select(
                'kode_tindakan_terapi.*',
                'kategori.nama_kategori',
                'kategori_klinis.nama_kategori_klinis'
            )
            ->orderBy('kode_tindakan_terapi.kode', 'asc')
            ->get();

        return view('dokter.kodetindakanterapii.index', compact('kodeTindakan'));
    }

    public function create()
    {
        // Ambil data kategori dan kategori klinis untuk dropdown
        $kategori = DB::table('kategori')->orderBy('nama_kategori', 'asc')->get();
        $kategoriKlinis = DB::table('kategori_klinis')->orderBy('nama_kategori_klinis', 'asc')->get();

        return view('admin.kodetindakanterapi.create', compact('kategori', 'kategoriKlinis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:5|unique:kode_tindakan_terapi,kode',
            'deskripsi_tindakan_terapi' => 'required|string|max:1000',
            'idkategori' => 'required|exists:kategori,idkategori',
            'idkategori_klinis' => 'required|exists:kategori_klinis,idkategori_klinis',
        ], [
            'kode.required' => 'Kode wajib diisi',
            'kode.unique' => 'Kode sudah digunakan',
            'kode.max' => 'Kode maksimal 5 karakter',
            'deskripsi_tindakan_terapi.required' => 'Deskripsi wajib diisi',
            'deskripsi_tindakan_terapi.max' => 'Deskripsi maksimal 1000 karakter',
            'idkategori.required' => 'Kategori wajib dipilih',
            'idkategori.exists' => 'Kategori tidak valid',
            'idkategori_klinis.required' => 'Kategori klinis wajib dipilih',
            'idkategori_klinis.exists' => 'Kategori klinis tidak valid',
        ]);

        // Ambil ID terakhir dan tambah 1
        $lastId = DB::table('kode_tindakan_terapi')->max('idkode_tindakan_terapi') ?? 0;
        $newId = $lastId + 1;

        DB::table('kode_tindakan_terapi')->insert([
            'idkode_tindakan_terapi' => $newId,
            'kode' => strtoupper($validated['kode']),
            'deskripsi_tindakan_terapi' => $validated['deskripsi_tindakan_terapi'],
            'idkategori' => $validated['idkategori'],
            'idkategori_klinis' => $validated['idkategori_klinis'],
        ]);

        return redirect()->route('kodetindakanterapi.index')
                         ->with('success', 'Data kode tindakan/terapi berhasil ditambahkan!');
    }

    public function show($id)
    {
        $kodeTindakan = DB::table('kode_tindakan_terapi')
            ->leftJoin('kategori', 'kode_tindakan_terapi.idkategori', '=', 'kategori.idkategori')
            ->leftJoin('kategori_klinis', 'kode_tindakan_terapi.idkategori_klinis', '=', 'kategori_klinis.idkategori_klinis')
            ->select(
                'kode_tindakan_terapi.*',
                'kategori.nama_kategori',
                'kategori_klinis.nama_kategori_klinis'
            )
            ->where('kode_tindakan_terapi.idkode_tindakan_terapi', $id)
            ->first();

        if (!$kodeTindakan) {
            return redirect()->route('kodetindakanterapi.index')
                           ->with('error', 'Data tidak ditemukan!');
        }

        return view('admin.kodetindakanterapi.show', compact('kodeTindakan'));
    }

    public function edit($id)
    {
        $kodeTindakan = DB::table('kode_tindakan_terapi')
            ->where('idkode_tindakan_terapi', $id)
            ->first();

        if (!$kodeTindakan) {
            return redirect()->route('kodetindakanterapi.index')
                           ->with('error', 'Data tidak ditemukan!');
        }

        $kategori = DB::table('kategori')->orderBy('nama_kategori', 'asc')->get();
        $kategoriKlinis = DB::table('kategori_klinis')->orderBy('nama_kategori_klinis', 'asc')->get();

        return view('admin.kodetindakanterapi.edit', compact('kodeTindakan', 'kategori', 'kategoriKlinis'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:5|unique:kode_tindakan_terapi,kode,' . $id . ',idkode_tindakan_terapi',
            'deskripsi_tindakan_terapi' => 'required|string|max:1000',
            'idkategori' => 'required|exists:kategori,idkategori',
            'idkategori_klinis' => 'required|exists:kategori_klinis,idkategori_klinis',
        ], [
            'kode.required' => 'Kode wajib diisi',
            'kode.unique' => 'Kode sudah digunakan',
            'deskripsi_tindakan_terapi.required' => 'Deskripsi wajib diisi',
            'idkategori.required' => 'Kategori wajib dipilih',
            'idkategori_klinis.required' => 'Kategori klinis wajib dipilih',
        ]);

        DB::table('kode_tindakan_terapi')
            ->where('idkode_tindakan_terapi', $id)
            ->update([
                'kode' => strtoupper($validated['kode']),
                'deskripsi_tindakan_terapi' => $validated['deskripsi_tindakan_terapi'],
                'idkategori' => $validated['idkategori'],
                'idkategori_klinis' => $validated['idkategori_klinis'],
            ]);

        return redirect()->route('kodetindakanterapi.index')
                         ->with('success', 'Data kode tindakan/terapi berhasil diupdate!');
    }

    public function destroy($id)
    {
        try {
            // Cek apakah ada detail_rekam_medis yang menggunakan kode tindakan terapi ini
            $detailRekamCount = DB::table('detail_rekam_medis')
                                  ->where('idkode_tindakan_terapi', $id)
                                  ->count();

            if ($detailRekamCount > 0) {
                return redirect()->route('kodetindakanterapi.index')
                                 ->with('error', 'Data tidak dapat dihapus! Masih ada ' . $detailRekamCount . ' detail rekam medis yang menggunakan kode tindakan/terapi ini.');
            }

            DB::table('kode_tindakan_terapi')
                ->where('idkode_tindakan_terapi', $id)
                ->delete();

            return redirect()->route('kodetindakanterapi.index')
                             ->with('success', 'Data kode tindakan/terapi berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('kodetindakanterapi.index')
                             ->with('error', 'Gagal menghapus data! Error: ' . $e->getMessage());
        }
    }
}               