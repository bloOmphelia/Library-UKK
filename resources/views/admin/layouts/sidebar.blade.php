<link rel="stylesheet" href="{{ asset('assets/css/admin/sidebar.css') }}">

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-box">
            <i class="bi bi-layers-half"></i>
        </div>
        <p class="brand-name">SmartLib</p>
    </div>

    <nav class="sidebar-menu">
        <a href="{{ route('admin.dashboard') }}"
           class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-fill"></i>
            <p>Dashboard</p>
        </a>

        <a href="{{ route('admin.category') }}"
           class="menu-item {{ request()->routeIs('admin.category') ? 'active' : '' }}">
            <i class="bi bi-collection-fill"></i>
            <p>Kategori</p>
        </a>

        <a href="{{ route('admin.books') }}"
           class="menu-item {{ request()->routeIs('admin.books') ? 'active' : '' }}">
            <i class="bi bi-journal-bookmark-fill"></i>
            <p>Kelola Buku</p>
        </a>

        <a href="{{ route('admin.transactions') }}"
           class="menu-item {{ request()->routeIs('admin.transactions') ? 'active' : '' }}">
            <i class="bi bi-arrow-down-up"></i>
            <p>Transaksi</p>
        </a>

        <a href="{{ route('admin.users') }}"
           class="menu-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i>
            <p>Kelola Anggota</p>
        </a>

        <a href="{{ route('admin.profile') }}"
           class="menu-item {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i>
            <p>Profile</p>
        </a>
    </nav>

    {{-- <div class="logout-section">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="bi bi-box-arrow-right"></i>
                <p>Log out</p>
            </button>
        </form>
    </div> --}}
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