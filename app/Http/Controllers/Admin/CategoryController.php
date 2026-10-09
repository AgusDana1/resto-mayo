<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar semua kategori beserta pencarian dan jumlah produk.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $categories = Category::withCount('products')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%'.$search.'%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.categories.index', compact('categories', 'search'));
    }

    /**
     * Menampilkan formulir penambahan kategori baru.
     */
    public function create(): View
    {
        return view('admin.categories.create');
    }

    /**
     * Menyimpan kategori baru ke database sesuai aturan migration.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:categories,name',
            ],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.string' => 'Nama kategori harus berupa teks.',
            'name.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            'name.unique' => 'Nama kategori ini sudah terdaftar.',
        ]);

        $validated['name'] = trim($validated['name']);

        Category::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail kategori dan produk yang terhubung.
     */
    public function show(Category $category): View
    {
        $category->loadCount('products');

        $products = $category->products()
            ->latest()
            ->paginate(8);

        return view('admin.categories.show', compact('category', 'products'));
    }

    /**
     * Menampilkan formulir edit kategori.
     */
    public function edit(Category $category): View
    {
        $category->loadCount('products');

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Memperbarui data kategori.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->ignore($category->id),
            ],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.string' => 'Nama kategori harus berupa teks.',
            'name.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            'name.unique' => 'Nama kategori ini sudah terdaftar.',
        ]);

        $validated['name'] = trim($validated['name']);

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Menghapus kategori.
     *
     * Berdasarkan relasi restrictOnDelete pada migration tabel products,
     * kategori yang masih memiliki produk tidak dapat dihapus sebelum produknya dipindahkan/dihapus.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $productsCount = $category->products()->count();

        if ($productsCount > 0) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', "Kategori '{$category->name}' tidak dapat dihapus karena masih terkait dengan {$productsCount} produk. Harap pindahkan atau hapus produk terlebih dahulu.");
        }

        $categoryName = $category->name;
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', "Kategori '{$categoryName}' berhasil dihapus.");
    }
}
