@extends('layout.admin')

@section('title', 'Data Kode Tindakan Terapi')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Data Kode Tindakan Terapi</h2>

   

    {{-- Tabel Data --}}
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-primary text-center">
            <tr>
                <th>ID</th>
                <th>Kode</th>
                <th>Deskripsi</th>
                <th>Kategori</th>
                <th>Kategori Klinis</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kodeTindakan as $row)
                <tr>
                    <td>{{ $row->idkode_tindakan_terapi }}</td>
                    <td>{{ $row->kode }}</td>
                    <td>{{ $row->deskripsi_tindakan_terapi }}</td>
                    <td>{{ $row->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $row->kategoriKlinis->nama_kategori_klinis ?? '-' }}</td>
                    <td>
                       
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

   
</div>
@endsection
