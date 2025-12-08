<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.dashboard');
    


        // Statistics
        $stats = [
            // Total rekam medis dokter ini (yang sudah selesai)
            'total_rekam_medis' => DB::table('rekam_medis')
                ->where('dokter_pemeriksa', $dokterRoleUser->idrole_user)
                ->whereNotNull('diagnosa')
                ->count(),

            // Rekam medis hari ini
            'rekam_medis_today' => DB::table('rekam_medis')
                ->where('dokter_pemeriksa', $dokterRoleUser->idrole_user)
                ->whereDate('created_at', Carbon::today())
                ->whereNotNull('diagnosa')
                ->count(),

            // Appointment menunggu (perlu diperiksa)
            'appointment_pending' => DB::table('rekam_medis')
                ->where('dokter_pemeriksa', $dokterRoleUser->idrole_user)
                ->whereNull('diagnosa')
                ->count(),

            // Total pasien yang pernah ditangani (unique pets)
            'total_pasien' => DB::table('rekam_medis')
                ->where('dokter_pemeriksa', $dokterRoleUser->idrole_user)
                ->distinct('idpet')
                ->count('idpet'),
        ];

        // Get today's appointments (pending)
        $appointmentsToday = DB::table('rekam_medis as rm')
            ->join('pet as p', 'rm.idpet', '=', 'p.idpet')
            ->join('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->join('user as u', 'pm.iduser', '=', 'u.iduser')
            ->join('ras_hewan as rh', 'p.idras_hewan', '=', 'rh.idras_hewan')
            ->join('jenis_hewan as jh', 'rh.idjenis_hewan', '=', 'jh.idjenis_hewan')
            ->where('rm.dokter_pemeriksa', $dokterRoleUser->idrole_user)
            ->whereDate('rm.created_at', Carbon::today())
            ->whereNull('rm.diagnosa') // Only pending
            ->select(
                'rm.idrekam_medis',
                'rm.created_at',
                'rm.anamnesa',
                'p.nama as nama_pet',
                'rh.nama_ras',
                'jh.nama_jenis_hewan',
                'u.nama as nama_pemilik',
                'pm.no_wa',
                DB::raw('TIME(rm.created_at) as jam')
            )
            ->orderBy('rm.created_at', 'asc')
            ->get();

        // Recent completed medical records (last 5)
        $recentRecords = DB::table('rekam_medis as rm')
            ->join('pet as p', 'rm.idpet', '=', 'p.idpet')
            ->join('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->join('user as u', 'pm.iduser', '=', 'u.iduser')
            ->where('rm.dokter_pemeriksa', $dokterRoleUser->idrole_user)
            ->whereNotNull('rm.diagnosa')
            ->select(
                'rm.idrekam_medis',
                'rm.created_at',
                'rm.diagnosa',
                'p.nama as nama_pet',
                'u.nama as nama_pemilik'
            )
            ->orderBy('rm.created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dokter.dashboard', compact('stats', 'appointmentsToday', 'recentRecords'));
    
            }
}