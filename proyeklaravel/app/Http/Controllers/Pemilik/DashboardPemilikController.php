<?php

namespace App\Http\Controllers\Pemilik;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class DashboardPemilikController extends Controller
{
    /**
     * Display dashboard pemilik.
     * Ambil data pemilik langsung dari database berdasarkan cookie/request
     */
    public function index(Request $request)
    {
        // Method 1: Get from cookie (jika login set cookie)
        $userId = $request->cookie('user_id') 
               ?? $request->cookie('iduser')
               ?? Cookie::get('user_id')
               ?? Cookie::get('iduser');
        
        // Method 2: Get from query string for testing
        // Contoh: /pemilik/dashboard?test_user=1
        if (!$userId && $request->has('test_user')) {
            $userId = $request->get('test_user');
        }
        
        // Method 3: Get pemilik pertama yang ada (untuk testing)
        // HAPUS INI SETELAH LOGIN BERFUNGSI!
        if (!$userId) {
            $firstPemilik = DB::table('pemilik')
                ->join('user', 'pemilik.iduser', '=', 'user.iduser')
                ->join('role_user', 'user.iduser', '=', 'role_user.iduser')
                ->where('role_user.idrole', 5) // Role pemilik = 5
                ->select('pemilik.iduser')
                ->first();
            
            $userId = $firstPemilik ? $firstPemilik->iduser : null;
        }
        
        if (!$userId) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu');
        }
        
        // Verify user adalah pemilik (role 5)
        $roleUser = DB::table('role_user')
            ->where('iduser', $userId)
            ->where('idrole', 5) // 5 = Pemilik
            ->first();
        
        if (!$roleUser) {
            return redirect()->route('login')
                ->with('error', 'Anda tidak memiliki akses sebagai pemilik');
        }
        
        // Get pemilik data
        $pemilik = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->where('pemilik.iduser', $userId)
            ->select('pemilik.*', 'user.nama', 'user.email')
            ->first();
        
        if (!$pemilik) {
            return redirect()->route('login')
                ->with('error', 'Data pemilik tidak ditemukan');
        }
        
        // Get statistics
        $stats = $this->getStatistics($pemilik->idpemilik);
        
        // Get upcoming appointments (next 3)
        $upcomingAppointments = $this->getUpcomingAppointments($pemilik->idpemilik);
        
        // Get pets summary
        $pets = $this->getPetsSummary($pemilik->idpemilik);
        
        // Get recent medical records (last 5)
        $recentMedicalRecords = $this->getRecentMedicalRecords($pemilik->idpemilik);
        
        // Get vaccination reminders
        $vaccinationReminders = $this->getVaccinationReminders($pemilik->idpemilik);
        
        return view('pemilik.dashboard', compact(
            'pemilik',
            'stats',
            'upcomingAppointments',
            'pets',
            'recentMedicalRecords',
            'vaccinationReminders'
        ));
    }
    
    /**
     * Get dashboard statistics.
     */
    private function getStatistics($idPemilik)
    {
        // Total pets
        $totalPets = DB::table('pet')
            ->where('idpemilik', $idPemilik)
            ->count();
        
        // Active appointments (pending + dikonfirmasi)
        $activeAppointments = DB::table('appointment')
            ->where('idpemilik', $idPemilik)
            ->whereIn('status', ['pending', 'dikonfirmasi'])
            ->where('tanggal_appointment', '>=', date('Y-m-d'))
            ->count();
        
        // Total medical records
        $totalMedicalRecords = DB::table('rekam_medis')
            ->join('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
            ->where('pet.idpemilik', $idPemilik)
            ->count();
        
        // Medical records this month
        $medicalRecordsThisMonth = DB::table('rekam_medis')
            ->join('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
            ->where('pet.idpemilik', $idPemilik)
            ->whereMonth('rekam_medis.created_at', date('m'))
            ->whereYear('rekam_medis.created_at', date('Y'))
            ->count();
        
        return [
            'total_pets' => $totalPets,
            'active_appointments' => $activeAppointments,
            'total_medical_records' => $totalMedicalRecords,
            'medical_records_this_month' => $medicalRecordsThisMonth,
        ];
    }
    
    /**
     * Get upcoming appointments.
     */
    private function getUpcomingAppointments($idPemilik)
    {
        return DB::table('appointment')
            ->leftJoin('pet', 'appointment.idpet', '=', 'pet.idpet')
            ->leftJoin('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->where('appointment.idpemilik', $idPemilik)
            ->whereIn('appointment.status', ['pending', 'dikonfirmasi'])
            ->where('appointment.tanggal_appointment', '>=', date('Y-m-d'))
            ->select(
                'appointment.*',
                'pet.nama as nama_pet',
                'ras_hewan.nama_ras'
            )
            ->orderBy('appointment.tanggal_appointment', 'asc')
            ->orderBy('appointment.waktu_appointment', 'asc')
            ->limit(3)
            ->get();
    }
    
    /**
     * Get pets summary.
     */
    private function getPetsSummary($idPemilik)
    {
        return DB::table('pet')
            ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->where('pet.idpemilik', $idPemilik)
            ->select(
                'pet.*',
                'ras_hewan.nama_ras',
                'jenis_hewan.nama_jenis_hewan'
            )
            ->limit(6)
            ->get();
    }
    
    /**
     * Get recent medical records.
     */
    private function getRecentMedicalRecords($idPemilik)
    {
        return DB::table('rekam_medis')
            ->join('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
            ->join('role_user', 'rekam_medis.dokter_pemeriksa', '=', 'role_user.idrole_user')
            ->join('user', 'role_user.iduser', '=', 'user.iduser')
            ->where('pet.idpemilik', $idPemilik)
            ->select(
                'rekam_medis.*',
                'pet.nama as nama_pet',
                'user.nama as nama_dokter'
            )
            ->orderBy('rekam_medis.created_at', 'desc')
            ->limit(5)
            ->get();
    }
    
    /**
     * Get vaccination reminders.
     */
    private function getVaccinationReminders($idPemilik)
    {
        // Get pets with their last vaccination
        $pets = DB::table('pet')
            ->where('pet.idpemilik', $idPemilik)
            ->select('pet.idpet', 'pet.nama', 'pet.tanggal_lahir')
            ->get();
        
        $reminders = [];
        
        foreach ($pets as $pet) {
            // Check if pet needs vaccination based on age
            if ($pet->tanggal_lahir) {
                $ageInMonths = \Carbon\Carbon::parse($pet->tanggal_lahir)->diffInMonths(now());
                
                // Basic vaccination schedule reminders
                if ($ageInMonths >= 2 && $ageInMonths <= 4) {
                    $reminders[] = [
                        'pet_name' => $pet->nama,
                        'message' => 'Waktu vaksinasi dasar',
                        'priority' => 'high'
                    ];
                } elseif ($ageInMonths >= 12 && $ageInMonths <= 13) {
                    $reminders[] = [
                        'pet_name' => $pet->nama,
                        'message' => 'Waktu vaksinasi tahunan',
                        'priority' => 'medium'
                    ];
                }
            }
        }
        
        return collect($reminders)->take(3);
    }
}