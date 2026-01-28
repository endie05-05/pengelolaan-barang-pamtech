<x-app-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Mutasi Stok</h1>
        <p class="text-slate-500">Riwayat semua pergerakan stok barang</p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 mb-6">
        <form action="{{ route('reports.stock-movement') }}" method="GET" class="flex flex-wrap gap-4">
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
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Barang</label>
                <select name="item_id" class="px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500">
                    <option value="">Semua Barang</option>
                    @foreach($items as $item)
                    <option value="{{ $item->id }}" {{ request('item_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Tipe</label>
                <select name="type" class="px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500">
                    <option value="">Semua</option>
                    <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Masuk</option>
                    <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Keluar</option>
                    <option value="adjust" {{ request('type') == 'adjust' ? 'selected' : '' }}>Penyesuaian</option>
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

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">Tanggal</th>
                        <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">Barang</th>
                        <th class="text-center px-6 py-4 text-sm font-semibold text-slate-600">Tipe</th>
                        <th class="text-center px-6 py-4 text-sm font-semibold text-slate-600">Qty</th>
                        <th class="text-center px-6 py-4 text-sm font-semibold text-slate-600">Sebelum</th>
                        <th class="text-center px-6 py-4 text-sm font-semibold text-slate-600">Sesudah</th>
                        <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">Keterangan</th>
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
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-{{ $mutation->type_badge }}-100 text-{{ $mutation->type_badge }}-800">
                                {{ $mutation->type_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="{{ in_array($mutation->type, ['in']) ? 'text-green-600' : 'text-red-600' }} font-bold">
                                {{ in_array($mutation->type, ['in']) ? '+' : '-' }}{{ $mutation->qty }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center text-slate-600">{{ $mutation->stock_before }}</td>
                        <td class="px-6 py-4 text-center font-medium text-slate-800">{{ $mutation->stock_after }}</td>
                        <td class="px-6 py-4 text-slate-600 max-w-xs truncate">{{ $mutation->reason ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                            Tidak ada data mutasi stok
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
