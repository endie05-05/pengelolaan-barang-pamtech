<x-app-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm text-slate-500">
                <li><a href="{{ route('requests.index') }}" class="hover:text-indigo-600">Request Barang</a></li>
                <li><span>/</span></li>
                <li class="text-slate-800 font-medium">{{ $materialRequest->project_name }}</li>
            </ol>
        </nav>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">{{ $materialRequest->project_name }}</h1>
                <p class="text-slate-500">Request oleh {{ $materialRequest->technician_name }}</p>
            </div>
            <span class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-full
                @if($materialRequest->status === 'pending') bg-yellow-100 text-yellow-800
                @elseif($materialRequest->status === 'checked_out') bg-blue-100 text-blue-800
                @elseif($materialRequest->status === 'returned') bg-purple-100 text-purple-800
                @else bg-green-100 text-green-800
                @endif">
                {{ $materialRequest->status_label }}
            </span>
        </div>
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Items -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
                <div class="p-6 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-800">Daftar Barang</h2>
                </div>
                
                @if($materialRequest->canCheckout())
                <!-- Checkout Form -->
                <form action="{{ route('requests.checkout', $materialRequest) }}" method="POST">
                    @csrf
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th class="text-left px-6 py-3 text-sm font-semibold text-slate-600">Barang</th>
                                    <th class="text-center px-6 py-3 text-sm font-semibold text-slate-600">Diminta</th>
                                    <th class="text-center px-6 py-3 text-sm font-semibold text-slate-600">Stok</th>
                                    <th class="text-center px-6 py-3 text-sm font-semibold text-slate-600">Qty Keluar</th>
                                    <th class="text-center px-6 py-3 text-sm font-semibold text-slate-600">Kondisi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($materialRequest->items as $index => $reqItem)
                                <tr>
                                    <input type="hidden" name="items[{{ $index }}][id]" value="{{ $reqItem->id }}">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-slate-800">{{ $reqItem->item->name }}</div>
                                        <div class="text-sm text-slate-500">{{ $reqItem->item->code }} • {{ $reqItem->item->category->name ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center text-slate-600">{{ $reqItem->qty_requested }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="{{ $reqItem->item->stock < $reqItem->qty_requested ? 'text-red-600 font-bold' : 'text-slate-600' }}">
                                            {{ $reqItem->item->stock }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="number" name="items[{{ $index }}][qty_out]" 
                                            value="{{ min($reqItem->qty_requested, $reqItem->item->stock) }}"
                                            min="0" max="{{ $reqItem->item->stock }}" required
                                            class="w-20 px-3 py-2 border border-slate-300 rounded-lg text-center focus:ring-2 focus:ring-indigo-500">
                                    </td>
                                    <td class="px-6 py-4">
                                        <select name="items[{{ $index }}][condition_out]" required
                                            class="px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                            <option value="good">Baik</option>
                                            <option value="fair">Cukup</option>
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-6 border-t border-slate-200 flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-green-600 text-white font-medium rounded-xl hover:bg-green-700 transition-colors">
                            <svg class="w-5 h-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Proses Check-out
                        </button>
                    </div>
                </form>
                @else
                <!-- View Only -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="text-left px-6 py-3 text-sm font-semibold text-slate-600">Barang</th>
                                <th class="text-center px-6 py-3 text-sm font-semibold text-slate-600">Diminta</th>
                                <th class="text-center px-6 py-3 text-sm font-semibold text-slate-600">Keluar</th>
                                <th class="text-center px-6 py-3 text-sm font-semibold text-slate-600">Terpakai</th>
                                <th class="text-center px-6 py-3 text-sm font-semibold text-slate-600">Kembali</th>
                                <th class="text-center px-6 py-3 text-sm font-semibold text-slate-600">Rusak/Hilang</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($materialRequest->items as $reqItem)
                            <tr class="{{ $reqItem->hasDiscrepancy() ? 'bg-red-50' : '' }}">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-800">{{ $reqItem->item->name }}</div>
                                    <div class="text-sm text-slate-500">{{ $reqItem->item->code }}</div>
                                </td>
                                <td class="px-6 py-4 text-center text-slate-600">{{ $reqItem->qty_requested }}</td>
                                <td class="px-6 py-4 text-center text-slate-600">{{ $reqItem->qty_out }}</td>
                                <td class="px-6 py-4 text-center text-slate-600">{{ $reqItem->qty_used }}</td>
                                <td class="px-6 py-4 text-center text-green-600 font-medium">{{ $reqItem->qty_returned }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($reqItem->qty_damaged > 0 || $reqItem->qty_lost > 0)
                                    <span class="text-red-600 font-medium">
                                        {{ $reqItem->qty_damaged }} / {{ $reqItem->qty_lost }}
                                    </span>
                                    @else
                                    <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($materialRequest->canCheckin())
                <div class="p-6 border-t border-slate-200 flex justify-end">
                    <a href="{{ route('requests.checkin.form', $materialRequest) }}" 
                        class="px-6 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Proses Check-in
                    </a>
                </div>
                @endif
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Info Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Informasi</h3>
                <dl class="space-y-4">
                    @if($materialRequest->template)
                    <div>
                        <dt class="text-sm text-slate-500">Template</dt>
                        <dd class="font-medium text-slate-800">{{ $materialRequest->template->name }}</dd>
                    </div>
                    @endif
                    <div>
                        <dt class="text-sm text-slate-500">Teknisi</dt>
                        <dd class="font-medium text-slate-800">{{ $materialRequest->technician_name }}</dd>
                    </div>
                    @if($materialRequest->location)
                    <div>
                        <dt class="text-sm text-slate-500">Lokasi</dt>
                        <dd class="font-medium text-slate-800">{{ $materialRequest->location }}</dd>
                    </div>
                    @endif
                    @if($materialRequest->departure_date)
                    <div>
                        <dt class="text-sm text-slate-500">Tanggal Berangkat</dt>
<dd class="font-medium text-slate-800">{{ $materialRequest->departure_date?->format('d M Y') ?? '-' }}</dd>
                    </div>
                    @endif
                    <div>
                        <dt class="text-sm text-slate-500">Dibuat</dt>
<dd class="font-medium text-slate-800">{{ $materialRequest->created_at?->format('d M Y H:i') ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-slate-500">Oleh</dt>
                        <dd class="font-medium text-slate-800">{{ $materialRequest->creator->name ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Timeline -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Timeline</h3>
                <div class="space-y-4">
                    <!-- Created -->
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-slate-800">Request dibuat</p>
<p class="text-xs text-slate-500">{{ $materialRequest->created_at?->format('d M Y H:i') ?? '-' }}</p>
                        </div>
                    </div>

                    @if($materialRequest->checkout_at)
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-slate-800">Check-out</p>
<p class="text-xs text-slate-500">{{ $materialRequest->checkout_at?->format('d M Y H:i') ?? '-' }} oleh {{ $materialRequest->checkoutUser->name ?? '-' }}</p>
                        </div>
                    </div>
                    @endif

                    @if($materialRequest->checkin_at)
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-slate-800">Check-in / Rekonsiliasi</p>
<p class="text-xs text-slate-500">{{ $materialRequest->checkin_at?->format('d M Y H:i') ?? '-' }} oleh {{ $materialRequest->checkinUser->name ?? '-' }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            @if($materialRequest->notes)
            <!-- Notes -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-2">Catatan</h3>
                <p class="text-slate-600">{{ $materialRequest->notes }}</p>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
