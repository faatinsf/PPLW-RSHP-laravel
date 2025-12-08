@extends('layout.resepsionis')

@section('title', 'Data Hewan Peliharaan | RSHP Unair')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-heart-pulse"></i> Data Hewan Peliharaan</h3>
    <a href="{{ route('resepsionis.pet.create') }}" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg"></i> Tambah Hewan
    </a>
</div>

<!-- Alert Success -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Alert Error -->
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        @if($pets->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Nama Hewan</th>
                        <th width="10%">Jenis Kelamin</th>
                        <th width="12%">Tanggal Lahir</th>
                        <th width="15%">Ras</th>
                        <th width="18%">Pemilik</th>
                        <th width="15%">Kontak</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pets as $index => $pet)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td><strong>{{ $pet->nama }}</strong></td>
                        <td class="text-center">
                            @if($pet->jenis_kelamin == 'J')
                                <span class="badge bg-primary">
                                    <i class="bi bi-gender-male"></i> Jantan
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="bi bi-gender-female"></i> Betina
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($pet->tanggal_lahir)->format('d/m/Y') }}
                            <br>
                            <small class="text-muted">
                                ({{ \Carbon\Carbon::parse($pet->tanggal_lahir)->age }} tahun)
                            </small>
                        </td>
                        <td>
                            {{ $pet->nama_ras }}
                            <br>
                            <small class="text-muted">{{ $pet->nama_jenis_hewan }}</small>
                        </td>
                        <td>
                            {{ $pet->nama_pemilik }}
                            <br>
                            <small class="text-muted">
                                <i class="bi bi-envelope"></i> {{ $pet->email_pemilik }}
                            </small>
                        </td>
                        <td>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pet->no_wa) }}" 
                               target="_blank" 
                               class="btn btn-success btn-sm">
                                <i class="bi bi-whatsapp"></i> WhatsApp
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('resepsionis.pet.show', $pet->idpet) }}" 
                               class="btn btn-info btn-sm" 
                               title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
            <p class="text-muted mt-3">Belum ada data hewan peliharaan</p>
            <a href="{{ route('resepsionis.pet.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Tambah Data Pertama
            </a>
        </div>
        @endif
    </div>
</div>

@endsection