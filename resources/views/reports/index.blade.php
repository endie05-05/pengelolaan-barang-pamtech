<x-app-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Laporan</h1>
        <p class="text-slate-500">Pusat data pelaporan inventaris dan penggunaan</p>
    </div>

    <div x-data="{ activeTab: '{{ $activeTab }}' }">
        
        <!-- Tab Navigation -->
        <div class="mb-6 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <nav class="flex space-x-8" aria-label="Tabs">
                    <button 
                        @click="activeTab = 'loss_damage'" 
                        :class="activeTab === 'loss_damage' ? 'border-[#006600] text-[#006600]' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                        Kerusakan & Kehilangan
                    </button>
                    <button 
                        @click="activeTab = 'stock_movement'" 
                        :class="activeTab === 'stock_movement' ? 'border-[#006600] text-[#006600]' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                        Mutasi Stok
                    </button>
                    <button 
                        @click="activeTab = 'tool_utilization'" 
                        :class="activeTab === 'tool_utilization' ? 'border-[#006600] text-[#006600]' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                        Penggunaan Alat
                    </button>
                </nav>
                
                <!-- Export PDF Button -->
                <a href="{{ route('reports.pdf.unified') }}" target="_blank" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-[#006600] text-white text-sm font-medium rounded-xl hover:bg-[#005500] transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export PDF
                </a>
            </div>
        </div>

        <!-- Tab 1: Loss & Damage -->
        <div x-show="activeTab === 'loss_damage'" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0 translate-y-2" 
             x-transition:enter-end="opacity-100 translate-y-0"
             @if($activeTab !== 'loss_damage') style="display: none;" @endif>
            <!-- Filters -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 mb-6">
                <!-- ... content ... -->
            <!-- (Keeping the content same, just updating the wrapper div attributes) -->
            <!-- ... -->
                <form action="{{ route('reports.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                    <input type="hidden" name="tab" value="loss_damage">
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#006600] focus:border-[#006600]">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#006600] focus:border-[#006600]">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Tipe</label>
                        <select name="type" class="px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#006600] focus:border-[#006600]">
                            <option value="">Semua</option>
                            <option value="damaged" {{ request('type') == 'damaged' ? 'selected' : '' }}>Rusak</option>
                            <option value="lost" {{ request('type') == 'lost' ? 'selected' : '' }}>Hilang</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-3">
                        <button type="submit" class="px-6 py-2 bg-[#006600] text-white font-medium rounded-xl hover:bg-[#005500] transition-colors">
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
                            <p class="text-3xl font-bold text-red-800">{{ $lossSummary['total_damaged'] }} <span class="text-lg font-normal">unit</span></p>
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
                            <p class="text-3xl font-bold text-white">{{ $lossSummary['total_lost'] }} <span class="text-lg font-normal text-slate-400">unit</span></p>
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
                            @forelse($lossMutations as $mutation)
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
                                    <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="mt-4 text-slate-500">Tidak ada data kerusakan/kehilangan</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($lossMutations->hasPages())
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $lossMutations->appends(['tab' => 'loss_damage'])->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- Tab 2: Stock Movement -->
        <div x-show="activeTab === 'stock_movement'" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0 translate-y-2" 
             x-transition:enter-end="opacity-100 translate-y-0"
             @if($activeTab !== 'stock_movement') style="display: none;" @endif>
             <!-- ... content ... -->

            <!-- Filters -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 mb-6">
                <form action="{{ route('reports.index') }}" method="GET" class="flex flex-wrap gap-4">
                    <input type="hidden" name="tab" value="stock_movement">
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#006600] focus:border-[#006600]">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#006600] focus:border-[#006600]">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Barang</label>
                        <select name="item_id" class="px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#006600] focus:border-[#006600]">
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
                        <select name="type" class="px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#006600] focus:border-[#006600]">
                            <option value="">Semua</option>
                            <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Masuk</option>
                            <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Keluar</option>
                            <option value="adjust" {{ request('type') == 'adjust' ? 'selected' : '' }}>Penyesuaian</option>
                            <option value="damaged" {{ request('type') == 'damaged' ? 'selected' : '' }}>Rusak</option>
                            <option value="lost" {{ request('type') == 'lost' ? 'selected' : '' }}>Hilang</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-3">
                        <button type="submit" class="px-6 py-2 bg-[#006600] text-white font-medium rounded-xl hover:bg-[#005500] transition-colors">
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
                            @forelse($stockMutations as $mutation)
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

                @if($stockMutations->hasPages())
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $stockMutations->appends(['tab' => 'stock_movement'])->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- Tab 3: Tool Utilization -->
        <div x-show="activeTab === 'tool_utilization'" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0 translate-y-2" 
             x-transition:enter-end="opacity-100 translate-y-0"
             @if($activeTab !== 'tool_utilization') style="display: none;" @endif>
            <!-- Filters -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 mb-6">
                <form action="{{ route('reports.index') }}" method="GET" class="flex flex-wrap gap-4">
                    <input type="hidden" name="tab" value="tool_utilization">
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#006600] focus:border-[#006600]">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#006600] focus:border-[#006600]">
                    </div>
                    <div class="flex items-end gap-3">
                        <button type="submit" class="px-6 py-2 bg-[#006600] text-white font-medium rounded-xl hover:bg-[#005500] transition-colors">
                            Filter
                        </button>
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
                            <p class="text-3xl font-bold text-[#006600]">{{ $tool->usage_count }}</p>
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
                            Alat sering digunakan.
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
                </div>
                @endforelse
            </div>

            @if($tools->hasPages())
            <div class="mt-6 rounded-2xl bg-white p-4 boorder border-slate-200">
                {{ $tools->appends(['tab' => 'tool_utilization'])->links() }}
            </div>
            @endif
        </div>

    </div>
</x-app-layout>
