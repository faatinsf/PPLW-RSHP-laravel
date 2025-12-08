@extends('layout.admin')

@section('title', 'Edit Ras Hewan | RSHP Unair')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-pencil-square"></i> Edit Data Ras Hewan</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('rashewan.index') }}">Data Ras Hewan</a></li>
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
        <form action="{{ route('rashewan.update', $rasHewan->idras_hewan) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- ID (Read-only) -->
            <div class="mb-3">
                <label for="id" class="form-label fw-semibold">ID Ras Hewan</label>
                <input type="text" 
                       class="form-control" 
                       id="id" 
                       value="{{ $rasHewan->idras_hewan }}"
                       disabled>
                <div class="form-text">ID tidak dapat diubah</div>
            </div>

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
                                {{ old('idjenis_hewan', $rasHewan->idjenis_hewan) == $jenis->idjenis_hewan ? 'selected' : '' }}>
                            {{ $jenis->nama_jenis_hewan }}
                        </option>
                    @endforeach
                </select>
                @error('idjenis_hewan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
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
                       value="{{ old('nama_ras', $rasHewan->nama_ras) }}"
                       placeholder="Contoh: Golden Retriever, Persian, Holland Lop"
                       required>
                @error('nama_ras')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Maksimal 100 karakter</div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Update
                </button>
                <a href="{{ route('rashewan.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection