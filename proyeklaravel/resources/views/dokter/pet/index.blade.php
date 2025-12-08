@extends('layout.dokter')

@section('title', 'Data Hewan Pasien')
@section('page-title', 'Data Hewan Pasien')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-1"><i class="fas fa-paw text-primary me-2"></i>Data Hewan Pasien</h2>
            <p class="text-muted mb-0">Lihat informasi hewan yang terdaftar</p>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Cari nama hewan, pemilik, atau telepon..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="jenis" class="form-select">
                                    <option value="">Semua Jenis</option>
                                    @foreach($jenisHewan as $jenis)
                                        <option value="{{ $jenis->idjenis_hewan }}" 
                                                {{ request('jenis') == $jenis->idjenis_hewan ? 'selected' : '' }}>
                                            {{ $jenis->nama_jenis_hewan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search me-1"></i>Cari
                                </button>
                            </div>
                            <div class="col-md-1">
                                <a href="{{ route('dokter.pet.index') }}" class="btn btn-secondary w-100">
                                    <i class="fas fa-redo"></i> ↺
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Nama Hewan</th>
                                    <th width="15%">Jenis & Ras</th>
                                    <th width="10%">Kelamin</th>
                                    <th width="10%">Umur</th>
                                    <th width="25%">Pemilik</th>
                                    <th width="10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pets as $pet)
                                <tr>
                                    <td>{{ ($pets->currentPage() - 1) * $pets->perPage() + $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $pet->nama_pet }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $pet->nama_jenis_hewan }}</span>
                                        <br>
                                        <small class="text-muted">{{ $pet->nama_ras }}</small>
                                    </td>
                                    <td>
                                        @if($pet->jenis_kelamin == 'J')
                                            <i class="fas fa-mars text-primary me-1"></i>Jantan
                                        @else
                                            <i class="fas fa-venus text-danger me-1"></i>Betina
                                        @endif
                                    </td>
                                    <td>
                                        @if($pet->tanggal_lahir)
                                            {{ \Carbon\Carbon::parse($pet->tanggal_lahir)->age }} tahun
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $pet->nama_pemilik }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            <i class="fas fa-phone me-1"></i>{{ $pet->no_wa }}
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('dokter.pet.show', $pet->idpet) }}" 
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-paw fa-3x mb-3 d-block"></i>
                                        <h5>Belum ada data hewan</h5>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($pets->hasPages())
                <div class="card-footer bg-white">
                    {{ $pets->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection