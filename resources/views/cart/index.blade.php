@extends('layouts.app')

@section('title', 'Keranjang Pesanan - Resto Mayo')

@section('content')

    <!-- Top Accent Bar -->
    <div class="h-1.5 w-full bg-gradient-to-r from-resto-red-900 via-resto-red-700 to-resto-gold-700"></div>

    <!-- Navigation Header -->
    <header class="bg-white border-b border-gray-100 sticky top-0 z-40 shadow-xs">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="flex justify-between h-14 sm:h-20 items-center">
                
                <!-- Brand & Back Button -->
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <a href="{{ route('menu.index') }}" 
                       class="inline-flex items-center space-x-1 sm:space-x-1.5 px-2.5 py-1.5 sm:px-3 sm:py-2 rounded-lg sm:rounded-xl text-gray-600 hover:text-resto-red-800 hover:bg-resto-red-50 text-xs font-semibold transition-colors border border-gray-200 hover:border-resto-red-200">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span class="hidden sm:inline">Tambah Menu Lagi</span>
                    </a>

                    <div class="h-5 sm:h-6 w-px bg-gray-200 hidden sm:block"></div>

                    <a href="{{ route('menu.index') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-resto-red-800 text-resto-gold-200 flex items-center justify-center shadow-xs border border-resto-gold-700/40">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm5-3v8h2.5v8H21V2c-2.76 0-5 2.24-5 4z"/>
                            </svg>
                        </div>
                        <span class="text-lg sm:text-xl font-bold tracking-tight text-resto-red-900 font-poppins">Resto<span class="text-resto-gold-700">Mayo</span></span>
                    </a>
                </div>

                <!-- Right Side: Meja & Pelanggan Info -->
                <div class="flex items-center space-x-2 sm:space-x-3">
                    @if(session('table_code'))
                        <div class="text-right">
                            <span class="block text-[8px] sm:text-[10px] uppercase tracking-wider text-gray-400 font-semibold">Meja Anda</span>
                            <span class="inline-flex items-center px-2 py-0.5 sm:px-2.5 sm:py-0.5 rounded-full text-[10px] sm:text-xs font-bold bg-resto-gold-100 text-resto-gold-900 border border-resto-gold-200">
                                {{ session('table_code') }}
                            </span>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </header>

    <!-- Main Content Container (Full Width Responsive) -->
    <main class="flex-1 w-full max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-4 sm:py-12">

        <!-- Title & Subtitle -->
        <div class="border-b border-gray-100 pb-3 sm:pb-5 mb-4 sm:mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-2 sm:gap-4">
            <div>
                <h1 class="text-xl sm:text-3xl font-extrabold text-resto-red-900 font-poppins tracking-tight">
                    Pesanan Anda
                </h1>
                <p class="text-[11px] sm:text-sm text-gray-500 mt-0.5 sm:mt-1">
                    Periksa kembali daftar hidangan dan minuman sebelum mengirimkan pesanan ke dapur Resto Mayo.
                </p>
            </div>

            @if(!empty($cart))
                <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengosongkan keranjang?')">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-gray-400 hover:text-resto-red-800 hover:bg-resto-red-50 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        <span>Kosongkan Pesanan</span>
                    </button>
                </form>
            @endif
        </div>

        @if(!empty($cart) && count($cart) > 0)
            <!-- Cart Layout: 2 Columns on Desktop, Stacked on Mobile -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left Column: Items List (2 Cols) -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden divide-y divide-gray-100">
                        @foreach($cart as $id => $item)
                            @php
                                $nameLower = strtolower($item['name'] ?? '');
                                
                                // Auto culinary photo matcher for cart display
                                $itemImage = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=300&q=80';
                                if (str_contains($nameLower, 'nasi goreng')) {
                                    $itemImage = 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=300&q=80';
                                } elseif (str_contains($nameLower, 'risol') || str_contains($nameLower, 'mayo') || str_contains($nameLower, 'gorengan')) {
                                    $itemImage = 'https://images.unsplash.com/photo-1541529086526-db283c563270?w=300&q=80';
                                } elseif (str_contains($nameLower, 'dimsum') || str_contains($nameLower, 'siomay')) {
                                    $itemImage = 'https://images.unsplash.com/photo-1496116218417-1a781b1c416c?w=300&q=80';
                                } elseif (str_contains($nameLower, 'kopi') || str_contains($nameLower, 'coffee')) {
                                    $itemImage = 'https://images.unsplash.com/photo-1517701550927-30cf4ba1dba5?w=300&q=80';
                                } elseif (str_contains($nameLower, 'teh') || str_contains($nameLower, 'tea') || str_contains($nameLower, 'jus') || str_contains($nameLower, 'minum')) {
                                    $itemImage = 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=300&q=80';
                                }

                                if (!empty($item['image'])) {
                                    $itemImage = str_starts_with($item['image'], 'http') ? $item['image'] : asset('storage/' . $item['image']);
                                }

                                $subtotal = $item['price'] * $item['quantity'];
                            @endphp

                            <div class="p-3 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4 hover:bg-resto-red-50/20 transition-colors">
                                <!-- Photo & Details -->
                                <div class="flex items-center space-x-3 sm:space-x-4">
                                    <div class="w-14 h-14 sm:w-24 sm:h-24 rounded-xl sm:rounded-2xl overflow-hidden flex-shrink-0 bg-gray-100 border border-gray-200/80 shadow-2xs sm:shadow-xs">
                                        <img src="{{ $itemImage }}" 
                                             alt="{{ $item['name'] }}" 
                                             class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900 text-xs sm:text-base font-poppins">
                                            {{ $item['name'] }}
                                        </h3>
                                        <p class="text-[10px] sm:text-xs text-resto-gold-800 font-semibold font-poppins mt-0.5">
                                            Rp {{ number_format($item['price'], 0, ',', '.') }} / porsi
                                        </p>
                                        @if(!empty($item['notes']))
                                            <p class="text-[9px] sm:text-xs text-resto-red-700 italic mt-0.5 sm:mt-1 bg-resto-red-50 px-1.5 py-0.5 rounded-md sm:rounded-lg inline-block">
                                                "{{ $item['notes'] }}"
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Quantity Stepper, Subtotal & Remove -->
                                <div class="flex items-center justify-between sm:justify-end space-x-3 sm:space-x-6 pt-2 sm:pt-0 border-t sm:border-t-0 border-gray-50">
                                    
                                    <!-- Stepper Form -->
                                    <div class="flex items-center border border-gray-200 rounded-lg sm:rounded-xl overflow-hidden shadow-2xs">
                                        <!-- Decrease -->
                                        <form action="{{ route('cart.update', $id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="action" value="decrease">
                                            <button type="submit" 
                                                    class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center text-gray-600 hover:bg-resto-red-50 hover:text-resto-red-800 transition-colors font-bold text-xs sm:text-sm">
                                                -
                                            </button>
                                        </form>

                                        <!-- Quantity Display -->
                                        <span class="w-7 sm:w-10 text-center font-bold text-xs sm:text-sm text-gray-800 font-poppins">
                                            {{ $item['quantity'] }}
                                        </span>

                                        <!-- Increase -->
                                        <form action="{{ route('cart.update', $id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="action" value="increase">
                                            <button type="submit" 
                                                    class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center text-gray-600 hover:bg-resto-gold-50 hover:text-resto-gold-800 transition-colors font-bold text-xs sm:text-sm">
                                                +
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Subtotal -->
                                    <div class="text-right min-w-[70px] sm:min-w-[90px]">
                                        <span class="text-[8px] sm:text-[10px] text-gray-400 uppercase tracking-wider block">Subtotal</span>
                                        <span class="font-bold text-resto-gold-800 font-poppins text-xs sm:text-base">
                                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <!-- Delete Item -->
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-1.5 sm:p-2 text-gray-400 hover:text-resto-red-700 hover:bg-resto-red-50 rounded-lg sm:rounded-xl transition-colors"
                                                title="Hapus dari Keranjang">
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>

                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Button Continue Shopping -->
                    <div class="pt-2">
                        <a href="{{ route('menu.index') }}" 
                           class="inline-flex items-center space-x-1.5 text-xs font-semibold text-resto-red-800 hover:text-resto-red-900 transition-colors">
                            <span>+ Pilih Hidangan Lainnya di Menu Resto Mayo</span>
                        </a>
                    </div>
                </div>

                <!-- Right Column: Order Summary Card (1 Col) -->
                <div class="space-y-4 sm:space-y-6">
                    <div class="bg-white rounded-2xl sm:rounded-3xl border border-gray-100 shadow-sm p-4 sm:p-8 space-y-4 sm:space-y-6 sticky top-20 sm:top-28">
                        <h2 class="text-base sm:text-lg font-bold text-gray-900 font-poppins pb-2 sm:pb-3 border-b border-gray-100">
                            Ringkasan Pesanan
                        </h2>

                        <!-- Breakdown -->
                        <div class="space-y-2 sm:space-y-3 text-xs sm:text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>Total Porsi</span>
                                <span class="font-semibold text-gray-800">{{ $totalQuantity }} porsi</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal Menu</span>
                                <span class="font-semibold text-gray-800">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Pajak Resto & Layanan</span>
                                <span class="font-semibold text-emerald-700">Termasuk</span>
                            </div>
                            <div class="pt-2 sm:pt-3 border-t border-gray-100 flex justify-between items-baseline">
                                <span class="text-sm sm:text-base font-bold text-gray-900 font-poppins">Total Pembayaran</span>
                                <span class="text-lg sm:text-xl font-extrabold text-resto-gold-800 font-poppins">
                                    Rp {{ number_format($totalAmount, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <!-- Checkout CTA -->
                        <div class="pt-1 sm:pt-2">
                            <a href="{{ route('checkout.index') }}" 
                               class="w-full py-3 sm:py-4 rounded-xl sm:rounded-2xl bg-resto-red-800 hover:bg-resto-red-900 text-white font-bold text-xs sm:text-sm tracking-wide shadow-md hover:shadow-lg transition-all duration-200 border border-resto-gold-700/50 flex items-center justify-center space-x-2">
                                <span>Lanjutkan Ke Kasir / Checkout</span>
                                <svg class="w-4 h-4 text-resto-gold-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                        </div>

                        <!-- Trust Badge -->
                        <div class="p-2.5 sm:p-3 rounded-xl sm:rounded-2xl bg-resto-gold-50/60 border border-resto-gold-200/70 text-[10px] sm:text-[11px] text-resto-gold-900 leading-relaxed flex items-center space-x-2">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-resto-gold-700 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Pesanan akan langsung diteruskan ke dapur Resto Mayo.</span>
                        </div>

                    </div>
                </div>

            </div>
        @else
            <!-- Empty Cart State -->
            <div class="py-20 px-6 text-center bg-white rounded-3xl border border-gray-100 shadow-sm max-w-2xl mx-auto">
                <div class="w-20 h-20 mx-auto rounded-full bg-resto-red-50 text-resto-red-800 flex items-center justify-center mb-4 border border-resto-red-100">
                    <svg class="w-10 h-10 text-resto-gold-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-resto-red-900 font-poppins">
                    Pesanan Masih Kosong
                </h2>
                <p class="text-sm text-gray-500 max-w-md mx-auto mt-2 leading-relaxed">
                    Anda belum memilih hidangan kuliner lezat kami. Lihat aneka makanan dan minuman sekarang!
                </p>
                <div class="mt-8">
                    <a href="{{ route('menu.index') }}" 
                       class="inline-flex items-center space-x-2 px-6 py-3.5 rounded-2xl bg-resto-red-800 hover:bg-resto-red-900 text-white font-semibold text-sm transition-all shadow-md hover:shadow-lg border border-resto-gold-700/50">
                        <svg class="w-4 h-4 text-resto-gold-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Lihat Menu </span>
                    </a>
                </div>
            </div>
        @endif

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs text-gray-400">
            &copy; {{ date('Y') }} Resto Mayo. Cita Rasa Meresap Sepanjang Masa.
        </div>
    </footer>
@endsection
