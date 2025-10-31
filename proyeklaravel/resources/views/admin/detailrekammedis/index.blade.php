@extends('layout.admin')

@section('title', 'Detail Rekam Medis | RSHP Unair')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-journal-text"></i> Detail Rekam Medis</h3>
    <button class="btn btn-primary shadow-sm"><i class="bi bi-plus-lg"></i> Tambah Detail</button>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>ID Detail</th>
                    <th>No. RM</th>
                    <th>Tindakan</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td>RM001</td>
                    <td>Vaksinasi Rabies</td>
                    <td>Pemberian vaksin 2ml intramuskular</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
