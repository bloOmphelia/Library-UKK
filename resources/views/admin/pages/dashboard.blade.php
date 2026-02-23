@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div>
    <div class="px-2 py-2 mb-3">
        <h3 class="fw-bold">Dashboard</h3>
    </div>
</div>

<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-bottom:30px;">

    @php
        $stats = [
            ['label'=>'Buku Dipinjam', 'value'=>$totalTransactions ?? 0, 'color'=>'#40487A', 'icon'=> '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#40487A" d="M13.09 20c.12.72.37 1.39.72 2H6c-1.11 0-2-.89-2-2V4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v9.09c-.33-.05-.66-.09-1-.09s-.67.04-1 .09V4h-5v8l-2.5-2.25L8 12V4H6v16zM15 18v2h8v-2z"/></svg>'],
            ['label'=>'Buku Tersedia', 'value'=>$booksAvailable ?? 0, 'color'=>'#E892C0', 'icon'=> '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#E892C0" d="m16.75 22.16l-2.75-3L15.16 18l1.59 1.59L20.34 16l1.16 1.41zM18 2c1.1 0 2 .9 2 2v9.34c-.63-.22-1.3-.34-2-.34V4h-5v8l-2.5-2.25L8 12V4H6v16h6.08c.12.72.37 1.39.72 2H6c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2z"/></svg>'],
            ['label'=>'Buku Terlambat', 'value'=>$overdueBooks ?? 0, 'color'=>'#AC7FF6', 'icon'=> '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#AC7FF6" d="M16 2H4c-1.1 0-2 .9-2 2v16a2 2 0 0 0 2 2h12c1.11 0 2-.89 2-2V4a2 2 0 0 0-2-2m0 18H4V4h2v8l2.5-2.25L11 12V4h5zm4-5h2v2h-2zm2-8v6h-2V7z"/></svg>'],
            ['label'=>'Total Kategori', 'value'=>$totalCategories ?? 0, 'color'=>'#ABCFF3', 'icon'=> '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#ABCFF3" fill-rule="evenodd" d="M20 4H4v1.5h16zm-2 9h-3c-1.1 0-2 .9-2 2v3c0 1.1.9 2 2 2h3c1.1 0 2-.9 2-2v-3c0-1.1-.9-2-2-2m.5 5c0 .3-.2.5-.5.5h-3c-.3 0-.5-.2-.5-.5v-3c0-.3.2-.5.5-.5h3c.3 0 .5.2.5.5zM4 9.5h9V8H4zM9 13H6c-1.1 0-2 .9-2 2v3c0 1.1.9 2 2 2h3c1.1 0 2-.9 2-2v-3c0-1.1-.9-2-2-2m.5 5c0 .3-.2.5-.5.5H6c-.3 0-.5-.2-.5-.5v-3c0-.3.2-.5.5-.5h3c.3 0 .5.2.5.5z"/></svg>'],
        ];
    @endphp

    @foreach($stats as $s)
        <div style="background:white; padding:20px; border-radius:14px; box-shadow:0 8px 20px rgba(64, 72, 122, .06); border-bottom: 4px solid {{ $s['color'] }};">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom: 10px;">
                @if(isset($s['icon']))
                    <div style="background: {{ $s['color'] }}15; width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <div style="transform: scale(0.85); display: flex; align-items: center;">
                            {!! $s['icon'] !!}
                        </div>
                    </div>
                @endif
                <p style="font-size:15px; color:#40487A; font-weight: 500; margin: 0;">
                    {{ $s['label'] }}
                </p>
            </div>
            <h2 style="font-size:24px; color:{{ $s['color'] }}; font-weight: 700; margin: 0; padding-left: 10px;">
                {{ $s['value'] }} <span style="font-size: 14px; font-weight: 500; opacity: 0.8;">Buku</span>
            </h2>
        </div>
    @endforeach
</div>

<div style="display:grid; grid-template-rows: auto auto; gap:25px;">
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:25px;">
        <div style="background:white; padding:25px; border-radius:16px; box-shadow:0 8px 20px rgba(0,0,0,.04); height: 320px; display:flex; flex-direction:column;">
            <h3 style="font-size:16px; color:#40487A; margin-bottom:15px; font-weight:700;">
                Transaksi Terbaru
            </h3>

            <div style="flex:1; overflow:auto;">
                <table style="width:100%; border-collapse:collapse; font-size:14px;">
                    <thead>
                        <tr style="color:#40487A; border-bottom:2px solid #E3EFFF; text-align:left;">
                            <th style="padding:10px;">Nama Pengguna</th>
                            <th style="padding:10px;">Judul Buku</th>
                            <th style="padding:10px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $statusColors = [
                                'pending'  => ['bg' => '#FEF3C7', 'text' => '#92400E'],
                                'borrowed' => ['bg' => '#DBEAFE', 'text' => '#1E40AF'],
                                'returned' => ['bg' => '#D1FAE5', 'text' => '#065F46'],
                                'late'     => ['bg' => '#FEE2E2', 'text' => '#991B1B'],
                                'rejected' => ['bg' => '#F3F4F6', 'text' => '#374151'],
                            ];
                        @endphp

                        @forelse($recentTransactions as $trx)
                        <tr style="border-bottom:1px solid #f9fafb;">
                            <td style="padding:10px; color: #4b5563;">{{ $trx->user->name }}</td>
                            <td style="padding:10px; color: #4b5563;">{{ $trx->book->title }}</td>
                            <td style="padding:10px;">
                                <span style="
                                    padding:4px 10px; 
                                    border-radius:20px; 
                                    font-size:11px; 
                                    font-weight: 600; 
                                    text-transform: uppercase;
                                    background: {{ $statusColors[$trx->status]['bg'] ?? '#E3EFFF' }};
                                    color: {{ $statusColors[$trx->status]['text'] ?? '#40487A' }};
                                ">
                                    {{ $trx->status_label }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="padding:30px; text-align:center; color:#9ca3af;">Belum ada Transaksi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div style="background:white; padding:25px; border-radius:16px; box-shadow:0 8px 20px rgba(0,0,0,.04); height: 320px; display:flex; flex-direction:column;">
            <h3 style="font-size:16px; color:#40487A; margin-bottom:15px; font-weight:700;">
                Total Transaksi
            </h3>
            <div style="flex:1;">
                <div id="barChart"></div>
            </div>
        </div>
    </div>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:25px;">

        <div style="background:white; padding:25px; border-radius:16px; box-shadow:0 8px 20px rgba(0,0,0,.04); height: 320px; display:flex; flex-direction:column;">
            <h3 style="font-size:16px; color:#40487A; margin-bottom:15px; font-weight:700;">
                Statistik Pengembalian
            </h3>
            <div style="display:flex; align-items:center; gap:25px; flex:1;">
                <div style="width:180px; height:180px;">
                    <div id="donutChart"></div>
                </div>
                <div style="color: #4b5563;">
                    <p style="margin-bottom:12px; display: flex; align-items: center; gap: 8px;">
                        <span style="width:12px; height:12px; border-radius:3px; background:#ABCFF3; display:inline-block;"></span>
                        Tepat Waktu: <strong style="color:#40487A;">{{ $onTimeReturns ?? 0 }}</strong>
                    </p>
                    <p style="display: flex; align-items: center; gap: 8px;">
                        <span style="width:12px; height:12px; border-radius:3px; background:#E892C0; display:inline-block;"></span>
                        Terlambat: <strong style="color:#40487A;">{{ $lateReturns ?? 0 }}</strong>
                    </p>
                </div>
            </div>
        </div>

        <div style="background:white; padding:25px; border-radius:16px; box-shadow:0 8px 20px rgba(0,0,0,.04); height: 320px; display:flex; flex-direction:column; border: 1px solid #FADDEE;">
            <h3 style="font-size:16px; color:#E892C0; margin-bottom:15px; font-weight:700;">
                Buku Terlambat Dikembalikan
            </h3>
            <div style="flex:1; overflow:auto;">
                <table style="width:100%; border-collapse:collapse; font-size:13px;">
                    <thead>
                        <tr style="color:#4b5563; border-bottom:1px solid #E3EFFF; text-align:left;">
                            <th style="padding:10px;">Nama Pengguna</th>
                            <th style="padding:10px;">Judul Buku</th>
                            <th style="padding:10px;">Terlambat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($overdueList as $late)
                        <tr style="border-bottom:1px solid #f9fafb;">
                            <td style="padding:10px;">{{ $late->user->name }}</td>
                            <td style="padding:10px;">{{ $late->book->title }}</td>
                            <td style="padding:10px; color:#E892C0; font-weight:700;">
                                @php
                                    $due = \Carbon\Carbon::parse($late->due_at)->startOfDay();
                                    $end = $late->returned_at 
                                        ? \Carbon\Carbon::parse($late->returned_at)->startOfDay() 
                                        : \Carbon\Carbon::today();

                                    $daysLate = $due->diffInDays($end, false);
                                @endphp
                                {{ $daysLate > 0 ? $daysLate : 0 }} Hari
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="padding:30px; text-align:center; color:#9ca3af;">Tidak ada keterlambatan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @include('admin.scripts.dashboard')
@endpush