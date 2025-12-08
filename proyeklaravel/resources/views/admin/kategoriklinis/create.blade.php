@extends('layout.admin')

@section('title', 'Tambah Kategori Klinis')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Kategori Klinis</h1>
        <a href="{{ route('kategoriklinis.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Data Kategori Klinis</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('kategoriklinis.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="nama_kategori_klinis">Nama Kategori Klinis <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nama_kategori_klinis') is-invalid @enderror" 
                                   id="nama_kategori_klinis" 
                                   name="nama_kategori_klinis" 
                                   value="{{ old('nama_kategori_klinis') }}"
                                   placeholder="Contoh: Terapi, Tindakan"
                                   required>
                            @error('nama_kategori_klinis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Nama akan otomatis diformat menjadi huruf kapital di setiap kata. Maksimal 50 karakter.
                            </small>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="{{ route('kategoriklinis.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Informasi</h6>
                </div>
                <div class="card-body">
                    <p class="mb-2"><i class="fas fa-info-circle text-info"></i> <strong>Petunjuk Pengisian:</strong></p>
                    <ul class="small">
                        <li>Field bertanda <span class="text-danger">*</span> wajib diisi</li>
                        <li>Nama kategori klinis akan diformat otomatis</li>
                        <li>Maksimal panjang nama: 50 karakter</li>
                        <li>Kategori yang sudah digunakan tidak dapat dihapus</li>
                    </ul>
                    
                    <hr>
                    
                    <p class="mb-2"><strong>Contoh Kategori Klinis:</strong></p>
                    <ul class="small">
                        <li>Terapi</li>
                        <li>Tindakan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection