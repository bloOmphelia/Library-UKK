@extends('admin.layouts.app')

@section('title', 'Manajemen Buku')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@700;800;900&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/admin/books/index.css') }}">
@endpush

@section('content')
<x-breadcrumb
    title="Koleksi Buku"
    description="Kelola koleksi buku perpustakaan."
    category="Manajemen"
    bgColor="#f0ebe2"
    imgWidth="70px"
/>

<div class="manage-books-page p-3">
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

            <a href="{{ route('admin.books.create') }}"
               class="btn-tambah btn btn-dark d-flex align-items-center justify-content-center gap-2 text-nowrap"
               style="height:45px; padding:0 20px; border-radius:12px; font-size:14px; font-weight:700;">
                <i class="bi bi-plus-lg" style="font-size:18px;"></i>
                Tambah Buku
            </a>
        </div>
    </x-search-filter>

    @if($books->count() > 0)
        <div class="books-grid">
            @foreach($books as $book)
                @php
                    $stock       = $book->stock ?? 0;
                    $title       = $book->title  ?? '-';
                    $author      = $book->writer ?? '-';
                    $category    = $book->category->name ?? '-';
                    $activeLoans = $book->transaction->whereIn('status', ['pending','borrowed'])->count();
                    $deleteRoute = route('admin.books.destroy', $book->id);
                    $editRoute   = route('admin.books.edit', $book->id);
                    $showRoute   = route('admin.books.show', $book->id);
                @endphp

                <a href="{{ $showRoute }}"
                   class="book-rec-card {{ $book->status === 'archived' ? 'is-archived' : '' }}">

                    {{-- Badges --}}
                    <div class="badge-category">{{ $category }}</div>
                    <div class="badge-stock {{ $stock == 0 ? 'stock-empty' : ($stock <= 3 ? 'stock-low' : 'stock-ok') }}">
                        {{ $stock == 0 ? 'Habis' : ($stock <= 3 ? "Sisa $stock" : 'Tersedia') }}
                    </div>

                    {{-- Cover --}}
                    <div class="book-cover-wrap">
                        @if($book->cover)
                            <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $title }}" loading="lazy">
                        @else
                            <div class="book-cover-fallback">
                                <i class="bi bi-book-half"></i>
                                <span>{{ $title }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="book-info">
                        <div class="book-title-row">
                            <div class="book-title">{{ Str::limit($title, 40) }}</div>
                        </div>
                        <div class="book-author">{{ Str::limit($author, 30) }}</div>
                    </div>

                    {{-- Actions --}}
                    <div class="book-actions">
                      
                        <form id="status-form-{{ $book->id }}"
                              action="{{ route('admin.books.updateStatus', $book->id) }}"
                              method="POST" style="display:none;">
                            @csrf @method('PATCH')
                        </form>

                        @if($book->status === 'published')
                           
                            <button type="button"
                                class="btn btn-light border d-flex align-items-center justify-content-center gap-2 w-100"
                                style="height:40px; border-radius:10px; font-weight:700; font-size:13px;"
                                onclick="event.preventDefault(); event.stopPropagation(); confirmStatus('{{ $book->id }}', 'published', {{ $activeLoans }})">
                                <i class="bi bi-archive-fill"></i>
                                <span>Tarik ke Draft</span>
                            </button>
                        @else
                            {{-- Terbitkan --}}
                            <button type="button"
                                class="btn btn-success d-flex align-items-center justify-content-center gap-2 flex-grow-1"
                                style="height:40px; border-radius:10px; font-weight:700; font-size:13px;"
                                onclick="event.preventDefault(); event.stopPropagation(); confirmStatus('{{ $book->id }}', '{{ $book->status }}', 0)">
                                <i class="bi bi-megaphone-fill"></i>
                                <span>Terbitkan</span>
                            </button>

                            <button type="button"
                                class="btn btn-warning text-white d-flex align-items-center justify-content-center"
                                style="width:40px; height:40px; border-radius:10px;"
                                onclick="event.preventDefault(); event.stopPropagation(); window.location.href='{{ $editRoute }}';">
                                <i class="bi bi-pencil-square text-white"></i>
                            </button>

                            <button type="button"
                                class="btn btn-danger d-flex align-items-center justify-content-center"
                                style="width:40px; height:40px; border-radius:10px;"
                                onclick="event.preventDefault(); event.stopPropagation(); confirmDelete('{{ $deleteRoute }}', '{{ addslashes($title) }}')">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

    @elseif(request('search') || request('stock_order'))
        <div class="empty-state-container">
            <x-empty-state
                :as-tr="false"
                icon="bi-search"
                message="Hasil pencarian '{{ request('search') }}' tidak ditemukan."
            />
        </div>
    @else
        <div class="empty-state-container">
            <x-empty-state
                :as-tr="false"
                icon="bi-book"
                message="Koleksi buku masih kosong."
            />
        </div>
    @endif

    <div class="mt-4">
        <x-paginate :paginator="$books" />
    </div>
</div>
@endsection

@push('scripts')
    @include('admin.pages.books.scripts.index')
@endpush