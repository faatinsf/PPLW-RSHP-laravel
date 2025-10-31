@extends('layout.admin')

@section('title', 'Kode Tindakan Terapi | RSHP Unair')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-capsule"></i> Kode Tindakan Terapi</h3>
    <button class="btn btn-primary shadow-sm"><i class="bi bi-plus-lg"></i> Tambah Tindakan</button>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>Kode</th>
                    <th>Nama Tindakan</th>
                    <th>Kategori</th>
                    <th>Tarif</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">TDK001</td>
                    <td>Vaksinasi Rabies</td>
                    <td>Tindakan</td>
                    <td>Rp 50.000</td>
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
