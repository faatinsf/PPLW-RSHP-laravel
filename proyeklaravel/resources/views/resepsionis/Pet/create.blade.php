@extends('layout.resepsionis')

@section('title', 'Tambah Hewan | RSHP Unair')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-plus-circle"></i> Tambah Data Hewan Peliharaan</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('resepsionis.pet.index') }}">Data Hewan</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

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
        <form action="{{ route('resepsionis.pet.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama" class="form-label fw-semibold">
                        Nama Hewan <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control @error('nama') is-invalid @enderror" 
                           id="nama" 
                           name="nama" 
                           value="{{ old('nama') }}"
                           placeholder="Contoh: Milo"
                           required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tanggal_lahir" class="form-label fw-semibold">
                        Tanggal Lahir <span class="text-danger">*</span>
                    </label>
                    <input type="date" 
                           class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                           id="tanggal_lahir" 
                           name="tanggal_lahir" 
                           value="{{ old('tanggal_lahir') }}"
                           max="{{ date('Y-m-d') }}"
                           required>
                    @error('tanggal_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="jenis_kelamin" class="form-label fw-semibold">
                        Jenis Kelamin <span class="text-danger">*</span>
                    </label>
                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror" 
                            id="jenis_kelamin" 
                            name="jenis_kelamin" 
                            required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="J" {{ old('jenis_kelamin') == 'J' ? 'selected' : '' }}>Jantan</option>
                        <option value="B" {{ old('jenis_kelamin') == 'B' ? 'selected' : '' }}>Betina</option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="warna_tanda" class="form-label fw-semibold">
                        Warna/Ciri Khas <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control @error('warna_tanda') is-invalid @enderror" 
                           id="warna_tanda" 
                           name="warna_tanda" 
                           value="{{ old('warna_tanda') }}"
                           placeholder="Contoh: Cokelat dengan bercak putih"
                           required>
                    @error('warna_tanda')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="jenis_hewan" class="form-label fw-semibold">
                        Jenis Hewan <span class="text-danger">*</span>
                    </label>
                    <select class="form-select @error('idras_hewan') is-invalid @enderror" 
                            id="jenis_hewan" 
                            required>
                        <option value="">-- Pilih Jenis Hewan --</option>
                        @foreach($jenisHewan as $jenis)
                            <option value="{{ $jenis->idjenis_hewan }}">
                                {{ $jenis->nama_jenis_hewan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="idras_hewan" class="form-label fw-semibold">
                        Ras Hewan <span class="text-danger">*</span>
                    </label>
                    <select class="form-select @error('idras_hewan') is-invalid @enderror" 
                            id="idras_hewan" 
                            name="idras_hewan" 
                            required>
                        <option value="">-- Pilih Jenis Hewan Dahulu --</option>
                    </select>
                    @error('idras_hewan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="idpemilik" class="form-label fw-semibold">
                    Pemilik <span class="text-danger">*</span>
                </label>
                <select class="form-select @error('idpemilik') is-invalid @enderror" 
                        id="idpemilik" 
                        name="idpemilik" 
                        required>
                    <option value="">-- Pilih Pemilik --</option>
                    @foreach($pemilik as $p)
                        <option value="{{ $p->idpemilik }}" {{ old('idpemilik') == $p->idpemilik ? 'selected' : '' }}>
                            {{ $p->nama }} - {{ $p->email }} ({{ $p->no_wa }})
                        </option>
                    @endforeach
                </select>
                @error('idpemilik')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="{{ route('resepsionis.pet.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
const rasHewanData = @json($rasHewan);

document.getElementById('jenis_hewan').addEventListener('change', function() {
    const jenisId = this.value;
    const rasSelect = document.getElementById('idras_hewan');
    
    rasSelect.innerHTML = '<option value="">-- Pilih Ras Hewan --</option>';
    
    if (jenisId) {
        const filteredRas = rasHewanData.filter(ras => ras.idjenis_hewan == jenisId);
        
        filteredRas.forEach(ras => {
            const option = document.createElement('option');
            option.value = ras.idras_hewan;
            option.textContent = ras.nama_ras;
            
            if ("{{ old('idras_hewan') }}" == ras.idras_hewan) {
                option.selected = true;
            }
            
            rasSelect.appendChild(option);
        });
    }
});

@if(old('idras_hewan'))
    const oldRasId = {{ old('idras_hewan') }};
    const rasData = rasHewanData.find(r => r.idras_hewan == oldRasId);
    if (rasData) {
        document.getElementById('jenis_hewan').value = rasData.idjenis_hewan;
        document.getElementById('jenis_hewan').dispatchEvent(new Event('change'));
    }
@endif
</script>
@endpush

@endsection