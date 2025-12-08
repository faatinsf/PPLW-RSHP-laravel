@extends('layout.resepsionis')

@section('content')
<h3>Tambah Pemilik Hewan</h3>

<form action="{{ route('resepsionis.pemilik.store') }}" method="POST">
    @csrf
    <label>Nama</label>
    <input type="text" name="nama" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <label>No WA</label>
    <input type="text" name="no_wa" required>

    <label>Alamat</label>
    <textarea name="alamat" required></textarea>

    <button type="submit">Simpan</button>
</form>
@endsection
