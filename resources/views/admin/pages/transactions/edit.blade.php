@extends('admin.layouts.app')

@section('title', 'Edit Transaction')

@section('content')
<div class="manage-users-page">

    <h2>Edit Transaksi</h2>

    <form action="{{ route('admin.transactions.update', $transactions->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nama Buku --}}
        <div class="form-group">
            <label>Nama Buku</label>
            <input type="text"
                class="form-control"
                value="{{ $transactions->book->title }}"
                readonly style="background-color: #f3f4f6;">
        </div>

        {{-- Nama User --}}
        <div class="form-group">
            <label>Nama User</label>
            <input type="text"
                class="form-control"
                value="{{ $transactions->user->name }}"
                readonly style="background-color: #f3f4f6;">
        </div>

        {{-- Tanggal Pinjam --}}
        <div class="form-group">
            <label>Tanggal Pinjam</label>
            <input type="date"
                name="borrowed_at"
                class="form-control"
                value="{{ old('borrowed_at', $transactions->borrowed_at->format('Y-m-d')) }}"
                required>
        </div>

        {{-- Tanggal Jatuh Tempo (Batas Pengembalian) --}}
        <div class="form-group">
            <label>Batas Pengembalian (Due Date)</label>
            <input type="date"
                name="due_at"
                class="form-control"
                value="{{ old('due_at', $transactions->due_at->format('Y-m-d')) }}"
                required>
        </div>

        {{-- Status Transaksi --}}
        <div class="form-group" style="margin-top: 15px;">
            <label>Status Transaksi</label>
            <select name="status" class="form-control" required>
                <option value="borrowed" {{ old('status', $transactions->status) == 'borrowed' ? 'selected' : '' }}>
                    Dipinjam (Borrowed)
                </option>
                <option value="returned" {{ old('status', $transactions->status) == 'returned' ? 'selected' : '' }}>
                    Dikembalikan (Returned)
                </option>
                <option value="late" {{ old('status', $transactions->status) == 'late' ? 'selected' : '' }}>
                    Terlambat (Late)
                </option>
            </select>
            <small style="color: #6b7280;">* Mengubah ke 'Returned' akan menambah stok buku secara otomatis.</small>
        </div>

        <div style="margin-top:30px;">
            <button type="submit" class="btn btn-primary" style="padding: 10px 25px;">
                Update Transaksi
            </button>

            <a href="{{ route('admin.transactions') }}" class="btn btn-secondary" style="padding: 10px 25px; margin-left: 10px;">
                Batal
            </a>
        </div>
    </form>

</div>

{{-- Tambahan CSS jika form-control belum rapi --}}
<style>
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
    .form-control { 
        width: 100%; 
        padding: 8px; 
        border: 1px solid #ddd; 
        border-radius: 4px; 
        box-sizing: border-box; 
    }
</style>
@endsection