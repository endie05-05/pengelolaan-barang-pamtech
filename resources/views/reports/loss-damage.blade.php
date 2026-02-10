<x-app-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Laporan Kerusakan & Kehilangan</h1>
        <p class="text-slate-500">Data barang rusak atau hilang selama periode tertentu</p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 mb-6">
        <form action="{{ route('reports.loss-damage') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                    class="px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                    class="px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Tipe</label>
                <select name="type" class="px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Semua</option>
                    <option value="damaged" {{ request('type') == 'damaged' ? 'selected' : '' }}>Rusak</option>
                    <option value="lost" {{ request('type') == 'lost' ? 'selected' : '' }}>Hilang</option>
                </select>
            </div>
            <div class="flex items-end gap-3">
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                    Filter
                </button>
                <a href="{{ route('reports.loss-damage.pdf', request()->all()) }}" target="_blank" class="px-6 py-2 bg-red-600 text-white font-medium rounded-xl hover:bg-red-700 transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export PDF
                </a>
            </div>
        </form>
    </div>

    <!-- Summary -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        <div class="bg-red-50 border border-red-200 rounded-2xl p-6">
            <div class="flex items-center">
                <div class="h-12 w-12 bg-red-100 rounded-xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-red-600">Total Rusak</p>
                    <p class="text-3xl font-bold text-red-800">{{ $summary['total_damaged'] }} <span class="text-lg font-normal">unit</span></p>
                </div>
            </div>
        </div>
        <div class="bg-slate-800 rounded-2xl p-6">
            <div class="flex items-center">
                <div class="h-12 w-12 bg-slate-700 rounded-xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-400">Total Hilang</p>
                    <p class="text-3xl font-bold text-white">{{ $summary['total_lost'] }} <span class="text-lg font-normal text-slate-400">unit</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Barang Stok Habis Pakai (Consumables) -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
            <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            Barang Habis Pakai (Consumables)
        </h2>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">Tanggal</th>
                            <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">Barang</th>
                            <th class="text-center px-6 py-4 text-sm font-semibold text-slate-600">Tipe</th>
                            <th class="text-center px-6 py-4 text-sm font-semibold text-slate-600">Jumlah</th>
                            <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">Alasan</th>
                            <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">Oleh</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($consumableMutations as $mutation)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-slate-600">{{ $mutation->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-800">{{ $mutation->item->name }}</div>
                                <div class="text-sm text-slate-500">{{ $mutation->item->code }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $mutation->type === 'damaged' ? 'bg-red-100 text-red-800' : 'bg-slate-800 text-white' }}">
                                    {{ $mutation->type_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-slate-800">{{ $mutation->qty }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $mutation->reason ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $mutation->creator->name ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <p class="text-slate-500">Tidak ada data kerusakan/kehilangan untuk consumables.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($consumableMutations->hasPages())
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $consumableMutations->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Section: Tools & Equipment -->
    <div>
        <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
            <svg class="w-6 h-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Alat & Inventaris (Tools & Equipment)
        </h2>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">Tanggal</th>
                            <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">Barang</th>
                            <th class="text-center px-6 py-4 text-sm font-semibold text-slate-600">Tipe</th>
                            <th class="text-center px-6 py-4 text-sm font-semibold text-slate-600">Jumlah</th>
                            <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">Alasan</th>
                            <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">Oleh</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($toolMutations as $mutation)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-slate-600">{{ $mutation->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-800">{{ $mutation->item->name }}</div>
                                <div class="text-sm text-slate-500">{{ $mutation->item->code }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $mutation->type === 'damaged' ? 'bg-red-100 text-red-800' : 'bg-slate-800 text-white' }}">
                                    {{ $mutation->type_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-slate-800">{{ $mutation->qty }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $mutation->reason ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $mutation->creator->name ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <p class="text-slate-500">Tidak ada data kerusakan/kehilangan untuk tools.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($toolMutations->hasPages())
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $toolMutations->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
