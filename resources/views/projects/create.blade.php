<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Buat Proyek Baru</h1>
            <p class="text-slate-600 mt-1">Pilih template untuk mempercepat setup proyek</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <form action="#" method="POST" class="space-y-6">
                @csrf

                <!-- Project Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Proyek *</label>
                        <input type="text" name="name" required placeholder="Instalasi CCTV Gudang A" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Lokasi *</label>
                        <input type="text" name="location" required placeholder="Jl. Contoh No. 123" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <!-- Technician & Date -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Assign Teknisi</label>
                        <select name="technician_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">-- Pilih Teknisi --</option>
                            <option value="2">Teknisi 1 (teknisi@pamtech.com)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <!-- Template Selection -->
                <div class="pt-4 border-t border-slate-200">
                    <label class="block text-sm font-medium text-slate-700 mb-3">Pilih Template Proyek *</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Template 1 -->
                        <label class="relative cursor-pointer">
                            <input type="radio" name="template_id" value="1" class="peer sr-only" checked>
                            <div class="p-4 border-2 border-slate-200 rounded-xl peer-checked:border-indigo-500 peer-checked:bg-indigo-50 transition-all">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-medium text-indigo-600 bg-indigo-100 px-2 py-0.5 rounded">CCTV</span>
                                    <svg class="w-5 h-5 text-indigo-600 hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h4 class="font-semibold text-slate-900">Paket CCTV 4 Channel</h4>
                                <p class="text-xs text-slate-500 mt-1">4 Camera, DVR, Kabel, dll</p>
                                <p class="text-xs text-slate-400 mt-2">6 item</p>
                            </div>
                        </label>

                        <!-- Template 2 -->
                        <label class="relative cursor-pointer">
                            <input type="radio" name="template_id" value="2" class="peer sr-only">
                            <div class="p-4 border-2 border-slate-200 rounded-xl peer-checked:border-indigo-500 peer-checked:bg-indigo-50 transition-all">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-medium text-indigo-600 bg-indigo-100 px-2 py-0.5 rounded">CCTV</span>
                                </div>
                                <h4 class="font-semibold text-slate-900">Paket CCTV 8 Channel</h4>
                                <p class="text-xs text-slate-500 mt-1">8 Camera, DVR, Kabel, dll</p>
                                <p class="text-xs text-slate-400 mt-2">7 item</p>
                            </div>
                        </label>

                        <!-- Template 3 -->
                        <label class="relative cursor-pointer">
                            <input type="radio" name="template_id" value="3" class="peer sr-only">
                            <div class="p-4 border-2 border-slate-200 rounded-xl peer-checked:border-indigo-500 peer-checked:bg-indigo-50 transition-all">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-medium text-purple-600 bg-purple-100 px-2 py-0.5 rounded">Access Control</span>
                                </div>
                                <h4 class="font-semibold text-slate-900">Access Control Fingerprint</h4>
                                <p class="text-xs text-slate-500 mt-1">Fingerprint, Door Lock, dll</p>
                                <p class="text-xs text-slate-400 mt-2">4 item</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Material Preview -->
                <div class="pt-4 border-t border-slate-200">
                    <div class="flex items-center justify-between mb-3">
                        <label class="block text-sm font-medium text-slate-700">Material dari Template</label>
                        <span class="text-xs text-slate-500">Anda bisa adjust quantity sebelum simpan</span>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-slate-500">
                                    <th class="pb-3">Item</th>
                                    <th class="pb-3 text-center">Qty Default</th>
                                    <th class="pb-3 text-center w-32">Qty Aktual</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                <tr>
                                    <td class="py-3">CCTV Camera Dome 2MP</td>
                                    <td class="py-3 text-center text-slate-400">4</td>
                                    <td class="py-3"><input type="number" value="4" min="0" class="w-full px-3 py-1 border border-slate-300 rounded text-center"></td>
                                </tr>
                                <tr>
                                    <td class="py-3">Kabel RG59 + Power</td>
                                    <td class="py-3 text-center text-slate-400">100</td>
                                    <td class="py-3"><input type="number" value="100" min="0" class="w-full px-3 py-1 border border-slate-300 rounded text-center"></td>
                                </tr>
                                <tr>
                                    <td class="py-3">BNC Connector</td>
                                    <td class="py-3 text-center text-slate-400">20</td>
                                    <td class="py-3"><input type="number" value="20" min="0" class="w-full px-3 py-1 border border-slate-300 rounded text-center"></td>
                                </tr>
                                <tr>
                                    <td class="py-3">DVR 8 Channel</td>
                                    <td class="py-3 text-center text-slate-400">1</td>
                                    <td class="py-3"><input type="number" value="1" min="0" class="w-full px-3 py-1 border border-slate-300 rounded text-center"></td>
                                </tr>
                                <tr>
                                    <td class="py-3">Power Supply 12V 5A</td>
                                    <td class="py-3 text-center text-slate-400">5</td>
                                    <td class="py-3"><input type="number" value="5" min="0" class="w-full px-3 py-1 border border-slate-300 rounded text-center"></td>
                                </tr>
                                <tr>
                                    <td class="py-3">HDD 1TB Surveillance</td>
                                    <td class="py-3 text-center text-slate-400">1</td>
                                    <td class="py-3"><input type="number" value="1" min="0" class="w-full px-3 py-1 border border-slate-300 rounded text-center"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Notes -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Catatan</label>
                    <textarea name="notes" rows="3" placeholder="Catatan tambahan untuk proyek ini..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <a href="{{ route('projects.index') }}" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition">Batal</a>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Buat Proyek</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
