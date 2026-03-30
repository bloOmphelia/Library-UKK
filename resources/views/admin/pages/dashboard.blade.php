@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/dashboard.css') }}">
@endpush

<div class="page-content dashboard-wrapper">
    <x-breadcrumb 
        title="Dashboard Admin"
        description="Kelola data perpustakaan"
        category="Manajemen"
        bgColor="var(--hero-bg)" 
        imgWidth="70px"
    />

    {{-- Stats Cards --}}
    <div class="stats-grid">
        @php
            $stats = [
                ['label'=>'Buku Dipinjam', 'value'=>$totalTransactions ?? 0, 'color'=>'var(--dark)', 'icon'=> 'bi-book'],
                ['label'=>'Buku Tersedia', 'value'=>$booksAvailable ?? 0, 'color'=>'var(--accent)', 'icon'=> 'bi-check-circle'],
                ['label'=>'Buku Terlambat', 'value'=>$overdueBooks ?? 0, 'color'=>'#fb6f6f', 'icon'=> 'bi-exclamation-triangle'],
                ['label'=>'Total Kategori', 'value'=>$totalCategories ?? 0, 'color'=>'#ABCFF3', 'icon'=> 'bi-grid'],
            ];
        @endphp

        @foreach($stats as $s)
            <div class="stat-card" style="border-bottom: 4px solid {{ $s['color'] }};">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
                    <div style="background:{{ $s['color'] }}15; width:42px; height:42px; border-radius:12px; display:flex; align-items:center; justify-content:center; color:{{ $s['color'] }}; font-size:20px; flex-shrink:0;">
                        <i class="bi {{ $s['icon'] }}"></i>
                    </div>
                    <p style="font-size:13px; color:var(--muted); font-weight:600; margin:0; text-transform:uppercase; letter-spacing:0.5px;">
                        {{ $s['label'] }}
                    </p>
                </div>
                <h2 style="font-size:28px; color:var(--dark); font-weight:800; margin:0; font-family:'Fraunces',serif;">
                    {{ $s['value'] }} <span style="font-size:14px; font-weight:500; color:var(--muted);">Buku</span>
                </h2>
            </div>
        @endforeach
    </div>

    {{-- Row 1 --}}
    <div class="row-top">
        {{-- Transaksi Terbaru --}}
        <div class="card-box">
            <h3 class="font-fraunces">Transaksi Terbaru</h3>
            <div class="table-scroll-wrapper">
                <table>
                    <thead>
                        <tr style="color:var(--muted); border-bottom:2px solid #f4f4f4; text-align:left;">
                            <th style="padding:12px;">Nama Pengguna</th>
                            <th style="padding:12px;">Judul Buku</th>
                            <th style="padding:12px;">Status</th>
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
                        <tr style="border-bottom:1px solid #fbfbfb;">
                            <td style="padding:14px 16px;">
                                <div class="d-flex align-items-center gap-3">
                                    @if($trx->user->photo)
                                        <img src="{{ asset('storage/' . $trx->user->photo) }}" 
                                            class="rounded-circle shadow-sm flex-shrink-0"
                                            style="width:44px; height:44px; object-fit:cover; border:2px solid #f0ebe2;">
                                    @else
                                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                            style="width:44px; height:44px; background:#f0ebe2; border:1px solid #e5e0d8;">
                                            <i class="bi bi-person-fill" style="font-size:18px; color:#ad9a79;"></i>
                                        </div>
                                    @endif
                                    <div style="min-width:0;">
                                        <div class="fw-bold text-truncate" style="color:#1e1e1e; font-size:13.5px; max-width:150px;">
                                            {{ $trx->user->name ?? '-' }}
                                        </div>
                                        <div class="text-truncate" style="font-size:11.5px; color:#8e8e8e; max-width:150px;">
                                            <i class="bi bi-envelope me-1"></i>{{ $trx->user->email ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:12px; color:var(--muted);">
                                {{ Str::limit($trx->book?->title ?? 'Buku Tidak Ditemukan', 35) }}
                            </td>
                            <td style="padding:12px;">
                                <span style="padding:5px 12px; border-radius:30px; font-size:10px; font-weight:700; text-transform:uppercase; white-space:nowrap; background:{{ $statusColors[$trx->status]['bg'] ?? '#eee' }}; color:{{ $statusColors[$trx->status]['text'] ?? '#666' }};">
                                    {{ $trx->status_label }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <x-empty-state colspan="3" description="Belum ada data transaksi yang tercatat." />
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Bar Chart --}}
        <div class="card-box">
            <h3 class="font-fraunces">Total Transaksi</h3>
            <div style="flex:1; min-height:0;"><div id="barChart" style="height:100%;"></div></div>
        </div>
    </div>

    {{-- Row 2 --}}
    <div class="row-bottom">
        {{-- Donut Chart --}}
        <div class="card-box">
            <h3 class="font-fraunces">Statistik Pengembalian</h3>
            <div class="donut-wrapper" style="display:flex; align-items:center; justify-content:center; gap:25px; flex:1;">
                <div id="donutChart" style="min-height:200px; flex-shrink:0;"></div>
                <div style="font-size:14px;">
                    <p style="margin-bottom:10px;">
                        <span style="width:10px; height:10px; border-radius:2px; background:#ad9a79; display:inline-block; margin-right:8px;"></span>
                        Tepat Waktu: <strong style="color:var(--dark);">{{ $onTimeReturns ?? 0 }}</strong>
                    </p>
                    <p>
                        <span style="width:10px; height:10px; border-radius:2px; background:#1e1e1e; display:inline-block; margin-right:8px;"></span>
                        Terlambat: <strong style="color:var(--dark);">{{ $lateReturns ?? 0 }}</strong>
                    </p>
                </div>
            </div>
        </div>

        {{-- Overdue Table --}}
        <div class="card-box overdue">
            <h3 class="font-fraunces">Buku Terlambat Dikembalikan</h3>
            <div class="table-scroll-wrapper overdue-table">
                <table>
                    <thead>
                        <tr style="color:var(--muted); border-bottom:1px solid #f4f4f4; text-align:left;">
                            <th style="padding:12px;">Nama Pengguna</th>
                            <th style="padding:12px;">Judul Buku</th>
                            <th style="padding:12px;">Durasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($overdueList as $late)
                        <tr style="border-bottom:1px solid #fbfbfb;">
                            <td style="padding:14px 16px;">
                                <div class="d-flex align-items-center gap-3">
                                    @if($late->user->photo)
                                        <img src="{{ asset('storage/' . $late->user->photo) }}" 
                                            class="rounded-circle shadow-sm flex-shrink-0"
                                            style="width:44px; height:44px; object-fit:cover; border:2px solid #f0ebe2;">
                                    @else
                                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                            style="width:44px; height:44px; background:#f0ebe2; border:1px solid #e5e0d8;">
                                            <i class="bi bi-person-fill" style="font-size:18px; color:#ad9a79;"></i>
                                        </div>
                                    @endif
                                    <div style="min-width:0;">
                                        <div class="fw-bold text-truncate" style="color:#1e1e1e; font-size:13.5px; max-width:150px;">
                                            {{ $late->user->name ?? '-' }}
                                        </div>
                                        <div class="text-truncate" style="font-size:11.5px; color:#8e8e8e; max-width:150px;">
                                            <i class="bi bi-envelope me-1"></i>{{ $late->user->email ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:12px; color:var(--muted);">{{ Str::limit($late->book->title, 30) }}</td>
                            <td style="padding:12px; color:#fb6f6f; font-weight:800; white-space:nowrap;">
                                @php
                                    $due = \Carbon\Carbon::parse($late->due_at)->startOfDay();
                                    $end = $late->returned_at ? \Carbon\Carbon::parse($late->returned_at)->startOfDay() : \Carbon\Carbon::today();
                                    $daysLate = $due->diffInDays($end, false);
                                @endphp
                                {{ $daysLate > 0 ? $daysLate : 0 }} Hari
                            </td>
                        </tr>
                        @empty
                        <x-empty-state colspan="3" description="Belum ada data keterlambatan." />
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