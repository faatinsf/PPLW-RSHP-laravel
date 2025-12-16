@extends('layout.pemilik')

@section('title', 'Rekam Medis')
@section('page-title', 'Rekam Medis Pet')
@section('breadcrumb', 'Home / Rekam Medis')

@section('content')
<div class="container-fluid">

    <!-- Filter -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('pemilik.medical-record') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Filter Pet</label>
                        <select class="form-select" name="pet" onchange="this.form.submit()">
                            <option value="">Semua Pet</option>
                            @foreach($pets as $pet)
                            <option value="{{ $pet->idpet }}" {{ request('pet') == $pet->idpet ? 'selected' : '' }}>
                                {{ $pet->nama }} ({{ $pet->nama_ras }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Periode</label>
                        <select class="form-select" name="periode" onchange="this.form.submit()">
                            <option value="">Semua Periode</option>
                            <option value="1" {{ request('periode') == '1' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="3" {{ request('periode') == '3' ? 'selected' : '' }}>3 Bulan Terakhir</option>
                            <option value="6" {{ request('periode') == '6' ? 'selected' : '' }}>6 Bulan Terakhir</option>
                            <option value="12" {{ request('periode') == '12' ? 'selected' : '' }}>1 Tahun Terakhir</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Cari</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari diagnosa atau tindakan...">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            @if(request()->hasAny(['pet', 'periode', 'search']))
                            <a href="{{ route('pemilik.medical-record') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Medical Records -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-file-medical me-2 text-danger"></i>
                Riwayat Rekam Medis
                <span class="badge bg-primary ms-2">{{ $rekamMedis->total() }} Total</span>
            </h5>
        </div>
        <div class="card-body">
            @if($rekamMedis->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Pet</th>
                            <th>Dokter</th>
                            <th>Anamnesa</th>
                            <th>Diagnosa</th>
                            <th>Tindakan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekamMedis as $rm)
                        <tr>
                            <td>
                                <i class="fas fa-calendar-day text-muted me-2"></i>
                                {{ \Carbon\Carbon::parse($rm->created_at)->isoFormat('D MMM YYYY') }}
                                <br>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($rm->created_at)->format('H:i') }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                                        @if(str_contains(strtolower($rm->nama_jenis_hewan), 'kucing'))
                                        <i class="fas fa-cat text-primary"></i>
                                        @elseif(str_contains(strtolower($rm->nama_jenis_hewan), 'anjing'))
                                        <i class="fas fa-dog text-success"></i>
                                        @else
                                        <i class="fas fa-paw text-warning"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <strong>{{ $rm->nama_pet }}</strong>
                                        <br><small class="text-muted">{{ $rm->nama_ras }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <strong>{{ $rm->nama_dokter }}</strong>
                            </td>
                            <td>
                                <div style="max-width: 200px;">
                                    {{ Str::limit($rm->anamnesa, 50) }}
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-danger bg-opacity-10 text-danger">
                                    {{ Str::limit($rm->diagnosa, 30) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $rm->jumlah_detail }} Tindakan
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('pemilik.medical-record.show', $rm->idrekam_medis) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Menampilkan {{ $rekamMedis->firstItem() ?? 0 }} - {{ $rekamMedis->lastItem() ?? 0 }} dari {{ $rekamMedis->total() }} data
                </div>
                {{ $rekamMedis->appends(request()->query())->links() }}
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-file-medical fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum Ada Rekam Medis</h5>
                <p class="text-muted">Rekam medis akan muncul setelah kunjungan pertama</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Info Stats -->
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm border-primary h-100">
                <div class="card-body text-center">
                    <i class="fas fa-file-medical fa-2x text-primary mb-2"></i>
                    <h3 class="mb-1">{{ $rekamMedis->total() }}</h3>
                    <small class="text-muted">Total Rekam Medis</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm border-success h-100">
                <div class="card-body text-center">
                    <i class="fas fa-paw fa-2x text-success mb-2"></i>
                    <h3 class="mb-1">{{ $pets->count() }}</h3>
                    <small class="text-muted">Total Pet</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm border-warning h-100">
                <div class="card-body text-center">
                    <i class="fas fa-user-md fa-2x text-warning mb-2"></i>
                    <h3 class="mb-1">
                        {{ $rekamMedis->pluck('dokter_pemeriksa')->unique()->count() }}
                    </h3>
                    <small class="text-muted">Dokter yang Menangani</small>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
.table tbody tr {
    transition: all 0.2s;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
    transform: scale(1.01);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.badge {
    animation: fadeIn 0.5s;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
</style>
@endpush