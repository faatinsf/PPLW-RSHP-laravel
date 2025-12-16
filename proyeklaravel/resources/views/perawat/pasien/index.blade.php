@extends('layout.perawat')

@section('title', 'Data Pasien')

@section('content')
<div class="page-header">
    <h1>🐾 Data Pasien</h1>
    <p class="breadcrumb">Dashboard / Data Pasien</p>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <div class="card-header" style="margin: 0; border: none; padding: 0;">
            Daftar Pasien
        </div>
        <form action="{{ route('perawat.pasien.index') }}" method="GET" style="display: flex; gap: 0.5rem;">
            <input type="text" 
                   name="search" 
                   class="form-control" 
                   placeholder="🔍 Cari nama pet/pemilik/ras..." 
                   value="{{ $search }}"
                   style="width: 300px;">
            <button type="submit" class="btn btn-primary">Cari</button>
            @if($search)
                <a href="{{ route('perawat.pasien.index') }}" class="btn btn-warning">Reset</a>
            @endif
        </form>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pet</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Hewan</th>
                <th>Ras</th>
                <th>Pemilik</th>
                <th>No. WA</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pasien as $index => $p)
            <tr>
                <td>{{ $pasien->firstItem() + $index }}</td>
                <td><strong>{{ $p->nama }}</strong></td>
                <td>
                    @if($p->jenis_kelamin == 'M')
                        <span class="badge badge-info">Jantan</span>
                    @else
                        <span class="badge badge-danger">Betina</span>
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal_lahir)->format('d/m/Y') }}</td>
                <td>{{ $p->nama_jenis_hewan }}</td>
                <td>{{ $p->nama_ras }}</td>
                <td>{{ $p->pemilik_nama }}</td>
                <td>{{ $p->no_wa }}</td>
                <td>
                    <a href="{{ route('perawat.pasien.show', $p->idpet) }}" class="btn btn-info btn-sm">
                         Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align: center; color: #718096; padding: 2rem;">
                    @if($search)
                        Tidak ada data yang sesuai dengan pencarian "{{ $search }}"
                    @else
                        Belum ada data pasien
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($pasien->hasPages())
    <div style="margin-top: 1.5rem;">
        {{ $pasien->links() }}
    </div>
    @endif
</div>
@endsection