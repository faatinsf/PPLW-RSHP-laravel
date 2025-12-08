@extends('layout.dokter')

@section('title', 'Dashboard Dokter')

@section('content')
<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white" style="background: linear-gradient(135deg, #0077b6 0%, #023e8a 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-2">👨‍⚕️ Dashboard Dokter</h3>
                            <p class="mb-0 opacity-75">Kelola rekam medis dan pemeriksaan pasien hewan</p>
                        </div>
                        <div class="text-end">
                            <h5 class="mb-1">{{ \Carbon\Carbon::now()->isoFormat('dddd') }}</h5>
                            <p class="mb-0">{{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Rekam Medis -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2 small">Total Rekam Medis</p>
                            <h2 class="mb-0 fw-bold text-primary">{{ $rekamCount ?? 0 }}</h2>
                            <small class="text-success">
                                <i class="bi bi-check-circle"></i> Semua data
                            </small>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-file-medical fs-2 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Hewan -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2 small">Total Pasien Hewan</p>
                            <h2 class="mb-0 fw-bold text-info">{{ $petCount ?? 0 }}</h2>
                            <small class="text-muted">
                                <i class="bi bi-paw"></i> Hewan terdaftar
                            </small>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-paw fs-2 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pemilik -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2 small">Total Pemilik</p>
                            <h2 class="mb-0 fw-bold text-warning">{{ $pemilikCount ?? 0 }}</h2>
                            <small class="text-warning">
                                <i class="bi bi-people"></i> Pemilik terdaftar
                            </small>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-people fs-2 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Tindakan/Terapi -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2 small">Jenis Tindakan</p>
                            <h2 class="mb-0 fw-bold text-success">{{ $terapiCount ?? 0 }}</h2>
                            <small class="text-muted">
                                <i class="bi bi-activity"></i> Kode tersedia
                            </small>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-heart-pulse fs-2 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Info Cards -->
    <div class="row g-4">
        <!-- Quick Actions -->
        <div class="col-lg-6">
            <div class="card border-0 h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="bi bi-lightning-charge text-warning"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('dokter.rekam-medis.index') }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-file-medical me-2"></i>
                            Lihat Semua Rekam Medis
                        </a>
                        <a href="{{ route('dokter.pet.index') }}" class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-paw me-2"></i>
                            Data Hewan Pasien
                        </a>
                        <a href="{{ route('dokter.pemilik.index') }}" class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-people me-2"></i>
                            Data Pemilik Hewan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info & Tips -->
        <div class="col-lg-6">
            <div class="card border-0 h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle text-info"></i>
                        Informasi Sistem
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-3">
                        <h6 class="alert-heading">
                            <i class="bi bi-clipboard-check"></i> Cara Input Rekam Medis
                        </h6>
                        <ol class="mb-0 ps-3">
                            <li>Pilih appointment yang perlu diperiksa</li>
                            <li>Klik tombol "Periksa" untuk input diagnosa</li>
                            <li>Isi diagnosa, temuan klinis, dan pilih tindakan</li>
                            <li>Status akan berubah otomatis menjadi "Selesai"</li>
                        </ol>
                    </div>

                    <div class="alert alert-success mb-3">
                        <h6 class="alert-heading">
                            <i class="bi bi-check2-circle"></i> Tips Dokter
                        </h6>
                        <ul class="mb-0 ps-3">
                            <li>Periksa appointment hari ini secara berkala</li>
                            <li>Input rekam medis sesegera mungkin</li>
                            <li>Gunakan kode tindakan yang sesuai</li>
                        </ul>
                    </div>

                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="text-primary">
                                <i class="bi bi-telephone"></i> Kontak Support
                            </h6>
                            <p class="mb-0 small">
                                Jika ada masalah teknis, hubungi Admin:<br>
                                <strong>0812-3456-7890</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="bi bi-activity text-danger"></i>
                        Aktivitas Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-light text-center">
                        <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                        <p class="mb-0 text-muted">
                            Untuk melihat appointment hari ini dan rekam medis terbaru,<br>
                            silakan kunjungi menu <strong>Rekam Medis</strong>
                        </p>
                        <a href="{{ route('dokter.rekam-medis.index') }}" class="btn btn-primary mt-3">
                            <i class="bi bi-arrow-right"></i> Lihat Rekam Medis
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.12);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #0077b6 0%, #023e8a 100%);
}

.btn-lg {
    padding: 12px 20px;
    font-size: 1rem;
}

.alert {
    border-left: 4px solid;
}

.alert-info {
    border-left-color: #0dcaf0;
}

.alert-success {
    border-left-color: #198754;
}
</style>
@endpush
@endsection