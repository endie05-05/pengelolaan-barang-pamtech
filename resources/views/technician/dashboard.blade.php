<x-technician-layout>
    <div>
        <!-- Header with Buttons -->
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Halo, {{ Auth::user()->name }}</h1>
                <p class="text-sm text-slate-500">Dashboard Teknisi Pamtechno</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('technician.items') }}" 
                   class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Lihat Barang
                </a>
                <a href="{{ route('technician.requests.create') }}" 
                   class="px-4 py-2.5 text-sm font-semibold text-white bg-[#006600] rounded-lg hover:bg-[#005500] transition-colors flex items-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Proyek Baru
                </a>
            </div>
        </div>

        <!-- Tabs -->
        <div class="mb-6 border-b border-slate-200">
            <div class="flex gap-6">
                <div class="pb-3 px-2 text-sm font-semibold border-b-2 border-[#006600] text-[#006600] flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Proyek Aktif
                </div>
            </div>
        </div>

        <!-- Tab Content: Proyek Aktif -->
        <div>
            <div class="space-y-3 mb-6">
                <h2 class="text-lg font-bold text-slate-800">Proyek Aktif</h2>

                @if($activeProjects->count() > 0)
                    @foreach($activeProjects as $project)
                    <div x-data="{ expanded: false }" 
                         class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden transition-all"
                         :class="expanded ? 'border-[#006600]' : 'hover:border-slate-300'">
                        <!-- Card Header (Clickable) -->
                        <div @click="expanded = !expanded" 
                             class="p-4 cursor-pointer hover:bg-slate-50 transition-colors">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-bold text-slate-800 text-lg flex-1">{{ $project->project_name }}</h3>
                                <div class="flex items-center gap-2">
                                    <span class="px-3 py-1 text-xs font-medium rounded-lg whitespace-nowrap
                                        @if($project->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($project->status === 'checked_out') bg-blue-100 text-blue-800
                                        @elseif($project->status === 'returned') bg-purple-100 text-purple-800
                                        @endif">
                                        {{ $project->status_label }}
                                    </span>
                                    <!-- Toggle Icon -->
                                    <svg class="w-5 h-5 text-slate-400 transition-transform" 
                                         :class="expanded ? 'rotate-180' : ''"
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 text-sm text-slate-500">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $project->location ?? 'Tidak ada lokasi' }}
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    {{ $project->items->count() }} Barang
                                </div>
                                <div class="text-xs text-slate-400 ml-auto">
                                    {{ $project->created_at->format('d M Y') }}
                                </div>
                            </div>
                        </div>

                        <!-- Expandable Items List -->
                        <div x-show="expanded" 
                             x-collapse
                             class="border-t border-slate-200 bg-slate-50">
                            <div class="p-4 space-y-4">
                                @php
                                    $tools = $project->items->filter(fn($i) => $i->item->item_type === 'tools');
                                    $materials = $project->items->filter(fn($i) => in_array($i->item->item_type, ['materials', 'equipment']));
                                @endphp

                                <!-- Tools Section -->
                                @if($tools->count() > 0)
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <h4 class="text-xs font-semibold text-blue-600 uppercase tracking-wide">Alat (Dapat Dikembalikan)</h4>
                                    </div>
                                    <div class="space-y-2">
                                        @foreach($tools as $item)
                                        <div class="flex items-center justify-between p-2 bg-white rounded-lg border border-blue-200">
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-slate-800">{{ $item->item->name }}</p>
                                                <p class="text-xs text-slate-500">{{ $item->item->category->name ?? '-' }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm font-semibold text-blue-700">{{ $item->qty_requested }} {{ $item->item->unit }}</p>
                                                <p class="text-xs text-slate-400">Returnable</p>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <!-- Materials Section -->
                                @if($materials->count() > 0)
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                        <h4 class="text-xs font-semibold text-orange-600 uppercase tracking-wide">Barang (Sekali Pakai)</h4>
                                    </div>
                                    <div class="space-y-2">
                                        @foreach($materials as $item)
                                        <div class="flex items-center justify-between p-2 bg-white rounded-lg border border-orange-200">
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-slate-800">{{ $item->item->name }}</p>
                                                <p class="text-xs text-slate-500">{{ $item->item->category->name ?? '-' }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm font-semibold text-orange-700">{{ $item->qty_requested }} {{ $item->item->unit }}</p>
                                                <p class="text-xs text-slate-400">Disposable</p>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                
                                <!-- View Detail Button -->
                                <a href="{{ route('technician.projects.show', $project) }}" 
                                   class="block w-full text-center px-4 py-2 bg-[#006600] hover:bg-[#005500] text-white text-sm font-medium rounded-lg transition-colors">
                                    Lihat Detail Lengkap
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 text-center">
                        <div class="inline-flex items-center justify-center w-14 h-14 bg-slate-100 rounded-full mb-3">
                            <svg class="w-7 h-7 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <h3 class="text-base font-medium text-slate-800 mb-1">Tidak ada proyek aktif</h3>
                        <p class="text-sm text-slate-500 mb-4">Anda belum memiliki proyek yang sedang berjalan.</p>
                        <a href="{{ route('technician.requests.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-[#006600] text-white font-medium rounded-xl hover:bg-[#005500] transition-colors text-sm">
                            + Buat Proyek Baru
                        </a>
                    </div>
                @endif
                
                <!-- Riwayat Selesai (Always show if exists) -->
                @if($completedProjects->count() > 0)
                <div class="mt-6">
                    <h3 class="text-base font-bold text-slate-600 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Riwayat Selesai
                    </h3>
                    @foreach($completedProjects as $project)
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-3 mb-2 opacity-75 hover:opacity-100 transition-opacity">
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-slate-700 text-sm">{{ $project->project_name }}</span>
                            <span class="px-2 py-0.5 text-xs font-medium rounded bg-green-100 text-green-800">Selesai</span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">{{ $project->created_at->format('d M Y') }}</p>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</x-technician-layout>

