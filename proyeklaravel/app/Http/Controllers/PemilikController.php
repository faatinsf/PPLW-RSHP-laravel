<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemilikController extends Controller
{
    /**
     * Display a listing of pemilik.
     */
    public function index()
    {
        try {
            // JOIN dengan tabel user untuk menampilkan nama user
            $pemilik = DB::table('pemilik')
                ->join('user', 'pemilik.iduser', '=', 'user.iduser')
                ->select(
                    'pemilik.*',
                    'user.nama as nama_user',
                    'user.email'
                )
                ->orderBy('pemilik.idpemilik', 'desc')
                ->get();

            return view('admin.pemilik.index', compact('pemilik'));
        } catch (\Exception $e) {
            return view('admin.pemilik.index', [
                'pemilik' => collect([])
            ])->with('error', 'Gagal memuat data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new pemilik.
     */
    public function create()
    {
        try {
            // Ambil semua user yang belum terdaftar sebagai pemilik
            $existingPemilikUserIds = DB::table('pemilik')
                ->pluck('iduser')
                ->toArray();

            $users = DB::table('user')
                ->select('iduser', 'nama', 'email')
                ->whereNotIn('iduser', $existingPemilikUserIds)
                ->orderBy('nama')
                ->get();

            return view('admin.pemilik.create', compact('users'));
        } catch (\Exception $e) {
            return redirect()
                ->route('pemilik.index')
                ->with('error', 'Gagal memuat form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created pemilik in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_wa'   => 'required|string|max:45',
            'alamat'  => 'required|string|max:100',
            'iduser'  => 'required|exists:user,iduser',
        ], [
            'no_wa.required' => 'Nomor WhatsApp harus diisi.',
            'no_wa.max' => 'Nomor WhatsApp maksimal 45 karakter.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.max' => 'Alamat maksimal 100 karakter.',
            'iduser.required' => 'User harus dipilih.',
            'iduser.exists' => 'User tidak valid.',
        ]);

        try {
            // Cek apakah user sudah terdaftar sebagai pemilik
            $exists = DB::table('pemilik')
                ->where('iduser', $validated['iduser'])
                ->exists();

            if ($exists) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'User ini sudah terdaftar sebagai pemilik!');
            }

            DB::table('pemilik')->insert([
                'no_wa'  => $validated['no_wa'],
                'alamat' => $validated['alamat'],
                'iduser' => $validated['iduser'],
            ]);

            return redirect()
                ->route('pemilik.index')
                ->with('success', 'Data pemilik berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified pemilik.
     */
    public function edit($id)
    {
        try {
            // Ambil data pemilik berdasarkan ID
            $pemilik = DB::table('pemilik')
                ->where('idpemilik', $id)
                ->first();

            if (!$pemilik) {
                return redirect()
                    ->route('pemilik.index')
                    ->with('error', 'Data pemilik tidak ditemukan.');
            }

            // Ambil semua user untuk dropdown (termasuk user yang sedang diedit)
            $existingPemilikUserIds = DB::table('pemilik')
                ->where('idpemilik', '!=', $id)
                ->pluck('iduser')
                ->toArray();

            $users = DB::table('user')
                ->select('iduser', 'nama', 'email')
                ->whereNotIn('iduser', $existingPemilikUserIds)
                ->orWhere('iduser', $pemilik->iduser)
                ->orderBy('nama')
                ->get();

            return view('admin.pemilik.edit', compact('pemilik', 'users'));

        } catch (\Exception $e) {
            return redirect()
                ->route('pemilik.index')
                ->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified pemilik in database.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'no_wa'   => 'required|string|max:45',
            'alamat'  => 'required|string|max:100',
            'iduser'  => 'required|exists:user,iduser',
        ], [
            'no_wa.required' => 'Nomor WhatsApp harus diisi.',
            'no_wa.max' => 'Nomor WhatsApp maksimal 45 karakter.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.max' => 'Alamat maksimal 100 karakter.',
            'iduser.required' => 'User harus dipilih.',
            'iduser.exists' => 'User tidak valid.',
        ]);

        try {
            // Cek apakah data ada
            $pemilik = DB::table('pemilik')
                ->where('idpemilik', $id)
                ->first();

            if (!$pemilik) {
                return redirect()
                    ->route('pemilik.index')
                    ->with('error', 'Data pemilik tidak ditemukan.');
            }

            // Cek apakah user sudah terdaftar sebagai pemilik (kecuali pemilik yang sedang diedit)
            if ($pemilik->iduser != $validated['iduser']) {
                $userExists = DB::table('pemilik')
                    ->where('iduser', $validated['iduser'])
                    ->where('idpemilik', '!=', $id)
                    ->exists();

                if ($userExists) {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->with('error', 'User ini sudah terdaftar sebagai pemilik lain!');
                }
            }

            // Update data
            DB::table('pemilik')
                ->where('idpemilik', $id)
                ->update([
                    'no_wa'  => $validated['no_wa'],
                    'alamat' => $validated['alamat'],
                    'iduser' => $validated['iduser'],
                ]);

            return redirect()
                ->route('pemilik.index')
                ->with('success', 'Data pemilik berhasil diupdate!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified pemilik from database.
     */
    public function destroy($id)
    {
        try {
            // Cek apakah pemilik masih memiliki pet
            $hasPet = DB::table('pet')
                ->where('idpemilik', $id)
                ->exists();

            if ($hasPet) {
                return redirect()
                    ->route('pemilik.index')
                    ->with('error', 'Pemilik tidak dapat dihapus karena masih memiliki pet yang terdaftar!');
            }

            // Cek apakah data ada
            $exists = DB::table('pemilik')
                ->where('idpemilik', $id)
                ->exists();

            if (!$exists) {
                return redirect()
                    ->route('pemilik.index')
                    ->with('error', 'Data pemilik tidak ditemukan.');
            }

            // Hapus data
            DB::table('pemilik')
                ->where('idpemilik', $id)
                ->delete();

            return redirect()
                ->route('pemilik.index')
                ->with('success', 'Data pemilik berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()
                ->route('pemilik.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}