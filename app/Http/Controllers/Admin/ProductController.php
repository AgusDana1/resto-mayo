<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Menampilkan semua produk beserta filter pencarian dan kategori.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $cleanSearch = $search ? mb_substr(strip_tags(trim(preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $search))), 0, 100) : null;
        $categoryId = $request->query('category_id');
        $status = $request->query('status');

        $products = Product::with('category')
            ->when($cleanSearch, function ($query, $cleanSearch) {
                $query->where(function ($q) use ($cleanSearch) {
                    $q->where('name', 'like', '%'.$cleanSearch.'%')
                        ->orWhere('description', 'like', '%'.$cleanSearch.'%');
                });
            })
            ->when($categoryId, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($status !== null && $status !== '', function ($query) use ($status) {
                $query->where('is_available', (bool) $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories', 'search', 'categoryId', 'status'));
    }

    /**
     * Menampilkan form tambah produk.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Menyimpan produk baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'image_url' => [
                'nullable',
                'url',
                'max:1000',
            ],

            'is_available' => [
                'nullable',
                'boolean',
            ],
        ], [
            'category_id.required' => 'Pilih salah satu kategori menu.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'name.required' => 'Nama produk menu wajib diisi.',
            'price.required' => 'Harga produk wajib ditentukan.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh kurang dari 0.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'image.max' => 'Ukuran file gambar maksimal 2MB.',
            'image_url.url' => 'Format link URL gambar tidak valid.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload gambar atau gunakan Image URL
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('products', 'public');
        } elseif (! empty($request->input('image_url'))) {
            $validated['image'] = $request->input('image_url');
        }
        unset($validated['image_url']);

        /*
        |--------------------------------------------------------------------------
        | Status ketersediaan & Sanitasi Input
        |--------------------------------------------------------------------------
        */

        $validated['name'] = strip_tags(trim($validated['name']));
        if (! empty($validated['description'])) {
            $validated['description'] = strip_tags(trim($validated['description']));
        }

        $validated['is_available'] = $request->boolean('is_available');

        /*
        |--------------------------------------------------------------------------
        | Simpan produk
        |--------------------------------------------------------------------------
        */

        Product::create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail produk.
     */
    public function show(Product $product): View
    {
        $product->load('category');

        return view('admin.products.show', compact('product'));
    }

    /**
     * Menampilkan form edit produk.
     */
    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact(
            'product',
            'categories'
        ));
    }

    /**
     * Memperbarui produk.
     */
    public function update(
        Request $request,
        Product $product
    ): RedirectResponse {

        $validated = $request->validate([
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'image_url' => [
                'nullable',
                'url',
                'max:1000',
            ],

            'is_available' => [
                'nullable',
                'boolean',
            ],
        ], [
            'category_id.required' => 'Pilih salah satu kategori menu.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'name.required' => 'Nama produk menu wajib diisi.',
            'price.required' => 'Harga produk wajib ditentukan.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh kurang dari 0.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'image.max' => 'Ukuran file gambar maksimal 2MB.',
            'image_url.url' => 'Format link URL gambar tidak valid.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload gambar baru atau update Image URL
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada di storage lokal
            if (
                $product->image &&
                ! str_starts_with($product->image, 'http') &&
                Storage::disk('public')->exists($product->image)
            ) {
                Storage::disk('public')->delete($product->image);
            }

            // Simpan gambar baru
            $validated['image'] = $request
                ->file('image')
                ->store('products', 'public');
        } elseif (! empty($request->input('image_url'))) {
            $validated['image'] = $request->input('image_url');
        }
        unset($validated['image_url']);

        /*
        |--------------------------------------------------------------------------
        | Status ketersediaan & Sanitasi Input
        |--------------------------------------------------------------------------
        */

        $validated['name'] = strip_tags(trim($validated['name']));
        if (! empty($validated['description'])) {
            $validated['description'] = strip_tags(trim($validated['description']));
        }

        $validated['is_available'] = $request->boolean('is_available');

        /*
        |--------------------------------------------------------------------------
        | Update produk
        |--------------------------------------------------------------------------
        */

        $product->update($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menonaktifkan produk.
     *
     * Produk tidak dihapus permanen karena mungkin
     * sudah digunakan pada order sebelumnya.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->update([
            'is_available' => false,
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil dinonaktifkan.');
    }
}
