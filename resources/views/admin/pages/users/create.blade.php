@extends('admin.layouts.app')

@section('title', 'Tambah Anggota Student')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/users/create-users.css') }}">
@endpush

@section('content')

<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="edit-card">

                <div class="edit-header-accent">
                    <h5 class="mb-0 text-center" style="font-weight: 700; letter-spacing: 1px;">
                        <i class="bi bi-person-plus-fill me-2"></i> TAMBAH ANGGOTA BARU
                    </h5>
                </div>

                <div class="card-body p-4 p-lg-5">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            {{-- Field NIS --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label">NIS (Nomor Induk Siswa) <span class="text-danger">*</span></label>
                                <input type="text" name="nis"
                                    class="form-control @error('nis') is-invalid @enderror"
                                    value="{{ old('nis') }}"
                                    placeholder="Masukkan NIS">
                                @error('nis') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}"
                                    placeholder="Masukkan nama lengkap">
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Alamat Email <span class="text-danger">*</span></label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                    placeholder="contoh@mail.com" >
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                                <input type="text" name="phone_number"
                                    class="form-control @error('phone_number') is-invalid @enderror"
                                    value="{{ old('phone_number') }}"
                                    placeholder="08xxxxxxxxxx">
                                @error('phone_number') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Kata Sandi<span class="text-danger">*</span></label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Minimal 8 karakter" >
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Konfirmasi Sandi <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation"
                                    class="form-control"
                                    placeholder="Ulangi kata sandi" >
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Kelas <span class="text-danger">*</span></label>
                                <input type="text" name="class"
                                    class="form-control @error('class') is-invalid @enderror"
                                    value="{{ old('class') }}"
                                    placeholder="Contoh: XII RPL 1">
                                @error('class') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea name="address" rows="3"
                                    class="form-control @error('address') is-invalid @enderror"
                                    placeholder="Masukkan alamat tinggal saat ini">{{ old('address') }}</textarea>
                                @error('address') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row mt-3 g-3 justify-content-center">
                            <div class="col-lg-4">
                                <button type="submit" class="btn-save">
                                    SIMPAN DATA <i class="bi bi-check-circle-fill ms-2"></i>
                                </button>
                            </div>
                            <div class="col-lg-4">
                                <a href="{{ route('admin.users') }}" class="btn-cancel">
                                    BATAL
                                </a>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection