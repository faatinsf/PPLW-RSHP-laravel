@extends('layout.admin')

@section('title', 'Tambah Rekam Medis | RSHP Unair')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-plus-circle"></i> Tambah Rekam Medis</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('rekammedis.index') }}">Data Rekam Medis</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<!-- Alert Error -->
@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle-fill"></i> <strong>Terdapat kesalahan:</strong>
    <ul class="mb-0 mt-2">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <form action="{{ route('rekammedis.store') }}" method="POST">
            @csrf

            <div class="row">
                <!-- Hewan Peliharaan -->
                <div class="col-md-6 mb-3">
                    <label for="idpet" class="form-label fw-semibold">
                        Hewan Peliharaan <span class="text-danger">*</span>
                    </label>
                    <select class="form-select @error('idpet') is-invalid @enderror" 
                            id="idpet" 
                            name="idpet" 
                            required>
                        <option value="">-- Pilih Hewan --</option>
                        @foreach($pets as $pet)
                            <option value="{{ $pet->idpet }}" {{ old('idpet') == $pet->idpet ? 'selected' : '' }}>
                                {{ $pet->nama_pet }} - {{ $pet->nama_ras }} ({{ $pet->nama_pemilik }})
                            </option>
                        @endforeach
                    </select>
                    @error('idpet')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Dokter Pemeriksa -->
                <div class="col-md-6 mb-3">
                    <label for="dokter_pemeriksa" class="form-label fw-semibold">
                        Dokter Pemeriksa <span class="text-danger">*</span>
                    </label>
                    <select class="form-select @error('dokter_pemeriksa') is-invalid @enderror" 
                            id="dokter_pemeriksa" 
                            name="dokter_pemeriksa" 
                            required>
                        <option value="">-- Pilih Dokter --</option>
                        @foreach($dokters as $dokter)
                            <option value="{{ $dokter->idrole_user }}" 
                                    {{ old('dokter_pemeriksa') == $dokter->idrole_user ? 'selected' : '' }}>
                                {{ $dokter->nama }} ({{ $dokter->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('dokter_pemeriksa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Anamnesa -->
            <div class="mb-3">
                <label for="anamnesa" class="form-label fw-semibold">
                    Anamnesa <span class="text-danger">*</span>
                </label>
                <textarea class="form-control @error('anamnesa') is-invalid @enderror" 
                          id="anamnesa" 
                          name="anamnesa" 
                          rows="4"
                          placeholder="Keluhan atau riwayat kesehatan yang disampaikan pemilik..."
                          required>{{ old('anamnesa') }}</textarea>
                @error('anamnesa')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Maksimal 1000 karakter</div>
            </div>

            <!-- Temuan Klinis -->
            <div class="mb-3">
                <label for="temuan_klinis" class="form-label fw-semibold">
                    Temuan Klinis <span class="text-danger">*</span>
                </label>
                <textarea class="form-control @error('temuan_klinis') is-invalid @enderror" 
                          id="temuan_klinis" 
                          name="temuan_klinis" 
                          rows="4"
                          placeholder="Hasil pemeriksaan fisik dan klinis..."
                          required>{{ old('temuan_klinis') }}</textarea>
                @error('temuan_klinis')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Maksimal 1000 karakter</div>
            </div>

            <!-- Diagnosa -->
            <div class="mb-3">
                <label for="diagnosa" class="form-label fw-semibold">
                    Diagnosa <span class="text-danger">*</span>
                </label>
                <textarea class="form-control @error('diagnosa') is-invalid @enderror" 
                          id="diagnosa" 
                          name="diagnosa" 
                          rows="3"
                          placeholder="Kesimpulan diagnosa berdasarkan anamnesa dan temuan klinis..."
                          required>{{ old('diagnosa') }}</textarea>
                @error('diagnosa')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Maksimal 1000 karakter</div>
            </div>

            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> 
                <strong>Catatan:</strong> Detail tindakan/terapi dapat ditambahkan setelah rekam medis ini disimpan.
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="{{ route('rekammedis.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection