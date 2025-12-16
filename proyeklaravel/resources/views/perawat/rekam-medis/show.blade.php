@extends('layout.perawat')

@section('title', 'Detail Rekam Medis')
@section('page-title', 'Detail Rekam Medis')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('perawat.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('perawat.rekam-medis.index') }}">Rekam Medis</a></li>
            <li class="breadcrumb-item active">#{{ $rekamMedis->idrekam_medis }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Left Sidebar -->
        <div class="col-lg-4 mb-4">
            <!-- Rekam Medis Info -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="fas fa-file-medical me-2"></i>Info Rekam Medis</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">No. Rekam Medis:</small>
                        <h5 class="mb-0">#{{ $rekamMedis->idrekam_medis }}</h5>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Tanggal Pemeriksaan:</small>
                        <p class="mb-0">
                            <i class="fas fa-calendar me-2 text-danger"></i>
                            <strong>{{ \Carbon\Carbon::parse($rekamMedis->created_at)->format('d F Y') }}</strong>
                            <br>
                            <i class="fas fa-clock me-2 text-danger"></i>
                            {{ \Carbon\Carbon::parse($rekamMedis->created_at)->format('H:i') }} WIB
                        </p>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Status:</small>
                        @if($rekamMedis->diagnosa)
                            <span class="badge bg-success fs-6">
                                <i class="fas fa-check-circle me-1"></i>Pemeriksaan Selesai
                            </span>
                        @else
                            <span class="badge bg-warning fs-6">
                                <i class="fas fa-clock me-1"></i>Menunggu Pemeriksaan
                            </span>
                        @endif
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        @if(!$rekamMedis->diagnosa)
                        <a href="{{ route('dokter.rekam-medis.edit', $rekamMedis->idrekam_medis) }}" 
                           class="btn btn-primary">
                            <i class="fas fa-stethoscope me-2"></i>Isi Hasil Pemeriksaan
                        </a>
                        @else
                        <a href="{{ route('dokter.rekam-medis.edit', $rekamMedis->idrekam_medis) }}" 
                           class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Pemeriksaan
                        </a>
                        @endif
                        <a href="{{ route('dokter.rekam-medis.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Pet Info -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-paw me-2"></i>Data Pasien</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="pet-avatar-large mx-auto">
                            <i class="fas fa-paw"></i>
                        </div>
                        <h5 class="mt-3 mb-1">{{ $rekamMedis->nama_pet }}</h5>
                        <span class="badge bg-primary">{{ $rekamMedis->nama_jenis_hewan }}</span>
                    </div>

                    <hr>

                    <div class="mb-2">
                        <small class="text-muted">Ras:</small>
                        <br><strong>{{ $rekamMedis->nama_ras }}</strong>
                    </div>

                    <div class="mb-2">
                        <small class="text-muted">Jenis Kelamin:</small>
                        <br>
                        @if($rekamMedis->jenis_kelamin == 'J')
                            <i class="fas fa-mars text-primary me-1"></i><strong>Jantan</strong>
                        @else
                            <i class="fas fa-venus text-danger me-1"></i><strong>Betina</strong>
                        @endif
                    </div>

                    @if($rekamMedis->tanggal_lahir)
                    <div class="mb-2">
                        <small class="text-muted">Umur:</small>
                        <br><strong>{{ \Carbon\Carbon::parse($rekamMedis->tanggal_lahir)->age }} tahun</strong>
                    </div>
                    @endif

                    @if($rekamMedis->warna_tanda)
                    <div class="mb-0">
                        <small class="text-muted">Ciri Khusus:</small>
                        <br>{{ $rekamMedis->warna_tanda }}
                    </div>
                    @endif
                </div>
            </div>

            <!-- Owner Info -->
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="fas fa-user me-2"></i>Data Pemilik</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted">Nama:</small>
                        <br><strong>{{ $rekamMedis->nama_pemilik }}</strong>
                    </div>

                    <div class="mb-2">
                        <small class="text-muted">No. WhatsApp:</small>
                        <br>
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $rekamMedis->no_wa) }}" 
                           target="_blank" class="text-decoration-none">
                            <i class="fab fa-whatsapp text-success me-1"></i>{{ $rekamMedis->no_wa }}
                        </a>
                    </div>

                    @if($rekamMedis->email_pemilik)
                    <div class="mb-2">
                        <small class="text-muted">Email:</small>
                        <br>
                        <a href="mailto:{{ $rekamMedis->email_pemilik }}" class="text-decoration-none">
                            <i class="fas fa-envelope text-primary me-1"></i>{{ $rekamMedis->email_pemilik }}
                        </a>
                    </div>
                    @endif

                    @if($rekamMedis->alamat)
                    <div class="mb-0">
                        <small class="text-muted">Alamat:</small>
                        <br>{{ $rekamMedis->alamat }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Anamnesa -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-notes-medical text-info me-2"></i>Anamnesa / Keluhan</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $rekamMedis->anamnesa }}</p>
                </div>
            </div>

            @if($rekamMedis->temuan_klinis)
            <!-- Temuan Klinis -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-stethoscope text-primary me-2"></i>Temuan Klinis</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0 whitespace-pre-line">{{ $rekamMedis->temuan_klinis }}</p>
                </div>
            </div>
            @endif

            @if($rekamMedis->diagnosa)
            <!-- Diagnosa -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-diagnoses text-success me-2"></i>Diagnosa</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0 whitespace-pre-line">{{ $rekamMedis->diagnosa }}</p>
                </div>
            </div>
            @endif

            <!-- Tindakan & Terapi -->
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-syringe text-warning me-2"></i>Tindakan & Terapi</h5>
                    @if($details->count() > 0)
                        <span class="badge bg-primary">{{ $details->count() }} Tindakan</span>
                    @endif
                </div>
                <div class="card-body">
                    @if($details->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th width="8%">Kode</th>
                                        <th width="35%">Tindakan/Terapi</th>
                                        <th width="15%">Kategori</th>
                                        <th width="12%">Jenis</th>
                                        <th width="30%">Detail/Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($details as $detail)
                                    <tr>
                                        <td><span class="badge bg-secondary">{{ $detail->kode }}</span></td>
                                        <td>{{ $detail->deskripsi_tindakan_terapi }}</td>
                                        <td><span class="badge bg-info">{{ $detail->nama_kategori }}</span></td>
                                        <td><span class="badge bg-success">{{ $detail->nama_kategori_klinis }}</span></td>
                                        <td>{{ $detail->detail ?? '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-syringe fa-2x mb-2 d-block"></i>
                            @if($rekamMedis->diagnosa)
                                <p class="mb-0">Tidak ada tindakan yang dilakukan</p>
                            @else
                                <p class="mb-0">Belum ada tindakan. Klik "Isi Hasil Pemeriksaan" untuk menambah.</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .pet-avatar-large {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
    }
    
    .whitespace-pre-line {
        white-space: pre-line;
    }
</style>
@endsection