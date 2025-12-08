@extends('layout.admin')

@section('title', 'Edit Kode Tindakan Terapi')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Kode Tindakan Terapi</h1>
        <a href="{{ route('kodetindakanterapi.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Data Kode Tindakan Terapi</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('kodetindakanterapi.update', $kodeTindakan->idkode_tindakan_terapi) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="kode">Kode <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('kode') is-invalid @enderror" 
                                   id="kode" 
                                   name="kode" 
                                   value="{{ old('kode', $kodeTindakan->kode) }}"
                                   placeholder="Contoh: T01, T02"
                                   maxlength="5"
                                   required>
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="deskripsi_tindakan_terapi">Deskripsi Tindakan/Terapi <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('deskripsi_tindakan_terapi') is-invalid @enderror" 
                                      id="deskripsi_tindakan_terapi" 
                                      name="deskripsi_tindakan_terapi" 
                                      rows="3"
                                      required>{{ old('deskripsi_tindakan_terapi', $kodeTindakan->deskripsi_tindakan_terapi) }}</textarea>
                            @error('deskripsi_tindakan_terapi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="idkategori">Kategori <span class="text-danger">*</span></label>
                            <select class="form-control @error('idkategori') is-invalid @enderror" 
                                    id="idkategori" 
                                    name="idkategori" 
                                    required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategori as $kat)
                                    <option value="{{ $kat->idkategori }}" 
                                        {{ old('idkategori', $kodeTindakan->idkategori) == $kat->idkategori ? 'selected' : '' }}>
                                        {{ $kat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idkategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="idkategori_klinis">Kategori Klinis <span class="text-danger">*</span></label>
                            <select class="form-control @error('idkategori_klinis') is-invalid @enderror" 
                                    id="idkategori_klinis" 
                                    name="idkategori_klinis" 
                                    required>
                                <option value="">-- Pilih Kategori Klinis --</option>
                                @foreach($kategoriKlinis as $katKlinis)
                                    <option value="{{ $katKlinis->idkategori_klinis }}" 
                                        {{ old('idkategori_klinis', $kodeTindakan->idkategori_klinis) == $katKlinis->idkategori_klinis ? 'selected' : '' }}>
                                        {{ $katKlinis->nama_kategori_klinis }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idkategori_klinis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update
                            </button>
                            <a href="{{ route('kodetindakanterapi.index') }}" class="btn btn-secondary">
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
                        <li>Semua field bertanda <span class="text-danger">*</span> wajib diisi</li>
                        <li>Kode akan otomatis diubah menjadi huruf besar</li>
                        <li>Pastikan data yang diupdate sudah benar</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection