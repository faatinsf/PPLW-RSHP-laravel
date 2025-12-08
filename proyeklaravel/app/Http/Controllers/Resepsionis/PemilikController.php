<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemilikController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->select('pemilik.*', 'user.nama', 'user.email');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('user.nama', 'like', "%{$request->search}%")
                  ->orWhere('user.email', 'like', "%{$request->search}%")
                  ->orWhere('pemilik.no_wa', 'like', "%{$request->search}%");
            });
        }

        $owners = $query->paginate(15);

        return view('resepsionis.pemilik.index', compact('owners'));
    }

    public function create()
    {
        return view('resepsionis.pemilik.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:user,email',
            'password' => 'required',
            'no_wa' => 'required',
            'alamat' => 'required',
        ]);

        $iduser = DB::table('user')->insertGetId([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        DB::table('pemilik')->insert([
            'no_wa' => $request->no_wa,
            'alamat' => $request->alamat,
            'iduser' => $iduser,
        ]);

        return redirect()->route('resepsionis.pemilik.index')->with('success', 'Pemilik berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pemilik = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->select('pemilik.*', 'user.nama', 'user.email')
            ->where('pemilik.idpemilik', $id)
            ->first();

        return view('resepsionis.pemilik.edit', compact('pemilik'));
    }

    public function update(Request $request, $id)
    {
        $pemilik = DB::table('pemilik')->where('idpemilik', $id)->first();

        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:user,email,' . $pemilik->iduser . ',iduser',
            'no_wa' => 'required',
            'alamat' => 'required',
        ]);

        DB::table('user')->where('iduser', $pemilik->iduser)->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        DB::table('pemilik')->where('idpemilik', $id)->update([
            'no_wa' => $request->no_wa,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('resepsionis.pemilik.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::table('pemilik')->where('idpemilik', $id)->delete();

        return redirect()->route('resepsionis.pemilik.index')->with('success', 'Data berhasil dihapus.');
    }
}
    