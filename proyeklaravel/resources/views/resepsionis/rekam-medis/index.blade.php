@extends('layout.resepsionis')

@section('title', 'Rekam Medis - History')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">📋 Rekam Medis</h2>
            <p class="text-muted mb-0">Lihat history rekam medis pasien</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Filters -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('resepsionis.rekam-medis.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">🔍 Cari Nama Hewan / Pemilik</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Ketik nama hewan atau pemilik..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">📅 Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" 
                           value="{{ request('tanggal') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">🐾 Pilih Hewan</label>
                    <select name="idpet" class="form-select">
                        <option value="">-- Semua Hewan --</option>
                        @foreach($pets as $pet)
                        <option value="{{ $pet->idpet }}" {{ request('idpet') == $pet->idpet ? 'selected' : '' }}>
                            {{ $pet->nama_pet }} ({{ $pet->nama_pemilik }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                    <a href="{{ route('resepsionis.rekam-medis.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Badge -->
    <div class="alert alert-info mb-4">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Info:</strong> Anda hanya dapat melihat rekam medis. Untuk menambah/edit, silakan hubungi dokter.
    </div>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Hewan</th>
                            <th>Pemilik</th>
                            <th>Dokter</th>
                            <th>Diagnosa</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekamMedis as $index => $rm)
                        <tr>
                            <td>{{ $rekamMedis->firstItem() + $index }}</td>
                            <td>
                                <div>{{ \Carbon\Carbon::parse($rm->created_at)->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($rm->created_at)->format('H:i') }}</small>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $rm->nama_pet }}</div>
                                <small class="text-muted">{{ $rm->nama_ras }}</small>
                            </td>
                            <td>
                                <div>{{ $rm->nama_pemilik }}</div>
                                <small class="text-muted">
                                    <i class="bi bi-whatsapp"></i> {{ $rm->no_wa }}
                                </small>
                            </td>
                            <td>
                                <i class="bi bi-person-badge"></i> {{ $rm->nama_dokter }}
                            </td>
                            <td>
                                <small>{{ Str::limit($rm->diagnosa, 50) }}</small>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('resepsionis.rekam-medis.show', $rm->idrekam_medis) }}" 
                                   class="btn btn-sm btn-info" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Tidak ada rekam medis ditemukan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Menampilkan {{ $rekamMedis->firstItem() ?? 0 }} - {{ $rekamMedis->lastItem() ?? 0 }} 
                    dari {{ $rekamMedis->total() }} data
                </div>
                {{ $rekamMedis->links() }}
            </div>
        </div>
    </div>
</div>

<style>
.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}
</style>
@endsection