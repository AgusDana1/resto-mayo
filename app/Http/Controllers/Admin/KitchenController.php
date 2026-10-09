<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KitchenController extends Controller
{
    /**
     * Menampilkan antrean pesanan di dapur (Kitchen Display System).
     * Menggunakan urutan First-In First-Out (FIFO) agar pesanan terdahulu dimasak lebih dulu.
     */
    public function index(Request $request): View
    {
        $filterStatus = $request->query('status');

        $activeStatuses = ['pending', 'processing', 'ready'];

        $orders = Order::with([
            'table',
            'items.product',
            'payment',
        ])
            ->whereIn('status', $activeStatuses)
            ->when($filterStatus && in_array($filterStatus, $activeStatuses), function ($query) use ($filterStatus) {
                $query->where('status', $filterStatus);
            })
            ->orderBy('created_at', 'asc') // FIFO
            ->get();

        // Hitung kuantitas per status di dapur
        $pendingCount = Order::where('status', 'pending')->count();
        $processingCount = Order::where('status', 'processing')->count();
        $readyCount = Order::where('status', 'ready')->count();

        return view('admin.kitchen.index', compact(
            'orders',
            'pendingCount',
            'processingCount',
            'readyCount',
            'filterStatus'
        ));
    }

    /**
     * Memperbarui alur status pesanan langsung dari stasiun dapur.
     */
    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'string',
                'in:pending,processing,ready,completed',
            ],
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        // Jika pesanan telah disajikan (completed), kosongkan meja jika perlu
        if ($validated['status'] === 'completed' && $order->table) {
            $order->table->update(['status' => 'available']);
        }

        $messages = [
            'processing' => "Pesanan #{$order->order_number} sedang dimasak oleh tim dapur.",
            'ready' => "Pesanan #{$order->order_number} telah matang dan SIAP DISAJIKAN ke meja pelanggan!",
            'completed' => "Pesanan #{$order->order_number} berhasil disajikan ke meja.",
            'pending' => "Pesanan #{$order->order_number} dikembalikan ke antrean tunggu.",
        ];

        return redirect()
            ->back()
            ->with('success', $messages[$validated['status']] ?? "Status pesanan #{$order->order_number} berhasil diperbarui.");
    }
}
