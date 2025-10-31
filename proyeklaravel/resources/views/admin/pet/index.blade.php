@extends('layout.admin')

@section('title', 'Data Hewan Peliharaan | RSHP Unair')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-bandaid"></i> Data Hewan Peliharaan</h3>
    <button class="btn btn-primary shadow-sm"><i class="bi bi-plus-lg"></i> Tambah Hewan</button>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>ID Hewan</th>
                    <th>Nama Hewan</th>
                    <th>Jenis Kelamin</th>
                    <th>Ras Hewan</th>
                    <th>Pemilik</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pets as $pet)
                    <tr>
                        <td class="text-center">{{ $pet->idpet }}</td>
                        <td>{{ $pet->nama_hewan }}</td>
                        <td>{{ ucfirst($pet->jenis_kelamin) }}</td>
                        <td>{{ $pet->rasHewan->nama_ras ?? '-' }}</td>
                        <td>{{ $pet->pemilik->nama_pemilik ?? '-' }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">Tidak ada data hewan peliharaan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
