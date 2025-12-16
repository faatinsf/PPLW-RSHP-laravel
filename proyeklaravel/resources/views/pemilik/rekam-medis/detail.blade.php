@extends('layout.pemilik')

@section('title', 'Detail Rekam Medis')
@section('page-title', 'Detail Rekam Medis')
@section('breadcrumb', 'Home / Rekam Medis / Detail')

@section('content')
<div class="container-fluid">

    <!-- Back Button -->
    <div class="mb-3">
        <a href="{{ route('pemilik.medical-record') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <!-- Medical Record Info -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-file-medical me-2"></i>
                Informasi Rekam Medis
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="200"><strong>Tanggal Kunjungan</strong></td>
                            <td>: {{ \Carbon\Carbon::parse($rekamMedis->created_at)->isoFormat('D MMMM YYYY') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Waktu</strong></td>
                            <td>: {{ \Carbon\Carbon::parse($rekamMedis->created_at)->format('H:i') }} WIB</td>
                        </tr>
                        <tr>
                            <td><strong>No. Rekam Medis</strong></td>
                            <td>: <span class="badge bg-secondary">RM-{{ str_pad($rekamMedis->idrekam_medis, 6, '0', STR_PAD_LEFT) }}</span></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="200"><strong>Dokter Pemeriksa</strong></td>
                            <td>: {{ $rekamMedis->nama_dokter }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>: <span class="badge bg-success">Selesai</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pet Info -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-paw me-2 text-primary"></i>
                Informasi Pet
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="180"><strong>Nama Pet</strong></td>
                            <td>: {{ $rekamMedis->nama_pet }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jenis</strong></td>
                            <td>: {{ Str::before($rekamMedis->nama_jenis_hewan, '(') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Ras</strong></td>
                            <td>: {{ $rekamMedis->nama_ras }}</td>
                        </tr>
                        <tr>
                            <td><strong>Umur</strong></td>
                            <td>: {{ $rekamMedis->umur }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="180"><strong>Jenis Kelamin</strong></td>
                            <td>: {{ $rekamMedis->jenis_kelamin == 'J' ? 'Jantan' : 'Betina' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Warna/Tanda</strong></td>
                            <td>: {{ $rekamMedis->warna_tanda ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Pemilik</strong></td>
                            <td>: {{ $rekamMedis->nama_pemilik }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Anamnesa -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-comment-medical me-2 text-info"></i>
                Anamnesa (Keluhan)
            </h5>
        </div>
        <div class="card-body">
            <p class="mb-0" style="line-height: 1.8; white-space: pre-wrap;">{{ $rekamMedis->anamnesa ?? 'Tidak ada catatan anamnesa' }}</p>
        </div>
    </div>

    <!-- Temuan Klinis -->
    @if($rekamMedis->temuan_klinis)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-stethoscope me-2 text-success"></i>
                Temuan Klinis (Pemeriksaan Fisik)
            </h5>
        </div>
        <div class="card-body">
            <p class="mb-0" style="line-height: 1.8; white-space: pre-wrap;">{{ $rekamMedis->temuan_klinis }}</p>
        </div>
    </div>
    @endif

    <!-- Diagnosis -->
    <div class="card border-0 shadow-sm border-danger mb-4">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0">
                <i class="fas fa-diagnoses me-2"></i>
                Diagnosa
            </h5>
        </div>
        <div class="card-body">
            <h4 class="text-danger mb-0">
                {{ $rekamMedis->diagnosa ?? 'Belum ada diagnosa' }}
            </h4>
        </div>
    </div>

    <!-- Treatment & Therapy -->
    @if(count($rekamMedis->detail_rekam_medis) > 0)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-pills me-2 text-primary"></i>
                Tindakan dan Terapi
                <span class="badge bg-primary ms-2">{{ count($rekamMedis->detail_rekam_medis) }} Items</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="10%">Kode</th>
                            <th width="40%">Tindakan/Terapi</th>
                            <th width="15%">Kategori</th>
                            <th width="15%">Jenis</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekamMedis->detail_rekam_medis as $detail)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $detail->kode }}</span></td>
                            <td><strong>{{ $detail->deskripsi_tindakan_terapi }}</strong></td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $detail->nama_kategori }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $detail->nama_kategori_klinis == 'Terapi' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $detail->nama_kategori_klinis }}
                                </span>
                            </td>
                            <td>{{ $detail->detail ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Follow Up Info -->
    <div class="alert alert-info" role="alert">
        <h5 class="alert-heading">
            <i class="fas fa-info-circle me-2"></i>
            Informasi Penting
        </h5>
        <hr>
        <p class="mb-2"><strong>Rekam medis ini telah selesai dan tersimpan dalam sistem.</strong></p>
        <p class="mb-0">
            Jika Anda memiliki pertanyaan atau membutuhkan konsultasi lebih lanjut, 
            silakan hubungi klinik kami di <strong>(031) 1234-5678</strong> atau 
            datang langsung ke klinik pada jam operasional.
        </p>
    </div>

    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm border-primary h-100">
                <div class="card-body text-center">
                    <i class="fas fa-procedures fa-2x text-primary mb-2"></i>
                    <h4 class="mb-1">{{ count($rekamMedis->detail_rekam_medis) }}</h4>
                    <small class="text-muted">Total Tindakan/Terapi</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm border-success h-100">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-check fa-2x text-success mb-2"></i>
                    <h4 class="mb-1">{{ $rekamMedis->total_kunjungan_pet }}</h4>
                    <small class="text-muted">Total Kunjungan {{ $rekamMedis->nama_pet }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm border-warning h-100">
                <div class="card-body text-center">
                    <i class="fas fa-user-md fa-2x text-warning mb-2"></i>
                    <h4 class="mb-1">{{ $rekamMedis->nama_dokter }}</h4>
                    <small class="text-muted">Dokter Pemeriksa</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-flex gap-2 justify-content-end no-print">
        <button class="btn btn-outline-primary" onclick="window.print()">
            <i class="fas fa-print me-2"></i> Cetak Rekam Medis
        </button>
        <a href="{{ route('pemilik.medical-record') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

</div>
@endsection

@push('styles')
<style>
@media print {
    .btn, .navbar, .sidebar, footer, .no-print, .alert {
        display: none !important;
    }
    
    .card {
        break-inside: avoid;
        page-break-inside: avoid;
    }
    
    body {
        background: white !important;
    }
}

.card {
    animation: fadeInUp 0.5s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endpush