<div class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('resepsionis.dashboard') }}" class="sidebar-brand">
            <i class="fas fa-clinic-medical"></i>
            RSH Petcare
        </a>
    </div>

    <div class="sidebar-menu">

        <div class="menu-title">Dashboard</div>
        <a href="{{ route('resepsionis.dashboard') }}" class="menu-item">
            <i class="fas fa-home"></i> Dashboard
        </a>

        <div class="menu-title">Data Master</div>
        <a href="{{ route('resepsionis.pemilik.index') }}" class="menu-item">
            <i class="fas fa-user"></i> Pemilik Hewan
        </a>
        <a href="{{ route('resepsionis.pet.index') }}" class="menu-item">
            <i class="fas fa-paw"></i> Data Hewan
        </a>

        <div class="menu-title">Layanan</div>
        <a href="{{ route('resepsionis.appointment.index') }}" class="menu-item">
            <i class="fas fa-calendar-check"></i> Appointment
        </a>
        


        <a href="{{ route('resepsionis.rekammedis.index') }}" class="menu-item">
            <i class="fas fa-cash-register"></i> Rekam Medis
        </a>

         <!-- Logout -->
                <li class="nav-item">
                    <a href="#" class="nav-link text-danger" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon bi bi-box-arrow-right"></i>
                        <p>Logout</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
    </div>
</div>
