@extends('layout.admin')

@section('title', 'Data Pemilik | RSHP Unair')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary"><i class="bi bi-people"></i> Data Pemilik</h3>
    <a href="{{ route('pemilik.create') }}" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg"></i> Tambah Pemilik
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
        @if($pemilik->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">Nama User</th>
                        <th width="20%">Email</th>
                        <th width="15%">No. WhatsApp</th>
                        <th width="30%">Alamat</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pemilik as $index => $data)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $data->nama_user }}</td>
                        <td>{{ $data->email }}</td>
                        <td>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $data->no_wa) }}" 
                               target="_blank" 
                               class="text-success text-decoration-none">
                                <i class="bi bi-whatsapp"></i> {{ $data->no_wa }}
                            </a>
                        </td>
                        <td>{{ $data->alamat }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('pemilik.edit', $data->idpemilik) }}" 
                                   class="btn btn-warning" 
                                   title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-danger" 
                                        onclick="confirmDelete('{{ $data->idpemilik }}', '{{ $data->nama_user }}')"
                                        title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            
                            <!-- Form Delete (Hidden) -->
                            <form id="delete-form-{{ $data->idpemilik }}" 
                                  action="{{ route('pemilik.destroy', $data->idpemilik) }}" 
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
            <p class="text-muted mt-3">Belum ada data pemilik</p>
            <a href="{{ route('pemilik.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Tambah Data Pertama
            </a>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(id, nama) {
    if (confirm(`Yakin ingin menghapus data pemilik "${nama}"?\n\nPeringatan: Data tidak dapat dikembalikan!`)) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush

@endsection