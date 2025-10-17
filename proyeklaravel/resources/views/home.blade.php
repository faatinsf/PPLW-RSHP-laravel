@extends('layout.main')

@section('title', 'Home')

@section('content')
<section id="home">
  <h2>Home</h2>
  <p><b>RSHP Universitas Airlangga</b> adalah fasilitas pelayanan kesehatan hewan yang juga berfungsi sebagai pusat pendidikan kedokteran hewan. Kami melayani hewan kecil, hewan besar, dan satwa liar.</p>
  <img src="{{ asset('image/gambarrshp.jpg') }}" alt="Gedung RSHP Universitas Airlangga">
  <p>Sumber informasi resmi dapat dilihat di 
    <a href="https://rshp.unair.ac.id" target="_blank">Website RSHP UNAIR</a>.
  </p>
</section>
@endsection
