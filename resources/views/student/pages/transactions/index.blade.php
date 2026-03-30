@extends('student.layouts.app')

@section('title', 'Transaksi Saya')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@700;800;900&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/student/transactions/index.css') }}">
@endpush

@section('content')
<div class="transaction-page">
    
    <x-breadcrumb 
        title="Transaksi Saya"
        description="Pantau status peminjaman dan riwayat buku kamu di sini."
        category="Aktivitas"
        bgColor="#f8f9fa"
        imgWidth="70px"
    />

    <div class="container-fluid px-0">

        <ul class="nav nav-tabs mb-4" id="transactionTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="borrow-tab" data-bs-toggle="tab" data-bs-target="#pane-borrow" type="button" role="tab">
                    <i class="bi bi-book"></i> Buku Dipinjam
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pane-pending" type="button" role="tab">
                    <i class="bi bi-clock-history"></i> Menunggu Konfirmasi
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#pane-history" type="button" role="tab">
                    <i class="bi bi-journal-check"></i> Riwayat
                </button>
            </li>
        </ul>

        <div class="tab-content" id="transactionTabContent">
            <div class="tab-pane fade show active" id="pane-borrow" role="tabpanel">
                @include('student.pages.transactions.panes.tab-list-borrow', ['transactions' => $transactions])
            </div>

            <div class="tab-pane fade" id="pane-pending" role="tabpanel">
                @include('student.pages.transactions.panes.tab-list-pending', ['transactions' => $transactions])
            </div>

            <div class="tab-pane fade" id="pane-history" role="tabpanel">
                @include('student.pages.transactions.panes.tab-list-history', ['transactions' => $transactions])
            </div>
        </div>
    </div>
</div>
@endsection