<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('pemilik.dashboard') }}" class="sidebar-brand">
            <i class="fas fa-paw"></i>
            <span>Klinik Hewan</span>
        </a>
        <div style="font-size: 0.85rem; color: #64748b; margin-top: 0.5rem;">
            Portal Pemilik Pet
        </div>
    </div>

    <div class="sidebar-menu">
        <div class="menu-title">Menu Utama</div>
        
        <a href="{{ route('pemilik.dashboard') }}" 
           class="menu-item {{ request()->routeIs('pemilik.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('pemilik.jadwal-temu') }}" 
           class="menu-item {{ request()->routeIs('pemilik.jadwal-temu') ? 'active' : '' }}">
            <i class="fas fa-calendar-check"></i>
            <span>Jadwal Temu Dokter</span>
            @if(isset($jadwal_count) && $jadwal_count > 0)
            <span class="badge bg-primary ms-auto">{{ $jadwal_count }}</span>
            @endif
        </a>

        <a href="{{ route('pemilik.rekam-medis') }}" 
           class="menu-item {{ request()->routeIs('pemilik.rekam-medis*') ? 'active' : '' }}">
            <i class="fas fa-file-medical"></i>
            <span>Rekam Medis</span>
        </a>

        <a href="{{ route('pemilik.pet') }}" 
           class="menu-item {{ request()->routeIs('pemilik.pet') ? 'active' : '' }}">
            <i class="fas fa-dog"></i>
            <span>Pet Saya</span>
            @if(Auth::user()->pemilik)
            <span class="badge bg-success ms-auto">{{ Auth::user()->pemilik->pets->count() }}</span>
            @endif
        </a>

        <div class="menu-title">Akun</div>

        <a href="{{ route('pemilik.profil') }}" 
           class="menu-item {{ request()->routeIs('pemilik.profil') ? 'active' : '' }}">
            <i class="fas fa-user"></i>
            <span>Profil Saya</span>
        </a>

        <a href="#" class="menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <!-- User Info at Bottom -->
    <div style="position: absolute; bottom: 0; width: 100%; padding: 1rem; border-top: 1px solid rgba(255, 255, 255, 0.1); background: rgba(0, 0, 0, 0.2);">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #10b981 0%, #059669 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 1.1rem;">
                {{ strtoupper(substr(Auth::user()->nama, 0, 2)) }}
            </div>
            <div style="flex: 1; overflow: hidden;">
                <div style="font-weight: 600; font-size: 0.9rem; color: white; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{ Auth::user()->nama }}
                </div>
                <div style="font-size: 0.75rem; color: #94a3b8;">
                    Pemilik Pet
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.menu-item {
    position: relative;
    transition: all 0.3s ease;
}

.menu-item:hover {
    transform: translateX(5px);
}

.menu-item.active {
    font-weight: 600;
}

.menu-item.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: var(--primary-color);
}

.menu-item .badge {
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
}

/* Hover effect for icons */
.menu-item:hover i {
    transform: scale(1.1);
    transition: transform 0.2s;
}

/* Active menu animation */
.menu-item.active {
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-10px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Sidebar responsive */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    
    .sidebar.active {
        transform: translateX(0);
    }
}
</style>

<script>
// Auto-highlight active menu on page load
document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname;
    const menuItems = document.querySelectorAll('.menu-item');
    
    menuItems.forEach(item => {
        const href = item.getAttribute('href');
        if (href && href !== '#' && currentPath.includes(href)) {
            item.classList.add('active');
        }
    });
});
</script>