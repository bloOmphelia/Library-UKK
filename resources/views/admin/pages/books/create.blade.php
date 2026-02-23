<style>
/* PAGE BG */
.create-book-page {
    min-height: 100vh;
    padding: 30px;
    color: #fff;
}

/* GLASS CARD */
.glass-card {
    background: linear-gradient(
        135deg,
        rgba(255,255,255,0.08),
        rgba(255,255,255,0.03));
  
}

/* FORM GRID */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 22px 40px;
}

/* LABEL */
.form-label-dark {
    color: #000000;
    font-weight: 600;
    font-size: 14px;
}

/* INPUT */
.form-control-dark,
.form-select-dark {
    background: #fff;
    border-radius: 10px;
    padding: 10px 14px;
    border: none;
    font-size: 14px;
}

/* FILE */
.file-box {
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
    padding: 8px 12px;
    color: #cbd5f5;
}

/* ACTIONS */
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

/* RESPONSIVE */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
}
</style>

@extends('admin.layouts.app')

@section('title', 'Tambah Buku')

@section('content')
<div class="create-book-page">

    <div class="glass-card">
        <h4 class="fw-bold mb-4" style="color: black;">Tambah Buku</h4>

        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-grid">

                {{-- Cover --}}
               <div>
                    <label class="form-label-dark">Cover <span class="text-danger">*</span></label>
                    <div class="file-box">
                        <input type="file" name="cover" class="form-control form-control-dark">
                    </div>
                    @error('cover')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Category --}}
                <div>
                    <label class="form-label-dark">
                        Kategori <span class="text-danger">*</span>
                    </label>
                    <select name="category_id" class="form-select form-select-dark">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Title --}}
                <div>
                    <label class="form-label-dark">
                        Judul <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="title" class="form-control form-control-dark">
                </div>

                {{-- Stock --}}
                <div>
                    <label class="form-label-dark">
                        Stok <span class="text-danger">*</span>
                    </label>
                    <input type="number" name="stock" class="form-control form-control-dark" value="1" min="0">
                    @error('stock')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Writer --}}
                <div>
                    <label class="form-label-dark">
                        Penulis <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="writer" class="form-control form-control-dark">
                    @error('writer')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Publisher --}}
                <div>
                    <label class="form-label-dark">
                        Penerbit <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="publisher" class="form-control form-control-dark">
                </div>

                <div style="grid-column: span 2;"> {{-- biar lebar 1 baris penuh --}}
                    <label class="form-label-dark">
                        Deskripsi <span class="text-danger">*</span>
                    </label>

                    <textarea 
                        name="description"
                        rows="4"
                        class="form-control form-control-dark"
                        placeholder="Masukkan deskripsi buku..."
                    ></textarea>

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
                    Tambah
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
