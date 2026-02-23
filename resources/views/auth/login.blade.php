@extends('auth.layouts.app')

@section('title', 'Login - SmartLib')

@push('styles')
<style>
    .auth-container {
        display: flex; align-items: center; justify-content: center;
        width: 100vw; height: 100vh; background-color: #E3EFFF;
        position: relative; overflow: hidden;
    }
    
    /* Background Elements */
    .bg-wave { position: absolute; right: 0; top: 200px; height: 100%; z-index: 1; }
    .bg-element { position: absolute; left: 3%; top: 1%; width: 28%; z-index: 1; opacity: 0.9; }
    .bg-log { position: absolute; right: 3%; top: 26%; width: 28%; z-index: 1; opacity: 0.9; }

    /* Card Style */
    .login-card {
        width: 100%; max-width: 420px; padding: 40px;
        background: rgba(255, 255, 255, 0.9); border-radius: 24px;
        box-shadow: 0 20px 40px rgba(64, 72, 122, 0.1);
        z-index: 10; backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.7);
    }

    .form-control {
        width: 100%; padding: 14px 20px; border: 1.5px solid #E3EFFF;
        border-radius: 12px; font-size: 14px; background: #F8FAFF;
        outline: none; transition: 0.3s;
    }
    .form-control:focus { border-color: #AC7FF6; box-shadow: 0 0 0 4px rgba(172, 127, 246, 0.1); }

    .btn-login {
        width: 100%; padding: 14px; background-color: #AC7FF6; color: white;
        border: none; border-radius: 12px; font-size: 16px; font-weight: 600;
        cursor: pointer; transition: 0.3s; box-shadow: 0 10px 20px rgba(172, 127, 246, 0.2);
    }
    .btn-login:hover { transform: translateY(-2px); box-shadow: 0 12px 24px rgba(172, 127, 246, 0.3); }
</style>
@endpush

@section('content')
<div class="auth-container">
    {{-- Background Decorations --}}
    <img src="{{ asset('images/wave.svg') }}" class="bg-wave" alt="">
    <img src="{{ asset('images/element.svg') }}" class="bg-element" data-aos="fade-right">
    <img src="{{ asset('images/log.svg') }}" class="bg-log" data-aos="fade-left">

    {{-- Login Card --}}
    <div class="login-card" data-aos="zoom-in">
        <div style="text-align: center; margin-bottom: 35px;">
            <h2 style="color: #40487A; font-weight: 800; font-size: 28px; margin-bottom: 10px;">Welcome Back!</h2>
            <p style="color: #6B7280; font-size: 14px;">Your library, simplified<br> Access knowledge smarter.</p>
        </div>

        <form method="POST" action="/login">
            @csrf

            <div style="margin-bottom: 20px;" data-aos="fade-up">
                <input type="email" name="email" class="form-control" placeholder="Email Address" 
                       value="{{ old('email') }}" required autofocus>
            </div>

            <div style="margin-bottom: 10px; position: relative;" data-aos="fade-up">
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                <span id="togglePassword" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); font-size: 12px; color: #AC7FF6; cursor: pointer; font-weight: 700;">
                    show
                </span>
            </div>

            <button type="submit" class="btn-login" style="margin-top: 30px;" data-aos="fade-up">Sign in</button>

            <div style="display: flex; align-items: center; margin: 30px 0; color: #BDBDBD; font-size: 12px;">
                <div style="flex: 1; border-top: 1px solid #E3EFFF;"></div>
                <span style="padding: 0 15px; text-transform: uppercase; letter-spacing: 1px;">OR</span>
                <div style="flex: 1; border-top: 1px solid #E3EFFF;"></div>
            </div>

            <div style="text-align: center; font-size: 13px; color: #40487A;">
                Don't have an account? 
                <a href="{{ route('register') }}" style="color: #E892C0; text-decoration: none; font-weight: 700;">Request Access</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Fitur toggle password sederhana
    $('#togglePassword').on('click', function() {
        const passInput = $('#password');
        const type = passInput.attr('type') === 'password' ? 'text' : 'password';
        passInput.attr('type', type);
        $(this).text(type === 'password' ? 'show' : 'hide');
    });
</script>
@endpush