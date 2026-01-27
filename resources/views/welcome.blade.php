<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pam-Inventory - Smart Asset Management</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800">
    
    <!-- Hero Section -->
    <div class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden">
        
        <!-- Background Decoration -->
        <div class="absolute inset-0 z-0">
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-indigo-500/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-purple-500/10 rounded-full blur-3xl"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 w-full max-w-4xl px-4 text-center">
            
            <!-- Logo Badge -->
            <div class="inline-flex items-center px-3 py-1 mb-8 rounded-full bg-white border border-slate-200 shadow-sm">
                <span class="w-2 h-2 mr-2 bg-green-500 rounded-full animate-pulse"></span>
                <span class="text-xs font-medium text-slate-600 tracking-wide uppercase">System Operational</span>
            </div>

            <!-- Main Headline -->
            <h1 class="text-5xl md:text-7xl font-bold tracking-tight text-slate-900 mb-6">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Pam-Inventory</span>
            </h1>
            <p class="text-lg md:text-xl text-slate-600 mb-10 max-w-2xl mx-auto leading-relaxed">
                Platform manajemen aset cerdas untuk memantau stok proyek secara real-time. 
                <span class="block mt-2 text-slate-500 italic">"No More Ghost Stock."</span>
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('login') }}" class="group relative inline-flex items-center justify-center px-8 py-3.5 text-base font-semibold text-white transition-all duration-200 bg-indigo-600 rounded-full hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
                    <span>Masuk ke Sistem</span>
                    <svg class="w-5 h-5 ml-2 -mr-1 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
                
                <!-- Secondary Button (Optional) -->
                <a href="#" class="inline-flex items-center justify-center px-8 py-3.5 text-base font-medium text-slate-600 transition-all duration-200 bg-white border border-slate-200 rounded-full hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-200">
                    Panduan Penggunaan
                </a>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-16 text-left">
                <!-- Feature 1 -->
                <div class="p-6 bg-white/60 backdrop-blur-sm border border-slate-100 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 mb-4 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Smart Template</h3>
                    <p class="text-slate-500 text-sm">Otomatisasi daftar barang bawaan berdasarkan tipe proyek.</p>
                </div>

                <!-- Feature 2 -->
                <div class="p-6 bg-white/60 backdrop-blur-sm border border-slate-100 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 mb-4 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Mobile Reporting</h3>
                    <p class="text-slate-500 text-sm">Lapor pemakaian barang langsung dari lokasi proyek via HP.</p>
                </div>

                <!-- Feature 3 -->
                <div class="p-6 bg-white/60 backdrop-blur-sm border border-slate-100 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 mb-4 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Photo Evidence</h3>
                    <p class="text-slate-500 text-sm">Bukti visual wajib untuk setiap pelaporan barang rusak.</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-16 border-t border-slate-200/60 pt-8">
                <p class="text-sm text-slate-400">© {{ date('Y') }} Pam-Techno. Internal Use Only.</p>
            </div>
        </div>
    </div>
</body>
</html>
