@extends('layout.dokter')

@section('title', 'Rekam Medis Pasien')
@section('page-title', 'Rekam Medis Pasien')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1"><i class="fas fa-file-medical text-danger me-2"></i>Rekam Medis Pasien</h2>
                    <p class="text-muted mb-0">Kelola hasil pemeriksaan pasien Anda</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Search & Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Cari nama hewan atau pemilik..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="tanggal" class="form-control" 
                                       value="{{ request('tanggal') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search me-1"></i>Cari
                                </button>
                            </div>
                            <div class="col-md-1">
                                <a href="{{ route('dokter.rekam-medis.index') }}" class="btn btn-secondary w-100">
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
                                    <th width="12%">Tanggal</th>
                                    <th width="18%">Nama Hewan</th>
                                    <th width="18%">Pemilik</th>
                                    <th width="25%">Anamnesa</th>
                                    <th width="12%">Status</th>
                                    <th width="10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekamMedis as $rm)
                                <tr>
                                    <td>{{ ($rekamMedis->currentPage() - 1) * $rekamMedis->perPage() + $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ \Carbon\Carbon::parse($rm->created_at)->format('d/m/Y') }}</strong>
                                        <br>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($rm->created_at)->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $rm->nama_pet }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $rm->nama_jenis_hewan }}</small>
                                    </td>
                                    <td>{{ $rm->nama_pemilik }}</td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 250px;">
                                            {{ $rm->anamnesa }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($rm->diagnosa)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>Selesai
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock me-1"></i>Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('dokter.rekam-medis.show', $rm->idrekam_medis) }}" 
                                               class="btn btn-sm btn-info" title="Detail">
                                                <i class="fas fa-eye"></i> Show
                                            </a>
                                            @if(!$rm->diagnosa)
                                            <a href="{{ route('dokter.rekam-medis.edit', $rm->idrekam_medis) }}" 
                                               class="btn btn-sm btn-primary" title="Isi Pemeriksaan">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-file-medical fa-3x mb-3 d-block"></i>
                                        <h5>Belum ada rekam medis</h5>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($rekamMedis->hasPages())
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Menampilkan {{ $rekamMedis->firstItem() }} - {{ $rekamMedis->lastItem() }} dari {{ $rekamMedis->total() }} data
                        </div>
                        {{ $rekamMedis->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
