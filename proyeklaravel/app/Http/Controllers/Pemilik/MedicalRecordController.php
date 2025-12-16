<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of medical records.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        
        // Get pemilik id
        $pemilik = DB::table('pemilik')
            ->where('iduser', $userId)
            ->first();
        
        if (!$pemilik) {
            return redirect()->route('pemilik.dashboard')
                ->with('error', 'Data pemilik tidak ditemukan');
        }
        
        // Build query
        $query = DB::table('rekam_medis')
            ->join('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
            ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->join('role_user', 'rekam_medis.dokter_pemeriksa', '=', 'role_user.idrole_user')
            ->join('user', 'role_user.iduser', '=', 'user.iduser')
            ->where('pet.idpemilik', $pemilik->idpemilik);
        
        // Filter by pet
        if ($request->filled('pet')) {
            $query->where('pet.idpet', $request->pet);
        }
        
        // Filter by periode
        if ($request->filled('periode')) {
            $months = $request->periode;
            $query->where('rekam_medis.created_at', '>=', now()->subMonths($months));
        }
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('rekam_medis.diagnosa', 'like', "%$search%")
                  ->orWhere('rekam_medis.anamnesa', 'like', "%$search%")
                  ->orWhere('rekam_medis.temuan_klinis', 'like', "%$search%");
            });
        }
        
        // Get rekam medis with detail count
        $rekamMedis = $query->select(
                'rekam_medis.*',
                'pet.nama as nama_pet',
                'pet.jenis_kelamin',
                'ras_hewan.nama_ras',
                'jenis_hewan.nama_jenis_hewan',
                'user.nama as nama_dokter',
                DB::raw('(SELECT COUNT(*) FROM detail_rekam_medis WHERE detail_rekam_medis.idrekam_medis = rekam_medis.idrekam_medis) as jumlah_detail')
            )
            ->orderBy('rekam_medis.created_at', 'desc')
            ->paginate(10);
        
        // Get pets for filter
        $pets = DB::table('pet')
            ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->where('pet.idpemilik', $pemilik->idpemilik)
            ->select('pet.idpet', 'pet.nama', 'ras_hewan.nama_ras')
            ->get();
        
        return view('pemilik.medical-record.index', compact('rekamMedis', 'pets'));
    }
    
    /**
     * Display the specified medical record.
     */
    public function show($id)
    {
        $userId = Auth::id();
        
        // Get pemilik id
        $pemilik = DB::table('pemilik')
            ->where('iduser', $userId)
            ->first();
        
        if (!$pemilik) {
            return redirect()->route('pemilik.dashboard')
                ->with('error', 'Data pemilik tidak ditemukan');
        }
        
        // Get medical record detail
        $rekamMedis = DB::table('rekam_medis')
            ->join('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
            ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
            ->join('user as owner', 'pemilik.iduser', '=', 'owner.iduser')
            ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->join('role_user', 'rekam_medis.dokter_pemeriksa', '=', 'role_user.idrole_user')
            ->join('user as dokter', 'role_user.iduser', '=', 'dokter.iduser')
            ->where('rekam_medis.idrekam_medis', $id)
            ->where('pemilik.idpemilik', $pemilik->idpemilik)
            ->select(
                'rekam_medis.*',
                'pet.nama as nama_pet',
                'pet.jenis_kelamin',
                'pet.tanggal_lahir',
                'pet.warna_tanda',
                'ras_hewan.nama_ras',
                'jenis_hewan.nama_jenis_hewan',
                'owner.nama as nama_pemilik',
                'dokter.nama as nama_dokter'
            )
            ->first();
        
        if (!$rekamMedis) {
            return redirect()->route('pemilik.medical-record')
                ->with('error', 'Rekam medis tidak ditemukan');
        }
        
        // Calculate age
        if ($rekamMedis->tanggal_lahir) {
            $age = \Carbon\Carbon::parse($rekamMedis->tanggal_lahir)->age;
            $rekamMedis->umur = $age > 0 ? "$age tahun" : 
                \Carbon\Carbon::parse($rekamMedis->tanggal_lahir)->diffInMonths(now()) . ' bulan';
        } else {
            $rekamMedis->umur = '-';
        }
        
        // Get detail rekam medis with tindakan/terapi
        $detailRekamMedis = DB::table('detail_rekam_medis')
            ->join('kode_tindakan_terapi', 'detail_rekam_medis.idkode_tindakan_terapi', '=', 'kode_tindakan_terapi.idkode_tindakan_terapi')
            ->join('kategori', 'kode_tindakan_terapi.idkategori', '=', 'kategori.idkategori')
            ->join('kategori_klinis', 'kode_tindakan_terapi.idkategori_klinis', '=', 'kategori_klinis.idkategori_klinis')
            ->where('detail_rekam_medis.idrekam_medis', $id)
            ->select(
                'detail_rekam_medis.*',
                'kode_tindakan_terapi.kode',
                'kode_tindakan_terapi.deskripsi_tindakan_terapi',
                'kategori.nama_kategori',
                'kategori_klinis.nama_kategori_klinis'
            )
            ->get();
        
        $rekamMedis->detail_rekam_medis = $detailRekamMedis;
        
        // Get total visits for this pet
        $rekamMedis->total_kunjungan_pet = DB::table('rekam_medis')
            ->where('idpet', $rekamMedis->idpet)
            ->count();
        
        return view('pemilik.medical-record.show', compact('rekamMedis'));
    }
}