@php
    $borrowed = $transactions->where('status', 'borrowed')->where('user_id', auth()->id());
@endphp

@if($borrowed->isEmpty())
    <p class="text-muted">Tidak ada buku yang sedang dipinjam.</p>
@else
    <div class="row">
        @foreach ($borrowed as $transaction)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $transaction->book->title }}</h5>
                        <p>Tanggal Pinjam: {{ optional($transaction->borrowed_at)->format('Y-m-d') }}</p>
                        <p>Jatuh Tempo: {{ optional($transaction->due_at)->format('Y-m-d') }}</p>

                        <form action="{{ route('student.transactions.return', $transaction->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-primary w-100">
                                Kembalikan Buku
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif