@extends('student.layouts.app')

@section('title', 'Dashboard Student')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@700;800;900&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/student/dashboard.css') }}">
@endpush

@section('content')
<div class="dashboard-wrap">

    <div class="card welcome-card">
        <div class="card-body p-4 p-lg-5">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 style="font-family: 'Fraunces'; font-weight: 900; font-size: 32px; color: var(--dark);">Selamat Datang di SmartLib</h1>
                    <p class="text-muted">Halo, <strong>{{ $user->name }}</strong> — Mau baca apa kita hari ini?</p>
                </div>
                <div class="col-lg-4 d-none d-lg-block text-center">
                    <img src="{{ asset('assets/users/admin/dist/images/backgrounds/track-bg.png') }}" 
                         width="180px" alt="Welcome" class="img-fluid" />
                </div>
            </div>
        </div>
    </div>

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
                            <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://via.placeholder.com/300x450?text=No+Cover' }}" alt="{{ $book->title }}">
                        </div>

                        <div class="book-info">
                            <div class="book-title">{{ Str::limit($book->title, 35) }}</div>
                            <div class="book-author">{{ $book->writer ?? 'Anonim' }}</div> {{-- Pastikan pakai 'writer' sesuai field DB kamu --}}
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