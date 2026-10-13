<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Resto Mayo - Admin Panel')</title>

    <!-- Google Font: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (CDN Fallback & Vite Support) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                        poppins: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        'resto-red': {
                            50: '#FDF2F2',
                            100: '#FDE8E8',
                            200: '#FBD5D5',
                            600: '#9B1C1C',
                            700: '#8A151B',
                            800: '#751016',
                            900: '#5F0C11',
                            950: '#42070B',
                        },
                        'resto-gold': {
                            50: '#FFFBEB',
                            100: '#FEF3C7',
                            200: '#FDE68A',
                            600: '#D97706',
                            700: '#B45309',
                            800: '#92400E',
                            900: '#78350F',
                            950: '#451A03',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        body {
            background-color: #FFFFFF;
            color: #1F2937;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #F9FAFB;
        }
        ::-webkit-scrollbar-thumb {
            background: #D1D5DB;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #9CA3AF;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-white min-h-screen flex flex-col font-sans antialiased text-gray-800">

    <!-- Top Announcement Bar / Elegant Header Accent -->
    <div class="h-1.5 w-full bg-gradient-to-r from-resto-red-900 via-resto-red-700 to-resto-gold-700"></div>

    <!-- Navigation Bar -->
    <header class="bg-white border-b border-gray-100 sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                
                <!-- Brand / Logo -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 group">
                        <div class="w-12 h-12 rounded-xl bg-resto-red-800 text-resto-gold-200 flex items-center justify-center shadow-md group-hover:scale-105 transition-transform duration-200 border border-resto-gold-700/40">
                            <!-- Restaurant Food Icon -->
                            <svg class="w-7 h-7 fill-current" viewBox="0 0 24 24">
                                <path d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm5-3v8h2.5v8H21V2c-2.76 0-5 2.24-5 4z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center space-x-1.5">
                                <span class="text-2xl font-bold tracking-tight text-resto-red-900 font-poppins">Resto<span class="text-resto-gold-700">Mayo</span></span>
                                <span class="inline-block w-2 h-2 rounded-full bg-resto-gold-600 animate-pulse"></span>
                            </div>
                            <p class="text-[11px] font-medium uppercase tracking-wider text-gray-400">Admin Restaurant</p>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation Menu -->
                <nav class="hidden md:flex items-center space-x-1 lg:space-x-2">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-resto-red-50 text-resto-red-800 font-semibold border-b-2 border-resto-red-800' : 'text-gray-600 hover:text-resto-red-800 hover:bg-gray-50' }}">
                        <span class="flex items-center space-x-2">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.dashboard') ? 'text-resto-red-800' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>Dashboard</span>
                        </span>
                    </a>

                    <!-- Kategori Tab (Active) -->
                    <a href="{{ route('admin.categories.index') }}" 
                       class="px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.categories.*') ? 'bg-resto-red-800 text-white font-semibold shadow-sm' : 'text-gray-600 hover:text-resto-red-800 hover:bg-gray-50' }}">
                        <span class="flex items-center space-x-2">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.categories.*') ? 'text-resto-gold-200' : 'text-resto-gold-700' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            <span>Kategori</span>
                        </span>
                    </a>

                    <!-- Produk Tab -->
                    <a href="{{ route('admin.products.index') }}" 
                       class="px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.products.*') ? 'bg-resto-red-800 text-white font-semibold shadow-sm' : 'text-gray-600 hover:text-resto-red-800 hover:bg-gray-50' }}">
                        <span class="flex items-center space-x-2">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.products.*') ? 'text-resto-gold-200' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span>Produk Menu</span>
                        </span>
                    </a>

                    <!-- Pesanan Tab -->
                    <a href="{{ route('admin.orders.index') }}" 
                       class="px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.orders.*') ? 'bg-resto-red-800 text-white font-semibold shadow-sm' : 'text-gray-600 hover:text-resto-red-800 hover:bg-gray-50' }}">
                        <span class="flex items-center space-x-2">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.orders.*') ? 'text-resto-gold-200' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span>Pesanan</span>
                        </span>
                    </a>

                    <!-- Kitchen Tab -->
                    <a href="{{ route('admin.kitchen.index') }}" 
                       class="px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.kitchen.*') ? 'bg-resto-red-800 text-white font-semibold shadow-sm' : 'text-gray-600 hover:text-resto-red-800 hover:bg-gray-50' }}">
                        <span class="flex items-center space-x-2">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.kitchen.*') ? 'text-resto-gold-200' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343a7.975 7.975 0 010 11.314z"/>
                            </svg>
                            <span>Dapur</span>
                        </span>
                    </a>
                </nav>

                <!-- Right Side Actions -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('menu.index') }}" target="_blank"
                       class="hidden sm:inline-flex items-center space-x-2 px-3.5 py-2 text-xs font-semibold rounded-lg text-resto-gold-800 bg-resto-gold-50 hover:bg-resto-gold-100 border border-resto-gold-200 transition-colors">
                        <svg class="w-4 h-4 text-resto-gold-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        <span>Lihat Menu Publik</span>
                    </a>

                    <!-- Admin User / Logout -->
                    <div class="relative flex items-center pl-3 border-l border-gray-200">
                        <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="inline-flex items-center space-x-1.5 px-3 py-2 text-xs font-medium rounded-lg text-resto-red-800 hover:bg-resto-red-50 hover:text-resto-red-900 border border-transparent hover:border-resto-red-200 transition-colors"
                                    title="Keluar dari Admin">
                                <svg class="w-4 h-4 text-resto-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span class="hidden sm:inline">Logout</span>
                            </button>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </header>

    <!-- Main Content Canvas (Crisp White Background) -->
    <main class="flex-1 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- Flash Notification: Success -->
            @if(session('success'))
                <div class="mb-6 bg-white border-l-4 border-resto-red-800 p-4 rounded-r-xl shadow-sm border border-gray-100 flex items-start justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-resto-gold-100 text-resto-gold-800 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5 text-resto-gold-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold uppercase tracking-wider text-resto-gold-800">Berhasil</h4>
                            <p class="text-sm font-medium text-gray-700">{{ session('success') }}</p>
                        </div>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-gray-400 hover:text-gray-600 p-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Flash Notification: Error -->
            @if(session('error'))
                <div class="mb-6 bg-white border-l-4 border-resto-red-800 p-4 rounded-r-xl shadow-sm border border-gray-100 flex items-start justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-resto-red-100 text-resto-red-800 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5 text-resto-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold uppercase tracking-wider text-resto-red-900">Perhatian / Peringatan</h4>
                            <p class="text-sm font-medium text-gray-700">{{ session('error') }}</p>
                        </div>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-gray-400 hover:text-gray-600 p-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Validation Errors -->
            @if($errors->any())
                <div class="mb-6 bg-white border-l-4 border-resto-red-700 p-4 rounded-r-xl shadow-sm border border-gray-100">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-resto-red-100 text-resto-red-800 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5 text-resto-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold uppercase tracking-wider text-resto-red-800">Terdapat Kesalahan Input:</h4>
                            <ul class="mt-1 list-disc list-inside text-sm text-gray-600 space-y-0.5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Page Body Yield -->
            @yield('content')

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-400 space-y-2 sm:space-y-0">
            <div class="flex items-center space-x-2">
                <span class="font-semibold text-resto-red-900 font-poppins">Resto Mayo</span>
                <span>•</span>
                <span>Sistem Manajemen Restoran Elegan & Modern</span>
            </div>
            <div>
                <span>Cita Rasa Terbaik &copy; {{ date('Y') }} Resto Mayo. All rights reserved.</span>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

