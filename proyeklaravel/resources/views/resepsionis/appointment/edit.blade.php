@extends('layout.resepsionis')

@section('title', 'Edit Appointment')
@section('page-title', 'Edit Appointment')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.appointment.index') }}">Appointment</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.appointment.show', $appointment->idrekam_medis) }}">#{{ $appointment->idrekam_medis }}</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>

            <!-- Form Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Appointment</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('resepsionis.appointment.update', $appointment->idrekam_medis) }}" method="POST" id="appointmentForm">
                        @csrf
                        @method('PUT')

                        <!-- Alert Info -->
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Perhatian:</strong> Perubahan appointment hanya untuk reschedule atau update keluhan. Untuk hasil pemeriksaan, dokter yang mengupdate.
                        </div>

                        <!-- Pilih Hewan -->
                        <h6 class="mb-3 text-warning"><i class="fas fa-paw me-2"></i>Data Hewan & Pemilik</h6>

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
                                            {{ old('idpet', $appointment->idpet) == $pet->idpet ? 'selected' : '' }}>
                                        {{ $pet->nama_pet }} - {{ $pet->nama_jenis_hewan }} ({{ $pet->nama_pemilik }})
                                    </option>
                                @endforeach
                            </select>
                            @error('idpet')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <!-- Jadwal Appointment -->
                        <h6 class="mb-3 text-warning"><i class="fas fa-calendar me-2"></i>Jadwal Appointment</h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_appointment" class="form-label">
                                    Tanggal <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control @error('tanggal_appointment') is-invalid @enderror" 
                                       id="tanggal_appointment" 
                                       name="tanggal_appointment" 
                                       value="{{ old('tanggal_appointment', date('Y-m-d', strtotime($appointment->created_at))) }}" 
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
                                       value="{{ old('jam_appointment', date('H:i', strtotime($appointment->created_at))) }}"
                                       required>
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
                                    <option value="{{ $doctor->idrole_user }}" 
                                            {{ old('dokter_pemeriksa', $appointment->dokter_pemeriksa) == $doctor->idrole_user ? 'selected' : '' }}>
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
                        <h6 class="mb-3 text-warning"><i class="fas fa-notes-medical me-2"></i>Keluhan / Anamnesa</h6>

                        <div class="mb-3">
                            <label for="anamnesa" class="form-label">
                                Keluhan Utama <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('anamnesa') is-invalid @enderror" 
                                      id="anamnesa" 
                                      name="anamnesa" 
                                      rows="4" 
                                      required>{{ old('anamnesa', $appointment->anamnesa) }}</textarea>
                            @error('anamnesa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('resepsionis.appointment.show', $appointment->idrekam_medis) }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Update Appointment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Combine date and time before submit
document.getElementById('appointmentForm')?.addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent default
    
    const tanggal = document.getElementById('tanggal_appointment').value;
    const jam = document.getElementById('jam_appointment').value;
    
    if (!tanggal || !jam) {
        alert('Tanggal dan Jam harus diisi!');
        return false;
    }
    
    // Combine datetime
    const datetime = tanggal + ' ' + jam + ':00';
    
    // Create hidden input
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'tanggal_appointment';
    hiddenInput.value = datetime;
    
    // Remove old name
    document.getElementById('tanggal_appointment').removeAttribute('name');
    
    // Add and submit
    this.appendChild(hiddenInput);
    this.submit();
});
</script>
@endpush