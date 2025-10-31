<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    public function index()
    {
        // Ambil semua data dengan relasi pet, dokter, dan detail rekam medis
        $rekamMedis = RekamMedis::with(['pet', 'dokter', 'detailRekamMedis'])->get();

        // Kirim ke view
        return view('admin.rekammedis.index', compact('rekamMedis'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'idpet' => 'required|exists:pet,idpet',
            'dokter_pemeriksa' => 'required|exists:role_user,idrole_user',
            'tanggal_periksa' => 'required|date',
            'diagnosa' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        RekamMedis::create($validated);
        return redirect()->route('admin.rekammedis.index')->with('success', 'Rekam medis berhasil ditambahkan');
    }

    public function show($id)
    {
        $rekamMedis = RekamMedis::with(['pet', 'dokter', 'detailRekamMedis'])->findOrFail($id);
        return view('admin.rekammedis.show', compact('rekamMedis'));
    }

    public function edit($id)
    {
        $rekamMedis = RekamMedis::findOrFail($id);
        return view('admin.rekammedis.edit', compact('rekamMedis'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'idpet' => 'required|exists:pet,idpet',
            'dokter_pemeriksa' => 'required|exists:role_user,idrole_user',
            'tanggal_periksa' => 'required|date',
            'diagnosa' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $rekamMedis = RekamMedis::findOrFail($id);
        $rekamMedis->update($validated);

        return redirect()->route('admin.rekammedis.index')->with('success', 'Rekam medis berhasil diperbarui');
    }

    public function destroy($id)
    {
        $rekamMedis = RekamMedis::findOrFail($id);
        $rekamMedis->delete();

        return redirect()->route('admin.rekammedis.index')->with('success', 'Rekam medis berhasil dihapus');
    }
}
