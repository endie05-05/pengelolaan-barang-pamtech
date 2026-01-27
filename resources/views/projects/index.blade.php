<x-app-layout>
    <div class="space-y-6">
        <!-- Header with Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Daftar Proyek</h1>
                <p class="text-slate-600 mt-1">Kelola proyek instalasi</p>
            </div>
            <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Proyek Baru
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wider">Total Proyek</p>
                        <p class="text-2xl font-bold text-slate-900 mt-1">12</p>
                    </div>
                    <div class="h-10 w-10 bg-slate-100 rounded-lg flex items-center justify-center">
                        <svg class="h-5 w-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-blue-600 uppercase tracking-wider">Aktif</p>
                        <p class="text-2xl font-bold text-blue-600 mt-1">5</p>
                    </div>
                    <div class="h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-green-600 uppercase tracking-wider">Selesai</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">6</p>
                    </div>
                    <div class="h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-amber-600 uppercase tracking-wider">Pending</p>
                        <p class="text-2xl font-bold text-amber-600 mt-1">1</p>
                    </div>
                    <div class="h-10 w-10 bg-amber-100 rounded-lg flex items-center justify-center">
                        <svg class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" placeholder="Cari nama proyek..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <select class="px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="active">Aktif</option>
                    <option value="completed">Selesai</option>
                </select>
                <button class="px-6 py-2 bg-slate-700 text-white rounded-lg hover:bg-slate-800 transition">Filter</button>
            </div>
        </div>

        <!-- Projects Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Project Card 1 -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-5">
                    <div class="flex items-start justify-between mb-3">
                        <span class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full">Aktif</span>
                        <span class="text-xs text-slate-500">PRJ-001</span>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Instalasi CCTV Gudang A</h3>
                    <p class="text-sm text-slate-500 mb-4">
                        <svg class="inline w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Jl. Industri No. 45, Bandung
                    </p>
                    <div class="flex items-center text-sm text-slate-600 mb-4">
                        <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-medium text-xs mr-2">BS</div>
                        <span>Budi Santoso</span>
                    </div>
                    <div class="flex items-center justify-between text-xs text-slate-500 pt-3 border-t border-slate-100">
                        <span>Template: Paket CCTV 4CH</span>
                        <span>8 item</span>
                    </div>
                </div>
                <div class="bg-slate-50 px-5 py-3 flex items-center justify-between">
                    <span class="text-xs text-slate-500">Mulai: 20 Jan 2026</span>
                    <a href="{{ route('projects.show', 1) }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Lihat Detail →</a>
                </div>
            </div>

            <!-- Project Card 2 -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-5">
                    <div class="flex items-start justify-between mb-3">
                        <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Selesai</span>
                        <span class="text-xs text-slate-500">PRJ-002</span>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Access Control Kantor Pusat</h3>
                    <p class="text-sm text-slate-500 mb-4">
                        <svg class="inline w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Jl. Sudirman No. 123, Jakarta
                    </p>
                    <div class="flex items-center text-sm text-slate-600 mb-4">
                        <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-medium text-xs mr-2">AR</div>
                        <span>Ahmad Rizki</span>
                    </div>
                    <div class="flex items-center justify-between text-xs text-slate-500 pt-3 border-t border-slate-100">
                        <span>Template: Access Control</span>
                        <span>4 item</span>
                    </div>
                </div>
                <div class="bg-slate-50 px-5 py-3 flex items-center justify-between">
                    <span class="text-xs text-slate-500">Selesai: 15 Jan 2026</span>
                    <a href="{{ route('projects.show', 2) }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Lihat Detail →</a>
                </div>
            </div>

            <!-- Project Card 3 -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-5">
                    <div class="flex items-start justify-between mb-3">
                        <span class="px-3 py-1 text-xs font-medium bg-amber-100 text-amber-700 rounded-full">Pending</span>
                        <span class="text-xs text-slate-500">PRJ-003</span>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Instalasi CCTV Toko Retail</h3>
                    <p class="text-sm text-slate-500 mb-4">
                        <svg class="inline w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Jl. Raya Bogor No. 88
                    </p>
                    <div class="flex items-center text-sm text-slate-600 mb-4">
                        <div class="h-8 w-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 font-medium text-xs mr-2">?</div>
                        <span class="text-slate-400 italic">Belum ditugaskan</span>
                    </div>
                    <div class="flex items-center justify-between text-xs text-slate-500 pt-3 border-t border-slate-100">
                        <span>Template: Paket CCTV 8CH</span>
                        <span>12 item</span>
                    </div>
                </div>
                <div class="bg-slate-50 px-5 py-3 flex items-center justify-between">
                    <span class="text-xs text-slate-500">Dijadwalkan: 1 Feb 2026</span>
                    <a href="{{ route('projects.show', 3) }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Lihat Detail →</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
