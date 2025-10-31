@extends('layout.admin')

@section('title', 'Rekam Medis | RSHP Unair')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-file-medical"></i> Rekam Medis</h3>
    <button class="btn btn-primary shadow-sm"><i class="bi bi-plus-lg"></i> Tambah Rekam Medis</button>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>No. RM</th>
                    <th>Tanggal</th>
                    <th>Nama Hewan</th>
                    <th>Dokter</th>
                    <th>Diagnosa</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">RM001</td>
                    <td>2025-10-30</td>
                    <td>Miko</td>
                    <td>Drh. Sinta</td>
                    <td>Flu Kucing</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-info"><i class="bi bi-eye"></i></button>
                        <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
    