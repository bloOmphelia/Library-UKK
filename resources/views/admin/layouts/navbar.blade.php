<link rel="stylesheet" href="{{ asset('assets/css/admin/navbar.css') }}">

<nav class="navbar-custom">
    <div class="nav-right" style="margin-left: auto;">
        {{-- <div class="notification-box">
            <i class="bi bi-bell"></i>
        
        </div> --}}

        <div class="profile-container">
            <div class="profile-trigger">
                @if(Auth::user()->photo)
                    <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="User Profile">
                @else
                    <img src="{{ asset('images/no-profile.jpeg') }}" alt="Default Profile">
                @endif

                <div class="profile-info">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <i class="bi bi-chevron-down"></i>
                </div>
            </div>

            <div class="profile-dropdown">
                <a href="{{ route('admin.profile') }}">
                    <i class="bi bi-person"></i> Profile
                </a>
                <hr>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-link">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>