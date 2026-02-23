@extends('admin.layouts.app')

@section('title', 'Manajemen Buku')

<style>
.manage-books-page {
    min-height: 100vh;
    padding: 30px;
}

/* GRID */
.books-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 20px;
}

/* CARD UTAMA */
.book-card {
    position: relative;
    width: 180px;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
}

/* GAMBAR COVER */
.book-cover {
    width: 100%;
    height: 260px;
    object-fit: cover;
    border-radius: 8px;
}

/* OVERLAY (fade in seperti React) */
.book-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.80);
    color: white;
    padding: 10px;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    opacity: 0;
    transition: opacity 0.3s ease;
}

/* Saat hover */
.book-card:hover .book-overlay {
    opacity: 1;
}

/* TAG */
.book-tag {
    font-size: 11px;
}

/* ACTION BUTTONS (BARU) */
.book-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 8px;
    gap: 6px;
}

.btn-edit {
    background: #f1c40f;
    color: #000;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 12px;
    text-decoration: none;
    text-align: center;
    flex: 1;
}

.btn-edit:hover {
    background: #d4ac0d;
}

.btn-delete {
    background: #e74c3c;
    color: white;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 12px;
    border: none;
    cursor: pointer;
    flex: 1;
}

.btn-delete:hover {
    background: #c0392b;
}

.create-card {
    border: 2px dashed #ccc;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 260px;
    text-decoration: none;
    color: #888;
    border-radius: 8px;
    gap: 6px;
}

.create-card:hover {
    background: #f1f1f1;
}

</style>

@section('content')
<div class="card position-relative overflow-hidden" style="background-color: #E8DEF3;">
    <div class="card-body px-4 py-4">
        <div class="row align-items-center">
            <div class="col-9">
                @include('components.breadcrumb', [
                    'title' => 'Daftar Buku',
                    'description' => 'Tambahkan dan Perbarui Buku'
                ])
            </div>
            <div class="col-3 text-center mb-n1">
                <img src="{{ asset('assets/users/admin/dist/images/backgrounds/track-bg.png') }}" 
                     width="70px" alt="" class="img-fluid mb-n3" />
            </div>
        </div>
    </div>
</div>

<div class="manage-books-page">
    <x-search-filter :action="url()->current()" placeholder="Cari..."></x-search-filter>

    <div class="books-grid">

        @foreach($books as $book)
        <div class="book-card">

            <!-- COVER -->
            <img 
                src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://via.placeholder.com/180x260' }}" 
                class="book-cover"
                alt="{{ $book->title }}"
            >

            <!-- OVERLAY (muncul saat hover) -->
            <div class="book-overlay">
                <div>
                    <h4 style="font-size:13px; font-weight:600; margin-bottom:4px;">
                        {{ $book->title }}
                    </h4>
                    <p style="font-size:12px;">
                        {{ Str::limit($book->description, 120) }}
                    </p>
                </div>

                <div style="display:flex; gap:5px; flex-wrap:wrap; margin-top:6px;">
                    <span class="book-tag">
                        {{ $book->category->name ?? 'Unknown' }}
                    </span>
                    <span class="book-tag">
                        Stok : {{ $book->stock }}
                    </span>
                </div>

                <!-- 🔥 BUTTON EDIT & DELETE (BARU) -->
                <div class="book-actions">
                    <a href="{{ route('admin.books.edit', $book->id) }}" class="btn-edit">
                        Edit
                    </a>

                    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" style="flex:1;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>

        </div>
        @endforeach

        <!-- CARD TAMBAH -->
        <a href="{{ route('admin.books.create') }}" class="create-card">
            <i class="bi bi-plus-circle" style="font-size:32px; margin-bottom:8px;"></i>
            <strong>Add New Book</strong>
        </a>

    </div>
</div>
@endsection
