@extends('auth.layouts.app')

@section('title', 'Register - SmartLib')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/auth/register.css') }}">
@endpush

@section('content')
<div class="auth-container">

    <div class="register-card" data-aos="zoom-in">
        <div style="text-align: center; margin-bottom: 25px;">
            <h2 style="color: #40487A; font-weight: 800; font-size: 28px; margin-bottom: 5px;">Buat Akun</h2>
            <p style="color: #6B7280; font-size: 14px;">Mulai perjalananmu bersama SmartLib hari ini.</p>
        </div>

        <form method="POST" action="/register" novalidate>
            @csrf

            <div class="form-grid">

                <div class="form-group" data-aos="fade-up">
                    <label class="input-label">Nama</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        placeholder="Masukkan nama" value="{{ old('name') }}" autofocus>
                    @error('name')
                        <small style="color: #ff4d4d; margin-left: 5px;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group" data-aos="fade-up">
                    <label class="input-label">NIS (Nomor Induk Siswa)</label>
                    <input type="text"
                        name="nis"
                        inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                        maxlength="10"
                        class="form-control @error('nis') is-invalid @enderror"
                        placeholder="Contoh: 0012345678"
                        value="{{ old('nis') }}"
                        required>
                    @error('nis')
                        <small style="color: #ff4d4d;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group full-width" data-aos="fade-up" data-aos-delay="50">
                    <label class="input-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        placeholder="Masukkan Email" value="{{ old('email') }}">
                    @error('email')
                        <small style="color: #ff4d4d; margin-left: 5px;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-delay="100">
                    <label class="input-label">Password</label>
                    <div style="position: relative;">
                        <input type="password" id="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="••••••••••">
                        <span class="toggle-pass" data-target="password" 
                            style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); font-size: 18px; color: #ad9a79; cursor: pointer;">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                    @error('password')
                        <small style="color: #ff4d4d; margin-left: 5px;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-delay="150">
                    <label class="input-label">Konfirmasi Password</label>
                    <div style="position: relative;">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control"
                            placeholder="••••••••••">
                        <span class="toggle-pass" data-target="password" 
                            style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); font-size: 18px; color: #ad9a79; cursor: pointer;">
                            <i class="bi bi-eye"></i> 
                        </span>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-register">Daftar</button>

            <div style="display: flex; align-items: center; margin: 25px 0; color: #BDBDBD; font-size: 12px;">
                <div style="flex: 1; border-top: 1px solid #E3EFFF;"></div>
                <span style="padding: 0 15px;">ATAU</span>
                <div style="flex: 1; border-top: 1px solid #E3EFFF;"></div>
            </div>

            <div style="text-align: center; font-size: 13px; color: #40487A;">
                Sudah punya akun?
                <a href="{{ route('login') }}" style="color: #ad9a79; text-decoration: none; font-weight: 700;">Login</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    @include('auth.scripts.register')
@endpush