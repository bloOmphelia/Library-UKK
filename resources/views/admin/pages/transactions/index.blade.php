@extends('admin.layouts.app')

@section('title', 'Manage Transaction')

@push('style')
<link rel="stylesheet" href="{{ asset('assets/css/admin/transactions/index.css') }}">
@endpush

@section('content')
<x-breadcrumb 
    title="Transaksi"
    description="Daftar transaksi peminjaman buku"
    category="Manajemen"
    bgColor="#f8f9fa"
    imgWidth="70px"
/>

{{-- Toolbar --}}
<div class="d-flex align-items-center gap-3 mb-4 w-100 flex-wrap toolbar-wrapper">

    {{-- Search --}}
    <div style="max-width: 500px; width: 100%;">
        <form action="{{ url()->current() }}" method="GET" class="m-0">
            <div class="position-relative">
                <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="form-control" placeholder="Cari transaksi..." 
                    style="height: 45px; padding-left: 45px; border-radius: 12px; border: 1px solid #e5e7eb; font-size: 14px;">
            </div>
        </form>
    </div>

    {{-- Filter Status --}}
    <div style="min-width: 180px;">
        <form action="{{ url()->current() }}" method="GET" class="m-0">
            <select name="status" class="form-select" onchange="this.form.submit()"
                style="height: 45px; border-radius: 12px; border: 1px solid #e5e7eb; font-size: 14px; cursor: pointer;">
                <option value="">Semua Status</option>
                <option value="pending"  {{ request('status') == 'pending'   ? 'selected' : '' }}>Menunggu</option>
                <option value="borrowed" {{ request('status') == 'borrowed'  ? 'selected' : '' }}>Dipinjam</option>
                <option value="returned" {{ request('status') == 'returned'  ? 'selected' : '' }}>Kembali</option>
                <option value="late"     {{ request('status') == 'late'      ? 'selected' : '' }}>Terlambat</option>
            </select>
        </form>
    </div>

    {{-- Tombol Tambah --}}
    <a href="{{ route('admin.transactions.create') }}" 
    class="btn btn-dark d-flex align-items-center justify-content-center gap-2 text-nowrap ms-auto toolbar-btn-add" 
    style="height: 45px; padding: 0 20px; border-radius: 12px; font-size: 14px; font-weight: 700; background-color: #1a1a1a; border: none; flex-shrink: 0;">
        <i class="bi bi-plus-lg" style="font-size: 18px;"></i>
        Tambah Transaksi
    </a>
</div>

    {{-- Tabel Transaksi --}}
    <div class="table-responsive rounded-4 mb-4 mt-4 shadow-sm border" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
        <table class="table customize-table mb-0 align-middle" style="min-width: 900px;">
            <thead>
                <tr style="border-bottom: 2px solid #eee;">
                    <th class="fw-bold text-white text-center" style="background-color: #1e1e1e; padding: 15px; width: 50px;">No</th>
                    <th class="fw-bold text-white text-center" style="background-color: #1e1e1e; padding: 15px; min-width: 220px;">Nama Pengguna</th>
                    <th class="fw-bold text-white" style="background-color: #1e1e1e; padding: 15px; min-width: 220px;">Nama Buku</th>
                    <th class="fw-bold text-white text-center" style="background-color: #1e1e1e; padding: 15px; min-width: 120px;">Tanggal Pinjam</th>
                    <th class="fw-bold text-white text-center" style="background-color: #1e1e1e; padding: 15px; min-width: 120px;">Estimasi</th>
                    <th class="fw-bold text-white text-center" style="background-color: #1e1e1e; padding: 15px; min-width: 120px;">Tanggal Kembali</th>
                    <th class="fw-bold text-white text-center" style="background-color: #1e1e1e; padding: 15px; min-width: 110px;">Status</th>
                    <th class="fw-bold text-white text-center" style="background-color: #1e1e1e; padding: 15px; width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $statusStyles = [
                        'pending'  => ['bg' => '#FFF9E6', 'text' => '#B28900', 'border' => '#FFE58F', 'label' => 'Menunggu'],
                        'borrowed' => ['bg' => '#E6F4FF', 'text' => '#0958D9', 'border' => '#91CAFF', 'label' => 'Dipinjam'],
                        'returned' => ['bg' => '#F6FFED', 'text' => '#389E0D', 'border' => '#B7EB8F', 'label' => 'Dikembalikan'],
                        'late'     => ['bg' => '#FFF1F0', 'text' => '#CF1322', 'border' => '#FFA39E', 'label' => 'Terlambat'],
                        'rejected' => ['bg' => '#F5F5F5', 'text' => '#595959', 'border' => '#D9D9D9', 'label' => 'Ditolak'],
                    ];
                @endphp

                @forelse ($transactions as $index => $transaction)
                <tr style="border-bottom: 1px solid #f3f3f3;">

                    {{-- No --}}
                    <td class="fw-semibold text-center text-muted" style="font-size: 13px;">
                        {{ $transactions->firstItem() + $index }}
                    </td>

                    {{-- Pengguna --}}
                    <td style="padding: 14px 16px;">
                        @php $isDeleted = $transaction->user?->trashed(); @endphp
                        <div class="d-flex align-items-center gap-3">
                            @if($transaction->user?->photo && !$isDeleted)
                                <img src="{{ asset('storage/' . $transaction->user->photo) }}" 
                                    class="rounded-circle shadow-sm flex-shrink-0"
                                    style="width: 44px; height: 44px; object-fit: cover; border: 2px solid #f0ebe2;">
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                    style="width: 44px; height: 44px; 
                                            background: {{ $isDeleted ? '#f5f5f5' : '#f0ebe2' }}; 
                                            border: 1px solid {{ $isDeleted ? '#ddd' : '#e5e0d8' }};">
                                    <i class="bi bi-person-fill" style="font-size: 18px; color: {{ $isDeleted ? '#ccc' : '#ad9a79' }};"></i>
                                </div>
                            @endif
                            <div style="min-width: 0;">
                                <div class="fw-bold text-truncate d-flex align-items-center gap-1" 
                                    style="color: {{ $isDeleted ? '#9e9e9e' : '#1e1e1e' }}; font-size: 13.5px; max-width: 150px;">
                                    {{ $transaction->user->name ?? '-' }}
                                    @if($isDeleted)
                                        <span style="font-size: 10px; background: #f5f5f5; color: #9e9e9e; border: 1px solid #ddd; border-radius: 4px; padding: 1px 6px; font-weight: 600; white-space: nowrap; flex-shrink: 0;">
                                            Dihapus
                                        </span>
                                    @endif
                                </div>
                                <div class="text-truncate" style="font-size: 11.5px; color: #8e8e8e; max-width: 150px;">
                                    <i class="bi bi-envelope me-1"></i>{{ $transaction->user->email ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </td>

                    {{-- Buku --}}
                    <td style="padding: 14px 16px;">
                        @php 
                            $book = $transaction->book;
                            $isBookDeleted = $book?->trashed(); 
                        @endphp
                        <div class="d-flex align-items-center gap-3">
                            @if($book?->cover && !$isBookDeleted)
                                {{-- Cover diperbesar: 48x64 --}}
                                <img src="{{ asset('storage/' . $book->cover) }}"
                                    class="rounded shadow-sm flex-shrink-0"
                                    style="width: 48px; height: 64px; object-fit: cover; border: 1px solid #eee;">
                            @else
                                <div class="rounded d-flex align-items-center justify-content-center flex-shrink-0"
                                    style="width: 48px; height: 64px; 
                                            background: {{ $isBookDeleted ? '#f5f5f5' : '#f0ebe2' }}; 
                                            border: 1px solid {{ $isBookDeleted ? '#ddd' : '#e5e0d8' }};">
                                    <i class="bi bi-book" style="font-size: 20px; color: {{ $isBookDeleted ? '#ccc' : '#ad9a79' }};"></i>
                                </div>
                            @endif

                            <div style="min-width: 0; max-width: 160px;">
                                <div class="fw-bold d-flex align-items-start gap-1 flex-wrap" 
                                    style="color: {{ $isBookDeleted ? '#9e9e9e' : '#1e1e1e' }}; font-size: 13.5px;">

                                    {{-- Judul Buku: dibatasi 2 baris, full title muncul di tooltip --}}
                                    <span title="{{ $book->title ?? '-' }}"
                                          style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4; word-break: break-word;">
                                        {{ $book->title ?? '-' }}
                                    </span>

                                    @if($isBookDeleted)
                                        <span style="font-size: 10px; background: #f5f5f5; color: #9e9e9e; border: 1px solid #ddd; border-radius: 4px; padding: 1px 6px; font-weight: 600; white-space: nowrap; flex-shrink: 0;">
                                            Dihapus
                                        </span>
                                    @endif
                                </div>

                                {{-- Kategori --}}
                                @if($book?->category)
                                    <div style="font-size: 11px; margin-top: 3px;">
                                        <span style="background: {{ $isBookDeleted ? '#f5f5f5' : '#f0ebe2' }}; 
                                                    color: {{ $isBookDeleted ? '#ccc' : '#ad9a79' }}; 
                                                    padding: 2px 8px; border-radius: 20px; font-size: 10.5px; font-weight: 600;">
                                            {{ $book->category->name ?? $book->category }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </td>

                    {{-- Tanggal Pinjam --}}
                    <td class="text-center">
                        @if($transaction->borrowed_at)
                            <div class="fw-semibold" style="font-size: 13px; color: #1e1e1e;">
                                {{ $transaction->borrowed_at->format('d M Y') }}
                            </div>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>

                    {{-- Estimasi --}}
                    <td class="text-center">
                        @if($transaction->due_at)
                            <div class="fw-semibold" style="font-size: 13px; color: #1e1e1e;">
                                {{ $transaction->due_at->format('d M Y') }}
                            </div>
                            @if(in_array($transaction->status, ['borrowed', 'pending']))
                                @php $daysLeft = (int) now()->startOfDay()->diffInDays($transaction->due_at->startOfDay(), false); @endphp
                                <div style="font-size: 11px; color: {{ $daysLeft < 0 ? '#CF1322' : ($daysLeft <= 2 ? '#B28900' : '#8e8e8e') }};">
                                    @if($daysLeft < 0)
                                        {{ abs($daysLeft) }} hari terlambat
                                    @elseif($daysLeft === 0)
                                        Hari ini
                                    @else
                                        {{ $daysLeft }} hari lagi
                                    @endif
                                </div>
                            @endif
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>

                    {{-- Tanggal Kembali --}}
                    <td class="text-center">
                        @if($transaction->returned_at)
                            <div class="fw-semibold" style="font-size: 13px; color: #1e1e1e;">
                                {{ $transaction->returned_at->format('d M Y') }}
                            </div>
                        @else
                            <span class="text-muted" style="font-size: 13px;">-</span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td class="text-center">
                        <span style="
                            display: inline-block;
                            background-color: {{ $statusStyles[$transaction->status]['bg'] ?? '#f8f9fa' }};
                            color: {{ $statusStyles[$transaction->status]['text'] ?? '#1e1e1e' }};
                            border: 1px solid {{ $statusStyles[$transaction->status]['border'] ?? '#eee' }};
                            padding: 5px 12px;
                            border-radius: 8px;
                            font-weight: 700;
                            font-size: 10.5px;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                        ">
                            {{ $transaction->status_label }}
                        </span>
                    </td>

                    {{-- Aksi --}}
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            @if ($transaction->status === 'pending')
                                {{-- Approve: hijau --}}
                                <button class="btn btn-sm text-white" 
                                        style="background-color: #2ECC71; border-radius: 6px;" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#approveModal{{ $transaction->id }}"
                                        title="Setujui">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                                {{-- Reject: hitam (diubah dari merah) --}}
                                <button class="btn btn-sm text-white" 
                                        style="background-color: #1e1e1e; border-radius: 6px;" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#rejectModal{{ $transaction->id }}"
                                        title="Tolak">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            @elseif ($transaction->status === 'borrowed')
                                <a href="{{ route('admin.transactions.edit', $transaction->id) }}" 
                                   class="btn btn-sm text-white" 
                                   style="background-color: #ad9a79; border-radius: 6px;"
                                   title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            @else
                                {{-- Delete: merah (diubah dari hitam) --}}
                                <form action="{{ route('admin.transactions.destroy', $transaction->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm text-white swal-delete" 
                                            style="background-color: #E74C3C; border-radius: 6px;"
                                            title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <x-empty-state
                    colspan="8" 
                    description="Belum ada data transaksi yang tercatat."
                />
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <x-paginate :paginator="$transactions"></x-paginate>
    </div>
</div>

@foreach ($transactions as $transaction)
    @if ($transaction->status === 'pending')
        @include('admin.pages.transactions.widgets.approve-modal', ['transaction' => $transaction])
        @include('admin.pages.transactions.widgets.reject-modal', ['transaction' => $transaction])
    @endif
@endforeach

@endsection