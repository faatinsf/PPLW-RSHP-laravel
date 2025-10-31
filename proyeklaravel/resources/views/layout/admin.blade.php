<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin | RSHP Universitas Airlangga')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f9;
            overflow-x: hidden;
        }

        /* === SIDEBAR === */
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, #003366 0%, #004c99 100%);
            color: #fff;
            overflow-y: auto;
            transition: all 0.3s ease;
            box-shadow: 2px 0 8px rgba(0,0,0,0.15);
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .sidebar h4 {
            font-weight: 600;
            text-align: center;
            margin-bottom: 25px;
            letter-spacing: 0.5px;
        }

        .sidebar a {
            color: #ffffffcc;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            margin: 6px 10px;
            transition: all 0.2s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
            transform: translateX(4px);
        }

        .sidebar hr {
            border-color: rgba(255,255,255,0.2);
            margin: 15px;
        }

        /* === CONTENT === */
        .content {
            margin-left: 250px;
            min-height: 100vh;
            padding: 20px 30px;
            transition: all 0.3s ease;
        }

        /* === NAVBAR === */
        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-radius: 12px;
            padding: 12px 20px;
            animation: fadeDown 0.6s ease;
        }

        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .navbar .navbar-brand {
            font-weight: 600;
            color: #003366;
        }

        /* === FOOTER === */
        footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 14px;
        }

        /* === ANIMASI HALUS KONTEN === */
        .content > div {
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* === TOGGLE UNTUK MOBILE === */
        @media (max-width: 992px) {
            .sidebar {
                left: -250px;
                z-index: 1000;
            }

            .sidebar.show {
                left: 0;
            }

            .content {
                margin-left: 0;
            }

            .toggle-btn {
                cursor: pointer;
                color: #003366;
            }
        }
    </style>
</head>
<body>

    {{-- SIDEBAR --}}
    <div class="sidebar" id="sidebar">
        <h4>🐾 RSHP Admin</h4>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
        <a href="{{ route('user.index') }}">👤 Data User</a>
        <a href="{{ route('role.index') }}">🛡️ Role</a>
        <a href="{{ route('roleuser.index') }}">⚙️ Role User</a>
        <a href="{{ route('pemilik.index') }}">🐕 Pemilik Hewan</a>
        <a href="{{ route('pet.index') }}">🐶 Data Hewan</a>
        <a href="{{ route('jenishewan.index') }}">🐾 Jenis Hewan</a>
        <a href="{{ route('rekammedis.index') }}">📋 Rekam Medis</a>
        <a href="{{ route('detailrekammedis.index') }}">🩺 Detail Rekam Medis</a>
        <a href="{{ route('kategori.index') }}">🧩 Kategori</a>
        <a href="{{ route('kategoriklinis.index') }}">💊 Kategori Klinis</a>
        <a href="{{ route('kodetindakanterapi.index') }}">⚕️ Tindakan Terapi</a>

        <hr>
        <a href="{{ route('login') }}">🚪 Logout</a>
    </div>

    {{-- KONTEN --}}
    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-light mb-3">
            <div class="container-fluid">
                <span class="navbar-brand">Dashboard Admin</span>
                <div class="d-flex align-items-center">
                    <span class="me-3 text-secondary">Halo, Admin 👋</span>
                    <span class="toggle-btn d-lg-none fs-4" onclick="toggleSidebar()">☰</span>
                </div>
            </div>
        </nav>

        <div class="mt-4">
            @yield('content')
        </div>

        <footer class="mt-5">
            <small>&copy; {{ date('Y') }} RSHP Universitas Airlangga. All Rights Reserved.</small>
        </footer>
    </div>

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        function toggleSidebar() {
            sidebar.classList.toggle('show');
        }
    </script>

</body>
</html>
