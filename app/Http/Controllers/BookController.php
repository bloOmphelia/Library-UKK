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
        $books = Book::with('category')->filter($request->all(), ['title'])->paginate(10)->withQueryString();
        return view('admin.pages.books.index', compact('books'));
    }

    public function student (Request $request) {
        $books = Book::with('category')->filter($request->all(), ['title'])->paginate(10)->withQueryString();
        return view('student.pages.books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.pages.books.create', compact('categories'));
    }
  
    public function store(Request $request)
    {
        $request->validate([
            'cover' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'title' => ['required', 'string', 'max:255',
                // Validasi: Judul harus unik untuk penulis yang sama
                function ($attribute, $value, $fail) use ($request) {
                    $exists = Book::where('title', $value)->where('writer', $request->writer)->exists();
                    if ($exists) {
                        $fail('Buku dengan judul dan penulis ini sudah terdaftar.');
                    }
                },
            ],
            'writer' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        Book::create([
            'cover' => $request->file('cover') ? $request->file('cover')->store('covers', 'public') : null,
            'title' => $request->title,
            'writer' => $request->writer,
            'publisher' => $request->publisher,
            'description' => $request->description,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.books')->with('success', 'Buku berhasil ditambahkan.');
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
            'cover' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'title' => ['sometimes', 'string', 'max:255',
                function ($attribute, $value, $fail) use ($request, $id) {
                    $exists = Book::where('title', $value)->where('writer', $request->writer)->where('id', '!=', $id) ->exists();
                        if ($exists) {
                            $fail('Buku dengan judul dan penulis ini sudah ada di database.');
                        }
                    },
                ],
            'writer' => 'sometimes|string|max:255',
            'publisher' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'stock' => 'sometimes|integer|min:0',
            'category_id' => 'sometimes|exists:categories,id',
        ]);

        $books = Book::findOrFail($id);
        $data = [
            'title' => $request->title,
            'writer' => $request->writer,
            'publisher' => $request->publisher,
            'description' => $request->description,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
        ];

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
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('admin.books')->with('success', 'Buku berhasil dihapus.');
    }
}
