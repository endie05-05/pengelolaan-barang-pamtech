<x-app-layout>
    <div x-data="{ activeTab: '{{ $activeTab }}' }">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Barang Keluar</h1>
                <p class="text-slate-500">Kelola permintaan pengambilan barang dari gudang</p>
            </div>
            <a href="{{ route('requests.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Buat Request
            </a>
        </div>

        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700">
            {{ session('error') }}
        </div>
        @endif

        <!-- Filters -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 mb-6">
            <form action="{{ route('requests.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                <input type="hidden" name="tab" :value="activeTab">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari proyek, teknisi, atau lokasi..." 
                        class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <button type="submit" class="px-6 py-2 bg-slate-100 text-slate-700 font-medium rounded-xl hover:bg-slate-200 transition-colors">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('requests.index') }}" class="px-6 py-2 bg-slate-200 text-slate-700 font-medium rounded-xl hover:bg-slate-300 transition-colors text-center">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Tab Navigation & Content -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="border-b border-slate-200">
                <nav class="flex -mb-px">
                    <button type="button"
                        @click="activeTab = 'active'"
                        :class="activeTab === 'active' ? 'border-indigo-500 text-indigo-600 bg-indigo-50' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                        class="flex-1 sm:flex-none px-6 py-4 text-sm font-medium border-b-2 focus:outline-none transition-colors">
                        <div class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span>Semua Proyek</span>
                            <span class="ml-1 px-2 py-0.5 text-xs rounded-full bg-slate-100 text-slate-600">{{ $requests->total() }}</span>
                        </div>
                    </button>
                    <button type="button"
                        @click="activeTab = 'completed'"
                        :class="activeTab === 'completed' ? 'border-indigo-500 text-indigo-600 bg-indigo-50' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                        class="flex-1 sm:flex-none px-6 py-4 text-sm font-medium border-b-2 focus:outline-none transition-colors">
                        <div class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Proyek Selesai</span>
                            <span class="ml-1 px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-600">{{ $completedRequests->total() }}</span>
                        </div>
                    </button>
                </nav>
            </div>

            <!-- Active Projects Tab Content -->
            <div x-show="activeTab === 'active'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">Proyek</th>
                                <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">Teknisi</th>
                                <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">Template</th>
                                <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">Jumlah Item</th>
                                <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">Status</th>
                                <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">Tanggal</th>
                                <th class="text-center px-6 py-4 text-sm font-semibold text-slate-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($requests as $request)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-800">{{ $request->project_name }}</div>
                                    @if($request->location)
                                    <div class="text-sm text-slate-500">{{ $request->location }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-600">{{ $request->technician_name }}</td>
                                <td class="px-6 py-4 text-slate-600">
                                    @if($request->template)
                                        <span class="px-2 py-1 bg-indigo-50 text-indigo-700 text-xs font-medium rounded-lg">
                                            {{ $request->template->name }}
                                        </span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-600">{{ $request->items->count() }} item</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full 
                                        @if($request->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($request->status === 'checked_out') bg-blue-100 text-blue-800
                                        @elseif($request->status === 'returned') bg-purple-100 text-purple-800
                                        @else bg-green-100 text-green-800
                                        @endif">
                                        {{ $request->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-600">{{ $request->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('requests.show', $request) }}" class="inline-flex items-center px-3 py-1 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors">
                                            Detail
                                        </a>
                                        <form action="{{ route('requests.destroy', $request) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus request ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-400 hover:text-red-600 transition-colors" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p class="mt-4 text-slate-500">Belum ada proyek aktif</p>
                                    <a href="{{ route('requests.create') }}" class="mt-2 inline-block text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                        + Buat Request Pertama
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($requests->hasPages())
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $requests->appends(request()->except('active_page'))->links() }}
                </div>
                @endif
            </div>

            <!-- Completed Projects Tab Content -->
            <div x-show="activeTab === 'completed'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">Proyek</th>
                                <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">Teknisi</th>
                                <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">Template</th>
                                <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">Jumlah Item</th>
                                <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">Selesai Pada</th>
                                <th class="text-center px-6 py-4 text-sm font-semibold text-slate-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($completedRequests as $request)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-medium text-slate-800">{{ $request->project_name }}</div>
                                            @if($request->location)
                                            <div class="text-sm text-slate-500">{{ $request->location }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-600">{{ $request->technician_name }}</td>
                                <td class="px-6 py-4 text-slate-600">
                                    @if($request->template)
                                        <span class="px-2 py-1 bg-indigo-50 text-indigo-700 text-xs font-medium rounded-lg">
                                            {{ $request->template->name }}
                                        </span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-600">{{ $request->items->count() }} item</td>
                                <td class="px-6 py-4 text-slate-600">
                                    {{ $request->checkin_at ? $request->checkin_at->format('d M Y') : $request->updated_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('requests.show', $request) }}" class="inline-flex items-center px-3 py-1 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors">
                                            Detail
                                        </a>
                                        <a href="{{ route('requests.edit-reconciliation', $request) }}" class="inline-flex items-center px-3 py-1 bg-amber-100 text-amber-700 text-sm font-medium rounded-lg hover:bg-amber-200 transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="mt-4 text-slate-500">Belum ada proyek yang selesai</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($completedRequests->hasPages())
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $completedRequests->appends(request()->except('completed_page'))->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
