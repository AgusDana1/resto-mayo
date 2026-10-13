<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Table;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Menampilkan formulir checkout pesanan.
     */
    public function index(): View|RedirectResponse
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('menu.index');
        }

        $tables = Table::all();
        $totalAmount = array_sum(array_map(fn ($item) => $item['price'] * $item['quantity'], $cart));
        $totalQuantity = array_sum(array_column($cart, 'quantity'));

        return view('checkout.index', [
            'cart' => $cart,
            'tables' => $tables,
            'totalAmount' => $totalAmount,
            'totalQuantity' => $totalQuantity,
            'customerName' => session('customer_name'),
            'tableCode' => session('table_code'),
        ]);
    }

    /**
     * Memproses pesanan dari keranjang ke database Resto Mayo secara aman dan tervalidasi.
     */
    public function process(Request $request): RedirectResponse
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('menu.index')->with('error', 'Keranjang pesanan Anda kosong.');
        }

        // Sanitasi awal input nama pelanggan dari script dan tag HTML berbahaya
        $rawName = (string) $request->input('customer_name', '');
        $cleanCustomerName = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $rawName);
        $cleanCustomerName = strip_tags(trim((string) $cleanCustomerName));
        $request->merge(['customer_name' => $cleanCustomerName]);

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'min:2', 'max:100'],
            'table_id' => ['required', 'exists:tables,id'],
            'payment_method' => ['required', 'in:qris,bank_transfer,dana,gopay,shopeepay,ovo'],
        ], [
            'customer_name.required' => 'Nama pemesan wajib diisi.',
            'customer_name.min' => 'Nama pemesan minimal 2 karakter.',
            'customer_name.max' => 'Nama pemesan maksimal 100 karakter.',
            'table_id.required' => 'Nomor meja wajib dipilih.',
            'payment_method.required' => 'Pilih salah satu metode pembayaran.',
        ]);

        // Verifikasi ketersediaan dan harga produk langsung dari database untuk mencegah price tampering
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $verifiedItems = [];
        $totalAmount = 0;

        foreach ($cart as $item) {
            $productId = $item['id'] ?? null;
            $product = $products->get($productId);

            if (! $product || ! $product->is_available) {
                $name = $product ? $product->name : ($item['name'] ?? 'Menu');

                return redirect()->route('cart.index')->with('error', "Menu '{$name}' saat ini sedang tidak tersedia atau habis. Harap sesuaikan pesanan Anda.");
            }

            $quantity = max(1, min(99, (int) ($item['quantity'] ?? 1)));
            $price = (float) $product->price;
            $lineTotal = $price * $quantity;
            $totalAmount += $lineTotal;

            $rawItemNotes = (string) ($item['notes'] ?? '');
            $cleanNotes = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $rawItemNotes);
            $cleanNotes = strip_tags(trim((string) $cleanNotes));
            $itemNotes = $cleanNotes !== '' ? mb_substr($cleanNotes, 0, 255) : null;

            $verifiedItems[] = [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price,
                'total' => $lineTotal,
                'notes' => $itemNotes,
            ];
        }

        $orderNumber = 'ORD-'.strtoupper(Str::random(6));

        // Eksekusi penyimpanan atomik dalam database transaction
        $order = DB::transaction(function () use ($validated, $cleanCustomerName, $orderNumber, $totalAmount, $verifiedItems) {
            $order = Order::create([
                'table_id' => $validated['table_id'],
                'customer_name' => $cleanCustomerName,
                'order_number' => $orderNumber,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'ordered_at' => now(),
            ]);

            foreach ($verifiedItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['total'],
                    'notes' => $item['notes'],
                ]);
            }

            Payment::create([
                'order_id' => $order->id,
                'method' => $validated['payment_method'],
                'status' => 'pending',
                'amount' => $totalAmount,
                'payment_reference' => 'PAY-'.strtoupper(Str::random(8)),
            ]);

            return $order;
        });

        // Simpan sesi meja & nama pemesan
        $table = Table::find($validated['table_id']);
        session([
            'customer_name' => $validated['customer_name'],
            'table_code' => $table->table_code ?? ('M'.$table->table_number),
        ]);

        // Kosongkan keranjang belanja
        session()->forget('cart');

        return redirect()->route('payment.show', $order)->with('success', "Pesanan #{$orderNumber} berhasil dikirim ke dapur!");
    }
}
