@extends('layout.admin')

@section('title', 'Data Ras Hewan | RSHP Unair')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-paw"></i> Data Ras Hewan</h3>
    <button class="btn btn-primary shadow-sm"><i class="bi bi-plus-lg"></i> Tambah Ras Hewan</button>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>ID Ras</th>
                    <th>Nama Ras</th>
                    <th>Jenis Hewan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rasHewan as $ras)
                    <tr>
                        <td class="text-center">{{ $ras->idras_hewan }}</td>
                        <td>{{ $ras->nama_ras }}</td>
                        <td>{{ $ras->jenisHewan->nama_jenis ?? '-' }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">Tidak ada data ras hewan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
