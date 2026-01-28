<x-app-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm text-slate-500">
                <li><a href="{{ route('requests.index') }}" class="hover:text-indigo-600">Request Barang</a></li>
                <li><span>/</span></li>
                <li><a href="{{ route('requests.show', $materialRequest) }}" class="hover:text-indigo-600">{{ $materialRequest->project_name }}</a></li>
                <li><span>/</span></li>
                <li class="text-slate-800 font-medium">Check-in</li>
            </ol>
        </nav>
        <h1 class="text-2xl font-bold text-slate-800">Check-in / Rekonsiliasi</h1>
        <p class="text-slate-500">Catat pengembalian barang dari proyek {{ $materialRequest->project_name }}</p>
    </div>

    <form action="{{ route('requests.checkin', $materialRequest) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
            <div class="p-6 border-b border-slate-200 bg-blue-50">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-blue-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="ml-3">
                        <h3 class="font-semibold text-blue-800">Panduan Rekonsiliasi</h3>
                        <p class="text-sm text-blue-600 mt-1">
                            Pastikan jumlah <strong>Terpakai + Kembali + Rusak + Hilang = Qty Keluar</strong> untuk setiap barang.
                            Jika ada selisih atau barang rusak/hilang, disarankan upload foto bukti.
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
                            <th class="text-left px-6 py-3 text-sm font-semibold text-slate-600">Catatan/Foto</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100" x-data="checkinForm()">
                        @foreach($materialRequest->items as $index => $reqItem)
                        <tr x-data="{ 
                            qtyOut: {{ $reqItem->qty_out }},
                            qtyUsed: 0,
                            qtyReturned: {{ $reqItem->item->isTools() ? $reqItem->qty_out : 0 }},
                            qtyDamaged: 0,
                            qtyLost: 0,
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
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-center focus:ring-2 focus:ring-indigo-500"
                                    {{ $reqItem->item->isTools() ? 'readonly' : '' }}>
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
                                <div class="space-y-2">
                                    <input type="text" name="items[{{ $index }}][notes]" placeholder="Catatan..."
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                                    <input type="file" name="items[{{ $index }}][photo]" accept="image/*"
                                        class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                                </div>
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
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Selesaikan Check-in
                </button>
            </div>
        </div>
    </form>

    <script>
        function checkinForm() {
            return {
                // Global form validation if needed
            }
        }
    </script>
</x-app-layout>
