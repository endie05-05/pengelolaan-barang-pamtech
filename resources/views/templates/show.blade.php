<x-app-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm text-slate-500">
                <li><a href="{{ route('templates.index') }}" class="hover:text-indigo-600">Paket Proyek</a></li>
                <li><span>/</span></li>
                <li class="text-slate-800 font-medium">{{ $template->name }}</li>
            </ol>
        </nav>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">{{ $template->name }}</h1>
                @if($template->description)
                <p class="text-slate-500 mt-1">{{ $template->description }}</p>
                @endif
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('templates.edit', $template) }}" class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 font-medium rounded-xl hover:bg-slate-200 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <a href="{{ route('requests.create', ['template_id' => $template->id]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Buat Request
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700">
        {{ session('success') }}
    </div>
    @endif

    <!-- Items Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
        <div class="p-6 border-b border-slate-200">
            <h2 class="text-lg font-semibold text-slate-800">Daftar Barang ({{ $template->items->count() }} item)</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left px-6 py-3 text-sm font-semibold text-slate-600">#</th>
                        <th class="text-left px-6 py-3 text-sm font-semibold text-slate-600">Kode</th>
                        <th class="text-left px-6 py-3 text-sm font-semibold text-slate-600">Nama Barang</th>
                        <th class="text-left px-6 py-3 text-sm font-semibold text-slate-600">Kategori</th>
                        <th class="text-center px-6 py-3 text-sm font-semibold text-slate-600">Qty Default</th>
                        <th class="text-center px-6 py-3 text-sm font-semibold text-slate-600">Stok Saat Ini</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($template->items as $index => $templateItem)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-slate-500">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-slate-100 text-slate-600 text-xs font-mono rounded">{{ $templateItem->item->code }}</span>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-800">{{ $templateItem->item->name }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $templateItem->item->category->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-center font-bold text-indigo-600">{{ $templateItem->default_qty }} {{ $templateItem->item->unit }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="{{ $templateItem->item->stock < $templateItem->default_qty ? 'text-red-600 font-bold' : 'text-slate-600' }}">
                                {{ $templateItem->item->stock }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Delete -->
    <div class="mt-8 p-6 bg-red-50 rounded-2xl border border-red-200">
        <div class="flex items-start justify-between">
            <div>
                <h3 class="text-lg font-semibold text-red-800">Hapus Template</h3>
                <p class="text-sm text-red-600 mt-1">Menghapus template tidak akan menghapus barang yang ada di dalamnya.</p>
            </div>
            <form action="{{ route('templates.destroy', $template) }}" method="POST" 
                onsubmit="return confirm('Yakin ingin menghapus template ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white font-medium rounded-xl hover:bg-red-700 transition-colors">
                    Hapus Template
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
