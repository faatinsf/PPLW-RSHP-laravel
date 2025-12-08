@extends('layout.admin')

@section('title', 'Edit Pemilik | RSHP Unair')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-pencil-square"></i> Edit Data Pemilik</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('pemilik.index') }}">Data Pemilik</a></li>
            <li class="breadcrumb-item active">Edit</li>
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
        <form action="{{ route('pemilik.update', $pemilik->idpemilik) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- ID (Read-only) -->
            <div class="mb-3">
                <label for="id" class="form-label fw-semibold">ID Pemilik</label>
                <input type="text" 
                       class="form-control" 
                       id="id" 
                       value="{{ $pemilik->idpemilik }}"
                       disabled>
                <div class="form-text">ID tidak dapat diubah</div>
            </div>

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
                        <option value="{{ $user->iduser }}" 
                                {{ old('iduser', $pemilik->iduser) == $user->iduser ? 'selected' : '' }}>
                            {{ $user->nama }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('iduser')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
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
                       value="{{ old('no_wa', $pemilik->no_wa) }}"
                       placeholder="Contoh: 081234567890"
                       required>
                @error('no_wa')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
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
                          required>{{ old('alamat', $pemilik->alamat) }}</textarea>
                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Update
                </button>
                <a href="{{ route('pemilik.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection