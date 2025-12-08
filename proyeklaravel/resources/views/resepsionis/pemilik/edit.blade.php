@extends('layout.resepsionis')

@section('content')
<h3>Edit Pemilik</h3>

<form action="{{ route('resepsionis.pemilik.update', $pemilik->idpemilik) }}" method="POST">
    @csrf @method('PUT')

    <label>Nama</label>
    <input type="text" name="nama" value="{{ $pemilik->nama }}" required>

    <label>Email</label>
    <input type="email" name="email" value="{{ $pemilik->email }}" required>

    <label>No WA</label>
    <input type="text" name="no_wa" value="{{ $pemilik->no_wa }}" required>

    <label>Alamat</label>
    <textarea name="alamat" required>{{ $pemilik->alamat }}</textarea>

    <button type="submit">Update</button>
</form>
@endsection
