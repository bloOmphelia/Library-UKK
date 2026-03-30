@extends('admin.layouts.app')

@section('title', 'Edit Anggota Student')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/users/edit-users.css') }}">
@endpush

@section('content')

<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="edit-card">

                <div class="edit-header-accent">
                    <h5 class="mb-0 text-center" style="font-weight: 700; letter-spacing: 1px;">
                        <i class="bi bi-person-gear me-2"></i> EDIT DATA ANGGOTA
                    </h5>
                </div>

                <div class="card-body p-4 p-lg-5">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">NIS (Nomor Induk Siswa)</label>
                                <input type="text" name="nis"
                                    class="form-control @error('nis') is-invalid @enderror"
                                    value="{{ old('nis', $user->nis) }}"
                                    placeholder="Masukkan 10 digit NIS" required>
                                @error('nis') 
                                    <div class="invalid-feedback">{{ $message }}</div> 
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}"
                                    placeholder="Nama lengkap" required>
                                @error('name') 
                                    <div class="invalid-feedback">{{ $message }}</div> 
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Alamat Email</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}"
                                    placeholder="email@example.com" required>
                                @error('email') 
                                    <div class="invalid-feedback">{{ $message }}</div> 
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">
                                    Password Baru
                                    <span class="text-muted fw-normal" style="text-transform: none; font-size: 11px;">(Biarkan kosong jika tidak diganti)</span>
                                </label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Minimal 8 karakter">
                                @error('password') 
                                    <div class="invalid-feedback">{{ $message }}</div> 
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="text" name="phone_number"
                                    class="form-control @error('phone_number') is-invalid @enderror"
                                    value="{{ old('phone_number', $user->phone_number) }}"
                                    placeholder="08xxxx">
                                @error('phone_number') 
                                    <div class="invalid-feedback">{{ $message }}</div> 
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Kelas / Divisi</label>
                                <input type="text" name="class"
                                    class="form-control @error('class') is-invalid @enderror"
                                    value="{{ old('class', $user->class) }}"
                                    placeholder="Contoh: XII RPL 1">
                                @error('class') 
                                    <div class="invalid-feedback">{{ $message }}</div> 
                                @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="gender" class="form-select @error('gender') is-invalid @enderror" style="border-radius: 8px;">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-laki" {{ old('gender', $user->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('gender', $user->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender') 
                                    <div class="invalid-feedback">{{ $message }}</div> 
                                @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea name="address" rows="3"
                                    class="form-control @error('address') is-invalid @enderror"
                                    placeholder="Masukkan alamat lengkap">{{ old('address', $user->address) }}</textarea>
                                @error('address') 
                                    <div class="invalid-feedback">{{ $message }}</div> 
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-3 g-3 justify-content-center">
                            <div class="col-lg-4">
                                <button type="submit" class="btn-save">
                                    UPDATE DATA <i class="bi bi-arrow-repeat ms-2"></i>
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