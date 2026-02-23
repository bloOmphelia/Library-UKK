@extends('auth.layouts.app')

@section('title', 'Register - SmartLib')

@push('styles')
<style>
    .auth-container {
        display: flex; 
        align-items: center; 
        justify-content: center;
        width: 100%; 
        /* Ganti height jadi min-height supaya fleksibel kalau inputnya banyak */
        min-height: 100vh; 
        background-color: #E3EFFF;
        position: relative; 
        overflow-x: hidden;
        /* Tambahkan padding atas bawah agar card tidak mepet layar di HP/layar kecil */
        padding: 40px 20px;
    }
    
    .bg-wave { position: absolute; right: 0; bottom: 0; height: 70%; z-index: 1; pointer-events: none; }
    .bg-element { position: absolute; left: 3%; top: 20%; width: 25%; z-index: 1; opacity: 0.8; }
    .bg-log-img { position: absolute; right: 5%; bottom: 10%; width: 25%; z-index: 1; }

    .register-card {
        width: 100%; 
        max-width: 450px; 
        padding: 40px;
        background: rgba(255, 255, 255, 0.9); 
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(64, 72, 122, 0.1);
        z-index: 10; 
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.7);
    }

    .form-group { margin-bottom: 15px; text-align: left; }
    
    .input-label { 
        display: block; 
        font-size: 13px; 
        color: #40487A; 
        margin-bottom: 6px; 
        font-weight: 600; 
    }

    .form-control {
        width: 100%; padding: 12px 16px; border: 1.5px solid #E3EFFF;
        border-radius: 12px; font-size: 14px; background: #F8FAFF;
        outline: none; transition: 0.3s; box-sizing: border-box;
    }
    .form-control:focus { border-color: #AC7FF6; background: #fff; }

    .btn-register {
        width: 100%; padding: 14px; background-color: #AC7FF6; color: white;
        border: none; border-radius: 12px; font-size: 16px; font-weight: 700;
        cursor: pointer; transition: 0.3s; box-shadow: 0 10px 20px rgba(172, 127, 246, 0.2);
        margin-top: 15px;
    }
    .btn-register:hover { transform: translateY(-2px); box-shadow: 0 12px 24px rgba(172, 127, 246, 0.3); }

    /* Responsif untuk layar kecil/tablet agar gambar tidak menutupi form */
    @media (max-width: 1024px) {
        .bg-element, .bg-log-img { display: none; }
    }
</style>
@endpush

@section('content')
<div class="auth-container">
    {{-- Background Decorations --}}
    <img src="{{ asset('images/wave.svg') }}" class="bg-wave" alt="">
    <img src="{{ asset('images/element.svg') }}" class="bg-element" data-aos="fade-right">
    <img src="{{ asset('images/log.svg') }}" class="bg-log-img" data-aos="fade-left">

    {{-- Register Card --}}
    <div class="register-card" data-aos="zoom-in">
        <div style="text-align: center; margin-bottom: 25px;">
            <h2 style="color: #40487A; font-weight: 800; font-size: 28px; margin-bottom: 5px;">Create Account</h2>
            <p style="color: #6B7280; font-size: 14px;">Start your journey with SmartLib today.</p>
        </div>

        <form method="POST" action="/register">
            @csrf

            <div class="form-group" data-aos="fade-up">
                <label class="input-label">Username</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Username" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="form-group" data-aos="fade-up">
                <label class="input-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter Email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group" data-aos="fade-up">
                <label class="input-label">Password</label>
                <div style="position: relative;">
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••••••" required>
                    <span class="toggle-pass" data-target="password" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); font-size: 11px; color: #AC7FF6; cursor: pointer; font-weight: 700;">show</span>
                </div>
            </div>

            <div class="form-group" data-aos="fade-up">
                <label class="input-label">Confirmation Password</label>
                <div style="position: relative;">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="••••••••••" required>
                    <span class="toggle-pass" data-target="password_confirmation" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); font-size: 11px; color: #AC7FF6; cursor: pointer; font-weight: 700;">show</span>
                </div>
            </div>

            <button type="submit" class="btn-register" data-aos="fade-up">Register</button>

            <div style="display: flex; align-items: center; margin: 25px 0; color: #BDBDBD; font-size: 12px;">
                <div style="flex: 1; border-top: 1px solid #E3EFFF;"></div>
                <span style="padding: 0 15px;">OR</span>
                <div style="flex: 1; border-top: 1px solid #E3EFFF;"></div>
            </div>

            <div style="text-align: center; font-size: 13px; color: #40487A;">
                Already have an account? 
                <a href="{{ route('login') }}" style="color: #E892C0; text-decoration: none; font-weight: 700;">Login Here</a>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggles = document.querySelectorAll('.toggle-pass');

        toggles.forEach(function(toggle) {
            toggle.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);

                if (input.type === "password") {
                    input.type = "text";
                    this.textContent = "hide";
                } else {
                    input.type = "password";
                    this.textContent = "show";
                }
            });
        });
    });
</script>
@endpush
