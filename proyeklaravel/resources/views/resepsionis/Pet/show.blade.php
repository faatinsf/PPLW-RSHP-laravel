@extends('layout.resepsionis')

@section('title', 'Detail Hewan | RSHP Unair')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-file-text"></i> Detail Hewan Peliharaan</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('resepsionis.pet.index') }}">Data Hewan</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div>

<div class="row">
    <!-- Informasi Hewan -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-heart-pulse"></i> Informasi Hewan</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td width="40%" class="fw-semibold">Nama Hewan</td>
                        <td>: <strong>{{ $pet->nama }}</strong></td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Jenis/Ras</td>
                        <td>: {{ $pet->nama_jenis_hewan }} - {{ $pet->nama_ras }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Jenis Kelamin</td>
                        <td>: 
                            @if($pet->jenis_kelamin == 'J')
                                <span class="badge bg-primary">Jantan</span>
                            @else
                                <span class="badge bg-danger">Betina</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Tanggal Lahir</td>
                        <td>: {{ \Carbon\Carbon::parse($pet->tanggal_lahir)->format('d/m/Y') }}
                            ({{ \Carbon\Carbon::parse($pet->tanggal_lahir)->age }} tahun)
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Warna/Tanda</td>
                        <td>: {{ $pet->warna_tanda }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Informasi Pemilik -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-person"></i> Informasi Pemilik</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td width="40%" class="fw-semibold">Nama Pemilik</td>
                        <td>: {{ $pet->nama_pemilik }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Email</td>
                        <td>: {{ $pet->email_pemilik }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">No. WhatsApp</td>
                        <td>: 
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pet->no_wa) }}" 
                               target="_blank" 
                               class="btn btn-success btn-sm">
                                <i class="bi bi-whatsapp"></i> {{ $pet->no_wa }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Alamat</td>
                        <td>: {{ $pet->alamat }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Rekam Medis -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-warning">
        <h5 class="mb-0"><i class="bi bi-clipboard-pulse"></i> Riwayat Rekam Medis (5 Terakhir)</h5>
    </div>
    <div class="card-body">
        @if($rekamMedis->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Dokter</th>
                        <th>Diagnosa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekamMedis as $rm)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($rm->created_at)->format('d/m/Y H:i') }}</td>
                        <td>{{ $rm->nama_dokter }}</td>
                        <td>{{ Str::limit($rm->diagnosa, 80) }}</td>
                        <td>
                            <a href="{{ route('rekammedis.show', $rm->idrekam_medis) }}" 
                               class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-4 text-muted">
            <i class="bi bi-inbox" style="font-size: 2rem;"></i>
            <p class="mt-2">Belum ada riwayat rekam medis</p>
        </div>
        @endif
    </div>
</div>

<!-- Action Buttons -->
<div class="d-flex gap-2">
    <a href="{{ route('resepsionis.pet.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <a href="{{ route('resepsionis.appointment.create') }}" class="btn btn-warning">
        <i class="bi bi-calendar-plus"></i> Buat Appointment
    </a>
</div>

@endsection