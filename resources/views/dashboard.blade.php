<x-app-layout>
    <!-- Page Header with Mini Stats -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
            <p class="text-slate-500">Overview inventaris dan aktivitas terkini</p>
        </div>
        
        <!-- Mini Stats Badges -->
        <div class="flex flex-wrap items-center gap-2">
            <div class="flex items-center gap-1.5 px-3 py-1.5 bg-green-50 border border-green-200 rounded-full">
                <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <span class="text-sm font-semibold text-green-700">{{ $stats['total_items'] }}</span>
                <span class="text-xs text-green-600">Barang</span>
            </div>
            <div class="flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 border border-amber-200 rounded-full">
                <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span class="text-sm font-semibold text-amber-700">{{ $stats['low_stock_items'] }}</span>
                <span class="text-xs text-amber-600">Kritis</span>
            </div>
            <div class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 border border-blue-200 rounded-full">
                <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span class="text-sm font-semibold text-blue-700">{{ $stats['pending_requests'] }}</span>
                <span class="text-xs text-blue-600">Pending</span>
            </div>
            <div class="flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 border border-emerald-200 rounded-full">
                <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="text-sm font-semibold text-emerald-700">{{ $stats['checked_out_requests'] }}</span>
                <span class="text-xs text-emerald-600">Keluar</span>
            </div>
        </div>
    </div>

    <!-- Loss & Damage Alert (if any) -->
    @if($stats['total_damaged_this_month'] > 0 || $stats['total_lost_this_month'] > 0)
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-red-100 rounded-lg">
                    <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-red-800">Kerugian Bulan Ini</p>
                    <div class="flex gap-4 text-sm">
                        <span class="text-red-600"><strong>{{ $stats['total_damaged_this_month'] }}</strong> rusak</span>
                        <span class="text-red-600"><strong>{{ $stats['total_lost_this_month'] }}</strong> hilang</span>
                    </div>
                </div>
            </div>
            <a href="{{ route('reports.loss-damage') }}" class="text-sm font-medium text-red-600 hover:text-red-800">
                Detail →
            </a>
        </div>
    </div>
    @endif

    <!-- Low Stock Alert -->
    @if($stats['low_stock_items'] > 0)
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-amber-100 rounded-lg">
                    <svg class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-amber-800">Peringatan Stok Menipis</p>
                    <p class="text-sm text-amber-600">
                        <strong>{{ $stats['low_stock_items'] }}</strong> barang memiliki stok di bawah batas minimum
                    </p>
                </div>
            </div>
            <a href="{{ route('items.index') }}?low_stock=1" class="text-sm font-medium text-amber-600 hover:text-amber-800">
                Lihat Detail →
            </a>
        </div>
    </div>
    @endif

    <!-- Main Content: 2-Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Request/Project Aktif (2/3 width) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 h-full">
                <div class="p-4 border-b border-slate-200 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-green-100 rounded-lg">
                            <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <h2 class="font-semibold text-slate-800">Barang keluar / Proyek aktif</h2>
                    </div>
                    <a href="{{ route('requests.index') }}" class="text-sm font-medium text-[#006600] hover:text-[#1c2a18]">
                        Lihat Semua →
                    </a>
                </div>
                
                <div class="divide-y divide-slate-100 max-h-[400px] overflow-y-auto">
                    @forelse($activeRequests as $request)
                    <div x-data="{ open: false }" class="p-3 hover:bg-slate-50/50 transition-colors">
                        <!-- Request Header -->
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('requests.show', $request) }}" class="font-medium text-slate-800 hover:text-[#006600] truncate text-sm">
                                        {{ $request->project_name }}
                                    </a>
                                    <span class="flex-shrink-0 px-2 py-0.5 text-xs font-medium rounded-full 
                                        @if($request->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($request->status === 'checked_out') bg-blue-100 text-blue-800
                                        @elseif($request->status === 'returned') bg-purple-100 text-purple-800
                                        @else bg-green-100 text-green-800
                                        @endif">
                                        {{ $request->status_label }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    {{ $request->technician_name }} • {{ $request->created_at->diffForHumans() }}
                                    <span class="text-slate-400">• {{ $request->items->count() }} barang</span>
                                </p>
                            </div>
                            
                            <!-- Dropdown Toggle -->
                            <button @click="open = !open" 
                                    class="ml-3 p-1.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-all"
                                    :class="{ 'bg-slate-100 text-slate-600': open }">
                                <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Collapsible Items Panel -->
                        <div x-show="open" 
                             x-collapse
                             x-cloak
                             class="mt-3">
                            <div class="bg-slate-50 rounded-lg border border-slate-200 overflow-hidden">
                                @if($request->items->count() > 0)
                                <table class="w-full text-xs">
                                    <thead>
                                        <tr class="bg-slate-100 text-left">
                                            <th class="px-3 py-2 font-medium text-slate-600">Barang</th>
                                            <th class="px-3 py-2 font-medium text-slate-600 text-center">Req</th>
                                            <th class="px-3 py-2 font-medium text-slate-600 text-center">Out</th>
                                            <th class="px-3 py-2 font-medium text-slate-600">Kondisi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200 bg-white">
                                        @foreach($request->items as $reqItem)
                                        <tr class="hover:bg-slate-50">
                                            <td class="px-3 py-2">
                                                <div class="flex items-center gap-1.5">
                                                    @if($reqItem->item)
                                                        @if($reqItem->item->item_type === 'tools')
                                                            <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                                                        @else
                                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                                        @endif
                                                        <span class="font-medium text-slate-700">{{ Str::limit($reqItem->item->name, 25) }}</span>
                                                    @else
                                                        <span class="text-slate-400 italic">-</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-3 py-2 text-center font-medium text-slate-700">{{ $reqItem->qty_requested }}</td>
                                            <td class="px-3 py-2 text-center">
                                                @if($reqItem->qty_out)
                                                    <span class="font-medium text-slate-700">{{ $reqItem->qty_out }}</span>
                                                @else
                                                    <span class="text-slate-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-2">
                                                @if($reqItem->condition_out)
                                                    <span class="px-1.5 py-0.5 text-xs rounded 
                                                        @if($reqItem->condition_out === 'good') bg-green-100 text-green-700
                                                        @elseif($reqItem->condition_out === 'fair') bg-yellow-100 text-yellow-700
                                                        @else bg-red-100 text-red-700
                                                        @endif">
                                                        {{ ucfirst($reqItem->condition_out) }}
                                                    </span>
                                                @else
                                                    <span class="text-slate-400">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <div class="p-3 text-center text-slate-500 text-xs">
                                    Tidak ada barang
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-6 text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-slate-100 rounded-full mb-3">
                            <svg class="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <p class="text-slate-500 text-sm mb-2">Belum ada request</p>
                        <a href="{{ route('requests.create') }}" class="inline-flex items-center gap-1 text-sm font-medium text-[#006600] hover:text-[#1c2a18]">
                            + Buat Proyek Baru
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Riwayat Proyek (Completed) -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 mt-6">
                <div class="p-4 border-b border-slate-200 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-slate-100 rounded-lg">
                            <svg class="w-4 h-4 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="font-semibold text-slate-800">Riwayat Proyek</h2>
                    </div>
                    <a href="{{ route('requests.index') }}?status=closed" class="text-sm font-medium text-[#006600] hover:text-[#1c2a18]">
                        Lihat Semua →
                    </a>
                </div>
                
                <div class="divide-y divide-slate-100 max-h-[300px] overflow-y-auto">
                    @forelse($completedRequests as $request)
                    <div x-data="{ open: false }" class="p-3 hover:bg-slate-50/50 transition-colors">
                        <!-- Request Header -->
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('requests.show', $request) }}" class="font-medium text-slate-800 hover:text-[#006600] truncate text-sm">
                                        {{ $request->project_name }}
                                    </a>
                                    <span class="flex-shrink-0 px-2 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                        {{ $request->status_label }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    {{ $request->technician_name }} • Selesai {{ $request->updated_at->diffForHumans() }}
                                    <span class="text-slate-400">• {{ $request->items->count() }} barang</span>
                                </p>
                            </div>
                            
                            <!-- Dropdown Toggle -->
                            <button @click="open = !open" 
                                    class="ml-3 p-1.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-all"
                                    :class="{ 'bg-slate-100 text-slate-600': open }">
                                <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Collapsible Items Panel -->
                        <div x-show="open" 
                             x-collapse
                             x-cloak
                             class="mt-3">
                            <div class="bg-slate-50 rounded-lg border border-slate-200 overflow-hidden">
                                @if($request->items->count() > 0)
                                <table class="w-full text-xs">
                                    <thead>
                                        <tr class="bg-slate-100 text-left">
                                            <th class="px-3 py-2 font-medium text-slate-600">Barang</th>
                                            <th class="px-3 py-2 font-medium text-slate-600 text-center">Req</th>
                                            <th class="px-3 py-2 font-medium text-slate-600 text-center">Out</th>
                                            <th class="px-3 py-2 font-medium text-slate-600">Kondisi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200 bg-white">
                                        @foreach($request->items as $reqItem)
                                        <tr class="hover:bg-slate-50">
                                            <td class="px-3 py-2">
                                                <div class="flex items-center gap-1.5">
                                                    @if($reqItem->item)
                                                        @if($reqItem->item->item_type === 'tools')
                                                            <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                                                        @else
                                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                                        @endif
                                                        <span class="font-medium text-slate-700">{{ Str::limit($reqItem->item->name, 25) }}</span>
                                                    @else
                                                        <span class="text-slate-400 italic">-</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-3 py-2 text-center font-medium text-slate-700">{{ $reqItem->qty_requested }}</td>
                                            <td class="px-3 py-2 text-center">
                                                @if($reqItem->qty_out)
                                                    <span class="font-medium text-slate-700">{{ $reqItem->qty_out }}</span>
                                                @else
                                                    <span class="text-slate-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-2">
                                                @if($reqItem->condition_out)
                                                    <span class="px-1.5 py-0.5 text-xs rounded 
                                                        @if($reqItem->condition_out === 'good') bg-green-100 text-green-700
                                                        @elseif($reqItem->condition_out === 'fair') bg-yellow-100 text-yellow-700
                                                        @else bg-red-100 text-red-700
                                                        @endif">
                                                        {{ ucfirst($reqItem->condition_out) }}
                                                    </span>
                                                @else
                                                    <span class="text-slate-400">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <div class="p-3 text-center text-slate-500 text-xs">
                                    Tidak ada barang
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-6 text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-slate-100 rounded-full mb-3">
                            <svg class="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-slate-500 text-sm">Belum ada proyek selesai</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column: Stok Menipis + Aksi Cepat -->
        <div class="lg:col-span-1 space-y-4">
            <!-- Stok Menipis (Compact) -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200">
                <div class="p-3 border-b border-slate-200 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-amber-100 rounded-lg">
                            <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h2 class="font-semibold text-slate-800 text-sm">Stok Menipis</h2>
                    </div>
                    <a href="{{ route('items.index') }}?low_stock=1" class="text-xs font-medium text-[#006600] hover:text-[#1c2a18]">
                        Semua →
                    </a>
                </div>
                
                @if($lowStockItems->count() > 0)
                <div class="divide-y divide-slate-100 max-h-[200px] overflow-y-auto">
                    @foreach($lowStockItems as $item)
                    <div class="p-3 flex items-center justify-between hover:bg-slate-50">
                        <div class="min-w-0 flex-1">
                            <p class="font-medium text-slate-800 text-sm truncate">{{ $item->name }}</p>
                            <p class="text-xs text-slate-500">{{ $item->category->name ?? '-' }}</p>
                        </div>
                        <div class="ml-3 text-right">
                            <span class="text-lg font-bold {{ $item->stock == 0 ? 'text-red-600' : 'text-amber-600' }}">
                                {{ $item->stock }}
                            </span>
                            <p class="text-xs text-slate-400">min: {{ $item->min_stock }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="p-4 text-center">
                    <div class="inline-flex items-center justify-center w-10 h-10 bg-green-100 rounded-full mb-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-slate-500 text-sm">Semua stok mencukupi!</p>
                </div>
                @endif
            </div>

            <!-- Aksi Cepat (Below Stok Menipis) -->
            <div class="bg-slate-50 rounded-xl border border-slate-200 p-3">
                <p class="text-xs font-medium text-slate-500 mb-2">Aksi Cepat</p>
                <div class="grid grid-cols-2 gap-2">
                    <a href="{{ route('requests.create') }}" class="flex items-center gap-2 px-3 py-2 bg-[#006600] text-white text-xs font-medium rounded-lg hover:bg-[#005500] transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Proyek Baru
                    </a>
                    <a href="{{ route('items.create') }}" class="flex items-center gap-2 px-3 py-2 bg-white text-slate-700 text-xs font-medium rounded-lg border border-slate-200 hover:bg-slate-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        Barang
                    </a>
                    <a href="{{ route('templates.create') }}" class="flex items-center gap-2 px-3 py-2 bg-white text-slate-700 text-xs font-medium rounded-lg border border-slate-200 hover:bg-slate-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5z" />
                        </svg>
                        Template
                    </a>
                    <a href="{{ route('reports.index') }}" class="flex items-center gap-2 px-3 py-2 bg-white text-slate-700 text-xs font-medium rounded-lg border border-slate-200 hover:bg-slate-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
