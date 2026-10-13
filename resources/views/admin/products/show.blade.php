@extends('layouts.admin')

@section('title', 'Detail Produk: ' . $product->name . ' - Resto Mayo')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">

    <!-- Breadcrumb & Back -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.products.index') }}" 
           class="inline-flex items-center space-x-2 text-sm font-medium text-gray-500 hover:text-resto-red-800 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali ke Manajemen Produk</span>
        </a>

        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.products.edit', $product) }}" 
               class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-xl bg-resto-red-800 hover:bg-resto-red-900 text-white text-xs font-semibold transition-colors shadow-sm border border-resto-gold-700/50">
                <svg class="w-3.5 h-3.5 text-resto-gold-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                <span>Ubah Produk</span>
            </a>
        </div>
    </div>

    @php
        $isAvailable = $product->is_available ?? true;
        $imageUrl = $product->image 
            ? (str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image)) 
            : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=600&q=80';
    @endphp

    <!-- Product Detail Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-3">
            
            <!-- Left: Product Image -->
            <div class="relative h-64 md:h-full bg-gray-100 border-b md:border-b-0 md:border-r border-gray-100 overflow-hidden group">
                <img src="{{ $imageUrl }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                
                @if(!$isAvailable)
                    <div class="absolute inset-0 bg-black/50 backdrop-blur-[2px] flex items-center justify-center">
                        <span class="px-3 py-1 bg-resto-red-900 text-white font-bold text-xs rounded-full uppercase tracking-wider">
                            Nonaktif / Stok Habis
                        </span>
                    </div>
                @endif

                <div class="absolute top-4 left-4">
                    @if($isAvailable)
                        <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-500 text-white shadow-md">
                            <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                            <span>Tersedia</span>
                        </span>
                    @else
                        <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full text-xs font-bold bg-gray-700 text-white shadow-md">
                            <span>Habis</span>
                        </span>
                    @endif
                </div>
            </div>

            <!-- Right: Product Information (2 Cols) -->
            <div class="md:col-span-2 p-6 sm:p-8 flex flex-col justify-between space-y-6">
                <div>
                    <!-- Meta Tag -->
                    <div class="flex items-center space-x-2">
                        @if($product->category)
                            <a href="{{ route('admin.categories.show', $product->category) }}" 
                               class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-resto-gold-50 text-resto-gold-800 border border-resto-gold-200 hover:bg-resto-gold-100 transition-colors">
                                <span>{{ $product->category->name }}</span>
                            </a>
                        @endif
                        <span class="text-xs text-gray-400">•</span>
                        <span class="text-xs font-mono text-gray-400">ID: #PRD-{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-2xl sm:text-3xl font-bold text-resto-red-900 mt-2 font-poppins">
                        {{ $product->name }}
                    </h1>

                    <!-- Price -->
                    <div class="mt-4 flex items-baseline space-x-2">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Harga Satuan:</span>
                        <span class="text-2xl sm:text-3xl font-extrabold text-resto-gold-800 font-poppins">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </div>

                    <!-- Description -->
                    <div class="mt-5 pt-5 border-t border-gray-100">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 font-poppins">
                            Deskripsi Sajian
                        </h3>
                        <p class="text-sm text-gray-700 mt-2 leading-relaxed">
                            {{ $product->description ?? 'Deskripsi hidangan ini belum ditambahkan oleh pengelola restoran.' }}
                        </p>
                    </div>
                </div>

                <!-- Footer Metadata & Info -->
                <div class="pt-6 border-t border-gray-100 flex flex-wrap items-center justify-between gap-4 text-xs text-gray-400">
                    <div>
                        <span>Ditambahkan pada: {{ $product->created_at ? $product->created_at->format('d M Y, H:i') : '-' }}</span>
                    </div>
                    <div>
                        <span>Terakhir diperbarui: {{ $product->updated_at ? $product->updated_at->format('d M Y, H:i') : '-' }}</span>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>
@endsection

