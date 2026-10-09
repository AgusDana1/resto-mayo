<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $pendingOrders = Order::where(
            'status',
            'pending'
        )->count();

        return view('admin.dashboard', compact('pendingOrders'));
    }
}
