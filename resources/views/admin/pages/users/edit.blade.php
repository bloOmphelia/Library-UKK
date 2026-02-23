@extends('admin.layouts.app')

@section('title', 'Edit Anggota Student')

@section('content')
<div class="manage-users-page">

    <h2>Edit Anggota (Student)</h2>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label>Password (Opsional)</label>
            <input type="password" name="password" placeholder="Kosongkan jika tidak diganti">
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div style="margin-top:20px;">
            <button type="submit" class="btn btn-primary">
                Update
            </button>

            <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                Batal
            </a>
        </div>
    </form>

</div>
@endsection
