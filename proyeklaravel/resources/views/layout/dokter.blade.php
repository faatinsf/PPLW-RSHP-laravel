<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Dokter') | RSHP Unair</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">


    
    @stack('styles')

    <style>
        :root {
            --dokter-primary: #0077b6;
            --dokter-secondary: #00b4d8;
            --dokter-dark: #023e8a;
            --sidebar-width: 260px;
        }
        body { background-color: #f0f2f5; font-family: 'Segoe UI'; overflow-x: hidden; }
        .sidebar { position: fixed; left:0; top:0; width:var(--sidebar-width); height:100vh;
            background: linear-gradient(180deg, var(--dokter-primary), var(--dokter-dark));
            color:white; padding:20px 0; overflow-y:auto; }
        .sidebar-menu a { padding:12px 15px; display:flex; gap:12px; color:white; text-decoration:none; border-radius:10px; }
        .sidebar-menu a.active { background:rgba(255,255,255,0.2); }
        .main-content { margin-left:var(--sidebar-width); padding:30px; }
        .navbar-top { padding:15px 30px; background:white; margin:-30px -30px 30px -30px; 
            display:flex; justify-content:space-between; }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header px-3 pb-3 border-bottom border-white border-opacity-25">
            <h4 class="d-flex align-items-center gap-2">
                <i class="bi bi-hospital"></i> RSHP Unair
            </h4>
            <small>Dashboard Dokter</small>
        </div>

        <ul class="sidebar-menu px-2">
            <li>
                <a href="{{ route('dokter.dashboard') }}"
                   class="{{ request()->routeIs('dokter.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>

            

            <li>
                <a href="{{ route('dokter.pet.index') }}"
                   class="{{ request()->routeIs('dokter.pet.*') ? 'active' : '' }}">
                    <i class="bi bi-emoji-smile"></i> Data Hewan

                </a>
            </li>

            <li>
                <a href="{{ route('dokter.pemilik.index') }}"
                   class="{{ request()->routeIs('dokter.pemilik.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Data Pemilik
                </a>
            </li>

            <li>
               <a href="{{ route('dokter.rekam-medis.index') }}"
                  class="{{ request()->routeIs('dokter.rekam-medis.index') || request()->routeIs('dokter.rekam-medis.*') ? 'active' : '' }}">
                   <i class="bi bi-file-medical"></i> Rekam Medis
               </a>
            </li>
             <li>
                <a href="{{ route('dokter.profile') }}"
                   class="{{ request()->routeIs('dokter.profile') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Profile
                </a>
            </li>
        </ul>

        <div class="sidebar-divider my-3"></div>

        <ul class="sidebar-menu px-2">
            <li>
                <a href="#" class="text-danger"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </li>
        </ul>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content">

        <!-- Top Navbar -->

        @php
            $user = Auth::user();
            $initial = $user ? strtoupper(substr($user->nama ?? $user->name ?? 'D', 0, 1)) : 'D';
            $username = $user->nama ?? $user->name ?? 'Dokter';
        @endphp

        <div class="navbar-top shadow-sm">
            <div>
                <h5 class="mb-0">Selamat Datang, Dokter!</h5>
                <small>{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</small>
            </div>

            <div class="user-info d-flex align-items-center gap-3">
                <div class="user-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                     style="width:45px; height:45px;">
                    {{ $initial }}
                </div>

                <div class="user-details">
                    <h6 class="mb-0">{{ $username }}</h6>
                    <small>Dokter Hewan</small>
                </div>
            </div>
        </div>

        @yield('content')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

</body>
</html>
