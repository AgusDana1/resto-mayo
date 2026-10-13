<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan beserta filter status dan pencarian.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $cleanSearch = $search ? mb_substr(strip_tags(trim(preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $search))), 0, 100) : null;
        $status = $request->query('status');

        $orders = Order::with([
            'table',
            'items.product',
            'payment',
        ])
            ->when($cleanSearch, function ($query, $cleanSearch) {
                $query->where(function ($q) use ($cleanSearch) {
                    $q->where('order_number', 'like', '%'.$cleanSearch.'%')
                        ->orWhere('customer_name', 'like', '%'.$cleanSearch.'%');
                });
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        // Ringkasan Statistik Pesanan
        $totalOrders = Order::count();
        $pendingCount = Order::where('status', 'pending')->count();
        $processingCount = Order::where('status', 'processing')->count();
        $readyCount = Order::where('status', 'ready')->count();
        $completedCount = Order::where('status', 'completed')->count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');

        return view('admin.orders.index', compact(
            'orders',
            'search',
            'status',
            'totalOrders',
            'pendingCount',
            'processingCount',
            'readyCount',
            'completedCount',
            'totalRevenue'
        ));
    }

    /**
     * Menampilkan detail lengkap suatu pesanan.
     */
    public function show(Order $order): View
    {
        $order->load([
            'table',
            'items.product',
            'payment',
        ]);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Memperbarui status pesanan dari panel admin.
     */
    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'string',
                'in:pending,processing,ready,completed,cancelled',
            ],
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        // Jika pesanan selesai atau dibatalkan, meja dapat dikosongkan kembali
        if (in_array($validated['status'], ['completed', 'cancelled']) && $order->table) {
            $order->table->update(['status' => 'available']);
        }

        $statusLabels = [
            'pending' => 'Menunggu Pembayaran / Dapur',
            'processing' => 'Sedang Dimasak di Dapur',
            'ready' => 'Siap Disajikan',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        $label = $statusLabels[$validated['status']] ?? $validated['status'];

        return redirect()
            ->back()
            ->with('success', "Status pesanan #{$order->order_number} berhasil diperbarui menjadi: {$label}.");
    }
}
