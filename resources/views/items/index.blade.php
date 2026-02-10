<x-app-layout>
    <div class="space-y-6" x-data="{ activeTab: '{{ $activeTab }}', foundItem: null }" 
        @barcode-scanned.window="findItemByBarcode($event.detail.barcode)">
        <!-- Header with Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Daftar Barang</h1>
                <p class="text-slate-600 mt-1">Kelola inventory barang gudang</p>
            </div>
            <div class="flex items-center gap-3">
                <x-barcode-scanner inputId="item-search-barcode" />
                <a href="{{ route('items.create') }}" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Barang
                </a>
            </div>
        </div>

        <!-- Found Item Alert -->
        <template x-if="foundItem">
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Barang ditemukan: <strong x-text="foundItem"></strong></span>
                </div>
                <button @click="foundItem = null" class="text-green-600 hover:text-green-800">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </template>

        <input type="hidden" id="item-search-barcode">

        <!-- Filters -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <form method="GET" action="{{ route('items.index') }}" class="flex flex-col sm:flex-row gap-4">
                <input type="hidden" name="tab" :value="activeTab">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama barang..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="w-full sm:w-64">
                    <select name="category_id" onchange="this.form.submit()" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-6 py-2 bg-slate-700 text-white rounded-lg hover:bg-slate-800 transition">Filter</button>
                @if(request()->has('search') || request()->has('category_id'))
                    <a href="{{ route('items.index') }}" class="px-6 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition text-center">Reset</a>
                @endif
            </form>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">{{ session('success') }}</div>
        @endif

        <!-- Tab Navigation -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="border-b border-slate-200">
                <nav class="flex -mb-px">
                    <button type="button"
                        @click="activeTab = 'items'"
                        :class="activeTab === 'items' ? 'border-indigo-500 text-indigo-600 bg-indigo-50' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                        class="flex-1 sm:flex-none px-6 py-4 text-sm font-medium border-b-2 focus:outline-none transition-colors">
                        <div class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <span>Barang</span>
                            <span class="ml-1 px-2 py-0.5 text-xs rounded-full bg-slate-100 text-slate-600">{{ $items->total() }}</span>
                        </div>
                    </button>
                    <button type="button"
                        @click="activeTab = 'tools'"
                        :class="activeTab === 'tools' ? 'border-indigo-500 text-indigo-600 bg-indigo-50' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                        class="flex-1 sm:flex-none px-6 py-4 text-sm font-medium border-b-2 focus:outline-none transition-colors">
                        <div class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Tools</span>
                            <span class="ml-1 px-2 py-0.5 text-xs rounded-full bg-slate-100 text-slate-600">{{ $tools->total() }}</span>
                        </div>
                    </button>
                </nav>
            </div>

            <!-- Items Tab Content -->
            <div x-show="activeTab === 'items'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">SKU / Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Stok</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @forelse($items as $item)
                                <tr class="hover:bg-slate-50 transition item-row" 
                                    data-barcode="{{ $item->barcode }}" 
                                    data-code="{{ $item->code }}" 
                                    data-name="{{ $item->name }}"
                                    data-tab="items">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-xs text-slate-500">{{ $item->code }}</div>
                                        <div class="text-sm font-medium text-slate-900">{{ $item->name }}</div>
                                        <div class="text-xs text-slate-400">{{ $item->unit }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-medium bg-slate-100 text-slate-700 rounded-full">
                                            {{ $item->category->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 font-medium">
                                        {{ $item->stock }} / <span class="text-slate-500">min {{ $item->min_stock }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($item->stock <= $item->min_stock)
                                            <span class="px-3 py-1 text-xs font-medium bg-red-100 text-red-700 rounded-full">Kritis</span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Aman</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('items.edit', $item) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form action="{{ route('items.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus item ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                        <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <p class="mt-2">Belum ada barang</p>
                                        <a href="{{ route('items.create') }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-700">Tambah barang pertama →</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($items->hasPages())
                    <div class="px-6 py-4 border-t border-slate-200">{{ $items->appends(request()->except('items_page'))->links() }}</div>
                @endif
            </div>

            <!-- Tools Tab Content -->
            <div x-show="activeTab === 'tools'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">SKU / Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @forelse($tools as $tool)
                                <tr class="hover:bg-slate-50 transition item-row" 
                                    data-barcode="{{ $tool->barcode }}" 
                                    data-code="{{ $tool->code }}" 
                                    data-name="{{ $tool->name }}"
                                    data-tab="tools">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="flex-shrink-0 w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-xs text-slate-500">{{ $tool->code }}</div>
                                                <div class="text-sm font-medium text-slate-900">{{ $tool->name }}</div>
                                                <div class="text-xs text-slate-400">{{ $tool->unit }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-medium bg-amber-100 text-amber-700 rounded-full">
                                            {{ $tool->category->name ?? 'Tools' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 font-medium">
                                        {{ $tool->stock }} <span class="text-slate-500">{{ $tool->unit }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($tool->stock <= $tool->min_stock)
                                            <span class="px-3 py-1 text-xs font-medium bg-red-100 text-red-700 rounded-full">Perlu Restok</span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Tersedia</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('items.edit', $tool) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form action="{{ route('items.destroy', $tool) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus tool ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                        <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <p class="mt-2">Belum ada tools</p>
                                        <a href="{{ route('items.create') }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-700">Tambah tools pertama →</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($tools->hasPages())
                    <div class="px-6 py-4 border-t border-slate-200">{{ $tools->appends(request()->except('tools_page'))->links() }}</div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function findItemByBarcode(barcode) {
            const rows = document.querySelectorAll('.item-row');
            let found = false;
            let targetRow = null;
            let targetTab = null;

            rows.forEach(row => {
                // Remove previous highlights
                row.classList.remove('ring-2', 'ring-green-500', 'bg-green-100');
                
                if (row.dataset.barcode === barcode || row.dataset.code === barcode) {
                    targetRow = row;
                    targetTab = row.dataset.tab;
                    found = true;
                }
            });

            if (found && targetRow) {
                // Switch to correct tab if needed
                const alpineData = Alpine.$data(document.querySelector('[x-data]'));
                if (alpineData && alpineData.activeTab !== targetTab) {
                    alpineData.activeTab = targetTab;
                    // Wait for tab transition
                    setTimeout(() => highlightRow(targetRow, alpineData), 300);
                } else {
                    highlightRow(targetRow, alpineData);
                }
            } else {
                alert('Barang dengan barcode "' + barcode + '" tidak ditemukan dalam daftar.');
            }
        }

        function highlightRow(row, alpineData) {
            row.scrollIntoView({ behavior: 'smooth', block: 'center' });
            row.classList.add('ring-2', 'ring-green-500', 'bg-green-100');
            
            if (alpineData) {
                alpineData.foundItem = row.dataset.name;
            }
            
            setTimeout(() => {
                row.classList.remove('ring-2', 'ring-green-500', 'bg-green-100');
                if (alpineData) {
                    alpineData.foundItem = null;
                }
            }, 4000);
        }
    </script>
</x-app-layout>
