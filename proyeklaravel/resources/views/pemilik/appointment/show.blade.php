@extends('layout.pemilik')

@section('title', 'Detail Janji Temu')
@section('page-title', 'Detail Janji Temu')
@section('breadcrumb', 'Home / Janji Temu / Detail')

@section('content')
<div class="container-fluid">

    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('pemilik.appointment') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Appointment Info Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-alt me-2 text-primary"></i>
                        Informasi Janji Temu
                    </h5>
                    @if($appointment->status == 'pending')
                        <span class="badge bg-warning">
                            <i class="fas fa-clock me-1"></i>Menunggu Konfirmasi
                        </span>
                    @elseif($appointment->status == 'dikonfirmasi')
                        <span class="badge bg-primary">
                            <i class="fas fa-check-circle me-1"></i>Dikonfirmasi
                        </span>
                    @elseif($appointment->status == 'selesai')
                        <span class="badge bg-success">
                            <i class="fas fa-check-circle me-1"></i>Selesai
                        </span>
                    @else
                        <span class="badge bg-danger">
                            <i class="fas fa-times-circle me-1"></i>Dibatalkan
                        </span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">TANGGAL KUNJUNGAN</label>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                                    <i class="fas fa-calendar fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0">{{ \Carbon\Carbon::parse($appointment->tanggal_appointment)->isoFormat('D MMMM YYYY') }}</h4>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($appointment->tanggal_appointment)->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">WAKTU KUNJUNGAN</label>
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 p-3 rounded me-3">
                                    <i class="fas fa-clock fa-2x text-success"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0">{{ \Carbon\Carbon::parse($appointment->waktu_appointment)->format('H:i') }} WIB</h4>
                                    <small class="text-muted">Harap datang 10 menit lebih awal</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">JENIS LAYANAN</label>
                            <p class="mb-0">
                                <i class="fas fa-hand-holding-medical text-primary me-2"></i>
                                <strong>{{ $appointment->jenis_layanan }}</strong>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">NOMOR APPOINTMENT</label>
                            <p class="mb-0">
                                <i class="fas fa-hashtag text-info me-2"></i>
                                <strong>APT-{{ str_pad($appointment->idappointment, 5, '0', STR_PAD_LEFT) }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pet Info Card -->
            @if($appointment->nama_pet)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-paw me-2 text-success"></i>
                        Informasi Pet
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">NAMA PET</label>
                            <p class="mb-0">
                                <strong>{{ $appointment->nama_pet }}</strong>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">JENIS & RAS</label>
                            <p class="mb-0">
                                <strong>{{ $appointment->nama_jenis_hewan }} - {{ $appointment->nama_ras }}</strong>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">JENIS KELAMIN</label>
                            <p class="mb-0">
                                @if($appointment->jenis_kelamin == 'J')
                                    <i class="fas fa-mars text-primary me-1"></i> Jantan
                                @else
                                    <i class="fas fa-venus text-danger me-1"></i> Betina
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">UMUR</label>
                            <p class="mb-0">
                                @if($appointment->tanggal_lahir)
                                    {{ \Carbon\Carbon::parse($appointment->tanggal_lahir)->age }} tahun
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Keluhan Card -->
            @if($appointment->keluhan)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-comment-medical me-2 text-warning"></i>
                        Keluhan / Catatan
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $appointment->keluhan }}</p>
                </div>
            </div>
            @endif

            <!-- Catatan Klinik -->
            @if($appointment->catatan_klinik)
            <div class="card border-0 shadow-sm border-info mb-4">
                <div class="card-header bg-info bg-opacity-10">
                    <h5 class="mb-0 text-info">
                        <i class="fas fa-notes-medical me-2"></i>
                        Catatan dari Klinik
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $appointment->catatan_klinik }}</p>
                </div>
            </div>
            @endif

            <!-- Actions -->
            @if(in_array($appointment->status, ['pending', 'dikonfirmasi']))
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Aksi</h6>
                    <form action="{{ route('pemilik.appointment.cancel', $appointment->idappointment) }}" 
                          method="POST"
                          onsubmit="return confirm('Yakin ingin membatalkan appointment ini?')">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times-circle me-2"></i> Batalkan Appointment
                        </button>
                        <small class="d-block text-muted mt-2">
                            <i class="fas fa-info-circle me-1"></i>
                            Harap batalkan minimal 24 jam sebelum jadwal jika tidak bisa hadir
                        </small>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Timeline Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2 text-secondary"></i>
                        Timeline
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <!-- Created -->
                        <div class="timeline-item mb-3">
                            <div class="d-flex">
                                <div class="timeline-icon bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="fas fa-plus text-success"></i>
                                </div>
                                <div>
                                    <strong class="d-block">Appointment Dibuat</strong>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($appointment->created_at)->isoFormat('D MMM YYYY, HH:mm') }}
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Status Updates -->
                        @if($appointment->status == 'dikonfirmasi')
                        <div class="timeline-item mb-3">
                            <div class="d-flex">
                                <div class="timeline-icon bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="fas fa-check text-primary"></i>
                                </div>
                                <div>
                                    <strong class="d-block">Dikonfirmasi</strong>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($appointment->updated_at)->isoFormat('D MMM YYYY, HH:mm') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        @elseif($appointment->status == 'selesai')
                        <div class="timeline-item mb-3">
                            <div class="d-flex">
                                <div class="timeline-icon bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="fas fa-check-double text-success"></i>
                                </div>
                                <div>
                                    <strong class="d-block">Selesai</strong>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($appointment->updated_at)->isoFormat('D MMM YYYY, HH:mm') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        @elseif($appointment->status == 'dibatalkan')
                        <div class="timeline-item mb-3">
                            <div class="d-flex">
                                <div class="timeline-icon bg-danger bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="fas fa-times text-danger"></i>
                                </div>
                                <div>
                                    <strong class="d-block">Dibatalkan</strong>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($appointment->updated_at)->isoFormat('D MMM YYYY, HH:mm') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Contact Card -->
            <div class="card border-0 shadow-sm bg-primary bg-opacity-10">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-phone-alt text-primary me-2"></i>
                        Butuh Bantuan?
                    </h6>
                    <p class="small mb-3">Hubungi kami jika ada pertanyaan tentang appointment Anda</p>
                    <div class="d-grid gap-2">
                        <a href="tel:031-123-4567" class="btn btn-primary btn-sm">
                            <i class="fas fa-phone me-2"></i> Telepon
                        </a>
                        <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-success btn-sm">
                            <i class="fab fa-whatsapp me-2"></i> WhatsApp
                        </a>
                        <a href="mailto:info@petklinik.com" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-envelope me-2"></i> Email
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    .timeline-item {
        position: relative;
    }
    
    .timeline-icon {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush