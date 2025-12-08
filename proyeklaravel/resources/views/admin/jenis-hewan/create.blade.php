@extends('layout.admin')

@section('title', 'Tambah Jenis Hewan')

@section('content')
<div class="container-fluid">
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Jenis Hewan</h1>
        <a href="{{ route('jenis-hewan.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>


    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Data Jenis Hewan</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('jenis-hewan.store') }}" method="POST">
                        @csrf
                       
                    
                        <div class="form-group">
                            <label for="nama_jenis_hewan">Nama Jenis Hewan <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nama_jenis_hewan') is-invalid @enderror" 
                                   id="nama_jenis_hewan" 
                                   name="nama_jenis_hewan" 
                                   value="{{ old('nama_jenis_hewan') }}"
                                   placeholder="Contoh: Mamalia, Reptil, Aves"
                                   required>
                            @error('nama_jenis_hewan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Nama akan otomatis diformat menjadi huruf kapital di setiap kata.
                            </small>
                        </div>

    
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="{{ route('jenis-hewan.index') }}" class="btn btn-secondary">
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
                        <li>Nama jenis hewan akan diformat otomatis</li>
  
                        <li>Pastikan data yang diinput sudah benar sebelum disimpan</li>
                        <li>Jenis hewan yang sudah digunakan oleh ras hewan tidak dapat dihapus</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
