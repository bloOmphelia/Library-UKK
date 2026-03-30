<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with('book')
        ->where('user_id', auth()->id())->filter($request->only(['search', 'status']), ['book.title'])->latest()->paginate(10)->withQueryString();

        return view('student.pages.transactions.index', compact('transactions'));
    }

    public function borrow(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->stock < 1) {
            return redirect()->back()->with('error', 'Buku tidak tersedia untuk dipinjam.');
        }

        $exists = Transaction::where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->whereIn('status', ['pending', 'borrowed'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah meminjam atau memiliki permintaan aktif untuk buku ini.');
        }

        Transaction::create([
            'book_id' => $book->id,
            'user_id' => auth()->id(),
            'status' => 'pending',
        ]);

        return back()->with('success', 'Permintaan peminjaman berhasil diajukan, menunggu persetujuan admin.');
    }

    public function return($id)
    {
        $transactions = Transaction::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'borrowed')
            ->firstOrFail();

        // PERBAIKAN: Gunakan startOfDay() untuk membandingkan tanggal murni
        $isLate = now()->startOfDay()->gt(\Carbon\Carbon::parse($transactions->due_at)->startOfDay());

        $status = $isLate ? 'late' : 'returned';

        $transactions->update([
            'returned_at' => now(),
            'status'      => $status,
        ]);

        $transactions->book->increment('stock');

        return back()->with('success', 'Buku berhasil dikembalikan.');
    }

    public function returnIndex()
    {
        $transactions = Transaction::with('book')
            ->where('user_id', auth()->id())
            ->where('status', 'borrowed')
            ->latest()
            ->get();

        return view('student.pages.transactions.return', compact('transactions'));
    }

}
