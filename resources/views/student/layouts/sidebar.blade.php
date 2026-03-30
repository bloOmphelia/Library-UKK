
<link rel="stylesheet" href="{{ asset('assets/css/student/sidebar.css') }}">


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
            <p>Koleksi Buku</p>
        </a>

        <a href="{{ route('student.transactions') }}"
           class="menu-item {{ request()->routeIs('student.transactions') ? 'active' : '' }}">
            <i class="bi bi-arrow-down-up"></i>
            <p>Pengembalian</p>
        </a>

        <a href="{{ route('student.profile') }}"
           class="menu-item {{ request()->routeIs('student.profile') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i>
            <p>Profile</p>
        </a>
    </nav>

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