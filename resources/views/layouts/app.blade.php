<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Resto Mayo - Restoran Pilihan Bersama')</title>

    <!-- Google Font: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <!-- Tailwind CSS via CDN with Resto Mayo Configuration -->
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
        }
        /* Toast notification animation */
        @keyframes slideDownFade {
            from {
                opacity: 0;
                transform: translateY(-20px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        .toast-animate {
            animation: slideDownFade 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Opening Scene Choreographed Animations */
        @keyframes openingEmblemIn {
            0% {
                opacity: 0;
                transform: translateY(-45px) scale(0.6);
                filter: blur(8px);
            }
            70% {
                opacity: 1;
                transform: translateY(4px) scale(1.04);
                filter: blur(0);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }
        @keyframes openingRestoSlide {
            0% {
                opacity: 0;
                transform: translateX(-50px);
                filter: blur(6px);
            }
            70% {
                opacity: 1;
                transform: translateX(4px);
                filter: blur(0);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
                filter: blur(0);
            }
        }
        @keyframes openingMayoSlide {
            0% {
                opacity: 0;
                transform: translateX(50px);
                filter: blur(6px);
            }
            70% {
                opacity: 1;
                transform: translateX(-4px);
                filter: blur(0);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
                filter: blur(0);
            }
        }
        @keyframes openingDividerExpand {
            0% {
                opacity: 0;
                transform: scaleX(0);
            }
            100% {
                opacity: 1;
                transform: scaleX(1);
            }
        }
        @keyframes openingTaglineRise {
            0% {
                opacity: 0;
                transform: translateY(20px);
                letter-spacing: 0.05em;
            }
            100% {
                opacity: 1;
                transform: translateY(0);
                letter-spacing: 0.22em;
            }
        }
        @keyframes openingPillFade {
            0% {
                opacity: 0;
                transform: translateY(14px) scale(0.92);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        @keyframes openingBarFill {
            0% {
                width: 0%;
            }
            100% {
                width: 100%;
            }
        }
        @keyframes openingAuraPulse {
            0%, 100% {
                transform: scale(0.95);
                opacity: 0.25;
            }
            50% {
                transform: scale(1.2);
                opacity: 0.6;
            }
        }

        .anim-opening-emblem {
            animation: openingEmblemIn 0.85s cubic-bezier(0.16, 1, 0.3, 1) 0.15s both;
        }
        .anim-opening-resto {
            animation: openingRestoSlide 0.75s cubic-bezier(0.16, 1, 0.3, 1) 0.45s both;
        }
        .anim-opening-mayo {
            animation: openingMayoSlide 0.75s cubic-bezier(0.16, 1, 0.3, 1) 0.45s both;
        }
        .anim-opening-divider {
            animation: openingDividerExpand 0.65s cubic-bezier(0.16, 1, 0.3, 1) 0.75s both;
        }
        .anim-opening-tagline {
            animation: openingTaglineRise 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.95s both;
        }
        .anim-opening-pill {
            animation: openingPillFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) 1.2s both;
        }
        .anim-opening-bar {
            animation: openingBarFill 0.75s ease-out 1.25s both;
        }
        .anim-opening-aura {
            animation: openingAuraPulse 3s ease-in-out infinite;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-white min-h-screen flex flex-col font-sans text-gray-800 antialiased selection:bg-resto-red-800 selection:text-white overflow-x-hidden">

    @yield('opening_scene')

    @yield('content')

    @stack('scripts')
</body>
</html>

