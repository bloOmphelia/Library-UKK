@extends('student.layouts.app')

@section('title', $book->title)

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,700;0,900;1,700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/student/books/show.css') }}">
@endpush

@section('content')
<div class="detail-wrap">
    <nav class="mb-4">
        <a href="{{ route('student.books') }}"
           style="color: var(--muted); text-decoration: none; font-size: 14px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
            <i class="bi bi-arrow-left fs-4"></i>
        </a>
    </nav>

    <div class="detail-grid">
        <div class="cover-col">
            <div class="cover-wrap">
                @if($book->cover)
                    <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}">
                @else
                    <div class="book-cover-fallback">
                        <i class="bi bi-book-half"></i>
                        <span>{{ $book->title }}</span>
                    </div>
                @endif
            </div>

            <div class="stock-badge {{ $book->stock > 0 ? 'available' : 'empty' }}">
                <span class="stock-dot"></span>
                {{ $book->stock > 0 ? $book->stock . ' Buku Tersedia' : 'Stok Habis' }}
            </div>
        </div>

        <div class="info-col">
            @if($book->category)
                <span class="book-category">{{ $book->category->name }}</span>
            @endif

            <h1 class="book-title">{{ $book->title }}</h1>
            <p class="book-writer">Karya <strong>{{ $book->writer ?? 'Penulis Anonim' }}</strong></p>

            <div class="meta-grid">
                <div class="meta-item">
                    <p class="meta-label">Penerbit</p>
                    <p class="meta-value">{{ $book->publisher ?? '—' }}</p>
                </div>
                <div class="meta-item">
                    <p class="meta-label">Tahun Terbit</p>
                    <p class="meta-value">{{ $book->year ?? '—' }}</p>
                </div>
                <div class="meta-item">
                    <p class="meta-label">Bahasa</p>
                    <p class="meta-value">{{ $book->language ?? '—' }}</p>
                </div>
            </div>

            <div class="desc-section">
                <h4>Sinopsis Buku</h4>
                <p class="desc-text {{ Str::length($book->description ?? '') > 300 ? 'clamped' : '' }}" id="descText">
                    {{ $book->description ?? 'Tidak ada deskripsi untuk buku ini.' }}
                </p>
                @if(Str::length($book->description ?? '') > 300)
                    <button class="btn p-0 fw-bold mt-2"
                            style="color: var(--accent); border: none; background: none; font-size: 13px;"
                            onclick="toggleDesc()" id="toggleBtn">
                        Baca Selengkapnya <i class="bi bi-chevron-down ms-1"></i>
                    </button>
                @endif
            </div>

            <div class="action-row">
                @if($book->stock > 0)
                    <form action="{{ route('student.transactions.borrow') }}" method="POST" style="flex: 1;">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <button type="submit" class="btn-borrow w-100">
                            <i class="fas fa-book-reader me-2"></i> Pinjam Buku Ini
                        </button>
                    </form>
                @else
                    <button class="btn-borrow w-100" disabled>
                        Stok Tidak Tersedia
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @include('student.pages.books.scripts.show')
@endpush