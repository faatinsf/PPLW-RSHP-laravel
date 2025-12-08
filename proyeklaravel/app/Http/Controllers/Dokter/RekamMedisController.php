<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of rekam medis (dokter's own records)
     */
    public function index(Request $request)
    {
        // Get current doctor's role_user id
        $currentUserId = Auth::id();
        $dokterRoleUser = DB::table('role_user')
            ->where('iduser', $currentUserId)
            ->where('idrole', 2)
            ->first();

        $query = DB::table('rekam_medis as rm')
            ->join('pet as p', 'rm.idpet', '=', 'p.idpet')
            ->join('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->join('user as u', 'pm.iduser', '=', 'u.iduser')
            ->join('ras_hewan as rh', 'p.idras_hewan', '=', 'rh.idras_hewan')
            ->join('jenis_hewan as jh', 'rh.idjenis_hewan', '=', 'jh.idjenis_hewan')
            ->where('rm.dokter_pemeriksa', $dokterRoleUser->idrole_user)
            ->select(
                'rm.idrekam_medis',
                'rm.created_at',
                'rm.diagnosa',
                'p.nama as nama_pet',
                'rh.nama_ras',
                'jh.nama_jenis_hewan',
                'u.nama as nama_pemilik',
                'pm.no_wa',
                DB::raw('DATE(rm.created_at) as tanggal'),
                DB::raw('CASE WHEN rm.diagnosa IS NULL THEN "Pending" ELSE "Selesai" END as status')
            );

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('p.nama', 'LIKE', "%{$search}%")
                  ->orWhere('u.nama', 'LIKE', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status == 'pending') {
                $query->whereNull('rm.diagnosa');
            } elseif ($request->status == 'selesai') {
                $query->whereNotNull('rm.diagnosa');
            }
        }

        // Filter by date
        if ($request->filled('tanggal')) {
            $query->whereDate('rm.created_at', $request->tanggal);
        }

        $rekamMedis = $query->orderBy('rm.created_at', 'desc')->paginate(15);

        return view('dokter.rekam-medis.index', compact('rekamMedis'));
    }

    /**
     * Show the form for creating a new rekam medis (input diagnosa)
     */
    public function create($appointmentId = null)
    {
        // Get appointment data if ID provided
        $appointment = null;
        if ($appointmentId) {
            $appointment = DB::table('rekam_medis as rm')
                ->join('pet as p', 'rm.idpet', '=', 'p.idpet')
                ->join('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
                ->join('user as u', 'pm.iduser', '=', 'u.iduser')
                ->join('ras_hewan as rh', 'p.idras_hewan', '=', 'rh.idras_hewan')
                ->where('rm.idrekam_medis', $appointmentId)
                ->whereNull('rm.diagnosa')
                ->select(
                    'rm.*',
                    'p.nama as nama_pet',
                    'p.jenis_kelamin',
                    'rh.nama_ras',
                    'u.nama as nama_pemilik',
                    'pm.no_wa'
                )
                ->first();

            if (!$appointment) {
                return redirect()->route('dokter.rekam-medis.index')
                    ->with('error', 'Appointment tidak ditemukan atau sudah selesai!');
            }
        }

        // Get all tindakan/terapi grouped by kategori
        $tindakan = DB::table('kode_tindakan_terapi as ktt')
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

        return view('dokter.rekam-medis.create', compact('appointment', 'tindakan'));
    }

    /**
     * Store a newly created rekam medis in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'idrekam_medis' => 'required|exists:rekam_medis,idrekam_medis',
            'diagnosa' => 'required|string|max:1000',
            'temuan_klinis' => 'nullable|string|max:1000',
            'tindakan' => 'nullable|array',
            'tindakan.*' => 'exists:kode_tindakan_terapi,idkode_tindakan_terapi',
            'detail.*' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            // Update rekam medis with diagnosa (changes status to Selesai)
            DB::table('rekam_medis')
                ->where('idrekam_medis', $request->idrekam_medis)
                ->update([
                    'diagnosa' => $request->diagnosa,
                    'temuan_klinis' => $request->temuan_klinis,
                ]);

            // Insert detail tindakan if any
            if ($request->filled('tindakan')) {
                foreach ($request->tindakan as $index => $idTindakan) {
                    DB::table('detail_rekam_medis')->insert([
                        'idrekam_medis' => $request->idrekam_medis,
                        'idkode_tindakan_terapi' => $idTindakan,
                        'detail' => $request->detail[$index] ?? null,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('dokter.rekam-medis.show', $request->idrekam_medis)
                ->with('success', 'Rekam medis berhasil disimpan! Status appointment berubah menjadi Selesai.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Gagal menyimpan rekam medis: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified rekam medis
     */
    public function show($id)
    {
        $rekamMedis = DB::table('rekam_medis as rm')
            ->join('pet as p', 'rm.idpet', '=', 'p.idpet')
            ->join('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->join('user as u', 'pm.iduser', '=', 'u.iduser')
            ->join('ras_hewan as rh', 'p.idras_hewan', '=', 'rh.idras_hewan')
            ->join('jenis_hewan as jh', 'rh.idjenis_hewan', '=', 'jh.idjenis_hewan')
            ->join('role_user as ru', 'rm.dokter_pemeriksa', '=', 'ru.idrole_user')
            ->join('user as dokter', 'ru.iduser', '=', 'dokter.iduser')
            ->where('rm.idrekam_medis', $id)
            ->select(
                'rm.*',
                'p.nama as nama_pet',
                'p.tanggal_lahir',
                'p.jenis_kelamin',
                'p.warna_tanda',
                'rh.nama_ras',
                'jh.nama_jenis_hewan',
                'u.nama as nama_pemilik',
                'u.email as email_pemilik',
                'pm.no_wa',
                'pm.alamat',
                'dokter.nama as nama_dokter'
            )
            ->first();

        if (!$rekamMedis) {
            return redirect()->route('dokter.rekam-medis.index')
                ->with('error', 'Rekam medis tidak ditemukan!');
        }

        // Get detail tindakan
        $detailTindakan = DB::table('detail_rekam_medis as drm')
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

        return view('dokter.rekam-medis.show', compact('rekamMedis', 'detailTindakan'));
    }

    /**
     * Show the form for editing the specified rekam medis
     */
    public function edit($id)
    {
        $rekamMedis = DB::table('rekam_medis as rm')
            ->join('pet as p', 'rm.idpet', '=', 'p.idpet')
            ->join('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->join('user as u', 'pm.iduser', '=', 'u.iduser')
            ->where('rm.idrekam_medis', $id)
            ->select('rm.*', 'p.nama as nama_pet', 'u.nama as nama_pemilik')
            ->first();

        if (!$rekamMedis) {
            return redirect()->route('dokter.rekam-medis.index')
                ->with('error', 'Rekam medis tidak ditemukan!');
        }

        // Get existing tindakan
        $existingTindakan = DB::table('detail_rekam_medis')
            ->where('idrekam_medis', $id)
            ->pluck('idkode_tindakan_terapi')
            ->toArray();

        // Get all tindakan
        $tindakan = DB::table('kode_tindakan_terapi as ktt')
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
            ->get()
            ->groupBy('nama_kategori');

        // Get detail tindakan with details
        $detailTindakan = DB::table('detail_rekam_medis')
            ->where('idrekam_medis', $id)
            ->get();

        return view('dokter.rekam-medis.edit', compact('rekamMedis', 'tindakan', 'existingTindakan', 'detailTindakan'));
    }

    /**
     * Update the specified rekam medis in storage
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'diagnosa' => 'required|string|max:1000',
            'temuan_klinis' => 'nullable|string|max:1000',
            'tindakan' => 'nullable|array',
            'tindakan.*' => 'exists:kode_tindakan_terapi,idkode_tindakan_terapi',
            'detail.*' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            // Update rekam medis
            DB::table('rekam_medis')
                ->where('idrekam_medis', $id)
                ->update([
                    'diagnosa' => $request->diagnosa,
                    'temuan_klinis' => $request->temuan_klinis,
                ]);

            // Delete old detail tindakan
            DB::table('detail_rekam_medis')
                ->where('idrekam_medis', $id)
                ->delete();

            // Insert new detail tindakan
            if ($request->filled('tindakan')) {
                foreach ($request->tindakan as $index => $idTindakan) {
                    DB::table('detail_rekam_medis')->insert([
                        'idrekam_medis' => $id,
                        'idkode_tindakan_terapi' => $idTindakan,
                        'detail' => $request->detail[$index] ?? null,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('dokter.rekam-medis.show', $id)
                ->with('success', 'Rekam medis berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Gagal update rekam medis: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified rekam medis from storage
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Delete detail tindakan first
            DB::table('detail_rekam_medis')
                ->where('idrekam_medis', $id)
                ->delete();

            // Reset diagnosa to null (back to pending status)
            DB::table('rekam_medis')
                ->where('idrekam_medis', $id)
                ->update([
                    'diagnosa' => null,
                    'temuan_klinis' => null
                ]);

            DB::commit();
            return redirect()->route('dokter.rekam-medis.index')
                ->with('success', 'Rekam medis berhasil direset ke status pending!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal reset rekam medis: ' . $e->getMessage());
        }
    }
}