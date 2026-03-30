<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $popularBooks = Book::published()
            ->has('transaction') 
            ->with('category')
            ->withCount('transaction')
            ->orderBy('transaction_count', 'desc')
            ->take(6)
            ->get();

        $currentBorrowings = Transaction::where('user_id', $user->id)
            ->whereIn('status', ['borrowed', 'late'])
            ->with('book')
            ->latest()
            ->get();

        $totalReturned = Transaction::where('user_id', $user->id)
            ->where('status', 'returned')
            ->count();

        return view('student.pages.dashboard', compact(
            'user', 
            'popularBooks', 
            'currentBorrowings',
            'totalReturned'
        ));
    }
}