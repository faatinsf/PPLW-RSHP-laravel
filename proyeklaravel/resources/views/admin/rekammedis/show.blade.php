@extends('layout.admin')

@section('title', 'Detail Rekam Medis | RSHP Unair')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-file-text"></i> Detail Rekam Medis</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('rekammedis.index') }}">Data Rekam Medis</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div>

<div class="row">
    <!-- Informasi Hewan & Pemilik -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-heart-pulse"></i> Informasi Hewan</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td width="40%" class="fw-semibold">Nama Hewan</td>
                        <td>: {{ $rekamMedis->nama_pet }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Jenis/Ras</td>
                        <td>: {{ $rekamMedis->nama_jenis_hewan }} - {{ $rekamMedis->nama_ras }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Jenis Kelamin</td>
                        <td>: 
                            @if($rekamMedis->jenis_kelamin == 'J')
                                <span class="badge bg-primary">Jantan</span>
                            @else
                                <span class="badge bg-danger">Betina</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Tanggal Lahir</td>
                        <td>: {{ \Carbon\Carbon::parse($rekamMedis->tanggal_lahir)->format('d/m/Y') }}
                            ({{ \Carbon\Carbon::parse($rekamMedis->tanggal_lahir)->age }} tahun)
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Warna/Tanda</td>
                        <td>: {{ $rekamMedis->warna_tanda }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Informasi Pemilik -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-person"></i> Informasi Pemilik</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td width="40%" class="fw-semibold">Nama Pemilik</td>
                        <td>: {{ $rekamMedis->nama_pemilik }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Email</td>
                        <td>: {{ $rekamMedis->email_pemilik }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">No. WhatsApp</td>
                        <td>: 
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $rekamMedis->no_wa) }}" 
                               target="_blank" 
                               class="text-success">
                                <i class="bi bi-whatsapp"></i> {{ $rekamMedis->no_wa }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Alamat</td>
                        <td>: {{ $rekamMedis->alamat }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Informasi Pemeriksaan -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="bi bi-clipboard-check"></i> Informasi Pemeriksaan</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <p class="mb-1"><strong>Dokter Pemeriksa:</strong></p>
                <p><i class="bi bi-person-badge"></i> {{ $rekamMedis->nama_dokter }}</p>
            </div>
            <div class="col-md-6">
                <p class="mb-1"><strong>Tanggal Pemeriksaan:</strong></p>
                <p><i class="bi bi-calendar"></i> 
                    {{ \Carbon\Carbon::parse($rekamMedis->created_at)->format('d F Y, H:i') }} WIB
                </p>
            </div>
        </div>

        <hr>

        <div class="mb-3">
            <h6 class="text-primary"><i class="bi bi-chat-dots"></i> Anamnesa</h6>
            <p class="bg-light p-3 rounded">{{ $rekamMedis->anamnesa }}</p>
        </div>

        <div class="mb-3">
            <h6 class="text-primary"><i class="bi bi-clipboard-data"></i> Temuan Klinis</h6>
            <p class="bg-light p-3 rounded">{{ $rekamMedis->temuan_klinis }}</p>
        </div>

        <div class="mb-3">
            <h6 class="text-primary"><i class="bi bi-file-medical"></i> Diagnosa</h6>
            <p class="bg-warning bg-opacity-25 p-3 rounded fw-semibold">{{ $rekamMedis->diagnosa }}</p>
        </div>
    </div>
</div>

<!-- Detail Tindakan/Terapi -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-warning">
        <h5 class="mb-0"><i class="bi bi-capsule"></i> Detail Tindakan / Terapi</h5>
    </div>
    <div class="card-body">
        @if($detailRekamMedis->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="10%">Kode</th>
                        <th width="20%">Kategori</th>
                        <th width="15%">Tipe</th>
                        <th width="40%">Deskripsi</th>
                        <th width="15%">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($detailRekamMedis as $detail)
                    <tr>
                        <td><span class="badge bg-secondary">{{ $detail->kode }}</span></td>
                        <td>{{ $detail->nama_kategori }}</td>
                        <td>
                            @if($detail->nama_kategori_klinis == 'Terapi')
                                <span class="badge bg-primary">{{ $detail->nama_kategori_klinis }}</span>
                            @else
                                <span class="badge bg-info">{{ $detail->nama_kategori_klinis }}</span>
                            @endif
                        </td>
                        <td>{{ $detail->deskripsi_tindakan_terapi }}</td>
                        <td>
                            @if($detail->detail)
                                <small class="text-muted">{{ $detail->detail }}</small>
                            @else
                                <small class="text-muted fst-italic">-</small>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-4 text-muted">
            <i class="bi bi-inbox" style="font-size: 2rem;"></i>
            <p class="mt-2">Belum ada detail tindakan/terapi</p>
        </div>
        @endif
    </div>
</div>

<!-- Action Buttons -->
<div class="d-flex gap-2">
    <a href="{{ route('rekammedis.edit', $rekamMedis->idrekam_medis) }}" class="btn btn-warning">
        <i class="bi bi-pencil"></i> Edit
    </a>
    <a href="{{ route('rekammedis.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <button type="button" class="btn btn-primary" onclick="window.print()">
        <i class="bi bi-printer"></i> Cetak
    </button>
</div>

@endsection