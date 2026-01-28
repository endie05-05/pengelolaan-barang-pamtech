<x-app-layout>
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Paket Proyek</h1>
            <p class="text-slate-500">Kelola template Bill of Materials untuk standarisasi kebutuhan proyek</p>
        </div>
        <a href="{{ route('templates.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Buat Template
        </a>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700">
        {{ session('success') }}
    </div>
    @endif

    <!-- Templates Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($templates as $template)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">{{ $template->name }}</h3>
                        <p class="text-sm text-slate-500 mt-1">{{ $template->items_count }} item</p>
                    </div>
                    <div class="h-10 w-10 bg-indigo-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5z" />
                        </svg>
                    </div>
                </div>
                @if($template->description)
                <p class="text-sm text-slate-600 mt-3 line-clamp-2">{{ $template->description }}</p>
                @endif
            </div>
            <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('templates.show', $template) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                    Lihat Detail
                </a>
                <div class="flex items-center gap-2">
                    <a href="{{ route('templates.edit', $template) }}" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </a>
                    <a href="{{ route('requests.create', ['template_id' => $template->id]) }}" class="p-2 text-green-500 hover:text-green-700 transition-colors" title="Buat Request">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5z" />
            </svg>
            <p class="mt-4 text-slate-500">Belum ada template</p>
            <a href="{{ route('templates.create') }}" class="mt-2 inline-block text-sm font-medium text-indigo-600 hover:text-indigo-800">
                + Buat Template Pertama
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($templates->hasPages())
    <div class="mt-6">
        {{ $templates->links() }}
    </div>
    @endif
</x-app-layout>
