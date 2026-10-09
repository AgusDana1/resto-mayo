@extends('layouts.admin')

@section('title', 'Kitchen Display System (Dapur) - Resto Mayo')

@section('content')
<div class="space-y-8">

    <!-- Kitchen Header & KDS Status -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-gray-100 pb-6">
        <div>
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-resto-red-100 text-resto-red-800 border border-resto-red-200">
                    <span class="w-2 h-2 rounded-full bg-resto-red-700 animate-pulse mr-1.5"></span>
                    Live Kitchen Display (KDS)
                </span>
                <span class="text-xs text-gray-400">•</span>
                <span class="text-xs text-gray-400 font-medium">FIFO (First-In, First-Out)</span>
            </div>
            <h1 class="text-3xl font-bold tracking-tight text-resto-red-900 mt-1 font-poppins">
                Antrean Dapur & Pengolahan Menu
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Pantau tiket masakan yang masuk dari meja pelanggan dan perbarui proses masak secara real-time.
            </p>
        </div>

        <div class="flex items-center space-x-3">
            <button type="button" 
                    onclick="window.location.reload()" 
                    class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-white hover:bg-gray-50 text-gray-700 font-medium text-xs border border-gray-200 transition-colors shadow-xs">
                <svg class="w-4 h-4 text-resto-gold-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span>Perbarui Antrean</span>
            </button>

            <a href="{{ route('admin.orders.index') }}" 
               class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-resto-red-800 hover:bg-resto-red-900 text-white font-medium text-xs transition-colors shadow-sm">
                <span>Daftar Semua Pesanan &rarr;</span>
            </a>
        </div>
    </div>

    <!-- Kitchen Status Tabs / Counters -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <!-- Tab: Semua Antrean -->
        <a href="{{ route('admin.kitchen.index') }}" 
           class="p-4 rounded-2xl border transition-all text-left {{ empty($filterStatus) ? 'bg-resto-red-50/50 border-resto-red-300 shadow-sm' : 'bg-white border-gray-100 hover:border-gray-200' }}">
            <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Total Tiket Dapur</span>
            <div class="flex items-baseline justify-between mt-1">
                <span class="text-2xl font-bold text-resto-red-900 font-poppins">{{ $pendingCount + $processingCount + $readyCount }}</span>
                <span class="text-xs text-gray-400 font-medium">Tiket Aktif</span>
            </div>
        </a>

        <!-- Tab: Menunggu Dimasak (Pending) -->
        <a href="{{ route('admin.kitchen.index', ['status' => 'pending']) }}" 
           class="p-4 rounded-2xl border transition-all text-left {{ ($filterStatus ?? '') === 'pending' ? 'bg-resto-gold-50 border-resto-gold-300 shadow-sm' : 'bg-white border-gray-100 hover:border-gray-200' }}">
            <div class="flex items-center space-x-1.5">
                <span class="w-2 h-2 rounded-full bg-resto-gold-600 animate-ping"></span>
                <span class="text-xs font-semibold uppercase tracking-wider text-resto-gold-800">Menunggu Dimasak</span>
            </div>
            <div class="flex items-baseline justify-between mt-1">
                <span class="text-2xl font-bold text-resto-gold-700 font-poppins">{{ $pendingCount }}</span>
                <span class="text-xs text-gray-400 font-medium">Tiket Baru</span>
            </div>
        </a>

        <!-- Tab: Sedang Dimasak (Processing) -->
        <a href="{{ route('admin.kitchen.index', ['status' => 'processing']) }}" 
           class="p-4 rounded-2xl border transition-all text-left {{ ($filterStatus ?? '') === 'processing' ? 'bg-blue-50 border-blue-300 shadow-sm' : 'bg-white border-gray-100 hover:border-gray-200' }}">
            <div class="flex items-center space-x-1.5">
                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                <span class="text-xs font-semibold uppercase tracking-wider text-blue-800">Sedang Dimasak</span>
            </div>
            <div class="flex items-baseline justify-between mt-1">
                <span class="text-2xl font-bold text-blue-900 font-poppins">{{ $processingCount }}</span>
                <span class="text-xs text-gray-400 font-medium">Di Kompor</span>
            </div>
        </a>

        <!-- Tab: Siap Disajikan (Ready) -->
        <a href="{{ route('admin.kitchen.index', ['status' => 'ready']) }}" 
           class="p-4 rounded-2xl border transition-all text-left {{ ($filterStatus ?? '') === 'ready' ? 'bg-emerald-50 border-emerald-300 shadow-sm' : 'bg-white border-gray-100 hover:border-gray-200' }}">
            <div class="flex items-center space-x-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                <span class="text-xs font-semibold uppercase tracking-wider text-emerald-800">Siap Disajikan</span>
            </div>
            <div class="flex items-baseline justify-between mt-1">
                <span class="text-2xl font-bold text-emerald-800 font-poppins">{{ $readyCount }}</span>
                <span class="text-xs text-gray-400 font-medium">Siap Diantar</span>
            </div>
        </a>
    </div>

    <!-- Active Kitchen Orders Grid (Tickets) -->
    @if($orders->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($orders as $order)
                @php
                    $durationMinutes = $order->created_at ? round(abs(now()->diffInMinutes($order->created_at))) : 0;
                    $isUrgent = $durationMinutes >= 20;
                @endphp

                <!-- KDS Order Ticket Card (Pure White with Distinct Status Accents) -->
                <div class="bg-white rounded-3xl border {{ $isUrgent ? 'border-resto-red-300 ring-2 ring-resto-red-100' : 'border-gray-200/90' }} shadow-sm hover:shadow-md transition-all flex flex-col justify-between overflow-hidden">
                    
                    <!-- Top Bar: Meja & Waktu Tiket -->
                    <div class="p-5 {{ $order->status === 'ready' ? 'bg-emerald-50/70 border-b border-emerald-100' : ($order->status === 'processing' ? 'bg-blue-50/70 border-b border-blue-100' : 'bg-resto-red-50/50 border-b border-resto-red-100') }} flex items-center justify-between">
                        <div class="flex items-center space-x-2.5">
                            <span class="w-10 h-10 rounded-xl bg-resto-red-900 text-resto-gold-200 font-bold text-sm flex items-center justify-center shadow-xs font-poppins">
                                {{ $order->table ? ($order->table->table_code ?? 'M' . $order->table->table_number) : 'M?' }}
                            </span>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm font-poppins">
                                    Meja {{ $order->table ? ($order->table->table_code ?? $order->table->table_number) : 'Meja' }}
                                </h3>
                                <p class="text-[11px] text-gray-500">
                                    {{ $order->customer_name }} • #{{ $order->order_number }}
                                </p>
                            </div>
                        </div>

                        <!-- Badge Durasi Tunggu -->
                        <div class="text-right">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold {{ $isUrgent ? 'bg-resto-red-100 text-resto-red-900 border border-resto-red-200 animate-pulse' : 'bg-white text-gray-600 border border-gray-200' }}">
                                <svg class="w-3 h-3 mr-1 text-resto-gold-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $durationMinutes }} mnt lalu
                            </span>
                        </div>
                    </div>

                    <!-- Items Cooking List -->
                    <div class="p-5 flex-1 space-y-3">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 block pb-1 border-b border-gray-50">
                            Menu Yang Harus Dimasak ({{ $order->items->sum('quantity') }} porsi):
                        </span>

                        <ul class="divide-y divide-gray-100 space-y-2">
                            @foreach($order->items as $item)
                                <li class="pt-2 first:pt-0">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start space-x-2.5">
                                            <!-- Kuantitas Menonjol -->
                                            <span class="w-6 h-6 rounded-lg bg-resto-gold-100 text-resto-gold-900 font-extrabold text-xs flex items-center justify-center flex-shrink-0 mt-0.5 border border-resto-gold-200">
                                                {{ $item->quantity }}x
                                            </span>
                                            <div>
                                                <h4 class="font-bold text-gray-900 text-sm font-poppins">
                                                    {{ $item->product ? $item->product->name : 'Menu Resto' }}
                                                </h4>
                                                @if($item->product && $item->product->category)
                                                    <span class="text-[10px] text-gray-400 font-medium">
                                                        {{ $item->product->category->name }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Catatan Khusus Koki (Special Request) -->
                                    @if($item->notes)
                                        <div class="mt-1.5 ml-8 p-2 rounded-xl bg-resto-red-50 border border-resto-red-200 text-xs text-resto-red-950 font-medium flex items-start space-x-1.5">
                                            <svg class="w-3.5 h-3.5 text-resto-red-700 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                            <span><strong>Catatan:</strong> {{ $item->notes }}</span>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Footer Action: Transition Workflow Button -->
                    <div class="p-4 bg-gray-50/70 border-t border-gray-100">
                        @if($order->status === 'pending')
                            <!-- Action: Mulai Masak -->
                            <form method="POST" action="{{ route('admin.kitchen.status', $order) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="processing">
                                <button type="submit" 
                                        class="w-full py-3 rounded-xl bg-resto-gold-700 hover:bg-resto-gold-800 text-white font-semibold text-xs tracking-wider uppercase transition-colors shadow-sm flex items-center justify-center space-x-2">
                                    <span>🔥 Mulai Masak Sekarang</span>
                                </button>
                            </form>
                        @elseif($order->status === 'processing')
                            <!-- Action: Selesai Masak & Siap Saji -->
                            <form method="POST" action="{{ route('admin.kitchen.status', $order) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="ready">
                                <button type="submit" 
                                        class="w-full py-3 rounded-xl bg-resto-red-800 hover:bg-resto-red-900 text-white font-semibold text-xs tracking-wider uppercase transition-colors shadow-sm flex items-center justify-center space-x-2">
                                    <span>🍽️ Selesai Masak & Siap Disajikan</span>
                                </button>
                            </form>
                        @elseif($order->status === 'ready')
                            <!-- Action: Telah Diantar ke Meja -->
                            <form method="POST" action="{{ route('admin.kitchen.status', $order) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" 
                                        class="w-full py-3 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-semibold text-xs tracking-wider uppercase transition-colors shadow-sm flex items-center justify-center space-x-2">
                                    <span>✅ Selesai Diantar ke Meja</span>
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State Dapur Bersih -->
        <div class="py-20 px-6 text-center bg-white rounded-3xl border border-gray-100 shadow-sm">
            <div class="w-20 h-20 mx-auto rounded-full bg-emerald-50 text-emerald-700 flex items-center justify-center mb-4 border border-emerald-100">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 font-poppins">Dapur Bersih & Tidak Ada Antrean!</h3>
            <p class="text-sm text-gray-500 max-w-md mx-auto mt-1">
                Semua pesanan makanan dan minuman telah berhasil dimasak dan disajikan ke meja pelanggan.
            </p>
            <div class="mt-6">
                <a href="{{ route('admin.orders.index') }}" 
                   class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition-colors">
                    <span>Lihat Riwayat Pesanan</span>
                </a>
            </div>
        </div>
    @endif

</div>
@endsection

