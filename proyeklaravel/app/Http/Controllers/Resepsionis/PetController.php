<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetController extends Controller
{
    /**
     * Display a listing of pets.
     */
    public function index()
    {
        try {
            $pets = DB::table('pet')
                ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
                ->join('user', 'pemilik.iduser', '=', 'user.iduser')
                ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
                ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
                ->select(
                    'pet.*',
                    'user.nama as nama_pemilik',
                    'user.email as email_pemilik',
                    'pemilik.no_wa',
                    'ras_hewan.nama_ras',
                    'jenis_hewan.nama_jenis_hewan'
                )
                ->orderBy('pet.idpet', 'desc')
                ->get();

            return view('resepsionis.pet.index', compact('pets'));
        } catch (\Exception $e) {
            return view('resepsionis.pet.index', ['pets' => collect([])])
                ->with('error', 'Gagal memuat data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new pet.
     */
    public function create()
    {
        try {
            $pemilik = DB::table('pemilik')
                ->join('user', 'pemilik.iduser', '=', 'user.iduser')
                ->select(
                    'pemilik.idpemilik',
                    'user.nama',
                    'user.email',
                    'pemilik.no_wa'
                )
                ->orderBy('user.nama')
                ->get();

            $jenisHewan = DB::table('jenis_hewan')
                ->select('idjenis_hewan', 'nama_jenis_hewan')
                ->orderBy('nama_jenis_hewan')
                ->get();

            $rasHewan = DB::table('ras_hewan')
                ->select('idras_hewan', 'nama_ras', 'idjenis_hewan')
                ->orderBy('nama_ras')
                ->get();

            return view('resepsionis.pet.create', compact('pemilik', 'jenisHewan', 'rasHewan'));
        } catch (\Exception $e) {
            return redirect()
                ->route('resepsionis.pet.index')
                ->with('error', 'Gagal memuat form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created pet in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'warna_tanda'   => 'required|string|max:45',
            'jenis_kelamin' => 'required|in:J,B',
            'idpemilik'     => 'required|exists:pemilik,idpemilik',
            'idras_hewan'   => 'required|exists:ras_hewan,idras_hewan',
        ], [
            'nama.required' => 'Nama hewan harus diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi.',
            'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak boleh melebihi hari ini.',
            'warna_tanda.required' => 'Warna/tanda harus diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih.',
            'idpemilik.required' => 'Pemilik harus dipilih.',
            'idras_hewan.required' => 'Ras hewan harus dipilih.',
        ]);

        try {
            DB::table('pet')->insert([
                'nama'          => $validated['nama'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'warna_tanda'   => $validated['warna_tanda'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'idpemilik'     => $validated['idpemilik'],
                'idras_hewan'   => $validated['idras_hewan'],
            ]);

            return redirect()
                ->route('resepsionis.pet.index')
                ->with('success', 'Data hewan berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified pet.
     */
    public function show($id)
    {
        try {
            $pet = DB::table('pet')
                ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
                ->join('user', 'pemilik.iduser', '=', 'user.iduser')
                ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
                ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
                ->select(
                    'pet.*',
                    'user.nama as nama_pemilik',
                    'user.email as email_pemilik',
                    'pemilik.no_wa',
                    'pemilik.alamat',
                    'ras_hewan.nama_ras',
                    'jenis_hewan.nama_jenis_hewan'
                )
                ->where('pet.idpet', $id)
                ->first();

            if (!$pet) {
                return redirect()
                    ->route('resepsionis.pet.index')
                    ->with('error', 'Data hewan tidak ditemukan.');
            }

            // Ambil riwayat rekam medis
            $rekamMedis = DB::table('rekam_medis')
                ->join('role_user', 'rekam_medis.dokter_pemeriksa', '=', 'role_user.idrole_user')
                ->join('user', 'role_user.iduser', '=', 'user.iduser')
                ->select(
                    'rekam_medis.*',
                    'user.nama as nama_dokter'
                )
                ->where('rekam_medis.idpet', $id)
                ->orderBy('rekam_medis.created_at', 'desc')
                ->limit(5)
                ->get();

            return view('resepsionis.pet.show', compact('pet', 'rekamMedis'));
        } catch (\Exception $e) {
            return redirect()
                ->route('resepsionis.pet.index')
                ->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }
}