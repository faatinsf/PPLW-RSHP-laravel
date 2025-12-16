<?php

namespace App\Http\Controllers\Perawat;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{


    public function index()
    {
        $user = DB::table('user as u')
    ->join('role_user as ru', 'u.iduser', '=', 'ru.iduser')
    ->where('ru.idrole', 3) // Role Perawat
    ->select('u.*')
    ->first();

   
        $roleUser = DB::table('role_user as ru')
    ->join('role as r', 'ru.idrole', '=', 'r.idrole')
    ->join('user as u', 'ru.iduser', '=', 'u.iduser')
    ->where('r.idrole', 3) // Role Perawat
    ->select('ru.*', 'r.nama_role', 'u.nama')
    ->first();

        
        // Statistik aktivitas
        $totalRekamMedis = DB::table('rekam_medis')->count();
        
        $rekamMedisBulanIni = DB::table('rekam_medis')
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->count();
        
        return view('perawat.profil', compact('user', 'roleUser', 'totalRekamMedis', 'rekamMedisBulanIni'));
    }
    
    public function update(Request $request)
    {
         $user = DB::table('user as u')
    ->join('role_user as ru', 'u.iduser', '=', 'ru.iduser')
    ->where('ru.idrole', 3) // Role Perawat
    ->select('u.*')
    ->first();
        
        $request->validate([
            'nama' => 'required|string|max:500',
            'email' => 'required|email|unique:user,email,' . $user->iduser . ',iduser',
            'password_lama' => 'nullable',
            'password_baru' => 'nullable|min:6|confirmed',
        ], [
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password_baru.min' => 'Password minimal 6 karakter',
            'password_baru.confirmed' => 'Konfirmasi password tidak cocok',
        ]);
        
        // Update data dasar
        $updateData = [
            'nama' => $request->nama,
            'email' => $request->email,
        ];
        
        // Jika mengubah password
        if ($request->filled('password_lama')) {
            if (!Hash::check($request->password_lama, $user->password)) {
                return back()->with('error', 'Password lama tidak sesuai');
            }
            
            $updateData['password'] = Hash::make($request->password_baru);
        }
        
        DB::table('user')
            ->where('iduser', $user->iduser)
            ->update($updateData);
        
        return back()->with('success', 'Profil berhasil diperbarui');
    }
} 

