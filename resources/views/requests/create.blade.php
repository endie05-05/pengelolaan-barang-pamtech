<x-app-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm text-slate-500">
                <li><a href="{{ route('requests.index') }}" class="hover:text-indigo-600">Request Barang</a></li>
                <li><span>/</span></li>
                <li class="text-slate-800 font-medium">Buat Request</li>
            </ol>
        </nav>
        <h1 class="text-2xl font-bold text-slate-800">Buat Request Barang</h1>
        <p class="text-slate-500">Ajukan permintaan pengambilan barang dari gudang</p>
    </div>

    <form action="{{ route('requests.store') }}" method="POST" x-data="requestForm()" class="space-y-6">
        @csrf

        <!-- Project Info -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-4">Informasi Proyek</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Template Selection -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Template (Opsional)</label>
                    <select name="template_id" x-model="selectedTemplate" @change="loadTemplateItems()" 
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">-- Pilih Template atau Input Manual --</option>
                        @foreach($templates as $template)
                        <option value="{{ $template->id }}">{{ $template->name }} ({{ $template->items->count() }} item)</option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-sm text-slate-500">Pilih template untuk auto-fill daftar barang standar</p>
                </div>

                <!-- Project Name -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Proyek <span class="text-red-500">*</span></label>
                    <input type="text" name="project_name" value="{{ old('project_name') }}" required
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Contoh: Instalasi CCTV Rumah Pak Budi">
                    @error('project_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Technician Name -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Teknisi <span class="text-red-500">*</span></label>
                    <input type="text" name="technician_name" value="{{ old('technician_name') }}" required
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Nama teknisi yang akan mengambil barang">
                    @error('technician_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Lokasi</label>
                    <input type="text" name="location" value="{{ old('location') }}"
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Alamat lokasi proyek">
                </div>

                <!-- Departure Date -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Berangkat</label>
                    <input type="date" name="departure_date" value="{{ old('departure_date') }}"
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Notes -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Catatan</label>
                    <textarea name="notes" rows="2"
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Items List -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-slate-800">Daftar Barang</h2>
                <button type="button" @click="showItemPicker = true" 
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Pilih Barang
                </button>
            </div>

            <!-- Selected Items Table -->
            <div class="overflow-x-auto" x-show="items.length > 0">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="text-left px-4 py-3 text-sm font-semibold text-slate-600">Barang</th>
                            <th class="text-left px-4 py-3 text-sm font-semibold text-slate-600 w-24">Stok</th>
                            <th class="text-left px-4 py-3 text-sm font-semibold text-slate-600 w-32">Qty Diminta</th>
                            <th class="text-center px-4 py-3 text-sm font-semibold text-slate-600 w-16"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <template x-for="(item, index) in items" :key="index">
                            <tr>
                                <td class="px-4 py-3">
                                    <input type="hidden" :name="'items[' + index + '][item_id]'" x-model="item.item_id">
                                    <div class="font-medium text-slate-800" x-text="item.name || 'Belum dipilih'"></div>
                                    <div class="text-sm text-slate-500" x-text="item.code || '-'"></div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="text-slate-600" x-text="item.stock || '-'"></span>
                                    <span class="text-slate-400 text-sm" x-text="item.unit ? ' ' + item.unit : ''"></span>
                                </td>
                                <td class="px-4 py-3">
                                    <input type="number" x-model="item.qty_requested" :name="'items[' + index + '][qty_requested]'" 
                                        min="1" :max="item.stock" required
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <button type="button" @click="removeItem(index)"
                                        class="p-1 text-red-400 hover:text-red-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div x-show="items.length === 0" class="py-8 text-center text-slate-500">
                <svg class="mx-auto h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <p>Belum ada barang dipilih.</p>
                <button type="button" @click="showItemPicker = true" class="mt-2 text-indigo-600 hover:text-indigo-800 font-medium">
                    + Pilih Barang
                </button>
            </div>
        </div>

        <!-- Submit -->
        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('requests.index') }}" class="px-6 py-3 text-slate-600 font-medium hover:text-slate-800 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                Simpan Request
            </button>
        </div>

        <!-- Item Picker Modal -->
        <div x-show="showItemPicker" x-cloak
            class="fixed inset-0 z-50 overflow-y-auto" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/50" @click="showItemPicker = false"></div>
            
            <!-- Modal Content -->
            <div class="relative min-h-screen flex items-center justify-center p-4">
                <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[85vh] overflow-hidden"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95">
                    
                    <!-- Header -->
                    <div class="sticky top-0 bg-white border-b border-slate-200 px-6 py-4 z-10">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-slate-800">Pilih Barang</h3>
                            <button type="button" @click="showItemPicker = false" class="p-2 text-slate-400 hover:text-slate-600 transition-colors">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Search -->
                        <div class="mt-4">
                            <input type="text" x-model="searchQuery" placeholder="Cari barang berdasarkan nama atau kode..."
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                    
                    <!-- Items List -->
                    <div class="overflow-y-auto p-6" style="max-height: calc(85vh - 140px);">
                        <template x-for="category in groupedItems" :key="category.name">
                            <div class="mb-6" x-show="category.items.length > 0">
                                <!-- Category Header -->
                                <div class="sticky top-0 bg-slate-100 px-4 py-2 rounded-lg mb-3">
                                    <h4 class="font-semibold text-slate-700" x-text="category.name"></h4>
                                </div>
                                
                                <!-- Category Items -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <template x-for="item in category.items" :key="item.id">
                                        <div class="p-4 border rounded-xl transition-all"
                                            :class="isItemSelected(item.id) 
                                                ? 'border-indigo-500 bg-indigo-50 ring-2 ring-indigo-500' 
                                                : 'border-slate-200 hover:border-indigo-300 hover:bg-slate-50'">
                                            
                                            <!-- Item Info Row -->
                                            <div class="flex items-start justify-between cursor-pointer" @click="toggleItem(item)">
                                                <div class="flex-1">
                                                    <div class="font-medium text-slate-800" x-text="item.name"></div>
                                                    <div class="text-sm text-slate-500 mt-1">
                                                        <span x-text="item.code"></span>
                                                    </div>
                                                    <div class="text-sm text-slate-500">
                                                        Stok: <span class="font-medium" x-text="item.stock"></span> <span x-text="item.unit"></span>
                                                    </div>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center transition-colors"
                                                        :class="isItemSelected(item.id) ? 'border-indigo-500 bg-indigo-500' : 'border-slate-300'">
                                                        <svg x-show="isItemSelected(item.id)" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Quantity Input (shown when selected) -->
                                            <div x-show="isItemSelected(item.id)" x-cloak class="mt-3 pt-3 border-t border-indigo-200">
                                                <div class="flex items-center gap-3">
                                                    <label class="text-sm font-medium text-slate-700">Jumlah:</label>
                                                    <input type="number" 
                                                        :value="getItemQty(item.id)"
                                                        @input="updateItemQty(item.id, $event.target.value)"
                                                        @click.stop
                                                        min="1" 
                                                        :max="item.stock"
                                                        class="w-24 px-3 py-1.5 text-center border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                    <span class="text-sm text-slate-500" x-text="item.unit"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                        
                        <!-- No Results -->
                        <div x-show="filteredAvailableItems.length === 0" class="py-12 text-center text-slate-500">
                            <svg class="mx-auto h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <p>Tidak ada barang ditemukan</p>
                        </div>
                    </div>
                    
                    <!-- Footer -->
                    <div class="sticky bottom-0 bg-white border-t border-slate-200 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-slate-600">
                                <span x-text="items.length"></span> barang dipilih
                            </div>
                            <button type="button" @click="showItemPicker = false"
                                class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                                Selesai
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@php
    $initialItems = [];
    if($selectedTemplate) {
        $initialItems = $selectedTemplate->items->map(function($ti) {
            return [
                'item_id' => (string) $ti->item_id,
                'name' => $ti->item->name,
                'code' => $ti->item->code,
                'qty_requested' => $ti->default_qty,
                'stock' => $ti->item->stock,
                'unit' => $ti->item->unit
            ];
        })->toArray();
    }
    
    // Group items by category
    $itemsByCategory = $items->groupBy(function($item) {
        return $item->category->name ?? 'Lainnya';
    })->sortKeys();
    
    // Prepare items for JavaScript
    $availableItemsJson = $items->map(function($item) {
        return [
            'id' => $item->id,
            'name' => $item->name,
            'code' => $item->code,
            'stock' => $item->stock,
            'unit' => $item->unit,
            'category' => $item->category->name ?? 'Lainnya'
        ];
    })->values()->toArray();
@endphp

    <script>
        // Available items data with category info
        const availableItems = @json($availableItemsJson);

        function requestForm() {
            return {
                selectedTemplate: '{{ $selectedTemplate?->id ?? '' }}',
                items: @json($initialItems),
                showItemPicker: false,
                searchQuery: '',
                
                get filteredAvailableItems() {
                    if (this.searchQuery === '') return availableItems;
                    const query = this.searchQuery.toLowerCase();
                    return availableItems.filter(item => 
                        item.name.toLowerCase().includes(query) || 
                        item.code.toLowerCase().includes(query)
                    );
                },
                
                get groupedItems() {
                    const filtered = this.filteredAvailableItems;
                    const groups = {};
                    
                    filtered.forEach(item => {
                        const cat = item.category || 'Lainnya';
                        if (!groups[cat]) {
                            groups[cat] = { name: cat, items: [] };
                        }
                        groups[cat].items.push(item);
                    });
                    
                    // Sort by category name and return as array
                    return Object.values(groups).sort((a, b) => a.name.localeCompare(b.name));
                },
                
                isItemSelected(itemId) {
                    return this.items.some(i => i.item_id == itemId);
                },
                
                toggleItem(item) {
                    const existingIndex = this.items.findIndex(i => i.item_id == item.id);
                    if (existingIndex !== -1) {
                        // Remove item
                        this.items.splice(existingIndex, 1);
                    } else {
                        // Add item
                        this.items.push({
                            item_id: item.id,
                            name: item.name,
                            code: item.code,
                            qty_requested: 1,
                            stock: item.stock,
                            unit: item.unit
                        });
                    }
                },
                
                getItemQty(itemId) {
                    const item = this.items.find(i => i.item_id == itemId);
                    return item ? item.qty_requested : 1;
                },
                
                updateItemQty(itemId, qty) {
                    const item = this.items.find(i => i.item_id == itemId);
                    if (item) {
                        item.qty_requested = parseInt(qty) || 1;
                    }
                },
                
                removeItem(index) {
                    this.items.splice(index, 1);
                },
                
                async loadTemplateItems() {
                    if (!this.selectedTemplate) {
                        this.items = [];
                        return;
                    }
                    
                    try {
                        const response = await fetch(`/api/templates/${this.selectedTemplate}/items`);
                        const templateItems = await response.json();
                        
                        this.items = templateItems.map(ti => {
                            const fullItem = availableItems.find(i => i.id == ti.item_id);
                            return {
                                item_id: ti.item_id.toString(),
                                name: fullItem?.name || ti.item_name,
                                code: fullItem?.code || ti.item_code,
                                qty_requested: ti.default_qty,
                                stock: ti.item_stock,
                                unit: ti.item_unit
                            };
                        });
                    } catch (error) {
                        console.error('Failed to load template items:', error);
                    }
                }
            }
        }
    </script>
</x-app-layout>
