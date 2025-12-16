@extends('layout.pemilik')

@section('title', 'Pet Saya')
@section('page-title', 'Pet Saya')
@section('breadcrumb', 'Home / Pet Saya')

@section('content')
<div class="container-fluid">

    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-paw fa-3x text-primary mb-3"></i>
                    <h2 class="mb-1">{{ $stats['total_pets'] }}</h2>
                    <p class="text-muted mb-0">Total Pet</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-heart fa-3x text-success mb-3"></i>
                    <h2 class="mb-1">{{ $stats['healthy_pets'] }}</h2>
                    <p class="text-muted mb-0">Pet Sehat</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-syringe fa-3x text-warning mb-3"></i>
                    <h2 class="mb-1">{{ $stats['needs_vaccination'] }}</h2>
                    <p class="text-muted mb-0">Perlu Vaksinasi</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pet Cards -->
    @if($pets->count() > 0)
    <div class="row">
        @foreach($pets as $pet)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <!-- Pet Avatar -->
                    <div class="text-center mb-4">
                        @php
                            $gradients = [
                                'anjing' => 'linear-gradient(135deg, #10b981 0%, #059669 100%)',
                                'kucing' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                                'default' => 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)'
                            ];
                            
                            $jenisLower = strtolower($pet->nama_jenis_hewan);
                            if (str_contains($jenisLower, 'anjing')) {
                                $gradient = $gradients['anjing'];
                                $icon = 'fa-dog';
                            } elseif (str_contains($jenisLower, 'kucing')) {
                                $gradient = $gradients['kucing'];
                                $icon = 'fa-cat';
                            } else {
                                $gradient = $gradients['default'];
                                $icon = 'fa-paw';
                            }
                        @endphp
                        
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 120px; height: 120px; background: {{ $gradient }};">
                            <i class="fas {{ $icon }} text-white" style="font-size: 4rem;"></i>
                        </div>
                        <h3 class="mb-1">{{ $pet->nama }}</h3>
                        <p class="text-muted mb-0">{{ $pet->nama_ras }}</p>
                    </div>

                    <!-- Info -->
                    <div class="border-top pt-3">
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <div class="text-center p-2 bg-light rounded">
                                    <small class="text-muted d-block">Umur</small>
                                    <strong>{{ $pet->age_display }}</strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-2 bg-light rounded">
                                    <small class="text-muted d-block">Kunjungan</small>
                                    <strong>{{ $pet->total_visits }}x</strong>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Jenis Kelamin</small>
                            <div class="d-flex align-items-center">
                                @if($pet->jenis_kelamin == 'J')
                                    <i class="fas fa-mars text-primary me-2"></i>
                                    <strong>Jantan</strong>
                                @else
                                    <i class="fas fa-venus text-danger me-2"></i>
                                    <strong>Betina</strong>
                                @endif
                            </div>
                        </div>

                        @if($pet->warna_tanda)
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Warna</small>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-palette text-info me-2"></i>
                                <strong>{{ $pet->warna_tanda }}</strong>
                            </div>
                        </div>
                        @endif

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Status Kesehatan</small>
                            @if($pet->health_status == 'healthy')
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i> Sehat
                                </span>
                            @elseif($pet->health_status == 'observation')
                                <span class="badge bg-warning">
                                    <i class="fas fa-exclamation-triangle me-1"></i> Observasi
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="fas fa-question-circle me-1"></i> Belum Ada Data
                                </span>
                            @endif
                        </div>

                        @if($pet->last_vaccination)
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Vaksinasi Terakhir</small>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-syringe text-success me-2"></i>
                                <strong>{{ \Carbon\Carbon::parse($pet->last_vaccination->created_at)->isoFormat('D MMM YYYY') }}</strong>
                            </div>
                            <small class="text-muted">{{ $pet->last_vaccination->deskripsi_tindakan_terapi }}</small>
                        </div>
                        @else
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Vaksinasi Terakhir</small>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                <strong>Belum divaksinasi</strong>
                            </div>
                        </div>
                        @endif

                        @if($pet->needs_vaccination)
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Vaksinasi Berikutnya</small>
                            <div class="alert alert-warning py-2 mb-0">
                                <small>
                                    <i class="fas fa-info-circle me-1"></i>
                                    Perlu dijadwalkan vaksinasi
                                </small>
                            </div>
                        </div>
                        @elseif($pet->last_vaccination)
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Vaksinasi Berikutnya</small>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-check text-info me-2"></i>
                                <strong>{{ \Carbon\Carbon::parse($pet->last_vaccination->created_at)->addYear()->isoFormat('D MMM YYYY') }}</strong>
                            </div>
                        </div>
                        @endif

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Total Kunjungan</small>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-medical text-primary me-2"></i>
                                <strong>{{ $pet->total_visits }} kunjungan</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-grid gap-2">
                        <a href="{{ route('pemilik.medical-record') }}?pet={{ $pet->idpet }}" 
                           class="btn btn-{{ $pet->health_status == 'healthy' ? 'success' : ($pet->health_status == 'observation' ? 'warning' : 'primary') }}">
                            <i class="fas fa-file-medical me-2"></i> Lihat Rekam Medis
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <i class="fas fa-paw text-muted mb-3" style="font-size: 4rem;"></i>
            <h4 class="text-muted mb-3">Belum Ada Pet Terdaftar</h4>
            <p class="text-muted mb-4">Tambahkan pet Anda untuk mulai menggunakan layanan kami</p>
            <a href="{{ route('pemilik.pet.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus me-2"></i> Tambah Pet Baru
            </a>
        </div>
    </div>
    @endif

    <!-- Info Card -->
    <div class="card border-info mt-4">
        <div class="card-body bg-info bg-opacity-10">
            <h5 class="mb-3">
                <i class="fas fa-lightbulb me-2 text-info"></i>
                Tips Perawatan Pet
            </h5>
            <div class="row">
                <div class="col-md-6">
                    <ul class="mb-0">
                        <li class="mb-2">Pastikan pet mendapat makanan bergizi seimbang</li>
                        <li class="mb-2">Sediakan air bersih setiap hari</li>
                        <li class="mb-2">Lakukan vaksinasi secara rutin</li>
                        <li class="mb-2">Jaga kebersihan kandang dan lingkungan</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="mb-0">
                        <li class="mb-2">Berikan waktu bermain dan olahraga</li>
                        <li class="mb-2">Periksa kesehatan rutin ke dokter hewan</li>
                        <li class="mb-2">Perhatikan perubahan perilaku yang tidak biasa</li>
                        <li class="mb-2">Berikan kasih sayang dan perhatian</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection