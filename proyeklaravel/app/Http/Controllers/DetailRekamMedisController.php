<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailRekamMedisController extends Controller
{
    /**
     * Display a listing of detail rekam medis.
     */
    public function index()
    {
        try {
            $detailRekamMedis = DB::table('detail_rekam_medis')
                ->join('rekam_medis', 'detail_rekam_medis.idrekam_medis', '=', 'rekam_medis.idrekam_medis')
                ->join('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
                ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
                ->join('user', 'pemilik.iduser', '=', 'user.iduser')
                ->join('kode_tindakan_terapi', 'detail_rekam_medis.idkode_tindakan_terapi', '=', 'kode_tindakan_terapi.idkode_tindakan_terapi')
                ->join('kategori', 'kode_tindakan_terapi.idkategori', '=', 'kategori.idkategori')
                ->join('kategori_klinis', 'kode_tindakan_terapi.idkategori_klinis', '=', 'kategori_klinis.idkategori_klinis')
                ->select(
                    'detail_rekam_medis.*',
                    'rekam_medis.created_at as tanggal_rekam_medis',
                    'rekam_medis.diagnosa',
                    'rekam_medis.idrekam_medis',
                    'pet.nama as nama_pet',
                    'user.nama as nama_pemilik',
                    'kode_tindakan_terapi.kode',
                    'kode_tindakan_terapi.deskripsi_tindakan_terapi',
                    'kategori.nama_kategori',
                    'kategori_klinis.nama_kategori_klinis'
                )
                ->orderBy('rekam_medis.created_at', 'desc')
                ->get();

            return view('admin.detailrekammedis.index', compact('detailRekamMedis'));
        } catch (\Exception $e) {
            return view('admin.detailrekammedis.index', ['detailRekamMedis' => collect([])])
                ->with('error', 'Gagal memuat data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new detail rekam medis.
     */
    public function create()
    {
        try {
            // Ambil rekam medis yang belum memiliki banyak detail
            $rekamMedisList = DB::table('rekam_medis')
                ->join('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
                ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
                ->join('user', 'pemilik.iduser', '=', 'user.iduser')
                ->select(
                    'rekam_medis.idrekam_medis',
                    'rekam_medis.created_at',
                    'rekam_medis.diagnosa',
                    'pet.nama as nama_pet',
                    'user.nama as nama_pemilik'
                )
                ->orderBy('rekam_medis.created_at', 'desc')
                ->get();

            // Ambil semua kode tindakan/terapi dengan kategori
            $kodeTindakanTerapi = DB::table('kode_tindakan_terapi')
                ->join('kategori', 'kode_tindakan_terapi.idkategori', '=', 'kategori.idkategori')
                ->join('kategori_klinis', 'kode_tindakan_terapi.idkategori_klinis', '=', 'kategori_klinis.idkategori_klinis')
                ->select(
                    'kode_tindakan_terapi.*',
                    'kategori.nama_kategori',
                    'kategori_klinis.nama_kategori_klinis'
                )
                ->orderBy('kategori.nama_kategori')
                ->orderBy('kode_tindakan_terapi.kode')
                ->get();

            // Ambil kategori untuk grouping
            $kategori = DB::table('kategori')
                ->orderBy('nama_kategori')
                ->get();

            return view('admin.detailrekammedis.create', compact('rekamMedisList', 'kodeTindakanTerapi', 'kategori'));
        } catch (\Exception $e) {
            return redirect()
                ->route('detailrekammedis.index')
                ->with('error', 'Gagal memuat form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created detail rekam medis in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'idrekam_medis' => 'required|exists:rekam_medis,idrekam_medis',
            'idkode_tindakan_terapi' => 'required|exists:kode_tindakan_terapi,idkode_tindakan_terapi',
            'detail' => 'nullable|string|max:1000',
        ], [
            'idrekam_medis.required' => 'Rekam medis harus dipilih.',
            'idrekam_medis.exists' => 'Rekam medis tidak valid.',
            'idkode_tindakan_terapi.required' => 'Kode tindakan/terapi harus dipilih.',
            'idkode_tindakan_terapi.exists' => 'Kode tindakan/terapi tidak valid.',
            'detail.max' => 'Detail maksimal 1000 karakter.',
        ]);

        try {
            DB::table('detail_rekam_medis')->insert([
                'idrekam_medis' => $validated['idrekam_medis'],
                'idkode_tindakan_terapi' => $validated['idkode_tindakan_terapi'],
                'detail' => $validated['detail'],
            ]);

            return redirect()
                ->route('detailrekammedis.index')
                ->with('success', 'Detail rekam medis berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified detail rekam medis.
     */
    public function edit($id)
    {
        try {
            $detailRekamMedis = DB::table('detail_rekam_medis')
                ->where('iddetail_rekam_medis', $id)
                ->first();

            if (!$detailRekamMedis) {
                return redirect()
                    ->route('detailrekammedis.index')
                    ->with('error', 'Data detail rekam medis tidak ditemukan.');
            }

            // Ambil rekam medis
            $rekamMedisList = DB::table('rekam_medis')
                ->join('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
                ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
                ->join('user', 'pemilik.iduser', '=', 'user.iduser')
                ->select(
                    'rekam_medis.idrekam_medis',
                    'rekam_medis.created_at',
                    'rekam_medis.diagnosa',
                    'pet.nama as nama_pet',
                    'user.nama as nama_pemilik'
                )
                ->orderBy('rekam_medis.created_at', 'desc')
                ->get();

            // Ambil kode tindakan/terapi
            $kodeTindakanTerapi = DB::table('kode_tindakan_terapi')
                ->join('kategori', 'kode_tindakan_terapi.idkategori', '=', 'kategori.idkategori')
                ->join('kategori_klinis', 'kode_tindakan_terapi.idkategori_klinis', '=', 'kategori_klinis.idkategori_klinis')
                ->select(
                    'kode_tindakan_terapi.*',
                    'kategori.nama_kategori',
                    'kategori_klinis.nama_kategori_klinis'
                )
                ->orderBy('kategori.nama_kategori')
                ->orderBy('kode_tindakan_terapi.kode')
                ->get();

            // Ambil kategori
            $kategori = DB::table('kategori')
                ->orderBy('nama_kategori')
                ->get();

            return view('admin.detailrekammedis.edit', compact('detailRekamMedis', 'rekamMedisList', 'kodeTindakanTerapi', 'kategori'));
        } catch (\Exception $e) {
            return redirect()
                ->route('detailrekammedis.index')
                ->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified detail rekam medis in database.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'idrekam_medis' => 'required|exists:rekam_medis,idrekam_medis',
            'idkode_tindakan_terapi' => 'required|exists:kode_tindakan_terapi,idkode_tindakan_terapi',
            'detail' => 'nullable|string|max:1000',
        ], [
            'idrekam_medis.required' => 'Rekam medis harus dipilih.',
            'idrekam_medis.exists' => 'Rekam medis tidak valid.',
            'idkode_tindakan_terapi.required' => 'Kode tindakan/terapi harus dipilih.',
            'idkode_tindakan_terapi.exists' => 'Kode tindakan/terapi tidak valid.',
            'detail.max' => 'Detail maksimal 1000 karakter.',
        ]);

        try {
            $exists = DB::table('detail_rekam_medis')
                ->where('iddetail_rekam_medis', $id)
                ->exists();

            if (!$exists) {
                return redirect()
                    ->route('detailrekammedis.index')
                    ->with('error', 'Data detail rekam medis tidak ditemukan.');
            }

            DB::table('detail_rekam_medis')
                ->where('iddetail_rekam_medis', $id)
                ->update([
                    'idrekam_medis' => $validated['idrekam_medis'],
                    'idkode_tindakan_terapi' => $validated['idkode_tindakan_terapi'],
                    'detail' => $validated['detail'],
                ]);

            return redirect()
                ->route('detailrekammedis.index')
                ->with('success', 'Detail rekam medis berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified detail rekam medis from database.
     */
    public function destroy($id)
    {
        try {
            $exists = DB::table('detail_rekam_medis')
                ->where('iddetail_rekam_medis', $id)
                ->exists();

            if (!$exists) {
                return redirect()
                    ->route('detailrekammedis.index')
                    ->with('error', 'Data detail rekam medis tidak ditemukan.');
            }

            DB::table('detail_rekam_medis')
                ->where('iddetail_rekam_medis', $id)
                ->delete();

            return redirect()
                ->route('detailrekammedis.index')
                ->with('success', 'Detail rekam medis berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()
                ->route('detailrekammedis.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}