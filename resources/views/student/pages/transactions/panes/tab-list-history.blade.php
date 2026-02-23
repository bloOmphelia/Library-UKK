@php
    $history = $transactions->whereIn('status', ['returned', 'late', 'rejected'])->where('user_id', auth()->id());
@endphp

@if($history->isEmpty())
    <p class="text-muted">Belum ada riwayat transaksi.</p>
@else
    <div class="row">
        @foreach ($history as $transaction)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $transaction->book->title }}</h5>

                        <p>Dipinjam:
                            {{ optional($transaction->borrowed_at)->format('Y-m-d') ?? '-' }}
                        </p>

                        <span class="badge 
                            @if($transaction->status == 'returned') bg-success
                            @elseif($transaction->status == 'late') bg-danger
                            @elseif($transaction->status == 'rejected') bg-secondary
                            @endif">
                            {{ ucfirst($transaction->status) }}
                        </span>

                        @if ($transaction->status === 'rejected')
                            <p class="mt-2 text-muted">
                                <strong>Alasan ditolak:</strong>
                                {{ $transaction->reject_reason }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif