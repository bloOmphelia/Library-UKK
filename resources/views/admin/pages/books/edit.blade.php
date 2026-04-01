@extends('admin.layouts.app')

@section('title', 'Edit Buku')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/books/edit.css') }}">
@endpush

@section('content')
<div class="container-fluid px-4 py-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="edit-card">

                <div class="edit-header-accent text-center">
                    <h5 class="mb-0" style="font-weight: 700; letter-spacing: 1px;">
                        <i class="bi bi-book-half me-2"></i> UPDATE DATA BUKU
                    </h5>
                </div>

                <div class="card-body p-4 p-lg-5">
                    <form action="{{ route('admin.books.update', $books->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Cover Preview & Upload --}}
                            <div class="col-12 mb-4">
                                <label class="form-label">Cover Buku</label>
                                <div class="d-flex align-items-center gap-3 p-3 border rounded-4 bg-light">
                                    <div class="file-preview" style="flex-shrink:0;">
                                        {{-- Tampil cover existing, atau placeholder jika kosong --}}
                                        @if($books->cover)
                                            <img id="coverPreview"
                                                src="{{ asset('storage/' . $books->cover) }}"
                                                alt="cover"
                                                style="width:80px; height:110px; object-fit:cover; border-radius:10px; border:2px solid #eee;">
                                            <div id="coverPlaceholder" style="display:none; width:80px; height:110px; border-radius:10px; border:2px solid #eee; background:#e9ecef; align-items:center; justify-content:center;">
                                                <i class="bi bi-image text-muted fs-2"></i>
                                            </div>
                                        @else
                                            <div id="coverPlaceholder" style="width:80px; height:110px; border-radius:10px; border:2px solid #eee; background:#e9ecef; display:flex; align-items:center; justify-content:center;">
                                                <i class="bi bi-image text-muted fs-2"></i>
                                            </div>
                                            <img id="coverPreview" src="" alt="cover"
                                                style="width:80px; height:110px; object-fit:cover; border-radius:10px; border:2px solid #eee; display:none;">
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <input type="file" name="cover" id="coverInput"
                                            class="form-control mb-1 @error('cover') is-invalid @enderror"
                                            accept="image/*">
                                        <small class="text-muted">Format: JPG, PNG, WEBP. Maks 2MB. Biarkan kosong jika tidak ingin ganti.</small>
                                    </div>
                                </div>
                                @error('cover') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                            </div>

                            {{-- Title --}}
                            <div class="col-md-8 mb-4">
                                <label class="form-label">Judul Buku</label>
                                <input type="text" name="title" class="form-control" @error('title') is-invalid @enderror value="{{ old('title', $books->title) }}" >
                                @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- Category --}}
                            <div class="col-md-4 mb-4">
                                <label class="form-label">Kategori</label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" >
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $books->category_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- Writer --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Penulis</label>
                                <input type="text" name="writer" class="form-control @error('writer') is-invalid @enderror" value="{{ old('writer', $books->writer) }}" >
                                @error('writer') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- Publisher --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Penerbit</label>
                                <input type="text" name="publisher" class="form-control @error('publisher') is-invalid @enderror" value="{{ old('publisher', $books->publisher) }}">
                                @error('publisher') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- Year, Stock, Language --}}
                            <div class="col-md-4 mb-4">
                                <label class="form-label">Tahun Terbit</label>
                                <input type="number" name="year" class="form-control @error('year') is-invalid @enderror" value="{{ old('year', $books->year) }}" >
                                @error('year') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="form-label">Stok</label>
                                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $books->stock) }}" min="0" >
                                @error('stock') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="form-label">Bahasa</label>
                                <input type="text" name="language" class="form-control @error('language') is-invalid @enderror" value="{{ old('language', $books->language) }}" >
                                @error('language') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div class="col-12 mb-4">
                                <label class="form-label">Deskripsi Buku</label>
                                <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" placeholder="Masukkan ringkasan buku..." >{{ old('description', $books->description) }}</textarea>
                                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="row mt-3 g-3 justify-content-center text-center">
                            <div class="col-lg-4">
                                <button type="submit" class="btn-save w-100">
                                    UPDATE BUKU <i class="bi bi-cloud-arrow-up-fill ms-2"></i>
                                </button>
                            </div>
                            <div class="col-lg-4">
                                <a href="{{ route('admin.books') }}" class="btn-cancel w-100">
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

@push('scripts')
@include('admin.pages.books.scripts.edit')
@endpush