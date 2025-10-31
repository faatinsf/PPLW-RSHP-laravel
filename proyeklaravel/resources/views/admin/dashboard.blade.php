@extends('layout.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="card shadow-sm text-center" style="border-radius: 15px;">
    <div class="card-body">
        <h3 class="mb-3">Selamat Datang di Dashboard RSHP!</h3>
        <p class="mb-4 text-muted">
            Gunakan menu di sidebar untuk mengelola data pengguna, hewan, rekam medis, dan lainnya.
        </p>
        <img 
            src="https://cdn-icons-png.flaticon.com/512/616/616408.png" 
            alt="Dog Icon" 
            class="dog-image"
            style="width: 150px; height: auto; display: block; margin: 0 auto;"
        >
    </div>
</div>
@endsection
