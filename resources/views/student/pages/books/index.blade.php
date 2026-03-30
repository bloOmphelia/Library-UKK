@extends('student.layouts.app')

@section('title', 'Koleksi Buku - SmartLib')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@700;800;900&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/student/books/index.css') }}">
@endpush

@section('content')

<x-breadcrumb
    title="Koleksi Buku"
    description="Jelajahi dan pinjam buku favoritmu di SmartLib."
    category="Perpustakaan"
    bgColor="#f0ebe2"
    imgWidth="70px"
/>

<div class="main-container manage-books-page">
    <x-search-filter :action="url()->current()" placeholder="Cari buku...">
        <div class="filter-bar-inner d-flex align-items-center gap-3 w-100 justify-content-end">

            <div class="sort-group d-flex align-items-center gap-2">
                <label class="mb-0 text-nowrap" style="font-size:14px; font-weight:600; color:#6b7280;">Sort by:</label>
                <select name="stock_order" class="form-select modern-input auto-submit"
                    style="height:45px; min-width:170px; border-radius:12px; font-size:14px; border:1px solid #e5e7eb;">
                    <option value="">Default</option>
                    <option value="highest" {{ request('stock_order') == 'highest' ? 'selected' : '' }}>Stok Terbanyak</option>
                    <option value="lowest"  {{ request('stock_order') == 'lowest'  ? 'selected' : '' }}>Stok Terendah</option>
                </select>
            </div>
        </div>
    </x-search-filter>
    <div class="books-grid">
        @forelse($books as $book)
            @php $stock = $book->stock ?? 0; @endphp
            
            <a href="{{ route('student.books.show', $book->id) }}" class="book-rec-card">
                <div class="badge-category">{{ $book->category->name ?? 'Umum' }}</div>

                <div class="badge-stock {{ $stock <= 3 ? ($stock == 0 ? 'stock-empty' : 'stock-low') : 'stock-ok' }}">
                    {{ $stock == 0 ? 'Habis' : ($stock <= 3 ? "Sisa $stock" : 'Tersedia') }}
                </div>

                <div class="book-cover-wrap">
                    @if($book->cover)
                        <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}" loading="lazy">
                    @else
                        <div class="book-cover-fallback">
                            <i class="bi bi-book-half"></i>
                            <span>{{ $book->title }}</span>
                        </div>
                    @endif
                </div>

                <div class="book-info">
                    <div class="book-title">{{ $book->title }}</div>
                    <div class="book-author">{{ $book->writer ?? $book->author ?? 'Anonim' }}</div>
                </div>
            </a>
        @empty
            <div class="empty-state-container">
                <x-empty-state 
                    :as-tr="false" 
                    icon="bi-book" 
                    message="Koleksi buku belum tersedia."
                />
            </div>
        @endforelse
    </div>

    <div class="mt-5 d-flex justify-content-center">
        <x-paginate :paginator="$books" />
    </div>
</div>

@endsection