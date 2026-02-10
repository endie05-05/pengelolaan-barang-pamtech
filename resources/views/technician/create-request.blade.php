<x-technician-layout>
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('technician.dashboard') }}" class="p-2 rounded-full hover:bg-slate-100 transition-colors">
            <svg class="w-6 h-6 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-slate-800">Buat Proyek Baru</h1>
    </div>

    <!-- Main Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
        <form action="{{ route('technician.requests.store') }}" method="POST" class="p-4 sm:p-6 space-y-6"
              x-data="requestForm()">
            @csrf

            <!-- Project Details -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-slate-800 border-b border-slate-100 pb-2">Informasi Proyek</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Nama Proyek</label>
                        <input type="text" name="project_name" required 
                               class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#006600] focus:border-[#006600]"
                               placeholder="Contoh: Instalasi CCTV PT X">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Lokasi</label>
                        <input type="text" name="location" 
                               class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#006600] focus:border-[#006600]"
                               placeholder="Alamat Pelanggan">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Tgl Keberangkatan</label>
                        <input type="date" name="departure_date" required value="{{ date('Y-m-d') }}"
                               class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#006600] focus:border-[#006600]">
                    </div>
                </div>
            </div>

            <!-- Template Selection -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-slate-800 border-b border-slate-100 pb-2">Pilih Paket (Template)</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($templates as $template)
                    <div class="relative flex items-start p-4 border rounded-xl hover:bg-slate-50 cursor-pointer transition-colors"
                         :class="selectedTemplate === {{ $template->id }} ? 'border-[#006600] bg-green-50 ring-1 ring-[#006600]' : 'border-slate-200'"
                         @click="selectTemplate({{ $template->id }}, '{{ $template->name }}')">
                        <div class="flex items-center h-5">
                            <input type="radio" name="template_id" value="{{ $template->id }}" 
                                   :checked="selectedTemplate === {{ $template->id }}"
                                   class="focus:ring-[#006600] h-4 w-4 text-[#006600] border-gray-300">
                        </div>
                        <div class="ml-3 text-sm">
                            <label class="font-medium text-slate-900 cursor-pointer">
                                {{ $template->name }}
                            </label>
                            <p class="text-slate-500">{{ $template->description }}</p>
                        </div>
                    </div>
                    @endforeach
                    <!-- Custom Option -->
                    <div class="relative flex items-start p-4 border rounded-xl hover:bg-slate-50 cursor-pointer transition-colors"
                         :class="selectedTemplate === null ? 'border-[#006600] bg-green-50 ring-1 ring-[#006600]' : 'border-slate-200'"
                         @click="selectTemplate(null, 'Custom')">
                        <div class="flex items-center h-5">
                            <input type="radio" name="template_id" value="" 
                                   :checked="selectedTemplate === null"
                                   class="focus:ring-[#006600] h-4 w-4 text-[#006600] border-gray-300">
                        </div>
                        <div class="ml-3 text-sm">
                            <label class="font-medium text-slate-900 cursor-pointer">
                                Custom (Pilih Manual)
                            </label>
                            <p class="text-slate-500">Pilih barang satu per satu</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items List -->
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                    <h3 class="text-lg font-semibold text-slate-800">Daftar Barang</h3>
                    <button type="button" @click="addItem()" 
                            class="text-sm px-3 py-1.5 bg-slate-100 text-slate-700 font-medium rounded-lg hover:bg-slate-200 transition-colors">
                        + Tambah Barang
                    </button>
                </div>

                <div class="space-y-2" id="items-container">
                    <template x-for="(row, index) in items" :key="index">
                        <div class="flex items-center gap-3 p-3 bg-white rounded-lg border border-slate-200 hover:border-[#006600] transition-colors">
                            <!-- Item Name (Flex 1 - Takes most space) -->
                            <div class="flex-1">
                                <select :name="'items['+index+'][item_id]'" x-model="row.item_id" required
                                        class="w-full px-3 py-2 text-sm border-0 bg-transparent focus:ring-0 font-medium text-slate-800">
                                    <option value="">Pilih Barang...</option>
                                    @foreach($items as $item)
                                    <option value="{{ $item->id }}" data-unit="{{ $item->unit }}">
                                        {{ $item->name }} (Stok: {{ $item->stock }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Quantity Input (Fixed width) -->
                            <div class="flex items-center gap-2 w-32">
                                <input type="number" :name="'items['+index+'][qty_requested]'" x-model="row.qty" required min="1"
                                       class="w-20 px-3 py-2 text-sm text-center border border-slate-300 rounded-lg focus:ring-1 focus:ring-[#006600] focus:border-[#006600]"
                                       placeholder="0">
                                <span class="text-xs text-slate-500 font-medium min-w-[40px]" x-text="getUnit(row.item_id)"></span>
                            </div>
                            
                            <!-- Delete Button -->
                            <button type="button" @click="removeItem(index)" 
                                    class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>
                
                <div x-show="items.length === 0" class="text-center py-8 text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-300">
                    <p>Belum ada barang dipilih.</p>
                    <button type="button" @click="addItem()" class="mt-2 text-[#006600] font-medium hover:underline">
                        Tambah barang manual
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-6">
                <button type="submit" 
                        class="w-full bg-[#006600] text-white font-bold py-4 rounded-xl shadow-lg hover:bg-[#005500] hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                    Buat Proyek
                </button>
            </div>
        </form>
    </div>

    <!-- Script for Dynamic Form -->
    <script>
        function requestForm() {
            return {
                selectedTemplate: null,
                items: [{ item_id: '', qty: 1 }], // Start with 1 empty row
                allItems: @json($items),
                
                addItem() {
                    this.items.push({ item_id: '', qty: 1 });
                },
                
                removeItem(index) {
                    this.items.splice(index, 1);
                },

                getUnit(itemId) {
                    const item = this.allItems.find(i => i.id == itemId);
                    return item ? item.unit : '';
                },

                selectTemplate(templateId, templateName) {
                    this.selectedTemplate = templateId;
                    
                    if (!templateId) {
                        this.items = [{ item_id: '', qty: 1 }];
                        return;
                    }

                    // Fetch template items via API
                    fetch(`/api/templates/${templateId}/items`)
                        .then(response => response.json())
                        .then(data => {
                            this.items = data.map(item => ({
                                item_id: item.item_id,
                                qty: item.default_qty
                            }));
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Gagal memuat template');
                        });
                }
            }
        }
    </script>
</x-technician-layout>
