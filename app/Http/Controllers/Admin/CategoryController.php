<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index (Request $request)
    {
        $categories = Category::filter($request->only(['search']), ['name'])->latest()->paginate(10)->withQueryString();
        return view('admin.pages.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.pages.category.create');
    }
  
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.string'   => 'Nama kategori harus berupa teks.',
            'name.max'      => 'Nama kategori maksimal 255 karakter.',
        ]);

        $existingCategory = Category::withTrashed()
            ->where('name', $request->name)
            ->first();

        if ($existingCategory) {
            if (!$existingCategory->trashed()) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['name' => 'Nama kategori ini sudah ada dan aktif.']);
            }

            $existingCategory->restore();

            return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
        }

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $categories = Category::findOrFail($id);
        return view('admin.pages.category.edit', compact('categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$id,
        ], [
            'name.required' => 'Nama kategori tidak boleh kosong.',
            'name.unique'   => 'Nama kategori sudah digunakan.',
        ]);

        $categories = Category::findOrFail($id);
        $categories->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.category')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $categories = Category::findOrFail($id);

            if ($categories->books()->exists()) {
            return redirect()->route('admin.category')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki data buku terkait.');
        }

        $categories->delete();

        return redirect()->route('admin.category')->with('success', 'Kategori berhasil dihapus.');
    }
}
