<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin | RSHP Universitas Airlangga')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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
            z-index: 1000;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background-color: rgba(255, 255, 255, 0.5);
        }

        /* Sidebar Brand/Header */
        .sidebar-brand {
            padding: 1.2rem 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            margin-bottom: 10px;
        }

        .sidebar-brand:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .sidebar-brand h4 {
            font-weight: 600;
            margin: 0;
            letter-spacing: 0.5px;
            font-size: 1.25rem;
            color: #fff;
        }

        /* Sidebar Navigation */
        .sidebar-nav {
            padding: 0;
            list-style: none;
        }

        .sidebar-nav .nav-item {
            margin: 0;
        }

        .sidebar-nav .nav-link {
            color: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            padding: 0.8rem 1rem;
            text-decoration: none;
            border-radius: 0.25rem;
            margin: 2px 8px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            position: relative;
        }

        .sidebar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            transform: translateX(3px);
        }

        .sidebar-nav .nav-link.active {
            background-color: #007bff;
            color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .sidebar-nav .nav-link:focus {
            outline: 2px solid rgba(255, 255, 255, 0.3);
            outline-offset: 2px;
        }

        /* Icon in nav links */
        .nav-icon {
            font-size: 1.1rem;
            margin-right: 0.75rem;
            width: 1.5rem;
            text-align: center;
        }

        /* Divider */
        .sidebar hr {
            border-color: rgba(255,255,255,0.2);
            margin: 15px 12px;
            opacity: 1;
        }

        /* Logout link styling */
        .sidebar-nav .nav-link.text-danger {
            color: rgba(220, 53, 69, 0.9) !important;
        }

        .sidebar-nav .nav-link.text-danger:hover {
            background-color: rgba(220, 53, 69, 0.1);
            color: #ff4d5e !important;
        }

        /* === CONTENT === */
        .content {
            margin-left: 250px;
            min-height: 100vh;
            padding: 20px 30px;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        /* === NAVBAR === */
        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-radius: 12px;
            padding: 12px 20px;
            animation: fadeDown 0.6s ease;
            margin-bottom: 1.5rem;
        }

        @keyframes fadeDown {
            from { 
                opacity: 0; 
                transform: translateY(-10px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }

        .navbar .navbar-brand {
            font-weight: 600;
            color: #003366;
            font-size: 1.25rem;
        }

        .navbar .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .navbar .user-greeting {
            color: #6c757d;
            font-size: 0.95rem;
        }

        /* === MAIN CONTENT AREA === */
        .main-content {
            flex: 1;
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: translateY(10px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }

        /* === FOOTER === */
        footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 14px;
            margin-top: auto;
            padding-top: 2rem;
        }

        /* === CARDS === */
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-radius: 12px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }

        /* === BUTTONS === */
        .btn {
            border-radius: 8px;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        /* === TOGGLE UNTUK MOBILE === */
        .toggle-btn {
            display: none;
            cursor: pointer;
            color: #003366;
            font-size: 1.5rem;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .toggle-btn:hover {
            background-color: rgba(0, 51, 102, 0.1);
        }

        @media (max-width: 992px) {
            .sidebar {
                left: -250px;
            }

            .sidebar.show {
                left: 0;
            }

            .content {
                margin-left: 0;
            }

            .toggle-btn {
                display: block;
            }

            .navbar .navbar-brand {
                font-size: 1.1rem;
            }

            .navbar .user-greeting {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .content {
                padding: 15px;
            }

            .navbar {
                padding: 10px 15px;
                margin-bottom: 1rem;
            }
        }

        /* === TABLE STYLING === */
        .table {
            background-color: #fff;
            border-radius: 12px;
            overflow: hidden;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
        }

        /* === ALERTS === */
        .alert {
            border-radius: 12px;
            border: none;
        }

        /* === SMOOTH TRANSITIONS === */
        a, button, .btn, .nav-link {
            transition: all 0.3s ease;
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- SIDEBAR --}}
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h4>🐾 RSHP Admin</h4>
        </div>
        
        <nav>
            <ul class="sidebar-nav">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="nav-icon">🏠</span>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.index') }}" class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}">
                        <span class="nav-icon">👤</span>
                        <span>Data User</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('role.index') }}" class="nav-link {{ request()->routeIs('role.*') ? 'active' : '' }}">
                        <span class="nav-icon">🛡️</span>
                        <span>Role</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('roleuser.index') }}" class="nav-link {{ request()->routeIs('roleuser.*') ? 'active' : '' }}">
                        <span class="nav-icon">⚙️</span>
                        <span>Role User</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pemilik.index') }}" class="nav-link {{ request()->routeIs('pemilik.*') ? 'active' : '' }}">
                        <span class="nav-icon">🐕</span>
                        <span>Pemilik Hewan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pet.index') }}" class="nav-link {{ request()->routeIs('pet.*') ? 'active' : '' }}">
                        <span class="nav-icon">🐶</span>
                        <span>Data Hewan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('rashewan.index') }}" class="nav-link {{ request()->routeIs('rashewan.*') ? 'active' : '' }}">
                        <span class="nav-icon">🐾</span>
                        <span>Ras Hewan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('jenis-hewan.index') }}" class="nav-link {{ request()->routeIs('jenis-hewan.*') ? 'active' : '' }}">
                        <span class="nav-icon">🦴</span>
                        <span>Jenis Hewan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('rekammedis.index') }}" class="nav-link {{ request()->routeIs('rekammedis.*') ? 'active' : '' }}">
                        <span class="nav-icon">📋</span>
                        <span>Rekam Medis</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('detailrekammedis.index') }}" class="nav-link {{ request()->routeIs('detailrekammedis.*') ? 'active' : '' }}">
                        <span class="nav-icon">🩺</span>
                        <span>Detail Rekam Medis</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('kategori.index') }}" class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                        <span class="nav-icon">🧩</span>
                        <span>Kategori</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('kategoriklinis.index') }}" class="nav-link {{ request()->routeIs('kategoriklinis.*') ? 'active' : '' }}">
                        <span class="nav-icon">💊</span>
                        <span>Kategori Klinis</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('kodetindakanterapi.index') }}" class="nav-link {{ request()->routeIs('kodetindakanterapi.*') ? 'active' : '' }}">
                        <span class="nav-icon">⚕️</span>
                        <span>Tindakan Terapi</span>
                    </a>
                </li>
            </ul>

            <hr>

            <ul class="sidebar-nav">
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link text-danger">
                        <span class="nav-icon">🚪</span>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    {{-- MAIN CONTENT WRAPPER --}}
    <div class="content">
        {{-- NAVBAR --}}
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <span class="navbar-brand">Dashboard Admin</span>
                <div class="user-info">
                    <span class="user-greeting">Halo, Admin 👋</span>
                    <button class="toggle-btn" onclick="toggleSidebar()" aria-label="Toggle Sidebar">
                        ☰
                    </button>
                </div>
            </div>
        </nav>

        {{-- MAIN CONTENT --}}
        <div class="main-content">
            @yield('content')
        </div>

        {{-- FOOTER --}}
        <footer>
            <small>&copy; {{ date('Y') }} RSHP Universitas Airlangga. All Rights Reserved.</small>
        </footer>
    </div>

    {{-- SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle Sidebar
        const sidebar = document.getElementById('sidebar');
        
        function toggleSidebar() {
            sidebar.classList.toggle('show');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 992) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isToggleBtn = event.target.classList.contains('toggle-btn') || 
                                   event.target.closest('.toggle-btn');
                
                if (!isClickInsideSidebar && !isToggleBtn && sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                }
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 992) {
                sidebar.classList.remove('show');
            }
        });

        // Smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>