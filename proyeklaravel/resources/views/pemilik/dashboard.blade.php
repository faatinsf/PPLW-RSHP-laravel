@extends('layout.pemilik')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Home / Dashboard')

@section('content')
<div class="container-fluid">

    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-gradient-primary text-white" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="mb-2">Selamat Datang, {{ $pemilik->nama }}! 👋</h3>
                            <p class="mb-0 opacity-90">
                                {{ now()->isoFormat('dddd, D MMMM YYYY') }}
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <a href="{{ route('pemilik.appointment.create') }}" class="btn btn-light btn-lg">
                                <i class="fas fa-calendar-plus me-2"></i> Buat Janji Temu
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Total Pet</p>
                            <h2 class="mb-0 fw-bold">{{ $stats['total_pets'] }}</h2>
                            <small class="text-success">
                                <i class="fas fa-paw me-1"></i> Active
                            </small>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-paw text-primary" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('pemilik.pet') }}" class="text-decoration-none small">
                        Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Janji Temu Aktif</p>
                            <h2 class="mb-0 fw-bold">{{ $stats['active_appointments'] }}</h2>
                            <small class="text-info">
                                <i class="fas fa-calendar-check me-1"></i> Upcoming
                            </small>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-calendar-alt text-info" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('pemilik.appointment') }}" class="text-decoration-none small">
                        Lihat Jadwal <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Total Kunjungan</p>
                            <h2 class="mb-0 fw-bold">{{ $stats['total_medical_records'] }}</h2>
                            <small class="text-success">
                                <i class="fas fa-check me-1"></i> All Time
                            </small>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-file-medical text-success" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('pemilik.medical-record') }}" class="text-decoration-none small">
                        Lihat Rekam Medis <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Kunjungan Bulan Ini</p>
                            <h2 class="mb-0 fw-bold">{{ $stats['medical_records_this_month'] }}</h2>
                            <small class="text-warning">
                                <i class="fas fa-calendar me-1"></i> This Month
                            </small>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-chart-line text-warning" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <span class="text-muted small">
                        {{ now()->isoFormat('MMMM YYYY') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            
            <!-- Upcoming Appointments -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-alt text-primary me-2"></i>
                        Jadwal Temu Mendatang
                    </h5>
                    <a href="{{ route('pemilik.appointment') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @if($upcomingAppointments->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($upcomingAppointments as $apt)
                            <a href="{{ route('pemilik.appointment.show', $apt->idappointment) }}" 
                               class="list-group-item list-group-item-action border-0 px-0">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="bg-primary bg-opacity-10 p-3 rounded text-center" style="min-width: 80px;">
                                            <div class="fw-bold text-primary" style="font-size: 1.5rem;">
                                                {{ \Carbon\Carbon::parse($apt->tanggal_appointment)->format('d') }}
                                            </div>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($apt->tanggal_appointment)->isoFormat('MMM') }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">{{ $apt->jenis_layanan }}</h6>
                                                <p class="mb-1 text-muted small">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ \Carbon\Carbon::parse($apt->waktu_appointment)->format('H:i') }} WIB
                                                </p>
                                                @if($apt->nama_pet)
                                                <p class="mb-0 text-muted small">
                                                    <i class="fas fa-paw me-1"></i>
                                                    {{ $apt->nama_pet }} ({{ $apt->nama_ras }})
                                                </p>
                                                @endif
                                            </div>
                                            <div>
                                                @if($apt->status == 'pending')
                                                    <span class="badge bg-warning">Menunggu</span>
                                                @else
                                                    <span class="badge bg-success">Dikonfirmasi</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times text-muted mb-3" style="font-size: 3rem;"></i>
                            <p class="text-muted mb-3">Belum ada jadwal temu mendatang</p>
                            <a href="{{ route('pemilik.appointment.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i> Buat Janji Temu
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Medical Records -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-file-medical text-success me-2"></i>
                        Rekam Medis Terbaru
                    </h5>
                    <a href="{{ route('pemilik.medical-record') }}" class="btn btn-sm btn-outline-success">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @if($recentMedicalRecords->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Pet</th>
                                        <th>Dokter</th>
                                        <th>Diagnosa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentMedicalRecords as $record)
                                    <tr>
                                        <td>
                                            <small>{{ \Carbon\Carbon::parse($record->created_at)->isoFormat('D MMM YYYY') }}</small>
                                        </td>
                                        <td>
                                            <strong>{{ $record->nama_pet }}</strong>
                                        </td>
                                        <td>
                                            <small>{{ $record->nama_dokter }}</small>
                                        </td>
                                        <td>
                                            <small>{{ Str::limit($record->diagnosa, 50) }}</small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-folder-open text-muted mb-2" style="font-size: 2.5rem;"></i>
                            <p class="text-muted mb-0">Belum ada rekam medis</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            
            <!-- My Pets -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-paw text-primary me-2"></i>
                        Pet Saya
                    </h5>
                    <a href="{{ route('pemilik.pet') }}" class="btn btn-sm btn-outline-primary">
                        Lihat
                    </a>
                </div>
                <div class="card-body">
                    @if($pets->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($pets as $pet)
                            <div class="list-group-item border-0 px-0 py-2">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3" style="width: 45px; height: 45px;">
                                        @if($pet->nama_jenis_hewan == 'Anjing (Canis lupus familiaris)')
                                            <i class="fas fa-dog text-primary fa-lg"></i>
                                        @elseif(str_contains($pet->nama_jenis_hewan, 'Kucing'))
                                            <i class="fas fa-cat text-primary fa-lg"></i>
                                        @else
                                            <i class="fas fa-paw text-primary fa-lg"></i>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ $pet->nama }}</h6>
                                        <small class="text-muted">{{ $pet->nama_ras }}</small>
                                    </div>
                                    <div>
                                        @if($pet->jenis_kelamin == 'J')
                                            <i class="fas fa-mars text-primary"></i>
                                        @else
                                            <i class="fas fa-venus text-danger"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-paw text-muted mb-2" style="font-size: 2.5rem;"></i>
                            <p class="text-muted mb-2">Belum ada pet terdaftar</p>
                            <a href="{{ route('pemilik.pet.create') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus me-1"></i> Tambah Pet
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Vaccination Reminders -->
            @if($vaccinationReminders->count() > 0)
            <div class="card border-0 shadow-sm bg-warning bg-opacity-10 mb-4">
                <div class="card-header bg-transparent border-0">
                    <h6 class="mb-0 text-warning">
                        <i class="fas fa-bell me-2"></i>
                        Pengingat Vaksinasi
                    </h6>
                </div>
                <div class="card-body">
                    @foreach($vaccinationReminders as $reminder)
                    <div class="alert alert-warning mb-2">
                        <strong>{{ $reminder['pet_name'] }}</strong><br>
                        <small>{{ $reminder['message'] }}</small>
                    </div>
                    @endforeach
                    <a href="{{ route('pemilik.appointment.create') }}" class="btn btn-warning btn-sm w-100">
                        Buat Janji Vaksinasi
                    </a>
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        <i class="fas fa-bolt text-warning me-2"></i>
                        Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('pemilik.appointment.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-calendar-plus me-2"></i> Buat Janji Temu
                        </a>
                        <a href="{{ route('pemilik.pet.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-paw me-2"></i> Tambah Pet Baru
                        </a>
                        <a href="{{ route('pemilik.medical-record') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-file-medical me-2"></i> Lihat Rekam Medis
                        </a>
                        <a href="tel:031-123-4567" class="btn btn-danger btn-sm">
                            <i class="fas fa-phone me-2"></i> Hubungi Klinik
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
    .hover-card {
        transition: all 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    .list-group-item-action:hover {
        background-color: #f8f9fa;
    }
</style>
@endpush