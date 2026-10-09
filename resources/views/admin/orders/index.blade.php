@extends('layouts.admin')

@section('title', 'Manajemen Pesanan - Resto Mayo')

@section('content')
<div class="space-y-8">

    <!-- Page Header & Action Bar -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-gray-100 pb-6">
        <div>
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-resto-gold-100 text-resto-gold-800 border border-resto-gold-200">
                    Kasir & Transaksi
                </span>
                <span class="text-xs text-gray-400">•</span>
                <span class="text-xs text-gray-400 font-medium">Resto Mayo Order Desk</span>
            </div>
            <h1 class="text-3xl font-bold tracking-tight text-resto-red-900 mt-1 font-poppins">
                Manajemen Pesanan
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Pantau seluruh pesanan meja pelanggan, status pembayaran, dan progres penyajian hidangan.
            </p>
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.kitchen.index') }}" 
               class="inline-flex items-center space-x-2 px-5 py-3 rounded-xl bg-resto-gold-50 hover:bg-resto-gold-100 text-resto-gold-900 font-semibold text-sm border border-resto-gold-300/80 transition-all shadow-xs">
                <svg class="w-5 h-5 text-resto-gold-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343a7.975 7.975 0 010 11.314z"/>
                </svg>
                <span>Buka Live Dapur &rarr;</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Total Pesanan -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-resto-red-50 rounded-full group-hover:scale-125 transition-transform duration-300 -z-0"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Pesanan</p>
                    <h3 class="text-3xl font-bold text-resto-red-900 mt-1 font-poppins">{{ $totalOrders }}</h3>
                    <p class="text-xs text-gray-400 mt-1">Seluruh riwayat order</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-resto-red-100 text-resto-red-800 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 2: Menunggu / Pending -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-resto-gold-50 rounded-full group-hover:scale-125 transition-transform duration-300 -z-0"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-resto-gold-800">Menunggu Dapur</p>
                    <h3 class="text-3xl font-bold text-resto-gold-700 mt-1 font-poppins">{{ $pendingCount }}</h3>
                    <p class="text-xs text-gray-400 mt-1">Perlu segera diproses</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-resto-gold-100 text-resto-gold-800 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 3: Sedang Dimasak & Siap -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-blue-50 rounded-full group-hover:scale-125 transition-transform duration-300 -z-0"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-blue-800">Dalam Dapur</p>
                    <h3 class="text-3xl font-bold text-blue-900 mt-1 font-poppins">{{ $processingCount + $readyCount }}</h3>
                    <p class="text-xs text-gray-400 mt-1">{{ $processingCount }} masak, {{ $readyCount }} siap</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-800 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343a7.975 7.975 0 010 11.314z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 4: Total Pendapatan Selesai -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-emerald-50 rounded-full group-hover:scale-125 transition-transform duration-300 -z-0"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-emerald-700">Total Omset</p>
                    <h3 class="text-2xl font-bold text-emerald-800 mt-1 font-poppins">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-1">{{ $completedCount }} pesanan selesai</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-col sm:flex-row items-center justify-between gap-4">
            
            <!-- Pencarian Nomor Order & Nama -->
            <div class="relative w-full sm:w-96">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" 
                       name="search" 
                       value="{{ $search ?? '' }}" 
                       placeholder="Cari no. order atau nama pelanggan..." 
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-resto-red-700 focus:border-transparent transition-all">
            </div>

            <!-- Filter Status Dropdown -->
            <div class="flex items-center space-x-2 w-full sm:w-auto justify-end">
                <select name="status" 
                        onchange="this.form.submit()"
                        class="px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-resto-red-700 focus:border-transparent transition-all text-gray-700 bg-white">
                    <option value="">Semua Status Pesanan</option>
                    <option value="pending" {{ ($status ?? '') === 'pending' ? 'selected' : '' }}>Menunggu (Pending)</option>
                    <option value="processing" {{ ($status ?? '') === 'processing' ? 'selected' : '' }}>Sedang Dimasak (Processing)</option>
                    <option value="ready" {{ ($status ?? '') === 'ready' ? 'selected' : '' }}>Siap Disajikan (Ready)</option>
                    <option value="completed" {{ ($status ?? '') === 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                    <option value="cancelled" {{ ($status ?? '') === 'cancelled' ? 'selected' : '' }}>Dibatalkan (Cancelled)</option>
                </select>

                <button type="submit" 
                        class="px-4 py-2.5 rounded-xl bg-resto-red-800 hover:bg-resto-red-900 text-white text-sm font-medium transition-colors shadow-sm">
                    Filter
                </button>

                @if(!empty($search) || !empty($status))
                    <a href="{{ route('admin.orders.index') }}" 
                       class="px-3.5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium transition-colors"
                       title="Reset Filter">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Orders Data Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @if($orders->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/80 border-b border-gray-100 text-xs uppercase font-semibold text-gray-500 tracking-wider">
                            <th class="py-4 px-6 w-16 text-center">No</th>
                            <th class="py-4 px-6">Nomor Order & Meja</th>
                            <th class="py-4 px-6">Pelanggan</th>
                            <th class="py-4 px-6">Rincian Hidangan</th>
                            <th class="py-4 px-6 text-right">Total Tagihan</th>
                            <th class="py-4 px-6 text-center">Status Pembayaran</th>
                            <th class="py-4 px-6 text-center">Status Pesanan</th>
                            <th class="py-4 px-6 text-right">Ubah Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @foreach($orders as $index => $order)
                            <tr class="hover:bg-resto-red-50/20 transition-colors group">
                                <!-- No -->
                                <td class="py-4 px-6 text-center font-medium text-gray-400">
                                    {{ $orders->firstItem() + $index }}
                                </td>

                                <!-- No Order & Meja -->
                                <td class="py-4 px-6">
                                    <div class="font-bold text-resto-red-900 font-poppins">
                                        #{{ $order->order_number }}
                                    </div>
                                    <div class="flex items-center space-x-1.5 mt-0.5">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-resto-gold-50 text-resto-gold-800 border border-resto-gold-200">
                                            Meja {{ $order->table ? ($order->table->table_code ?? $order->table->table_number) : '-' }}
                                        </span>
                                        <span class="text-[11px] text-gray-400">
                                            {{ $order->created_at ? $order->created_at->format('H:i') : '' }} WIB
                                        </span>
                                    </div>
                                </td>

                                <!-- Pelanggan -->
                                <td class="py-4 px-6">
                                    <div class="font-semibold text-gray-800">
                                        {{ $order->customer_name }}
                                    </div>
                                    <span class="text-[11px] text-gray-400">
                                        {{ $order->created_at ? $order->created_at->format('d M Y') : '-' }}
                                    </span>
                                </td>

                                <!-- Rincian Hidangan -->
                                <td class="py-4 px-6">
                                    <div class="space-y-1 max-w-xs">
                                        @foreach($order->items as $item)
                                            <div class="text-xs text-gray-700 flex items-start space-x-1">
                                                <span class="font-bold text-resto-gold-800">{{ $item->quantity }}x</span>
                                                <span class="font-medium truncate">{{ $item->product ? $item->product->name : 'Item' }}</span>
                                            </div>
                                            @if($item->notes)
                                                <div class="text-[11px] text-resto-red-700 italic pl-4">
                                                    "{{ $item->notes }}"
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </td>

                                <!-- Total Tagihan -->
                                <td class="py-4 px-6 text-right">
                                    <span class="font-bold text-resto-gold-800 font-poppins text-sm block">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </span>
                                    <span class="text-[10px] text-gray-400">{{ $order->items->sum('quantity') }} porsi</span>
                                </td>

                                <!-- Pembayaran -->
                                <td class="py-4 px-6 text-center">
                                    @if($order->payment)
                                        @if($order->payment->status === 'paid')
                                            <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <span>Lunas</span>
                                            </span>
                                            <div class="text-[10px] uppercase font-bold text-gray-400 mt-1">
                                                {{ $order->payment->method }}
                                            </div>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-resto-gold-50 text-resto-gold-800 border border-resto-gold-200">
                                                {{ ucfirst($order->payment->status) }}
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-xs text-gray-400 italic">Belum Ada</span>
                                    @endif
                                </td>

                                <!-- Status Pesanan -->
                                <td class="py-4 px-6 text-center">
                                    @switch($order->status)
                                        @case('pending')
                                            <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-resto-gold-100 text-resto-gold-800 border border-resto-gold-300">
                                                <span class="w-1.5 h-1.5 rounded-full bg-resto-gold-600 animate-ping"></span>
                                                <span>Menunggu</span>
                                            </span>
                                            @break
                                        @case('processing')
                                            <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                                <span>Dimasak</span>
                                            </span>
                                            @break
                                        @case('ready')
                                            <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-resto-red-50 text-resto-red-800 border border-resto-red-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-resto-red-600"></span>
                                                <span>Siap Saji</span>
                                            </span>
                                            @break
                                        @case('completed')
                                            <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                <span>Selesai</span>
                                            </span>
                                            @break
                                        @case('cancelled')
                                            <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-500 border border-gray-200">
                                                <span>Dibatalkan</span>
                                            </span>
                                            @break
                                    @endswitch
                                </td>

                                <!-- Aksi Update Status Langsung -->
                                <td class="py-4 px-6 text-right">
                                    <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="inline-flex items-center space-x-1">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" 
                                                onchange="this.form.submit()" 
                                                class="px-2.5 py-1.5 rounded-lg border border-gray-200 text-xs font-medium focus:ring-2 focus:ring-resto-red-700 focus:outline-none bg-white">
                                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Dimasak</option>
                                            <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>Siap Saji</option>
                                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Batal</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                {{ $orders->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="py-16 px-6 text-center">
                <div class="w-20 h-20 mx-auto rounded-full bg-resto-red-50 text-resto-red-800 flex items-center justify-center mb-4 border border-resto-red-100">
                    <svg class="w-10 h-10 text-resto-gold-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-resto-red-900 font-poppins">Belum Ada Pesanan Masuk</h3>
                <p class="text-sm text-gray-500 max-w-md mx-auto mt-1">
                    Pesanan dari pelanggan yang memilih menu makanan dan minuman akan otomatis tampil di sini.
                </p>
            </div>
        @endif
    </div>

</div>
@endsection

