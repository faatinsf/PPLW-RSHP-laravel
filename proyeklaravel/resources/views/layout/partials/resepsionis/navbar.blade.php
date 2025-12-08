<nav class="navbar">
    <div class="navbar-left">
        <button class="mobile-toggle" id="toggleSidebar">
            ☰
        </button>
        <h2 class="navbar-title">Dashboard Resepsionis</h2>
    </div>

    <div class="navbar-right">
        <span class="user-name">{{ Auth::user()->nama ?? 'User' }}</span>

        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</nav>

<style>
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 20px;
        background: white;
        border-bottom: 1px solid #e2e8f0;
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .navbar-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #0f172a;
    }

    .navbar-right {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .user-name {
        font-weight: 500;
        color: #334155;
    }

    .logout-btn {
        padding: 6px 14px;
        background: #ef4444;
        color: #fff;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.9rem;
    }

    .logout-btn:hover {
        background: #dc2626;
    }

    .mobile-toggle {
        font-size: 22px;
        border: none;
        background: transparent;
        cursor: pointer;
        display: none;
    }

    @media (max-width: 768px) {
        .mobile-toggle {
            display: block;
        }
    }
</style>

<script>
    document.getElementById('toggleSidebar')?.addEventListener('click', () => {
        document.querySelector('.sidebar')?.classList.toggle('active');
    });
</script>
