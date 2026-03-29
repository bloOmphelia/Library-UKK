@extends('admin.layouts.app')

@section('title', 'Tambah Kategori')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/category/create.css') }}">
@endpush

@section('content')

<div class="container py-5">
    <div class="category-card">
        <div class="card-header-navy">
            <h5 class="mb-0" style="letter-spacing: 1px;">KATEGORI BARU</h5>
        </div>
        <div class="card-body p-4 p-lg-5">
            <form action="{{ route('admin.category.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label">
                        Nama Kategori 
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           placeholder="Contoh: Sains & Teknologi" value="{{ old('name') }}" autofocus>
                    @error('name')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-center gap-3 mt-5">
                    <button type="submit" class="btn-save shadow-sm">
                        SIMPAN & TAMBAH LAINNYA <i class="bi bi-plus-circle-fill ms-2"></i>
                    </button>
                    <a href="{{ route('admin.category') }}" class="btn-cancel">SELESAI</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection