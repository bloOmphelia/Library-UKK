@extends('admin.layouts.app')

@section('title', 'Edit Transaksi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/transactions/edit-transaction.css') }}">
@endpush

@section('content')
<div class="container-fluid px-4 py-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="edit-card">

                <div class="edit-header-accent text-center">
                    <h5 class="mb-0" style="font-weight: 700; letter-spacing: 1px;">
                        <i class="bi bi-pencil-square me-2"></i> UPDATE DATA TRANSAKSI
                    </h5>
                </div>

                <div class="card-body p-4 p-lg-5">
                    <form action="{{ route('admin.transactions.update', $transactions->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Nama Buku</label>
                                <input type="text" class="form-control"
                                    value="{{ $transactions->book->title }}" readonly>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Nama Peminjam</label>
                                <input type="text" class="form-control"
                                    value="{{ $transactions->user->name }}" readonly>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Tanggal Pinjam</label>
                                <input type="date" name="borrowed_at"
                                    class="form-control @error('borrowed_at') is-invalid @enderror"
                                    value="{{ old('borrowed_at', $transactions->borrowed_at->format('Y-m-d')) }}"
                                    required>
                                @error('borrowed_at') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Tanggal Kembali</label>
                                <input type="date" name="due_at"
                                    class="form-control @error('due_at') is-invalid @enderror"
                                    value="{{ old('due_at', $transactions->due_at->format('Y-m-d')) }}"
                                    required>
                                @error('due_at') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label">Status Transaksi</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="borrowed" {{ old('status', $transactions->status) == 'borrowed' ? 'selected' : '' }}>
                                        Dipinjam
                                    </option>
                                    <option value="returned" {{ old('status', $transactions->status) == 'returned' ? 'selected' : '' }}>
                                        Dikembalikan
                                    </option>
                                    <option value="late" {{ old('status', $transactions->status) == 'late' ? 'selected' : '' }}>
                                        Terlambat
                                    </option>
                                </select>
                                @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                                <div class="mt-2" style="font-size: 13px; color: #6c757d;">
                                    <i class="bi bi-info-circle-fill me-1 text-primary"></i> 
                                    Status <strong>'Dikembalikan'</strong> & <strong>'Terlambat'</strong> akan mengembalikan stok buku secara otomatis.
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3 g-3 justify-content-center">
                            <div class="col-lg-4">
                                <button type="submit" class="btn-save">
                                    UPDATE TRANSAKSI <i class="bi bi-check-lg ms-2"></i>
                                </button>
                            </div>
                            <div class="col-lg-4">
                                <a href="{{ route('admin.transactions') }}" class="btn-cancel">
                                    KEMBALI
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