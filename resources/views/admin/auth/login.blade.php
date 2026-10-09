<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - Resto Mayo</title>

    <!-- Google Font: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <!-- Tailwind CSS via CDN -->
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
                        },
                        'resto-gold': {
                            50: '#FFFBEB',
                            100: '#FEF3C7',
                            200: '#FDE68A',
                            600: '#D97706',
                            700: '#B45309',
                            800: '#92400E',
                            900: '#78350F',
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
        }
    </style>
</head>
<body class="bg-white min-h-screen flex flex-col justify-center items-center p-4 font-sans text-gray-800">

    <!-- Decorative Top Accent -->
    <div class="fixed top-0 inset-x-0 h-1.5 bg-gradient-to-r from-resto-red-900 via-resto-red-700 to-resto-gold-700"></div>

    <div class="w-full max-w-md">

        <!-- Logo & Restaurant Branding -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-2xl bg-resto-red-800 text-resto-gold-200 flex items-center justify-center shadow-lg border border-resto-gold-700/50 mx-auto mb-3">
                <svg class="w-8 h-8 fill-current" viewBox="0 0 24 24">
                    <path d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm5-3v8h2.5v8H21V2c-2.76 0-5 2.24-5 4z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-extrabold text-resto-red-900 font-poppins tracking-tight">
                Resto<span class="text-resto-gold-700">Mayo</span>
            </h1>
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mt-1">
                Restricted Admin Access Portal
            </p>
        </div>

        <!-- Login Card (Pure White with Subtle Border) -->
        <div class="bg-white rounded-3xl border border-gray-100 shadow-xl p-8 sm:p-10 relative overflow-hidden">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-resto-red-50 rounded-full -z-0"></div>

            <div class="relative z-10">
                <h2 class="text-xl font-bold text-gray-900 font-poppins mb-1">
                    Masuk Ke Panel Admin
                </h2>
                <p class="text-xs text-gray-400 mb-6">
                    Akses khusus staf terotorisasi Resto Mayo.
                </p>

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="mb-5 p-3.5 rounded-xl bg-resto-red-50 border border-resto-red-200 text-xs text-resto-red-900 flex items-start space-x-2">
                        <svg class="w-4 h-4 text-resto-red-700 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                    @csrf

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-gray-600 mb-1.5 font-poppins">
                            Alamat Email Admin
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"/>
                                </svg>
                            </div>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus
                                   placeholder="admin@restomayo.com"
                                   class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-resto-red-700 focus:border-transparent transition-all">
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-gray-600 mb-1.5 font-poppins">
                            Kata Sandi (Password)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   required 
                                   placeholder="••••••••"
                                   class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-resto-red-700 focus:border-transparent transition-all">
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center space-x-2 cursor-pointer text-gray-600">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-resto-red-800 focus:ring-resto-red-700">
                            <span>Ingat Sesi Masuk</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-3">
                        <button type="submit" 
                                class="w-full py-3.5 rounded-xl bg-resto-red-800 hover:bg-resto-red-900 text-white font-medium text-sm shadow-md hover:shadow-lg transition-all duration-200 border border-resto-gold-700/50 flex items-center justify-center space-x-2">
                            <span>Masuk ke Sistem</span>
                            <svg class="w-4 h-4 text-resto-gold-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </div>
                </form>

            </div>
        </div>

        <p class="text-center text-xs text-gray-400 mt-6">
            &copy; {{ date('Y') }} Resto Mayo. Hak Cipta Dilindungi.
        </p>

    </div>

</body>
</html>

