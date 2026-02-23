@php
    $pending = $transactions->where('status', 'pending')->where('user_id', auth()->id());
@endphp

@if($pending->isEmpty())
    <p class="text-muted">Tidak ada pengajuan yang menunggu.</p>
@else
    <div class="row">
        @foreach ($pending as $transaction)
            <div class="col-md-4 mb-4">
                <div class="card border-warning">
                    <div class="card-body">
                        <h5 class="card-title">{{ $transaction->book->title }}</h5>
                        <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif