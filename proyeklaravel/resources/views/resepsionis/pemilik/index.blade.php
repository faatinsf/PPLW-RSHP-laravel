@extends('layout.resepsionis')

@section('content')
<div class="container">
    <h3>Data Pemilik Hewan</h3>

    <form action="{{ route('resepsionis.pemilik.index') }}" method="GET">
        <input type="text" name="search" placeholder="Cari nama / email / no wa" value="{{ request('search') }}">
        <button type="submit">Cari</button>
    </form>

    <a href="{{ route('resepsionis.pemilik.create') }}" class="btn btn-primary">Tambah Pemilik</a>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>No WA</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($owners as $o)
            <tr>
                <td>{{ $o->nama }}</td>
                <td>{{ $o->email }}</td>
                <td>{{ $o->no_wa }}</td>
                <td>{{ $o->alamat }}</td>
                <td>
                    <a href="{{ route('resepsionis.pemilik.edit', $o->idpemilik) }}">Edit</a>
                    <form action="{{ route('resepsionis.pemilik.destroy', $o->idpemilik) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Hapus data?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $owners->links() }}
</div>
@endsection
