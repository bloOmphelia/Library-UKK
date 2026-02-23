@extends('admin.layouts.app')

@section('title', 'Edit Book')

<style>
.edit-book-page {
    min-height: 100vh;
    padding: 30px;
    color: #fff;
}

.page-title {
    font-size: 42px;
    font-weight: 800;
    margin-bottom: 30px;
}

.glass-card {
    background: linear-gradient(
        135deg,
        rgba(255,255,255,0.08),
        rgba(255,255,255,0.03)
    );
    backdrop-filter: blur(12px);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.4);
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 22px 40px;
}

.form-label-dark {
    color: #e5e7eb;
    font-weight: 600;
    font-size: 14px;
}

.form-control-dark,
.form-select-dark {
    background: #fff;
    border-radius: 10px;
    padding: 10px 14px;
    border: none;
    font-size: 14px;
}

.file-preview {
    display: flex;
    align-items: center;
    gap: 14px;
}

.file-preview img {
    width: 70px;
    height: 90px;
    object-fit: cover;
    border-radius: 8px;
    background: #1f2933;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 14px;
    margin-top: 30px;
}

.btn-cancel {
    background: #ef4444;
    border: none;
    color: #fff;
    padding: 10px 22px;
    border-radius: 10px;
    font-weight: 600;
}

.btn-submit {
    background: #4ade80;
    border: none;
    color: #022c22;
    padding: 10px 22px;
    border-radius: 10px;
    font-weight: 600;
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
}
</style>

@section('content')
<div class="edit-book-page">

    <h1 class="page-title">Edit Book</h1>

    <div class="glass-card">
        <h4 class="fw-bold mb-4">Edit Buku</h4>
        <hr style="border-color: rgba(255,255,255,0.2)">

        <form action="{{ route('admin.books.update', $books->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-grid">

                {{-- Cover --}}
                <div>
                    <label class="form-label-dark">Cover</label>
                    <div class="file-preview mb-2">
                        <img 
                            src="{{ $books->cover ? asset('storage/'.$books->cover) : 'https://via.placeholder.com/70x90' }}" 
                            alt="cover"
                        >
                        <span class="text-muted">Cover saat ini</span>
                    </div>
                    <input type="file" name="cover" class="form-control form-control-dark">
                </div>

                {{-- Category --}}
                <div>
                    <label class="form-label-dark">
                        Category <span class="text-danger">*</span>
                    </label>
                    <select name="category_id" class="form-select form-select-dark">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ $books->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Title --}}
                <div>
                    <label class="form-label-dark">
                        Title <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="title" 
                           class="form-control form-control-dark"
                           value="{{ old('title', $books->title) }}">
                </div>

                {{-- Stock --}}
                <div>
                    <label class="form-label-dark">
                        Stock <span class="text-danger">*</span>
                    </label>
                    <input type="number" name="stock" 
                           class="form-control form-control-dark"
                           value="{{ old('stock', $books->stock) }}" min="0">
                </div>

                {{-- Writer --}}
                <div>
                    <label class="form-label-dark">
                        Writer <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="writer" 
                           class="form-control form-control-dark"
                           value="{{ old('writer', $books->writer) }}">
                </div>

                {{-- Publisher --}}
                <div>
                    <label class="form-label-dark">
                        Publisher
                    </label>
                    <input type="text" name="publisher" 
                           class="form-control form-control-dark"
                           value="{{ old('publisher', $books->publisher) }}">
                </div>

                {{-- Deskripsi --}}
                <div style="grid-column: span 2;"> 
                    <label class="form-label-dark">
                        Deskripsi <span class="text-danger">*</span>
                    </label>
                    <textarea 
                        name="description"
                        rows="4"
                        class="form-control form-control-dark"
                        placeholder="Masukkan deskripsi buku..."
                    >{{ old('description', $books->description) }}</textarea>

                    @error('description')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="form-actions">
                <a href="{{ route('admin.books') }}" class="btn-cancel">
                    Batal
                </a>
                <button type="submit" class="btn-submit">
                    Update
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
