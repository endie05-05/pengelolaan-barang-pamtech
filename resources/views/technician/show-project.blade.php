<x-technician-layout>
    <div class="mb-6 flex items-center justify-between gap-4">
        <a href="{{ route('technician.dashboard') }}" class="p-2 rounded-full hover:bg-slate-100 transition-colors">
            <svg class="w-6 h-6 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-xl font-bold text-slate-800 flex-1 truncate">{{ $materialRequest->project_name }}</h1>
        <span class="px-3 py-1 text-sm font-medium rounded-full 
            @if($materialRequest->status === 'pending') bg-yellow-100 text-yellow-800
            @elseif($materialRequest->status === 'checked_out') bg-blue-100 text-blue-800
            @elseif($materialRequest->status === 'returned') bg-purple-100 text-purple-800
            @else bg-green-100 text-green-800
            @endif">
            {{ $materialRequest->status_label }}
        </span>
    </div>

    <!-- Project Info Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 mb-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-4 opacity-10">
            <svg class="w-24 h-24 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
        </div>
        
        <div class="grid grid-cols-1 gap-4 relative z-10">
            <div class="flex items-start gap-3">
                <div class="p-2 bg-slate-100 rounded-lg text-slate-500">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500">Lokasi</label>
                    <p class="font-medium text-slate-800">{{ $materialRequest->location ?? '-' }}</p>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <div class="p-2 bg-slate-100 rounded-lg text-slate-500">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500">Tanggal Keberangkatan</label>
                    <p class="font-medium text-slate-800">
                        {{ $materialRequest->departure_date ? \Carbon\Carbon::parse($materialRequest->departure_date)->format('d M Y') : '-' }}
                    </p>
                </div>
            </div>
            
            @if($materialRequest->notes)
            <div class="flex items-start gap-3">
                <div class="p-2 bg-slate-100 rounded-lg text-slate-500">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500">Catatan</label>
                    <p class="font-medium text-slate-800 text-sm">{{ $materialRequest->notes }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Items List -->
    <div class="mb-20">
        <h3 class="text-lg font-bold text-slate-800 mb-4 px-2">Daftar Barang</h3>
        
        <div class="space-y-3">
            @foreach($materialRequest->items as $item)
            <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm flex items-center justify-between">
                <div>
                    <span class="inline-block w-2 h-2 rounded-full mb-1 
                        {{ $item->item->item_type === 'tools' ? 'bg-orange-500' : 'bg-blue-500' }}"></span>
                    <h4 class="font-semibold text-slate-800">{{ $item->item->name }}</h4>
                    <p class="text-xs text-slate-500">{{ $item->item->code }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-slate-500 mb-1">Jumlah</p>
                    <span class="text-lg font-bold text-slate-800">
                        {{ $item->qty_out ?? $item->qty_requested }} 
                        <span class="text-xs font-normal text-slate-500">{{ $item->item->unit }}</span>
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Action Bar (Fixed Bottom) -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 p-4 lg:static lg:bg-transparent lg:border-t-0">
        <div class="container mx-auto max-w-7xl">
            @if($materialRequest->status === 'checked_out')
                <a href="{{ route('requests.checkin.form', $materialRequest) }}" 
                   class="block w-full text-center bg-[#006600] text-white font-bold py-3 rounded-xl shadow-lg hover:bg-[#005500] transition-colors">
                    Lapor Pengerjaan (Check-in)
                </a>
                <p class="text-center text-xs text-slate-500 mt-2">Klik tombol ini setelah pekerjaan selesai untuk melaporkan pemakaian barang.</p>
            @elseif($materialRequest->status === 'pending')
                <button disabled class="block w-full text-center bg-slate-200 text-slate-400 font-bold py-3 rounded-xl cursor-not-allowed">
                    Menunggu Approval Admin
                </button>
                <p class="text-center text-xs text-slate-500 mt-2">Hubungi admin untuk persetujuan dan pengambilan barang.</p>
            @else
                <div class="text-center p-3 bg-green-50 text-green-800 rounded-xl font-medium border border-green-200">
                    Proyek Selesai
                </div>
            @endif
        </div>
    </div>
    
    <!-- Spacer for mobile bottom bar -->
    <div class="h-24 lg:hidden"></div>
</x-technician-layout>
