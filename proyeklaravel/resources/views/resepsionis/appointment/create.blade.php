@extends('layout.resepsionis')

@section('title', 'Buat Appointment Baru')
@section('page-title', 'Buat Appointment Baru')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.appointment.index') }}">Appointment</a></li>
                    <li class="breadcrumb-item active">Buat Appointment</li>
                </ol>
            </nav>

            <!-- Form Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-calendar-plus me-2"></i>Form Appointment Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('resepsionis.appointment.store') }}" method="POST" id="appointmentForm">
                        @csrf

                        <!-- Info Box -->
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Pastikan data hewan sudah terdaftar. Jika belum, silakan 
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#quickRegisterModal">
                                <i class="fas fa-user-plus me-1"></i>Registrasi Cepat
                            </button>
                        </div>

                        <!-- Pilih Hewan -->
                        <h6 class="mb-3 text-info"><i class="fas fa-paw me-2"></i>Data Hewan & Pemilik</h6>

                        <div class="mb-3">
                            <label for="idpet" class="form-label">
                                Pilih Hewan <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('idpet') is-invalid @enderror" 
                                    id="idpet" 
                                    name="idpet" 
                                    required>
                                <option value="">-- Pilih Hewan --</option>
                                @foreach($pets as $pet)
                                    <option value="{{ $pet->idpet }}" 
                                            data-owner="{{ $pet->nama_pemilik }}"
                                            data-phone="{{ $pet->no_wa }}"
                                            data-jenis="{{ $pet->nama_jenis_hewan }}"
                                            data-ras="{{ $pet->nama_ras }}"
                                            {{ old('idpet') == $pet->idpet ? 'selected' : '' }}>
                                        {{ $pet->nama_pet }} - {{ $pet->nama_jenis_hewan }} ({{ $pet->nama_pemilik }})
                                    </option>
                                @endforeach
                            </select>
                            @error('idpet')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Pet Info Display -->
                        <div id="petInfo" class="card bg-light mb-4" style="display: none;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-primary"><i class="fas fa-paw me-2"></i>Info Hewan</h6>
                                        <p class="mb-1"><strong>Jenis:</strong> <span id="info_jenis">-</span></p>
                                        <p class="mb-0"><strong>Ras:</strong> <span id="info_ras">-</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-success"><i class="fas fa-user me-2"></i>Info Pemilik</h6>
                                        <p class="mb-1"><strong>Nama:</strong> <span id="info_owner">-</span></p>
                                        <p class="mb-0"><strong>No. WA:</strong> <span id="info_phone">-</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Jadwal Appointment -->
                        <h6 class="mb-3 text-info"><i class="fas fa-calendar me-2"></i>Jadwal Appointment</h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_appointment" class="form-label">
                                    Tanggal <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control @error('tanggal_appointment') is-invalid @enderror" 
                                       id="tanggal_appointment" 
                                       name="tanggal_appointment" 
                                       value="{{ old('tanggal_appointment', date('Y-m-d')) }}" 
                                       min="{{ date('Y-m-d') }}"
                                       required>
                                @error('tanggal_appointment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="jam_appointment" class="form-label">
                                    Jam <span class="text-danger">*</span>
                                </label>
                                <input type="time" 
                                       class="form-control" 
                                       id="jam_appointment"
                                       name="jam_appointment"
                                       value="{{ old('jam_appointment', date('H:i')) }}"
                                       required>
                                <small class="text-muted">Jam operasional: 08:00 - 17:00</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="dokter_pemeriksa" class="form-label">
                                Dokter Pemeriksa <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('dokter_pemeriksa') is-invalid @enderror" 
                                    id="dokter_pemeriksa" 
                                    name="dokter_pemeriksa" 
                                    required>
                                <option value="">-- Pilih Dokter --</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->idrole_user }}" {{ old('dokter_pemeriksa') == $doctor->idrole_user ? 'selected' : '' }}>
                                        drh. {{ $doctor->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('dokter_pemeriksa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <!-- Keluhan -->
                        <h6 class="mb-3 text-info"><i class="fas fa-notes-medical me-2"></i>Keluhan / Anamnesa</h6>

                        <div class="mb-3">
                            <label for="anamnesa" class="form-label">
                                Keluhan Utama <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('anamnesa') is-invalid @enderror" 
                                      id="anamnesa" 
                                      name="anamnesa" 
                                      rows="4" 
                                      placeholder="Contoh: Tidak mau makan sejak 2 hari yang lalu, terlihat lemas dan muntah-muntah"
                                      required>{{ old('anamnesa') }}</textarea>
                            @error('anamnesa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Jelaskan keluhan hewan secara detail</small>
                        </div>

                        <hr class="my-4">

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('resepsionis.appointment.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <div>
                                <button type="reset" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-redo me-2"></i>Reset
                                </button>
                                <button type="submit" class="btn btn-info">
                                    <i class="fas fa-save me-2"></i>Simpan Appointment
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Register Modal -->
@include('resepsionis.appointment.partials.quick-register-modal')

@endsection

@push('scripts')
<script>
document.getElementById('idpet')?.addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const petInfo = document.getElementById('petInfo');
    
    if (this.value) {
        document.getElementById('info_jenis').textContent = selectedOption.dataset.jenis;
        document.getElementById('info_ras').textContent = selectedOption.dataset.ras;
        document.getElementById('info_owner').textContent = selectedOption.dataset.owner;
        document.getElementById('info_phone').textContent = selectedOption.dataset.phone;
        petInfo.style.display = 'block';
    } else {
        petInfo.style.display = 'none';
    }
});

// Combine date and time before submit
document.getElementById('appointmentForm')?.addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent default submit
    
    const tanggal = document.getElementById('tanggal_appointment').value;
    const jam = document.getElementById('jam_appointment').value;
    
    if (!tanggal) {
        alert('Tanggal harus diisi!');
        document.getElementById('tanggal_appointment').focus();
        return false;
    }
    
    if (!jam) {
        alert('Jam harus diisi!');
        document.getElementById('jam_appointment').focus();
        return false;
    }
    
    // Combine datetime
    const datetime = tanggal + ' ' + jam + ':00';
    
    // Create hidden input for combined datetime
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'tanggal_appointment';
    hiddenInput.value = datetime;
    
    // Remove old date input name to avoid conflict
    document.getElementById('tanggal_appointment').removeAttribute('name');
    
    // Add hidden input
    this.appendChild(hiddenInput);
    
    // Now submit
    this.submit();
});

// Validate operating hours
document.getElementById('jam_appointment')?.addEventListener('change', function() {
    const time = this.value;
    if (!time) return;
    
    const [hours] = time.split(':');
    
    if (hours < 8 || hours >= 17) {
        alert('Jam operasional klinik: 08:00 - 17:00');
        this.value = '09:00';
    }
});
</script>
@endpush