@extends('layout.admin')

@section('title', 'Edit Detail Tindakan/Terapi | RSHP Unair')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-pencil-square"></i> Edit Detail Tindakan/Terapi</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('detailrekammedis.index') }}">Detail Rekam Medis</a></li>
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
        <form action="{{ route('detailrekammedis.update', $detailRekamMedis->iddetail_rekam_medis) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- ID (Read-only) -->
            <div class="mb-3">
                <label for="id" class="form-label fw-semibold">ID Detail Rekam Medis</label>
                <input type="text" 
                       class="form-control" 
                       id="id" 
                       value="{{ $detailRekamMedis->iddetail_rekam_medis }}"
                       disabled>
                <div class="form-text">ID tidak dapat diubah</div>
            </div>

            <!-- Rekam Medis -->
            <div class="mb-3">
                <label for="idrekam_medis" class="form-label fw-semibold">
                    Rekam Medis <span class="text-danger">*</span>
                </label>
                <select class="form-select @error('idrekam_medis') is-invalid @enderror" 
                        id="idrekam_medis" 
                        name="idrekam_medis" 
                        required>
                    <option value="">-- Pilih Rekam Medis --</option>
                    @foreach($rekamMedisList as $rm)
                        <option value="{{ $rm->idrekam_medis }}" 
                                {{ old('idrekam_medis', $detailRekamMedis->idrekam_medis) == $rm->idrekam_medis ? 'selected' : '' }}>
                            [{{ \Carbon\Carbon::parse($rm->created_at)->format('d/m/Y') }}] 
                            {{ $rm->nama_pet }} - {{ $rm->nama_pemilik }} | {{ Str::limit($rm->diagnosa, 50) }}
                        </option>
                    @endforeach
                </select>
                @error('idrekam_medis')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Kategori (untuk filter) -->
            <div class="mb-3">
                <label for="kategori_filter" class="form-label fw-semibold">
                    Filter Kategori
                </label>
                <select class="form-select" id="kategori_filter">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($kategori as $kat)
                        <option value="{{ $kat->idkategori }}">{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>
                <div class="form-text">Filter untuk memudahkan pencarian tindakan/terapi</div>
            </div>

            <!-- Kode Tindakan/Terapi -->
            <div class="mb-3">
                <label for="idkode_tindakan_terapi" class="form-label fw-semibold">
                    Tindakan / Terapi <span class="text-danger">*</span>
                </label>
                <select class="form-select @error('idkode_tindakan_terapi') is-invalid @enderror" 
                        id="idkode_tindakan_terapi" 
                        name="idkode_tindakan_terapi" 
                        required>
                    <option value="">-- Pilih Tindakan/Terapi --</option>
                    @foreach($kodeTindakanTerapi as $ktt)
                        <option value="{{ $ktt->idkode_tindakan_terapi }}" 
                                data-kategori="{{ $ktt->idkategori }}"
                                {{ old('idkode_tindakan_terapi', $detailRekamMedis->idkode_tindakan_terapi) == $ktt->idkode_tindakan_terapi ? 'selected' : '' }}>
                            [{{ $ktt->kode }}] {{ $ktt->deskripsi_tindakan_terapi }} 
                            ({{ $ktt->nama_kategori }} - {{ $ktt->nama_kategori_klinis }})
                        </option>
                    @endforeach
                </select>
                @error('idkode_tindakan_terapi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Detail/Keterangan -->
            <div class="mb-3">
                <label for="detail" class="form-label fw-semibold">
                    Detail / Keterangan Tambahan
                </label>
                <textarea class="form-control @error('detail') is-invalid @enderror" 
                          id="detail" 
                          name="detail" 
                          rows="4"
                          placeholder="Contoh: Dosis, frekuensi pemberian, hasil pemeriksaan, dll...">{{ old('detail', $detailRekamMedis->detail) }}</textarea>
                @error('detail')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Opsional, maksimal 1000 karakter</div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Update
                </button>
                <a href="{{ route('detailrekammedis.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Filter tindakan berdasarkan kategori
document.getElementById('kategori_filter').addEventListener('change', function() {
    const kategoriId = this.value;
    const tindakanSelect = document.getElementById('idkode_tindakan_terapi');
    const options = tindakanSelect.querySelectorAll('option');
    
    options.forEach(option => {
        if (option.value === '') {
            option.style.display = 'block';
            return;
        }
        
        if (kategoriId === '' || option.dataset.kategori == kategoriId) {
            option.style.display = 'block';
        } else {
            option.style.display = 'none';
        }
    });
    
    // Reset selection jika hidden
    if (tindakanSelect.value && tindakanSelect.selectedOptions[0].style.display === 'none') {
        tindakanSelect.value = '';
    }
});
</script>
@endpush

@endsection 