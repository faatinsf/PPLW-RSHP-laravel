@extends('layout.perawat')

@section('title', 'Dashboard Perawat')

@section('content')
<div class="page-header">
    <h1>Dashboard Perawat</h1>
    <p class="breadcrumb">Selamat datang, Perawat!</p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <h3 style="font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $totalPasien }}</h3>
        <p style="opacity: 0.9;">Total Pasien</p>
    </div>
    
    <div class="card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
        <h3 style="font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $totalRekamMedis }}</h3>
        <p style="opacity: 0.9;">Total Rekam Medis</p>
    </div>
    
    <div class="card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
        <h3 style="font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $rekamMedisHariIni }}</h3>
        <p style="opacity: 0.9;">Rekam Medis Hari Ini</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        📋 Rekam Medis Terbaru
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Pet</th>
                <th>Pemilik</th>
                <th>Diagnosa</th>
                <th>Dokter</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekamMedisTerbaru as $rm)
            <tr>
                <td>{{ \Carbon\Carbon::parse($rm->created_at)->format('d/m/Y H:i') }}</td>
                <td>{{ $rm->pet_nama }}</td>
                <td>{{ $rm->pemilik_nama }}</td>
                <td>{{ Str::limit($rm->diagnosa, 50) }}</td>
                <td>{{ $rm->dokter_nama }}</td>
                <td>
                    <a href="{{ route('perawat.rekam-medis.show', $rm->idrekam_medis) }}" class="btn btn-info btn-sm">
                        👁️ Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #718096;">
                    Belum ada rekam medis
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="card">
    <div class="card-header">
        🐾 Pasien Terdaftar
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Pet</th>
                <th>Jenis</th>
                <th>Ras</th>
                <th>Pemilik</th>
                <th>No. WA</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pasienTerbaru as $pet)
            <tr>
                <td>{{ $pet->pet_nama }}</td>
                <td>{{ $pet->nama_jenis_hewan }}</td>
                <td>{{ $pet->nama_ras }}</td>
                <td>{{ $pet->pemilik_nama }}</td>
                <td>{{ $pet->no_wa }}</td>
                <td>
                    <a href="{{ route('perawat.pasien.show', $pet->idpet) }}" class="btn btn-info btn-sm">
                        👁️ Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #718096;">
                    Belum ada data pasien
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection