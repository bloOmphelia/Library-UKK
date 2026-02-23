@extends('student.layouts.app')

@section('title', 'Transaksi Saya')

@section('content')
<div class="container my-4">
    <h2>Transaksi Saya</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ALERT KALAU ADA YANG DITOLAK --}}
    @if ($transactions->where('status','rejected')->where('user_id', auth()->id())->isNotEmpty())
        <div class="alert alert-danger">
            Ada pengajuan peminjaman yang ditolak. Silakan cek di tab <strong>Riwayat</strong>.
        </div>
    @endif

    {{-- TAB NAV --}}
    <ul class="nav nav-tabs mb-4" id="transactionTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active"
                id="borrow-tab"
                data-bs-toggle="tab"
                data-bs-target="#pane-borrow"
                type="button"
                role="tab"
                aria-controls="pane-borrow"
                aria-selected="true">
                📚 Buku Dipinjam
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link"
                id="pending-tab"
                data-bs-toggle="tab"
                data-bs-target="#pane-pending"
                type="button"
                role="tab"
                aria-controls="pane-pending"
                aria-selected="false">
                ⏳ Menunggu Konfirmasi
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link"
                id="history-tab"
                data-bs-toggle="tab"
                data-bs-target="#pane-history"
                type="button"
                role="tab"
                aria-controls="pane-history"
                aria-selected="false">
                🕘 Riwayat
            </button>
        </li>
    </ul>

    {{-- TAB CONTENT --}}
    <div class="tab-content" id="transactionTabContent">
        <div class="tab-pane fade show active" id="pane-borrow" role="tabpanel" aria-labelledby="borrow-tab">
            @include('student.pages.transactions.panes.tab-list-borrow', ['transactions' => $transactions])
        </div>

        <div class="tab-pane fade" id="pane-pending" role="tabpanel" aria-labelledby="pending-tab">
            @include('student.pages.transactions.panes.tab-list-pending', ['transactions' => $transactions])
        </div>

        <div class="tab-pane fade" id="pane-history" role="tabpanel" aria-labelledby="history-tab">
            @include('student.pages.transactions.panes.tab-list-history', ['transactions' => $transactions])
        </div>
    </div>
</div>
@endsection