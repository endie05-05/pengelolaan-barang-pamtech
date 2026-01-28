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
    
    <!-- Main Container -->
    <div class="min-h-screen flex items-center justify-center p-4 md:p-8">
        
        <!-- Card Container -->
        <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl shadow-slate-200/50 overflow-hidden flex flex-col lg:flex-row">
            
            <!-- Left Panel - Branding -->
            <div class="relative lg:w-1/2 p-8 lg:p-12 flex flex-col min-h-[300px] lg:min-h-[700px]" style="background: linear-gradient(135deg, #006600 0%, #1c2a18 100%);">
                
                <!-- Network Pattern Background -->
                <div class="absolute top-0 left-0 w-full h-full overflow-hidden">
                    <!-- SVG Network Lines & Cable Pattern -->
                    <svg class="absolute inset-0 w-full h-full opacity-20" xmlns="http://www.w3.org/2000/svg">
                        <!-- Network connection lines -->
                        <line x1="10%" y1="15%" x2="35%" y2="25%" stroke="white" stroke-width="1"/>
                        <line x1="35%" y1="25%" x2="25%" y2="45%" stroke="white" stroke-width="1"/>
                        <line x1="35%" y1="25%" x2="60%" y2="20%" stroke="white" stroke-width="1"/>
                        <line x1="60%" y1="20%" x2="85%" y2="35%" stroke="white" stroke-width="1"/>
                        <line x1="25%" y1="45%" x2="45%" y2="55%" stroke="white" stroke-width="1"/>
                        <line x1="45%" y1="55%" x2="70%" y2="45%" stroke="white" stroke-width="1"/>
                        <line x1="70%" y1="45%" x2="85%" y2="35%" stroke="white" stroke-width="1"/>
                        <line x1="70%" y1="45%" x2="90%" y2="60%" stroke="white" stroke-width="1"/>
                        <line x1="45%" y1="55%" x2="30%" y2="75%" stroke="white" stroke-width="1"/>
                        <line x1="30%" y1="75%" x2="55%" y2="85%" stroke="white" stroke-width="1"/>
                        <line x1="55%" y1="85%" x2="80%" y2="75%" stroke="white" stroke-width="1"/>
                        <line x1="90%" y1="60%" x2="80%" y2="75%" stroke="white" stroke-width="1"/>
                        <line x1="10%" y1="65%" x2="30%" y2="75%" stroke="white" stroke-width="1"/>
                        <line x1="25%" y1="45%" x2="10%" y2="65%" stroke="white" stroke-width="1"/>
                        <!-- Extra cable lines -->
                        <line x1="5%" y1="30%" x2="15%" y2="35%" stroke="white" stroke-width="1.5" stroke-dasharray="4,2"/>
                        <line x1="85%" y1="15%" x2="95%" y2="25%" stroke="white" stroke-width="1.5" stroke-dasharray="4,2"/>
                        <line x1="5%" y1="85%" x2="20%" y2="90%" stroke="white" stroke-width="1.5" stroke-dasharray="4,2"/>
                    </svg>
                    
                    <!-- Network Nodes -->
                    <div class="absolute top-[15%] left-[10%] w-3 h-3 bg-white/60 rounded-full shadow-lg shadow-white/30"></div>
                    <div class="absolute top-[25%] left-[35%] w-4 h-4 bg-white/80 rounded-full shadow-lg shadow-white/40"></div>
                    <div class="absolute top-[20%] left-[60%] w-3 h-3 bg-cyan-200/70 rounded-full shadow-lg shadow-cyan-200/30"></div>
                    <div class="absolute top-[35%] right-[15%] w-4 h-4 bg-white/60 rounded-full shadow-lg shadow-white/30"></div>
                    <div class="absolute top-[45%] left-[25%] w-3 h-3 bg-white/50 rounded-full"></div>
                    <div class="absolute top-[55%] left-[45%] w-5 h-5 bg-yellow-400/90 rounded-full shadow-lg shadow-yellow-400/50"></div>
                    <div class="absolute top-[45%] left-[70%] w-3 h-3 bg-cyan-200/80 rounded-full shadow-lg shadow-cyan-200/40"></div>
                    <div class="absolute top-[60%] right-[10%] w-3 h-3 bg-white/50 rounded-full"></div>
                    <div class="absolute top-[65%] left-[10%] w-3 h-3 bg-white/40 rounded-full"></div>
                    <div class="absolute top-[75%] left-[30%] w-4 h-4 bg-white/70 rounded-full shadow-lg shadow-white/30"></div>
                    <div class="absolute top-[85%] left-[55%] w-3 h-3 bg-cyan-200/60 rounded-full"></div>
                    <div class="absolute top-[75%] right-[20%] w-4 h-4 bg-white/80 rounded-full shadow-lg shadow-white/40"></div>
                    
                    <!-- CCTV Camera Icon 1 -->
                    <div class="absolute top-[8%] right-[25%] text-white/40">
                        <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18 10.48V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-4.48l4 3.98v-11l-4 3.98zM16 18H4V6h12v12zm-3-7h-2V9h2v2zm0 4h-2v-2h2v2zm-4-4H7V9h2v2zm0 4H7v-2h2v2z"/>
                        </svg>
                    </div>
                    
                    <!-- CCTV Camera Icon 2 (surveillance style) -->
                    <div class="absolute top-[35%] left-[5%] text-white/30">
                        <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                        </svg>
                    </div>
                    
                    <!-- Router/WiFi Icon -->
                    <div class="absolute top-[12%] left-[45%] text-white/35">
                        <svg class="w-14 h-14" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 6c3.33 0 6.49 1.08 9.08 3.07L12 18.17l-9.08-9.1C5.51 7.08 8.67 6 12 6m0-2C7.95 4 4.21 5.34 1.2 7.63l-.7.55c-.23.18-.37.46-.37.75s.14.57.36.75L11.61 20.2c.12.1.28.15.43.15.13 0 .26-.04.37-.11L22.79 9.68c.23-.18.36-.46.36-.75s-.14-.57-.37-.75l-.7-.55C19.08 5.34 15.34 4 12 4z"/>
                        </svg>
                    </div>
                    
                    <!-- Network Switch Icon -->
                    <div class="absolute bottom-[25%] right-[8%] text-white/30">
                        <svg class="w-18 h-18 lg:w-20 lg:h-20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM5 7h2v2H5V7zm0 4h2v2H5v-2zm0 4h2v2H5v-2zm14 3H8v-2h11v2zm0-4H8v-2h11v2zm0-4H8V8h11v2z"/>
                        </svg>
                    </div>
                    
                    <!-- Cable/Ethernet Icon -->
                    <div class="absolute top-[70%] left-[85%] text-white/25">
                        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M7.77 6.76L6.23 5.48.82 12l5.41 6.52 1.54-1.28L3.42 12l4.35-5.24zM7 13h2v-2H7v2zm10-2h-2v2h2v-2zm-6 2h2v-2h-2v2zm6.77-7.52l-1.54 1.28L20.58 12l-4.35 5.24 1.54 1.28L23.18 12l-5.41-6.52z"/>
                        </svg>
                    </div>
                    
                    <!-- Server/Monitor Icon -->
                    <div class="absolute bottom-[40%] left-[15%] text-white/25">
                        <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M21 2H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h7v2H8v2h8v-2h-2v-2h7c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H3V4h18v12z"/>
                        </svg>
                    </div>
                    
                    <!-- Antenna/Signal Icon -->
                    <div class="absolute top-[50%] right-[30%] text-white/20">
                        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 5c-3.87 0-7 3.13-7 7h2c0-2.76 2.24-5 5-5s5 2.24 5 5h2c0-3.87-3.13-7-7-7zm0 4c-1.66 0-3 1.34-3 3h2c0-.55.45-1 1-1s1 .45 1 1h2c0-1.66-1.34-3-3-3zm0-8C5.93 1 1 5.93 1 12h2c0-4.97 4.03-9 9-9s9 4.03 9 9h2c0-6.07-4.93-11-11-11z"/>
                        </svg>
                    </div>
                    
                    <!-- Animated pulse nodes -->
                    <div class="absolute top-[55%] left-[45%] w-5 h-5 bg-yellow-400/30 rounded-full animate-ping"></div>
                    <div class="absolute top-[25%] left-[35%] w-4 h-4 bg-white/20 rounded-full animate-ping" style="animation-delay: 0.5s"></div>
                    <div class="absolute top-[75%] right-[20%] w-4 h-4 bg-white/20 rounded-full animate-ping" style="animation-delay: 1s"></div>
                    
                    <!-- Circle outline decorations -->
                    <div class="absolute top-1/2 right-8 w-16 h-16 border-2 border-white/20 rounded-full"></div>
                    <div class="absolute bottom-[15%] left-[5%] w-20 h-20 border border-white/10 rounded-full"></div>
                </div>

                <!-- Content -->
                <div class="relative z-10 flex-1 flex flex-col">
                    <!-- Logo -->
                    <div class="flex items-center gap-3 mb-8 lg:mb-12">
                                                <img src="{{ asset('assets/logo-pure.png') }}" alt="Pamtechno Logo" class="w-14 h-14 lg:w-16 lg:h-16 object-contain brightness-0 invert">
                        <span class="text-white font-semibold text-lg lg:text-xl">Pam-Inventory</span>
                    </div>

                    <!-- Tagline -->
                    <div class="mb-8 lg:mb-auto">
                        <h1 class="text-2xl lg:text-4xl font-bold text-white leading-tight">
                            Kelola inventaris proyek dengan mudah dan efisien
                        </h1>
                    </div>

                    <!-- Illustration Area -->
                    <div class="relative mt-auto hidden lg:block">
                        <!-- Mock Dashboard Cards -->
                        <div class="relative w-full max-w-md mx-auto">
                            <!-- Background Card -->
                            <div class="absolute inset-0 bg-cyan-300/40 rounded-2xl transform translate-x-4 translate-y-4"></div>
                            
                            <!-- Main Dashboard Preview -->
                            <div class="relative bg-gradient-to-br from-cyan-400 to-cyan-300 rounded-2xl p-4 shadow-xl">
                                <div class="grid grid-cols-3 gap-2">
                                    <!-- Card 1 -->
                                    <div class="bg-white/90 rounded-lg p-2 h-20">
                                        <div class="w-4 h-1 bg-slate-300 rounded mb-2"></div>
                                        <div class="w-8 h-1 bg-slate-200 rounded mb-1"></div>
                                        <div class="w-6 h-1 bg-slate-200 rounded"></div>
                                    </div>
                                    <!-- Center Card (highlighted) -->
                                    <div class="bg-gradient-to-br from-pink-400 to-purple-500 rounded-lg p-2 h-24 -mt-2 shadow-lg">
                                        <div class="w-4 h-1 bg-white/50 rounded mb-2"></div>
                                        <div class="w-8 h-1 bg-white/30 rounded mb-1"></div>
                                        <div class="w-6 h-1 bg-white/30 rounded"></div>
                                    </div>
                                    <!-- Card 3 -->
                                    <div class="bg-white/90 rounded-lg p-2 h-20">
                                        <div class="w-4 h-1 bg-slate-300 rounded mb-2"></div>
                                        <div class="w-8 h-1 bg-slate-200 rounded mb-1"></div>
                                        <div class="w-6 h-1 bg-slate-200 rounded"></div>
                                    </div>
                                </div>
                                <!-- Bottom rows -->
                                <div class="mt-2 space-y-1">
                                    <div class="bg-white/60 rounded h-3"></div>
                                    <div class="bg-white/60 rounded h-3"></div>
                                    <div class="bg-white/60 rounded h-3 w-3/4"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Panel - Login Form -->
            <div class="lg:w-1/2 p-8 lg:p-12 flex flex-col justify-center">
                
                <!-- Form Header -->
                <div class="mb-8">
                    <h2 class="text-2xl lg:text-3xl font-bold text-slate-800 mb-2">Masuk</h2>
                    <p class="text-slate-400 text-sm">Masukkan kredensial Anda untuk mengakses sistem inventaris.</p>
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

                <!-- Divider -->
                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-4 bg-white text-sm text-slate-400">atau</span>
                    </div>
                </div>

                <!-- Help Links -->
                <div class="text-center space-y-3">
                    <p class="text-slate-500 text-sm">
                        Butuh bantuan? <a href="#" class="text-blue-500 hover:text-blue-600 font-medium transition-colors">Hubungi Admin</a>
                    </p>
                    <a href="#panduan" class="inline-flex items-center justify-center gap-2 text-sm text-slate-600 hover:text-slate-800 font-medium transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Panduan Penggunaan
                    </a>
                </div>

                <!-- Footer -->
                <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                    <p class="text-xs text-slate-400">© {{ date('Y') }} Pam-Techno. Internal Use Only.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
