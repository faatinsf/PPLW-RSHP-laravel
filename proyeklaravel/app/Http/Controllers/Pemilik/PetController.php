<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PetController extends Controller
{
    /**
     * Display a listing of pets.
     */
    public function index()
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
        
        // Get pets with their data
        $pets = DB::table('pet')
            ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->where('pet.idpemilik', $pemilik->idpemilik)
            ->select(
                'pet.*',
                'ras_hewan.nama_ras',
                'jenis_hewan.nama_jenis_hewan'
            )
            ->get();
        
        // Add additional data for each pet
        $pets = $pets->map(function($pet) {
            // Calculate age
            if ($pet->tanggal_lahir) {
                $age = \Carbon\Carbon::parse($pet->tanggal_lahir)->age;
                $ageInMonths = \Carbon\Carbon::parse($pet->tanggal_lahir)->diffInMonths(now());
                
                if ($age > 0) {
                    $pet->age_display = "$age tahun";
                } else {
                    $pet->age_display = "$ageInMonths bulan";
                }
            } else {
                $pet->age_display = '-';
            }
            
            // Get total visits
            $pet->total_visits = DB::table('rekam_medis')
                ->where('idpet', $pet->idpet)
                ->count();
            
            // Get last vaccination
            $lastVaccination = DB::table('rekam_medis')
                ->join('detail_rekam_medis', 'rekam_medis.idrekam_medis', '=', 'detail_rekam_medis.idrekam_medis')
                ->join('kode_tindakan_terapi', 'detail_rekam_medis.idkode_tindakan_terapi', '=', 'kode_tindakan_terapi.idkode_tindakan_terapi')
                ->join('kategori', 'kode_tindakan_terapi.idkategori', '=', 'kategori.idkategori')
                ->where('rekam_medis.idpet', $pet->idpet)
                ->where('kategori.nama_kategori', 'Vaksinasi')
                ->orderBy('rekam_medis.created_at', 'desc')
                ->select('rekam_medis.created_at', 'kode_tindakan_terapi.deskripsi_tindakan_terapi')
                ->first();
            
            $pet->last_vaccination = $lastVaccination;
            
            // Determine health status
            $recentCheckup = DB::table('rekam_medis')
                ->where('idpet', $pet->idpet)
                ->where('created_at', '>=', now()->subMonths(3))
                ->orderBy('created_at', 'desc')
                ->first();
            
            if ($recentCheckup) {
                $diagnosa = strtolower($recentCheckup->diagnosa ?? '');
                if (str_contains($diagnosa, 'sehat') || str_contains($diagnosa, 'baik')) {
                    $pet->health_status = 'healthy';
                } else {
                    $pet->health_status = 'observation';
                }
            } else {
                $pet->health_status = 'unknown';
            }
            
            // Check if needs vaccination (based on age and last vaccination)
            $pet->needs_vaccination = false;
            if ($pet->tanggal_lahir) {
                $ageInMonths = \Carbon\Carbon::parse($pet->tanggal_lahir)->diffInMonths(now());
                if ($ageInMonths >= 2 && !$lastVaccination) {
                    $pet->needs_vaccination = true;
                } elseif ($lastVaccination && \Carbon\Carbon::parse($lastVaccination->created_at)->diffInMonths(now()) >= 12) {
                    $pet->needs_vaccination = true;
                }
            }
            
            return $pet;
        });
        
        // Calculate statistics
        $stats = [
            'total_pets' => $pets->count(),
            'healthy_pets' => $pets->where('health_status', 'healthy')->count(),
            'needs_vaccination' => $pets->where('needs_vaccination', true)->count(),
        ];
        
        return view('pemilik.pet.index', compact('pets', 'stats'));
    }
}