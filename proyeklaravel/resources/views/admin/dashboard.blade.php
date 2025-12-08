@extends('layout.admin')

@section('title', 'Dashboard Admin | RSHP Unair')

@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('content')
<!-- Info boxes -->
<div class="row">
    <!-- Jenis Hewan -->
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-primary">
            <div class="inner">
                <h3>{{ \App\Models\JenisHewan::count() }}</h3>
                <p>Jenis Hewan</p>
            </div>
            <i class="bi bi-heart-fill small-box-icon"></i>
            <a href="{{ route('jenis-hewan.index') }}" class="small-box-footer link-light">
                Lihat Detail <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    
    <!-- Ras Hewan -->
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-success">
            <div class="inner">
                <h3>{{ \App\Models\RasHewan::count() }}</h3>
                <p>Ras Hewan</p>
            </div>
            <i class="bi bi-list-ul small-box-icon"></i>
            <a href="{{ route('rashewan.index') }}" class="small-box-footer link-light">
                Lihat Detail <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    
    <!-- Kategori -->
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-warning">
            <div class="inner">
                <h3>{{ \App\Models\Kategori::count() }}</h3>
                <p>Kategori</p>
            </div>
            <i class="bi bi-grid-3x3-gap-fill small-box-icon"></i>
            <a href="{{ route('kategori.index') }}" class="small-box-footer link-dark">
                Lihat Detail <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    
    <!-- Total User -->
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-danger">
            <div class="inner">
                <h3>{{ \App\Models\User::count() }}</h3>
                <p>Total User</p>
            </div>
            <i class="bi bi-people-fill small-box-icon"></i>
            <a href="{{ route('user.index') }}" class="small-box-footer link-light">
                Lihat Detail <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- Welcome Card -->
<div class="row">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center p-5">
                <i class="bi bi-house-heart-fill text-primary" style="font-size: 4rem;"></i>
                <h3 class="mt-4 mb-3">Selamat Datang di Dashboard RSHP Unair!</h3>
                <p class="text-muted mb-4">
                    Sistem Informasi Rumah Sakit Hewan - Universitas Airlangga
                </p>
                @auth
                <div class="alert alert-info">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <strong>Halo, {{ Auth::user()->nama ?? 'User' }}!</strong> 
                    Anda login sebagai <strong>Administrator</strong>. 
                    Gunakan menu di sidebar untuk mengelola data master dan user.
                </div>
                @endauth
            </div>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="row mt-4">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-database me-2"></i>Data Master</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <a href="{{ route('jenis-hewan.index') }}" class="text-decoration-none">
                            <i class="bi bi-chevron-right text-primary"></i> Jenis Hewan
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('rashewan.index') }}" class="text-decoration-none">
                            <i class="bi bi-chevron-right text-primary"></i> Ras Hewan
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('kategori.index') }}" class="text-decoration-none">
                            <i class="bi bi-chevron-right text-primary"></i> Kategori
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('kategoriklinis.index') }}" class="text-decoration-none">
                            <i class="bi bi-chevron-right text-primary"></i> Kategori Klinis
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-people me-2"></i>Management</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <a href="{{ route('user.index') }}" class="text-decoration-none">
                            <i class="bi bi-chevron-right text-success"></i> Data User
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('role.index') }}" class="text-decoration-none">
                            <i class="bi bi-chevron-right text-success"></i> Data Role
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi</h5>
            </div>
            <div class="card-body">
                @auth
                <p class="mb-2"><strong>Nama:</strong> {{ Auth::user()->nama ?? 'N/A' }}</p>
                <p class="mb-2"><strong>Email:</strong> {{ Auth::user()->email ?? 'N/A' }}</p>
                <p class="mb-2"><strong>Role:</strong> Administrator</p>
                <p class="mb-0"><strong>Tanggal Login:</strong> {{ date('d M Y H:i') }}</p>
                @else
                <p class="text-muted">Silakan login terlebih dahulu</p>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .small-box {
        position: relative;
        display: block;
        margin-bottom: 20px;
        border-radius: 10px;
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    }
    .small-box .inner {
        padding: 20px;
    }
    .small-box .small-box-icon {
        position: absolute;
        top: -10px;
        right: 10px;
        z-index: 0;
        font-size: 90px;
        opacity: .15;
    }
    .small-box .small-box-footer {
        position: relative;
        text-align: center;
        padding: 10px 0;
        display: block;
        z-index: 10;
        text-decoration: none;
        border-radius: 0 0 10px 10px;
    }
</style>
@endpush