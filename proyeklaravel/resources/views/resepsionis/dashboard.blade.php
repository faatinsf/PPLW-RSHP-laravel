@extends('layout.resepsionis')

@section('title', 'Dashboard Resepsionis')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h3>Selamat Datang, Resepsionis RSHP!</h3>
        <p>Gunakan menu di sidebar untuk mengelola data hewan, pemilik, transaksi, dan jadwal pemeriksaan.</p>

        <hr>

        <div class="row text-center">
            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <h5>🐶 Data Hewan</h5>
                    <p class="text-muted">Lihat dan kelola semua data hewan yang terdaftar.</p>
                    <a href="{{ route('resepsionis.pet.index') }}" class="btn btn-sm btn-success">Lihat</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <h5>👤 Pemilik Hewan</h5>
                    <p class="text-muted">Atur data pemilik hewan di sini.</p>
                    <a href="{{ route('resepsionis.pemilik.index') }}" class="btn btn-sm btn-primary">Lihat</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <h5>📅 Jadwal Pemeriksaan</h5>
                    <p class="text-muted">Kelola jadwal kedatangan pasien hewan.</p>
                    <a href="{{ route('resepsionis.appointment.index') }}" class="btn btn-sm btn-warning">Lihat</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <h5>💳 Transaksi</h5>
                    <p class="text-muted">Lihat dan kelola data pembayaran.</p>
                    <a href="{{ route('resepsionis.transaksi.index') }}" class="btn btn-sm btn-danger">Lihat</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
