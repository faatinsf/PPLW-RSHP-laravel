@extends('layout.admin')

@section('title', 'Data Rekam Medis | RSHP Unair')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-clipboard-pulse"></i> Data Rekam Medis</h3>
    <button class="btn btn-primary shadow-sm"><i class="bi bi-plus-lg"></i> Tambah Rekam Medis</button>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>ID Rekam</th>
                    <th>Nama Hewan</th>
                    <th>Pemilik</th>
                    <th>Dokter Pemeriksa</th>
                    <th>Tanggal Periksa</th>
                    <th>Diagnosa</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rekamMedis as $rm)
                    <tr>
                        <td class="text-center">{{ $rm->idrekam_medis }}</td>
                        <td>{{ $rm->pet->nama_pet ?? '-' }}</td>
                        <td>{{ $rm->pet->pemilik->nama_pemilik ?? '-' }}</td>
                        <td>{{ $rm->dokter->user->name ?? '-' }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($rm->tanggal_periksa)->format('d M Y') }}</td>
                        <td>{{ $rm->diagnosa ?? '-' }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-3">Tidak ada data rekam medis</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
