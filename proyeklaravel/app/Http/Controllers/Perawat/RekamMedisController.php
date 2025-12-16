<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RekamMedisController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $tanggal = $request->get('tanggal');
        
        $query = DB::table('rekam_medis as rm')
            ->join('pet as p', 'rm.idpet', '=', 'p.idpet')
            ->join('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->join('user as u_pemilik', 'pm.iduser', '=', 'u_pemilik.iduser')
            ->join('role_user as ru', 'rm.dokter_pemeriksa', '=', 'ru.idrole_user')
            ->join('user as u_dokter', 'ru.iduser', '=', 'u_dokter.iduser')
            ->select(
                'rm.*',
                'p.nama as pet_nama',
                'u_pemilik.nama as pemilik_nama',
                'u_dokter.nama as dokter_nama'
            );
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('p.nama', 'like', "%{$search}%")
                  ->orWhere('u_pemilik.nama', 'like', "%{$search}%")
                  ->orWhere('rm.diagnosa', 'like', "%{$search}%");
            });
        }
        
        if ($tanggal) {
            $query->whereDate('rm.created_at', $tanggal);
        }
        
        $rekamMedis = $query->orderBy('rm.created_at', 'desc')->paginate(10);
        
        return view('perawat.rekam-medis.index', compact('rekamMedis', 'search', 'tanggal'));
    }
    
    public function create()
    {
        // Get list pasien
        $pasien = DB::table('pet as p')
            ->join('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->join('user as u', 'pm.iduser', '=', 'u.iduser')
            ->join('ras_hewan as rh', 'p.idras_hewan', '=', 'rh.idras_hewan')
            ->select('p.idpet', 'p.nama', 'u.nama as pemilik_nama', 'rh.nama_ras')
            ->orderBy('p.nama')
            ->get();
        
        // Get list dokter
        $dokter = DB::table('role_user as ru')
            ->join('user as u', 'ru.iduser', '=', 'u.iduser')
            ->join('role as r', 'ru.idrole', '=', 'r.idrole')
            ->where('r.idrole', 2) // Role dokter
            ->where('ru.status', 1)
            ->select('ru.idrole_user', 'u.nama')
            ->orderBy('u.nama')
            ->get();
        
        return view('perawat.rekam-medis.create', compact('pasien', 'dokter'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'idpet' => 'required|exists:pet,idpet',
            'dokter_pemeriksa' => 'required|exists:role_user,idrole_user',
            'anamnesa' => 'required',
            'temuan_klinis' => 'required',
            'diagnosa' => 'required',
        ], [
            'idpet.required' => 'Pasien harus dipilih',
            'dokter_pemeriksa.required' => 'Dokter pemeriksa harus dipilih',
            'anamnesa.required' => 'Anamnesa harus diisi',
            'temuan_klinis.required' => 'Temuan klinis harus diisi',
            'diagnosa.required' => 'Diagnosa harus diisi',
        ]);
        
        DB::table('rekam_medis')->insert([
            'idpet' => $request->idpet,
            'dokter_pemeriksa' => $request->dokter_pemeriksa,
            'anamnesa' => $request->anamnesa,
            'temuan_klinis' => $request->temuan_klinis,
            'diagnosa' => $request->diagnosa,
            'created_at' => now(),
        ]);
        
        return redirect()->route('perawat.rekam-medis.index')
            ->with('success', 'Rekam medis berhasil ditambahkan');
    }
    
   public function show($id)
    {
        $rekamMedis = DB::table('rekam_medis as rm')
            ->join('pet as p', 'rm.idpet', '=', 'p.idpet')
            ->join('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->join('user as u_pemilik', 'pm.iduser', '=', 'u_pemilik.iduser')
            ->join('ras_hewan as rh', 'p.idras_hewan', '=', 'rh.idras_hewan')
            ->join('jenis_hewan as jh', 'rh.idjenis_hewan', '=', 'jh.idjenis_hewan')
            ->where('rm.idrekam_medis', $id)
            ->select(
                'rm.*',
                'p.idpet',
                'p.nama as nama_pet',
                'p.tanggal_lahir',
                'p.jenis_kelamin',
                'p.warna_tanda',
                'jh.nama_jenis_hewan',
                'rh.nama_ras',
                'pm.no_wa',
                'pm.alamat',
                'u_pemilik.nama as nama_pemilik',
                'u_pemilik.email as email_pemilik'
            )
            ->first();

        if (!$rekamMedis) {
            return redirect()->route('dokter.rekam-medis.index')
                ->with('error', 'Rekam medis tidak ditemukan');
        }

        $details = DB::table('detail_rekam_medis as drm')
            ->join('kode_tindakan_terapi as ktt', 'drm.idkode_tindakan_terapi', '=', 'ktt.idkode_tindakan_terapi')
            ->join('kategori as k', 'ktt.idkategori', '=', 'k.idkategori')
            ->join('kategori_klinis as kk', 'ktt.idkategori_klinis', '=', 'kk.idkategori_klinis')
            ->where('drm.idrekam_medis', $id)
            ->select(
                'drm.*',
                'ktt.kode',
                'ktt.deskripsi_tindakan_terapi',
                'k.nama_kategori',
                'kk.nama_kategori_klinis'
            )
            ->get();

        return view('perawat.rekam-medis.show', compact('rekamMedis', 'details'));
    }
    
    public function edit($id)
    {
        $rekamMedis = DB::table('rekam_medis')->where('idrekam_medis', $id)->first();
        
        if (!$rekamMedis) {
            return redirect()->route('perawat.rekam-medis.index')
                ->with('error', 'Rekam medis tidak ditemukan');
        }
        
        // Get list pasien
        $pasien = DB::table('pet as p')
            ->join('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->join('user as u', 'pm.iduser', '=', 'u.iduser')
            ->join('ras_hewan as rh', 'p.idras_hewan', '=', 'rh.idras_hewan')
            ->select('p.idpet', 'p.nama', 'u.nama as pemilik_nama', 'rh.nama_ras')
            ->orderBy('p.nama')
            ->get();
        
        // Get list dokter
        $dokter = DB::table('role_user as ru')
            ->join('user as u', 'ru.iduser', '=', 'u.iduser')
            ->join('role as r', 'ru.idrole', '=', 'r.idrole')
            ->where('r.idrole', 2)
            ->where('ru.status', 1)
            ->select('ru.idrole_user', 'u.nama')
            ->orderBy('u.nama')
            ->get();
        
        return view('perawat.rekam-medis.edit', compact('rekamMedis', 'pasien', 'dokter'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'idpet' => 'required|exists:pet,idpet',
            'dokter_pemeriksa' => 'required|exists:role_user,idrole_user',
            'anamnesa' => 'required',
            'temuan_klinis' => 'required',
            'diagnosa' => 'required',
        ]);
        
        DB::table('rekam_medis')
            ->where('idrekam_medis', $id)
            ->update([
                'idpet' => $request->idpet,
                'dokter_pemeriksa' => $request->dokter_pemeriksa,
                'anamnesa' => $request->anamnesa,
                'temuan_klinis' => $request->temuan_klinis,
                'diagnosa' => $request->diagnosa,
            ]);
        
        return redirect()->route('perawat.rekam-medis.show', $id)
            ->with('success', 'Rekam medis berhasil diupdate');
    }
    
    public function destroy($id)
    {
        // Cek apakah ada detail rekam medis
        $countDetail = DB::table('detail_rekam_medis')
            ->where('idrekam_medis', $id)
            ->count();
        
        if ($countDetail > 0) {
            return redirect()->route('perawat.rekam-medis.index')
                ->with('error', 'Tidak dapat menghapus rekam medis yang sudah memiliki detail tindakan/terapi');
        }
        
        DB::table('rekam_medis')->where('idrekam_medis', $id)->delete();
        
        return redirect()->route('perawat.rekam-medis.index')
            ->with('success', 'Rekam medis berhasil dihapus');
    }
}