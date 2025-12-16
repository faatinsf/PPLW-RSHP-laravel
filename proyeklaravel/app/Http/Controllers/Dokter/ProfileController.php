<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the dokter's profile.
     */
    public function index()
    {
        $userId = Auth::id();
        
        // Get user data
        $dokter = DB::table('user')
            ->where('iduser', $userId)
            ->first();
        
        // Get role user data untuk mendapatkan informasi tambahan
        $roleUser = DB::table('role_user')
            ->join('role', 'role_user.idrole', '=', 'role.idrole')
            ->where('role_user.iduser', $userId)
            ->where('role.idrole', 2) // 2 = Dokter
            ->first();
        
        // Get statistics
        $stats = [
            'total_pasien' => DB::table('rekam_medis')
                ->join('role_user', 'rekam_medis.dokter_pemeriksa', '=', 'role_user.idrole_user')
                ->where('role_user.iduser', $userId)
                ->distinct('idpet')
                ->count('idpet'),
            
            'total_rekam_medis' => DB::table('rekam_medis')
                ->join('role_user', 'rekam_medis.dokter_pemeriksa', '=', 'role_user.idrole_user')
                ->where('role_user.iduser', $userId)
                ->count(),
            
            'rekam_medis_bulan_ini' => DB::table('rekam_medis')
                ->join('role_user', 'rekam_medis.dokter_pemeriksa', '=', 'role_user.idrole_user')
                ->where('role_user.iduser', $userId)
                ->whereMonth('rekam_medis.created_at', date('m'))
                ->whereYear('rekam_medis.created_at', date('Y'))
                ->count(),
        ];
        
        return view('dokter.profile', compact('dokter', 'roleUser', 'stats'));
    }

    /**
     * Update the dokter's profile information.
     */
    public function update(Request $request)
    {
        $userId = Auth::id();

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:500'],
            'email' => ['required', 'string', 'email', 'max:200', 'unique:user,email,' . $userId . ',iduser'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'spesialisasi' => ['nullable', 'string', 'max:255'],
            'no_sip' => ['nullable', 'string', 'max:100'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Get current foto
            $currentUser = DB::table('user')->where('iduser', $userId)->first();
            
            // Delete old foto if exists
            if (isset($currentUser->foto) && $currentUser->foto && Storage::disk('public')->exists($currentUser->foto)) {
                Storage::disk('public')->delete($currentUser->foto);
            }

            // Store new foto
            $fotoPath = $request->file('foto')->store('dokter/photos', 'public');
            $validated['foto'] = $fotoPath;
        }

        // Update user data
        DB::table('user')
            ->where('iduser', $userId)
            ->update([
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'no_hp' => $validated['no_hp'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
                'foto' => $validated['foto'] ?? DB::raw('foto'),
                'spesialisasi' => $validated['spesialisasi'] ?? null,
                'no_sip' => $validated['no_sip'] ?? null,
            ]);

        return redirect()->route('dokter.profile')
            ->with('success', 'Profile berhasil diperbarui!');
    }

    /**
     * Update the dokter's password.
     */
    public function updatePassword(Request $request)
    {
        $userId = Auth::id();
        
        $validated = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Get current user
        $user = DB::table('user')->where('iduser', $userId)->first();
        
        // Verify current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
        }

        // Update password
        DB::table('user')
            ->where('iduser', $userId)
            ->update([
                'password' => Hash::make($validated['password'])
            ]);

        return redirect()->route('dokter.profile')
            ->with('success', 'Password berhasil diperbarui!');
    }

    /**
     * Remove the dokter's photo.
     */
    public function deletePhoto()
    {
        $userId = Auth::id();
        
        $user = DB::table('user')->where('iduser', $userId)->first();

        if (isset($user->foto) && $user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
            
            DB::table('user')
                ->where('iduser', $userId)
                ->update(['foto' => null]);
        }

        return redirect()->route('dokter.profile')
            ->with('success', 'Foto profile berhasil dihapus!');
    }
}