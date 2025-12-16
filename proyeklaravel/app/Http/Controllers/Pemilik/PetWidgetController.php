<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PetWidgetController extends Controller
{
    /**
     * Get pets for widget display.
     */
    public function getPetsWidget()
    {
        $userId = Auth::id();
        
        // Get pemilik id
        $pemilik = DB::table('pemilik')
            ->where('iduser', $userId)
            ->first();
        
        if (!$pemilik) {
            return response()->json(['error' => 'Pemilik not found'], 404);
        }
        
        // Get pets with health status
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
        
        // Add health status and recent activity
        $pets = $pets->map(function($pet) {
            // Get last checkup
            $lastCheckup = DB::table('rekam_medis')
                ->where('idpet', $pet->idpet)
                ->orderBy('created_at', 'desc')
                ->first();
            
            // Calculate age
            $age = $pet->tanggal_lahir ? 
                \Carbon\Carbon::parse($pet->tanggal_lahir)->age : 0;
            
            return [
                'idpet' => $pet->idpet,
                'nama' => $pet->nama,
                'jenis_hewan' => $pet->nama_jenis_hewan,
                'ras' => $pet->nama_ras,
                'jenis_kelamin' => $pet->jenis_kelamin,
                'age' => $age,
                'age_text' => $age > 0 ? "$age tahun" : 
                    (\Carbon\Carbon::parse($pet->tanggal_lahir)->diffInMonths(now()) . ' bulan'),
                'warna' => $pet->warna_tanda,
                'last_checkup' => $lastCheckup ? 
                    \Carbon\Carbon::parse($lastCheckup->created_at)->diffForHumans() : 
                    'Belum pernah',
                'health_status' => $this->determineHealthStatus($pet->idpet)
            ];
        });
        
        return response()->json($pets);
    }
    
    /**
     * Determine health status based on recent checkups.
     */
    private function determineHealthStatus($idPet)
    {
        $recentCheckup = DB::table('rekam_medis')
            ->where('idpet', $idPet)
            ->where('created_at', '>=', now()->subMonths(3))
            ->orderBy('created_at', 'desc')
            ->first();
        
        if (!$recentCheckup) {
            return 'unknown'; // No recent checkup
        }
        
        // Simple logic: check if there's any serious diagnosis
        $diagnosa = strtolower($recentCheckup->diagnosa ?? '');
        
        if (str_contains($diagnosa, 'sehat') || str_contains($diagnosa, 'baik')) {
            return 'healthy';
        } elseif (str_contains($diagnosa, 'ringan') || str_contains($diagnosa, 'observasi')) {
            return 'observation';
        } elseif (str_contains($diagnosa, 'sakit') || str_contains($diagnosa, 'infeksi')) {
            return 'sick';
        }
        
        return 'unknown';
    }
}