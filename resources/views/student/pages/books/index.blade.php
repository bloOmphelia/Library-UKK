@extends('student.layouts.app')

@section('title', 'Books')

<style>
/* PAGE */
.manage-books-page {
    min-height: 100vh;
    padding: 30px;
    color: #fff;
}

/* HEADER */
.manage-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 30px;
}

.manage-header h2 {
    font-size: 32px;
    font-weight: 700;
    color: #000;
}

/* GRID */
.books-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
}

/* CARD */
.book-card {
    background: rgba(255,255,255,0.06);
    border-radius: 16px;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 14px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

/* TOP */
.book-top {
    display: flex;
    gap: 12px;
}

.book-cover {
    width: 60px;
    height: 80px;
    border-radius: 8px;
    object-fit: cover;
    background: #1f2933;
}

.book-info h5 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #000;
}

.book-info p {
    margin: 0;
    font-size: 13px;
    color: #cbd5f5;
}

.book-stock {
    font-size: 13px;
    color: #a5b4fc;
}

/* ACTIONS */
.book-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.btn-borrow {
    background: #3b82f6;
    border: none;
    color: white;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    cursor: pointer;
    font-weight: 600;
    transition: background 0.2s;
}

.btn-borrow:hover {
    background: #2563eb;
}

.btn-borrow:disabled {
    background: #4b5563;
    cursor: not-allowed;
}
</style>

@section('content')
<div class="manage-books-page">

    <div class="manage-header">
        <h2>List Books</h2>
    </div>

    <x-search-filter :action="url()->current()" placeholder="Cari..."></x-search-filter>

    @if (session('success'))
        <div style="background:#10b981; color:white; padding:12px; border-radius:8px; margin-bottom:20px;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="background:#ef4444; color:white; padding:12px; border-radius:8px; margin-bottom:20px;">
            {{ session('error') }}
        </div>
    @endif

    <div class="books-grid">
        @foreach($books as $book)
            <div class="book-card">
                <div class="book-top">
                    <img 
                        src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://via.placeholder.com/60x80?text=No+Cover' }}" 
                        class="book-cover"
                        alt="{{ $book->title }}"
                    >
                    <div class="book-info">
                        <h5>{{ $book->title }}</h5>
                        <p>{{ $book->writer }}</p>
                        <p class="book-stock">Stock: {{ $book->stock }}</p>
                    </div>
                </div>

                <div class="book-actions">
                    @if($book->stock > 0)
                        <form action="{{ route('student.transactions.borrow') }}" method="POST">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            <button type="submit" class="btn-borrow">Pinjam Buku</button>
                        </form>
                    @else
                        <span style="color:#f87171; font-size:12px;">Stok Habis</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('filterForm');
    if (!form) return;

    let timeout = null;

    document.querySelectorAll('.auto-submit').forEach(element => {
        if (element.tagName === 'INPUT' && element.type === 'text') {
            element.addEventListener('input', function () { 
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    form.submit();
                }, 500);
            });
        }
    });
});
</script>