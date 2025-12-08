@extends('layout.admin')

@section('title', 'Data Hewan Peliharaan | RSHP Unair')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-heart-pulse"></i> Data Hewan Peliharaan</h3>
    <a href="{{ route('pet.create') }}" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg"></i> Tambah Hewan
    </a>
</div>

<!-- Alert Success -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Alert Error -->
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        @if($pets->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Nama Hewan</th>
                        <th width="10%">Jenis Kelamin</th>
                        <th width="12%">Tanggal Lahir</th>
                        <th width="12%">Warna/Tanda</th>
                        <th width="15%">Ras</th>
                        <th width="18%">Pemilik</th>
                        <th width="13%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pets as $index => $pet)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td><strong>{{ $pet->nama }}</strong></td>
                        <td class="text-center">
                            @if($pet->jenis_kelamin == 'J')
                                <span class="badge bg-primary">
                                    <i class="bi bi-gender-male"></i> Jantan
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="bi bi-gender-female"></i> Betina
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($pet->tanggal_lahir)->format('d/m/Y') }}
                            <br>
                            <small class="text-muted">
                                ({{ \Carbon\Carbon::parse($pet->tanggal_lahir)->age }} tahun)
                            </small>
                        </td>
                        <td>{{ $pet->warna_tanda }}</td>
                        <td>
                            {{ $pet->nama_ras }}
                            <br>
                            <small class="text-muted">{{ $pet->nama_jenis_hewan }}</small>
                        </td>
                        <td>
                            {{ $pet->nama_pemilik }}
                            <br>
                            <small class="text-muted">
                                <i class="bi bi-envelope"></i> {{ $pet->email_pemilik }}
                            </small>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('pet.edit', $pet->idpet) }}" 
                                   class="btn btn-warning" 
                                   title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-danger" 
                                        onclick="confirmDelete('{{ $pet->idpet }}', '{{ $pet->nama }}')"
                                        title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            
                            <!-- Form Delete (Hidden) -->
                            <form id="delete-form-{{ $pet->idpet }}" 
                                  action="{{ route('pet.destroy', $pet->idpet) }}" 
                                  method="POST" 
                                  class="d-none">
                                @csrf
                                @method('DELETE')
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
            <p class="text-muted mt-3">Belum ada data hewan peliharaan</p>
            <a href="{{ route('pet.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Tambah Data Pertama
            </a>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(id, nama) {
    if (confirm(`Yakin ingin menghapus data hewan "${nama}"?\n\nPeringatan: Data tidak dapat dikembalikan!`)) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush

@endsection