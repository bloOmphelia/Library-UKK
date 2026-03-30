<link rel="stylesheet" href="{{ asset('assets/css/student/navbar.css') }}">

<nav class="navbar-custom">
    <div class="nav-right" style="margin-left: auto;">
        <div class="notification-box">
    <i class="bi bi-bell"></i>
   
    @if(auth()->user()->unreadNotifications->count() > 0)
        <span class="badge-notif">{{ auth()->user()->unreadNotifications->count() }}</span>
    @endif

    <div class="notif-dropdown">
        <div class="notif-header">
            <h6>Notifikasi</h6>
            @if(auth()->user()->unreadNotifications->count() > 0)
                <a href="{{ route('mark-notifications-read') }}" style="font-size: 11px; text-decoration: none; color: #8b8564;">Tandai dibaca</a>
            @endif
        </div>
        <hr style="margin: 10px 0;">

        <div class="notif-list" style="max-height: 300px; overflow-y: auto;">
            @forelse(auth()->user()->notifications->take(5) as $notification)
                <div class="notif-item {{ $notification->read_at ? 'opacity-50' : '' }}">
                    <i class="bi {{ $notification->data['icon'] }} text-{{ $notification->data['type'] }}"></i>
                    <div class="notif-content">
                        <p>{{ $notification->data['message'] }}</p>
                        <small>{{ $notification->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            @empty
                <div class="text-center py-3">
                    <p class="text-muted small mb-0">Tidak ada notifikasi</p>
                </div>
            @endforelse
        </div>
        
        <hr style="margin: 10px 0;">
        <a href="{{ route('student.transactions') }}" class="d-block text-center small" style="text-decoration: none; color: #1E293B; font-weight: 600;">Lihat Semua Transaksi</a>
    </div>
</div>

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
                <a href="{{ route('student.profile') }}">
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