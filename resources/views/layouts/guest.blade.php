<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Pam-techno Inventory') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('assets/logo-pure.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased bg-slate-50">
        <div class="min-h-screen flex bg-white">
            <!-- Left Side (Hero) -->
            <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-green-900">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <defs>
                            <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                                <path d="M 10 0 L 0 0 0 10" fill="none" stroke="currentColor" stroke-width="0.5"/>
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#grid)" class="text-white"/>
                    </svg>
                </div>
                
                <!-- Content -->
                <div class="relative z-10 w-full flex flex-col justify-between p-12 text-white">
                    <!-- Logo Area -->
                    <div class="flex items-center space-x-3">
                        <div class="bg-white/10 p-2 rounded-xl backdrop-blur-sm border border-white/20">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold tracking-wide">Pam-Inventory</span>
                    </div>

                    <!-- Hero Text -->
                    <div class="space-y-6 max-w-lg">
                        <h1 class="text-5xl font-bold leading-tight">
                            Kelola inventaris proyek dengan mudah dan efisien
                        </h1>
                        <p class="text-green-100 text-lg leading-relaxed">
                            Sistem terintegrasi untuk tracking inventory, monitoring tools, dan laporan audit secara realtime untuk kebutuhan proyek Pam-Techno.
                        </p>
                    </div>

                    <!-- Illustration / Cards Mockup -->
                    <div class="relative mt-8">
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 shadow-2xl transform translate-y-4">
                            <div class="flex space-x-4 mb-4">
                                <div class="w-1/3 h-24 bg-white/20 rounded-xl animate-pulse"></div>
                                <div class="w-1/3 h-24 bg-green-500 rounded-xl shadow-lg transform -translate-y-2"></div>
                                <div class="w-1/3 h-24 bg-white/20 rounded-xl animate-pulse"></div>
                            </div>
                            <div class="space-y-2">
                                <div class="h-3 w-3/4 bg-white/30 rounded-full"></div>
                                <div class="h-3 w-1/2 bg-white/20 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Abstract Circles -->
                <div class="absolute top-1/4 right-0 w-64 h-64 bg-green-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-emerald-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            </div>

            <!-- Right Side (Login Form) -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
                <div class="w-full max-w-md">
                    {{ $slot }}
                    
                    <div class="mt-8 text-center text-xs text-slate-400">
                        &copy; {{ date('Y') }} Pam-Techno. Internal Use Only.
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
