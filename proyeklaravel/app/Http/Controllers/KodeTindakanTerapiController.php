<?php

namespace App\Http\Controllers;

use App\Models\KodeTindakanTerapi;
use App\Models\Kategori;
use App\Models\KategoriKlinis;
use Illuminate\Http\Request;

class KodeTindakanTerapiController extends Controller
{
    public function index()
    {
        $kodeTindakan = KodeTindakanTerapi::with(['kategori', 'kategoriKlinis'])->get();
        $kategori = Kategori::all();
        $kategoriKlinis = KategoriKlinis::all();

        return view('admin.kodetindakanterapi.index', compact('kodeTindakan', 'kategori', 'kategoriKlinis'));
    }

    public function store(Request $request)
    {
        KodeTindakanTerapi::create($request->all());
        return redirect()->route('admin.kodetindakanterapi.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $data = KodeTindakanTerapi::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('admin.kodetindakanterapi.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        KodeTindakanTerapi::destroy($id);
        return redirect()->route('admin.kodetindakanterapi.index')->with('success', 'Data berhasil dihapus!');
    }
}
