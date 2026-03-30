<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $now = Carbon::now();

        // Logika Utama Keterlambatan (Hanya membandingkan TANGGAL)
        $lateCriteria = function($query) {
            $query->where('status', 'late')
                ->orWhere(function($q) {
                    // Sudah kembali tapi telat (Minimal selisih 1 hari)
                    $q->where('status', 'returned')
                    ->whereRaw('DATEDIFF(returned_at, due_at) > 0');
                })
                ->orWhere(function($q) {
                    // Masih dipinjam tapi sudah lewat hari ini
                    $q->where('status', 'borrowed')
                    ->whereRaw('DATEDIFF(NOW(), due_at) > 0');
                });
        };

        // Statistik Dasar
        $totalTransactions = Transaction::count();
        $booksAvailable = Book::where('stock', '>', 0)->count();
        $totalCategories = Category::count();
        $totalMembers = User::role('student')->count();

        // Untuk Donut Chart
        $onTimeReturns = Transaction::where('status', 'returned')
        ->whereRaw('DATEDIFF(returned_at, due_at) <= 0')
        ->count();

        $lateReturns = Transaction::where($lateCriteria)->count();

        // Card Atas & Tabel List Terlambat
        $overdueBooks = $lateReturns; 
        
        $overdueList = Transaction::with(['user', 'book'])
            ->where($lateCriteria)
            ->latest()
            ->take(5)
            ->get();

        // Transaksi Terbaru & Chart Batang
        $recentTransactions = Transaction::with(['user', 'book'])->latest()->take(5)->get();

        $transactionsPerMonth = Transaction::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $now->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $allMonths = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $chartData = array_fill(0, 12, 0);
        foreach ($transactionsPerMonth as $trx) {
            $chartData[$trx->month - 1] = $trx->total;
        }

        $popularBooks = Book::withCount('transaction')
            ->orderBy('transaction_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.pages.dashboard', compact(
            'user', 'totalTransactions', 'booksAvailable', 'overdueBooks', 
            'totalCategories', 'recentTransactions', 'overdueList', 
            'totalMembers', 'allMonths', 'chartData', 'popularBooks', 
            'onTimeReturns', 'lateReturns'
        ));
    }
}
