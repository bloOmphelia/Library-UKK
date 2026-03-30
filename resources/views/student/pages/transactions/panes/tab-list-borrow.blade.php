@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/student/transactions/borrow.css') }}">
@endpush

@php
    $borrowed = $transactions->where('status', 'borrowed')->where('user_id', auth()->id());
@endphp

@if($borrowed->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-book text-muted" style="font-size: 48px; opacity: 0.3;"></i>
        <p class="text-muted mt-3">Tidak ada buku yang sedang kamu pinjam.</p>
    </div>
@else
    <div class="borrow-grid">
        @foreach ($borrowed as $transaction)
            @php
                $daysLeft = (int) now()->startOfDay()->diffInDays($transaction->due_at->startOfDay(), false);
                $isLate = $daysLeft < 0;
                $isArchived = $transaction->book->status === 'archived';
            @endphp
            <div class="borrow-card">
                <div class="borrow-cover">
                    {{-- Badge Status Waktu --}}
                    <div class="day-badge {{ $isLate || $daysLeft <= 2 ? 'badge-urgent' : 'badge-normal' }}">
                        @if($isLate)
                            Terlambat {{ abs($daysLeft) }} Hari
                        @elseif($daysLeft == 0)
                            Batas Hari Ini
                        @else
                            Sisa {{ $daysLeft }} Hari
                        @endif
                    </div>

                    {{-- CEK STATUS ARSIP DI COVER --}}
                    @if($isArchived)
                        <div class="archived-overlay-placeholder">
                            <i class="bi bi-exclamation-octagon"></i>
                            <span>Buku Diarsipkan</span>
                        </div>
                    @else
                        @if($transaction->book->cover)
                            <img src="{{ asset('storage/' . $transaction->book->cover) }}" alt="{{ $transaction->book->title }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 bg-dark text-white p-4 text-center" style="font-size: 12px;">
                                {{ $transaction->book->title }}
                            </div>
                        @endif
                    @endif
                </div>

                <div class="borrow-info">
                    <div class="borrow-title">{{ $transaction->book->title }}</div>
                    <div class="borrow-meta">Penulis: {{ $transaction->book->writer ?? 'Anonim' }}</div>
                    
                    {{-- Pesan Peringatan jika Buku ditarik Admin --}}
                    @if($isArchived)
                        <div class="warning-archived-text">
                            <i class="bi bi-info-circle-fill me-1"></i>
                            Buku sedang ditarik ke arsip perpustakaan untuk dilakukan pembaruan atau penyesuaian data.
                        </div>
                    @endif

                    <div class="date-row">
                        <div>
                            <span class="d-block text-uppercase" style="font-size: 9px; letter-spacing: 0.5px;">Pinjam</span>
                            <span class="fw-bold text-dark">{{ $transaction->borrowed_at->format('d M Y') }}</span>
                        </div>
                        <div class="text-end">
                            <span class="d-block text-uppercase" style="font-size: 9px; letter-spacing: 0.5px;">Kembali</span>
                            <span class="fw-bold {{ $isLate ? 'text-danger' : 'text-dark' }}">{{ $transaction->due_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('student.transactions.return', $transaction->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-return swal-return" 
                            data-title="Kembalikan Buku?" 
                            data-text="Buku ini akan dikembalikan ke perpustakaan dan tidak bisa dibatalkan.">
                        <i class="bi bi-arrow-left-right me-1"></i> Kembalikan Buku
                    </button>
                </form>
            </div>
        @endforeach
    </div>
@endif