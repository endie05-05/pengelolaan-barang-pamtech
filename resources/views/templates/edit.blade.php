<x-app-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm text-slate-500">
                <li><a href="{{ route('templates.index') }}" class="hover:text-indigo-600">Paket Proyek</a></li>
                <li><span>/</span></li>
                <li><a href="{{ route('templates.show', $template) }}" class="hover:text-indigo-600">{{ $template->name }}</a></li>
                <li><span>/</span></li>
                <li class="text-slate-800 font-medium">Edit</li>
            </ol>
        </nav>
        <h1 class="text-2xl font-bold text-slate-800">Edit Template</h1>
        <p class="text-slate-500">Ubah template {{ $template->name }}</p>
    </div>

    <form action="{{ route('templates.update', $template) }}" method="POST" x-data="templateForm()">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Template Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">Informasi Template</h2>
                
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Nama Template <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $template->name) }}" required
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
                        <textarea name="description" rows="2"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $template->description) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Items List -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-slate-800">Daftar Barang Standar</h2>
                    <button type="button" @click="addItem()" 
                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Barang
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="text-left px-4 py-3 text-sm font-semibold text-slate-600">Barang</th>
                                <th class="text-left px-4 py-3 text-sm font-semibold text-slate-600 w-32">Qty Default</th>
                                <th class="text-center px-4 py-3 text-sm font-semibold text-slate-600 w-16"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <template x-for="(item, index) in items" :key="index">
                                <tr>
                                    <td class="px-4 py-3">
                                        <select x-model="item.item_id" :name="'items[' + index + '][item_id]'" required
                                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <option value="">-- Pilih Barang --</option>
                                            @foreach($items as $availableItem)
                                            <option value="{{ $availableItem->id }}">
                                                {{ $availableItem->name }} ({{ $availableItem->code }}) - {{ $availableItem->unit }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="number" x-model="item.default_qty" :name="'items[' + index + '][default_qty]'" 
                                            min="1" required
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
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('templates.show', $template) }}" class="px-6 py-3 text-slate-600 font-medium hover:text-slate-800 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>

    <script>
        function templateForm() {
            return {
                items: @json($template->items->map(fn($ti) => ['item_id' => (string)$ti->item_id, 'default_qty' => $ti->default_qty])),
                
                addItem() {
                    this.items.push({ item_id: '', default_qty: 1 });
                },
                
                removeItem(index) {
                    this.items.splice(index, 1);
                }
            }
        }
    </script>
</x-app-layout>
