@extends('layout.main')

@section('title', 'Layanan Umum')

@section('content')
<section id="layanan">
  <h2>Layanan Umum</h2>
  <ol>
    <li>Konsultasi & Pemeriksaan</li>
    <li>Vaksinasi</li>
    <li>Bedah</li>
    <li>UGD 24 Jam</li>
    <li>Laboratorium</li>
  </ol>

  <h3>Jam Layanan</h3>
  <table>
    <tr>
      <th>Layanan</th>
      <th>Hari</th>
      <th>Jam</th>
    </tr>
    <tr>
      <td>Poliklinik</td>
      <td>Senin–Jumat</td>
      <td>08.00–15.00</td>
    </tr>
    <tr>
      <td>UGD</td>
      <td>Setiap Hari</td>
      <td>24 Jam</td>
    </tr>
  </table>
</section>
@endsection
