<?php

namespace App\Http\Controllers;

use App\Models\RasHewan;
use Illuminate\Http\Request;

class RasHewanController extends Controller
{
    public function index()
    {
        return response()->json(RasHewan::with('jenisHewan')->get());
    }

    public function store(Request $request)
    {
        $ras = RasHewan::create($request->all());
        return response()->json($ras, 201);
    }

    public function show($id)
    {
        return response()->json(RasHewan::with('jenisHewan')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $ras = RasHewan::findOrFail($id);
        $ras->update($request->all());
        return response()->json($ras);
    }

    public function destroy($id)
    {
        RasHewan::destroy($id);
        return response()->json(['message' => 'Ras Hewan deleted']);
    }
}
