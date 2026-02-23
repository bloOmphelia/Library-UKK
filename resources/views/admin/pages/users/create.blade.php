@extends('admin.layouts.app')

@section('title', 'Tambah Anggota Student')

@section('content')
<div class="manage-users-page">

    <h2>Tambah Anggota</h2>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div style="margin-top:20px;">
            <button type="submit" class="btn btn-primary">
                Simpan
            </button>

            <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                Batal
            </a>
        </div>
    </form>

</div>
@endsection
