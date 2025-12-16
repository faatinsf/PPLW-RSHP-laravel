@extends('layout.pemilik')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('breadcrumb', 'Home / Profil')

@section('content')
<div class="container-fluid">

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
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
            @if(isset($pemilik->foto) && $pemilik->foto)
                <img src="{{ Storage::url($pemilik->foto) }}" 
                     alt="Profile Photo" 
                     class="rounded-circle mb-3"
                     style="width: 120px; height: 120px; object-fit: cover;">
            @else
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                     style="width: 120px; height: 120px; background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <span class="text-white" style="font-size: 3rem; font-weight: 600;">
                        {{ strtoupper(substr($pemilik->nama ?? 'P', 0, 1)) }}
                    </span>
                </div>
            @endif
            <h2 class="mb-1">{{ $pemilik->nama }}</h2>
            <p class="text-muted mb-3">Pemilik Pet</p>
            <span class="badge bg-success">
                <i class="fas fa-check-circle me-1"></i> Akun Terverifikasi
            </span>
        </div>
    </div>

    <!-- Personal Information -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-user me-2 text-primary"></i>
                Informasi Pribadi
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('pemilik.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nama Lengkap *</label>
                        <input type="text" 
                               class="form-control @error('nama') is-invalid @enderror" 
                               name="nama" 
                               value="{{ old('nama', $pemilik->nama ?? '') }}" 
                               readonly 
                               id="input-nama">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Email *</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email', $pemilik->email ?? '') }}" 
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
                        <label class="form-label fw-bold">No. Telepon</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input type="text" 
                                   class="form-control @error('no_hp') is-invalid @enderror" 
                                   name="no_hp" 
                                   value="{{ old('no_hp', $pemilik->no_hp ?? '') }}" 
                                   readonly 
                                   id="input-no_hp"
                                   placeholder="08xxxxxxxxxx">
                        </div>
                        @error('no_hp')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">No. WhatsApp</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                            <input type="text" 
                                   class="form-control @error('no_wa') is-invalid @enderror" 
                                   name="no_wa" 
                                   value="{{ old('no_wa', $pemilik->no_wa ?? '') }}" 
                                   readonly 
                                   id="input-no_wa"
                                   placeholder="08xxxxxxxxxx">
                        </div>
                        @error('no_wa')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Alamat Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  name="alamat" 
                                  rows="3" 
                                  readonly 
                                  id="input-alamat"
                                  placeholder="Masukkan alamat lengkap">{{ old('alamat', $pemilik->alamat ?? '') }}</textarea>
                    </div>
                    @error('alamat')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
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

                <div class="d-none" id="edit-buttons">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                    <button type="button" class="btn btn-secondary" id="cancelEdit">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-chart-bar me-2 text-success"></i>
                Statistik
            </h5>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-3 mb-3">
                    <div class="p-3 bg-light rounded">
                        <i class="fas fa-paw fa-2x text-primary mb-2"></i>
                        <h3 class="mb-1">{{ $stats['total_pets'] }}</h3>
                        <small class="text-muted">Total Pet</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="p-3 bg-light rounded">
                        <i class="fas fa-file-medical fa-2x text-success mb-2"></i>
                        <h3 class="mb-1">{{ $stats['total_visits'] }}</h3>
                        <small class="text-muted">Total Kunjungan</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="p-3 bg-light rounded">
                        <i class="fas fa-calendar-check fa-2x text-warning mb-2"></i>
                        <h3 class="mb-1">{{ $stats['upcoming_appointments'] }}</h3>
                        <small class="text-muted">Jadwal Mendatang</small>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="p-3 bg-light rounded">
                        <i class="fas fa-clock fa-2x text-info mb-2"></i>
                        <h3 class="mb-1">
                            @if($stats['member_since'])
                                {{ \Carbon\Carbon::parse($stats['member_since'])->diffInYears(now()) }} Thn
                            @else
                                - 
                            @endif
                        </h3>
                        <small class="text-muted">Member Sejak</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- My Pets -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-paw me-2 text-success"></i>
                Pet yang Dimiliki
            </h5>
            <a href="{{ route('pemilik.pet') }}" class="btn btn-sm btn-outline-success">
                Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="card-body">
            @if($pets->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Pet</th>
                                <th>Jenis</th>
                                <th>Ras</th>
                                <th>Gender</th>
                                <th>Umur</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pets as $pet)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                                            @if($pet->nama_jenis_hewan == 'Anjing (Canis lupus familiaris)')
                                                <i class="fas fa-dog text-primary"></i>
                                            @elseif(str_contains($pet->nama_jenis_hewan, 'Kucing'))
                                                <i class="fas fa-cat text-primary"></i>
                                            @else
                                                <i class="fas fa-paw text-primary"></i>
                                            @endif
                                        </div>
                                        <strong>{{ $pet->nama }}</strong>
                                    </div>
                                </td>
                                <td>{{ Str::before($pet->nama_jenis_hewan, '(') }}</td>
                                <td>{{ $pet->nama_ras }}</td>
                                <td>
                                    @if($pet->jenis_kelamin == 'J')
                                        <span class="badge bg-primary">
                                            <i class="fas fa-mars me-1"></i> Jantan
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="fas fa-venus me-1"></i> Betina
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($pet->tanggal_lahir)
                                        {{ \Carbon\Carbon::parse($pet->tanggal_lahir)->age }} tahun
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-paw text-muted mb-3" style="font-size: 3rem;"></i>
                    <p class="text-muted mb-3">Belum ada pet terdaftar</p>
                    <a href="{{ route('pemilik.pet.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Tambah Pet
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Account Settings -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-cog me-2 text-secondary"></i>
                Pengaturan Akun
            </h5>
        </div>
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    <i class="fas fa-key me-2"></i> Ubah Password
                </button>
                <button class="btn btn-outline-primary" id="editProfileBtn">
                    <i class="fas fa-edit me-2"></i> Edit Profil
                </button>
                @if(isset($pemilik->foto) && $pemilik->foto)
                <form action="{{ route('pemilik.profile.photo.delete') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="btn btn-outline-danger" 
                            onclick="return confirm('Yakin ingin menghapus foto?')">
                        <i class="fas fa-trash me-2"></i> Hapus Foto
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
            <form action="{{ route('pemilik.profile.password') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-key me-2"></i> Ubah Password
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
                        <i class="fas fa-save me-1"></i> Simpan Password
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
        'input-no_wa',
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
    @if($errors->has('nama') || $errors->has('email') || $errors->has('no_hp') || $errors->has('no_wa') || $errors->has('alamat') || $errors->has('foto'))
        editBtn.click();
    @endif
});
</script>
@endpush