<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardPerawatController extends Controller
{
    public function index()
    {
        // Total pasien
        $totalPasien = DB::table('pet')->count();
        
        // Total rekam medis
        $totalRekamMedis = DB::table('rekam_medis')->count();
        
        // Rekam medis hari ini
        $rekamMedisHariIni = DB::table('rekam_medis')
            ->whereDate('created_at', today())
            ->count();
        
        // Rekam medis terbaru (5 data)
        $rekamMedisTerbaru = DB::table('rekam_medis as rm')
            ->join('pet as p', 'rm.idpet', '=', 'p.idpet')
            ->join('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->join('user as u_pemilik', 'pm.iduser', '=', 'u_pemilik.iduser')
            ->join('role_user as ru', 'rm.dokter_pemeriksa', '=', 'ru.idrole_user')
            ->join('user as u_dokter', 'ru.iduser', '=', 'u_dokter.iduser')
            ->select(
                'rm.idrekam_medis',
                'rm.created_at',
                'rm.diagnosa',
                'p.nama as pet_nama',
                'u_pemilik.nama as pemilik_nama',
                'u_dokter.nama as dokter_nama'
            )
            ->orderBy('rm.created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Pasien terbaru (5 data)
        $pasienTerbaru = DB::table('pet as p')
            ->join('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->join('user as u', 'pm.iduser', '=', 'u.iduser')
            ->join('ras_hewan as rh', 'p.idras_hewan', '=', 'rh.idras_hewan')
            ->join('jenis_hewan as jh', 'rh.idjenis_hewan', '=', 'jh.idjenis_hewan')
            ->select(
                'p.idpet',
                'p.nama as pet_nama',
                'u.nama as pemilik_nama',
                'pm.no_wa',
                'rh.nama_ras',
                'jh.nama_jenis_hewan'
            )
            ->orderBy('p.idpet', 'desc')
            ->limit(5)
            ->get();
        
        return view('perawat.dashboard', compact(
            'totalPasien',
            'totalRekamMedis',
            'rekamMedisHariIni',
            'rekamMedisTerbaru',
            'pasienTerbaru'
        ));
    }
}