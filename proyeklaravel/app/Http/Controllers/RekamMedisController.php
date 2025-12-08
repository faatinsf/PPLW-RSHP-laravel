<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of rekam medis.
     */
    public function index()
    {
        try {
            $rekamMedis = DB::table('rekam_medis')
                ->join('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
                ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
                ->join('user as pemilik_user', 'pemilik.iduser', '=', 'pemilik_user.iduser')
                ->join('role_user', 'rekam_medis.dokter_pemeriksa', '=', 'role_user.idrole_user')
                ->join('user as dokter_user', 'role_user.iduser', '=', 'dokter_user.iduser')
                ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
                ->select(
                    'rekam_medis.*',
                    'pet.nama as nama_pet',
                    'pemilik_user.nama as nama_pemilik',
                    'pemilik_user.email as email_pemilik',
                    'dokter_user.nama as nama_dokter',
                    'ras_hewan.nama_ras'
                )
                ->orderBy('rekam_medis.created_at', 'desc')
                ->get();

            return view('admin.rekammedis.index', compact('rekamMedis'));
        } catch (\Exception $e) {
            return view('admin.rekammedis.index', ['rekamMedis' => collect([])])
                ->with('error', 'Gagal memuat data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new rekam medis.
     */
    public function create()
    {
        try {
            // Ambil data pet dengan info pemilik
            $pets = DB::table('pet')
                ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
                ->join('user', 'pemilik.iduser', '=', 'user.iduser')
                ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
                ->select(
                    'pet.idpet',
                    'pet.nama as nama_pet',
                    'user.nama as nama_pemilik',
                    'ras_hewan.nama_ras'
                )
                ->orderBy('pet.nama')
                ->get();

            // Ambil data dokter (role_user dengan idrole = 2)
            $dokters = DB::table('role_user')
                ->join('user', 'role_user.iduser', '=', 'user.iduser')
                ->join('role', 'role_user.idrole', '=', 'role.idrole')
                ->where('role_user.idrole', 2) // 2 = Dokter
                ->where('role_user.status', 1) // Status aktif
                ->select(
                    'role_user.idrole_user',
                    'user.nama',
                    'user.email'
                )
                ->orderBy('user.nama')
                ->get();

            return view('admin.rekammedis.create', compact('pets', 'dokters'));
        } catch (\Exception $e) {
            return redirect()
                ->route('rekammedis.index')
                ->with('error', 'Gagal memuat form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created rekam medis in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'idpet' => 'required|exists:pet,idpet',
            'dokter_pemeriksa' => 'required|exists:role_user,idrole_user',
            'anamnesa' => 'required|string|max:1000',
            'temuan_klinis' => 'required|string|max:1000',
            'diagnosa' => 'required|string|max:1000',
        ], [
            'idpet.required' => 'Hewan peliharaan harus dipilih.',
            'idpet.exists' => 'Hewan peliharaan tidak valid.',
            'dokter_pemeriksa.required' => 'Dokter pemeriksa harus dipilih.',
            'dokter_pemeriksa.exists' => 'Dokter pemeriksa tidak valid.',
            'anamnesa.required' => 'Anamnesa harus diisi.',
            'anamnesa.max' => 'Anamnesa maksimal 1000 karakter.',
            'temuan_klinis.required' => 'Temuan klinis harus diisi.',
            'temuan_klinis.max' => 'Temuan klinis maksimal 1000 karakter.',
            'diagnosa.required' => 'Diagnosa harus diisi.',
            'diagnosa.max' => 'Diagnosa maksimal 1000 karakter.',
        ]);

        try {
            DB::table('rekam_medis')->insert([
                'idpet' => $validated['idpet'],
                'dokter_pemeriksa' => $validated['dokter_pemeriksa'],
                'anamnesa' => $validated['anamnesa'],
                'temuan_klinis' => $validated['temuan_klinis'],
                'diagnosa' => $validated['diagnosa'],
                'created_at' => now(),
            ]);

            return redirect()
                ->route('rekammedis.index')
                ->with('success', 'Rekam medis berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified rekam medis.
     */
    public function show($id)
    {
        try {
            // Ambil data rekam medis dengan detail
            $rekamMedis = DB::table('rekam_medis')
                ->join('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
                ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
                ->join('user as pemilik_user', 'pemilik.iduser', '=', 'pemilik_user.iduser')
                ->join('role_user', 'rekam_medis.dokter_pemeriksa', '=', 'role_user.idrole_user')
                ->join('user as dokter_user', 'role_user.iduser', '=', 'dokter_user.iduser')
                ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
                ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
                ->select(
                    'rekam_medis.*',
                    'pet.nama as nama_pet',
                    'pet.tanggal_lahir',
                    'pet.jenis_kelamin',
                    'pet.warna_tanda',
                    'pemilik_user.nama as nama_pemilik',
                    'pemilik_user.email as email_pemilik',
                    'pemilik.no_wa',
                    'pemilik.alamat',
                    'dokter_user.nama as nama_dokter',
                    'dokter_user.email as email_dokter',
                    'ras_hewan.nama_ras',
                    'jenis_hewan.nama_jenis_hewan'
                )
                ->where('rekam_medis.idrekam_medis', $id)
                ->first();

            if (!$rekamMedis) {
                return redirect()
                    ->route('rekammedis.index')
                    ->with('error', 'Data rekam medis tidak ditemukan.');
            }

            // Ambil detail tindakan/terapi
            $detailRekamMedis = DB::table('detail_rekam_medis')
                ->join('kode_tindakan_terapi', 'detail_rekam_medis.idkode_tindakan_terapi', '=', 'kode_tindakan_terapi.idkode_tindakan_terapi')
                ->join('kategori', 'kode_tindakan_terapi.idkategori', '=', 'kategori.idkategori')
                ->join('kategori_klinis', 'kode_tindakan_terapi.idkategori_klinis', '=', 'kategori_klinis.idkategori_klinis')
                ->select(
                    'detail_rekam_medis.*',
                    'kode_tindakan_terapi.kode',
                    'kode_tindakan_terapi.deskripsi_tindakan_terapi',
                    'kategori.nama_kategori',
                    'kategori_klinis.nama_kategori_klinis'
                )
                ->where('detail_rekam_medis.idrekam_medis', $id)
                ->get();

            return view('admin.rekammedis.show', compact('rekamMedis', 'detailRekamMedis'));
        } catch (\Exception $e) {
            return redirect()
                ->route('rekammedis.index')
                ->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified rekam medis.
     */
    public function edit($id)
    {
        try {
            $rekamMedis = DB::table('rekam_medis')
                ->where('idrekam_medis', $id)
                ->first();

            if (!$rekamMedis) {
                return redirect()
                    ->route('rekammedis.index')
                    ->with('error', 'Data rekam medis tidak ditemukan.');
            }

            // Ambil data pet dengan info pemilik
            $pets = DB::table('pet')
                ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
                ->join('user', 'pemilik.iduser', '=', 'user.iduser')
                ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
                ->select(
                    'pet.idpet',
                    'pet.nama as nama_pet',
                    'user.nama as nama_pemilik',
                    'ras_hewan.nama_ras'
                )
                ->orderBy('pet.nama')
                ->get();

            // Ambil data dokter
            $dokters = DB::table('role_user')
                ->join('user', 'role_user.iduser', '=', 'user.iduser')
                ->where('role_user.idrole', 2) // 2 = Dokter
                ->where('role_user.status', 1)
                ->select(
                    'role_user.idrole_user',
                    'user.nama',
                    'user.email'
                )
                ->orderBy('user.nama')
                ->get();

            return view('admin.rekammedis.edit', compact('rekamMedis', 'pets', 'dokters'));
        } catch (\Exception $e) {
            return redirect()
                ->route('rekammedis.index')
                ->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified rekam medis in database.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'idpet' => 'required|exists:pet,idpet',
            'dokter_pemeriksa' => 'required|exists:role_user,idrole_user',
            'anamnesa' => 'required|string|max:1000',
            'temuan_klinis' => 'required|string|max:1000',
            'diagnosa' => 'required|string|max:1000',
        ], [
            'idpet.required' => 'Hewan peliharaan harus dipilih.',
            'idpet.exists' => 'Hewan peliharaan tidak valid.',
            'dokter_pemeriksa.required' => 'Dokter pemeriksa harus dipilih.',
            'dokter_pemeriksa.exists' => 'Dokter pemeriksa tidak valid.',
            'anamnesa.required' => 'Anamnesa harus diisi.',
            'anamnesa.max' => 'Anamnesa maksimal 1000 karakter.',
            'temuan_klinis.required' => 'Temuan klinis harus diisi.',
            'temuan_klinis.max' => 'Temuan klinis maksimal 1000 karakter.',
            'diagnosa.required' => 'Diagnosa harus diisi.',
            'diagnosa.max' => 'Diagnosa maksimal 1000 karakter.',
        ]);

        try {
            $exists = DB::table('rekam_medis')
                ->where('idrekam_medis', $id)
                ->exists();

            if (!$exists) {
                return redirect()
                    ->route('rekammedis.index')
                    ->with('error', 'Data rekam medis tidak ditemukan.');
            }

            DB::table('rekam_medis')
                ->where('idrekam_medis', $id)
                ->update([
                    'idpet' => $validated['idpet'],
                    'dokter_pemeriksa' => $validated['dokter_pemeriksa'],
                    'anamnesa' => $validated['anamnesa'],
                    'temuan_klinis' => $validated['temuan_klinis'],
                    'diagnosa' => $validated['diagnosa'],
                ]);

            return redirect()
                ->route('rekammedis.index')
                ->with('success', 'Rekam medis berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified rekam medis from database.
     */
    public function destroy($id)
    {
        try {
            // Cek apakah rekam medis memiliki detail
            $hasDetail = DB::table('detail_rekam_medis')
                ->where('idrekam_medis', $id)
                ->exists();

            if ($hasDetail) {
                return redirect()
                    ->route('rekammedis.index')
                    ->with('error', 'Rekam medis tidak dapat dihapus karena masih memiliki detail tindakan/terapi!');
            }

            $exists = DB::table('rekam_medis')
                ->where('idrekam_medis', $id)
                ->exists();

            if (!$exists) {
                return redirect()
                    ->route('rekammedis.index')
                    ->with('error', 'Data rekam medis tidak ditemukan.');
            }

            DB::table('rekam_medis')
                ->where('idrekam_medis', $id)
                ->delete();

            return redirect()
                ->route('rekammedis.index')
                ->with('success', 'Rekam medis berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()
                ->route('rekammedis.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}