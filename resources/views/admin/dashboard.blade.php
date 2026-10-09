@extends('layouts.admin')

@section('title', 'Dashboard - Resto Mayo')

@section('content')
<div class="space-y-8">

    <!-- Welcome Header -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 relative overflow-hidden">
        <div class="absolute -right-8 -top-8 w-60 h-60 bg-resto-red-50 rounded-full pointer-events-none -z-0"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-resto-gold-100 text-resto-gold-800 border border-resto-gold-200">
                    <span class="w-2 h-2 rounded-full bg-resto-gold-600 animate-pulse"></span>
                    <span>Sistem Restoran Aktif</span>
                </span>
                <h1 class="text-3xl font-bold tracking-tight text-resto-red-900 mt-2 font-poppins">
                    Selamat Datang di Resto Mayo Admin
                </h1>
                <p class="text-sm text-gray-500 mt-1 max-w-xl">
                    Kelola menu masakan, pantau pesanan dapur, dan atur kategori hidangan dengan suasana elegan dan modern.
                </p>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.categories.index') }}" 
                   class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-resto-red-800 hover:bg-resto-red-900 text-white text-sm font-medium transition-all shadow-sm">
                    <svg class="w-4 h-4 text-resto-gold-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <span>Kelola Kategori</span>
                </a>
                <a href="{{ route('admin.products.index') }}" 
                   class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-resto-gold-50 hover:bg-resto-gold-100 text-resto-gold-800 border border-resto-gold-200 text-sm font-semibold transition-all">
                    <span>Daftar Menu</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Stat: Kategori -->
        <a href="{{ route('admin.categories.index') }}" class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-resto-red-200 transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Kategori</p>
                    <h3 class="text-2xl font-bold text-resto-red-900 mt-1 font-poppins">Kelola Master</h3>
                    <p class="text-xs text-resto-gold-700 mt-1 font-medium group-hover:underline">Buka Kategori &rarr;</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-resto-red-100 text-resto-red-800 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            </div>
        </a>

        <!-- Stat: Produk -->
        <a href="{{ route('admin.products.index') }}" class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-resto-gold-200 transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Produk Kuliner</p>
                    <h3 class="text-2xl font-bold text-resto-gold-800 mt-1 font-poppins">Menu Makanan</h3>
                    <p class="text-xs text-resto-gold-700 mt-1 font-medium group-hover:underline">Buka Produk &rarr;</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-resto-gold-100 text-resto-gold-800 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
        </a>

        <!-- Stat: Pesanan Pending -->
        <a href="{{ route('admin.orders.index') }}" class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-resto-red-200 transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Pesanan Pending</p>
                    <h3 class="text-2xl font-bold text-resto-red-900 mt-1 font-poppins">{{ $pendingOrders ?? 0 }}</h3>
                    <p class="text-xs text-resto-red-700 mt-1 font-medium group-hover:underline">Buka Pesanan &rarr;</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-resto-red-100 text-resto-red-800 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </a>

        <!-- Stat: Dapur Resto -->
        <a href="{{ route('admin.kitchen.index') }}" class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-resto-gold-200 transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Status Dapur</p>
                    <h3 class="text-2xl font-bold text-resto-gold-800 mt-1 font-poppins">Live Kitchen</h3>
                    <p class="text-xs text-resto-gold-700 mt-1 font-medium group-hover:underline">Pantau Dapur &rarr;</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-resto-gold-100 text-resto-gold-800 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343a7.975 7.975 0 010 11.314z"/>
                    </svg>
                </div>
            </div>
        </a>
    </div>

</div>
@endsection

