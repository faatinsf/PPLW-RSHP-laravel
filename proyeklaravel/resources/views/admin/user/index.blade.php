@extends('layout.admin')

@section('title', 'Data User | RSHP Unair')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-people"></i> Data User</h3>
    <button class="btn btn-primary shadow-sm">
        
      <a href="{{ route('user.create') }}" class="btn btn-primary shadow-sm" title="Tambah User">
        <i class="bi bi-plus-lg"></i> Tambah User
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $user)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ($user->roleUser->isNotEmpty())
                                @foreach ($user->roleUser as $roleUser)
                                    <span class="badge bg-primary">
                                        {{ $roleUser->role->nama_role ?? 'Tidak ada role' }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-muted">Belum ada role</span>
                            @endif
                        </td>
                           <td class="text-center">
                            <div class="btn-group" user="group">
                                <a href="{{ route('user.edit', $user->iduser) }}" 
                                   class="btn btn-sm btn-warning" 
                                   title="Edit User">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('user.destroy', $user->iduser) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus user {{ $user->nama_user }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger" 
                                            title="Hapus User">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            Tidak ada data user yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
