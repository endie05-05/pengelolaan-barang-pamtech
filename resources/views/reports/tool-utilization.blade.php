<x-app-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Penggunaan Alat</h1>
        <p class="text-slate-500">Frekuensi penggunaan tools/alat kerja</p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 mb-6">
        <form action="{{ route('reports.tool-utilization') }}" method="GET" class="flex flex-wrap gap-4">
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                    class="px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                    class="px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500">
            </div>
            <div class="flex items-end gap-3">
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                    Filter
                </button>
                <a href="{{ route('reports.tool-utilization.pdf', request()->all()) }}" target="_blank" class="px-6 py-2 bg-red-600 text-white font-medium rounded-xl hover:bg-red-700 transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export PDF
                </a>
            </div>
        </form>
    </div>

    <!-- Tools Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($tools as $tool)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="font-semibold text-slate-800">{{ $tool->name }}</h3>
                    <p class="text-sm text-slate-500">{{ $tool->code }}</p>
                </div>
                <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs font-medium rounded-lg">
                    {{ $tool->item_type_label }}
                </span>
            </div>
            
            <div class="flex items-end justify-between">
                <div>
                    <p class="text-sm text-slate-500">Penggunaan</p>
                    <p class="text-3xl font-bold text-indigo-600">{{ $tool->usage_count }}</p>
                    <p class="text-xs text-slate-400">kali dipinjam</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-slate-500">Stok</p>
                    <p class="text-xl font-bold {{ $tool->stock <= $tool->min_stock ? 'text-red-600' : 'text-slate-800' }}">
                        {{ $tool->stock }}
                    </p>
                </div>
            </div>

            @if($tool->usage_count > 10)
            <div class="mt-4 p-3 bg-amber-50 rounded-xl border border-amber-200">
                <p class="text-sm text-amber-800">
                    <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Alat sering digunakan, pertimbangkan penambahan unit.
                </p>
            </div>
            @endif
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
            </svg>
            <p class="mt-4 text-slate-500">Tidak ada data alat dengan tipe "tools"</p>
            <p class="text-sm text-slate-400">Pastikan ada barang dengan item_type = "tools" di database</p>
        </div>
        @endforelse
    </div>

    @if($tools->hasPages())
    <div class="mt-6">
        {{ $tools->links() }}
    </div>
    @endif
</x-app-layout>
