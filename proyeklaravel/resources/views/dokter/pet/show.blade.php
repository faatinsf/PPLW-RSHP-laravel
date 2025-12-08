@extends('layout.dokter')

@section('title', 'Detail Hewan')
@section('page-title', 'Detail Hewan')

@section('content')

<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dokter.pet.index') }}">Data Hewan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Hewan</li>
        </ol>
    </nav>

    {{-- Card Detail Hewan --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Informasi Hewan</h5>
        </div>
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Nama Hewan</div>
                <div class="col-md-8">{{ $pet->nama }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Jenis Kelamin</div>
                <div class="col-md-8">
                    {{ ucfirst($pet->jenis_kelamin) }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Tanggal Lahir</div>
                <div class="col-md-8">
                    {{ $pet->tanggal_lahir ? \Carbon\Carbon::parse($pet->tanggal_lahir)->format('d M Y') : '-' }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Warna / Tanda Khusus</div>
                <div class="col-md-8">{{ $pet->warna_tanda }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Ras Hewan</div>
                <div class="col-md-8">{{ $pet->nama_ras }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Jenis Hewan</div>
                <div class="col-md-8">{{ $pet->nama_jenis_hewan }}</div>
            </div>

        </div>
    </div>

    {{-- Card Informasi Pemilik --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Informasi Pemilik</h5>
        </div>
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Nama Pemilik</div>
                <div class="col-md-8">{{ $pet->nama_pemilik }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Nomor WA</div>
                <div class="col-md-8">
                    <a href="https://wa.me/{{ $pet->no_wa }}" target="_blank">
                        {{ $pet->no_wa }}
                    </a>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Alamat</div>
                <div class="col-md-8">{{ $pet->alamat }}</div>
            </div>

        </div>
    </div>

    {{-- Card Riwayat Rekam Medis --}}
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Riwayat Rekam Medis</h5>
        </div>
        <div class="card-body">

            @if ($rekamMedisHistory->isEmpty())
                <p class="text-muted">Belum ada riwayat rekam medis.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Dokter</th>
                                <th>Anamnesa</th>
                                <th>Temuan Klinis</th>
                                <th>Diagnosa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rekamMedisHistory as $rm)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($rm->created_at)->format('d M Y H:i') }}</td>
                                    <td>{{ $rm->nama_dokter ?? '-' }}</td>
                                    <td>{{ $rm->anamnesa }}</td>
                                    <td>{{ $rm->temuan_klinis }}</td>
                                    <td>{{ $rm->diagnosa }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>

</div>

@endsection
