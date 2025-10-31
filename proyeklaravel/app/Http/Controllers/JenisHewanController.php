<?php

namespace App\Http\Controllers;

use App\Models\JenisHewan;
use Illuminate\Http\Request;

class JenisHewanController extends Controller
{
    public function index()
    {
        return response()->json(JenisHewan::with('rasHewan')->get());
    }

    public function store(Request $request)
    {
        $jenis = JenisHewan::create($request->all());
        return response()->json($jenis, 201);
    }

    public function show($id)
    {
        return response()->json(JenisHewan::with('rasHewan')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $jenis = JenisHewan::findOrFail($id);
        $jenis->update($request->all());
        return response()->json($jenis);
    }

    public function destroy($id)
    {
        JenisHewan::destroy($id);
        return response()->json(['message' => 'Jenis Hewan deleted']);
    }
}
