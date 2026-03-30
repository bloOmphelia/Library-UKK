@extends('student.layouts.app')

@section('title', 'Update Profile - SmartLib')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/student/profile/index.css') }}">
@endpush

@section('content')
<div class="container-fluid px-4 py-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="profile-update-card" data-aos="fade-up">
                <div class="profile-header-accent">
                    <h5 class="mb-0 fw-bold text-center">
                        <i class="fas fa-user-edit me-2"></i> Perbarui Informasi Profil
                    </h5>
                </div>

                <div class="card-body p-4 p-lg-5">
                    <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="text-center mb-5">
                            <div class="profile-upload-wrapper">
                                <div class="profile-preview-container" id="profileContainer">
                                    @if(auth()->user()->photo)
                                        <img id="previewImg" src="{{ asset('storage/'.auth()->user()->photo) }}" alt="Profil">
                                    @else
                                        <i class="bi bi-person-fill no-profile-icon"></i>
                                    @endif
                                </div>
                                <label for="photo" class="btn-upload-icon">
                                    <i class="bi bi-camera"></i>
                                </label>
                                <input type="file" name="photo" id="photo" class="d-none" accept="image/*" onchange="previewFile(this)">
                            </div>
                            <h6 style="color: #1e1e1e; font-weight: 700; margin-bottom: 0;">Foto Profil</h6>
                            <p class="text-muted small">Format: JPG, PNG, WEBP (Maks. 2MB)</p>
                            @error('photo') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" placeholder="Nama Anda">
                                @error('name') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', auth()->user()->phone_number) }}" placeholder="08xxxx">
                                @error('phone_number') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="gender" class="form-select">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-laki" {{ (old('gender') ?? auth()->user()->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ (old('gender') ?? auth()->user()->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Kelas</label>
                                <input type="text" name="class" class="form-control" value="{{ old('class', auth()->user()->class) }}" placeholder="Contoh: XII RPL 1">
                                @error('class') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 mb-5">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea name="address" class="form-control" rows="3" placeholder="Masukkan alamat lengkap">{{ old('address', auth()->user()->address) }}</textarea>
                                @error('address') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-5 mx-auto text-center">
                                <button type="submit" class="btn-update-profile">
                                    SIMPAN PERUBAHAN <i class="bi bi-check-circle ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var container = document.getElementById('profileContainer');
                container.innerHTML = '<img id="previewImg" src="' + e.target.result + '" alt="Preview">';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush