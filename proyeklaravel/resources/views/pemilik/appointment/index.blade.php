@extends('layout.pemilik')

@section('title', 'Janji Temu')
@section('page-title', 'Janji Temu')
@section('breadcrumb', 'Home / Janji Temu')

@section('content')
<div class="container-fluid">

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Header Actions -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Janji Temu</h2>
            <p class="text-muted mb-0">Kelola jadwal kunjungan Anda</p>
        </div>
        <a href="{{ route('pemilik.appointment.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i> Buat Janji Temu
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1">Menunggu Konfirmasi</p>
                            <h3 class="mb-0">{{ $pendingAppointments->count() }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="fas fa-clock text-warning" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1">Terjadwal</p>
                            <h3 class="mb-0">{{ $upcomingAppointments->count() }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-calendar-check text-primary" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1">Selesai</p>
                            <h3 class="mb-0">{{ $completedAppointments->count() }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-check-circle text-success" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1">Dibatalkan</p>
                            <h3 class="mb-0">{{ $cancelledAppointments->count() }}</h3>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded">
                            <i class="fas fa-times-circle text-danger" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#upcoming" role="tab">
                        <i class="fas fa-calendar-alt me-2"></i>Terjadwal ({{ $upcomingAppointments->count() }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#pending" role="tab">
                        <i class="fas fa-clock me-2"></i>Menunggu ({{ $pendingAppointments->count() }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#completed" role="tab">
                        <i class="fas fa-check me-2"></i>Selesai ({{ $completedAppointments->count() }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#cancelled" role="tab">
                        <i class="fas fa-times me-2"></i>Dibatalkan ({{ $cancelledAppointments->count() }})
                    </a>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content">
                <!-- Upcoming Appointments -->
                <div class="tab-pane fade show active" id="upcoming" role="tabpanel">
                    @if($upcomingAppointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal & Waktu</th>
                                        <th>Pet</th>
                                        <th>Jenis Layanan</th>
                                        <th>Keluhan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($upcomingAppointments as $apt)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 p-2 rounded me-2">
                                                    <i class="fas fa-calendar text-primary"></i>
                                                </div>
                                                <div>
                                                    <strong>{{ \Carbon\Carbon::parse($apt->tanggal_appointment)->isoFormat('D MMM YYYY') }}</strong><br>
                                                    <small class="text-muted">{{ \Carbon\Carbon::parse($apt->waktu_appointment)->format('H:i') }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($apt->nama_pet)
                                                <strong>{{ $apt->nama_pet }}</strong><br>
                                                <small class="text-muted">{{ $apt->nama_ras }}</small>
                                            @else
                                                <span class="text-muted">Belum dipilih</span>
                                            @endif
                                        </td>
                                        <td>{{ $apt->jenis_layanan }}</td>
                                        <td>
                                            @if($apt->keluhan)
                                                {{ Str::limit($apt->keluhan, 50) }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">
                                                <i class="fas fa-check-circle me-1"></i>Dikonfirmasi
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('pemilik.appointment.show', $apt->idappointment) }}" 
                                               class="btn btn-sm btn-outline-info me-1">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('pemilik.appointment.cancel', $apt->idappointment) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin membatalkan appointment ini?')">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times text-muted" style="font-size: 4rem;"></i>
                            <p class="text-muted mt-3">Tidak ada janji temu yang terjadwal</p>
                            <a href="{{ route('pemilik.appointment.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Buat Janji Temu
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Pending Appointments -->
                <div class="tab-pane fade" id="pending" role="tabpanel">
                    @if($pendingAppointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal & Waktu</th>
                                        <th>Pet</th>
                                        <th>Jenis Layanan</th>
                                        <th>Keluhan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingAppointments as $apt)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-warning bg-opacity-10 p-2 rounded me-2">
                                                    <i class="fas fa-calendar text-warning"></i>
                                                </div>
                                                <div>
                                                    <strong>{{ \Carbon\Carbon::parse($apt->tanggal_appointment)->isoFormat('D MMM YYYY') }}</strong><br>
                                                    <small class="text-muted">{{ \Carbon\Carbon::parse($apt->waktu_appointment)->format('H:i') }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($apt->nama_pet)
                                                <strong>{{ $apt->nama_pet }}</strong><br>
                                                <small class="text-muted">{{ $apt->nama_ras }}</small>
                                            @else
                                                <span class="text-muted">Belum dipilih</span>
                                            @endif
                                        </td>
                                        <td>{{ $apt->jenis_layanan }}</td>
                                        <td>
                                            @if($apt->keluhan)
                                                {{ Str::limit($apt->keluhan, 50) }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock me-1"></i>Menunggu Konfirmasi
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('pemilik.appointment.show', $apt->idappointment) }}" 
                                               class="btn btn-sm btn-outline-info me-1">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('pemilik.appointment.cancel', $apt->idappointment) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin membatalkan appointment ini?')">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-hourglass-half text-muted" style="font-size: 4rem;"></i>
                            <p class="text-muted mt-3">Tidak ada appointment yang menunggu konfirmasi</p>
                        </div>
                    @endif
                </div>

                <!-- Completed Appointments -->
                <div class="tab-pane fade" id="completed" role="tabpanel">
                    @if($completedAppointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal & Waktu</th>
                                        <th>Pet</th>
                                        <th>Jenis Layanan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($completedAppointments as $apt)
                                    <tr>
                                        <td>
                                            <strong>{{ \Carbon\Carbon::parse($apt->tanggal_appointment)->isoFormat('D MMM YYYY') }}</strong><br>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($apt->waktu_appointment)->format('H:i') }}</small>
                                        </td>
                                        <td>
                                            @if($apt->nama_pet)
                                                <strong>{{ $apt->nama_pet }}</strong><br>
                                                <small class="text-muted">{{ $apt->nama_ras }}</small>
                                            @else
                                                <span class="text-muted">Belum dipilih</span>
                                            @endif
                                        </td>
                                        <td>{{ $apt->jenis_layanan }}</td>
                                        <td>
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>Selesai
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('pemilik.appointment.show', $apt->idappointment) }}" 
                                               class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye me-1"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-check text-muted" style="font-size: 4rem;"></i>
                            <p class="text-muted mt-3">Belum ada appointment yang selesai</p>
                        </div>
                    @endif
                </div>

                <!-- Cancelled Appointments -->
                <div class="tab-pane fade" id="cancelled" role="tabpanel">
                    @if($cancelledAppointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal & Waktu</th>
                                        <th>Pet</th>
                                        <th>Jenis Layanan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cancelledAppointments as $apt)
                                    <tr>
                                        <td>
                                            <strong>{{ \Carbon\Carbon::parse($apt->tanggal_appointment)->isoFormat('D MMM YYYY') }}</strong><br>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($apt->waktu_appointment)->format('H:i') }}</small>
                                        </td>
                                        <td>
                                            @if($apt->nama_pet)
                                                <strong>{{ $apt->nama_pet }}</strong><br>
                                                <small class="text-muted">{{ $apt->nama_ras }}</small>
                                            @else
                                                <span class="text-muted">Belum dipilih</span>
                                            @endif
                                        </td>
                                        <td>{{ $apt->jenis_layanan }}</td>
                                        <td>
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times-circle me-1"></i>Dibatalkan
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('pemilik.appointment.show', $apt->idappointment) }}" 
                                               class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye me-1"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-ban text-muted" style="font-size: 4rem;"></i>
                            <p class="text-muted mt-3">Tidak ada appointment yang dibatalkan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection