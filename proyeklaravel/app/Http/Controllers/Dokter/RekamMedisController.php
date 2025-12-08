<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekamMedisController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('rekam_medis as rm')
            ->join('pet as p', 'rm.idpet', '=', 'p.idpet')
            ->join('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->join('user as u_pemilik', 'pm.iduser', '=', 'u_pemilik.iduser')
            ->join('ras_hewan as rh', 'p.idras_hewan', '=', 'rh.idras_hewan')
            ->join('jenis_hewan as jh', 'rh.idjenis_hewan', '=', 'jh.idjenis_hewan')
            ->select(
                'rm.idrekam_medis',
                'rm.created_at',
                'rm.anamnesa',
                'rm.temuan_klinis',
                'rm.diagnosa',
                'p.nama as nama_pet',
                'jh.nama_jenis_hewan',
                'rh.nama_ras',
                'u_pemilik.nama as nama_pemilik'
            );

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('p.nama', 'like', '%' . $search . '%')
                  ->orWhere('u_pemilik.nama', 'like', '%' . $search . '%');
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'pending') {
                $query->whereNull('rm.diagnosa');
            } else if ($request->status == 'selesai') {
                $query->whereNotNull('rm.diagnosa');
            }
        }

        // Filter by date
        if ($request->has('tanggal') && $request->tanggal != '') {
            $query->whereDate('rm.created_at', $request->tanggal);
        }

        $rekamMedis = $query->orderBy('rm.created_at', 'desc')->paginate(15);

        return view('dokter.rekam-medis.index', compact('rekamMedis'));
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

        return view('dokter.rekam-medis.show', compact('rekamMedis', 'details'));
    }

    public function edit($id)
    {
        $rekamMedis = DB::table('rekam_medis as rm')
            ->join('pet as p', 'rm.idpet', '=', 'p.idpet')
            ->join('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->join('user as u', 'pm.iduser', '=', 'u.iduser')
            ->where('rm.idrekam_medis', $id)
            ->select(
                'rm.*',
                'p.nama as nama_pet',
                'u.nama as nama_pemilik'
            )
            ->first();

        if (!$rekamMedis) {
            return redirect()->route('dokter.rekam-medis.index')
                ->with('error', 'Rekam medis tidak ditemukan');
        }

        $tindakanList = DB::table('kode_tindakan_terapi as ktt')
            ->join('kategori as k', 'ktt.idkategori', '=', 'k.idkategori')
            ->join('kategori_klinis as kk', 'ktt.idkategori_klinis', '=', 'kk.idkategori_klinis')
            ->select(
                'ktt.idkode_tindakan_terapi',
                'ktt.kode',
                'ktt.deskripsi_tindakan_terapi',
                'k.nama_kategori',
                'kk.nama_kategori_klinis'
            )
            ->orderBy('k.nama_kategori')
            ->orderBy('ktt.kode')
            ->get()
            ->groupBy('nama_kategori');

        $existingDetails = DB::table('detail_rekam_medis')
            ->where('idrekam_medis', $id)
            ->get();

        return view('dokter.rekam-medis.edit', compact('rekamMedis', 'tindakanList', 'existingDetails'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'temuan_klinis' => 'required|string',
            'diagnosa' => 'required|string',
            'tindakan' => 'nullable|array',
            'tindakan.*' => 'exists:kode_tindakan_terapi,idkode_tindakan_terapi',
            'detail_tindakan' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            DB::table('rekam_medis')
                ->where('idrekam_medis', $id)
                ->update([
                    'temuan_klinis' => $validated['temuan_klinis'],
                    'diagnosa' => $validated['diagnosa'],
                ]);

            DB::table('detail_rekam_medis')
                ->where('idrekam_medis', $id)
                ->delete();

            if (isset($validated['tindakan']) && is_array($validated['tindakan'])) {
                foreach ($validated['tindakan'] as $index => $idTindakan) {
                    $detail = $validated['detail_tindakan'][$index] ?? null;
                    DB::table('detail_rekam_medis')->insert([
                        'idrekam_medis' => $id,
                        'idkode_tindakan_terapi' => $idTindakan,
                        'detail' => $detail,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('dokter.rekam-medis.show', $id)
                ->with('success', 'Rekam medis berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui rekam medis: ' . $e->getMessage())
                ->withInput();
        }
    }
}
