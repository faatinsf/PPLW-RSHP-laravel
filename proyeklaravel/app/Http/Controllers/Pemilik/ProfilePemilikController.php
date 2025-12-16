<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfilePemilikController extends Controller
{
    /**
     * Display profile page.
     */
    public function index()
    {
        $userId = Auth::id();
        
        // Get pemilik data with user data
        $pemilik = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->where('pemilik.iduser', $userId)
            ->select(
                'pemilik.*',
                'user.nama',
                'user.email',
                'user.no_hp',
                'user.alamat',
                'user.foto',
                'user.created_at'
            )
            ->first();
        
        if (!$pemilik) {
            return redirect()->route('pemilik.dashboard')
                ->with('error', 'Data pemilik tidak ditemukan');
        }
        
        // Get statistics
        $stats = $this->getProfileStatistics($pemilik->idpemilik);
        
        // Get pets
        $pets = DB::table('pet')
            ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->where('pet.idpemilik', $pemilik->idpemilik)
            ->select(
                'pet.*',
                'ras_hewan.nama_ras',
                'jenis_hewan.nama_jenis_hewan'
            )
            ->get();
        
        return view('pemilik.profile', compact('pemilik', 'stats', 'pets'));
    }
    
    /**
     * Update profile information.
     */
    public function update(Request $request)
    {
        $userId = Auth::id();
        
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:500'],
            'email' => ['required', 'string', 'email', 'max:200', 'unique:user,email,' . $userId . ',iduser'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'no_wa' => ['nullable', 'string', 'max:45'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);
        
        // Get current user data
        $currentUser = DB::table('user')->where('iduser', $userId)->first();
        
        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Delete old foto if exists
            if (isset($currentUser->foto) && $currentUser->foto && Storage::disk('public')->exists($currentUser->foto)) {
                Storage::disk('public')->delete($currentUser->foto);
            }
            
            // Store new foto
            $fotoPath = $request->file('foto')->store('pemilik/photos', 'public');
            $validated['foto'] = $fotoPath;
        }
        
        // Update user table
        DB::table('user')
            ->where('iduser', $userId)
            ->update([
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'no_hp' => $validated['no_hp'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
                'foto' => $validated['foto'] ?? $currentUser->foto,
            ]);
        
        // Update pemilik table
        DB::table('pemilik')
            ->where('iduser', $userId)
            ->update([
                'no_wa' => $validated['no_wa'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
            ]);
        
        return redirect()->route('pemilik.profile')
            ->with('success', 'Profile berhasil diperbarui!');
    }
    
    /**
     * Update password.
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
        
        return redirect()->route('pemilik.profile')
            ->with('success', 'Password berhasil diperbarui!');
    }
    
    /**
     * Delete profile photo.
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
        
        return redirect()->route('pemilik.profile')
            ->with('success', 'Foto profile berhasil dihapus!');
    }
    
    /**
     * Get profile statistics.
     */
    private function getProfileStatistics($idPemilik)
    {
        return [
            'total_pets' => DB::table('pet')
                ->where('idpemilik', $idPemilik)
                ->count(),
            
            'total_visits' => DB::table('rekam_medis')
                ->join('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
                ->where('pet.idpemilik', $idPemilik)
                ->count(),
            
            'upcoming_appointments' => DB::table('appointment')
                ->where('idpemilik', $idPemilik)
                ->whereIn('status', ['pending', 'dikonfirmasi'])
                ->where('tanggal_appointment', '>=', date('Y-m-d'))
                ->count(),
            
            'member_since' => DB::table('user')
                ->join('pemilik', 'user.iduser', '=', 'pemilik.iduser')
                ->where('pemilik.idpemilik', $idPemilik)
                ->value('user.created_at'),
        ];
    }
}