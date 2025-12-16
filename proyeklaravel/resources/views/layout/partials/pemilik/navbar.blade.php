<div class="top-navbar">
    <div class="navbar-left">
        <button class="mobile-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <h4>@yield('page-title', 'Dashboard')</h4>
    </div>
@php
    $recent_rekam_medis = collect($recent_rekam_medis ?? []);
@endphp

   <div class="top-navbar">
    <div class="navbar-left">
        <button class="mobile-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <h4>@yield('page-title', 'Dashboard')</h4>
    </div>

@php
    use Illuminate\Support\Facades\Auth;
    use App\Models\RekamMedis;

    // PASTI COLLECTION
    $recent_rekam_medis = collect();
    $notif_count = 0;

    if (Auth::check() && Auth::user()->pemilik) {
        $recent_rekam_medis = RekamMedis::whereHas('pet', function ($q) {
                $q->where('idpemilik', Auth::user()->pemilik->idpemilik);
            })
            ->with('pet')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $notif_count = $recent_rekam_medis->count();
    }
@endphp

    <div class="navbar-right">
        <!-- NOTIFICATION -->
        <div class="dropdown">
            <button class="notification-btn" data-bs-toggle="dropdown">
                <i class="fas fa-bell"></i>
                @if($notif_count > 0)
                    <span class="notification-badge">{{ $notif_count }}</span>
                @endif
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow"
                style="width: 350px; max-height: 400px; overflow-y: auto;">
                <li class="dropdown-header d-flex justify-content-between align-items-center">
                    <strong>Notifikasi</strong>
                    @if($notif_count > 0)
                        <span class="badge bg-primary">{{ $notif_count }} Baru</span>
                    @endif
                </li>
                <li><hr class="dropdown-divider"></li>

                @forelse($recent_rekam_medis as $rekam)
                    <li>
                        <a class="dropdown-item"
                           href="{{ route('pemilik.rekam-medis.detail', $rekam->idrekam_medis) }}">
                            <div class="d-flex gap-3 py-2">
                                <div class="flex-shrink-0">
                                    <div style="width:40px;height:40px;background:#dcfce7;border-radius:50%;
                                        display:flex;align-items:center;justify-content:center;">
                                        <i class="fas fa-file-medical" style="color:#10b981;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">Rekam Medis Baru</div>
                                    <div class="small text-muted">
                                        {{ $rekam->pet->nama ?? '-' }} — {{ Str::limit($rekam->diagnosa, 30) }}
                                    </div>
                                    <div class="small text-muted">
                                        {{ $rekam->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    @if(!$loop->last)
                        <li><hr class="dropdown-divider"></li>
                    @endif
                @empty
                    <li>
                        <div class="dropdown-item text-center text-muted py-3">
                            <i class="fas fa-bell-slash fa-2x mb-2"></i>
                            <p class="mb-0">Tidak ada notifikasi</p>
                        </div>
                    </li>
                @endforelse

                @if($recent_rekam_medis->count() > 0)
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-center text-primary"
                           href="{{ route('pemilik.rekam-medis') }}">
                            <strong>Lihat Semua</strong>
                        </a>
                    </li>
                @endif
            </ul>
        </div>

        <!-- USER DROPDOWN -->
        <div class="user-dropdown">
            <div class="user-info" data-bs-toggle="dropdown">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->nama, 0, 2)) }}
                </div>
                <div class="user-details">
                    <div class="user-name">{{ Auth::user()->nama }}</div>
                    <div class="user-role">Pemilik Pet</div>
                </div>
                <i class="fas fa-chevron-down"></i>
            </div>

            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li class="dropdown-item-text">
                    <strong>{{ Auth::user()->nama }}</strong><br>
                    <small class="text-muted">{{ Auth::user()->email }}</small>
                </li>
                <li><hr class="dropdown-divider"></li>

                <li>
                    <a class="dropdown-item" href="{{ route('pemilik.profil') }}">
                        <i class="fas fa-user me-2"></i> Profil Saya
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('pemilik.pet') }}">
                        <i class="fas fa-dog me-2"></i> Pet Saya
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('pemilik.rekam-medis') }}">
                        <i class="fas fa-file-medical me-2"></i> Rekam Medis
                    </a>
                </li>

                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-danger"
                       href="#"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </li>
            </ul>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</div>


        <!-- User Dropdown -->
        <div class="user-dropdown">
            <div class="user-info" data-bs-toggle="dropdown" id="userDropdown">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->nama, 0, 2)) }}</div>
                <div class="user-details">
                    <div class="user-name">{{ Auth::user()->nama }}</div>
                    <div class="user-role">Pemilik Pet</div>
                </div>
                <i class="fas fa-chevron-down" style="color: #94a3b8; font-size: 0.75rem;"></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li>
                    <div class="dropdown-item-text">
                        <div class="d-flex align-items-center gap-2">
                            <div class="user-avatar" style="width: 48px; height: 48px;">
                                {{ strtoupper(substr(Auth::user()->nama, 0, 2)) }}
                            </div>
                            <div>
                                <div class="fw-bold">{{ Auth::user()->nama }}</div>
                                <div class="small text-muted">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                    </div>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="{{ route('pemilik.profil') }}">
                        <i class="fas fa-user me-2"></i> Profil Saya
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('pemilik.pet') }}">
                        <i class="fas fa-dog me-2"></i> Pet Saya
                        @if(Auth::user()->pemilik)
                        <span class="badge bg-success float-end">{{ Auth::user()->pemilik->pets->count() }}</span>
                        @endif
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('pemilik.rekam-medis') }}">
                        <i class="fas fa-file-medical me-2"></i> Rekam Medis
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-nav').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </li>
            </ul>

            <form id="logout-form-nav" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</div>

<style>
/* Notification Animation */
@keyframes bellShake {
    0%, 100% { transform: rotate(0deg); }
    10%, 30%, 50%, 70%, 90% { transform: rotate(-10deg); }
    20%, 40%, 60%, 80% { transform: rotate(10deg); }
}

.notification-btn:hover .fa-bell {
    animation: bellShake 0.5s ease;
}

/* Badge pulse animation */
@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.notification-badge {
    animation: pulse 2s infinite;
}

/* Dropdown animations */
.dropdown-menu {
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* User dropdown hover effect */
.user-info:hover .user-avatar {
    transform: scale(1.05);
    transition: transform 0.2s;
}

/* Notification item hover */
.dropdown-item {
    transition: all 0.2s;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    padding-left: 1.5rem;
}

/* Custom scrollbar for notifications */
.dropdown-menu::-webkit-scrollbar {
    width: 6px;
}

.dropdown-menu::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.dropdown-menu::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 3px;
}

.dropdown-menu::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .user-details {
        display: none;
    }
    
    .dropdown-menu {
        width: 300px !important;
    }
}
</style>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('active');
}

// Mark notification as read on click
document.addEventListener('DOMContentLoaded', function() {
    const notifItems = document.querySelectorAll('#notificationDropdown + .dropdown-menu .dropdown-item');
    
    notifItems.forEach(item => {
        item.addEventListener('click', function() {
            // Add logic to mark as read
            this.style.opacity = '0.7';
        });
    });
});

// Auto refresh notification count every 30 seconds
setInterval(function() {
    // Add AJAX call to refresh notification count
    // fetch('/pemilik/notifications/count')
    //     .then(response => response.json())
    //     .then(data => {
    //         // Update badge
    //     });
}, 30000);
</script>