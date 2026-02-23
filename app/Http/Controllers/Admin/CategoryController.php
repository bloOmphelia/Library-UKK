<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index (Request $request)
    {
        $categories = Category::filter($request->all(), ['name'])->latest()->paginate(10)->withQueryString();
        return view('admin.pages.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.pages.category.create');
    }
  
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.category')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $categories = Category::findOrFail($id);
        return view('admin.pages.category.edit', compact('categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255|unique:categories,name,'.$id,
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
        $categories->delete();

        return redirect()->route('admin.category')->with('success', 'Kategori berhasil dihapus.');
    }
}
