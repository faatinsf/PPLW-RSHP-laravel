@extends('layout.pemilik')

@section('title', 'Buat Janji Temu')
@section('page-title', 'Buat Janji Temu Baru')
@section('breadcrumb', 'Home / Janji Temu / Buat')

@section('content')
<div class="container-fluid">

    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('pemilik.appointment') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-plus me-2 text-primary"></i>
                        Informasi Janji Temu
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pemilik.appointment.store') }}" method="POST">
                        @csrf

                        <!-- Pet Selection -->
                        <div class="mb-4">
                            <label for="idpet" class="form-label fw-bold">
                                Pilih Pet <small class="text-muted">(Opsional)</small>
                            </label>
                            <select class="form-select @error('idpet') is-invalid @enderror" 
                                    id="idpet" 
                                    name="idpet">
                                <option value="">-- Belum tahu pet mana yang akan dibawa --</option>
                                @foreach($pets as $pet)
                                <option value="{{ $pet->idpet }}" {{ old('idpet') == $pet->idpet ? 'selected' : '' }}>
                                    {{ $pet->nama }} - {{ $pet->nama_ras }} ({{ $pet->nama_jenis_hewan }})
                                </option>
                                @endforeach
                            </select>
                            @error('idpet')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($pets->count() == 0)
                                <div class="alert alert-info mt-2">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Anda belum memiliki data pet. 
                                    <a href="{{ route('pemilik.pet.create') }}">Tambahkan pet</a> terlebih dahulu.
                                </div>
                            @endif
                        </div>

                        <div class="row">
                            <!-- Tanggal Appointment -->
                            <div class="col-md-6 mb-4">
                                <label for="tanggal_appointment" class="form-label fw-bold">
                                    Tanggal Kunjungan *
                                </label>
                                <input type="date" 
                                       class="form-control @error('tanggal_appointment') is-invalid @enderror" 
                                       id="tanggal_appointment" 
                                       name="tanggal_appointment" 
                                       value="{{ old('tanggal_appointment') }}"
                                       min="{{ date('Y-m-d') }}"
                                       required>
                                @error('tanggal_appointment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Waktu Appointment -->
                            <div class="col-md-6 mb-4">
                                <label for="waktu_appointment" class="form-label fw-bold">
                                    Waktu Kunjungan *
                                </label>
                                <select class="form-select @error('waktu_appointment') is-invalid @enderror" 
                                        id="waktu_appointment" 
                                        name="waktu_appointment" 
                                        required>
                                    <option value="">-- Pilih Waktu --</option>
                                    <option value="08:00:00" {{ old('waktu_appointment') == '08:00:00' ? 'selected' : '' }}>08:00</option>
                                    <option value="09:00:00" {{ old('waktu_appointment') == '09:00:00' ? 'selected' : '' }}>09:00</option>
                                    <option value="10:00:00" {{ old('waktu_appointment') == '10:00:00' ? 'selected' : '' }}>10:00</option>
                                    <option value="11:00:00" {{ old('waktu_appointment') == '11:00:00' ? 'selected' : '' }}>11:00</option>
                                    <option value="13:00:00" {{ old('waktu_appointment') == '13:00:00' ? 'selected' : '' }}>13:00</option>
                                    <option value="14:00:00" {{ old('waktu_appointment') == '14:00:00' ? 'selected' : '' }}>14:00</option>
                                    <option value="15:00:00" {{ old('waktu_appointment') == '15:00:00' ? 'selected' : '' }}>15:00</option>
                                    <option value="16:00:00" {{ old('waktu_appointment') == '16:00:00' ? 'selected' : '' }}>16:00</option>
                                </select>
                                @error('waktu_appointment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Jenis Layanan -->
                        <div class="mb-4">
                            <label for="jenis_layanan" class="form-label fw-bold">
                                Jenis Layanan *
                            </label>
                            <select class="form-select @error('jenis_layanan') is-invalid @enderror" 
                                    id="jenis_layanan" 
                                    name="jenis_layanan" 
                                    required>
                                <option value="">-- Pilih Jenis Layanan --</option>
                                @foreach($jenisLayanan as $layanan)
                                <option value="{{ $layanan }}" {{ old('jenis_layanan') == $layanan ? 'selected' : '' }}>
                                    {{ $layanan }}
                                </option>
                                @endforeach
                            </select>
                            @error('jenis_layanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Keluhan -->
                        <div class="mb-4">
                            <label for="keluhan" class="form-label fw-bold">
                                Keluhan / Catatan <small class="text-muted">(Opsional)</small>
                            </label>
                            <textarea class="form-control @error('keluhan') is-invalid @enderror" 
                                      id="keluhan" 
                                      name="keluhan" 
                                      rows="5" 
                                      placeholder="Jelaskan keluhan atau kondisi pet Anda...">{{ old('keluhan') }}</textarea>
                            @error('keluhan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Berikan informasi sebanyak mungkin untuk membantu dokter mempersiapkan pemeriksaan
                            </small>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i> Kirim Permohonan
                            </button>
                            <a href="{{ route('pemilik.appointment') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <!-- Info Card -->
            <div class="card border-0 shadow-sm bg-primary bg-opacity-10 mb-3">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Informasi Penting
                    </h6>
                    <ul class="small mb-0">
                        <li class="mb-2">Janji temu akan menunggu konfirmasi dari klinik</li>
                        <li class="mb-2">Mohon datang 10 menit sebelum waktu yang ditentukan</li>
                        <li class="mb-2">Bawa semua dokumen medis jika ada</li>
                        <li class="mb-2">Untuk kasus emergency, silakan hubungi langsung klinik</li>
                    </ul>
                </div>
            </div>

            <!-- Contact Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-phone text-success me-2"></i>
                        Hubungi Kami
                    </h6>
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Telepon</small>
                        <strong>(031) 123-4567</strong>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">WhatsApp</small>
                        <strong>0812-3456-7890</strong>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Email</small>
                        <strong>info@petklinik.com</strong>
                    </div>
                    <div>
                        <small class="text-muted d-block mb-1">Jam Operasional</small>
                        <strong>Senin - Sabtu: 08:00 - 17:00</strong><br>
                        <strong>Minggu: Emergency Only</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Validate weekend selection
    document.getElementById('tanggal_appointment').addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const dayOfWeek = selectedDate.getDay();
        
        if (dayOfWeek === 0) { // Sunday
            if (!confirm('Klinik hanya melayani emergency pada hari Minggu. Lanjutkan?')) {
                this.value = '';
            }
        }
    });

    // Show service description on selection
    document.getElementById('jenis_layanan').addEventListener('change', function() {
        const serviceDescriptions = {
            'Pemeriksaan Umum': 'Pemeriksaan kesehatan rutin dan konsultasi umum',
            'Vaksinasi': 'Pemberian vaksin untuk pencegahan penyakit',
            'Grooming': 'Perawatan bulu, mandi, dan grooming medis',
            'Bedah / Operasi': 'Tindakan operasi atau bedah (perlu konsultasi terlebih dahulu)',
            'Konsultasi': 'Konsultasi dengan dokter hewan',
            'Pemeriksaan Laboratorium': 'Pemeriksaan darah, urin, atau tes lab lainnya',
            'Rawat Inap': 'Perawatan intensif dengan menginap di klinik',
            'Emergency': 'Penanganan darurat (hubungi langsung untuk lebih cepat)',
            'Lainnya': 'Layanan lainnya, jelaskan di kolom keluhan'
        };
        
        const selectedService = this.value;
        if (selectedService && serviceDescriptions[selectedService]) {
            // You can show a tooltip or alert here if needed
            console.log(serviceDescriptions[selectedService]);
        }
    });
</script>
@endpush