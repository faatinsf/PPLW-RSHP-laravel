@extends('layout.admin')

@section('title', 'Kategori Klinis | RSHP Unair')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-clipboard2-pulse"></i> Kategori Klinis</h3>
    <a href="{{ route('kategoriklinis.create') }}" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg"></i> Tambah Kategori Klinis
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
        @if($kategoriKlinis->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th width="10%">No</th>
                        <th width="30%">Nama Kategori Klinis</th>
                        <th width="40%">Kode Tindakan Terapi</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kategoriKlinis as $index => $data)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="fw-semibold">{{ $data->nama_kategori_klinis }}</td>
                        <td>
                            @if($data->kode_list)
                                @php
                                    $kodeArray = explode('||', $data->kode_list);
                                @endphp
                                <ul class="list-unstyled mb-0">
                                    @foreach($kodeArray as $kode)
                                        <li class="mb-1">
                                            <span class="badge bg-info text-dark">{{ explode(' - ', $kode)[0] }}</span> 
                                            {{ explode(' - ', $kode)[1] ?? '' }}
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <em class="text-muted">Tidak ada kode tindakan</em>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('kategoriklinis.edit', $data->idkategori_klinis) }}" 
                               class="btn btn-sm btn-warning" 
                               title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('kategoriklinis.destroy', $data->idkategori_klinis) }}" 
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
            <p class="text-muted mt-3">Belum ada data kategori klinis</p>
            <a href="{{ route('kategoriklinis.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Tambah Data Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
