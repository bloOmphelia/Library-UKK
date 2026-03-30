@extends('admin.layouts.app')

@section('title', 'Tambah Buku')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/books/create.css') }}">
@endpush

@section('content')

<div class="container-fluid px-4 py-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="edit-card">

                <div class="edit-header-accent text-center">
                    <h5 class="mb-0" style="font-weight: 700; letter-spacing: 1px;">
                        <i class="bi bi-plus-circle-fill me-2"></i> TAMBAH BUKU BARU
                    </h5>
                </div>

                <div class="card-body p-4 p-lg-5">
                    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            {{-- Cover Upload --}}
                            <div class="col-12 mb-4">
                                <label class="form-label">Cover Buku</label>
                                <div class="d-flex align-items-center gap-3 p-3 border rounded-4 bg-light">
                                    <div class="file-preview" style="flex-shrink:0;">
                                        {{-- Placeholder ikon sebelum ada gambar --}}
                                        <div id="coverPlaceholder" style="width:80px; height:110px; border-radius:10px; border:2px solid #eee; background:#e9ecef; display:flex; align-items:center; justify-content:center;">
                                            <i class="bi bi-image text-muted fs-2"></i>
                                        </div>
                                        {{-- Preview gambar setelah dipilih --}}
                                        <img id="coverPreview" src="" alt="cover"
                                            style="width:80px; height:110px; object-fit:cover; border-radius:10px; border:2px solid #eee; display:none;">
                                    </div>
                                    <div class="flex-grow-1">
                                        <input type="file" name="cover" id="coverInput"
                                            class="form-control mb-1 @error('cover') is-invalid @enderror"
                                            accept="image/*">
                                        <small class="text-muted">Format: JPG, PNG, WEBP. Maks 2MB. Rekomendasi ukuran: 400×600 px.</small>
                                    </div>
                                </div>
                                @error('cover') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                            </div>

                            {{-- Title --}}
                            <div class="col-md-8 mb-4">
                                <label class="form-label">Judul Buku <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                    placeholder="Masukkan judul lengkap buku" value="{{ old('title') }}" required>
                                @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- Category --}}
                            <div class="col-md-4 mb-4">
                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- Writer --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Penulis / Pengarang <span class="text-danger">*</span></label>
                                <input type="text" name="writer" class="form-control @error('writer') is-invalid @enderror" 
                                    placeholder="Nama penulis" value="{{ old('writer') }}" required>
                                @error('writer') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- Publisher --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Penerbit <span class="text-danger">*</span></label>
                                <input type="text" name="publisher" class="form-control @error('publisher') is-invalid @enderror" 
                                    placeholder="Nama penerbit" value="{{ old('publisher') }}" required>
                                @error('publisher') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- Tahun Terbit, Stok, Bahasa --}}
                            <div class="col-md-4 mb-4">
                                <label class="form-label">Tahun Terbit</label>
                                <input type="text" name="year" class="form-control @error('year') is-invalid @enderror" 
                                    placeholder="Contoh: 2024" value="{{ old('year') }}">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label">Jumlah Stok <span class="text-danger">*</span></label>
                                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" 
                                    value="{{ old('stock', 1) }}" min="0" required>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label">Bahasa</label>
                                <input type="text" name="language" class="form-control @error('language') is-invalid @enderror" 
                                    placeholder="Contoh: Indonesia">
                            </div>

                            {{-- Deskripsi --}}
                            <div class="col-12 mb-4">
                                <label class="form-label">Ringkasan / Deskripsi <span class="text-danger">*</span></label>
                                <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" 
                                    placeholder="Tuliskan sedikit tentang isi buku..." required>{{ old('description') }}</textarea>
                                @error('description') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="row mt-3 g-3 justify-content-center">
                            <div class="col-lg-5">
                                <button type="submit" class="btn-save">
                                    SIMPAN & TAMBAH LAINNYA <i class="bi bi-plus-circle-fill ms-2"></i>
                                </button>
                            </div>
                            <div class="col-lg-3">
                                <a href="{{ route('admin.books') }}" class="btn-cancel">KEMBALI</a>
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
    @include('admin.pages.books.scripts.create')
@endpush