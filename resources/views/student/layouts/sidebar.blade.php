<style>

.sidebar {
    width: 85px;
    background: rgba(255, 255, 255, 0.5);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    padding: 30px 12px;
    position: fixed;
    left: 0;
    top: 0;
    height: 100vh;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    box-shadow: 4px 0 12px rgba(64, 72, 122, 0.06);
    border-right: 1px solid rgba(255, 255, 255, 0.5);
    transition: width 0.3s ease; 
}

.sidebar:hover {
    width: 250px;
}

.sidebar-logo {
    display: flex;s
    align-items: center;
    gap: 16px;
    margin-bottom: 40px;
    padding: 0 10px;
}

.logo-box {
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, #AC7FF6, #E892C0);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
    box-shadow: 0 4px 10px rgba(172, 127, 246, 0.2);
}

.brand-name {
    opacity: 0;
    white-space: nowrap;
    font-weight: 800;
    color: #40487A;
    font-size: 1.4rem;
    margin: 0;
    transition: opacity 0.2s ease;
}

.sidebar:hover .brand-name {
    opacity: 1;
}

.sidebar-menu {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.menu-item {
    display: flex;
    align-items: center;
    padding: 14px 16px;
    border-radius: 16px;
    color: #64748b;
    text-decoration: none;
    white-space: nowrap;
    transition: background-color 0.2s, color 0.2s;
}

.menu-item i {
    min-width: 24px;
    font-size: 20px;
    text-align: center;
}

.menu-item p {
    margin: 0 0 0 14px;
    font-weight: 600;
    font-size: 14px;
    opacity: 0;
    transition: opacity 0.2s ease;
}

.sidebar:hover .menu-item p {
    opacity: 1;
}

.menu-item:hover {
    background: rgba(172, 127, 246, 0.08);
    color: #AC7FF6;
}

.menu-item.active {
    background: #40487A;
    color: white !important;
}

.logout-section {
    margin-top: auto;
    padding-top: 20px;
}

.btn-logout {
    background: none;
    border: none;
    width: 100%;
    display: flex;
    align-items: center;
    padding: 14px 16px;
    border-radius: 16px;
    color: #e5547d;
    cursor: pointer;
    transition: background-color 0.2s;
}

.btn-logout i {
    min-width: 24px;
    font-size: 20px;
    text-align: center;
}

.btn-logout p {
    margin: 0 0 0 14px;
    font-weight: 600;
    font-size: 14px;
    opacity: 0;
    transition: opacity 0.2s ease;
}

.sidebar:hover .btn-logout p {
    opacity: 1;
}

.btn-logout:hover {
    background: rgba(229, 84, 125, 0.08);
}

/* ===== KONTEN UTAMA ===== */
.main-content {
    margin-left: 100px;
    padding: 30px;
    transition: margin-left 0.3s ease;
}

</style>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-box">
            <i class="bi bi-layers-half"></i>
        </div>
        <p class="brand-name">SmartLib</p>
    </div>

    <nav class="sidebar-menu">
        <a href="{{ route('student.dashboard') }}"
           class="menu-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i>
            <p>Dashboard</p>
        </a>

        <a href="{{ route('student.books') }}"
           class="menu-item {{ request()->routeIs('student.books') ? 'active' : '' }}">
            <i class="bi bi-journals"></i>
            <p>Daftar Buku</p>
        </a>

        <a href="{{ route('student.transactions') }}"
           class="menu-item {{ request()->routeIs('student.transactions') ? 'active' : '' }}">
            <i class="bi bi-arrow-down-up"></i>
            <p>Pengembalian</p>
        </a>
    </nav>

    <div class="logout-section">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="bi bi-box-arrow-right"></i>
                <p>Logout</p>
            </button>
        </form>
    </div>

</aside>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    if (!sidebar || !mainContent) return;

    sidebar.addEventListener('mouseenter', () => {
        mainContent.style.marginLeft = '270px';
    });
    sidebar.addEventListener('mouseleave', () => {
        mainContent.style.marginLeft = '100px';
    });
});
</script>