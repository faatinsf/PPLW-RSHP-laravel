@extends('layout.admin')

@section('title', 'Data Role User | RSHP Unair')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-person-gear"></i> Data Role User</h3>
    <button class="btn btn-primary shadow-sm"><i class="bi bi-plus-lg"></i> Tambah Role User</button>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>ID</th>
                    <th>Nama User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roleUsers as $ru)
                    <tr>
                        <td class="text-center">{{ $ru->idrole_user }}</td>
                        <td>{{ $ru->user->name ?? '-' }}</td>
                        <td>{{ $ru->user->email ?? '-' }}</td>
                        <td>{{ $ru->role->nama_role ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge bg-{{ $ru->status == 'aktif' ? 'success' : 'secondary' }}">
                                {{ ucfirst($ru->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">Tidak ada data Role User</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
