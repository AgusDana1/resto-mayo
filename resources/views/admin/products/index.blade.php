@extends('layouts.admin')

@section('title', 'Daftar Produk Menu - Resto Mayo')

@section('content')
<div class="space-y-8">

    <!-- Page Header & Action Bar -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-gray-100 pb-6">
        <div>
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-resto-gold-100 text-resto-gold-800 border border-resto-gold-200">
                    Sajian Kuliner
                </span>
                <span class="text-xs text-gray-400">•</span>
                <span class="text-xs text-gray-400 font-medium">Resto Mayo Menu Master</span>
            </div>
            <h1 class="text-3xl font-bold tracking-tight text-resto-red-900 mt-1 font-poppins">
                Manajemen Produk Menu
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Kelola daftar hidangan makanan, camilan khas risoles mayonise, nasi goreng, dan aneka minuman segar.
            </p>
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.products.create') }}" 
               class="inline-flex items-center space-x-2 px-5 py-3 rounded-xl bg-resto-red-800 hover:bg-resto-red-900 text-white font-medium text-sm shadow-md hover:shadow-lg transition-all duration-200 border border-resto-gold-700/50 group">
                <svg class="w-5 h-5 text-resto-gold-200 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Tambah Produk Baru</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Total Produk -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-resto-red-50 rounded-full group-hover:scale-125 transition-transform duration-300 -z-0"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Menu</p>
                    <h3 class="text-3xl font-bold text-resto-red-900 mt-1 font-poppins">{{ $products->total() }}</h3>
                    <p class="text-xs text-gray-400 mt-1">Makanan & Minuman</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-resto-red-100 text-resto-red-800 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 2: Menu Tersedia -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-emerald-50 rounded-full group-hover:scale-125 transition-transform duration-300 -z-0"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-emerald-700">Siap Disajikan</p>
                    <h3 class="text-3xl font-bold text-emerald-800 mt-1 font-poppins">
                        {{ $products->filter(fn($p) => $p->is_available ?? $p->is_active ?? true)->count() }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-1">Status aktif / ready</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 3: Menu Nonaktif / Habis -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-gray-50 rounded-full group-hover:scale-125 transition-transform duration-300 -z-0"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Nonaktif / Habis</p>
                    <h3 class="text-3xl font-bold text-gray-600 mt-1 font-poppins">
                        {{ $products->filter(fn($p) => !($p->is_available ?? $p->is_active ?? true))->count() }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-1">Stok kosong / rehat</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-gray-100 text-gray-500 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 4: Kategori Master -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-resto-gold-50 rounded-full group-hover:scale-125 transition-transform duration-300 -z-0"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-resto-gold-800">Total Kategori</p>
                    <h3 class="text-3xl font-bold text-resto-gold-700 mt-1 font-poppins">{{ $categories->count() }}</h3>
                    <p class="text-xs text-resto-gold-700 mt-1 font-medium">
                        <a href="{{ route('admin.categories.index') }}" class="hover:underline">Kelola Kategori &rarr;</a>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-resto-gold-100 text-resto-gold-800 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Multi-Filter Bar -->
    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
        <form method="GET" action="{{ route('admin.products.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-center">
            
            <!-- Pencarian Kata Kunci -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" 
                       name="search" 
                       value="{{ $search ?? '' }}" 
                       placeholder="Cari nasi goreng, risoles, dll..." 
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-resto-red-700 focus:border-transparent transition-all">
            </div>

            <!-- Filter Kategori -->
            <div>
                <select name="category_id" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-resto-red-700 focus:border-transparent transition-all text-gray-700 bg-white">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ (string)($categoryId ?? '') === (string)$category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Status Ketersediaan -->
            <div>
                <select name="status" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-resto-red-700 focus:border-transparent transition-all text-gray-700 bg-white">
                    <option value="">Semua Status</option>
                    <option value="1" {{ (string)($status ?? '') === '1' ? 'selected' : '' }}>Tersedia (Ready)</option>
                    <option value="0" {{ (string)($status ?? '') === '0' ? 'selected' : '' }}>Nonaktif / Habis</option>
                </select>
            </div>

            <!-- Tombol Filter & Reset -->
            <div class="flex items-center space-x-2 justify-end">
                <button type="submit" 
                        class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-resto-red-800 hover:bg-resto-red-900 text-white text-sm font-medium transition-colors shadow-sm">
                    Terapkan Filter
                </button>
                @if(!empty($search) || !empty($categoryId) || $status !== null && $status !== '')
                    <a href="{{ route('admin.products.index') }}" 
                       class="px-3.5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium transition-colors"
                       title="Reset Filter">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Products Data Table & Visual Showcase -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @if($products->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/80 border-b border-gray-100 text-xs uppercase font-semibold text-gray-500 tracking-wider">
                            <th class="py-4 px-6 w-16 text-center">No</th>
                            <th class="py-4 px-6">Foto & Sajian Menu</th>
                            <th class="py-4 px-6">Kategori</th>
                            <th class="py-4 px-6 text-right">Harga</th>
                            <th class="py-4 px-6 text-center">Status</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @foreach($products as $index => $product)
                            @php
                                $isAvailable = $product->is_available ?? $product->is_active ?? true;
                                $nameLower = strtolower($product->name);
                                
                                // Smart culinary fallback images for display if no uploaded image exists
                                $defaultImage = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=400&q=80'; // gourmet plate
                                if (str_contains($nameLower, 'nasi goreng')) {
                                    $defaultImage = 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=400&q=80'; // Nasi Goreng
                                } elseif (str_contains($nameLower, 'risol') || str_contains($nameLower, 'mayo') || str_contains($nameLower, 'gorengan')) {
                                    $defaultImage = 'https://images.unsplash.com/photo-1541529086526-db283c563270?w=400&q=80'; // Crispy snack / pastry
                                } elseif (str_contains($nameLower, 'dimsum') || str_contains($nameLower, 'siomay')) {
                                    $defaultImage = 'https://images.unsplash.com/photo-1496116218417-1a781b1c416c?w=400&q=80'; // Dimsum
                                } elseif (str_contains($nameLower, 'kopi') || str_contains($nameLower, 'coffee')) {
                                    $defaultImage = 'https://images.unsplash.com/photo-1517701550927-30cf4ba1dba5?w=400&q=80'; // Iced Coffee
                                } elseif (str_contains($nameLower, 'teh') || str_contains($nameLower, 'tea') || str_contains($nameLower, 'jus') || str_contains($nameLower, 'minum')) {
                                    $defaultImage = 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=400&q=80'; // Refreshing Drink
                                }

                                $imageUrl = $product->image 
                                    ? (str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image)) 
                                    : $defaultImage;
                            @endphp
                            <tr class="hover:bg-resto-red-50/25 transition-colors group">
                                <!-- Nomor -->
                                <td class="py-4 px-6 text-center font-medium text-gray-400">
                                    {{ $products->firstItem() + $index }}
                                </td>

                                <!-- Foto & Info Menu -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-4">
                                        <!-- Thumbnail Foto Makanan/Minuman -->
                                        <div class="relative w-16 h-16 rounded-xl overflow-hidden flex-shrink-0 bg-gray-100 border border-gray-200/80 shadow-xs group-hover:shadow-md transition-shadow">
                                            <img src="{{ $imageUrl }}" 
                                                 alt="{{ $product->name }}" 
                                                 loading="lazy"
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                            
                                            @if(!$isAvailable)
                                                <div class="absolute inset-0 bg-black/40 backdrop-blur-[1px] flex items-center justify-center">
                                                    <span class="text-[9px] font-bold text-white uppercase tracking-wider bg-resto-red-900/80 px-1 py-0.5 rounded">Habis</span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Judul & Deskripsi -->
                                        <div class="min-w-0">
                                            <a href="{{ route('admin.products.show', $product) }}" 
                                               class="font-bold text-gray-800 hover:text-resto-red-800 transition-colors font-poppins block truncate">
                                                {{ $product->name }}
                                            </a>
                                            <p class="text-xs text-gray-400 mt-0.5 line-clamp-1 max-w-md">
                                                {{ $product->description ?? 'Deskripsi hidangan belum ditambahkan.' }}
                                            </p>
                                            <span class="text-[10px] text-gray-400">ID: #PRD-{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Kategori -->
                                <td class="py-4 px-6">
                                    @if($product->category)
                                        <a href="{{ route('admin.categories.show', $product->category) }}" 
                                           class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-resto-gold-50 text-resto-gold-800 border border-resto-gold-300/80 hover:bg-resto-gold-100 transition-colors">
                                            <span class="w-1.5 h-1.5 rounded-full bg-resto-gold-600"></span>
                                            <span>{{ $product->category->name }}</span>
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Tanpa Kategori</span>
                                    @endif
                                </td>

                                <!-- Harga -->
                                <td class="py-4 px-6 text-right">
                                    <span class="font-bold text-resto-gold-800 font-poppins text-sm block">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                    <span class="text-[10px] text-gray-400">per porsi</span>
                                </td>

                                <!-- Status Ketersediaan -->
                                <td class="py-4 px-6 text-center">
                                    @if($isAvailable)
                                        <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            <span>Tersedia</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-500 border border-gray-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                            <span>Nonaktif</span>
                                        </span>
                                    @endif
                                </td>

                                <!-- Aksi -->
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <!-- Detail -->
                                        <a href="{{ route('admin.products.show', $product) }}" 
                                           class="p-2 rounded-lg text-gray-500 hover:text-resto-red-800 hover:bg-resto-red-50 border border-transparent hover:border-resto-red-200 transition-colors"
                                           title="Lihat Detail Produk">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>

                                        <!-- Edit -->
                                        <a href="{{ route('admin.products.edit', $product) }}" 
                                           class="p-2 rounded-lg text-gray-500 hover:text-resto-gold-800 hover:bg-resto-gold-50 border border-transparent hover:border-resto-gold-200 transition-colors"
                                           title="Ubah Produk">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </a>

                                        <!-- Nonaktifkan / Hapus Modal Trigger -->
                                        <button type="button" 
                                                onclick="openDeactivateModal('{{ $product->id }}', '{{ addslashes($product->name) }}', {{ $isAvailable ? 'true' : 'false' }})"
                                                class="p-2 rounded-lg text-gray-400 hover:text-resto-red-700 hover:bg-resto-red-50 border border-transparent hover:border-resto-red-200 transition-colors"
                                                title="Nonaktifkan Produk">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                {{ $products->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="py-16 px-6 text-center">
                <div class="w-20 h-20 mx-auto rounded-full bg-resto-red-50 text-resto-red-800 flex items-center justify-center mb-4 border border-resto-red-100">
                    <svg class="w-10 h-10 text-resto-gold-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-resto-red-900 font-poppins">Belum Ada Menu Ditemukan</h3>
                <p class="text-sm text-gray-500 max-w-md mx-auto mt-1">
                    @if(!empty($search) || !empty($categoryId) || $status !== null && $status !== '')
                        Tidak ada hidangan yang cocok dengan filter yang dipilih. Silakan coba atur ulang filter Anda.
                    @else
                        Mulai bangun katalog makanan dan minuman Resto Mayo seperti Nasi Goreng Spesial atau Risoles Mayonise favorit pelanggan.
                    @endif
                </p>
                <div class="mt-6 flex items-center justify-center space-x-3">
                    @if(!empty($search) || !empty($categoryId) || $status !== null && $status !== '')
                        <a href="{{ route('admin.products.index') }}" 
                           class="inline-flex items-center px-4 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium transition-colors">
                            Lihat Semua Menu
                        </a>
                    @else
                        <a href="{{ route('admin.products.create') }}" 
                           class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-resto-red-800 hover:bg-resto-red-900 text-white text-sm font-medium transition-colors shadow-sm">
                            <svg class="w-4 h-4 text-resto-gold-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>Tambah Produk Sekarang</span>
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>

</div>

<!-- Modal Konfirmasi Nonaktifkan Produk -->
<div id="deactivateModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-xs transition-opacity" onclick="closeDeactivateModal()"></div>

        <!-- Modal Card -->
        <div class="relative inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white rounded-2xl shadow-xl border border-gray-100">
            <div class="w-12 h-12 mx-auto rounded-full bg-resto-red-100 text-resto-red-800 flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-resto-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-center text-resto-red-900 font-poppins">Nonaktifkan Menu Kuliner</h3>
            <p class="mt-2 text-sm text-center text-gray-600">
                Apakah Anda ingin menonaktifkan status sajian untuk <span id="productNameDeactivate" class="font-bold text-resto-red-800"></span>?
            </p>
            <p class="mt-2 text-xs text-center text-gray-400">
                Menu yang dinonaktifkan tidak akan muncul pada pilihan pemesanan pelanggan, namun riwayat pesanan sebelumnya tetap aman.
            </p>

            <form id="deactivateForm" method="POST" action="" class="mt-6 flex items-center justify-end space-x-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeactivateModal()" 
                        class="px-4 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium transition-colors">
                    Batal
                </button>
                <button type="submit" 
                        class="px-5 py-2.5 rounded-xl bg-resto-red-800 hover:bg-resto-red-900 text-white text-sm font-medium transition-colors shadow-sm">
                    Ya, Nonaktifkan Menu
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openDeactivateModal(productId, productName, isAvailable) {
        const modal = document.getElementById('deactivateModal');
        const form = document.getElementById('deactivateForm');
        document.getElementById('productNameDeactivate').innerText = '"' + productName + '"';
        form.action = "{{ url('admin/products') }}/" + productId;
        modal.classList.remove('hidden');
    }

    function closeDeactivateModal() {
        document.getElementById('deactivateModal').classList.add('hidden');
    }
</script>
@endpush
@endsection

