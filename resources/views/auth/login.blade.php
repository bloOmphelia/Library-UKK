@extends('auth.layouts.app')

@section('title', 'Login - SmartLib')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/auth/login.css') }}">
@endpush

@section('content')
<div class="auth-container">
    
    <div class="login-card" data-aos="zoom-in">
        <div style="text-align: center; margin-bottom: 35px;">
            <h2 style="color: #40487A; font-weight: 800; font-size: 24px; margin-bottom: 10px;">Selamat Datang Kembali!</h2>
            <p style="color: #6B7280; font-size: 14px;">Akses ilmu dengan cara yang lebih pintar.</p>
        </div>

        <form method="POST" action="/login" novalidate>
            @csrf

            <div class="form-group" data-aos="fade-up">
                <label class="input-label">Email</label>
                <input type="email" name="email" class="form-control" 
                    placeholder="Masukkan Email" 
                    value="{{ session('autofill_email') ?? old('email') }}">
                    @error('email')
                        <small style="color: #ff4d4d; margin-left: 5px;">{{ $message }}</small>
                    @enderror
            </div>

            <div class="form-group" data-aos="fade-up">
                <label class="input-label">Password</label>
                <div style="position: relative;">
                    <input type="password" id="password" name="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        placeholder="••••••••••">
                    <span class="toggle-pass" data-target="password" 
                        style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); font-size: 16px; color: #ad9a79; cursor: pointer;">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </span>
                </div>
                @error('password')
                    <small style="color: #ff4d4d; margin-left: 5px; display: block; margin-top: 5px;">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn-login" style="margin-top: 30px;" data-aos="fade-up">Masuk</button>

            <div style="display: flex; align-items: center; margin: 30px 0; color: #BDBDBD; font-size: 12px;">
                <div style="flex: 1; border-top: 1px solid #E3EFFF;"></div>
                <span style="padding: 0 15px; text-transform: uppercase; letter-spacing: 1px;">ATAU</span>
                <div style="flex: 1; border-top: 1px solid #E3EFFF;"></div>
            </div>

            <div style="text-align: center; font-size: 13px; color: #40487A;">
                Belum punya akun? 
                <a href="{{ route('register') }}" style="color: #ad9a79; text-decoration: none; font-weight: 700;">Daftar</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    @include('auth.scripts.login')
@endpush