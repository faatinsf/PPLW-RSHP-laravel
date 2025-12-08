@extends('layout.admin')

@section('title', 'Kode Tindakan Terapi | RSHP Unair')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-file-medical"></i> Kode Tindakan Terapi</h3>
    <a href="{{ route('kodetindakanterapi.create') }}" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg"></i> Tambah Kode Tindakan
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        @if($kodeTindakan->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th width="8%">Kode</th>
                        <th width="40%">Deskripsi</th>
                        <th width="17%">Kategori</th>
                        <th width="15%">Kategori Klinis</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kodeTindakan as $index => $row)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">
                            <span class="badge bg-info text-dark">{{ $row->kode }}</span>
                        </td>
                        <td>{{ $row->deskripsi_tindakan_terapi }}</td>
                        <td>{{ $row->nama_kategori ?? '-' }}</td>
                        <td class="text-center">
                            @if($row->nama_kategori_klinis)
                                <span class="badge bg-success">{{ $row->nama_kategori_klinis }}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('kodetindakanterapi.edit', $row->idkode_tindakan_terapi) }}" 
                               class="btn btn-sm btn-warning" 
                               title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('kodetindakanterapi.destroy', $row->idkode_tindakan_terapi) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-sm btn-danger" 
                                        title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
            <p class="text-muted mt-3">Belum ada data kode tindakan/terapi</p>
            <a href="{{ route('kodetindakanterapi.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Tambah Data Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection