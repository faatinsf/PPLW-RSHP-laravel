@extends('perawat.layout')

@section('title', 'Detail Pasien')

@section('content')
<div class="page-header">
    <h1>🐾 Detail Pasien</h1>
    <p class="breadcrumb">Dashboard / Data Pasien / Detail</p>
</div>

<a href="{{ route('perawat.pasien.index') }}" class="btn btn-warning" style="margin-bottom: 1rem;">
    ← Kembali
</a>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
    <!-- Info Pasien -->
    <div class="card">
        <div class="card-header">
            📋 Informasi Pasien
        </div>
        <table style="width: 100%;">
            <tr>
                <td style="padding: 0.75rem; font-weight: 600; width: 40%;">Nama Pet</td>
                <td style="padding: 0.75rem;">{{ $pasien->nama }}</td>
            </tr>
            <tr>
                <td style="padding: 0.75rem; font-weight: 600; background: #f7fafc;">Jenis Kelamin</td>
                <td style="padding: 0.75rem; background: #f7fafc;">
                    @if($pasien->jenis_kelamin == 'M')
                        <span class="badge badge-info">♂ Jantan</span>
                    @else
                        <span class="badge badge-danger">♀ Betina</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="padding: 0.75rem; font-weight: 600;">Tanggal Lahir</td>
                <td style="padding: 0.75rem;">
                    {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d F Y') }}
                    <br>
                    <small style="color: #718096;">
                        ({{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} tahun)
                    </small>
                </td>
            </tr>
            <tr>
                <td style="padding: 0.75rem; font-weight: 600; background: #f7fafc;">Warna/Tanda</td>
                <td style="padding: 0.75rem; background: #f7fafc;">{{ $pasien->warna_tanda }}</td>
            </tr>
            <tr>
                <td style="padding: 0.75rem; font-weight: 600;">Jenis Hewan</td>
                <td style="padding: 0.75rem;">{{ $pasien->nama_jenis_hewan }}</td>
            </tr>
            <tr>
                <td style="padding: 0.75rem; font-weight: 600; background: #f7fafc;">Ras</td>
                <td style="padding: 0.75rem; background: #f7fafc;">{{ $pasien->nama_ras }}</td>
            </tr>
        </table>
    </div>

    <!-- Info Pemilik -->
    <div class="card">
        <div class="card-header">
            👤 Informasi Pemilik
        </div>
        <table style="width: 100%;">
            <tr>
                <td style="padding: 0.75rem; font-weight: 600; width: 40%;">Nama Pemilik</td>
                <td style="padding: 0.75rem;">{{ $pasien->pemilik_nama }}</td>
            </tr>
            <tr>
                <td style="padding: 0.75rem; font-weight: 600; background: #f7fafc;">Email</td>
                <td style="padding: 0.75rem; background: #f7fafc;">{{ $pasien->pemilik_email }}</td>
            </tr>
            <tr>
                <td style="padding: 0.75rem; font-weight: 600;">No. WhatsApp</td>
                <td style="padding: 0.75rem;">
                    <a href="https://wa.me/{{ $pasien->no_wa }}" 
                       target="_blank" 
                       style="color: #48bb78; text-decoration: none;">
                        📱 {{ $pasien->no_wa }}
                    </a>
                </td>
            </tr>
            <tr>
                <td style="padding: 0.75rem; font-weight: 600; background: #f7fafc;">Alamat</td>
                <td style="padding: 0.75rem; background: #f7fafc;">{{ $pasien->alamat }}</td>
            </tr>
        </table>
    </div>
</div>

<!-- Riwayat Rekam Medis -->
<div class="card">
    <div class="card-header">
        📋 Riwayat Rekam Medis
    </div>
    
    @if($riwayatRekamMedis->count() > 0)
        @foreach($riwayatRekamMedis as $rm)
        <div style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.75rem;">
                <div>
                    <strong style="color: #2d3748;">
                        📅 {{ \Carbon\Carbon::parse($rm->created_at)->format('d F Y, H:i') }} WIB
                    </strong>
                    <br>
                    <small style="color: #718096;">Dokter: {{ $rm->dokter_nama }}</small>
                </div>
                <a href="{{ route('perawat.rekam-medis.show', $rm->idrekam_medis) }}" class="btn btn-info btn-sm">
                    👁️ Detail
                </a>
            </div>
            
            <div style="background: #f7fafc; padding: 0.75rem; border-radius: 6px; margin-bottom: 0.5rem;">
                <strong>Anamnesa:</strong>
                <p style="margin: 0.25rem 0 0 0; color: #4a5568;">{{ $rm->anamnesa }}</p>
            </div>
            
            <div style="background: #f7fafc; padding: 0.75rem; border-radius: 6px; margin-bottom: 0.5rem;">
                <strong>Temuan Klinis:</strong>
                <p style="margin: 0.25rem 0 0 0; color: #4a5568;">{{ $rm->temuan_klinis }}</p>
            </div>
            
            <div style="background: #fef5e7; padding: 0.75rem; border-radius: 6px; border-left: 3px solid #f39c12;">
                <strong>Diagnosa:</strong>
                <p style="margin: 0.25rem 0 0 0; color: #4a5568;">{{ $rm->diagnosa }}</p>
            </div>
        </div>
        @endforeach
    @else
        <p style="text-align: center; color: #718096; padding: 2rem;">
            Belum ada riwayat rekam medis
        </p>
    @endif
</div>
@endsection