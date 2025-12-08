@extends('layout.admin')

@section('title', 'Tambah Ras Hewan | RSHP Unair')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-plus-circle"></i> Tambah Data Ras Hewan</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('rashewan.index') }}">Data Ras Hewan</a></li>
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
        <form action="{{ route('rashewan.store') }}" method="POST">
            @csrf

            <!-- Jenis Hewan -->
            <div class="mb-3">
                <label for="idjenis_hewan" class="form-label fw-semibold">
                    Jenis Hewan <span class="text-danger">*</span>
                </label>
                <select class="form-select @error('idjenis_hewan') is-invalid @enderror" 
                        id="idjenis_hewan" 
                        name="idjenis_hewan" 
                        required>
                    <option value="">-- Pilih Jenis Hewan --</option>
                    @foreach($jenisHewan as $jenis)
                        <option value="{{ $jenis->idjenis_hewan }}" 
                                {{ old('idjenis_hewan') == $jenis->idjenis_hewan ? 'selected' : '' }}>
                            {{ $jenis->nama_jenis_hewan }}
                        </option>
                    @endforeach
                </select>
                @error('idjenis_hewan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Pilih jenis hewan terlebih dahulu</div>
            </div>

            <!-- Nama Ras -->
            <div class="mb-3">
                <label for="nama_ras" class="form-label fw-semibold">
                    Nama Ras <span class="text-danger">*</span>
                </label>
                <input type="text" 
                       class="form-control @error('nama_ras') is-invalid @enderror" 
                       id="nama_ras" 
                       name="nama_ras" 
                       value="{{ old('nama_ras') }}"
                       placeholder="Contoh: Golden Retriever, Persian, Holland Lop"
                       required>
                @error('nama_ras')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Maksimal 100 karakter</div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="{{ route('rashewan.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection