<?php

namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RasHewanController extends Controller
{
    /**
     * Display a listing of ras hewan.
     */
    public function index()
    {
        try {
            $rasHewan = DB::table('ras_hewan')
                ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
                ->select(
                    'ras_hewan.*',
                    'jenis_hewan.nama_jenis_hewan'
                )
                ->orderBy('jenis_hewan.nama_jenis_hewan')
                ->orderBy('ras_hewan.nama_ras')
                ->get();
                
            return view('admin.ras-hewan.index', compact('rasHewan'));
        } catch (\Exception $e) {
            return view('admin.ras-hewan.index', ['rasHewan' => collect([])])
                ->with('error', 'Gagal memuat data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new ras hewan.
     */
    public function create()
    {
        try {
            $jenisHewan = DB::table('jenis_hewan')
                ->select('idjenis_hewan', 'nama_jenis_hewan')
                ->orderBy('nama_jenis_hewan')
                ->get();
                
            return view('admin.ras-hewan.create', compact('jenisHewan'));
        } catch (\Exception $e) {
            return redirect()
                ->route('rashewan.index')
                ->with('error', 'Gagal memuat form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created ras hewan in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_ras' => 'required|string|max:100',
            'idjenis_hewan' => 'required|exists:jenis_hewan,idjenis_hewan',
        ], [
            'nama_ras.required' => 'Nama ras hewan harus diisi.',
            'nama_ras.max' => 'Nama ras hewan maksimal 100 karakter.',
            'idjenis_hewan.required' => 'Jenis hewan harus dipilih.',
            'idjenis_hewan.exists' => 'Jenis hewan tidak valid.',
        ]);

        try {
            // Cek duplikasi nama ras dalam jenis hewan yang sama
            $exists = DB::table('ras_hewan')
                ->where('nama_ras', $validated['nama_ras'])
                ->where('idjenis_hewan', $validated['idjenis_hewan'])
                ->exists();

            if ($exists) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Ras hewan dengan nama ini sudah ada untuk jenis hewan yang dipilih!');
            }

            DB::table('ras_hewan')->insert([
                'nama_ras' => ucwords(strtolower($validated['nama_ras'])),
                'idjenis_hewan' => $validated['idjenis_hewan']
            ]);
            
            return redirect()
                ->route('rashewan.index')
                ->with('success', 'Data ras hewan berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified ras hewan.
     */
    public function edit($id)
    {
        try {
            $rasHewan = DB::table('ras_hewan')
                ->where('idras_hewan', $id)
                ->first();

            if (!$rasHewan) {
                return redirect()
                    ->route('rashewan.index')
                    ->with('error', 'Data ras hewan tidak ditemukan.');
            }
                
            $jenisHewan = DB::table('jenis_hewan')
                ->select('idjenis_hewan', 'nama_jenis_hewan')
                ->orderBy('nama_jenis_hewan')
                ->get();
            
            return view('admin.ras-hewan.edit', compact('rasHewan', 'jenisHewan'));
        } catch (\Exception $e) {
            return redirect()
                ->route('rashewan.index')
                ->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified ras hewan in database.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_ras' => 'required|string|max:100',
            'idjenis_hewan' => 'required|exists:jenis_hewan,idjenis_hewan',
        ], [
            'nama_ras.required' => 'Nama ras hewan harus diisi.',
            'nama_ras.max' => 'Nama ras hewan maksimal 100 karakter.',
            'idjenis_hewan.required' => 'Jenis hewan harus dipilih.',
            'idjenis_hewan.exists' => 'Jenis hewan tidak valid.',
        ]);

        try {
            // Cek apakah data ada
            $exists = DB::table('ras_hewan')
                ->where('idras_hewan', $id)
                ->exists();

            if (!$exists) {
                return redirect()
                    ->route('rashewan.index')
                    ->with('error', 'Data ras hewan tidak ditemukan.');
            }

            // Cek duplikasi nama ras (kecuali data yang sedang diedit)
            $duplicate = DB::table('ras_hewan')
                ->where('nama_ras', $validated['nama_ras'])
                ->where('idjenis_hewan', $validated['idjenis_hewan'])
                ->where('idras_hewan', '!=', $id)
                ->exists();

            if ($duplicate) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Ras hewan dengan nama ini sudah ada untuk jenis hewan yang dipilih!');
            }

            DB::table('ras_hewan')
                ->where('idras_hewan', $id)
                ->update([
                    'nama_ras' => ucwords(strtolower($validated['nama_ras'])),
                    'idjenis_hewan' => $validated['idjenis_hewan']
                ]);
            
            return redirect()
                ->route('rashewan.index')
                ->with('success', 'Data ras hewan berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified ras hewan from database.
     */
    public function destroy($id)
    {
        try {
            // Cek apakah ras hewan masih digunakan oleh pet
            $hasPet = DB::table('pet')
                ->where('idras_hewan', $id)
                ->exists();

            if ($hasPet) {
                return redirect()
                    ->route('rashewan.index')
                    ->with('error', 'Ras hewan tidak dapat dihapus karena masih digunakan oleh data hewan peliharaan!');
            }

            // Cek apakah data ada
            $exists = DB::table('ras_hewan')
                ->where('idras_hewan', $id)
                ->exists();

            if (!$exists) {
                return redirect()
                    ->route('rashewan.index')
                    ->with('error', 'Data ras hewan tidak ditemukan.');
            }

            DB::table('ras_hewan')
                ->where('idras_hewan', $id)
                ->delete();
                
            return redirect()
                ->route('rashewan.index')
                ->with('success', 'Data ras hewan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()
                ->route('rashewan.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
