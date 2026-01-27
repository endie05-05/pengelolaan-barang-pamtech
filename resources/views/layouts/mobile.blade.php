<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Teknisi - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800 pb-20">
    
    <!-- Top Header -->
    <div class="bg-indigo-600 px-4 py-4 shadow-lg sticky top-0 z-50">
        <div class="flex justify-between items-center text-white">
            <h1 class="text-lg font-bold tracking-wide">PAM-TECH</h1>
            <div class="h-8 w-8 rounded-full bg-indigo-500 border border-indigo-400 flex items-center justify-center text-xs font-bold">
                TK
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="p-4">
        {{ $slot }}
    </main>

    <!-- Bottom Navigation -->
    <div class="fixed bottom-0 left-0 w-full bg-white border-t border-slate-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] pb-safe">
        <div class="flex justify-around items-center h-16">
            <a href="#" class="flex flex-col items-center justify-center w-full h-full text-indigo-600">
                <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <span class="text-[10px] font-medium">Proyek</span>
            </a>
            <a href="#" class="flex flex-col items-center justify-center w-full h-full text-slate-400 hover:text-indigo-600 transition-colors">
                <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-[10px] font-medium">Riwayat</span>
            </a>
            <a href="#" class="flex flex-col items-center justify-center w-full h-full text-slate-400 hover:text-indigo-600 transition-colors">
                <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="text-[10px] font-medium">Profil</span>
            </a>
        </div>
    </div>
</body>
</html>