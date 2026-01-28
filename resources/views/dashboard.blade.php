<x-app-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
        <p class="text-slate-500">Overview inventaris dan aktivitas terkini</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Barang -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Barang</p>
                    <p class="text-3xl font-bold text-slate-800 mt-1">{{ $stats['total_items'] }}</p>
                </div>
                <div class="h-12 w-12 rounded-xl flex items-center justify-center" style="background-color: #6eea8e33;">
                    <svg class="h-6 w-6 text-[#006600]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Stok Kritis -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Stok Kritis</p>
                    <p class="text-3xl font-bold text-amber-600 mt-1">{{ $stats['low_stock_items'] }}</p>
                </div>
                <div class="h-12 w-12 bg-amber-100 rounded-xl flex items-center justify-center">
                    <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Request Pending -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Request Pending</p>
                    <p class="text-3xl font-bold text-blue-600 mt-1">{{ $stats['pending_requests'] }}</p>
                </div>
                <div class="h-12 w-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Barang Keluar -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Sedang Keluar</p>
                    <p class="text-3xl font-bold text-green-600 mt-1">{{ $stats['checked_out_requests'] }}</p>
                </div>
                <div class="h-12 w-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Loss & Damage Summary -->
    @if($stats['total_damaged_this_month'] > 0 || $stats['total_lost_this_month'] > 0)
    <div class="bg-red-50 border border-red-200 rounded-2xl p-6 mb-8">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div class="ml-4 flex-1">
                <h3 class="text-lg font-semibold text-red-800">Kerugian Bulan Ini</h3>
                <div class="mt-2 flex gap-6">
                    <div>
                        <span class="text-2xl font-bold text-red-600">{{ $stats['total_damaged_this_month'] }}</span>
                        <span class="text-red-600 text-sm ml-1">unit rusak</span>
                    </div>
                    <div>
                        <span class="text-2xl font-bold text-red-600">{{ $stats['total_lost_this_month'] }}</span>
                        <span class="text-red-600 text-sm ml-1">unit hilang</span>
                    </div>
                </div>
            </div>
            <a href="{{ route('reports.loss-damage') }}" class="text-sm font-medium text-red-600 hover:text-red-800">
                Lihat Detail →
            </a>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Requests -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
            <div class="p-6 border-b border-slate-200 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-800">Request Terbaru</h2>
                <a href="{{ route('requests.index') }}" class="text-sm font-medium text-[#006600] hover:text-[#1c2a18]">Lihat Semua</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentRequests as $request)
                <a href="{{ route('requests.show', $request) }}" class="block p-4 hover:bg-slate-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-slate-800">{{ $request->project_name }}</p>
                            <p class="text-sm text-slate-500">{{ $request->technician_name }} • {{ $request->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="px-3 py-1 text-xs font-medium rounded-full 
                            @if($request->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($request->status === 'checked_out') bg-blue-100 text-blue-800
                            @elseif($request->status === 'returned') bg-purple-100 text-purple-800
                            @else bg-green-100 text-green-800
                            @endif">
                            {{ $request->status_label }}
                        </span>
                    </div>
                </a>
                @empty
                <div class="p-8 text-center text-slate-500">
                    <p>Belum ada request</p>
                    <a href="{{ route('requests.create') }}" class="mt-2 inline-block text-sm font-medium text-[#006600] hover:text-[#1c2a18]">
                        + Buat Request Baru
                    </a>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Low Stock Items -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
            <div class="p-6 border-b border-slate-200 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-800">Stok Menipis</h2>
                <a href="{{ route('items.index') }}?low_stock=1" class="text-sm font-medium text-[#006600] hover:text-[#1c2a18]">Lihat Semua</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($lowStockItems as $item)
                <div class="p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-slate-800">{{ $item->name }}</p>
                            <p class="text-sm text-slate-500">{{ $item->category->name ?? '-' }} • {{ $item->code }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold {{ $item->stock == 0 ? 'text-red-600' : 'text-amber-600' }}">{{ $item->stock }}</p>
                            <p class="text-xs text-slate-500">min: {{ $item->min_stock }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-slate-500">
                    <svg class="mx-auto h-12 w-12 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="mt-2">Semua stok mencukupi!</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 rounded-2xl p-6 text-white" style="background: linear-gradient(135deg, #006600 0%, #1c2a18 100%);">
        <h3 class="text-lg font-semibold mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('requests.create') }}" class="flex flex-col items-center p-4 bg-white/10 rounded-xl hover:bg-white/20 transition-colors">
                <svg class="h-8 w-8 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span class="text-sm font-medium">Request Barang</span>
            </a>
            <a href="{{ route('items.create') }}" class="flex flex-col items-center p-4 bg-white/10 rounded-xl hover:bg-white/20 transition-colors">
                <svg class="h-8 w-8 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <span class="text-sm font-medium">Tambah Barang</span>
            </a>
            <a href="{{ route('templates.create') }}" class="flex flex-col items-center p-4 bg-white/10 rounded-xl hover:bg-white/20 transition-colors">
                <svg class="h-8 w-8 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5z" />
                </svg>
                <span class="text-sm font-medium">Buat Template</span>
            </a>
            <a href="{{ route('reports.stock-movement') }}" class="flex flex-col items-center p-4 bg-white/10 rounded-xl hover:bg-white/20 transition-colors">
                <svg class="h-8 w-8 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="text-sm font-medium">Lihat Laporan</span>
            </a>
        </div>
    </div>
</x-app-layout>
