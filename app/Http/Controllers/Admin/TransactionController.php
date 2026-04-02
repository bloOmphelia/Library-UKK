<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\TransactionNotification;

class TransactionController extends Controller
{
    public function index (Request $request)
    {
        $transactions = Transaction::with(['book','user'])->filter($request->only(['search', 'status']), ['book.title', 'user.name'])->latest()->paginate(10)->withQueryString();
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
       $rules = [
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'borrowed_at' => 'required|date',
            'due_at' => 'required|date|after_or_equal:borrowed_at',
        ];

        $messages = [
            'required' => ':attribute wajib diisi.',
            'exists'   => ':attribute tidak valid.',
            'date'     => ':attribute harus berupa format tanggal.',
            'after_or_equal' => ':attribute tidak boleh sebelum tanggal pinjam.',
        ];

        $attributes = [
            'book_id' => 'Buku',
            'user_id' => 'Siswa',
            'borrowed_at' => 'Tanggal pinjam',
            'due_at' => 'Tanggal kembali',
        ];

        $request->validate($rules, $messages, $attributes);

        $book = Book::findOrFail($request->book_id);

        $existingTransaction = Transaction::where('user_id', $request->user_id)
            ->where('book_id', $request->book_id)
            ->whereIn('status', ['borrowed', 'pending'])
            ->exists();

        if ($existingTransaction) {
            return redirect()->back()->with('error', 'User masih meminjam atau memiliki antrean untuk buku ini.');
        }

        if ($book->stock < 1) {
            return redirect()->back()->with('error', 'Buku tidak tersedia untuk dipinjam.');
        }

        Transaction::create([
            'book_id' => $request->book_id,
            'user_id' => $request->user_id,
            'borrowed_at' => $request->borrowed_at,
            'due_at'      => $request->due_at,
            'status' => 'borrowed',
        ]);

        $book->decrement('stock');

        return redirect()->back()
            ->withInput($request->except(['book_id', 'user_id']))
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function approve(Request $request, $id)
    {
        $transaction = Transaction::with(['book', 'user'])->findOrFail($id); 

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi sudah diproses.');
        }

        $request->validate([
            'borrowed_at' => 'required|date',
            'due_at' => 'required|date|after_or_equal:borrowed_at',
        ], [
            'required' => ':attribute wajib diisi.',
            'date'     => ':attribute harus format tanggal valid.',
            'after_or_equal' => ':attribute tidak boleh sebelum tanggal pinjam.',
        ], [
            'borrowed_at' => 'Tanggal pinjam',
            'due_at'      => 'Tanggal kembali',
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

        $message = "Peminjaman buku '{$transaction->book->title}' telah disetujui!";
        $transaction->user->notify(new TransactionNotification($message, 'success', 'bi-check-circle-fill'));

        return back()->with('success', 'Transaksi berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $transaction = Transaction::with(['book', 'user'])->findOrFail($id);

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi sudah diproses.');
        }

        $request->validate([
            'reason' => 'required|string|max:255',
        ], [
            'required' => 'Alasan penolakan wajib diisi.',
            'max'      => 'Alasan terlalu panjang (maksimal 255 karakter).'
        ]);

        $transaction->update([
            'status' => 'rejected',
            'reject_reason' => $request->reason,
        ]);

        $message = "Maaf, pengajuan peminjaman buku '{$transaction->book->title}' ditolak karena: {$request->reason}";
        $transaction->user->notify(new TransactionNotification($message, 'danger', 'bi-exclamation-triangle-fill'));

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
        $transaction = Transaction::with('book')->findOrFail($id);

        $request->validate([
            'borrowed_at' => 'required|date',
            'due_at'      => 'required|date|after_or_equal:borrowed_at',
            'status'      => 'required|in:borrowed,returned,late',
        ], [
            'required' => ':attribute tidak boleh kosong.',
            'date'     => ':attribute harus tanggal valid.',
            'after_or_equal' => ':attribute harus sama atau setelah tanggal pinjam.',
            'in'       => 'Status tidak valid.'
        ], [
            'borrowed_at' => 'Tanggal pinjam',
            'due_at'      => 'Tanggal tenggat',
            'status'      => 'Status Transaksi'
        ]);

        $finalStatuses = ['returned', 'late'];

        if ($transaction->status === 'borrowed' && in_array($request->status, $finalStatuses)) {
            $transaction->book->increment('stock');

            $statusText = $request->status === 'late' ? 'Terlambat' : 'Tepat Waktu';
            $message = "Transaksi buku '{$transaction->book->title}' telah ditutup dengan status: {$statusText}.";
            $transaction->user->notify(new TransactionNotification($message, 'success', 'bi-check-all'));
        }

        $transaction->update([
            'borrowed_at' => $request->borrowed_at,
            'due_at'      => $request->due_at,
            'status'      => $request->status,
            'returned_at' => in_array($request->status, $finalStatuses) ? now() : $transaction->returned_at,
        ]);

        return redirect()->route('admin.transactions')->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $transactions = Transaction::findOrFail($id);

        if ($transactions->status === 'borrowed') {
            return redirect()->route('admin.transactions')
                ->with('error', 'Transaksi sedang aktif! Buku harus dikembalikan terlebih dahulu sebelum data bisa dihapus.');
        }

        $transactions->delete();

        return redirect()->route('admin.transactions')->with('success', 'Transaksi berhasil dihapus.');
    }
}
