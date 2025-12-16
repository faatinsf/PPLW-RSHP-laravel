<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Perawat') | RSHP Unair</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    @stack('styles')

    <style>
        :root {
            --perawat-primary: #0077b6;
            --perawat-secondary: #00b4d8;
            --perawat-dark: #023e8a;
            --perawat-light: #90e0ef;
            --sidebar-width: 280px;
            --sidebar-collapsed: 80px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--perawat-primary) 0%, var(--perawat-dark) 100%);
            color: white;
            padding: 0;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 3px;
        }

        /* Toggle Button */
        .sidebar-toggle {
            position: absolute;
            top: 20px;
            right: -15px;
            width: 30px;
            height: 30px;
            background: white;
            border: none;
            border-radius: 50%;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--perawat-primary);
            transition: all 0.3s;
            z-index: 1001;
        }

        .sidebar-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        .sidebar-toggle i {
            transition: transform 0.3s;
        }

        .sidebar.collapsed .sidebar-toggle i {
            transform: rotate(180deg);
        }

        .sidebar-brand {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 10px;
            transition: all 0.3s;
            position: relative;
        }

        .sidebar.collapsed .sidebar-brand {
            padding: 25px 10px;
        }

        .brand-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .brand-icon {
            font-size: 2rem;
            min-width: 40px;
            text-align: center;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .brand-text {
            white-space: nowrap;
            overflow: hidden;
            transition: opacity 0.3s;
        }

        .sidebar.collapsed .brand-text {
            opacity: 0;
            width: 0;
        }

        .brand-text h3 {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
            background: linear-gradient(135deg, #fff, var(--perawat-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .brand-text small {
            color: rgba(255,255,255,0.8);
            font-size: 0.85rem;
        }

        /* Menu */
        .sidebar-menu {
            list-style: none;
            padding: 10px 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin: 3px 10px;
            position: relative;
        }

        .sidebar-menu a {
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 12px;
            position: relative;
            overflow: hidden;
        }

        .sidebar-menu a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: white;
            transform: scaleY(0);
            transition: transform 0.3s;
        }

        .sidebar-menu a:hover::before,
        .sidebar-menu a.active::before {
            transform: scaleY(1);
        }

        .sidebar-menu a:hover {
            background: rgba(255,255,255,0.15);
            color: white;
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .sidebar-menu a.active {
            background: rgba(255,255,255,0.2);
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .menu-icon {
            min-width: 24px;
            font-size: 1.3rem;
            text-align: center;
            transition: transform 0.3s;
        }

        .sidebar-menu a:hover .menu-icon {
            transform: scale(1.2) rotate(5deg);
        }

        .menu-text {
            white-space: nowrap;
            overflow: hidden;
            transition: opacity 0.3s;
        }

        .sidebar.collapsed .menu-text {
            opacity: 0;
            width: 0;
        }

        .sidebar.collapsed .sidebar-menu a {
            justify-content: center;
            padding: 14px;
        }

        /* Notification Badge */
        .notification-badge {
            position: absolute;
            top: 8px;
            right: 15px;
            background: #f56565;
            color: white;
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: 600;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-3px); }
        }

        .sidebar.collapsed .notification-badge {
            right: 8px;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .main-content.expanded {
            margin-left: var(--sidebar-collapsed);
        }

        /* Top Navbar */
        .navbar-top {
            background: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 999;
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .navbar-welcome h5 {
            color: #2d3748;
            font-size: 1.4rem;
            margin-bottom: 5px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--perawat-primary), var(--perawat-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .navbar-welcome small {
            color: #718096;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .live-clock {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: var(--perawat-primary);
            font-weight: 600;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--perawat-primary), var(--perawat-secondary));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.3rem;
            box-shadow: 0 4px 15px rgba(0,119,182,0.3);
            transition: all 0.3s;
            cursor: pointer;
            position: relative;
        }

        .user-avatar::after {
            content: '';
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 12px;
            height: 12px;
            background: #48bb78;
            border: 2px solid white;
            border-radius: 50%;
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.8; }
        }

        .user-avatar:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(0,119,182,0.4);
        }

        .user-details h6 {
            margin: 0;
            color: #2d3748;
            font-size: 1rem;
            font-weight: 600;
        }

        .user-details small {
            color: #718096;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .logout-btn {
            background: linear-gradient(135deg, #f56565, #e53e3e);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: 15px;
            font-weight: 500;
            box-shadow: 0 4px 15px rgba(245,101,101,0.3);
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245,101,101,0.4);
        }

        /* Content Area */
        .content-wrapper {
            padding: 30px;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Cards */
        .card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
            border: none;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--perawat-primary), var(--perawat-secondary));
            transform: scaleX(0);
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .card:hover::before {
            transform: scaleX(1);
        }

        .card-header {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #2d3748;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Table */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 12px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background: linear-gradient(135deg, #f7fafc, #edf2f7);
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #4a5568;
            border-bottom: 2px solid #e2e8f0;
            font-size: 0.9rem;
            white-space: nowrap;
        }

        .table td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
            color: #4a5568;
            transition: all 0.3s;
        }

        .table tbody tr {
            transition: all 0.3s;
        }

        .table tbody tr:hover {
            background: linear-gradient(90deg, rgba(0,119,182,0.05), transparent);
            transform: scale(1.01);
        }

        /* Buttons */
        .btn {
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transform: translate(-50%, -50%);
            transition: width 0.5s, height 0.5s;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102,126,234,0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102,126,234,0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
            box-shadow: 0 4px 15px rgba(72,187,120,0.3);
        }

        .btn-info {
            background: linear-gradient(135deg, #4299e1, #3182ce);
            color: white;
            box-shadow: 0 4px 15px rgba(66,153,225,0.3);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ed8936, #dd6b20);
            color: white;
            box-shadow: 0 4px 15px rgba(237,137,54,0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, #f56565, #e53e3e);
            color: white;
            box-shadow: 0 4px 15px rgba(245,101,101,0.3);
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        /* Loading Animation */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.95);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .loading-overlay.active {
            display: flex;
        }

        .spinner {
            width: 60px;
            height: 60px;
            border: 5px solid #e2e8f0;
            border-top: 5px solid var(--perawat-primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: block;
                position: fixed;
                bottom: 20px;
                right: 20px;
                width: 60px;
                height: 60px;
                background: linear-gradient(135deg, var(--perawat-primary), var(--perawat-secondary));
                color: white;
                border: none;
                border-radius: 50%;
                font-size: 1.5rem;
                box-shadow: 0 4px 20px rgba(0,119,182,0.4);
                z-index: 999;
                cursor: pointer;
            }

            .navbar-top {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .content-wrapper {
                padding: 15px;
            }
        }

        @media (min-width: 769px) {
            .mobile-menu-btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <button class="sidebar-toggle" onclick="toggleSidebar()">
            <i class="bi bi-chevron-left"></i>
        </button>
        
        <div class="sidebar-brand">
            <div class="brand-content">
                <div class="brand-icon">🏥</div>
                <div class="brand-text">
                    <h3>Klinik Hewan</h3>
                    <small>Panel Perawat</small>
                </div>
            </div>
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('perawat.dashboard') }}" class="{{ request()->routeIs('perawat.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 menu-icon"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('perawat.pasien.index') }}" class="{{ request()->routeIs('perawat.pasien.*') ? 'active' : '' }}">
                    <i class="bi bi-heart-pulse menu-icon"></i>
                    <span class="menu-text">Data Pasien</span>
                    <span class="notification-badge">12</span>
                </a>
            </li>
            <li>
                <a href="{{ route('perawat.rekam-medis.index') }}" class="{{ request()->routeIs('perawat.rekam-medis.*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard2-pulse menu-icon"></i>
                    <span class="menu-text">Rekam Medis</span>
                </a>
            </li>
            <li>
                <a href="{{ route('perawat.profil') }}" class="{{ request()->routeIs('perawat.profil') ? 'active' : '' }}">
                    <i class="bi bi-person-circle menu-icon"></i>
                    <span class="menu-text">Profil Saya</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" onclick="toggleMobileSidebar()">
        <i class="bi bi-list"></i>
    </button>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navbar -->
        @php
            $user = Auth::user();
            $initial = $user ? strtoupper(substr($user->nama ?? $user->name ?? 'P', 0, 1)) : 'P';
            $username = $user->nama ?? $user->name ?? 'Perawat';
        @endphp

        <div class="navbar-top">
            <div class="navbar-welcome">
                <h5>Selamat Datang, {{ $username }}! 👋</h5>
                <small>
                    <i class="bi bi-calendar-check"></i>
                    <span id="currentDate"></span>
                    <span class="live-clock">
                        <i class="bi bi-clock"></i>
                        <span id="liveClock"></span>
                    </span>
                </small>
            </div>

            <div class="user-info">
                <div class="user-avatar" title="Online">
                    {{ $initial }}
                </div>
                <div class="user-details">
                    <h6>{{ $username }}</h6>
                    <small>
                        <i class="bi bi-shield-check"></i>
                        Perawat
                    </small>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="logout-btn" onclick="showLoading()">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle Sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            
            // Save state to localStorage
            const isCollapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebarCollapsed', isCollapsed);
        }

        // Toggle Mobile Sidebar
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('mobile-open');
        }

        // Restore Sidebar State
        window.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }
        });

        // Live Clock
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            
            document.getElementById('liveClock').textContent = `${hours}:${minutes}:${seconds}`;
        }

        // Update Date
        function updateDate() {
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const date = new Date().toLocaleDateString('id-ID', options);
            document.getElementById('currentDate').textContent = date;
        }

        // Loading Overlay
        function showLoading() {
            document.getElementById('loadingOverlay').classList.add('active');
        }

        function hideLoading() {
            document.getElementById('loadingOverlay').classList.remove('active');
        }

        // Close mobile sidebar when clicking outside
        document.addEventListener('click', (e) => {
            const sidebar = document.getElementById('sidebar');
            const mobileBtn = document.querySelector('.mobile-menu-btn');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(e.target) && 
                !mobileBtn.contains(e.target) &&
                sidebar.classList.contains('mobile-open')) {
                sidebar.classList.remove('mobile-open');
            }
        });

        // Show loading on page navigation
        document.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', (e) => {
                if (!link.getAttribute('href').startsWith('#')) {
                    showLoading();
                }
            });
        });

        // Initialize
        setInterval(updateClock, 1000);
        updateClock();
        updateDate();

        // Hide loading when page fully loaded
        window.addEventListener('load', () => {
            hideLoading();
        });
    </script>
    
    @stack('scripts')
</body>
</html>