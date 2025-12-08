@extends('layout.admin')

@section('title', 'Data Ras Hewan | RSHP Unair')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-card-list"></i> Data Ras Hewan</h3>
    <a href="{{ route('rashewan.create') }}" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg"></i> Tambah Ras
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
        @if($rasHewan->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th width="10%">No</th>
                        <th width="40%">Nama Ras</th>
                        <th width="35%">Jenis Hewan</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $currentJenis = null;
                    @endphp
                    @foreach($rasHewan as $index => $ras)
                    @if($currentJenis != $ras->nama_jenis_hewan)
                        <tr class="table-light">
                            <td colspan="4" class="fw-bold text-primary">
                                <i class="bi bi-chevron-right"></i> {{ $ras->nama_jenis_hewan }}
                            </td>
                        </tr>
                        @php
                            $currentJenis = $ras->nama_jenis_hewan;
                        @endphp
                    @endif
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="ps-4">{{ $ras->nama_ras }}</td>
                        <td>
                            <span class="badge bg-info text-dark">
                                {{ $ras->nama_jenis_hewan }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('rashewan.edit', $ras->idras_hewan) }}" 
                                   class="btn btn-warning" 
                                   title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-danger" 
                                        onclick="confirmDelete('{{ $ras->idras_hewan }}', '{{ $ras->nama_ras }}')"
                                        title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            
                            <!-- Form Delete (Hidden) -->
                            <form id="delete-form-{{ $ras->idras_hewan }}" 
                                  action="{{ route('rashewan.destroy', $ras->idras_hewan) }}" 
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
            <p class="text-muted mt-3">Belum ada data ras hewan</p>
            <a href="{{ route('rashewan.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Tambah Data Pertama
            </a>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(id, nama) {
    if (confirm(`Yakin ingin menghapus ras "${nama}"?\n\nPeringatan: Data tidak dapat dikembalikan!`)) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush

@endsection