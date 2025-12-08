<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemilikController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('pemilik as pm')
            ->join('user as u', 'pm.iduser', '=', 'u.iduser')
            ->select(
                'pm.idpemilik',
                'pm.no_wa',
                'pm.alamat',
                'u.nama as nama_pemilik',
                'u.email',
                DB::raw('(SELECT COUNT(*) FROM pet WHERE idpemilik = pm.idpemilik) as jumlah_pet')
            );

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('u.nama', 'like', '%' . $search . '%')
                  ->orWhere('pm.no_wa', 'like', '%' . $search . '%')
                  ->orWhere('u.email', 'like', '%' . $search . '%');
            });
        }

        $pemilik = $query->orderBy('u.nama', 'asc')->paginate(15);

        return view('dokter.pemilik.index', compact('pemilik'));
    }

    public function show($id)
    {
        $pemilik = DB::table('pemilik as pm')
            ->join('user as u', 'pm.iduser', '=', 'u.iduser')
            ->where('pm.idpemilik', $id)
            ->select('pm.*', 'u.nama as nama_pemilik', 'u.email')
            ->first();

        if (!$pemilik) {
            return redirect()->route('dokter.pemilik.index')
                ->with('error', 'Data pemilik tidak ditemukan');
        }

        // Get pets
        $pets = DB::table('pet as p')
            ->join('ras_hewan as rh', 'p.idras_hewan', '=', 'rh.idras_hewan')
            ->join('jenis_hewan as jh', 'rh.idjenis_hewan', '=', 'jh.idjenis_hewan')
            ->where('p.idpemilik', $id)
            ->select(
                'p.idpet',
                'p.nama as nama_pet',
                'p.jenis_kelamin',
                'p.tanggal_lahir',
                'jh.nama_jenis_hewan',
                'rh.nama_ras'
            )
            ->get();

        return view('dokter.pemilik.show', compact('pemilik', 'pets'));
    }
}