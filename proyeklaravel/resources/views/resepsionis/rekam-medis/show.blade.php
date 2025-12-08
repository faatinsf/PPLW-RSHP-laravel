@extends('layout.resepsionis')

@section('title', 'Detail Rekam Medis')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">📋 Detail Rekam Medis</h2>
            <p class="text-muted mb-0">Informasi lengkap rekam medis pasien</p>
        </div>
        <div>
            <a href="{{ route('resepsionis.rekam-medis.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn btn-primary">
                <i class="bi bi-printer me-1"></i> Print
            </button>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column: Patient Info -->
        <div class="col-md-4">
            <!-- Pet Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-paw me-2"></i>Informasi Hewan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Nama Hewan</label>
                        <div class="fw-bold fs-5">{{ $rekamMedis->nama_pet }}</div>
                    </div>
                    <hr>
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted">Jenis</td>
                            <td class="fw-bold">{{ $rekamMedis->nama_jenis_hewan }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Ras</td>
                            <td class="fw-bold">{{ $rekamMedis->nama_ras }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Jenis Kelamin</td>
                            <td>
                                @if($rekamMedis->jenis_kelamin == 'J')
                                    <span class="badge bg-info">Jantan</span>
                                @else
                                    <span class="badge bg-danger">Betina</span>
                                @endif
                            </td>
                        </tr>
                        @if($rekamMedis->tanggal_lahir)
                        <tr>
                            <td class="text-muted">Tanggal Lahir</td>
                            <td>{{ \Carbon\Carbon::parse($rekamMedis->tanggal_lahir)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Umur</td>
                            <td>{{ \Carbon\Carbon::parse($rekamMedis->tanggal_lahir)->age }} tahun</td>
                        </tr>
                        @endif
                        @if($rekamMedis->warna_tanda)
                        <tr>
                            <td class="text-muted">Warna/Tanda</td>
                            <td>{{ $rekamMedis->warna_tanda }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <!-- Owner Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-person me-2"></i>Pemilik Hewan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Nama Pemilik</label>
                        <div class="fw-bold">{{ $rekamMedis->nama_pemilik }}</div>
                    </div>
                    <hr>
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted">Email</td>
                            <td>{{ $rekamMedis->email_pemilik }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">WhatsApp</td>
                            <td>
                                <a href="https://wa.me/{{ $rekamMedis->no_wa }}" 
                                   target="_blank" class="text-success">
                                    <i class="bi bi-whatsapp me-1"></i>{{ $rekamMedis->no_wa }}
                                </a>
                            </td>
                        </tr>
                        @if($rekamMedis->alamat)
                        <tr>
                            <td class="text-muted">Alamat</td>
                            <td>{{ $rekamMedis->alamat }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <!-- History Card -->
            @if($history->count() > 0)
            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Riwayat Kunjungan</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @foreach($history as $h)
                        <div class="timeline-item mb-3">
                            <div class="small text-muted">
                                {{ \Carbon\Carbon::parse($h->created_at)->format('d M Y') }}
                            </div>
                            <div class="fw-bold">{{ Str::limit($h->diagnosa, 50) }}</div>
                            <small class="text-muted">Dokter: {{ $h->nama_dokter }}</small>
                            <hr class="mt-2">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column: Medical Records -->
        <div class="col-md-8">
            <!-- Medical Record Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-file-medical me-2"></i>Rekam Medis</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Tanggal Pemeriksaan</label>
                            <div class="fw-bold">
                                {{ \Carbon\Carbon::parse($rekamMedis->created_at)->format('d F Y, H:i') }} WIB
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Dokter Pemeriksa</label>
                            <div class="fw-bold">
                                <i class="bi bi-person-badge text-primary"></i> 
                                {{ $rekamMedis->nama_dokter }}
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-4">
                        <h6 class="text-primary">📝 Anamnesa (Keluhan)</h6>
                        <div class="p-3 bg-light rounded">
                            {{ $rekamMedis->anamnesa ?? '-' }}
                        </div>
                    </div>

                    @if($rekamMedis->temuan_klinis)
                    <div class="mb-4">
                        <h6 class="text-primary">🔬 Temuan Klinis</h6>
                        <div class="p-3 bg-light rounded">
                            {{ $rekamMedis->temuan_klinis }}
                        </div>
                    </div>
                    @endif

                    <div class="mb-4">
                        <h6 class="text-primary">🩺 Diagnosa</h6>
                        <div class="p-3 bg-light rounded">
                            <strong>{{ $rekamMedis->diagnosa }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tindakan/Terapi Card -->
            @if($detailTindakan->count() > 0)
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-heart-pulse me-2"></i>Tindakan & Terapi</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="10%">Kode</th>
                                    <th width="30%">Tindakan/Terapi</th>
                                    <th width="20%">Kategori</th>
                                    <th width="15%">Jenis</th>
                                    <th width="25%">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detailTindakan as $detail)
                                <tr>
                                    <td><span class="badge bg-primary">{{ $detail->kode }}</span></td>
                                    <td>{{ $detail->deskripsi_tindakan_terapi }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $detail->nama_kategori }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $detail->nama_kategori_klinis }}</span>
                                    </td>
                                    <td>
                                        <small>{{ $detail->detail ?? '-' }}</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @else
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Belum ada tindakan/terapi yang tercatat untuk rekam medis ini.
            </div>
            @endif
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .sidebar, .navbar, .card-header {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>
@endsection