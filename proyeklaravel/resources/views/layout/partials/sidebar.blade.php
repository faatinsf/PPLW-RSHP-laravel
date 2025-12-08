<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!-- Sidebar Brand -->
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <img src="{{ asset('assets/img/AdminLTELogo.png') }}" 
                 alt="RSHP Logo" 
                 class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">RSHP Unair</span>
        </a>
    </div>
    
    <!-- Sidebar Wrapper -->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" 
                data-lte-toggle="treeview" 
                role="navigation" 
                aria-label="Main navigation">
                
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                
                <!-- Data Master -->
                <li class="nav-item {{ request()->is('admin/jenishewan*', 'admin/rashewan*', 'admin/kategori*', 'admin/kodetindakanterapi*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/jenishewan*', 'admin/rashewan*', 'admin/kategori*', 'admin/kodetindakanterapi*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-database-fill"></i>
                        <p>
                            Data Master
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('jenis-hewan.index') }}" 
                               class="nav-link {{ request()->routeIs('admin.jenis-hewan.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle-fill"></i>
                                <p>Jenis Hewan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('rashewan.index') }}" 
                               class="nav-link {{ request()->routeIs('admin.rashewan.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle-fill"></i>
                                <p>Ras Hewan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('kategori.index') }}" 
                               class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle-fill"></i>
                                <p>Kategori</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('kategoriklinis.index') }}" 
                               class="nav-link {{ request()->routeIs('admin.kategoriklinis.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle-fill"></i>
                                <p>Kategori Klinis</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('kodetindakanterapi.index') }}" 
                               class="nav-link {{ request()->routeIs('admin.kodetindakanterapi.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle-fill"></i>
                                <p>Kode Tindakan Terapi</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Data Pemilik & Pet -->
                <li class="nav-item {{ request()->is('admin/pemilik*', 'admin/pet*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/pemilik*', 'admin/pet*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-hearts"></i>
                        <p>
                            Data Pemilik & Pet
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('pemilik.index') }}" 
                               class="nav-link {{ request()->routeIs('admin.pemilik.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle-fill"></i>
                                <p>Data Pemilik</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pet.index') }}" 
                               class="nav-link {{ request()->routeIs('admin.pet.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle-fill"></i>
                                <p>Data Pet</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Rekam Medis -->
                <li class="nav-item {{ request()->is('admin/rekammedis*', 'admin/detailrekammedis*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/rekammedis*', 'admin/detailrekammedis*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-file-medical-fill"></i>
                        <p>
                            Rekam Medis
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('rekammedis.index') }}" 
                               class="nav-link {{ request()->routeIs('admin.rekammedis.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle-fill"></i>
                                <p>Rekam Medis</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('detailrekammedis.index') }}" 
                               class="nav-link {{ request()->routeIs('admin.detailrekammedis.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle-fill"></i>
                                <p>Detail Rekam Medis</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Management User -->
                <li class="nav-item {{ request()->is('admin/user*', 'admin/role*', 'admin/roleuser*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/user*', 'admin/role*', 'admin/roleuser*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>
                            Management User
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.index') }}" 
                               class="nav-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle-fill"></i>
                                <p>Data User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('role.index') }}" 
                               class="nav-link {{ request()->routeIs('admin.role.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle-fill"></i>
                                <p>Data Role</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('roleuser.index') }}" 
                               class="nav-link {{ request()->routeIs('admin.roleuser.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle-fill"></i>
                                <p>Role User</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Divider -->
                <li class="nav-header">SISTEM</li>
                
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
                
            </ul>
        </nav>
    </div>
</aside>