@extends('layout.main')

@section('title', 'Struktur Organisasi')

@section('content')
<section id="struktur">
  <h2>Struktur Organisasi</h2>
  <ul>
    <li>Direktur</li>
    <li>Wakil Direktur Pelayanan</li>
    <li>Wakil Direktur Akademik</li>
    <li>Kepala Instalasi:
      <ul>
        <li>Poliklinik Hewan Kecil</li>
        <li>Poliklinik Hewan Besar</li>
        <li>Laboratorium</li>
      </ul>
    </li>
    <li>Bagian Administrasi</li>
  </ul>

  <table>
    <tr>
      <th>Unit</th>
      <th>Penanggung Jawab</th>
      <th>Kontak</th>
    </tr>
    <tr>
      <td>UGD 24 Jam</td>
      <td>drh. Budi</td>
      <td>0812-xxxx-xxxx</td>
    </tr>
    <tr>
      <td>Laboratorium</td>
      <td>drh. Citra</td>
      <td>0813-xxxx-xxxx</td>
    </tr>
  </table>
</section>
@endsection
