<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        return response()->json(Kategori::with('kodeTindakanTerapi')->get());
    }

    public function store(Request $request)
    {
        $kategori = Kategori::create($request->all());
        return response()->json($kategori, 201);
    }

    public function show($id)
    {
        return response()->json(Kategori::with('kodeTindakanTerapi')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->update($request->all());
        return response()->json($kategori);
    }

    public function destroy($id)
    {
        Kategori::destroy($id);
        return response()->json(['message' => 'Kategori deleted']);
    }
}
