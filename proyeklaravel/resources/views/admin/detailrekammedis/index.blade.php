@extends('layout.admin')

@section('title', 'Detail Rekam Medis | RSHP Unair')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-capsule"></i> Detail Tindakan/Terapi</h3>
    <a href="{{ route('detailrekammedis.create') }}" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg"></i> Tambah Detail
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
        @if($detailRekamMedis->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th width="12%">Tanggal</th>
                        <th width="15%">Nama Hewan</th>
                        <th width="10%">Kode</th>
                        <th width="15%">Kategori</th>
                        <th width="8%">Tipe</th>
                        <th width="20%">Deskripsi</th>
                        <th width="10%">Detail</th>
                        <th width="5%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($detailRekamMedis as $index => $detail)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">
                            @if($detail->tanggal_rekam_medis)
                                {{ \Carbon\Carbon::parse($detail->tanggal_rekam_medis)->format('d/m/Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <strong>{{ $detail->nama_pet }}</strong>
                            <br>
                            <small class="text-muted">{{ $detail->nama_pemilik }}</small>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-secondary">{{ $detail->kode }}</span>
                        </td>
                        <td>{{ $detail->nama_kategori }}</td>
                        <td class="text-center">
                            @if($detail->nama_kategori_klinis == 'Terapi')
                                <span class="badge bg-primary">Terapi</span>
                            @else
                                <span class="badge bg-info">Tindakan</span>
                            @endif
                        </td>
                        <td>
                            <small>{{ Str::limit($detail->deskripsi_tindakan_terapi, 50) }}</small>
                        </td>
                        <td>
                            @if($detail->detail)
                                <small class="text-muted">{{ Str::limit($detail->detail, 40) }}</small>
                            @else
                                <small class="text-muted fst-italic">-</small>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('detailrekammedis.edit', $detail->iddetail_rekam_medis) }}" 
                                   class="btn btn-warning" 
                                   title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-danger" 
                                        onclick="confirmDelete('{{ $detail->iddetail_rekam_medis }}', '{{ $detail->kode }}')"
                                        title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            
                            <!-- Form Delete (Hidden) -->
                            <form id="delete-form-{{ $detail->iddetail_rekam_medis }}" 
                                  action="{{ route('detailrekammedis.destroy', $detail->iddetail_rekam_medis) }}" 
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
            <p class="text-muted mt-3">Belum ada detail tindakan/terapi</p>
            <a href="{{ route('detailrekammedis.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Tambah Data Pertama
            </a>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(id, kode) {
    if (confirm(`Yakin ingin menghapus detail tindakan "${kode}"?\n\nPeringatan: Data tidak dapat dikembalikan!`)) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush

@endsection