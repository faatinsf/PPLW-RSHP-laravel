<?php

namespace App\Http\Controllers;

use App\Models\KategoriKlinis;
use Illuminate\Http\Request;

class KategoriKlinisController extends Controller
{
    public function index()
    {
        return response()->json(KategoriKlinis::with('kodeTindakanTerapi')->get());
    }

    public function store(Request $request)
    {
        $kat = KategoriKlinis::create($request->all());
        return response()->json($kat, 201);
    }

    public function show($id)
    {
        return response()->json(KategoriKlinis::with('kodeTindakanTerapi')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $kat = KategoriKlinis::findOrFail($id);
        $kat->update($request->all());
        return response()->json($kat);
    }

    public function destroy($id)
    {
        KategoriKlinis::destroy($id);
        return response()->json(['message' => 'Kategori Klinis deleted']);
    }
}
