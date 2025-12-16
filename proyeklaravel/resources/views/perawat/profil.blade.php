@extends('layout.perawat')

@section('title', 'Profil Saya')

@section('content')
<div class="page-header">
    <h1>👤 Profil Saya</h1>
    <p class="breadcrumb">Dashboard / Profil</p>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem;">
    <!-- Info Card -->
    <div class="card" style="text-align: center;">
        <div style="width: 150px; height: 150px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 4rem; color: white;">
            👤
        </div>
        <h2 style="color: #2d3748; margin-bottom: 0.5rem;"> {{ $user->nama }}</h2>
        <p style="color: #718096; margin-bottom: 1rem;">{{ $roleUser->nama_role }}</p>
        
        <div style="background: #f7fafc; padding: 1rem; border-radius: 8px; margin-top: 1.5rem;">
            <div style="margin-bottom: 1rem;">
                <div style="font-size: 2rem; font-weight: bold; color: #667eea;">{{ $totalRekamMedis }}</div>
                <div style="color: #718096; font-size: 0.9rem;">Total Rekam Medis</div>
            </div>
            <div>
                <div style="font-size: 2rem; font-weight: bold; color: #48bb78;">{{ $rekamMedisBulanIni }}</div>
                <div style="color: #718096; font-size: 0.9rem;">Bulan Ini</div>
            </div>
        </div>
    </div>


    <!-- Form Edit Profil -->
    <div class="card">
        <div class="card-header">
            ✏️ Edit Profil
        </div>

        <form action="{{ route('perawat.profil.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="nama">Nama Lengkap <span style="color: red;">*</span></label>
                <input type="text" 
                       name="nama" 
                       id="nama" 
                       class="form-control" 
                       value="{{ old('nama', $user->nama) }}"
                       required>
                @error('nama')
                    <small style="color: #f56565;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email <span style="color: red;">*</span></label>
                <input type="email" 
                       name="email" 
                       id="email" 
                       class="form-control" 
                       value="{{ old('email', $user->email) }}"
                       required>
                @error('email')
                    <small style="color: #f56565;">{{ $message }}</small>
                @enderror
            </div>

            <hr style="margin: 2rem 0;">
            
            <h3 style="color: #2d3748; font-size: 1.2rem; margin-bottom: 1rem;">🔒 Ubah Password</h3>
            <p style="color: #718096; font-size: 0.9rem; margin-bottom: 1rem;">
                Kosongkan jika tidak ingin mengubah password
            </p>

            <div class="form-group">
                <label for="password_lama">Password Lama</label>
                <input type="password" 
                       name="password_lama" 
                       id="password_lama" 
                       class="form-control" 
                       placeholder="Masukkan password lama">
                @error('password_lama')
                    <small style="color: #f56565;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_baru">Password Baru</label>
                <input type="password" 
                       name="password_baru" 
                       id="password_baru" 
                       class="form-control" 
                       placeholder="Masukkan password baru (min. 6 karakter)">
                @error('password_baru')
                    <small style="color: #f56565;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_baru_confirmation">Konfirmasi Password Baru</label>
                <input type="password" 
                       name="password_baru_confirmation" 
                       id="password_baru_confirmation" 
                       class="form-control" 
                       placeholder="Ulangi password baru">
            </div>

            <button type="submit" class="btn btn-primary">
                💾 Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection