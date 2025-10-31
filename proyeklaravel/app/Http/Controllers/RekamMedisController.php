<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    public function index()
    {
        return response()->json(RekamMedis::with(['pet', 'dokter', 'detailRekamMedis'])->get());
    }

    public function store(Request $request)
    {
        $rekam = RekamMedis::create($request->all());
        return response()->json($rekam, 201);
    }

    public function show($id)
    {
        return response()->json(RekamMedis::with(['pet', 'dokter', 'detailRekamMedis'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $rekam = RekamMedis::findOrFail($id);
        $rekam->update($request->all());
        return response()->json($rekam);
    }

    public function destroy($id)
    {
        RekamMedis::destroy($id);
        return response()->json(['message' => 'Rekam Medis deleted']);
    }
}
