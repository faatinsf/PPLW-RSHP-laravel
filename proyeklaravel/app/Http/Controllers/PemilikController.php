<?php

namespace App\Http\Controllers;

use App\Models\Pemilik;
use Illuminate\Http\Request;

class PemilikController extends Controller
{
    public function index()
    {
        // Ambil semua data pemilik + relasi user & pets,
        // tapi paksa relasi user-nya pakai iduser, bukan id
        $pemilik = Pemilik::all()->map(function ($item) {
            $item->user = \App\Models\User::where('iduser', $item->iduser)->first();
            $item->pets = $item->pets; // biar relasi pets tetap ikut
            return $item;
        });

        return view('admin.pemilik.index', compact('pemilik'));
    }

    public function store(Request $request)
    {
        Pemilik::create($request->all());
        return redirect()->route('admin.pemilik.index')->with('success', 'Data pemilik berhasil ditambahkan!');
    }

    // public function show($id)
    // {
    //     $pemilik = Pemilik::findOrFail($id);
    //     $pemilik->user = \App\Models\User::where('iduser', $pemilik->iduser)->first();
    //     $pemilik->pets = $pemilik->pets;

    //     return view('admin.pemilik.show', compact('pemilik'));
    // }

     public function update(Request $request, $id)
    {
        $pemilik = Pemilik::findOrFail($id);
        $pemilik->update($request->all());
        return redirect()->route('admin.pemilik.index')->with('success', 'Data pemilik berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Pemilik::destroy($id);
        return redirect()->route('admin.pemilik.index')->with('success', 'Data pemilik berhasil dihapus!');
    }
}
