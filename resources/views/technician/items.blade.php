<x-technician-layout>
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('technician.dashboard') }}" class="text-sm text-slate-500 hover:text-[#006600] flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Dashboard
            </a>
            <h1 class="text-2xl font-bold text-slate-800">Daftar Barang</h1>
            <p class="text-slate-500">Lihat stok inventaris yang tersedia</p>
        </div>
    </div>

    <!-- Search & Filter -->
    <form method="GET" class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 mb-6">
        <div class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Cari barang..." 
                   class="flex-1 px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#006600] focus:border-transparent text-sm">
            <select name="category" class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#006600] focus:border-transparent text-sm">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-[#006600] text-white rounded-lg hover:bg-[#005500] transition-colors text-sm font-medium">
                Cari
            </button>
        </div>
    </form>

    <!-- Tabs & Items List -->
    <div x-data="{ activeTab: 'tools' }" class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <!-- Tab Headers -->
        <div class="border-b border-slate-200 bg-slate-50">
            <div class="flex">
                <button @click="activeTab = 'tools'" 
                        :class="activeTab === 'tools' ? 'border-b-2 border-[#006600] text-[#006600] bg-white' : 'text-slate-500 hover:text-slate-700'"
                        class="flex-1 px-6 py-3 text-sm font-semibold transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Alat
                </button>
                <button @click="activeTab = 'materials'" 
                        :class="activeTab === 'materials' ? 'border-b-2 border-[#006600] text-[#006600] bg-white' : 'text-slate-500 hover:text-slate-700'"
                        class="flex-1 px-6 py-3 text-sm font-semibold transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Barang
                </button>
            </div>
        </div>

        @php
            $tools = $items->filter(fn($item) => $item->item_type === 'tools');
            $materials = $items->filter(fn($item) => in_array($item->item_type, ['materials', 'equipment']));
        @endphp

        <!-- Tools Tab Content -->
        <div x-show="activeTab === 'tools'" x-transition>
            @if($tools->count() > 0)
                <div class="divide-y divide-slate-100">
                    @foreach($tools as $item)
                    <div class="p-4 hover:bg-blue-50 transition-colors">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-medium text-slate-800">{{ $item->name }}</h3>
                                <p class="text-sm text-slate-500">{{ $item->code }} • {{ $item->category->name ?? 'Uncategorized' }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium 
                                    {{ $item->stock > 10 ? 'bg-green-100 text-green-800' : ($item->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $item->stock }} {{ $item->unit }}
                                </span>
                                <p class="text-xs text-blue-600 mt-1 font-medium">Dapat Dikembalikan</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center">
                    <svg class="w-12 h-12 mx-auto text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <p class="text-slate-500">Tidak ada alat ditemukan.</p>
                </div>
            @endif
        </div>

        <!-- Materials Tab Content -->
        <div x-show="activeTab === 'materials'" x-transition>
            @if($materials->count() > 0)
                <div class="divide-y divide-slate-100">
                    @foreach($materials as $item)
                    <div class="p-4 hover:bg-orange-50 transition-colors">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-medium text-slate-800">{{ $item->name }}</h3>
                                <p class="text-sm text-slate-500">{{ $item->code }} • {{ $item->category->name ?? 'Uncategorized' }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium 
                                    {{ $item->stock > 10 ? 'bg-green-100 text-green-800' : ($item->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $item->stock }} {{ $item->unit }}
                                </span>
                                <p class="text-xs text-orange-600 mt-1 font-medium">Sekali Pakai</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center">
                    <svg class="w-12 h-12 mx-auto text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <p class="text-slate-500">Tidak ada barang ditemukan.</p>
                </div>
            @endif
        </div>
    </div>

</x-technician-layout>
