@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/student/transactions/pending.css') }}">
@endpush

@php
    $pending = $transactions->where('status', 'pending')->where('user_id', auth()->id());
@endphp

@if($pending->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-hourglass-split text-muted" style="font-size: 48px; opacity: 0.2;"></i> <!-- FIX SPASI -->
        <p class="text-muted mt-3">Tidak ada pengajuan yang sedang diproses.</p>
    </div>
@else
    <div class="pending-grid">
        @foreach ($pending as $transaction)
            <div class="pending-card">
                <div class="pending-cover">
                    {{-- Status Badge with Animation - POSISI SAMAKAN --}}
                    <div class="status-pending-badge">
                        <span class="pulse-dot"></span>
                        Menunggu Konfirmasi
                    </div>

                    @if($transaction->book->cover)
                        <img src="{{ asset('storage/' . $transaction->book->cover) }}" alt="{{ $transaction->book->title }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100 bg-dark text-white p-4 text-center" style="font-size: 12px;">
                            <!-- SAMAKAN no-cover borrow -->
                            {{ $transaction->book->title }}
                        </div>
                    @endif
                </div>

                <div class="pending-info">
                    <div class="pending-title">{{ $transaction->book->title }}</div>
                    <div class="pending-author">Penulis: {{ $transaction->book->writer ?? 'Anonim' }}</div> <!-- SAMAKAN -->
                    
                    <div class="pending-notice">
                        <i class="bi bi-info-circle me-1"></i> <!-- SAMAKAN -->
                        Admin akan segera memverifikasi pengajuanmu.
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif