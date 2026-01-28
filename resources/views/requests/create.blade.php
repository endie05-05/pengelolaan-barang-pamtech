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
                <button type="button" @click="addItem()" 
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Tambah Barang
                </button>
            </div>

            <!-- Items Table -->
            <div class="overflow-x-auto">
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
                                    <select x-model="item.item_id" :name="'items[' + index + '][item_id]'" required
                                        @change="updateItemStock(index)"
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">-- Pilih Barang --</option>
                                        @foreach($items as $availableItem)
                                        <option value="{{ $availableItem->id }}" data-stock="{{ $availableItem->stock }}" data-unit="{{ $availableItem->unit }}">
                                            {{ $availableItem->name }} ({{ $availableItem->code }})
                                        </option>
                                        @endforeach
                                    </select>
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
                                    <button type="button" @click="removeItem(index)" x-show="items.length > 1"
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
                <p>Belum ada barang. Klik "Tambah Barang" untuk menambahkan.</p>
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
    </form>

    <script>
        function requestForm() {
            return {
                selectedTemplate: '{{ $selectedTemplate?->id ?? '' }}',
                items: @json($selectedTemplate ? $selectedTemplate->items->map(fn($ti) => ['item_id' => $ti->item_id, 'qty_requested' => $ti->default_qty, 'stock' => $ti->item->stock, 'unit' => $ti->item->unit]) : [['item_id' => '', 'qty_requested' => 1, 'stock' => null, 'unit' => '']]),
                
                addItem() {
                    this.items.push({ item_id: '', qty_requested: 1, stock: null, unit: '' });
                },
                
                removeItem(index) {
                    this.items.splice(index, 1);
                },
                
                updateItemStock(index) {
                    const select = document.querySelector(`select[name="items[${index}][item_id]"]`);
                    const option = select.options[select.selectedIndex];
                    this.items[index].stock = option.dataset.stock || null;
                    this.items[index].unit = option.dataset.unit || '';
                },
                
                async loadTemplateItems() {
                    if (!this.selectedTemplate) {
                        this.items = [{ item_id: '', qty_requested: 1, stock: null, unit: '' }];
                        return;
                    }
                    
                    try {
                        const response = await fetch(`/api/templates/${this.selectedTemplate}/items`);
                        const templateItems = await response.json();
                        
                        this.items = templateItems.map(ti => ({
                            item_id: ti.item_id.toString(),
                            qty_requested: ti.default_qty,
                            stock: ti.item_stock,
                            unit: ti.item_unit
                        }));
                    } catch (error) {
                        console.error('Failed to load template items:', error);
                    }
                }
            }
        }
    </script>
</x-app-layout>
