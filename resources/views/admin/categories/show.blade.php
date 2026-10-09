@extends('layouts.admin')

@section('title', 'Detail Kategori: ' . $category->name . ' - Resto Mayo')

@section('content')
<div class="space-y-8">

    <!-- Breadcrumb & Back -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.categories.index') }}" 
           class="inline-flex items-center space-x-2 text-sm font-medium text-gray-500 hover:text-resto-red-800 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali ke Daftar Kategori</span>
        </a>

        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.categories.edit', $category) }}" 
               class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-xl bg-gray-100 hover:bg-resto-gold-50 text-gray-700 hover:text-resto-gold-800 border border-gray-200 hover:border-resto-gold-200 text-xs font-semibold transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                <span>Ubah Kategori</span>
            </a>
            
            <a href="{{ route('admin.products.create') }}" 
               class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-xl bg-resto-red-800 hover:bg-resto-red-900 text-white text-xs font-semibold transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5 text-resto-gold-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Tambah Produk ke Kategori</span>
            </a>
        </div>
    </div>

    <!-- Category Banner Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-48 h-full bg-gradient-to-l from-resto-red-50/50 to-transparent pointer-events-none"></div>

        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div class="flex items-center space-x-5">
                <div class="w-16 h-16 rounded-2xl bg-resto-red-800 text-resto-gold-200 flex items-center justify-center font-bold text-2xl shadow-md border border-resto-gold-600/30 font-poppins">
                    {{ strtoupper(substr($category->name, 0, 1)) }}
                </div>
                <div>
                    <div class="flex items-center space-x-2">
                        <span class="text-xs uppercase tracking-wider font-semibold text-resto-gold-800">
                            #CAT-{{ str_pad($category->id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                        <span class="text-gray-300">•</span>
                        <span class="text-xs text-gray-400">
                            Dibuat: {{ $category->created_at ? $category->created_at->format('d M Y') : '-' }}
                        </span>
                    </div>
                    <h1 class="text-3xl font-bold tracking-tight text-resto-red-900 mt-0.5 font-poppins">
                        {{ $category->name }}
                    </h1>
                    <p class="text-xs text-gray-500 mt-1">
                        Daftar menu kuliner dan minuman yang tergabung di bawah kategori ini.
                    </p>
                </div>
            </div>

            <!-- Badge Count -->
            <div class="flex items-center space-x-4 border-t sm:border-t-0 sm:border-l border-gray-100 pt-4 sm:pt-0 sm:pl-6">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Produk</span>
                    <div class="flex items-baseline space-x-1.5 mt-0.5">
                        <span class="text-3xl font-bold text-resto-gold-700 font-poppins">{{ $category->products_count }}</span>
                        <span class="text-xs text-gray-500 font-medium">Menu</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products in Category Section -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-800 font-poppins flex items-center space-x-2">
                <span>Daftar Menu Pada Kategori Ini</span>
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-resto-gold-100 text-resto-gold-800 border border-resto-gold-200">
                    {{ $category->products_count }} item
                </span>
            </h2>
        </div>

        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($products as $product)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden flex flex-col group">
                        
                        @php
                            $nameLower = strtolower($product->name);
                            $catFoodPhoto = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=400&q=80';
                            if (str_contains($nameLower, 'nasi goreng')) {
                                $catFoodPhoto = 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=400&q=80';
                            } elseif (str_contains($nameLower, 'risol') || str_contains($nameLower, 'mayo') || str_contains($nameLower, 'gorengan')) {
                                $catFoodPhoto = 'https://images.unsplash.com/photo-1541529086526-db283c563270?w=400&q=80';
                            } elseif (str_contains($nameLower, 'dimsum') || str_contains($nameLower, 'siomay')) {
                                $catFoodPhoto = 'https://images.unsplash.com/photo-1496116218417-1a781b1c416c?w=400&q=80';
                            } elseif (str_contains($nameLower, 'kopi') || str_contains($nameLower, 'coffee')) {
                                $catFoodPhoto = 'https://images.unsplash.com/photo-1517701550927-30cf4ba1dba5?w=400&q=80';
                            } elseif (str_contains($nameLower, 'teh') || str_contains($nameLower, 'tea')) {
                                $catFoodPhoto = 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=400&q=80';
                            } elseif (str_contains($nameLower, 'jus') || str_contains($nameLower, 'alpukat') || str_contains($nameLower, 'minum')) {
                                $catFoodPhoto = 'https://images.unsplash.com/photo-1525385133512-2f3bdd039054?w=400&q=80';
                            }

                            if (!empty($product->image)) {
                                $catFoodPhoto = str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image);
                            }
                        @endphp

                        <!-- Image Container / Food Photo -->
                        <div class="h-40 w-full bg-gray-100 relative overflow-hidden flex items-center justify-center border-b border-gray-100">
                            <img src="{{ $catFoodPhoto }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">

                            <!-- Status Badge -->
                            <div class="absolute top-3 right-3">
                                @if($product->is_available ?? $product->is_active ?? true)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-xs">
                                        Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-gray-100 text-gray-500 border border-gray-200">
                                        Habis
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Content Body -->
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-gray-800 text-sm group-hover:text-resto-red-800 transition-colors font-poppins">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-xs text-gray-400 mt-1 line-clamp-2">
                                    {{ $product->description ?? 'Deskripsi kuliner belum ditambahkan.' }}
                                </p>
                            </div>

                            <div class="mt-4 pt-3 border-t border-gray-50 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] uppercase tracking-wider text-gray-400 block">Harga</span>
                                    <span class="text-sm font-bold text-resto-gold-800 font-poppins">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>
                                <a href="{{ route('admin.products.edit', $product) }}" 
                                   class="p-1.5 rounded-lg text-gray-400 hover:text-resto-red-800 hover:bg-resto-red-50 transition-colors"
                                   title="Ubah Produk">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </a>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pt-4">
                {{ $products->links() }}
            </div>
        @else
            <!-- Empty State for Products inside Category -->
            <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center shadow-sm">
                <div class="w-16 h-16 mx-auto rounded-full bg-resto-gold-50 text-resto-gold-700 flex items-center justify-center mb-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-resto-red-900 font-poppins">Belum Ada Menu Pada Kategori Ini</h3>
                <p class="text-xs text-gray-500 max-w-sm mx-auto mt-1">
                    Kategori ini masih kosong. Anda dapat menambahkan produk kuliner baru atau memindahkan produk ke kategori ini.
                </p>
                <div class="mt-5">
                    <a href="{{ route('admin.products.create') }}" 
                       class="inline-flex items-center space-x-2 px-4 py-2 rounded-xl bg-resto-red-800 hover:bg-resto-red-900 text-white text-xs font-semibold transition-colors shadow-sm">
                        <svg class="w-3.5 h-3.5 text-resto-gold-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Tambah Produk Menu Sekarang</span>
                    </a>
                </div>
            </div>
        @endif
    </div>

</div>
@endsection

