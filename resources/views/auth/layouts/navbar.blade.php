<style>
.auth-navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    padding: 20px 60px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 100;
}

.nav-left {
    align-items: center;
    gap: 10px;
    font-size: 22px;
    font-weight: 800;
    color: #40487A;
}

.nav-right {
    display: flex;
    align-items: center;
    gap: 15px;
}

/* Button Sign Up (mirip referensi) */
.btn-signup {
    padding: 10px 18px;
    border-radius: 10px;
    border: 1px solid #E892C0;
    background: transparent;
    color: #E892C0;
    font-weight: 600;
    cursor: pointer;
    transition: .3s;
}

.btn-signup:hover {
    background: #E892C0;
    color: white;
}
</style>

<div class="auth-navbar">
    <div class="nav-left">
        <img src="{{ asset('images/logo.png') }}" class="logo" style="width: 40px;" alt="">
        SmartLib
    </div>

    <div class="nav-right">
        <button class="btn-signup" onclick="window.location='{{ route('register') }}'">
            Sign Up
        </button>
    </div>
</div>
