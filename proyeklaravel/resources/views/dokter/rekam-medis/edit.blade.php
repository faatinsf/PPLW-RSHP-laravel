@extends('layout.dokter')

@section('title', 'Isi Hasil Pemeriksaan')
@section('page-title', 'Isi Hasil Pemeriksaan')

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dokter.rekam-medis.index') }}">Rekam Medis</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dokter.rekam-medis.show', $rekamMedis->idrekam_medis) }}">#{{ $rekamMedis->idrekam_medis }}</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-stethoscope me-2"></i>Form Pemeriksaan Pasien</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('dokter.rekam-medis.update', $rekamMedis->idrekam_medis) }}" method="POST" id="pemeriksaanForm">
                        @csrf
                        @method('PUT')

                        <!-- Patient Info -->
                        <div class="alert alert-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong><i class="fas fa-paw me-2"></i>Pasien:</strong> {{ $rekamMedis->nama_pet }}
                                </div>
                                <div class="col-md-6">
                                    <strong><i class="fas fa-user me-2"></i>Pemilik:</strong> {{ $rekamMedis->nama_pemilik }}
                                </div>
                            </div>
                        </div>

                        <!-- Anamnesa (Read Only) -->
                        <div class="mb-4">
                            <h6 class="text-primary"><i class="fas fa-notes-medical me-2"></i>Anamnesa / Keluhan</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    {{ $rekamMedis->anamnesa }}
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Temuan Klinis -->
                        <h6 class="text-primary mb-3"><i class="fas fa-stethoscope me-2"></i>Temuan Klinis</h6>
                        <div class="mb-3">
                            <label for="temuan_klinis" class="form-label">
                                Hasil Pemeriksaan Fisik <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('temuan_klinis') is-invalid @enderror" 
                                      id="temuan_klinis" 
                                      name="temuan_klinis" 
                                      rows="5" 
                                      placeholder="Contoh:&#10;- Suhu: 38.5°C&#10;- Denyut nadi: 120x/menit&#10;- Mukosa: pucat&#10;- Palpasi abdomen: terasa nyeri&#10;- dll."
                                      required>{{ old('temuan_klinis', $rekamMedis->temuan_klinis) }}</textarea>
                            @error('temuan_klinis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Diagnosa -->
                        <div class="mb-4">
                            <label for="diagnosa" class="form-label">
                                Diagnosa <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('diagnosa') is-invalid @enderror" 
                                      id="diagnosa" 
                                      name="diagnosa" 
                                      rows="4" 
                                      placeholder="Contoh: Gastritis akut, Infeksi saluran pernapasan atas, dll."
                                      required>{{ old('diagnosa', $rekamMedis->diagnosa) }}</textarea>
                            @error('diagnosa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <!-- Tindakan & Terapi -->
                        <h6 class="text-primary mb-3"><i class="fas fa-syringe me-2"></i>Tindakan & Terapi</h6>
                        
                        <div id="tindakanContainer">
                            @if($existingDetails->count() > 0)
                                @foreach($existingDetails as $index => $existing)
                                    <div class="tindakan-item mb-3 p-3 border rounded">
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label class="form-label">Pilih Tindakan/Terapi</label>
                                                <select name="tindakan[]" class="form-select tindakan-select">
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($tindakanList as $kategori => $items)
                                                        <optgroup label="{{ $kategori }}">
                                                            @foreach($items as $item)
                                                                <option value="{{ $item->idkode_tindakan_terapi }}" 
                                                                        {{ $existing->idkode_tindakan_terapi == $item->idkode_tindakan_terapi ? 'selected' : '' }}>
                                                                    {{ $item->kode }} - {{ $item->deskripsi_tindakan_terapi }}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-5 mb-2">
                                                <label class="form-label">Detail/Catatan</label>
                                                <input type="text" name="detail_tindakan[]" class="form-control" 
                                                       value="{{ $existing->detail }}"
                                                       placeholder="Contoh: Dosis 2x sehari, 5ml">
                                            </div>
                                            <div class="col-md-1 mb-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger btn-sm w-100 remove-tindakan">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="tindakan-item mb-3 p-3 border rounded">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Pilih Tindakan/Terapi</label>
                                            <select name="tindakan[]" class="form-select tindakan-select">
                                                <option value="">-- Pilih --</option>
                                                @foreach($tindakanList as $kategori => $items)
                                                    <optgroup label="{{ $kategori }}">
                                                        @foreach($items as $item)
                                                            <option value="{{ $item->idkode_tindakan_terapi }}">
                                                                {{ $item->kode }} - {{ $item->deskripsi_tindakan_terapi }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5 mb-2">
                                            <label class="form-label">Detail/Catatan</label>
                                            <input type="text" name="detail_tindakan[]" class="form-control" 
                                                   placeholder="Contoh: Dosis 2x sehari, 5ml">
                                        </div>
                                        <div class="col-md-1 mb-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm w-100 remove-tindakan">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <button type="button" class="btn btn-outline-primary mb-4" id="addTindakan">
                            <i class="fas fa-plus me-2"></i>Tambah Tindakan/Terapi
                        </button>

                        <hr class="my-4">

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dokter.rekam-medis.show', $rekamMedis->idrekam_medis) }}" 
                               class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Simpan Hasil Pemeriksaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Tindakan template
const tindakanTemplate = `
<div class="tindakan-item mb-3 p-3 border rounded">
    <div class="row">
        <div class="col-md-6 mb-2">
            <label class="form-label">Pilih Tindakan/Terapi</label>
            <select name="tindakan[]" class="form-select tindakan-select">
                <option value="">-- Pilih --</option>
                @foreach($tindakanList as $kategori => $items)
                    <optgroup label="{{ $kategori }}">
                        @foreach($items as $item)
                            <option value="{{ $item->idkode_tindakan_terapi }}">
                                {{ $item->kode }} - {{ $item->deskripsi_tindakan_terapi }}
                            </option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>
        <div class="col-md-5 mb-2">
            <label class="form-label">Detail/Catatan</label>
            <input type="text" name="detail_tindakan[]" class="form-control" 
                   placeholder="Contoh: Dosis 2x sehari, 5ml">
        </div>
        <div class="col-md-1 mb-2 d-flex align-items-end">
            <button type="button" class="btn btn-danger btn-sm w-100 remove-tindakan">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
</div>
`;

// Add tindakan
document.getElementById('addTindakan')?.addEventListener('click', function() {
    document.getElementById('tindakanContainer').insertAdjacentHTML('beforeend', tindakanTemplate);
});

// Remove tindakan (event delegation)
document.getElementById('tindakanContainer')?.addEventListener('click', function(e) {
    if (e.target.closest('.remove-tindakan')) {
        const item = e.target.closest('.tindakan-item');
        const container = document.getElementById('tindakanContainer');
        
        // Keep at least one item
        if (container.querySelectorAll('.tindakan-item').length > 1) {
            item.remove();
        } else {
            alert('Minimal harus ada 1 tindakan/terapi');
        }
    }
});

// Form validation
document.getElementById('pemeriksaanForm')?.addEventListener('submit', function(e) {
    const temuanKlinis = document.getElementById('temuan_klinis').value.trim();
    const diagnosa = document.getElementById('diagnosa').value.trim();
    
    if (!temuanKlinis || !diagnosa) {
        e.preventDefault();
        alert('Temuan Klinis dan Diagnosa harus diisi!');
        return false;
    }
});
</script>
@endpush