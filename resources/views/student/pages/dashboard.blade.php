@extends('student.layouts.app')

@section('title', 'Dashboard Student')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@700;800;900&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/student/dashboard.css') }}">
@endpush

@section('content')
<div class="dashboard-wrap">

    <x-breadcrumb 
        title="Selamat Datang di SmartLib"
        :description="'Halo, ' . $user->name . ' — Mau baca apa kita hari ini?'"
        category="Manajemen"
        bgColor="var(--hero-bg)" 
    />

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-book-reader"></i>
            </div>
            <div class="stat-info">
                <p class="stat-label">Sedang Dipinjam</p>
                <p class="stat-value">{{ $currentBorrowings->count() }} <span>Buku</span></p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon amber">
                <i class="fas fa-history"></i>
            </div>
            <div class="stat-info">
                <p class="stat-label">Total Dikembalikan</p>
                <p class="stat-value">{{ $totalReturned }} <span>Buku</span></p>
            </div>
        </div>
    </div>

    <div class="books-outer">
        <div class="section-header">
            <h3>Buku Terpopuler</h3>
            <a href="{{ route('student.books') }}" class="view-all">Lihat Semua &rsaquo;</a>
        </div>

        <div class="books-row">
            @forelse($popularBooks as $book)
                @php $stock = $book->stock ?? 0; @endphp
               <a href="{{ route('student.books.show', $book->id) }}" class="book-card-link">
                    <div class="book-rec-card">
                        <div class="badge-category">{{ $book->category->name ?? 'Umum' }}</div>
                        
                        @php $stock = $book->stock; @endphp
                        <div class="badge-stock {{ $stock <= 3 ? ($stock == 0 ? 'stock-empty' : 'stock-low') : 'stock-ok' }}">
                            {{ $stock == 0 ? 'Habis' : ($stock <= 3 ? "Sisa $stock" : 'Tersedia') }}
                        </div>

                        <div class="book-cover-wrap">
                            @if($book->cover)
                                <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}" loading="lazy">
                            @else
                                <div class="book-cover-fallback">
                                    <i class="bi bi-book-half"></i>
                                    <span>{{ Str::limit($book->title, 25) }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="book-info">
                            <div class="book-title">{{ Str::limit($book->title, 35) }}</div>
                            <div class="book-author">{{ $book->writer ?? 'Anonim' }}</div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="py-4 text-muted">
                    <x-empty-state 
                        :as-tr="false" 
                        icon="bi-book" 
                        message="Koleksi buku masih kosong." 
                    />
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection