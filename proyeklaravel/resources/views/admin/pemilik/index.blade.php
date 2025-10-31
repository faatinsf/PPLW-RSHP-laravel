@extends('layout.admin')

@section('title', 'Data Pemilik Hewan')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">📋 Data Pemilik Hewan</h1>

    {{-- Tombol tambah data --}}
   
        + Tambah Pemilik
    </a>

    {{-- Tabel data --}}
    <div class="card shadow-sm rounded">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama User</th>
                        <th>Alamat</th>
                        <th>No. Telepon</th>
                        <th>Jumlah Hewan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pemilik as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->user->name ?? '-' }}</td>
                            <td>{{ $item->alamat ?? '-' }}</td>
                            <td>{{ $item->no_telp ?? '-' }}</td>
                            <td class="text-center">{{ $item->pets->count() }}</td>
                            <td class="text-center">
                               
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data pemilik.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

