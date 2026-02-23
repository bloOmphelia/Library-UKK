<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index (Request $request)
    {
        $transactions = Transaction::with(['book','user'])->filter($request->all(), ['book.title', 'user.name'])->paginate(10)->withQueryString();
        return view('admin.pages.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $books = Book::where('stock', '>', 0)->get();
        $users = User::role('student')->get();

        return view('admin.pages.transactions.create', compact('books', 'users'));
    }
  
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'borrowed_at' => 'required|date',
            'due_at' => 'required|date|after_or_equal:borrowed_at',
        ]);

        $books = Book::findOrFail($request->book_id);

        if ($books->stock < 1) {
            return redirect()->back()->with('error', 'Buku tidak tersedia untuk dipinjam.');
        }

        Transaction::create([
            'book_id' => $request->book_id,
            'user_id' => $request->user_id,
            'borrowed_at' => $request->borrowed_at,
            'due_at'      => $request->due_at,
            'status' => 'borrowed',
        ]);

        $books->decrement('stock');

        return redirect()->route('admin.transactions')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function approve(Request $request, $id)
    {
        $transaction = Transaction::with('book')->findOrFail($id);

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi sudah diproses.');
        }

        $request->validate([
            'borrowed_at' => 'required|date',
            'due_at' => 'required|date|after_or_equal:borrowed_at',
        ]);

        if ($transaction->book->stock < 1) {
            return back()->with('error', 'Stok buku habis.');
        }

        $transaction->update([
            'borrowed_at' => $request->borrowed_at,
            'due_at' => $request->due_at,
            'status' => 'borrowed',
        ]);

        $transaction->book->decrement('stock');

        return back()->with('success', 'Transaksi berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi sudah diproses.');
        }

        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $transaction->update([
            'status' => 'rejected',
            'reject_reason' => $request->reason,
        ]);

        return back()->with('success', 'Transaksi ditolak.');
    }

    public function edit($id)
    {
        $transactions = Transaction::findOrFail($id);

        if ($transactions->status !== 'borrowed') {
            return back()->with('error', 'Transaksi yang sudah selesai tidak dapat diedit.');
        }

        return view('admin.pages.transactions.edit', compact('transactions'));
    }

    public function update(Request $request, $id)
    {
        $transactions = Transaction::findOrFail($id);

        if ($transactions->status !== 'borrowed') {
            return back()->with('error', 'Hanya transaksi aktif yang dapat diperbarui.');
        }

        $request->validate([
            'borrowed_at' => 'required|date',
            'due_at'      => 'required|date|after_or_equal:borrowed_at',
        ]);

        $transactions->update([
            'borrowed_at' => $request->borrowed_at,
            'due_at'      => $request->due_at,
        ]);

        return redirect()->route('admin.transactions')->with('success', 'Data peminjaman diperbarui.');
    }

    public function destroy($id)
    {
        $transactions = Transaction::findOrFail($id);

        if($transactions->status === 'borrowed') {
            $transactions->book->increment('stock');
        }

        $transactions->delete();

        return redirect()->route('admin.transactions')->with('success', 'Transaksi berhasil dihapus.');
    }
}
