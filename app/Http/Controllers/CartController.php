<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Menampilkan halaman keranjang pesanan.
     */
    public function index(): View
    {
        $cart = session('cart', []);

        $totalAmount = 0;
        $totalQuantity = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
            $totalQuantity += $item['quantity'];
        }

        return view('cart.index', compact('cart', 'totalAmount', 'totalQuantity'));
    }

    /**
     * Menambahkan produk ke keranjang belanja (mendukung AJAX tanpa reload halaman).
     */
    public function add(Request $request, Product $product): JsonResponse|RedirectResponse
    {
        if (! $product->is_available) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => "Menu {$product->name} saat ini sedang tidak tersedia atau habis.",
                ], 422);
            }

            return redirect()->back()->with('error', "Menu {$product->name} saat ini sedang tidak tersedia atau habis.");
        }

        $quantity = max(1, min(99, (int) $request->input('quantity', 1)));
        $rawNotes = $request->input('notes');
        $notes = $rawNotes ? mb_substr(strip_tags(trim((string) $rawNotes)), 0, 255) : '';

        $cart = session('cart', []);
        $id = $product->id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = min(99, $cart[$id]['quantity'] + $quantity);
            if ($notes !== '') {
                $cart[$id]['notes'] = $notes;
            }
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'image' => $product->image,
                'quantity' => $quantity,
                'notes' => $notes,
            ];
        }

        session(['cart' => $cart]);

        $totalItems = count($cart);
        $totalQuantity = array_sum(array_column($cart, 'quantity'));
        $totalAmount = array_sum(array_map(fn ($item) => $item['price'] * $item['quantity'], $cart));

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "{$product->name} berhasil ditambahkan ke pesanan!",
                'product_name' => $product->name,
                'cartCount' => $totalItems,
                'totalQuantity' => $totalQuantity,
                'totalAmount' => $totalAmount,
                'cart' => $cart,
            ]);
        }

        return redirect()->back()->with('success', "{$product->name} berhasil ditambahkan ke pesanan!");
    }

    /**
     * Memperbarui kuantitas produk di dalam keranjang.
     */
    public function update(Request $request, Product $product): JsonResponse|RedirectResponse
    {
        $action = $request->input('action');
        $cart = session('cart', []);
        $id = $product->id;

        if (isset($cart[$id])) {
            if ($action === 'increase') {
                $cart[$id]['quantity'] = min(99, $cart[$id]['quantity'] + 1);
            } elseif ($action === 'decrease') {
                $cart[$id]['quantity'] -= 1;
                if ($cart[$id]['quantity'] <= 0) {
                    unset($cart[$id]);
                }
            } elseif ($request->has('quantity')) {
                $newQty = max(0, min(99, (int) $request->input('quantity')));
                if ($newQty <= 0) {
                    unset($cart[$id]);
                } else {
                    $cart[$id]['quantity'] = $newQty;
                }
            }

            if ($request->has('notes') && isset($cart[$id])) {
                $cart[$id]['notes'] = mb_substr(strip_tags(trim((string) $request->input('notes'))), 0, 255);
            }

            session(['cart' => $cart]);
        }

        $totalItems = count($cart);
        $totalQuantity = array_sum(array_column($cart, 'quantity'));
        $totalAmount = array_sum(array_map(fn ($item) => $item['price'] * $item['quantity'], $cart));

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Keranjang berhasil diperbarui.',
                'cartCount' => $totalItems,
                'totalQuantity' => $totalQuantity,
                'totalAmount' => $totalAmount,
                'itemSubtotal' => isset($cart[$id]) ? $cart[$id]['price'] * $cart[$id]['quantity'] : 0,
                'itemQuantity' => isset($cart[$id]) ? $cart[$id]['quantity'] : 0,
                'cart' => $cart,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Pesanan berhasil diperbarui.');
    }

    /**
     * Menghapus produk dari keranjang belanja.
     */
    public function remove(Product $product): RedirectResponse|JsonResponse
    {
        $cart = session('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session(['cart' => $cart]);
        }

        if (request()->expectsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "{$product->name} dihapus dari keranjang.",
                'cartCount' => count($cart),
                'totalQuantity' => array_sum(array_column($cart, 'quantity')),
            ]);
        }

        return redirect()->route('cart.index')->with('success', "{$product->name} dihapus dari pesanan.");
    }

    /**
     * Mengosongkan seluruh isi keranjang belanja.
     */
    public function clear(): RedirectResponse
    {
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Pesanan berhasil dikosongkan.');
    }
}
