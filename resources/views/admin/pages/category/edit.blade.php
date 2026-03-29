@extends('admin.layouts.app')

@section('title', 'Edit Kategori')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/category/edit.css') }}">
@endpush

@section('content')

<div class="container py-5">
    <div class="category-card">
        <div class="card-header-navy">
            <h5 class="mb-0" style="letter-spacing: 1px;">UPDATE CATEGORY</h5>
        </div>
        <div class="card-body p-4 p-lg-5">
            <form action="{{ route('admin.category.update', $categories->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name', $categories->name) }}">
                    @error('name')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-center gap-3 mt-5">
                    <a href="{{ route('admin.category') }}" class="btn-cancel">BATAL</a>
                    <button type="submit" class="btn-save shadow-sm">UPDATE KATEGORI</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection