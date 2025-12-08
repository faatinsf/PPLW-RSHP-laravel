@extends('layout.dokter')

@section('title', 'Detail Pemilik')
@section('page-title', 'Detail Pemilik')

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dokter.pemilik.index') }}">Data Pemilik</a></li>
            <li class="breadcrumb-item active">{{ $pemilik->nama_pemilik }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Data Pemilik</h5>
                </div>
                <div class="card-body text-center">
                    <div class="owner-avatar mx-auto mb-3">
                        {{ strtoupper(substr($pemilik->nama_pemilik, 0, 2)) }}
                    </div>
                    
                    <h4 class="mb-1">{{ $pemilik->nama_pemilik }}</h4>
                    <span class="badge bg-success mb-3">{{ $pets->count() }} Hewan</span>
                    
                    <hr>
                    
                    <div class="text-start">
                        <div class="mb-3">
                            <small class="text-muted d-block">No. WhatsApp:</small>
                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', $pemilik->no_wa) }}" 
                               target="_blank" 
                               class="text-decoration-none">
                                <i class="fab fa-whatsapp text-success me-1"></i>
                                <strong>{{ $pemilik->no_wa }}</strong>
                            </a>
                            <br>
                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', $pemilik->no_wa) }}" 
                               target="_blank" 
                               class="btn btn-sm btn-success mt-2 w-100">
                                <i class="fab fa-whatsapp me-1"></i>Kirim WhatsApp
                            </a>
                        </div>
                        
                        @if($pemilik->email)
                        <div class="mb-3">
                            <small class="text-muted d-block">Email:</small>
                            <a href="mailto:{{ $pemilik->email }}" class="text-decoration-none">
                                <i class="fas fa-envelope text-primary me-1"></i>
                                <strong>{{ $pemilik->email }}</strong>
                            </a>
                        </div>
                        @endif
                        
                        @if($pemilik->alamat)
                        <div>
                            <small class="text-muted d-block">Alamat:</small>
                            <p class="mb-0">
                                <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                {{ $pemilik->alamat }}
                            </p>
                        </div>
                        @endif
                    </div>
                    
                    <hr>
                    
                    <a href="{{ route('dokter.pemilik.index') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-paw text-primary me-2"></i>Hewan Terdaftar</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($pets as $pet)
                        <div class="col-md-6 mb-3">
                            <div class="card border h-100">
                                <div class="card-body">
                                    <h5 class="mb-1">{{ $pet->nama_pet }}</h5>
                                    <div class="mb-2">
                                        <span class="badge bg-primary">{{ $pet->nama_jenis_hewan }}</span>
                                        <span class="badge bg-secondary">{{ $pet->nama_ras }}</span>
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class="small">
                                        <div class="mb-1">
                                            @if($pet->jenis_kelamin == 'J')
                                                <i class="fas fa-mars text-primary me-1"></i>Jantan
                                            @else
                                                <i class="fas fa-venus text-danger me-1"></i>Betina
                                            @endif
                                        </div>
                                        @if($pet->tanggal_lahir)
                                        <div class="mb-1">
                                            <i class="fas fa-birthday-cake text-warning me-1"></i>
                                            {{ \Carbon\Carbon::parse($pet->tanggal_lahir)->age }} tahun
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <hr>
                                    
                                    <a href="{{ route('dokter.pet.show', $pet->idpet) }}" 
                                       class="btn btn-sm btn-info w-100">
                                        <i class="fas fa-eye me-1"></i>Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-paw fa-3x mb-3 d-block"></i>
                                <h5>Belum ada hewan terdaftar</h5>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .owner-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
        font-weight: 700;
    }
</style>
@endsection