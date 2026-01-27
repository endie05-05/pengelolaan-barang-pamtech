<x-app-layout>
    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <a href="{{ route('projects.index') }}" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <span class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full">Aktif</span>
                </div>
                <h1 class="text-2xl font-bold text-slate-900">Instalasi CCTV Gudang A</h1>
                <p class="text-slate-500 mt-1 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    </svg>
                    Jl. Industri No. 45, Bandung
                </p>
            </div>
            <div class="flex gap-2">
                <button class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition text-sm">Edit</button>
                <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm">Tandai Selesai</button>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
                <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Template</p>
                <p class="font-semibold text-slate-900">Paket CCTV 4 Channel</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
                <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Teknisi</p>
                <div class="flex items-center">
                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-medium text-xs mr-2">BS</div>
                    <span class="font-semibold text-slate-900">Budi Santoso</span>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
                <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Periode</p>
                <p class="font-semibold text-slate-900">20 Jan - 25 Jan 2026</p>
            </div>
        </div>

        <!-- Materials Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-5 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900">Material Proyek</h2>
                <p class="text-sm text-slate-500">Barang yang dialokasikan untuk proyek ini</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 text-xs text-slate-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-5 py-3 text-left">Item</th>
                            <th class="px-5 py-3 text-center">Dialokasi</th>
                            <th class="px-5 py-3 text-center">Terpakai</th>
                            <th class="px-5 py-3 text-center">Rusak</th>
                            <th class="px-5 py-3 text-center">Sisa</th>
                            <th class="px-5 py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4">
                                <div class="font-medium text-slate-900">CCTV Camera Dome 2MP</div>
                                <div class="text-xs text-slate-500">ITM-00001</div>
                            </td>
                            <td class="px-5 py-4 text-center font-medium">4</td>
                            <td class="px-5 py-4 text-center text-green-600">4</td>
                            <td class="px-5 py-4 text-center text-red-600">0</td>
                            <td class="px-5 py-4 text-center">0</td>
                            <td class="px-5 py-4 text-center">
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Selesai</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4">
                                <div class="font-medium text-slate-900">Kabel RG59 + Power</div>
                                <div class="text-xs text-slate-500">ITM-00003</div>
                            </td>
                            <td class="px-5 py-4 text-center font-medium">100</td>
                            <td class="px-5 py-4 text-center text-green-600">95</td>
                            <td class="px-5 py-4 text-center text-red-600">0</td>
                            <td class="px-5 py-4 text-center">5</td>
                            <td class="px-5 py-4 text-center">
                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full">Dilaporkan</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4">
                                <div class="font-medium text-slate-900">BNC Connector</div>
                                <div class="text-xs text-slate-500">ITM-00004</div>
                            </td>
                            <td class="px-5 py-4 text-center font-medium">20</td>
                            <td class="px-5 py-4 text-center text-green-600">16</td>
                            <td class="px-5 py-4 text-center text-red-600">2</td>
                            <td class="px-5 py-4 text-center">2</td>
                            <td class="px-5 py-4 text-center">
                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full">Dilaporkan</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4">
                                <div class="font-medium text-slate-900">DVR 8 Channel</div>
                                <div class="text-xs text-slate-500">ITM-00005</div>
                            </td>
                            <td class="px-5 py-4 text-center font-medium">1</td>
                            <td class="px-5 py-4 text-center text-green-600">1</td>
                            <td class="px-5 py-4 text-center text-red-600">0</td>
                            <td class="px-5 py-4 text-center">0</td>
                            <td class="px-5 py-4 text-center">
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Selesai</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4">
                                <div class="font-medium text-slate-900">Power Supply 12V 5A</div>
                                <div class="text-xs text-slate-500">ITM-00006</div>
                            </td>
                            <td class="px-5 py-4 text-center font-medium">5</td>
                            <td class="px-5 py-4 text-center text-slate-400">-</td>
                            <td class="px-5 py-4 text-center text-slate-400">-</td>
                            <td class="px-5 py-4 text-center text-slate-400">-</td>
                            <td class="px-5 py-4 text-center">
                                <span class="px-2 py-1 text-xs font-medium bg-amber-100 text-amber-700 rounded-full">Belum Lapor</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Reports -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-5 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900">Laporan Teknisi</h2>
                <p class="text-sm text-slate-500">Riwayat laporan dari lapangan</p>
            </div>
            <div class="divide-y divide-slate-200">
                <div class="p-5 hover:bg-slate-50">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="font-medium text-slate-900">Laporan Harian - 22 Jan 2026</p>
                            <p class="text-sm text-slate-500 mt-1">Pemasangan 4 kamera selesai. 2 BNC rusak saat pemasangan.</p>
                        </div>
                        <span class="text-xs text-slate-400">10:30 WIB</span>
                    </div>
                    <div class="flex gap-2 mt-3">
                        <div class="h-16 w-16 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="h-16 w-16 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="p-5 hover:bg-slate-50">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="font-medium text-slate-900">Laporan Harian - 21 Jan 2026</p>
                            <p class="text-sm text-slate-500 mt-1">Mulai penarikan kabel. Kabel terpakai 95m dari 100m.</p>
                        </div>
                        <span class="text-xs text-slate-400">16:45 WIB</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
