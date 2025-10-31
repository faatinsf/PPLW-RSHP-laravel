<?php

namespace App\Http\Controllers;

use App\Models\KodeTindakanTerapi;
use Illuminate\Http\Request;

class KodeTindakanTerapiController extends Controller
{
    public function index()
    {
        return response()->json(KodeTindakanTerapi::with(['kategori', 'kategoriKlinis'])->get());
    }

    public function store(Request $request)
    {
        $kode = KodeTindakanTerapi::create($request->all());
        return response()->json($kode, 201);
    }

    public function show($id)
    {
        return response()->json(KodeTindakanTerapi::with(['kategori', 'kategoriKlinis'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $kode = KodeTindakanTerapi::findOrFail($id);
        $kode->update($request->all());
        return response()->json($kode);
    }

    public function destroy($id)
    {
        KodeTindakanTerapi::destroy($id);
        return response()->json(['message' => 'Kode Tindakan Terapi deleted']);
    }
}
