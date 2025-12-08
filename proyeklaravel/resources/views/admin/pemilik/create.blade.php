@extends('layout.admin')

@section('title', 'Tambah Pemilik | RSHP Unair')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-person-plus"></i> Tambah Data Pemilik</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('pemilik.index') }}">Data Pemilik</a></li>
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
        <form action="{{ route('pemilik.store') }}" method="POST">
            @csrf

            <!-- User -->
            <div class="mb-3">
                <label for="iduser" class="form-label fw-semibold">
                    Pilih User <span class="text-danger">*</span>
                </label>
                <select class="form-select @error('iduser') is-invalid @enderror" 
                        id="iduser" 
                        name="iduser" 
                        required>
                    <option value="">-- Pilih User --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->iduser }}" {{ old('iduser') == $user->iduser ? 'selected' : '' }}>
                            {{ $user->nama }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('iduser')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Pilih user yang akan dijadikan pemilik pet</div>
            </div>

            <!-- No WhatsApp -->
            <div class="mb-3">
                <label for="no_wa" class="form-label fw-semibold">
                    Nomor WhatsApp <span class="text-danger">*</span>
                </label>
                <input type="text" 
                       class="form-control @error('no_wa') is-invalid @enderror" 
                       id="no_wa" 
                       name="no_wa" 
                       value="{{ old('no_wa') }}"
                       placeholder="Contoh: 081234567890"
                       required>
                @error('no_wa')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Format: 08xxxxxxxxxx (maksimal 45 karakter)</div>
            </div>

            <!-- Alamat -->
            <div class="mb-3">
                <label for="alamat" class="form-label fw-semibold">
                    Alamat <span class="text-danger">*</span>
                </label>
                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                          id="alamat" 
                          name="alamat" 
                          rows="3"
                          placeholder="Masukkan alamat lengkap"
                          required>{{ old('alamat') }}</textarea>
                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Maksimal 100 karakter</div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="{{ route('pemilik.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection