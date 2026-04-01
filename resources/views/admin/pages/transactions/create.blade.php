@extends('admin.layouts.app')

@section('title', 'Tambah Transaksi')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('assets/css/admin/transactions/create-transaction.css') }}">
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="edit-card">
                <div class="edit-header-accent text-center">
                    <h5 class="mb-0" style="font-weight: 700; letter-spacing: 1px;">
                        <i class="bi bi-journal-plus me-2"></i> FORM TRANSAKSI BARU
                    </h5>
                </div>

                <div class="card-body p-4 p-lg-5">
                    <form action="{{ route('admin.transactions.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Pilih Buku</label>
                                <select name="book_id" class="form-select select2-init @error('book_id') is-invalid @enderror" data-placeholder="-- Pilih Buku --" >
                                    <option value=""></option>
                                    @foreach ($books as $book)
                                        <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                            {{ $book->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('book_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Pilih Anggota</label>
                                <select name="user_id" id="user_id" class="form-select select2-init @error('user_id') is-invalid @enderror" data-placeholder="-- Cari Nama Anggota --">
                                    <option value=""></option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- Tanggal --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Tanggal Peminjaman</label>
                                <input type="date" name="borrowed_at" class="form-control @error('borrowed_at') is-invalid @enderror" value="{{ old('borrowed_at', now()->format('Y-m-d')) }}" >
                                @error('borrowed_at') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Tanggal Kembali</label>
                                <input type="date" name="due_at" class="form-control @error('due_at') is-invalid @enderror" value="{{ old('due_at') }}" >
                                @error('due_at') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row mt-3 g-3 justify-content-center">
                            <div class="col-lg-5">
                                <button type="submit" class="btn-save">
                                    SIMPAN & TAMBAH LAGI <i class="bi bi-plus-circle-fill ms-2"></i>
                                </button>
                            </div>
                            <div class="col-lg-3">
                                <a href="{{ route('admin.transactions') }}" class="btn-cancel">KEMBALI</a>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@include('admin.pages.transactions.scripts.create')
@endpush