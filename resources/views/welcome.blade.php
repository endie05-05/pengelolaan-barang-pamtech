<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pam-Inventory - Smart Asset Management</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="antialiased bg-slate-100">
    
    <!-- Background Pattern & Icons -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <!-- Grid Pattern -->
        <svg class="absolute inset-0 w-full h-full opacity-[0.03]" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid-pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="1"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid-pattern)" class="text-slate-900"/>
        </svg>

        <!-- Floating Icons (Scattered) -->
        
        <!-- Top Left: CCTV -->
        <div class="absolute top-[10%] left-[10%] text-slate-300/40 transform -rotate-12">
            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18 10.48V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-4.48l4 3.98v-11l-4 3.98zM16 18H4V6h12v12zm-3-7h-2V9h2v2zm0 4h-2v-2h2v2zm-4-4H7V9h2v2zm0 4H7v-2h2v2z"/>
            </svg>
        </div>

        <!-- Top Right: Wi-Fi Router -->
        <div class="absolute top-[15%] right-[15%] text-slate-300/40 transform rotate-12">
            <svg class="w-28 h-28" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 6c3.33 0 6.49 1.08 9.08 3.07L12 18.17l-9.08-9.1C5.51 7.08 8.67 6 12 6m0-2C7.95 4 4.21 5.34 1.2 7.63l-.7.55c-.23.18-.37.46-.37.75s.14.57.36.75L11.61 20.2c.12.1.28.15.43.15.13 0 .26-.04.37-.11L22.79 9.68c.23-.18.36-.46.36-.75s-.14-.57-.37-.75l-.7-.55C19.08 5.34 15.34 4 12 4z"/>
            </svg>
        </div>

        <!-- Bottom Left: Server/Rack -->
        <div class="absolute bottom-[10%] left-[8%] text-slate-300/40 transform rotate-6">
            <svg class="w-36 h-36" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20 3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM5 7h2v2H5V7zm0 4h2v2H5v-2zm0 4h2v2H5v-2zm14 3H8v-2h11v2zm0-4H8v-2h11v2zm0-4H8V8h11v2z"/>
            </svg>
        </div>

        <!-- Bottom Right: Ethernet Cable -->
        <div class="absolute bottom-[15%] right-[10%] text-slate-300/40 transform -rotate-12">
            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                <path d="M7.77 6.76L6.23 5.48.82 12l5.41 6.52 1.54-1.28L3.42 12l4.35-5.24zM7 13h2v-2H7v2zm10-2h-2v2h2v-2zm-6 2h2v-2h-2v2zm6.77-7.52l-1.54 1.28L20.58 12l-4.35 5.24 1.54 1.28L23.18 12l-5.41-6.52z"/>
            </svg>
        </div>

        <!-- Center: Network Nodes (Connecting Lines) -->
        <svg class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] opacity-[0.02] pointer-events-none" viewBox="0 0 800 600">
             <path d="M200,100 L400,300 M400,300 L600,100 M400,300 L200,500 M400,300 L600,500" stroke="currentColor" stroke-width="2" class="text-slate-900" />
             <circle cx="200" cy="100" r="10" fill="currentColor" class="text-slate-900"/>
             <circle cx="600" cy="100" r="10" fill="currentColor" class="text-slate-900"/>
             <circle cx="200" cy="500" r="10" fill="currentColor" class="text-slate-900"/>
             <circle cx="600" cy="500" r="10" fill="currentColor" class="text-slate-900"/>
             <circle cx="400" cy="300" r="20" fill="currentColor" class="text-slate-900"/>
        </svg>
    </div>

    <!-- Main Container -->
    <div class="min-h-screen flex items-center justify-center p-4 md:p-8 relative z-10">
        
        <!-- Card Container -->
        <div class="w-full max-w-md bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl shadow-slate-200/50 p-8 lg:p-12 border border-white/50">
            
            <!-- Logo -->
            <div class="flex flex-col items-center justify-center mb-8">
                <img src="{{ asset('assets/logo-pure.png') }}" alt="Pamtechno Logo" class="w-24 h-auto object-contain mb-4">
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">PAM-TECHNO</h1>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-600 mb-2">Email</label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="nama@pamtechno.com"
                        required 
                        autofocus
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50/50 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#6eea8e] focus:border-transparent transition-all duration-200"
                    />
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-600 mb-2">Password</label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        placeholder="••••••••"
                        required
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50/50 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#6eea8e] focus:border-transparent transition-all duration-200"
                    />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-[#006600] focus:ring-[#6eea8e] focus:ring-offset-0">
                        <span class="ml-2 text-sm text-slate-600">Ingat saya</span>
                    </label>
                    <a href="#" class="text-sm text-[#826cf6] hover:text-[#6c54e0] font-medium transition-colors">Lupa password?</a>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full text-white font-semibold py-3.5 px-6 rounded-xl shadow-lg hover:shadow-xl hover:opacity-90 transition-all duration-200 flex items-center justify-center gap-2" style="background-color: #006600; box-shadow: 0 10px 15px -3px rgba(0, 102, 0, 0.3);"
                >
                    Masuk ke Sistem
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</body>
</html>
