<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Pemilik;
use App\Models\RasHewan;
use Illuminate\Http\Request;

class PetController extends Controller
{
    // 🧾 Tampilkan semua data hewan peliharaan
    public function index()
    {
        $pets = Pet::with(['pemilik', 'rasHewan'])->get();

        return view('admin.pet.index', compact('pets'));
    }

    // ➕ Form tambah data hewan
    public function create()
    {
        $pemilik = Pemilik::all();
        $rasHewan = RasHewan::with('jenisHewan')->get();

        return view('admin.pet.create', compact('pemilik', 'rasHewan'));
    }

    // 💾 Simpan data hewan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_hewan' => 'required|string|max:100',
            'jenis_kelamin' => 'required|string|max:10',
            'idpemilik' => 'required|exists:pemilik,idpemilik',
            'idras_hewan' => 'required|exists:ras_hewan,idras_hewan',
        ]);

        Pet::create($validated);

        return redirect()->route('admin.pet.index')
            ->with('success', 'Data hewan berhasil ditambahkan.');
    }

    // 👁️ Detail hewan
    public function show($id)
    {
        $pet = Pet::with(['pemilik', 'rasHewan'])->findOrFail($id);

        return view('admin.pet.show', compact('pet'));
    }

    // ✏️ Edit data hewan
    public function edit($id)
    {
        $pet = Pet::findOrFail($id);
        $pemilik = Pemilik::all();
        $rasHewan = RasHewan::all();

        return view('admin.pet.edit', compact('pet', 'pemilik', 'rasHewan'));
    }

    // 🔁 Update data
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_hewan' => 'required|string|max:100',
            'jenis_kelamin' => 'required|string|max:10',
            'idpemilik' => 'required|exists:pemilik,idpemilik',
            'idras_hewan' => 'required|exists:ras_hewan,idras_hewan',
        ]);

        $pet = Pet::findOrFail($id);
        $pet->update($validated);

        return redirect()->route('admin.pet.index')
            ->with('success', 'Data hewan berhasil diperbarui.');
    }

    // ❌ Hapus data
    public function destroy($id)
    {
        $pet = Pet::findOrFail($id);
        $pet->delete();

        return redirect()->route('admin.pet.index')
            ->with('success', 'Data hewan berhasil dihapus.');
    }
}
