<?php

namespace App\Http\Controllers;

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
            // Ambil semua data pet dengan JOIN
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

            return view('admin.pet.index', compact('pets'));
        } catch (\Exception $e) {
            return view('admin.pet.index', ['pets' => collect([])])
                ->with('error', 'Gagal memuat data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new pet.
     */
    public function create()
    {
        try {
            // Ambil data pemilik dengan info user
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

            // Ambil data jenis hewan dengan ras
            $jenisHewan = DB::table('jenis_hewan')
                ->select('idjenis_hewan', 'nama_jenis_hewan')
                ->orderBy('nama_jenis_hewan')
                ->get();

            // Ambil data ras hewan
            $rasHewan = DB::table('ras_hewan')
                ->select('idras_hewan', 'nama_ras', 'idjenis_hewan')
                ->orderBy('nama_ras')
                ->get();

            return view('admin.pet.create', compact('pemilik', 'jenisHewan', 'rasHewan'));
        } catch (\Exception $e) {
            return redirect()
                ->route('pet.index')
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
            'nama.max' => 'Nama hewan maksimal 100 karakter.',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi.',
            'tanggal_lahir.date' => 'Format tanggal tidak valid.',
            'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak boleh melebihi hari ini.',
            'warna_tanda.required' => 'Warna/tanda harus diisi.',
            'warna_tanda.max' => 'Warna/tanda maksimal 45 karakter.',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.',
            'idpemilik.required' => 'Pemilik harus dipilih.',
            'idpemilik.exists' => 'Pemilik tidak valid.',
            'idras_hewan.required' => 'Ras hewan harus dipilih.',
            'idras_hewan.exists' => 'Ras hewan tidak valid.',
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
                ->route('pet.index')
                ->with('success', 'Data hewan peliharaan berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified pet.
     */
    public function edit($id)
    {
        try {
            // Ambil data pet
            $pet = DB::table('pet')
                ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
                ->join('user', 'pemilik.iduser', '=', 'user.iduser')
                ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
                ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
                ->select(
                    'pet.*',
                    'user.nama as nama_pemilik',
                    'ras_hewan.nama_ras',
                    'ras_hewan.idjenis_hewan'
                )
                ->where('pet.idpet', $id)
                ->first();

            if (!$pet) {
                return redirect()
                    ->route('pet.index')
                    ->with('error', 'Data hewan tidak ditemukan.');
            }

            // Ambil data pemilik dengan info user
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

            // Ambil data jenis hewan dengan ras
            $jenisHewan = DB::table('jenis_hewan')
                ->select('idjenis_hewan', 'nama_jenis_hewan')
                ->orderBy('nama_jenis_hewan')
                ->get();

            // Ambil data ras hewan
            $rasHewan = DB::table('ras_hewan')
                ->select('idras_hewan', 'nama_ras', 'idjenis_hewan')
                ->orderBy('nama_ras')
                ->get();

            return view('admin.pet.edit', compact('pet', 'pemilik', 'jenisHewan', 'rasHewan'));
        } catch (\Exception $e) {
            return redirect()
                ->route('pet.index')
                ->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified pet in database.
     */
    public function update(Request $request, $id)
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
            'nama.max' => 'Nama hewan maksimal 100 karakter.',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi.',
            'tanggal_lahir.date' => 'Format tanggal tidak valid.',
            'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak boleh melebihi hari ini.',
            'warna_tanda.required' => 'Warna/tanda harus diisi.',
            'warna_tanda.max' => 'Warna/tanda maksimal 45 karakter.',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.',
            'idpemilik.required' => 'Pemilik harus dipilih.',
            'idpemilik.exists' => 'Pemilik tidak valid.',
            'idras_hewan.required' => 'Ras hewan harus dipilih.',
            'idras_hewan.exists' => 'Ras hewan tidak valid.',
        ]);

        try {
            // Cek apakah data ada
            $exists = DB::table('pet')
                ->where('idpet', $id)
                ->exists();

            if (!$exists) {
                return redirect()
                    ->route('pet.index')
                    ->with('error', 'Data hewan tidak ditemukan.');
            }

            // Update data
            DB::table('pet')
                ->where('idpet', $id)
                ->update([
                    'nama'          => $validated['nama'],
                    'tanggal_lahir' => $validated['tanggal_lahir'],
                    'warna_tanda'   => $validated['warna_tanda'],
                    'jenis_kelamin' => $validated['jenis_kelamin'],
                    'idpemilik'     => $validated['idpemilik'],
                    'idras_hewan'   => $validated['idras_hewan'],
                ]);

            return redirect()
                ->route('pet.index')
                ->with('success', 'Data hewan peliharaan berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified pet from database.
     */
    public function destroy($id)
    {
        try {
            // Cek apakah pet masih memiliki rekam medis
            $hasRekamMedis = DB::table('rekam_medis')
                ->where('idpet', $id)
                ->exists();

            if ($hasRekamMedis) {
                return redirect()
                    ->route('pet.index')
                    ->with('error', 'Hewan tidak dapat dihapus karena masih memiliki rekam medis!');
            }

            // Cek apakah data ada
            $exists = DB::table('pet')
                ->where('idpet', $id)
                ->exists();

            if (!$exists) {
                return redirect()
                    ->route('pet.index')
                    ->with('error', 'Data hewan tidak ditemukan.');
            }

            // Hapus data
            DB::table('pet')
                ->where('idpet', $id)
                ->delete();

            return redirect()
                ->route('pet.index')
                ->with('success', 'Data hewan peliharaan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()
                ->route('pet.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}