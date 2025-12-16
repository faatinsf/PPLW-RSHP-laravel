@extends('layout.perawat')

@section('title', 'Edit Rekam Medis')

@section('content')
<div class="page-header">
    <h1>✏️ Edit Rekam Medis</h1>
    <p class="breadcrumb">Dashboard / Rekam Medis / Edit</p>
</div>

<a href="{{ route('perawat.rekam-medis.index', $rekamMedis->idrekam_medis) }}" class="btn btn-warning" style="margin-bottom: 1rem;">
    ← Kembali
</a>

<div class="card">
    <div class="card-header">
        Form Edit Rekam Medis
    </div>

    <form action="{{ route('perawat.rekam-medis.update', $rekamMedis->idrekam_medis) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="idpet">Pasien (Pet) <span style="color: red;">*</span></label>
            <select name="idpet" id="idpet" class="form-control" required>
                <option value="">-- Pilih Pasien --</option>
                @foreach($pasien as $p)
                    <option value="{{ $p->idpet }}" 
                            {{ old('idpet', $rekamMedis->idpet) == $p->idpet ? 'selected' : '' }}>
                        {{ $p->nama }} - {{ $p->nama_ras }} (Pemilik: {{ $p->pemilik_nama }})
                    </option>
                @endforeach
            </select>
            @error('idpet')
                <small style="color: #f56565;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="dokter_pemeriksa">Dokter Pemeriksa <span style="color: red;">*</span></label>
            <select name="dokter_pemeriksa" id="dokter_pemeriksa" class="form-control" required>
                <option value="">-- Pilih Dokter --</option>
                @foreach($dokter as $d)
                    <option value="{{ $d->idrole_user }}" 
                            {{ old('dokter_pemeriksa', $rekamMedis->dokter_pemeriksa) == $d->idrole_user ? 'selected' : '' }}>
                        {{ $d->nama }}
                    </option>
                @endforeach
            </select>
            @error('dokter_pemeriksa')
                <small style="color: #f56565;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="anamnesa">Anamnesa <span style="color: red;">*</span></label>
            <textarea name="anamnesa" 
                      id="anamnesa" 
                      class="form-control" 
                      rows="4" 
                      placeholder="Keluhan dan gejala yang dialami pasien..."
                      required>{{ old('anamnesa', $rekamMedis->anamnesa) }}</textarea>
            @error('anamnesa')
                <small style="color: #f56565;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="temuan_klinis">Temuan Klinis <span style="color: red;">*</span></label>
            <textarea name="temuan_klinis" 
                      id="temuan_klinis" 
                      class="form-control" 
                      rows="4" 
                      placeholder="Hasil pemeriksaan fisik dan klinis..."
                      required>{{ old('temuan_klinis', $rekamMedis->temuan_klinis) }}</textarea>
            @error('temuan_klinis')
                <small style="color: #f56565;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="diagnosa">Diagnosa <span style="color: red;">*</span></label>
            <textarea name="diagnosa" 
                      id="diagnosa" 
                      class="form-control" 
                      rows="4" 
                      placeholder="Diagnosis penyakit atau kondisi pasien..."
                      required>{{ old('diagnosa', $rekamMedis->diagnosa) }}</textarea>
            @error('diagnosa')
                <small style="color: #f56565;">{{ $message }}</small>
            @enderror
        </div>

        <div style="display: flex; gap: 0.5rem;">
            <button type="submit" class="btn btn-primary">
                💾 Update Rekam Medis
            </button>
            <a href="{{ route('perawat.rekam-medis.index', $rekamMedis->idrekam_medis) }}" class="btn btn-warning">
                ❌ Batal
            </a>
        </div>
    </form>
</div>
@endsection