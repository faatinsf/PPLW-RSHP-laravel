@extends('layout.admin')

@section('title', 'Data Role | RSHP Unair')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-shield-lock"></i> Data Role</h3>
    <a href="{{ route('role.create') }}" class="btn btn-primary shadow-sm" title="Tambah Role">
        <i class="bi bi-plus-lg"></i> Tambah Role
    </a>
</div>

{{-- Alert Success/Error --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-x-circle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>#</th>
                    <th>Nama Role</th>
                    
                    <th>Jumlah User</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $index => $role)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $role->nama_role }}</td>
                       
                        <td class="text-center">
                            <span class="badge bg-info">{{ $role->jumlah_user }} User</span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('role.edit', $role->idrole) }}" 
                                   class="btn btn-sm btn-warning" 
                                   title="Edit Role">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('role.destroy', $role->idrole) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus role {{ $role->nama_role }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger" 
                                            title="Hapus Role">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-1"></i>
                            <p class="mt-2">Belum ada data role</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection