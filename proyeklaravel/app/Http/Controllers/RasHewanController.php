<?php

namespace App\Http\Controllers;

use App\Models\RasHewan;
use App\Models\JenisHewan;
use Illuminate\Http\Request;

class RasHewanController extends Controller
{
    public function index()
    {
        // Ambil semua data ras hewan beserta relasinya ke jenis hewan
        $rasHewan = RasHewan::with('jenisHewan')->get();

        // Kirim ke view
        return view('admin.rashewan.index', compact('rasHewan'));
    }

    public function create()
    {
        $jenisHewan = JenisHewan::all();
        return view('admin.rashewan.create', compact('jenisHewan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_ras' => 'required|string|max:100',
            'idjenis_hewan' => 'required|exists:jenis_hewan,idjenis_hewan',
        ]);

        RasHewan::create($validated);

        return redirect()->route('admin.rashewan.index')
            ->with('success', 'Ras hewan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $ras = RasHewan::with('jenisHewan')->findOrFail($id);
        return view('admin.rashewan.show', compact('ras'));
    }

    public function edit($id)
    {
        $ras = RasHewan::findOrFail($id);
        $jenisHewan = JenisHewan::all();
        return view('admin.rashewan.edit', compact('ras', 'jenisHewan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_ras' => 'required|string|max:100',
            'idjenis_hewan' => 'required|exists:jenis_hewan,idjenis_hewan',
        ]);

        $ras = RasHewan::findOrFail($id);
        $ras->update($validated);

        return redirect()->route('admin.rashewan.index')
            ->with('success', 'Ras hewan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $ras = RasHewan::findOrFail($id);
        $ras->delete();

        return redirect()->route('admin.rashewan.index')
            ->with('success', 'Ras hewan berhasil dihapus.');
    }
}
