@extends('layouts.app')

@section('title', 'Resto Mayo - Restoran Pilihan Bersama')

@section('content')

    <!-- Toast Notification Container (Fixed Top Right) -->
    <div id="toastContainer" class="fixed top-6 right-6 z-50 space-y-3 pointer-events-none max-w-sm w-full px-4 sm:px-0"></div>

    <!-- Top Accent Bar -->
    <div class="h-1.5 w-full bg-gradient-to-r from-resto-red-900 via-resto-red-700 to-resto-gold-700"></div>

    <!-- Navigation Header (Full Screen Width) -->
    <header class="bg-white/95 backdrop-blur-md border-b border-gray-100 sticky top-0 z-40 shadow-xs transition-all">
        <div class="w-full px-3 sm:px-6 lg:px-12">
            <div class="flex justify-between h-14 sm:h-20 items-center">
                
                <!-- Brand / Logo -->
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <a href="{{ route('menu.index') }}" class="flex items-center space-x-2 sm:space-x-3 group">
                        <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-resto-red-800 text-resto-gold-200 flex items-center justify-center shadow-md border border-resto-gold-700/40 group-hover:scale-105 transition-transform duration-200">
                            <svg class="w-4 h-4 sm:w-6 sm:h-6 fill-current" viewBox="0 0 24 24">
                                <path d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm5-3v8h2.5v8H21V2c-2.76 0-5 2.24-5 4z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-xl sm:text-3xl font-extrabold tracking-tight text-resto-red-900 font-poppins">Resto<span class="text-resto-gold-700">Mayo</span></span>
                            <p class="hidden sm:block text-[10px] uppercase tracking-widest text-resto-gold-800 font-bold">Cita Rasa Meresap Sepanjang Masa</p>
                        </div>
                    </a>
                </div>

                <!-- Right Side: Meja & Keranjang -->
                <div class="flex items-center space-x-2 sm:space-x-4">
                    @if(session('table_code'))
                        <div class="flex items-center space-x-1 sm:space-x-1.5 px-2 py-1 sm:px-3 sm:py-1.5 rounded-lg sm:rounded-xl bg-resto-gold-50 border border-resto-gold-200 text-[10px] sm:text-xs font-bold text-resto-gold-900">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-resto-gold-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            <span>Meja: {{ session('table_code') }}</span>
                        </div>
                    @endif

                    <!-- Keranjang Nav Button -->
                    @php
                        $cartSession = session('cart', []);
                        $cartTotalQty = is_array($cartSession) ? array_sum(array_column($cartSession, 'quantity')) : 0;
                    @endphp
                    <a href="{{ route('cart.index') }}" 
                       class="relative inline-flex items-center space-x-1.5 sm:space-x-2 px-3 py-1.5 sm:px-5 sm:py-3 rounded-xl sm:rounded-2xl bg-resto-red-800 hover:bg-resto-red-900 text-white text-xs sm:text-sm font-semibold shadow-xs sm:shadow-md hover:shadow-lg transition-all duration-200 border border-resto-gold-700/50 group">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-resto-gold-200 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span class="hidden xs:inline sm:inline">Pesanan</span>
                        <span id="navbarCartBadge" 
                              class="{{ $cartTotalQty > 0 ? 'inline-flex' : 'hidden' }} items-center justify-center min-w-[18px] sm:min-w-[20px] h-4 sm:h-5 px-1 sm:px-1.5 rounded-full bg-resto-gold-600 text-white text-[10px] sm:text-[11px] font-bold shadow-xs">
                            {{ $cartTotalQty }}
                        </span>
                    </a>
                </div>

            </div>
        </div>
    </header>

    <!-- Full-Width Hero Culinary Showcase Banner (Compact Responsive) -->
    <section class="relative bg-white border-b border-gray-100 overflow-hidden py-5 sm:py-16 lg:py-20">
        <div class="absolute -right-20 -top-20 w-48 h-48 sm:w-96 sm:h-96 bg-resto-red-50/60 rounded-full blur-3xl pointer-events-none -z-0"></div>
        <div class="absolute -left-20 -bottom-20 w-48 h-48 sm:w-96 sm:h-96 bg-resto-gold-50/60 rounded-full blur-3xl pointer-events-none -z-0"></div>

        <div class="w-full px-3 sm:px-6 lg:px-12 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                @php
                    $heroRisoles = null;
                    foreach ($categories as $cat) {
                        foreach ($cat->products as $prod) {
                            if (str_contains(strtolower($prod->name), 'risol')) {
                                $heroRisoles = $prod;
                                break 2;
                            }
                        }
                    }
                    $heroRisolesImg = 'https://images.unsplash.com/photo-1541529086526-db283c563270?w=600&q=80';
                    if ($heroRisoles && !empty($heroRisoles->image)) {
                        $heroRisolesImg = str_starts_with($heroRisoles->image, 'http')
                            ? $heroRisoles->image
                            : asset('storage/' . $heroRisoles->image);
                    }
                @endphp

                <!-- Hero Title & Circular Risoles Mayonise Keju Lumer Showcase -->
                <div class="flex items-center justify-center gap-3 sm:gap-8 lg:gap-10">
                    <div class="text-left">
                        <span class="inline-flex items-center px-2.5 py-0.5 sm:px-3.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-bold uppercase tracking-wider bg-resto-red-50 text-resto-red-800 border border-resto-red-200 mb-1 sm:mb-3 shadow-2xs">
                            ✦ Resto Mayo 
                        </span>
                        <h1 class="text-xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-resto-red-900 font-poppins leading-tight">
                            Sajian Lezat <span class="text-resto-gold-700 block sm:inline">Autentik & Meresap</span>
                        </h1>
                    </div>

                    <!-- Gambar Lingkaran Risoles Mayonise Keju Lumer (Proporsional di HP) -->
                    <div class="relative flex-shrink-0 group">
                        <!-- Glow Ambient Effect -->
                        <div class="absolute -inset-1 bg-gradient-to-tr from-resto-red-700 to-resto-gold-600 rounded-full blur-xs sm:blur-sm opacity-60 group-hover:opacity-90 transition duration-300"></div>
                        
                        <!-- Circular Frame with Golden-Red Accent -->
                        <div class="relative w-16 h-16 sm:w-32 sm:h-32 md:w-36 md:h-36 lg:w-40 lg:h-40 rounded-full p-0.5 sm:p-1.5 bg-gradient-to-tr from-resto-gold-600 via-resto-red-800 to-resto-gold-500 shadow-md sm:shadow-xl transition-transform duration-300 group-hover:scale-105">
                            <div class="w-full h-full rounded-full overflow-hidden border sm:border-4 border-white bg-white relative">
                                <img src="{{ $heroRisolesImg }}" 
                                     alt="Risoles Mayonise Keju Lumer" 
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search Input In Hero -->
                <div class="mt-4 sm:mt-8 max-w-xl mx-auto relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 sm:pl-4 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-resto-gold-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" 
                           id="clientSearchInput" 
                           placeholder="Cari risoles mayo, nasi goreng..." 
                           class="w-full pl-9 sm:pl-11 pr-3 sm:pr-4 py-2 sm:py-4 rounded-xl sm:rounded-2xl border border-gray-200 text-xs sm:text-base focus:outline-none focus:ring-2 focus:ring-resto-red-700 focus:border-transparent transition-all shadow-xs sm:shadow-sm placeholder-gray-400 bg-white">
                </div>
            </div>
        </div>
    </section>

    <!-- Sticky Category Filter Navigation (Full Width) -->
    @if($categories->count() > 0)
        <nav class="sticky top-14 sm:top-20 z-30 bg-white/95 backdrop-blur-md border-b border-gray-100 py-2 sm:py-3 shadow-2xs">
            <div class="w-full px-3 sm:px-6 lg:px-12 overflow-x-auto no-scrollbar">
                <div class="flex items-center space-x-1.5 sm:space-x-3 min-w-max">
                    <a href="#all" 
                       onclick="filterCategory('all', event)" 
                       class="cat-filter-btn px-3 py-1.5 sm:px-4 sm:py-2 rounded-lg sm:rounded-xl text-xs sm:text-sm font-semibold transition-all bg-resto-red-800 text-white shadow-xs" 
                       data-cat="all">
                        Semua Kategori ({{ $categories->sum(fn($c) => $c->products->count()) }})
                    </a>
                    @foreach($categories as $category)
                        <a href="#category-{{ $category->id }}" 
                           onclick="filterCategory('cat-{{ $category->id }}', event)" 
                           class="cat-filter-btn px-3 py-1.5 sm:px-4 sm:py-2 rounded-lg sm:rounded-xl text-xs sm:text-sm font-medium text-gray-600 hover:text-resto-red-800 hover:bg-resto-red-50 border border-gray-200 transition-all" 
                           data-cat="cat-{{ $category->id }}">
                            {{ $category->name }} ({{ $category->products->count() }})
                        </a>
                    @endforeach
                </div>
            </div>
        </nav>
    @endif

    <!-- Main Full-Width Menu Catalog Grid -->
    <main class="flex-1 w-full px-3 sm:px-6 lg:px-12 py-4 sm:py-12 bg-white">

        @if($categories->count() > 0)
            <div class="space-y-6 sm:space-y-14">
                @foreach($categories as $category)
                    <section id="category-{{ $category->id }}" class="category-block space-y-3 sm:space-y-6" data-cat-id="cat-{{ $category->id }}">
                        
                        <!-- Category Header Bar -->
                        <div class="flex items-center justify-between border-b border-gray-100 pb-2 sm:pb-3">
                            <div class="flex items-center space-x-2 sm:space-x-3">
                                <div class="w-7 h-7 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-resto-red-100 text-resto-red-800 flex items-center justify-center font-bold text-xs sm:text-base shadow-2xs font-poppins">
                                    {{ strtoupper(substr($category->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h2 class="text-base sm:text-2xl font-bold text-resto-red-900 font-poppins">
                                        {{ $category->name }}
                                    </h2>
                                    <p class="text-[10px] sm:text-xs text-gray-400 font-medium">{{ $category->products->count() }} hidangan siap saji</p>
                                </div>
                            </div>
                        </div>

                        <!-- Product Cards Grid: 2 Kolom di Layar HP (Perkecil 1/2), 3-5 Kolom di Layar Lebar -->
                        @if($category->products->count() > 0)
                            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 2xl:grid-cols-5 gap-2.5 sm:gap-6">
                                @foreach($category->products as $product)
                                    @php
                                        $nameLower = strtolower($product->name);
                                        
                                        // Smart curated culinary photography tailored to the dish
                                        $foodPhoto = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=600&q=80'; // gourmet plate
                                        if (str_contains($nameLower, 'nasi goreng')) {
                                            $foodPhoto = 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=600&q=80'; // Nasi Goreng
                                        } elseif (str_contains($nameLower, 'risol') || str_contains($nameLower, 'mayo') || str_contains($nameLower, 'gorengan')) {
                                            $foodPhoto = 'https://images.unsplash.com/photo-1541529086526-db283c563270?w=600&q=80'; // Risoles Mayonaise
                                        } elseif (str_contains($nameLower, 'dimsum') || str_contains($nameLower, 'siomay')) {
                                            $foodPhoto = 'https://images.unsplash.com/photo-1496116218417-1a781b1c416c?w=600&q=80'; // Dimsum
                                        } elseif (str_contains($nameLower, 'kopi') || str_contains($nameLower, 'coffee')) {
                                            $foodPhoto = 'https://images.unsplash.com/photo-1517701550927-30cf4ba1dba5?w=600&q=80'; // Iced Coffee
                                        } elseif (str_contains($nameLower, 'teh') || str_contains($nameLower, 'tea')) {
                                            $foodPhoto = 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=600&q=80'; // Iced Jasmine Tea
                                        } elseif (str_contains($nameLower, 'jus') || str_contains($nameLower, 'alpukat') || str_contains($nameLower, 'minum')) {
                                            $foodPhoto = 'https://images.unsplash.com/photo-1525385133512-2f3bdd039054?w=600&q=80'; // Avocado Drink
                                        }

                                        // If product has image, check if external URL or storage
                                        if (!empty($product->image)) {
                                            $foodPhoto = str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image);
                                        }
                                    @endphp

                                    <!-- Single Culinary Dish Card (Perkecil 1/2 ukuran untuk HP) -->
                                    <div class="product-card bg-white rounded-2xl sm:rounded-3xl border border-gray-100 shadow-xs sm:shadow-sm hover:shadow-xl hover:border-resto-gold-200 transition-all duration-300 flex flex-col justify-between overflow-hidden group"
                                         data-title="{{ strtolower($product->name) }}"
                                         data-desc="{{ strtolower($product->description ?? '') }}">
                                        
                                        <!-- Photo Container with Zoom Effect (112px di HP, 208px di Laptop) -->
                                        <div class="h-28 sm:h-52 w-full bg-gray-100 relative overflow-hidden">
                                            <img src="{{ $foodPhoto }}" 
                                                 alt="{{ $product->name }}" 
                                                 loading="lazy"
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-out">
                                            
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                                        </div>

                                        <!-- Dish Details (Padding ringkas di HP) -->
                                        <div class="p-2.5 sm:p-6 flex-1 flex flex-col justify-between space-y-2 sm:space-y-4">
                                            <div>
                                                <h3 class="font-bold text-gray-900 text-xs sm:text-lg group-hover:text-resto-red-800 transition-colors font-poppins line-clamp-1 sm:line-clamp-none leading-snug">
                                                    {{ $product->name }}
                                                </h3>
                                                <p class="text-[10px] sm:text-xs text-gray-500 mt-0.5 sm:mt-1.5 line-clamp-2 leading-tight sm:leading-relaxed">
                                                    {{ $product->description ?? 'Hidangan istimewa Resto Mayo disajikan segar dengan racikan bumbu pilihan.' }}
                                                </p>
                                            </div>

                                            <!-- Price & AJAX Order Action -->
                                            <div class="pt-2 sm:pt-3 border-t border-gray-50 flex items-center justify-between gap-1">
                                                <div>
                                                    <span class="text-[7px] sm:text-[10px] uppercase font-bold tracking-wider text-gray-400 block">Harga</span>
                                                    <span class="text-xs sm:text-lg font-extrabold text-resto-gold-800 font-poppins">
                                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                                    </span>
                                                </div>

                                                <!-- AJAX Order Button -->
                                                <button type="button" 
                                                        onclick="addToCartAjax('{{ $product->id }}', '{{ addslashes($product->name) }}', this)"
                                                        class="btn-order inline-flex items-center space-x-1 sm:space-x-1.5 px-2 py-1.5 sm:px-4 sm:py-2.5 rounded-lg sm:rounded-xl bg-resto-red-800 hover:bg-resto-red-900 text-white text-[10px] sm:text-xs font-bold shadow-xs sm:shadow-md hover:shadow-lg transition-all duration-200 border border-resto-gold-700/50 active:scale-95 flex-shrink-0">
                                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 text-resto-gold-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                                    </svg>
                                                    <span class="btn-text">Pesan</span>
                                                </button>
                                            </div>

                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-6 sm:p-8 rounded-2xl sm:rounded-3xl bg-white border border-gray-100 text-center text-xs text-gray-400">
                                Menu dalam kategori ini sedang disiapkan oleh dapur.
                            </div>
                        @endif

                    </section>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="py-16 sm:py-24 text-center bg-white rounded-2xl sm:rounded-3xl border border-gray-100 p-6 sm:p-8 max-w-xl mx-auto shadow-sm">
                <div class="w-14 h-14 sm:w-20 sm:h-20 mx-auto rounded-full bg-resto-red-50 text-resto-red-800 flex items-center justify-center mb-4 border border-resto-red-100">
                    <svg class="w-7 h-7 sm:w-10 sm:h-10 text-resto-gold-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <h3 class="text-base sm:text-xl font-bold text-resto-red-900 font-poppins">Belum Ada Menu Yang Tersedia</h3>
                <p class="text-xs text-gray-400 max-w-sm mx-auto mt-2">
                    Silakan hubungi staf atau pramusaji restoran kami untuk informasi hidangan hari ini.
                </p>
            </div>
        @endif

    </main>


    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-5 sm:py-8 mt-auto">
        <div class="w-full px-3 sm:px-6 lg:px-12 flex flex-col sm:flex-row items-center justify-between text-[10px] sm:text-xs text-gray-400 space-y-2 sm:space-y-0">
            <div class="flex items-center space-x-2">
                <span class="font-bold text-resto-red-900 font-poppins text-xs sm:text-sm">Resto Mayo</span>
                <span>•</span>
                <span>Cita Rasa Meresap Sepanjang Masa</span>
            </div>
            <div>
                <span>&copy; {{ date('Y') }} Resto Mayo. All rights reserved.</span>
            </div>
        </div>
    </footer>

    <!-- JavaScript: AJAX Add to Cart & Realtime Client Filter -->
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // AJAX Add To Cart (Tanpa Reload Halaman)
        async function addToCartAjax(productId, productName, buttonElement) {
            const btnText = buttonElement.querySelector('.btn-text');
            const originalText = btnText.innerText;

            // Loading UI
            buttonElement.disabled = true;
            btnText.innerText = 'Menyimpan...';

            try {
                const response = await fetch('/cart/add/' + productId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken,
                        'ngrok-skip-browser-warning': 'true'
                    },
                    body: JSON.stringify({
                        quantity: 1
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    // Update Badge in Navbar
                    const navBadge = document.getElementById('navbarCartBadge');
                    navBadge.innerText = data.totalQuantity;
                    navBadge.classList.remove('hidden');
                    navBadge.classList.add('inline-flex');


                    // Success Feedback on Button
                    buttonElement.classList.remove('bg-resto-red-800');
                    buttonElement.classList.add('bg-emerald-700');
                    btnText.innerText = '✓ Ditambahkan';

                    // Show Toast Notification
                    showToast(productName + ' berhasil ditambahkan ke keranjang!');

                    setTimeout(() => {
                        buttonElement.classList.remove('bg-emerald-700');
                        buttonElement.classList.add('bg-resto-red-800');
                        btnText.innerText = originalText;
                        buttonElement.disabled = false;
                    }, 1200);

                } else {
                    throw new Error(data.message || 'Gagal menambahkan produk');
                }
            } catch (error) {
                console.error('Add to cart error:', error);
                btnText.innerText = 'Gagal';
                showToast('Gagal menambahkan ke keranjang. Silakan coba lagi.', true);

                setTimeout(() => {
                    btnText.innerText = originalText;
                    buttonElement.disabled = false;
                }, 1500);
            }
        }

        // Toast Notification System
        function showToast(message, isError = false) {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = 'toast-animate pointer-events-auto bg-white border-l-4 ' + 
                              (isError ? 'border-red-600 text-red-900' : 'border-resto-gold-700 text-gray-800') + 
                              ' p-4 rounded-2xl shadow-xl border border-gray-100 flex items-center justify-between space-x-3';
            
            toast.innerHTML = `
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-full ${isError ? 'bg-red-100 text-red-700' : 'bg-resto-gold-100 text-resto-gold-800'} flex items-center justify-center flex-shrink-0 font-bold">
                        ${isError ? '!' : '✓'}
                    </div>
                    <div>
                        <p class="text-xs font-semibold ${isError ? 'text-red-800' : 'text-resto-gold-800'} uppercase tracking-wider">${isError ? 'Peringatan' : 'Berhasil'}</p>
                        <p class="text-xs font-medium text-gray-700">${message}</p>
                    </div>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-gray-400 hover:text-gray-600 p-1">&times;</button>
            `;

            container.appendChild(toast);

            setTimeout(() => {
                if (toast && toast.parentElement) {
                    toast.style.transition = 'all 0.4s ease';
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(-10px)';
                    setTimeout(() => toast.remove(), 400);
                }
            }, 3000);
        }

        // Live Realtime Client-Side Search
        const searchInput = document.getElementById('clientSearchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();
                const cards = document.querySelectorAll('.product-card');

                cards.forEach(card => {
                    const title = card.getAttribute('data-title') || '';
                    const desc = card.getAttribute('data-desc') || '';
                    if (title.includes(query) || desc.includes(query)) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }

        // Category Tab Filter
        function filterCategory(catId, event) {
            event.preventDefault();

            // Update active state tab buttons
            document.querySelectorAll('.cat-filter-btn').forEach(btn => {
                btn.classList.remove('bg-resto-red-800', 'text-white', 'shadow-xs');
                btn.classList.add('text-gray-600', 'border', 'border-gray-200');
            });
            event.currentTarget.classList.remove('text-gray-600', 'border', 'border-gray-200');
            event.currentTarget.classList.add('bg-resto-red-800', 'text-white', 'shadow-xs');

            const sections = document.querySelectorAll('.category-block');
            sections.forEach(sec => {
                if (catId === 'all' || sec.getAttribute('data-cat-id') === catId) {
                    sec.style.display = '';
                } else {
                    sec.style.display = 'none';
                }
            });

            if (catId !== 'all') {
                const target = document.querySelector(`[data-cat-id="${catId}"]`);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        }
    </script>
@endsection
