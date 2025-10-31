@extends('layout.admin')

@section('title', 'Data Role | RSHP Unair')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-shield-lock"></i> Data Role</h3>
    <button class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg"></i> Tambah Role
    </button>
</div>

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
                        <td class="text-center">{{ $role->roleUsers->count() }}</td>
                      
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            Tidak ada data role yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
