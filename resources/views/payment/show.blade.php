@extends('layouts.app')

@section('title', 'Instruksi Pembayaran - #' . $order->order_number . ' - Resto Mayo')

@section('content')

    <!-- Top Accent Bar -->
    <div class="h-1.5 w-full bg-gradient-to-r from-resto-red-900 via-resto-red-700 to-resto-gold-700"></div>

    <!-- Navigation Header -->
    <header class="bg-white border-b border-gray-100 sticky top-0 z-40 shadow-xs">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="flex justify-between h-14 sm:h-20 items-center">
                <a href="{{ route('menu.index') }}" 
                   class="inline-flex items-center space-x-1.5 px-2.5 py-1.5 sm:px-3 sm:py-2 rounded-lg sm:rounded-xl text-gray-600 hover:text-resto-red-800 hover:bg-resto-red-50 text-xs font-semibold transition-colors border border-gray-200">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Kembali ke Menu</span>
                </a>

                <div class="flex items-center space-x-2">
                    <span class="text-lg sm:text-xl font-bold tracking-tight text-resto-red-900 font-poppins">Resto<span class="text-resto-gold-700">Mayo</span></span>
                </div>
            </div>
        </div>
    </header>

    @php
        $payment = $order->payment;
        $method = $payment ? $payment->method : 'qris';
        $isPaid = $payment && $payment->status === 'paid';
    @endphp

    <main class="flex-1 max-w-2xl w-full mx-auto px-3 py-4 sm:py-12 flex flex-col justify-center">

        <!-- Flash Alert Notification -->
        @if(session('success'))
            <div class="mb-4 sm:mb-6 bg-white border-l-4 border-emerald-600 p-3 sm:p-4 rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs sm:text-base">
                        ✓
                    </div>
                    <div>
                        <p class="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-emerald-800">Status Pembayaran</p>
                        <p class="text-xs sm:text-sm font-medium text-gray-700">{{ session('success') }}</p>
                    </div>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
        @endif

        <!-- Main Payment Card (Pure White with Subtle Border) -->
        <div class="w-full bg-white rounded-2xl sm:rounded-3xl border border-gray-100 shadow-xl p-4 sm:p-10 relative overflow-hidden space-y-4 sm:space-y-8">
            <div class="absolute -right-12 -top-12 w-36 h-36 bg-resto-red-50/50 rounded-full -z-0 pointer-events-none"></div>

            <!-- Header Info -->
            <div class="text-center space-y-1.5 sm:space-y-2 relative z-10">
                <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto rounded-xl sm:rounded-2xl {{ $isPaid ? 'bg-emerald-100 text-emerald-800' : 'bg-resto-gold-100 text-resto-gold-800' }} flex items-center justify-center shadow-xs">
                    @if($isPaid)
                        <svg class="w-8 h-8 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    @else
                        <svg class="w-8 h-8 text-resto-gold-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    @endif
                </div>

                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $isPaid ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-resto-gold-100 text-resto-gold-900 border border-resto-gold-200' }}">
                    {{ $isPaid ? 'Pembayaran Berhasil / Lunas' : 'Menunggu Penyelesaian Pembayaran' }}
                </span>

                <h1 class="text-2xl sm:text-3xl font-extrabold text-resto-red-900 font-poppins">
                    Pesanan #{{ $order->order_number }}
                </h1>
                <p class="text-xs sm:text-sm text-gray-500">
                    Pelanggan: <strong class="text-gray-800">{{ $order->customer_name }}</strong> • 
                    Meja: <strong class="text-resto-red-800">{{ $order->table ? ($order->table->table_code ?? 'M' . $order->table->table_number) : '-' }}</strong>
                </p>
            </div>

            <!-- Order Amount Summary Box -->
            <div class="p-5 rounded-2xl bg-gray-50/80 border border-gray-100 flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-400 block">Total Tagihan Pesanan</span>
                    <span class="text-2xl font-extrabold text-resto-gold-800 font-poppins">
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </span>
                </div>
                <div class="text-right">
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-400 block">Metode Pembayaran</span>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold uppercase bg-white border border-gray-200 text-gray-800">
                        {{ str_replace('_', ' ', $method) }}
                    </span>
                </div>
            </div>

            <!-- CONDITIONAL PAYMENT UI PER METHOD -->

            <!-- 1. BANK TRANSFER (BRI KE REKENING CEO / OWNER) -->
            @if($method === 'bank_transfer')
                <div class="p-6 rounded-3xl bg-white border-2 border-blue-100 shadow-sm space-y-6">
                    <div class="flex items-center space-x-3 pb-4 border-b border-gray-100">
                        <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-extrabold text-sm shadow-xs">
                            BRI
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-base font-poppins">
                                Transfer Bank BRI
                            </h3>
                            <p class="text-xs text-gray-500">
                                Rekening Resmi CEO & Pemilik Resto Mayo
                            </p>
                        </div>
                    </div>

                    <!-- Rekening Detail Box -->
                    <div class="space-y-4">
                        <div class="p-4 rounded-2xl bg-blue-50/50 border border-blue-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div>
                                <span class="text-[11px] uppercase font-bold tracking-wider text-blue-900 block">Nomor Rekening BRI:</span>
                                <span id="briAccountNum" class="text-xl sm:text-2xl font-extrabold text-blue-950 font-poppins tracking-wider select-all">
                                    0123-01-089765-50-8
                                </span>
                            </div>
                            <button type="button" 
                                    onclick="copyText('012301089765508', this)" 
                                    class="inline-flex items-center justify-center space-x-1.5 px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                <span>Salin No. Rekening</span>
                            </button>
                        </div>

                        <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-[11px] uppercase font-semibold text-gray-400 block">Atas Nama Pemilik (CEO):</span>
                                <span class="text-base font-bold text-gray-900 font-poppins">Agus Dana (CEO Resto Mayo)</span>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-blue-100 text-blue-800">Verified Owner</span>
                        </div>

                        <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-[11px] uppercase font-semibold text-gray-400 block">Jumlah Yang Harus Ditransfer:</span>
                                <span class="text-lg font-extrabold text-resto-gold-800 font-poppins">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </span>
                            </div>
                            <button type="button" 
                                    onclick="copyText('{{ (int)$order->total_amount }}', this)" 
                                    class="text-xs font-semibold text-resto-gold-800 hover:underline">
                                Salin Nominal
                            </button>
                        </div>
                    </div>

                    <!-- Petunjuk Transfer -->
                    <div class="text-xs text-gray-500 space-y-1.5 leading-relaxed bg-gray-50/50 p-4 rounded-2xl">
                        <p class="font-bold text-gray-700">Petunjuk Transfer BRI:</p>
                        <p>1. Buka aplikasi <strong>BRImo</strong> atau ATM Bank BRI terdekat.</p>
                        <p>2. Pilih menu <strong>Transfer &gt; Sesama BRI</strong>.</p>
                        <p>3. Masukkan nomor rekening di atas atas nama <strong>Agus Dana</strong>.</p>
                        <p>4. Masukkan nominal tepat sebesar <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong> lalu konfirmasi transfer.</p>
                    </div>

                    @if(!$isPaid)
                        <!-- Tombol Konfirmasi Transfer Mandiri -->
                        <form action="{{ route('payment.confirm', $order) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="w-full py-4 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm tracking-wide shadow-md hover:shadow-lg transition-all flex items-center justify-center space-x-2">
                                <span>Saya Sudah Melakukan Transfer ke Bank BRI</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                        </form>
                    @endif
                </div>

            <!-- 2. DANA -->
            @elseif($method === 'dana')
                <div class="p-6 rounded-3xl bg-white border-2 border-sky-200 shadow-sm space-y-6">
                    <div class="flex items-center space-x-3 pb-4 border-b border-gray-100">
                        <div class="w-12 h-12 rounded-2xl bg-[#118EEA] text-white flex items-center justify-center font-extrabold text-base shadow-xs">
                            DANA
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-base font-poppins">
                                Pembayaran Via DANA
                            </h3>
                            <p class="text-xs text-gray-500">
                                Dompet Digital Resmi Resto Mayo
                            </p>
                        </div>
                    </div>

                    <!-- Info Akun DANA -->
                    <div class="p-4 rounded-2xl bg-sky-50/60 border border-sky-100 flex items-center justify-between">
                        <div>
                            <span class="text-[11px] uppercase font-bold text-sky-900 block">Nomor Akun DANA Resto Mayo:</span>
                            <span class="text-xl font-extrabold text-sky-950 font-poppins select-all">0812-3456-7890</span>
                            <span class="text-xs text-gray-500 block">a.n. Agus Dana / Resto Mayo</span>
                        </div>
                        <button type="button" 
                                onclick="copyText('081234567890', this)" 
                                class="px-3 py-1.5 rounded-xl bg-[#118EEA] hover:bg-sky-600 text-white text-xs font-semibold shadow-xs transition-colors">
                            Salin Nomor
                        </button>
                    </div>

                    <div class="text-xs text-gray-500 leading-relaxed bg-gray-50 p-4 rounded-2xl">
                        Silakan hubungkan atau buka aplikasi <strong>DANA</strong> di smartphone Anda untuk menyelesaikan transaksi sebesar <strong class="text-sky-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>.
                    </div>

                    <!-- Buka Aplikasi DANA Action -->
                    <div class="space-y-3">
                        <a href="https://link.dana.id" target="_blank" 
                           class="w-full py-4 rounded-2xl bg-[#118EEA] hover:bg-sky-600 text-white font-bold text-sm tracking-wide shadow-md transition-all flex items-center justify-center space-x-2">
                            <span>Hubungkan &amp; Buka Aplikasi DANA</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>

                        @if(!$isPaid)
                            <form action="{{ route('payment.confirm', $order) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs transition-colors">
                                    Saya Sudah Bayar di Aplikasi DANA
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

            <!-- 3. GOPAY -->
            @elseif($method === 'gopay')
                <div class="p-6 rounded-3xl bg-white border-2 border-cyan-200 shadow-sm space-y-6">
                    <div class="flex items-center space-x-3 pb-4 border-b border-gray-100">
                        <div class="w-12 h-12 rounded-2xl bg-[#00AED6] text-white flex items-center justify-center font-extrabold text-sm shadow-xs">
                            GOPAY
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-base font-poppins">
                                Pembayaran Via GoPay
                            </h3>
                            <p class="text-xs text-gray-500">
                                Ekosistem Gojek / GoPay Indonesia
                            </p>
                        </div>
                    </div>

                    <!-- Info Akun GoPay -->
                    <div class="p-4 rounded-2xl bg-cyan-50/60 border border-cyan-100 flex items-center justify-between">
                        <div>
                            <span class="text-[11px] uppercase font-bold text-cyan-900 block">Nomor GoPay Resto Mayo:</span>
                            <span class="text-xl font-extrabold text-cyan-950 font-poppins select-all">0877-5500-0371</span>
                            <span class="text-xs text-gray-500 block">a.n. Agus Dana / Resto Mayo</span>
                        </div>
                        <button type="button" 
                                onclick="copyText('081234567890', this)" 
                                class="px-3 py-1.5 rounded-xl bg-[#00AED6] hover:bg-cyan-600 text-white text-xs font-semibold shadow-xs transition-colors">
                            Salin Nomor
                        </button>
                    </div>

                    <div class="text-xs text-gray-500 leading-relaxed bg-gray-50 p-4 rounded-2xl">
                        Silakan hubungkan atau buka aplikasi <strong>Gojek / GoPay</strong> di smartphone Anda untuk membayar pesanan sebesar <strong class="text-cyan-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>.
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <a href="https://gopay.co.id" target="_blank" 
                           class="w-full py-4 rounded-2xl bg-[#00AED6] hover:bg-cyan-600 text-white font-bold text-sm tracking-wide shadow-md transition-all flex items-center justify-center space-x-2">
                            <span>Hubungkan &amp; Buka Aplikasi GoPay</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>

                        @if(!$isPaid)
                            <form action="{{ route('payment.confirm', $order) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs transition-colors">
                                    Saya Sudah Bayar di Aplikasi GoPay
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

            <!-- 4. SHOPEEPAY -->
            @elseif($method === 'shopeepay')
                <div class="p-6 rounded-3xl bg-white border-2 border-orange-200 shadow-sm space-y-6">
                    <div class="flex items-center space-x-3 pb-4 border-b border-gray-100">
                        <div class="w-12 h-12 rounded-2xl bg-[#EE4D2D] text-white flex items-center justify-center font-extrabold text-xs shadow-xs">
                            SHOPEE
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-base font-poppins">
                                Pembayaran Via ShopeePay
                            </h3>
                            <p class="text-xs text-gray-500">
                                ShopeePay Dompet Digital
                            </p>
                        </div>
                    </div>

                    <!-- Info Akun ShopeePay -->
                    <div class="p-4 rounded-2xl bg-orange-50/60 border border-orange-100 flex items-center justify-between">
                        <div>
                            <span class="text-[11px] uppercase font-bold text-orange-900 block">Nomor ShopeePay Resto Mayo:</span>
                            <span class="text-xl font-extrabold text-orange-950 font-poppins select-all">0877-5500-0371</span>
                            <span class="text-xs text-gray-500 block">a.n. Agus Dana / Resto Mayo</span>
                        </div>
                        <button type="button" 
                                onclick="copyText('081234567890', this)" 
                                class="px-3 py-1.5 rounded-xl bg-[#EE4D2D] hover:bg-orange-600 text-white text-xs font-semibold shadow-xs transition-colors">
                            Salin Nomor
                        </button>
                    </div>

                    <div class="text-xs text-gray-500 leading-relaxed bg-gray-50 p-4 rounded-2xl">
                        Buka aplikasi <strong>Shopee</strong> dan selesaikan transaksi dengan transfer ShopeePay sebesar <strong class="text-orange-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>.
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <a href="https://shopee.co.id" target="_blank" 
                           class="w-full py-4 rounded-2xl bg-[#EE4D2D] hover:bg-orange-600 text-white font-bold text-sm tracking-wide shadow-md transition-all flex items-center justify-center space-x-2">
                            <span>Hubungkan &amp; Buka Aplikasi ShopeePay</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>

                        @if(!$isPaid)
                            <form action="{{ route('payment.confirm', $order) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs transition-colors">
                                    Saya Sudah Bayar di Aplikasi ShopeePay
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

            <!-- 5. OVO -->
            @elseif($method === 'ovo')
                <div class="p-6 rounded-3xl bg-white border-2 border-purple-200 shadow-sm space-y-6">
                    <div class="flex items-center space-x-3 pb-4 border-b border-gray-100">
                        <div class="w-12 h-12 rounded-2xl bg-[#4C3494] text-white flex items-center justify-center font-extrabold text-sm shadow-xs">
                            OVO
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-base font-poppins">
                                Pembayaran Via OVO
                            </h3>
                            <p class="text-xs text-gray-500">
                                OVO Dompet Digital Indonesia
                            </p>
                        </div>
                    </div>

                    <!-- Info Akun OVO -->
                    <div class="p-4 rounded-2xl bg-purple-50/60 border border-purple-100 flex items-center justify-between">
                        <div>
                            <span class="text-[11px] uppercase font-bold text-purple-900 block">Nomor OVO Resto Mayo:</span>
                            <span class="text-xl font-extrabold text-purple-950 font-poppins select-all">0877-5500-0371</span>
                            <span class="text-xs text-gray-500 block">a.n. Agus Dana / Resto Mayo</span>
                        </div>
                        <button type="button" 
                                onclick="copyText('081234567890', this)" 
                                class="px-3 py-1.5 rounded-xl bg-[#4C3494] hover:bg-purple-800 text-white text-xs font-semibold shadow-xs transition-colors">
                            Salin Nomor
                        </button>
                    </div>

                    <div class="text-xs text-gray-500 leading-relaxed bg-gray-50 p-4 rounded-2xl">
                        Buka aplikasi <strong>OVO</strong> Anda di smartphone dan setujui pembayaran sebesar <strong class="text-purple-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>.
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <a href="https://www.ovo.id" target="_blank" 
                           class="w-full py-4 rounded-2xl bg-[#4C3494] hover:bg-purple-800 text-white font-bold text-sm tracking-wide shadow-md transition-all flex items-center justify-center space-x-2">
                            <span>Hubungkan &amp; Buka Aplikasi OVO</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>

                        @if(!$isPaid)
                            <form action="{{ route('payment.confirm', $order) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs transition-colors">
                                    Saya Sudah Bayar di Aplikasi OVO
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

            <!-- 6. QRIS (HANYA DITAMPILKAN JIKA MEMILIH QRIS) -->
            @elseif($method === 'qris')
                <div class="p-6 rounded-3xl bg-white border border-gray-200 shadow-sm space-y-6 text-center">
                    <div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-resto-gold-100 text-resto-gold-900 border border-resto-gold-200">
                            QRIS Standar Nasional
                        </span>
                        <h3 class="font-bold text-resto-red-900 text-lg font-poppins mt-2">
                            Pindai QR Code di Bawah Ini
                        </h3>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Dapat dipindai dari BCA, Mandiri, BRI, BNI, GoPay, OVO, ShopeePay, DANA, dll.
                        </p>
                    </div>

                    <!-- Barcode Box -->
                    <div class="p-4 rounded-2xl bg-gray-50 border border-dashed border-gray-200 inline-block mx-auto shadow-2xs">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=RESTOMAYO-{{ $order->order_number }}" 
                             alt="QRIS Resto Mayo" 
                             class="w-44 h-44 mx-auto rounded-xl border border-gray-200 p-1.5 bg-white">
                        <span class="text-[11px] font-bold text-gray-700 mt-2 block tracking-wider font-poppins">NMID: ID102030405060</span>
                        <span class="text-[10px] text-gray-400 block">Resto Mayo Official Merchant</span>
                    </div>

                    @if(!$isPaid)
                        <form action="{{ route('payment.confirm', $order) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="w-full py-4 rounded-2xl bg-resto-red-800 hover:bg-resto-red-900 text-white font-bold text-sm tracking-wide shadow-md hover:shadow-lg transition-all flex items-center justify-center space-x-2 border border-resto-gold-700/50">
                                <span>Saya Sudah Pindai &amp; Selesaikan Pembayaran</span>
                                <svg class="w-4 h-4 text-resto-gold-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                        </form>
                    @endif
                </div>
            @endif

            <!-- Rincian Menu Pesanan -->
            <div class="pt-6 border-t border-gray-100">
                <span class="text-xs font-bold uppercase tracking-wider text-gray-400 block mb-3">
                    Hidangan Yang Dipesan ({{ $order->items->sum('quantity') }} porsi):
                </span>
                <div class="divide-y divide-gray-100 space-y-2">
                    @foreach($order->items as $item)
                        <div class="pt-2 first:pt-0 flex items-center justify-between text-xs">
                            <div class="flex items-center space-x-2">
                                <span class="w-5 h-5 rounded-md bg-resto-gold-100 text-resto-gold-900 font-bold text-[10px] flex items-center justify-center">
                                    {{ $item->quantity }}x
                                </span>
                                <span class="font-medium text-gray-800">{{ $item->product ? $item->product->name : 'Menu Resto' }}</span>
                                @if($item->notes)
                                    <span class="text-[10px] text-resto-red-700 italic">({{ $item->notes }})</span>
                                @endif
                            </div>
                            <span class="font-semibold text-gray-700">
                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Footer Return Link -->
            <div class="pt-4 text-center">
                <a href="{{ route('menu.index') }}" 
                   class="inline-flex items-center space-x-2 text-xs font-semibold text-resto-red-800 hover:text-resto-red-900 transition-colors">
                    <span>← Kembali Ke Halaman Menu Utama</span>
                </a>
            </div>

        </div>

    </main>

    <!-- Copy to Clipboard Toast & Script -->
    <script>
        function copyText(text, btnElement) {
            navigator.clipboard.writeText(text).then(() => {
                const originalText = btnElement.innerText;
                btnElement.innerText = '✓ Berhasil Disalin!';
                btnElement.classList.add('bg-emerald-600', 'text-white');
                setTimeout(() => {
                    btnElement.innerText = originalText;
                    btnElement.classList.remove('bg-emerald-600', 'text-white');
                }, 1500);
            }).catch(err => {
                alert('Gagal menyalin teks: ' + text);
            });
        }
    </script>
@endsection
