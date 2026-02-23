<style>
    /* NAVBAR */
.navbar-custom {
    height: 70px;
    background: white;
    padding: 0 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

/* LEFT */
.navbar-left h4 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
}

/* PROFILE */
.navbar-profile {
    position: relative;
}

.profile-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    background: none;
    border: none;
    cursor: pointer;
}

.profile-btn img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.profile-btn span {
    font-size: 14px;
    font-weight: 500;
}

/* DROPDOWN */
.profile-dropdown {
    position: absolute;
    top: 55px;
    right: 0;
    width: 180px;
    background: white;
    border-radius: 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.12);
    opacity: 0;
    transform: translateY(-10px);
    pointer-events: none;
    transition: all 0.2s ease;
}

.navbar-profile:hover .profile-dropdown {
    opacity: 1;
    transform: translateY(0);
    pointer-events: auto;
}

.profile-dropdown a,
.profile-dropdown button {
    width: 100%;
    padding: 12px 16px;
    display: flex;
    align-items: center;
    gap: 10px;
    border: none;
    background: none;
    text-decoration: none;
    color: #333;
    cursor: pointer;
}

.profile-dropdown a:hover,
.profile-dropdown button:hover {
    background: #f5f5f5;
}

</style>

<nav class="navbar-custom">
    
    <!-- LEFT -->
    <div class="navbar-left">
      <div class="search"></div>
    </div>

    <!-- RIGHT -->
    <div class="navbar-profile">
        <button class="profile-btn">
            <img src="{{ asset('images/no-profile.jpeg') }}" alt="profile">
            <span>{{ Auth::user()->name }}</span>
            <i class="bi bi-chevron-down"></i>
        </button>

        <div class="profile-dropdown">
            <a href="#">
                <i class="bi bi-person"></i>
                Profile
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">
                    <i class="bi bi-box-arrow-right"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>

</nav>
