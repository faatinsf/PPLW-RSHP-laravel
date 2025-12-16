@extends('layout.perawat')

@section('title', 'Rekam Medis')

@section('content')
<div class="page-header">
    <h1>📋 Rekam Medis</h1>
    <p class="breadcrumb">Dashboard / Rekam Medis</p>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <div class="card-header" style="margin: 0; border: none; padding: 0;">
            Daftar Rekam Medis
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('perawat.rekam-medis.create') }}" class="btn btn-primary">
                Tambah Rekam Medis
            </a>
        </div>
    </div>

    <form action="{{ route('perawat.rekam-medis.index') }}" method="GET" style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
        <input type="text" 
               name="search" 
               class="form-control" 
               placeholder="🔍 Cari pet/pemilik/diagnosa..." 
               value="{{ $search }}"
               style="flex: 1; min-width: 250px;">
        <input type="date" 
               name="tanggal" 
               class="form-control" 
               value="{{ $tanggal }}"
               style="width: 200px;">
        <button type="submit" class="btn btn-primary">Cari</button>
        @if($search || $tanggal)
            <a href="{{ route('perawat.rekam-medis.index') }}" class="btn btn-warning">Reset</a>
        @endif
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Pet</th>
                <th>Pemilik</th>
                <th>Anamnesa</th>
                <th>Diagnosa</th>
                <th>Dokter</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekamMedis as $index => $rm)
            <tr>
                <td>{{ $rekamMedis->firstItem() + $index }}</td>
                <td>{{ \Carbon\Carbon::parse($rm->created_at)->format('d/m/Y H:i') }}</td>
                <td><strong>{{ $rm->pet_nama }}</strong></td>
                <td>{{ $rm->pemilik_nama }}</td>
                <td>{{ Str::limit($rm->anamnesa, 50) }}</td>
                <td>{{ Str::limit($rm->diagnosa, 50) }}</td>
                <td>{{ $rm->dokter_nama }}</td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('perawat.rekam-medis.show', $rm->idrekam_medis) }}" class="btn btn-info btn-sm">
                            Detail
                        </a>
                        <a href="{{ route('perawat.rekam-medis.edit', $rm->idrekam_medis) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>
                        <form action="{{ route('perawat.rekam-medis.destroy', $rm->idrekam_medis) }}" 
                              method="POST" 
                              onsubmit="return confirm('Yakin ingin menghapus rekam medis ini?')"
                              style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; color: #718096; padding: 2rem;">
                    @if($search || $tanggal)
                        Tidak ada data yang sesuai dengan pencarian
                    @else
                        Belum ada data rekam medis
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($rekamMedis->hasPages())
    <div style="margin-top: 1.5rem;">
        {{ $rekamMedis->appends(['search' => $search, 'tanggal' => $tanggal])->links() }}
    </div>
    @endif
</div>
@endsection