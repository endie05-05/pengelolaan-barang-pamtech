<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check-in - {{ $materialRequest->project_name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f0fdf4] min-h-screen">
    <div class="max-w-4xl mx-auto p-4">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('technician.projects.show', $materialRequest) }}" 
               class="flex items-center text-slate-600 hover:text-[#006600] transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="font-medium">Kembali</span>
            </a>
        </div>

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-800 mb-1">Check-in Selesai</h1>
            <p class="text-slate-600">{{ $materialRequest->project_name }}</p>
        </div>

        <form action="{{ route('requests.checkin', $materialRequest) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Info Banner -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h3 class="font-semibold text-blue-800 text-sm mb-1">Panduan Rekonsiliasi</h3>
                        <p class="text-xs text-blue-700">
                            Pastikan: <strong>Terpakai + Kembali + Rusak + Hilang = Qty Keluar</strong>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Items List -->
            <div class="space-y-3 mb-6">
                @foreach($materialRequest->items as $index => $reqItem)
                <div x-data="{ 
                    qtyOut: {{ $reqItem->qty_out }},
                    qtyUsed: {{ $reqItem->item->isTools() ? 0 : $reqItem->qty_out }},
                    qtyReturned: {{ $reqItem->item->isTools() ? $reqItem->qty_out : 0 }},
                    qtyDamaged: 0,
                    qtyLost: 0,
                    get total() { return this.qtyUsed + this.qtyReturned + this.qtyDamaged + this.qtyLost },
                    get isValid() { return this.total === this.qtyOut },
                    get remaining() { return this.qtyOut - this.total }
                }" 
                :class="{ 'ring-2 ring-red-400': !isValid }"
                class="bg-white rounded-xl shadow-sm border border-slate-200 p-3 transition-all">
                    
                    <input type="hidden" name="items[{{ $index }}][id]" value="{{ $reqItem->id }}">
                    
                    <!-- Main Horizontal Row -->
                    <div class="flex items-center gap-3 mb-2">
                        <!-- Item Info (30%) -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <div class="font-bold text-slate-800 text-sm truncate">{{ $reqItem->item->name }}</div>
                                <!-- QR Scanner Button -->
                                <button type="button" onclick="alert('Fitur scan QR akan segera hadir!')" 
                                        class="flex-shrink-0 p-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors"
                                        title="Scan QR/Barcode">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="text-xs text-slate-500 mt-0.5">
                                {{ $reqItem->item->code }}
                                @if($reqItem->item->isTools())
                                <span class="ml-1 px-1.5 py-0.5 bg-blue-100 text-blue-700 rounded text-xs">Alat</span>
                                @else
                                <span class="ml-1 px-1.5 py-0.5 bg-orange-100 text-orange-700 rounded text-xs">Barang</span>
                                @endif
                                • <span class="font-semibold">{{ $reqItem->qty_out }}</span>
                            </div>
                        </div>
                        
                        <!-- Terpakai -->
                        <div class="w-20">
                            <label class="block text-xs text-slate-600 mb-1 text-center">Terpakai</label>
                            <input type="number" 
                                   name="items[{{ $index }}][qty_used]" 
                                   x-model.number="qtyUsed"
                                   min="0" 
                                   :max="qtyOut" 
                                   required
                                   {{ $reqItem->item->isTools() ? 'readonly' : '' }}
                                   class="w-full px-2 py-2 text-center font-bold border-2 border-slate-300 rounded-lg focus:ring-2 focus:ring-[#006600] focus:border-[#006600]">
                        </div>
                        
                        <!-- Kembali -->
                        <div class="w-20">
                            <label class="block text-xs text-slate-600 mb-1 text-center">Kembali</label>
                            <input type="number" 
                                   name="items[{{ $index }}][qty_returned]" 
                                   x-model.number="qtyReturned"
                                   min="0" 
                                   :max="qtyOut" 
                                   required
                                   class="w-full px-2 py-2 text-center font-bold border-2 border-slate-300 rounded-lg focus:ring-2 focus:ring-[#006600] focus:border-[#006600]">
                        </div>
                        
                        <!-- Rusak -->
                        <div class="w-20">
                            <label class="block text-xs text-slate-600 mb-1 text-center">Rusak</label>
                            <input type="number" 
                                   name="items[{{ $index }}][qty_damaged]" 
                                   x-model.number="qtyDamaged"
                                   min="0" 
                                   :max="qtyOut" 
                                   required
                                   class="w-full px-2 py-2 text-center font-bold border-2 border-slate-300 rounded-lg focus:ring-2 focus:ring-[#006600] focus:border-[#006600]">
                        </div>
                        
                        <!-- Hilang -->
                        <div class="w-20">
                            <label class="block text-xs text-slate-600 mb-1 text-center">Hilang</label>
                            <input type="number" 
                                   name="items[{{ $index }}][qty_lost]" 
                                   x-model.number="qtyLost"
                                   min="0" 
                                   :max="qtyOut" 
                                   required
                                   class="w-full px-2 py-2 text-center font-bold border-2 border-slate-300 rounded-lg focus:ring-2 focus:ring-[#006600] focus:border-[#006600]">
                        </div>
                    </div>

                    <!-- Validation Alert -->
                    <div x-show="!isValid" class="mb-2 p-2 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center gap-2 text-red-700">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span class="text-xs font-semibold">
                                Selisih: <span x-text="remaining"></span> {{ $reqItem->item->unit }}
                            </span>
                        </div>
                    </div>

                    <!-- Notes & Photo (Collapsible) -->
                    <div class="space-y-2 pt-2 border-t border-slate-100">
                        <input type="text" 
                               name="items[{{ $index }}][notes]" 
                               placeholder="Catatan (opsional)..."
                               class="w-full px-3 py-1.5 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-[#006600] focus:border-[#006600]">
                        
                        <input type="file" 
                               name="items[{{ $index }}][photo]" 
                               accept="image/*"
                               class="w-full text-xs text-slate-600 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 file:cursor-pointer">
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full py-4 bg-[#006600] text-white font-bold rounded-xl hover:bg-[#005500] transition-all shadow-lg hover:shadow-xl text-lg">
                <svg class="w-5 h-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Selesaikan Check-in
            </button>
        </form>
    </div>
</body>
</html>
