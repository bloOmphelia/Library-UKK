@extends('student.layouts.app')

@section('title', 'Pengembalian')

@section('content')
    <div class="container">
        <h2 class="my-4">Pengembalian Buku</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            @foreach ($transactions as $transaction)
                @if ($transaction->status === 'borrowed' && $transaction->user_id === auth()->id())
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $transaction->book->title }}</h5>
                                <p class="card-text">Tanggal Pinjam: {{ $transaction->borrowed_at->format('Y-m-d') }}</p>
                                <p class="card-text">Tanggal Jatuh Tempo: {{ $transaction->due_at->format('Y-m-d') }}</p>
                                <form action="{{ route('student.transactions.return', $transaction->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-primary">Kembalikan Buku</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
