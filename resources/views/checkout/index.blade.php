@extends('layouts.app')

@section('title', 'Checkout Pesanan - Resto Mayo')

@section('content')

    <!-- Top Accent Bar -->
    <div class="h-1.5 w-full bg-gradient-to-r from-resto-red-900 via-resto-red-700 to-resto-gold-700"></div>

    <!-- Navigation Header -->
    <header class="bg-white border-b border-gray-100 sticky top-0 z-40 shadow-xs">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="flex justify-between h-14 sm:h-20 items-center">
                <a href="{{ route('cart.index') }}" 
                   class="inline-flex items-center space-x-1.5 px-2.5 py-1.5 sm:px-3 sm:py-2 rounded-lg sm:rounded-xl text-gray-600 hover:text-resto-red-800 hover:bg-resto-red-50 text-xs font-semibold transition-colors border border-gray-200">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Kembali ke Keranjang</span>
                </a>

                <div class="flex items-center space-x-2">
                    <span class="text-lg sm:text-xl font-bold tracking-tight text-resto-red-900 font-poppins">Resto<span class="text-resto-gold-700">Mayo</span></span>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="flex-1 w-full max-w-5xl mx-auto px-3 sm:px-6 lg:px-8 py-4 sm:py-12">

        <div class="text-center max-w-xl mx-auto mb-4 sm:mb-10">
            <span class="inline-flex items-center px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full text-[10px] sm:text-xs font-bold uppercase tracking-wider bg-resto-gold-100 text-resto-gold-800 border border-resto-gold-200 mb-1.5 sm:mb-2">
                Tahap Terakhir Pemesanan
            </span>
            <h1 class="text-xl sm:text-3xl font-extrabold text-resto-red-900 font-poppins">
                Konfirmasi & Pembayaran
            </h1>
            <p class="text-[11px] sm:text-sm text-gray-500 mt-0.5 sm:mt-1">
                Lengkapi nama pemesan dan nomor meja Anda agar dapur kami dapat segera memproses hidangan.
            </p>
        </div>

        @if($errors->any())
            <div class="mb-4 sm:mb-6 p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-resto-red-50 border border-resto-red-200 text-xs text-resto-red-900">
                <p class="font-bold mb-1">Periksa isian berikut:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-5 sm:gap-8">
            @csrf

            <!-- Form Data (2 Cols) -->
            <div class="lg:col-span-2 space-y-4 sm:space-y-6">
                
                <!-- Identitas Pemesan Card -->
                <div class="bg-white rounded-2xl sm:rounded-3xl border border-gray-100 shadow-sm p-4 sm:p-8 space-y-4 sm:space-y-5">
                    <h3 class="text-sm sm:text-base font-bold text-gray-900 font-poppins pb-2 sm:pb-3 border-b border-gray-100">
                        1. Informasi Meja & Pelanggan
                    </h3>

                    <!-- Nama Pemesan -->
                    <div>
                        <label for="customer_name" class="block text-[11px] sm:text-xs font-bold uppercase tracking-wider text-gray-600 mb-1 sm:mb-1.5 font-poppins">
                            Nama Lengkap Pemesan <span class="text-resto-red-800">*</span>
                        </label>
                        <input type="text" 
                               name="customer_name" 
                               id="customer_name" 
                               value="{{ old('customer_name', $customerName ?? '') }}" 
                               required 
                               placeholder="Contoh: Budi Santoso"
                               class="w-full px-3.5 py-2.5 sm:px-4 sm:py-3 rounded-xl sm:rounded-2xl border border-gray-200 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-resto-red-700 transition-all">
                    </div>

                    <!-- Nomor Meja -->
                    <div>
                        <label for="table_id" class="block text-[11px] sm:text-xs font-bold uppercase tracking-wider text-gray-600 mb-1 sm:mb-1.5 font-poppins">
                            Pilih Nomor Meja Anda <span class="text-resto-red-800">*</span>
                        </label>
                        <select name="table_id" 
                                id="table_id" 
                                required
                                class="w-full px-3.5 py-2.5 sm:px-4 sm:py-3 rounded-xl sm:rounded-2xl border border-gray-200 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-resto-red-700 transition-all bg-white text-gray-700">
                            <option value="">-- Pilih Meja Resto Mayo --</option>
                            @foreach($tables as $table)
                                @php
                                    $code = $table->table_code ?? ('M' . $table->table_number);
                                    $isSelected = old('table_id') == $table->id || (isset($tableCode) && $tableCode == $code);
                                @endphp
                                <option value="{{ $table->id }}" {{ $isSelected ? 'selected' : '' }}>
                                    Meja {{ $code }} (Meja #{{ $table->table_number }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Metode Pembayaran Card -->
                <div class="bg-white rounded-2xl sm:rounded-3xl border border-gray-100 shadow-sm p-4 sm:p-8 space-y-3 sm:space-y-5">
                    <h3 class="text-sm sm:text-base font-bold text-gray-900 font-poppins pb-2 sm:pb-3 border-b border-gray-100">
                        2. Pilih Metode Pembayaran
                    </h3>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 sm:gap-3">
                        <!-- QRIS -->
                        <label class="relative flex flex-col p-2.5 sm:p-4 border rounded-xl sm:rounded-2xl cursor-pointer hover:border-resto-gold-300 transition-all group">
                            <input type="radio" name="payment_method" value="qris" class="sr-only peer" checked>
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-xs sm:text-sm text-gray-800 peer-checked:text-resto-red-900">QRIS</span>
                                <span class="w-3.5 h-3.5 sm:w-4 sm:h-4 rounded-full border-2 border-gray-300 peer-checked:border-resto-red-800 peer-checked:bg-resto-red-800 flex items-center justify-center"></span>
                            </div>
                            <span class="text-[9px] sm:text-[10px] text-gray-400 mt-0.5 sm:mt-1">BCA, GoPay, OVO, dll</span>
                            <div class="absolute inset-0 rounded-xl sm:rounded-2xl border-2 border-transparent peer-checked:border-resto-red-800 pointer-events-none"></div>
                        </label>

                        <!-- GoPay -->
                        <label class="relative flex flex-col p-2.5 sm:p-4 border rounded-xl sm:rounded-2xl cursor-pointer hover:border-resto-gold-300 transition-all group">
                            <input type="radio" name="payment_method" value="gopay" class="sr-only peer">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-xs sm:text-sm text-gray-800 peer-checked:text-resto-red-900">GoPay</span>
                                <span class="w-3.5 h-3.5 sm:w-4 sm:h-4 rounded-full border-2 border-gray-300 peer-checked:border-resto-red-800 peer-checked:bg-resto-red-800 flex items-center justify-center"></span>
                            </div>
                            <span class="text-[9px] sm:text-[10px] text-gray-400 mt-0.5 sm:mt-1">Dompet Digital</span>
                            <div class="absolute inset-0 rounded-xl sm:rounded-2xl border-2 border-transparent peer-checked:border-resto-red-800 pointer-events-none"></div>
                        </label>

                        <!-- DANA -->
                        <label class="relative flex flex-col p-2.5 sm:p-4 border rounded-xl sm:rounded-2xl cursor-pointer hover:border-resto-gold-300 transition-all group">
                            <input type="radio" name="payment_method" value="dana" class="sr-only peer">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-xs sm:text-sm text-gray-800 peer-checked:text-resto-red-900">DANA</span>
                                <span class="w-3.5 h-3.5 sm:w-4 sm:h-4 rounded-full border-2 border-gray-300 peer-checked:border-resto-red-800 peer-checked:bg-resto-red-800 flex items-center justify-center"></span>
                            </div>
                            <span class="text-[9px] sm:text-[10px] text-gray-400 mt-0.5 sm:mt-1">Dompet Digital</span>
                            <div class="absolute inset-0 rounded-xl sm:rounded-2xl border-2 border-transparent peer-checked:border-resto-red-800 pointer-events-none"></div>
                        </label>

                        <!-- ShopeePay -->
                        <label class="relative flex flex-col p-2.5 sm:p-4 border rounded-xl sm:rounded-2xl cursor-pointer hover:border-resto-gold-300 transition-all group">
                            <input type="radio" name="payment_method" value="shopeepay" class="sr-only peer">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-xs sm:text-sm text-gray-800 peer-checked:text-resto-red-900">ShopeePay</span>
                                <span class="w-3.5 h-3.5 sm:w-4 sm:h-4 rounded-full border-2 border-gray-300 peer-checked:border-resto-red-800 peer-checked:bg-resto-red-800 flex items-center justify-center"></span>
                            </div>
                            <span class="text-[9px] sm:text-[10px] text-gray-400 mt-0.5 sm:mt-1">Dompet Digital</span>
                            <div class="absolute inset-0 rounded-xl sm:rounded-2xl border-2 border-transparent peer-checked:border-resto-red-800 pointer-events-none"></div>
                        </label>

                        <!-- Transfer Bank -->
                        <label class="relative flex flex-col p-2.5 sm:p-4 border rounded-xl sm:rounded-2xl cursor-pointer hover:border-resto-gold-300 transition-all group">
                            <input type="radio" name="payment_method" value="bank_transfer" class="sr-only peer">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-xs sm:text-sm text-gray-800 peer-checked:text-resto-red-900">Transfer BRI</span>
                                <span class="w-3.5 h-3.5 sm:w-4 sm:h-4 rounded-full border-2 border-gray-300 peer-checked:border-resto-red-800 peer-checked:bg-resto-red-800 flex items-center justify-center"></span>
                            </div>
                            <span class="text-[9px] sm:text-[10px] text-gray-400 mt-0.5 sm:mt-1">Bank BRI Direct</span>
                            <div class="absolute inset-0 rounded-xl sm:rounded-2xl border-2 border-transparent peer-checked:border-resto-red-800 pointer-events-none"></div>
                        </label>

                        <!-- OVO -->
                        <label class="relative flex flex-col p-2.5 sm:p-4 border rounded-xl sm:rounded-2xl cursor-pointer hover:border-resto-gold-300 transition-all group">
                            <input type="radio" name="payment_method" value="ovo" class="sr-only peer">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-xs sm:text-sm text-gray-800 peer-checked:text-resto-red-900">OVO</span>
                                <span class="w-3.5 h-3.5 sm:w-4 sm:h-4 rounded-full border-2 border-gray-300 peer-checked:border-resto-red-800 peer-checked:bg-resto-red-800 flex items-center justify-center"></span>
                            </div>
                            <span class="text-[9px] sm:text-[10px] text-gray-400 mt-0.5 sm:mt-1">Dompet Digital</span>
                            <div class="absolute inset-0 rounded-xl sm:rounded-2xl border-2 border-transparent peer-checked:border-resto-red-800 pointer-events-none"></div>
                        </label>
                    </div>

                </div>

            </div>

            <!-- Right Column: Summary Card (1 Col) -->
            <div class="space-y-4 sm:space-y-6">
                <div class="bg-white rounded-2xl sm:rounded-3xl border border-gray-100 shadow-sm p-4 sm:p-8 space-y-4 sm:space-y-6 sticky top-20 sm:top-28">
                    <h3 class="text-sm sm:text-base font-bold text-gray-900 font-poppins pb-2 sm:pb-3 border-b border-gray-100">
                        Ringkasan Belanja
                    </h3>

                    <!-- Items List -->
                    <div class="divide-y divide-gray-100 max-h-52 sm:max-h-60 overflow-y-auto space-y-2">
                        @foreach($cart as $item)
                            <div class="pt-2 first:pt-0 flex items-start justify-between text-xs">
                                <div>
                                    <span class="font-bold text-gray-800">{{ $item['quantity'] }}x</span>
                                    <span class="text-gray-700 ml-1">{{ $item['name'] }}</span>
                                </div>
                                <span class="font-bold text-resto-gold-800 font-poppins">
                                    Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Total -->
                    <div class="pt-2 sm:pt-3 border-t border-gray-100 flex justify-between items-baseline">
                        <span class="text-xs sm:text-sm font-bold text-gray-900">Total Tagihan</span>
                        <span class="text-lg sm:text-xl font-extrabold text-resto-gold-800 font-poppins">
                            Rp {{ number_format($totalAmount, 0, ',', '.') }}
                        </span>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full py-3 sm:py-4 rounded-xl sm:rounded-2xl bg-resto-red-800 hover:bg-resto-red-900 text-white font-bold text-xs sm:text-sm tracking-wide shadow-md hover:shadow-lg transition-all duration-200 border border-resto-gold-700/50 flex items-center justify-center space-x-2">
                        <span>Konfirmasi & Kirim Pesanan 🔥</span>
                    </button>

                    <p class="text-[10px] sm:text-[11px] text-gray-400 text-center leading-relaxed">
                        Dengan mengklik tombol di atas, pesanan Anda akan langsung dikirimkan ke stasiun dapur Resto Mayo.
                    </p>
                </div>
            </div>

        </form>

    </main>
@endsection
