<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardResepsionisController extends Controller
{
    public function index()
    {
        try {
            // Tanggal hari ini
            $today = Carbon::today();
            
            // 1. Statistik Cards
            $stats = [
                'total_hewan' => DB::table('pet')->count(),
                'total_pemilik' => DB::table('pemilik')->count(),
                'appointment_hari_ini' => DB::table('rekam_medis')
                    ->whereDate('created_at', $today)
                    ->count(),
                'total_rekam_medis' => DB::table('rekam_medis')->count(),
            ];

            // 2. Appointment Hari Ini (Detail)
            $appointmentHariIni = DB::table('rekam_medis')
                ->join('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
                ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
                ->join('user as pemilik_user', 'pemilik.iduser', '=', 'pemilik_user.iduser')
                ->join('role_user', 'rekam_medis.dokter_pemeriksa', '=', 'role_user.idrole_user')
                ->join('user as dokter_user', 'role_user.iduser', '=', 'dokter_user.iduser')
                ->select(
                    'rekam_medis.*',
                    'pet.nama as nama_pet',
                    'pemilik_user.nama as nama_pemilik',
                    'pemilik.no_wa',
                    'dokter_user.nama as nama_dokter'
                )
                ->whereDate('rekam_medis.created_at', $today)
                ->orderBy('rekam_medis.created_at', 'desc')
                ->limit(10)
                ->get();

            // 3. Hewan yang Baru Terdaftar (5 terakhir)
            $hewanTerbaru = DB::table('pet')
                ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
                ->join('user', 'pemilik.iduser', '=', 'user.iduser')
                ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
                ->select(
                    'pet.*',
                    'user.nama as nama_pemilik',
                    'ras_hewan.nama_ras'
                )
                ->orderBy('pet.idpet', 'desc')
                ->limit(5)
                ->get();

            // 4. Rekam Medis Terbaru
            $rekamMedisTerbaru = DB::table('rekam_medis')
                ->join('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
                ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
                ->join('user', 'pemilik.iduser', '=', 'user.iduser')
                ->select(
                    'rekam_medis.*',
                    'pet.nama as nama_pet',
                    'user.nama as nama_pemilik'
                )
                ->orderBy('rekam_medis.created_at', 'desc')
                ->limit(5)
                ->get();

            // 5. Info User (Resepsionis yang login)
            $resepsionis = Auth::user();

            return view('resepsionis.dashboard', compact(
                'stats',
                'appointmentHariIni',
                'hewanTerbaru',
                'rekamMedisTerbaru',
                'resepsionis',
                'today'
            ));
        } catch (\Exception $e) {
            return view('resepsionis.dashboard', [
                'stats' => [
                    'total_hewan' => 0,
                    'total_pemilik' => 0,
                    'appointment_hari_ini' => 0,
                    'total_rekam_medis' => 0,
                ],
                'appointmentHariIni' => collect([]),
                'hewanTerbaru' => collect([]),
                'rekamMedisTerbaru' => collect([]),
                'resepsionis' => Auth::user(),
                'today' => Carbon::today(),
            ])->with('error', 'Gagal memuat dashboard: ' . $e->getMessage());
        }
    }
}