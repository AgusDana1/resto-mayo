<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Table;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
     * Memproses pesanan dari keranjang ke database Resto Mayo.
     */
    public function process(Request $request): RedirectResponse
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('menu.index')->with('error', 'Keranjang pesanan Anda kosong.');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'table_id' => 'required|exists:tables,id',
            'payment_method' => 'required|in:qris,bank_transfer,dana,gopay,shopeepay,ovo',
        ], [
            'customer_name.required' => 'Nama pemesan wajib diisi.',
            'table_id.required' => 'Nomor meja wajib dipilih.',
            'payment_method.required' => 'Pilih salah satu metode pembayaran.',
        ]);

        $totalAmount = array_sum(array_map(fn ($item) => $item['price'] * $item['quantity'], $cart));
        $orderNumber = 'ORD-'.strtoupper(Str::random(6));

        $order = Order::create([
            'table_id' => $validated['table_id'],
            'customer_name' => $validated['customer_name'],
            'order_number' => $orderNumber,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'ordered_at' => now(),
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['price'] * $item['quantity'],
                'notes' => $item['notes'] ?? null,
            ]);
        }

        Payment::create([
            'order_id' => $order->id,
            'method' => $validated['payment_method'],
            'status' => 'pending',
            'amount' => $totalAmount,
            'payment_reference' => 'PAY-'.strtoupper(Str::random(8)),
        ]);

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
