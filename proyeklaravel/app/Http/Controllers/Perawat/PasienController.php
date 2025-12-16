<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $query = DB::table('pet as p')
            ->join('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->join('user as u', 'pm.iduser', '=', 'u.iduser')
            ->join('ras_hewan as rh', 'p.idras_hewan', '=', 'rh.idras_hewan')
            ->join('jenis_hewan as jh', 'rh.idjenis_hewan', '=', 'jh.idjenis_hewan')
            ->select(
                'p.*',
                'u.nama as pemilik_nama',
                'u.email as pemilik_email',
                'pm.no_wa',
                'pm.alamat',
                'rh.nama_ras',
                'jh.nama_jenis_hewan'
            );
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('p.nama', 'like', "%{$search}%")
                  ->orWhere('u.nama', 'like', "%{$search}%")
                  ->orWhere('rh.nama_ras', 'like', "%{$search}%");
            });
        }
        
        $pasien = $query->orderBy('p.idpet', 'desc')->paginate(10);
        
        return view('perawat.pasien.index', compact('pasien', 'search'));
    }
    
    public function show($id)
    {
        $pasien = DB::table('pet as p')
            ->join('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->join('user as u', 'pm.iduser', '=', 'u.iduser')
            ->join('ras_hewan as rh', 'p.idras_hewan', '=', 'rh.idras_hewan')
            ->join('jenis_hewan as jh', 'rh.idjenis_hewan', '=', 'jh.idjenis_hewan')
            ->select(
                'p.*',
                'u.nama as pemilik_nama',
                'u.email as pemilik_email',
                'pm.no_wa',
                'pm.alamat',
                'rh.nama_ras',
                'jh.nama_jenis_hewan'
            )
            ->where('p.idpet', $id)
            ->first();
        
        if (!$pasien) {
            return redirect()->route('perawat.pasien.index')
                ->with('error', 'Data pasien tidak ditemukan');
        }
        
        // Riwayat rekam medis
        $riwayatRekamMedis = DB::table('rekam_medis as rm')
            ->join('role_user as ru', 'rm.dokter_pemeriksa', '=', 'ru.idrole_user')
            ->join('user as u', 'ru.iduser', '=', 'u.iduser')
            ->select('rm.*', 'u.nama as dokter_nama')
            ->where('rm.idpet', $id)
            ->orderBy('rm.created_at', 'desc')
            ->get();
        
        return view('perawat.pasien.show', compact('pasien', 'riwayatRekamMedis'));
    }
}