@extends('layout.dokter')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid">

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Profile Header -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body text-center py-5">
            @if(isset($dokter->foto) && $dokter->foto)
                <img src="{{ Storage::url($dokter->foto) }}" 
                     alt="Profile Photo" 
                     class="rounded-circle mb-3"
                     style="width: 120px; height: 120px; object-fit: cover;">
            @else
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                     style="width: 120px; height: 120px; background: linear-gradient(135deg, #0077b6 0%, #023e8a 100%);">
                    <span class="text-white" style="font-size: 3rem; font-weight: 600;">
                        {{ strtoupper(substr($dokter->nama ?? 'D', 0, 1)) }}
                    </span>
                </div>
            @endif
            <h2 class="mb-1">{{ $dokter->nama ?? 'Dokter' }}</h2>
            <p class="text-muted mb-3">Dokter Hewan</p>
            <span class="badge bg-success">
                <i class="bi bi-check-circle me-1"></i> Akun Aktif
            </span>
        </div>
    </div>

    <!-- Personal Information -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="bi bi-person-circle me-2 text-primary"></i>
                Informasi Pribadi
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('dokter.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nama Lengkap *</label>
                        <input type="text" 
                               class="form-control @error('nama') is-invalid @enderror" 
                               name="nama" 
                               value="{{ old('nama', $dokter->nama ?? '') }}" 
                               readonly 
                               id="input-nama">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Email *</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email', $dokter->email ?? '') }}" 
                                   readonly 
                                   id="input-email">
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">No. Handphone</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-phone"></i></span>
                            <input type="text" 
                                   class="form-control @error('no_hp') is-invalid @enderror" 
                                   name="no_hp" 
                                   value="{{ old('no_hp', $dokter->no_hp ?? '') }}" 
                                   readonly 
                                   id="input-no_hp"
                                   placeholder="08xxxxxxxxxx">
                        </div>
                        @error('no_hp')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Spesialisasi</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                            <input type="text" 
                                   class="form-control @error('spesialisasi') is-invalid @enderror" 
                                   name="spesialisasi" 
                                   value="{{ old('spesialisasi', $dokter->spesialisasi ?? '') }}" 
                                   readonly 
                                   id="input-spesialisasi"
                                   placeholder="Contoh: Bedah, Penyakit Dalam">
                        </div>
                        @error('spesialisasi')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">No. SIP</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                            <input type="text" 
                                   class="form-control @error('no_sip') is-invalid @enderror" 
                                   name="no_sip" 
                                   value="{{ old('no_sip', $dokter->no_sip ?? '') }}" 
                                   readonly 
                                   id="input-no_sip"
                                   placeholder="Nomor Surat Izin Praktek">
                        </div>
                        @error('no_sip')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Foto Profile</label>
                        <div class="input-group">
                            <input type="file" 
                                   class="form-control @error('foto') is-invalid @enderror" 
                                   name="foto" 
                                   id="input-foto"
                                   accept="image/jpeg,image/png,image/jpg"
                                   disabled>
                        </div>
                        <small class="text-muted">Format: JPG, JPEG, PNG. Max: 2MB</small>
                        @error('foto')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Alamat Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  name="alamat" 
                                  rows="3" 
                                  readonly 
                                  id="input-alamat"
                                  placeholder="Masukkan alamat lengkap">{{ old('alamat', $dokter->alamat ?? '') }}</textarea>
                    </div>
                    @error('alamat')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-none" id="edit-buttons">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                    </button>
                    <button type="button" class="btn btn-secondary" id="cancelEdit">
                        <i class="bi bi-x-lg me-1"></i> Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="bi bi-bar-chart me-2 text-success"></i>
                Statistik
            </h5>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-4 mb-3">
                    <div class="p-3 bg-light rounded">
                        <i class="bi bi-people-fill fa-2x text-primary mb-2" style="font-size: 2rem;"></i>
                        <h3 class="mb-1">{{ $stats['total_pasien'] ?? 0 }}</h3>
                        <small class="text-muted">Total Pasien</small>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="p-3 bg-light rounded">
                        <i class="bi bi-file-medical-fill fa-2x text-success mb-2" style="font-size: 2rem;"></i>
                        <h3 class="mb-1">{{ $stats['total_rekam_medis'] ?? 0 }}</h3>
                        <small class="text-muted">Total Rekam Medis</small>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="p-3 bg-light rounded">
                        <i class="bi bi-calendar-check-fill fa-2x text-warning mb-2" style="font-size: 2rem;"></i>
                        <h3 class="mb-1">{{ $stats['rekam_medis_bulan_ini'] ?? 0 }}</h3>
                        <small class="text-muted">Rekam Medis Bulan Ini</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Settings -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="bi bi-gear me-2 text-secondary"></i>
                Pengaturan Akun
            </h5>
        </div>
        <div class="card-body">
            <div class="d-grid gap-2 d-md-flex">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    <i class="bi bi-key me-2"></i> Ubah Password
                </button>
                <button class="btn btn-outline-primary" id="editProfileBtn">
                    <i class="bi bi-pencil me-2"></i> Edit Profil
                </button>
                @if(isset($dokter->foto) && $dokter->foto)
                <form action="{{ route('dokter.profile.photo.delete') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="btn btn-outline-danger" 
                            onclick="return confirm('Yakin ingin menghapus foto?')">
                        <i class="bi bi-trash me-2"></i> Hapus Foto
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('dokter.profile.password') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-key me-2"></i> Ubah Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Password Saat Ini *</label>
                        <input type="password" 
                               class="form-control @error('current_password') is-invalid @enderror" 
                               name="current_password" 
                               placeholder="Masukkan password saat ini"
                               required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru *</label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               name="password" 
                               placeholder="Masukkan password baru"
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Minimal 8 karakter</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password Baru *</label>
                        <input type="password" 
                               class="form-control" 
                               name="password_confirmation" 
                               placeholder="Konfirmasi password baru"
                               required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Simpan Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const editBtn = document.getElementById('editProfileBtn');
    const cancelBtn = document.getElementById('cancelEdit');
    const editButtons = document.getElementById('edit-buttons');
    const form = document.getElementById('profileForm');
    
    const inputs = [
        'input-nama',
        'input-email',
        'input-no_hp',
        'input-spesialisasi',
        'input-no_sip',
        'input-alamat',
        'input-foto'
    ];
    
    // Store original values
    let originalValues = {};
    
    editBtn.addEventListener('click', function() {
        // Store original values
        inputs.forEach(inputId => {
            const input = document.getElementById(inputId);
            if (input) {
                originalValues[inputId] = input.value;
                input.removeAttribute('readonly');
                input.removeAttribute('disabled');
            }
        });
        
        editButtons.classList.remove('d-none');
        editBtn.classList.add('d-none');
    });
    
    cancelBtn.addEventListener('click', function() {
        // Restore original values
        inputs.forEach(inputId => {
            const input = document.getElementById(inputId);
            if (input) {
                input.value = originalValues[inputId] || '';
                input.setAttribute('readonly', 'readonly');
                if (inputId === 'input-foto') {
                    input.setAttribute('disabled', 'disabled');
                    input.value = ''; // Clear file input
                }
            }
        });
        
        editButtons.classList.add('d-none');
        editBtn.classList.remove('d-none');
        
        // Clear validation errors
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        document.querySelectorAll('.invalid-feedback').forEach(el => {
            el.style.display = 'none';
        });
    });
    
    // Auto-show password modal if there are validation errors
    @if($errors->has('current_password') || $errors->has('password'))
        var passwordModal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
        passwordModal.show();
    @endif
    
    // Auto enable edit mode if there are validation errors on profile form
    @if($errors->has('nama') || $errors->has('email') || $errors->has('no_hp') || $errors->has('spesialisasi') || $errors->has('no_sip') || $errors->has('alamat') || $errors->has('foto'))
        editBtn.click();
    @endif
});
</script>
@endpush