@extends('admin.layouts.app')

@section('title', 'Transaction')

@section('content')
<div class="manage-users-page">

    <h2>Tambah Transaksi</h2>

    <form action="{{ route('admin.transactions.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Nama Buku</label>
            <select name="book_id" required>
                <option value="">Pilih Buku</option>
                @foreach ($books as $book)
                    <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                        {{ $book->title }}
                    </option>
                @endforeach
            </select>
            @error('book_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label>Nama User</label>
            <select name="user_id" required>
                <option value="">Pilih User</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            @error('user_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label>Tanggal Pinjam</label>
            <input type="date" name="borrowed_at" value="{{ old('borrowed_at') }}" required>
            @error('borrowed_at') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label>Tanggal Kembali</label>
            <input type="date" name="due_at" value="{{ old('due_at') }}" required>
            @error('due_at') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div style="margin-top:20px;">
            <button type="submit" class="btn btn-primary">
                Simpan
            </button>

            <a href="{{ route('admin.transactions') }}" class="btn btn-secondary">
                Batal
            </a>
        </div>
    </form>

</div>
@endsection
