<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    /**
     * Menampilkan halaman instruksi pembayaran pesanan.
     */
    public function index(Order $order): View
    {
        $order->load([
            'items.product',
            'table',
            'payment',
        ]);

        return view('payment.show', compact('order'));
    }

    /**
     * Konfirmasi pembayaran mandiri oleh pelanggan (setelah transfer / bayar via e-wallet).
     */
    public function confirm(Request $request, Order $order): RedirectResponse
    {
        if ($order->payment) {
            $order->payment->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        }

        return redirect()
            ->route('payment.show', $order)
            ->with('success', 'Terima kasih! Pembayaran Anda telah kami catat. Pesanan Anda segera disiapkan oleh koki Resto Mayo.');
    }
}
