<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'RSHP Universitas Airlangga')</title>
  <style>
    /* === RESET & FONT === */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Arial, sans-serif;
      background-color: #e9eef7;
      color: #333;
      line-height: 1.6;
    }

    /* === HEADER === */
    header {
      background: linear-gradient(135deg, #0b2a32, #15535c);
      color: white;
      padding: 20px 0;
      text-align: center;
      position: relative;
    }

    header img {
      width: 80px;
      position: absolute;
      left: 30px;
      top: 50%;
      transform: translateY(-50%);
      border-radius: 50%;
      border: 2px solid white;
      background-color: white;
    }

    header h1 {
      font-size: 1.6rem;
      letter-spacing: 0.5px;
      margin-left: 100px;
    }

    /* === NAVIGATION === */
    nav {
      background-color: #0b2a32;
      display: flex;
      justify-content: center;
      gap: 25px;
      padding: 12px 0;
      box-shadow: 0 3px 5px rgba(0,0,0,0.15);
    }

    nav a {
      color: white;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
      padding: 8px 15px;
      border-radius: 5px;
    }

    nav a:hover {
      background-color: #1f5f68;
      transform: translateY(-2px);
    }

    /* === SECTION STYLING === */
    section {
      background: white;
      margin: 30px auto;
      max-width: 900px;
      border-radius: 12px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
      padding: 25px 30px;
      transition: all 0.3s ease;
    }

    section:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.15);
    }

    section h2 {
      color: #0b2a32;
      border-bottom: 3px solid #1f5f68;
      display: inline-block;
      margin-bottom: 15px;
      padding-bottom: 5px;
    }

    section h3 {
      margin-top: 20px;
      color: #1f5f68;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      margin-top: 10px;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: left;
    }

    th {
      background-color: #0b2a32;
      color: white;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    tr:nth-child(even) {
      background-color: #f5f8fc;
    }

    tr:hover {
      background-color: #eef4ff;
    }

    ul, ol {
      margin: 10px 0 10px 20px;
    }

    li {
      margin-bottom: 6px;
    }

    img {
      display: block;
      margin: 20px auto;
      max-width: 100%;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    footer {
      background-color: #0b2a32;
      color: white;
      text-align: center;
      padding: 12px 0;
      font-size: 0.9rem;
      letter-spacing: 0.3px;
    }

    footer a {
      color: #8ed0d6;
      text-decoration: none;
    }

    footer a:hover {
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      header img { display: none; }
      header h1 { margin-left: 0; font-size: 1.3rem; }
      nav { flex-wrap: wrap; gap: 10px; }
      section { margin: 20px 15px; padding: 20px; }
    }
  </style>
</head>
<body>
  <header>
    <img src="{{ asset('images/logo-rshp.png') }}" alt="Logo RSHP">
    <h1>Rumah Sakit Hewan Pendidikan (RSHP) Universitas Airlangga</h1>
  </header>

  <nav>
    <a href="{{ route('home') }}">Home</a>
    <a href="{{ route('struktur') }}">Struktur Organisasi</a>
    <a href="{{ route('layanan') }}">Layanan Umum</a>
    <a href="{{ route('visi') }}">Visi Misi dan Tujuan</a>
    <a href="{{ route('login') }}">Login</a>
  </nav>

  <main>
    @yield('content')
  </main>

  <footer>
    &copy; 2025 RSHP Universitas Airlangga — 
    <a href="https://rshp.unair.ac.id" target="_blank">rshp.unair.ac.id</a>
  </footer>
</body>
</html>
