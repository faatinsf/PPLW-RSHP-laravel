@extends('layout.dokter')

@section('title', 'Data Pemilik')
@section('page-title', 'Data Pemilik')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-1"><i class="fas fa-users text-success me-2"></i>Data Pemilik</h2>
            <p class="text-muted mb-0">Lihat informasi pemilik hewan</p>
        </div>
    </div>


    

    <!-- Search -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Cari nama, telepon, atau email..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search me-1"></i>Cari
                                </button>
                            </div>
                            <div class="col-md-1">
                                <a href="{{ route('dokter.pemilik.index') }}" class="btn btn-secondary w-100">
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
                                    <th width="25%">Nama</th>
                                    <th width="18%">No. WhatsApp</th>
                                    <th width="22%">Email</th>
                                    <th width="20%">Alamat</th>
                                    <th width="10%" class="text-center">Jumlah Hewan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pemilik as $pm)
                                <tr>
                                    <td>{{ ($pemilik->currentPage() - 1) * $pemilik->perPage() + $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('dokter.pemilik.show', $pm->idpemilik) }}" 
                                           class="text-decoration-none">
                                            <strong>{{ $pm->nama_pemilik }}</strong>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $pm->no_wa) }}" 
                                           target="_blank" 
                                           class="text-decoration-none">
                                            <i class="fab fa-whatsapp text-success me-1"></i>{{ $pm->no_wa }}
                                        </a>
                                    </td>
                                    <td>
                                        @if($pm->email)
                                            <a href="mailto:{{ $pm->email }}" class="text-decoration-none">
                                                {{ $pm->email }}
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($pm->alamat ?? '-', 40) }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-primary">{{ $pm->jumlah_pet }} Hewan</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-users fa-3x mb-3 d-block"></i>
                                        <h5>Belum ada data pemilik</h5>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($pemilik->hasPages())
                <div class="card-footer bg-white">
                    {{ $pemilik->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection