<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Pemilik Pet Klinik Hewan</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --sidebar-width: 280px;
            --primary-color: #10b981;
            --primary-dark: #059669;
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ============================================
           SIDEBAR STYLES
        ============================================ */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, #1e293b 100%);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            transition: var(--transition);
            z-index: 1050;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        .sidebar-header {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar-brand {
            font-size: 1.4rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: var(--transition);
        }

        .sidebar-brand:hover {
            color: var(--primary-color);
            transform: translateX(3px);
        }

        .sidebar-brand i {
            font-size: 1.8rem;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-title {
            padding: 1.25rem 1.5rem 0.75rem;
            font-size: 0.7rem;
            text-transform: uppercase;
            color: #94a3b8;
            font-weight: 700;
            letter-spacing: 0.1em;
        }

        .menu-item {
            padding: 0.875rem 1.5rem;
            color: #cbd5e1;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.875rem;
            transition: var(--transition);
            border-left: 3px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .menu-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 0;
            height: 100%;
            background: linear-gradient(90deg, var(--primary-color), transparent);
            transition: var(--transition);
            z-index: 0;
        }

        .menu-item:hover::before {
            width: 100%;
        }

        .menu-item:hover {
            background: var(--sidebar-hover);
            color: white;
            border-left-color: var(--primary-color);
            transform: translateX(5px);
        }

        .menu-item.active {
            background: linear-gradient(90deg, rgba(16, 185, 129, 0.15), transparent);
            color: white;
            border-left-color: var(--primary-color);
        }

        .menu-item i {
            width: 22px;
            text-align: center;
            font-size: 1.1rem;
            position: relative;
            z-index: 1;
        }

        .menu-item span {
            position: relative;
            z-index: 1;
            font-weight: 500;
        }

        .menu-item .badge {
            margin-left: auto;
            position: relative;
            z-index: 1;
        }

        /* Logout button special styling */
        .menu-item.logout {
            color: #fca5a5;
            margin-top: 1rem;
        }

        .menu-item.logout:hover {
            background: rgba(239, 68, 68, 0.1);
            border-left-color: #ef4444;
            color: #ef4444;
        }

        /* ============================================
           MAIN CONTENT
        ============================================ */
        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            background: #f8f9fa;
            transition: var(--transition);
        }

        /* ============================================
           TOP NAVBAR
        ============================================ */
        .top-navbar {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1040;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            animation: slideDown 0.3s ease-out;
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

        .navbar-left h4 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .breadcrumb {
            font-size: 0.85rem;
            color: #64748b;
            margin: 0.25rem 0 0 0;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Search Box */
        .search-box {
            position: relative;
            display: none; /* Hidden by default, show on larger screens */
        }

        @media (min-width: 992px) {
            .search-box {
                display: block;
            }
        }

        .search-box input {
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            width: 250px;
            transition: var(--transition);
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            width: 300px;
        }

        .search-box i {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        /* Notification Button */
        .notification-btn {
            position: relative;
            background: transparent;
            border: none;
            font-size: 1.25rem;
            color: #64748b;
            cursor: pointer;
            padding: 0.625rem;
            border-radius: 0.5rem;
            transition: var(--transition);
        }

        .notification-btn:hover {
            background: #f1f5f9;
            color: var(--primary-color);
            transform: scale(1.1);
        }

        .notification-badge {
            position: absolute;
            top: 0.25rem;
            right: 0.25rem;
            background: #ef4444;
            color: white;
            font-size: 0.65rem;
            padding: 0.15rem 0.4rem;
            border-radius: 1rem;
            font-weight: 700;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }

        /* User Dropdown */
        .user-dropdown {
            position: relative;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            transition: var(--transition);
            border: 1px solid transparent;
        }

        .user-info:hover {
            background: #f1f5f9;
            border-color: #e2e8f0;
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }

        .user-details {
            text-align: left;
        }

        .user-name {
            font-weight: 600;
            color: #1e293b;
            font-size: 0.9rem;
            line-height: 1.3;
        }

        .user-role {
            font-size: 0.75rem;
            color: #64748b;
        }

        .dropdown-icon {
            color: #94a3b8;
            transition: var(--transition);
            font-size: 0.75rem;
        }

        .user-dropdown.show .dropdown-icon {
            transform: rotate(180deg);
        }

        /* Dropdown Menu */
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            border-radius: 0.75rem;
            padding: 0.5rem;
            min-width: 220px;
            margin-top: 0.5rem;
            animation: fadeInDown 0.3s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item {
            padding: 0.625rem 1rem;
            border-radius: 0.5rem;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
            color: #64748b;
        }

        .dropdown-item:hover {
            background: #f1f5f9;
            color: var(--primary-color);
        }

        .dropdown-item:hover i {
            color: var(--primary-color);
        }

        .dropdown-divider {
            margin: 0.5rem 0;
            border-top: 1px solid #e2e8f0;
        }

        .dropdown-item.text-danger:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .dropdown-item.text-danger:hover i {
            color: #ef4444;
        }

        /* ============================================
           CONTENT AREA
        ============================================ */
        .content-area {
            padding: 2rem;
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

        /* ============================================
           CARDS
        ============================================ */
        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
            transition: var(--transition);
            overflow: hidden;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            color: #1e293b;
        }

        /* ============================================
           FOOTER
        ============================================ */
        footer {
            background: white;
            border-top: 1px solid #e2e8f0;
            padding: 1.5rem 2rem;
            text-align: center;
            color: #64748b;
            font-size: 0.875rem;
            margin-top: auto;
        }

        /* ============================================
           MOBILE RESPONSIVE
        ============================================ */
        .mobile-toggle {
            display: none;
            background: transparent;
            border: none;
            font-size: 1.5rem;
            color: #64748b;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: var(--transition);
        }

        .mobile-toggle:hover {
            background: #f1f5f9;
            color: var(--primary-color);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            opacity: 0;
            transition: var(--transition);
        }

        .sidebar-overlay.show {
            display: block;
            opacity: 1;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .mobile-toggle {
                display: block;
            }

            .content-area {
                padding: 1.5rem;
            }

            .top-navbar {
                padding: 1rem 1.5rem;
            }

            .navbar-left h4 {
                font-size: 1.25rem;
            }

            .user-details {
                display: none;
            }
        }

        /* ============================================
           UTILITY CLASSES
        ============================================ */
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        .slide-in-left {
            animation: slideInLeft 0.5s ease-out;
        }

        @keyframes slideInLeft {
            from {
                transform: translateX(-30px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Loading spinner */
        .spinner {
            border: 3px solid #f3f4f6;
            border-top: 3px solid var(--primary-color);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar Overlay for Mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('pemilik.dashboard') }}" class="sidebar-brand">
                    <i class="fas fa-paw"></i>
                    <span>Pet Klinik</span>
                </a>
            </div>

            <nav class="sidebar-menu">
                <div class="menu-title">MENU UTAMA</div>
                
                <a href="{{ route('pemilik.dashboard') }}" class="menu-item {{ request()->routeIs('pemilik.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('pemilik.pet') }}" class="menu-item {{ request()->routeIs('pemilik.pet*') ? 'active' : '' }}">
                    <i class="fas fa-paw"></i>
                    <span>Pet Saya</span>
                    <span class="badge bg-primary">3</span>
                </a>

                <a href="{{ route('pemilik.appointment') }}" class="menu-item {{ request()->routeIs('pemilik.appointment*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>Janji Temu</span>
                </a>

                <a href="{{ route('pemilik.rekam-medis') }}" class="menu-item {{ request()->routeIs('pemilik.rekam-medis*') ? 'active' : '' }}">
                    <i class="fas fa-file-medical"></i>
                    <span>Rekam Medis</span>
                </a>

                <div class="menu-title">LAYANAN</div>

                </a>

                <a href="#" class="menu-item logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navbar -->
            <nav class="top-navbar">
                <div class="navbar-left">
                    <button class="mobile-toggle" id="mobileToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div>
                        <h4>
                            @yield('page-title', 'Dashboard')
                        </h4>
                        <div class="breadcrumb">
                            <i class="fas fa-home"></i> @yield('breadcrumb', 'Home')
                        </div>
                    </div>
                </div>

                <div class="navbar-right">
                    <!-- Search Box -->
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Cari..." id="searchInput">
                    </div>

                    <!-- Notifications -->
                    <div class="dropdown">
                        <button class="notification-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">3</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header">Notifikasi</h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-calendar-check text-success"></i>
                                    Janji temu besok pukul 10:00
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-syringe text-primary"></i>
                                    Vaksinasi Luna jatuh tempo
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-file-medical text-info"></i>
                                    Hasil lab tersedia
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-center" href="#">Lihat Semua</a></li>
                        </ul>
                    </div>

                    <!-- User Dropdown -->
                    <div class="dropdown user-dropdown">
                        <div class="user-info" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar">BS</div>
                            <div class="user-details">
                                <div class="user-name">Budi Santoso</div>
                                <div class="user-role">Pemilik Pet</div>
                            </div>
                            <i class="fas fa-chevron-down dropdown-icon"></i>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end">
                        
                           
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-2').submit();">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Keluar
                                </a>
                            </li>
                        </ul>
                    </div>

                    <form id="logout-form-2" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </nav>

            <!-- Content Area -->
            <main class="content-area">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer>
                <p class="mb-0">
                    &copy; {{ date('Y') }} Pet Klinik Hewan. All rights reserved. 
                    <span class="mx-2">|</span>
                    Made with <i class="fas fa-heart text-danger"></i> for pets
                </p>
            </footer>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Mobile Toggle
        const mobileToggle = document.getElementById('mobileToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        if (mobileToggle) {
            mobileToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                sidebarOverlay.classList.toggle('show');
            });
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('show');
            });
        }

        // Close sidebar when clicking menu item on mobile
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('show');
                }
            });
        });

        // Active Menu Highlighting
        const currentPath = window.location.pathname;
        document.querySelectorAll('.menu-item').forEach(item => {
            if (item.getAttribute('href') === currentPath) {
                item.classList.add('active');
            }
        });

        // Auto dismiss alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const searchTerm = this.value;
                    console.log('Searching for:', searchTerm);
                    // Add your search logic here
                }
            });
        }

        // Smooth scroll to top
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Show scroll to top button when scrolled down
        window.addEventListener('scroll', function() {
            const scrollBtn = document.getElementById('scrollTopBtn');
            if (scrollBtn) {
                if (window.pageYOffset > 300) {
                    scrollBtn.style.display = 'block';
                } else {
                    scrollBtn.style.display = 'none';
                }
            }
        });

        // Add animation class to cards when they come into view
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.card').forEach(card => {
            observer.observe(card);
        });

        // Loading indicator
        window.addEventListener('load', function() {
            const loader = document.getElementById('pageLoader');
            if (loader) {
                loader.style.display = 'none';
            }
        });

        // Notification badge animation
        const notificationBadge = document.querySelector('.notification-badge');
        if (notificationBadge) {
            setInterval(function() {
                notificationBadge.style.animation = 'none';
                setTimeout(function() {
                    notificationBadge.style.animation = 'pulse 2s infinite';
                }, 10);
            }, 10000);
        }

        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Initialize popovers
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
    </script>
    
    @stack('scripts')
</body>
</html>