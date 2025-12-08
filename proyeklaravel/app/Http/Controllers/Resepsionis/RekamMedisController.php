<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of rekam medis (READ ONLY for Resepsionis)
     */
    public function index(Request $request)
    {
        $query = DB::table('rekam_medis as rm')
            ->join('pet as p', 'rm.idpet', '=', 'p.idpet')
            ->join('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->join('user as u_pemilik', 'pm.iduser', '=', 'u_pemilik.iduser')
            ->join('ras_hewan as rh', 'p.idras_hewan', '=', 'rh.idras_hewan')
            ->join('jenis_hewan as jh', 'rh.idjenis_hewan', '=', 'jh.idjenis_hewan')
            ->join('role_user as ru', 'rm.dokter_pemeriksa', '=', 'ru.idrole_user')
            ->join('user as u_dokter', 'ru.iduser', '=', 'u_dokter.iduser')
            ->whereNotNull('rm.diagnosa') // Only show completed medical records
            ->select(
                'rm.idrekam_medis',
                'rm.created_at',
                'rm.diagnosa',
                'p.nama as nama_pet',
                'rh.nama_ras',
                'jh.nama_jenis_hewan',
                'u_pemilik.nama as nama_pemilik',
                'pm.no_wa',
                'u_dokter.nama as nama_dokter',
                DB::raw('DATE(rm.created_at) as tanggal')
            );

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('p.nama', 'LIKE', "%{$search}%")
                  ->orWhere('u_pemilik.nama', 'LIKE', "%{$search}%")
                  ->orWhere('pm.no_wa', 'LIKE', "%{$search}%");
            });
        }

        // Filter by date
        if ($request->filled('tanggal')) {
            $query->whereDate('rm.created_at', $request->tanggal);
        }

        // Filter by pet
        if ($request->filled('idpet')) {
            $query->where('rm.idpet', $request->idpet);
        }

        $rekamMedis = $query->orderBy('rm.created_at', 'desc')->paginate(15);

        // Get pets for filter dropdown
        $pets = DB::table('pet as p')
            ->join('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->join('user as u', 'pm.iduser', '=', 'u.iduser')
            ->select('p.idpet', 'p.nama as nama_pet', 'u.nama as nama_pemilik')
            ->orderBy('u.nama')
            ->get();

        return view('resepsionis.rekam-medis.index', compact('rekamMedis', 'pets'));
    }

    /**
     * Display the specified rekam medis (READ ONLY)
     */
    public function show($id)
    {
        $rekamMedis = DB::table('rekam_medis as rm')
            ->join('pet as p', 'rm.idpet', '=', 'p.idpet')
            ->join('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->join('user as u_pemilik', 'pm.iduser', '=', 'u_pemilik.iduser')
            ->join('ras_hewan as rh', 'p.idras_hewan', '=', 'rh.idras_hewan')
            ->join('jenis_hewan as jh', 'rh.idjenis_hewan', '=', 'jh.idjenis_hewan')
            ->join('role_user as ru', 'rm.dokter_pemeriksa', '=', 'ru.idrole_user')
            ->join('user as u_dokter', 'ru.iduser', '=', 'u_dokter.iduser')
            ->where('rm.idrekam_medis', $id)
            ->select(
                'rm.*',
                'p.nama as nama_pet',
                'p.tanggal_lahir',
                'p.jenis_kelamin',
                'p.warna_tanda',
                'rh.nama_ras',
                'jh.nama_jenis_hewan',
                'u_pemilik.nama as nama_pemilik',
                'u_pemilik.email as email_pemilik',
                'pm.no_wa',
                'pm.alamat',
                'u_dokter.nama as nama_dokter'
            )
            ->first();

        if (!$rekamMedis) {
            return redirect()->route('resepsionis.rekam-medis.index')
                ->with('error', 'Rekam medis tidak ditemukan!');
        }

        // Get detail tindakan
        $detailTindakan = DB::table('detail_rekam_medis as drm')
            ->join('kode_tindakan_terapi as ktt', 'drm.idkode_tindakan_terapi', '=', 'ktt.idkode_tindakan_terapi')
            ->join('kategori as k', 'ktt.idkategori', '=', 'k.idkategori')
            ->join('kategori_klinis as kk', 'ktt.idkategori_klinis', '=', 'kk.idkategori_klinis')
            ->where('drm.idrekam_medis', $id)
            ->select(
                'drm.*',
                'ktt.kode',
                'ktt.deskripsi_tindakan_terapi',
                'k.nama_kategori',
                'kk.nama_kategori_klinis'
            )
            ->get();

        // Get pet history (previous medical records for this pet)
        $history = DB::table('rekam_medis as rm')
            ->join('role_user as ru', 'rm.dokter_pemeriksa', '=', 'ru.idrole_user')
            ->join('user as u_dokter', 'ru.iduser', '=', 'u_dokter.iduser')
            ->where('rm.idpet', $rekamMedis->idpet)
            ->where('rm.idrekam_medis', '!=', $id)
            ->whereNotNull('rm.diagnosa')
            ->select(
                'rm.idrekam_medis',
                'rm.created_at',
                'rm.diagnosa',
                'rm.anamnesa',
                'u_dokter.nama as nama_dokter'
            )
            ->orderBy('rm.created_at', 'desc')
            ->limit(5)
            ->get();

        return view('resepsionis.rekam-medis.show', compact('rekamMedis', 'detailTindakan', 'history'));
    }
}