<x-app-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm text-slate-500">
                <li><a href="{{ route('requests.index') }}" class="hover:text-indigo-600">Barang Keluar</a></li>
                <li><span>/</span></li>
                <li><a href="{{ route('requests.show', $materialRequest) }}" class="hover:text-indigo-600">{{ $materialRequest->project_name }}</a></li>
                <li><span>/</span></li>
                <li class="text-slate-800 font-medium">Edit Rekonsiliasi</li>
            </ol>
        </nav>
        <h1 class="text-2xl font-bold text-slate-800">Edit Rekonsiliasi</h1>
        <p class="text-slate-500">Ubah data pengembalian barang dari proyek {{ $materialRequest->project_name }}</p>
    </div>

    <form action="{{ route('requests.update-reconciliation', $materialRequest) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
            <div class="p-6 border-b border-slate-200 bg-amber-50">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-amber-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div class="ml-3">
                        <h3 class="font-semibold text-amber-800">Mode Edit Rekonsiliasi</h3>
                        <p class="text-sm text-amber-600 mt-1">
                            Anda sedang mengedit data rekonsiliasi yang sudah selesai. Perubahan akan mempengaruhi stok gudang.
                        </p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="text-left px-6 py-3 text-sm font-semibold text-slate-600">Barang</th>
                            <th class="text-center px-6 py-3 text-sm font-semibold text-slate-600 w-20">Keluar</th>
                            <th class="text-center px-6 py-3 text-sm font-semibold text-slate-600 w-24">Terpakai</th>
                            <th class="text-center px-6 py-3 text-sm font-semibold text-slate-600 w-24">Kembali</th>
                            <th class="text-center px-6 py-3 text-sm font-semibold text-slate-600 w-20">Rusak</th>
                            <th class="text-center px-6 py-3 text-sm font-semibold text-slate-600 w-20">Hilang</th>
                            <th class="text-left px-6 py-3 text-sm font-semibold text-slate-600">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($materialRequest->items as $index => $reqItem)
                        <tr x-data="{ 
                            qtyOut: {{ $reqItem->qty_out }},
                            qtyUsed: {{ $reqItem->qty_used ?? 0 }},
                            qtyReturned: {{ $reqItem->qty_returned ?? 0 }},
                            qtyDamaged: {{ $reqItem->qty_damaged ?? 0 }},
                            qtyLost: {{ $reqItem->qty_lost ?? 0 }},
                            get total() { return this.qtyUsed + this.qtyReturned + this.qtyDamaged + this.qtyLost },
                            get isValid() { return this.total === this.qtyOut },
                            get hasIssue() { return this.qtyDamaged > 0 || this.qtyLost > 0 }
                        }" :class="{ 'bg-red-50': !isValid, 'bg-yellow-50': hasIssue && isValid }">
                            <input type="hidden" name="items[{{ $index }}][id]" value="{{ $reqItem->id }}">
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-800">{{ $reqItem->item->name }}</div>
                                <div class="text-sm text-slate-500">
                                    {{ $reqItem->item->code }} 
                                    @if($reqItem->item->isTools())
                                    <span class="ml-1 px-2 py-0.5 bg-purple-100 text-purple-700 rounded text-xs">Alat</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="font-bold text-slate-800">{{ $reqItem->qty_out }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <input type="number" name="items[{{ $index }}][qty_used]" x-model.number="qtyUsed"
                                    min="0" :max="qtyOut" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-center focus:ring-2 focus:ring-indigo-500">
                            </td>
                            <td class="px-6 py-4">
                                <input type="number" name="items[{{ $index }}][qty_returned]" x-model.number="qtyReturned"
                                    min="0" :max="qtyOut" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-center focus:ring-2 focus:ring-indigo-500">
                            </td>
                            <td class="px-6 py-4">
                                <input type="number" name="items[{{ $index }}][qty_damaged]" x-model.number="qtyDamaged"
                                    min="0" :max="qtyOut" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-center focus:ring-2 focus:ring-indigo-500">
                            </td>
                            <td class="px-6 py-4">
                                <input type="number" name="items[{{ $index }}][qty_lost]" x-model.number="qtyLost"
                                    min="0" :max="qtyOut" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-center focus:ring-2 focus:ring-indigo-500">
                            </td>
                            <td class="px-6 py-4">
                                <input type="text" name="items[{{ $index }}][notes]" value="{{ $reqItem->notes }}" placeholder="Catatan..."
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                                <!-- Validation Message -->
                                <div x-show="!isValid" class="mt-2 text-xs text-red-600">
                                    <span x-text="'Selisih: ' + (qtyOut - total)"></span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-6 border-t border-slate-200 flex items-center justify-between">
                <a href="{{ route('requests.show', $materialRequest) }}" class="text-slate-600 hover:text-slate-800">
                    ← Kembali
                </a>
                <button type="submit" class="px-6 py-3 bg-amber-600 text-white font-medium rounded-xl hover:bg-amber-700 transition-colors">
                    <svg class="w-5 h-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</x-app-layout>
