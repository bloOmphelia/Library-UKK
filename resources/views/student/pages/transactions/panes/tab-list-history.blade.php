@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/student/transactions/history.css') }}">
@endpush

@php
    $history = $transactions->whereIn('status', ['returned', 'late', 'rejected'])->where('user_id', auth()->id());
@endphp

@if($history->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-clock-history text-muted" style="font-size: 48px; opacity: 0.2;"></i>
        <p class="text-muted mt-3">Belum ada riwayat aktivitas.</p>
    </div>
@else
    <div class="history-grid">
        @foreach ($history as $transaction)
            <div class="history-card">
                <div class="history-cover">
                    @php
                        $statusClasses = [
                            'returned' => 'status-returned',
                            'late'     => 'status-late',
                            'rejected' => 'status-rejected'
                        ];
                        $statusLabels = [
                            'returned' => 'Tepat Waktu',
                            'late'     => 'Terlambat',
                            'rejected' => 'Ditolak'
                        ];
                    @endphp
                    <div class="status-badge {{ $statusClasses[$transaction->status] ?? 'status-rejected' }}">
                        {{ $statusLabels[$transaction->status] ?? $transaction->status }}
                    </div>

                    @if($transaction->book->cover)
                        <img src="{{ asset('storage/' . $transaction->book->cover) }}" alt="{{ $transaction->book->title }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100 bg-dark text-white p-4 text-center" style="font-size: 12px;">
                            {{ $transaction->book->title }}
                        </div>
                    @endif
                </div>

                <div class="history-info">
                    <div class="history-title">{{ $transaction->book->title }}</div>
                    <div class="history-author">Penulis: {{ $transaction->book->writer ?? 'Anonim' }}</div> <!-- SAMAKAN -->

                    @if ($transaction->status === 'rejected')
                        <div class="reject-box">
                            <span class="reject-label">Alasan Ditolak</span>
                            <div class="reject-text">{{ $transaction->reject_reason ?? 'Tidak ada alasan spesifik.' }}</div>
                        </div>
                    @endif
                </div>

                <div class="history-footer">
                    <div class="d-flex justify-content-between">
                        <span>Pinjam: <strong>{{ optional($transaction->borrowed_at)->format('d/m/y') ?? '-' }}</strong></span>
                        @if($transaction->status !== 'rejected')
                            <span>Kembali: <strong>{{ optional($transaction->returned_at)->format('d/m/y') ?? '-' }}</strong></span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif