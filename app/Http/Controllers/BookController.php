<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index (Request $request)
    {
        $query = Book::with('category');

        if ($request->filled('stock_order')) {
            $direction = $request->stock_order === 'highest' ? 'desc' : 'asc';
            $query->orderBy('stock', $direction);
        } else {
            $query->latest();
        }

        $books = $query->filter($request->all(), ['title', 'writer'])
                    ->paginate(10)
                    ->withQueryString();
        return view('admin.pages.books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.pages.books.create', compact('categories'));
    }
  
    public function store(Request $request)
    {
            $rules = [
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'title' => 'required|string|max:255',
            'writer' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'language' => 'nullable|string|max:100',
            'category_id' => 'required|exists:categories,id',
        ];

        $messages = [
            'required' => ':attribute wajib diisi.',
            'image' => 'File harus berupa gambar.',
            'mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau svg.',
            'max' => 'Ukuran :attribute maksimal 10MB.',
            'integer' => ':attribute harus berupa angka.',
            'min' => ':attribute minimal :min.',
            'exists' => 'Kategori tidak valid.',
        ];

        $attributes = [
            'cover' => 'Cover buku',
            'title' => 'Judul buku',
            'writer' => 'Penulis',
            'publisher' => 'Penerbit',
            'description' => 'Deskripsi',
            'stock' => 'Stok',
            'year' => 'Tahun terbit',
            'language' => 'Bahasa',
            'category_id' => 'Kategori',
        ];

        $request->validate($rules, $messages, $attributes);

        // 1. Cek apakah buku sudah ada (termasuk yang di sampah/deleted_at tidak null)
        $existingBook = Book::withTrashed()
            ->where('title', $request->title)
            ->where('writer', $request->writer)
            ->first();

        if ($existingBook) {
            // 2. Jika buku ada tapi TIDAK di sampah, berarti memang duplikat aktif
            if (!$existingBook->trashed()) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['title' => 'Buku dengan judul dan penulis ini sudah terdaftar dan aktif.']);
            }

            // 3. Jika buku ada DI SAMPAH, kita restore dan update datanya
            if ($request->file('cover')) {
                $existingBook->cover = $request->file('cover')->store('covers', 'public');
            }
            
            $existingBook->publisher = $request->publisher;
            $existingBook->description = $request->description;
            $existingBook->stock = $request->stock ?? 0;
            $existingBook->year = $request->year;
            $existingBook->language = $request->language;
            $existingBook->category_id = $request->category_id;
            $existingBook->status = 'archived'; // Reset status ke default jika perlu
            
            $existingBook->restore(); 
            $existingBook->save();

            return redirect()->route('admin.books')->with('success', 'Buku lama telah dipulihkan kembali!');
        }

        // 4. Jika benar-benar data baru, jalankan Create biasa
        Book::create([
            'cover' => $request->file('cover') ? $request->file('cover')->store('covers', 'public') : null,
            'title' => $request->title,
            'writer' => $request->writer,
            'publisher' => $request->publisher,
            'description' => $request->description,
            'stock' => $request->stock ?? 0,
            'year' => $request->year,
            'language' => $request->language,
            'category_id' => $request->category_id,
            'status' => 'archived',
        ]);

        return redirect()->route('admin.books')->with('success', 'Buku baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $books = Book::findOrFail($id);
        $categories = Category::all();
        return view('admin.pages.books.edit', compact('books', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cover'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'title'       => ['nullable', 'string', 'max:255', 
                function ($attribute, $value, $fail) use ($request, $id) {
                    if (!empty($value)) {
                        $exists = Book::withTrashed()
                            ->where('title', $value)
                            ->where('writer', $request->writer ?? Book::find($id)->writer)
                            ->where('id', '!=', $id) 
                            ->exists();
                        if ($exists) {
                            $fail('Buku dengan judul dan penulis ini sudah terdaftar.');
                        }
                    }
                },
            ],
            'writer'      => 'nullable|string|max:255',
            'publisher'   => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'stock'       => 'nullable|integer|min:0',
            'year'        => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'language'    => 'nullable|string|max:100', 
            'category_id' => 'nullable|exists:categories,id',
        ], [
            'image'    => 'Cover harus berupa gambar.',
            'integer'  => ':attribute harus berupa angka.', 
            'min'      => ':attribute minimal :min.',
            'max'      => ':attribute maksimal :max.', 
            'mimes'    => 'Format gambar tidak valid.',
        ], [
            'title'       => 'Judul buku',
            'writer'      => 'Penulis',
            'publisher'   => 'Penerbit',
            'stock'       => 'Stok',
            'language'    => 'Bahasa', 
            'year'        => 'Tahun terbit',
            'description' => 'Deskripsi',
            'category_id' => 'Kategori',
        ]);

        $books = Book::findOrFail($id);
    
        $data = array_filter($request->only([
            'title', 'writer', 'publisher', 'description', 'stock', 'year', 'language', 'category_id'
        ]), function($value) {
            return $value !== null && $value !== '';
        });

        if ($request->hasFile('cover')) {
            if ($books->cover && Storage::disk('public')->exists($books->cover)) {
                Storage::disk('public')->delete($books->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $books->update($data);

        return redirect()->route('admin.books')->with('success', 'Buku berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $books = Book::findOrFail($id);

        $hasActiveTransaction = $books->transaction()->whereIn('status', ['pending', 'borrowed'])->exists();

        if ($hasActiveTransaction) {
            return redirect()->route('admin.books')->with('error', 'Buku tidak dapat dihapus karena masih terdapat transaksi peminjaman oleh pengguna.');
        }

        $books->delete();

        return redirect()->route('admin.books')->with('success', 'Buku berhasil dihapus.');
    }

    public function updateStatus(Book $book)
    {
        if ($book->status === 'published') {
            $book->update(['status' => 'archived']);
            $message = "Buku berhasil ditarik ke arsip.";
        } else {
            $book->update(['status' => 'published']);
            $message = "Buku berhasil diterbitkan.";
        }

        return back()->with('success', $message);
    }

    public function student(Request $request) 
    {
        $query = Book::published()->with('category');

        if ($request->filled('stock_order')) {
            $direction = $request->stock_order === 'highest' ? 'desc' : 'asc';
            $query->orderBy('stock', $direction);
        } else {
            $query->latest();
        }
        
        $books = $query->filter($request->all(), ['title', 'writer'])->paginate(10)->withQueryString();

        $categories = Category::withCount('books')->get();

        return view('student.pages.books.index', compact('books', 'categories'));
    }

    public function show(Book $book)
    {
        // Jika buku diarsip DAN yang akses bukan admin, arahkan balik/error
        if ($book->status === 'archived' && auth()->user()->role !== 'admin') {
            abort(404); // Seolah-olah buku tidak ada
        }

        $book->load('category');

        // Pastikan rekomendasi buku lain juga hanya yang 'published'
        $relatedBooks = Book::published()
            ->where('category_id', $book->category_id)->where('id', '!=', $book->id)->limit(4)->get();

        return view('student.pages.books.show', compact('book', 'relatedBooks'));
    }

    public function adminShow(Book $book)
    {
        $book->load('category');
        
        return view('admin.pages.books.show', compact('book'));
    }
}
