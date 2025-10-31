<?php

namespace App\Http\Controllers;

use App\Models\Pemilik;
use Illuminate\Http\Request;

class PemilikController extends Controller
{
    public function index()
    {
        return response()->json(Pemilik::with(['user', 'pets'])->get());
    }

    public function store(Request $request)
    {
        $pemilik = Pemilik::create($request->all());
        return response()->json($pemilik, 201);
    }

    public function show($id)
    {
        return response()->json(Pemilik::with(['user', 'pets'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $pemilik = Pemilik::findOrFail($id);
        $pemilik->update($request->all());
        return response()->json($pemilik);
    }

    public function destroy($id)
    {
        Pemilik::destroy($id);
        return response()->json(['message' => 'Pemilik deleted']);
    }
}
