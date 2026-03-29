@extends('auth.layouts.app')

@section('title', 'Lengkapi Profil - SmartLib')

@push('styles')
{{-- Menggunakan file CSS yang sama dengan login agar style-nya konsisten --}}
<link rel="stylesheet" href="{{ asset('assets/css/auth/login.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/auth/complete-register.css') }}">
@endpush

@section('content')
<div class="auth-container">
    {{-- Background Decorations (Sama dengan Login) --}}
    <img src="{{ asset('images/wave.svg') }}" class="bg-wave" alt="">

    {{-- Profile Card --}}
    <div class="login-card" data-aos="zoom-in">
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="color: #40487A; font-weight: 800; font-size: 28px; margin-bottom: 10px;">Data Diri</h2>
            <p style="color: #6B7280; font-size: 14px;">Halo <strong>{{ $user->name }}</strong>,<br> Ayo lengkapi profilmu!</p>
        </div>

        <form action="{{ route('register.update') }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Kelas --}}
            <div class="form-group-custom" data-aos="fade-up">
                <input type="text" name="class" class="form-control" placeholder="Kelas (Contoh: XII RPL 1)" value="{{ old('class') }}">
                @error('class') <small style="color: #ff4d4d; margin-left: 10px;">{{ $message }}</small> @enderror
            </div>

            {{-- No Telepon --}}
            <div class="form-group-custom" data-aos="fade-up" data-aos-delay="50">
                <label class="input-label">Nomor Telepon</label>
                <div style="display: flex; gap: 8px;">
                    <div class="phone-prefix">+62</div>
                    <input type="text" name="phone_number" class="form-control" placeholder="812345678" value="{{ old('phone_number') }}" style="flex: 1;">
                </div>
                @error('phone_number') <small style="color: #ff4d4d; margin-left: 10px;">{{ $message }}</small> @enderror
            </div>

            {{-- Jenis Kelamin --}}
            <div class="form-group-custom" data-aos="fade-up" data-aos-delay="200">
                <select name="gender" class="form-select" style="width: 100%;">
                    <option value="" selected disabled>Pilih Jenis Kelamin</option>
                    <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('gender') <small style="color: #ff4d4d; margin-left: 10px;">{{ $message }}</small> @enderror
            </div>

            {{-- Alamat --}}
            <div class="form-group-custom" data-aos="fade-up" data-aos-delay="300">
                <textarea name="address" class="form-control" rows="2" placeholder="Alamat Lengkap">{{ old('address') }}</textarea>
                @error('address') <small style="color: #ff4d4d; margin-left: 10px;">{{ $message }}</small> @enderror
            </div>

            {{-- Button --}}
            <button type="submit" name="action" value="save" class="btn-login" style="margin-top: 10px;" data-aos="fade-up" data-aos-delay="200">
                Simpan & Lanjutkan
            </button>

            <div style="display: flex; align-items: center; margin: 25px 0; color: #BDBDBD; font-size: 12px;">
                <div style="flex: 1; border-top: 1px solid #E3EFFF;"></div>
                <span style="padding: 0 15px; text-transform: uppercase; letter-spacing: 1px;">ATAU</span>
                <div style="flex: 1; border-top: 1px solid #E3EFFF;"></div>
            </div>

           <div style="text-align: center;">
                <button type="submit" name="action" value="skip" 
                    style="background: none; border: none; padding: 0; color: #ad9a79; text-decoration: none; font-weight: 700; cursor: pointer; font-size: 14px; transition: 0.3s;"
                    onmouseover="this.style.color='#8e7d5f'" onmouseout="this.style.color='#ad9a79'">
                    Nanti Saja
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
