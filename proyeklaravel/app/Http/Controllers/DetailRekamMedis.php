<?php

namespace App\Http\Controllers;

use App\Models\DetailRekamMedis;
use Illuminate\Http\Request;

class DetailRekamMedisController extends Controller
{
    public function index()
    {
        return response()->json(DetailRekamMedis::with(['rekamMedis', 'tindakanTerapi'])->get());
    }

    public function store(Request $request)
    {
        $detail = DetailRekamMedis::create($request->all());
        return response()->json($detail, 201);
    }

    public function show($id)
    {
        return response()->json(DetailRekamMedis::with(['rekamMedis', 'tindakanTerapi'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $detail = DetailRekamMedis::findOrFail($id);
        $detail->update($request->all());
        return response()->json($detail);
    }

    public function destroy($id)
    {
        DetailRekamMedis::destroy($id);
        return response()->json(['message' => 'Detail Rekam Medis deleted']);
    }
}
