@extends('layout.admin')

@section('title', 'Data Hewan | RSHP Unair')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-bug"></i> Data Hewan</h3>
    <button class="btn btn-primary shadow-sm"><i class="bi bi-plus-lg"></i> Tambah Hewan</button>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>ID Hewan</th>
                    <th>Nama Hewan</th>
                    <th>Jenis</th>
                    <th>Ras</th>
                    <th>Pemilik</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td>Miko</td>
                    <td>Kucing</td>
                    <td>Persia</td>
                    <td>Budi Santoso</td>
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
