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
            <div class="flex items-end">
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                    Filter
                </button>
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

    <!-- Table -->
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
                    @forelse($mutations as $mutation)
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
                            <svg class="mx-auto h-12 w-12 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="mt-4 text-slate-500">Tidak ada data kerusakan/kehilangan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($mutations->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $mutations->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
