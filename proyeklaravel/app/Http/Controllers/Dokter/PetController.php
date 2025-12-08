<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetController extends Controller
{
    /**
     * Tampilkan daftar hewan (index).
     * Sesuai view: membutuhkan $pets (paginator) dan $jenisHewan.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $jenis  = $request->input('jenis');

        $query = DB::table('pet')
            ->join('pemilik', 'pemilik.idpemilik', '=', 'pet.idpemilik')
            ->join('user', 'user.iduser', '=', 'pemilik.iduser')
            ->join('ras_hewan', 'ras_hewan.idras_hewan', '=', 'pet.idras_hewan')
            ->join('jenis_hewan', 'jenis_hewan.idjenis_hewan', '=', 'ras_hewan.idjenis_hewan')
            ->select(
                'pet.idpet',
                'pet.nama as nama_pet',
                'pet.jenis_kelamin',
                'pet.tanggal_lahir',
                'pet.warna_tanda',
                'ras_hewan.nama_ras',
                'jenis_hewan.nama_jenis_hewan',
                'user.nama as nama_pemilik',
                'pemilik.no_wa',
                'pemilik.alamat'
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('pet.nama', 'like', "%{$search}%")
                  ->orWhere('user.nama', 'like', "%{$search}%")
                  ->orWhere('pemilik.no_wa', 'like', "%{$search}%");
            });
        }

        if ($jenis) {
            $query->where('jenis_hewan.idjenis_hewan', $jenis);
        }

        $pets = $query->orderBy('pet.idpet', 'DESC')
                      ->paginate(10)
                      ->withQueryString();

        $jenisHewan = DB::table('jenis_hewan')->get();

        return view('dokter.pet.index', compact('pets', 'jenisHewan'));
    }

    /**
     * Tampilkan detail hewan (show).
     * Sesuai view: membutuhkan $pet dan $rekamMedisHistory.
     */
    public function show($id)
    {
        // Ambil data pet + pemilik + ras + jenis
        $pet = DB::table('pet')
            ->join('pemilik', 'pemilik.idpemilik', '=', 'pet.idpemilik')
            ->join('user', 'user.iduser', '=', 'pemilik.iduser')
            ->join('ras_hewan', 'ras_hewan.idras_hewan', '=', 'pet.idras_hewan')
            ->join('jenis_hewan', 'jenis_hewan.idjenis_hewan', '=', 'ras_hewan.idjenis_hewan')
            ->select(
                'pet.idpet',
                'pet.nama',
                'pet.jenis_kelamin',
                'pet.tanggal_lahir',
                'pet.warna_tanda',
                'ras_hewan.nama_ras',
                'jenis_hewan.nama_jenis_hewan',
                'user.nama as nama_pemilik',
                // 'user.email as email_pemilik', // dihapus sesuai permintaan: jangan paksa email
                'pemilik.no_wa',
                'pemilik.alamat'
            )
            ->where('pet.idpet', $id)
            ->first();

        if (! $pet) {
            abort(404, 'Hewan tidak ditemukan.');
        }

        // Ambil riwayat rekam medis.
        // Rekam_medis.dokter_pemeriksa -> role_user.idrole_user -> role_user.iduser -> user (nama)
        $rekamMedisHistory = DB::table('rekam_medis')
            ->leftJoin('role_user', 'role_user.idrole_user', '=', 'rekam_medis.dokter_pemeriksa')
            ->leftJoin('user', 'user.iduser', '=', 'role_user.iduser')
            ->select(
                'rekam_medis.idrekam_medis',
                'rekam_medis.anamnesa',
                'rekam_medis.temuan_klinis',
                'rekam_medis.diagnosa',
                'rekam_medis.created_at',
                'user.nama as nama_dokter'
            )
            ->where('rekam_medis.idpet', $id)
            ->orderBy('rekam_medis.created_at', 'DESC')
            ->get();

        return view('dokter.pet.show', compact('pet', 'rekamMedisHistory'));
    }
}
