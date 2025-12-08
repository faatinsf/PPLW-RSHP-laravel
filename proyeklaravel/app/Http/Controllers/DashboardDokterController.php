<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use App\Models\Pet;
use App\Models\Pemilik;
use App\Models\KodeTindakanTerapi;

class DashboardDokterController extends Controller
{
    public function index()
    {
        $rekamCount = RekamMedis::count();
        $petCount = Pet::count();
        $pemilikCount = Pemilik::count();
        $terapiCount = KodeTindakanTerapi::count();

        return view('dokter.dashboard', compact('rekamCount', 'petCount', 'pemilikCount', 'terapiCount'));
    }
}
