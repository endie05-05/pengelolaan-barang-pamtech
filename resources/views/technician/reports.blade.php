<x-technician-layout>
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('technician.dashboard') }}" class="text-sm text-slate-500 hover:text-[#006600] flex items-center gap-1 mb-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Dashboard
        </a>
        <h1 class="text-2xl font-bold text-slate-800">Laporan</h1>
        <p class="text-slate-500">Lihat berbagai laporan inventaris</p>
    </div>

    <!-- Report Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Loss & Damage Report -->
        <a href="{{ route('reports.loss-damage') }}" class="group bg-white rounded-xl p-6 shadow-sm border border-slate-200 hover:border-red-400 hover:shadow-md transition-all">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-full flex items-center justify-center bg-red-100 text-red-600 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 mb-1">Loss & Damage</h3>
                    <p class="text-sm text-slate-500">Laporan barang rusak dan hilang</p>
                </div>
            </div>
        </a>

        <!-- Stock Movement Report -->
        <a href="{{ route('reports.stock-movement') }}" class="group bg-white rounded-xl p-6 shadow-sm border border-slate-200 hover:border-blue-400 hover:shadow-md transition-all">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-full flex items-center justify-center bg-blue-100 text-blue-600 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 mb-1">Stock Movement</h3>
                    <p class="text-sm text-slate-500">Riwayat keluar-masuk barang</p>
                </div>
            </div>
        </a>

        <!-- Tool Utilization Report -->
        <a href="{{ route('reports.tool-utilization') }}" class="group bg-white rounded-xl p-6 shadow-sm border border-slate-200 hover:border-green-400 hover:shadow-md transition-all">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-full flex items-center justify-center bg-green-100 text-green-600 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 mb-1">Tool Utilization</h3>
                    <p class="text-sm text-slate-500">Penggunaan alat/tools</p>
                </div>
            </div>
        </a>
    </div>

</x-technician-layout>
