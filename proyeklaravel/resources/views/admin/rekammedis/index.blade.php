@extends('layout.admin')

@section('title', 'Data Rekam Medis | RSHP Unair')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-clipboard-pulse"></i> Data Rekam Medis</h3>
    <a href="{{ route('rekammedis.create') }}" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg"></i> Tambah Rekam Medis
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
        @if($rekamMedis->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Nama Hewan</th>
                        <th width="15%">Pemilik</th>
                        <th width="15%">Dokter</th>
                        <th width="10%">Tanggal</th>
                        <th width="25%">Diagnosa</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekamMedis as $index => $rm)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $rm->nama_pet }}</strong>
                            <br>
                            <small class="text-muted">{{ $rm->nama_ras }}</small>
                        </td>
                        <td>
                            {{ $rm->nama_pemilik }}
                            <br>
                            <small class="text-muted">
                                <i class="bi bi-envelope"></i> {{ $rm->email_pemilik }}
                            </small>
                        </td>
                        <td>
                            <i class="bi bi-person-badge"></i> {{ $rm->nama_dokter }}
                        </td>
                        <td class="text-center">
                            @if($rm->created_at)
                                {{ \Carbon\Carbon::parse($rm->created_at)->format('d/m/Y') }}
                                <br>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($rm->created_at)->format('H:i') }}
                                </small>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <small>{{ Str::limit($rm->diagnosa, 80) }}</small>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('rekammedis.show', $rm->idrekam_medis) }}" 
                                   class="btn btn-info" 
                                   title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('rekammedis.edit', $rm->idrekam_medis) }}" 
                                   class="btn btn-warning" 
                                   title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-danger" 
                                        onclick="confirmDelete('{{ $rm->idrekam_medis }}', '{{ $rm->nama_pet }}')"
                                        title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            
                            <!-- Form Delete (Hidden) -->
                            <form id="delete-form-{{ $rm->idrekam_medis }}" 
                                  action="{{ route('rekammedis.destroy', $rm->idrekam_medis) }}" 
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
            <p class="text-muted mt-3">Belum ada data rekam medis</p>
            <a href="{{ route('rekammedis.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Tambah Data Pertama
            </a>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(id, namaPet) {
    if (confirm(`Yakin ingin menghapus rekam medis untuk "${namaPet}"?\n\nPeringatan: Data tidak dapat dikembalikan!`)) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush

@endsection