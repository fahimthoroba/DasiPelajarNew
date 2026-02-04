@foreach($nodes as $node)
    <div class="relative pl-4 border-l-2 border-gray-100 dark:border-gray-800 ml-2 mt-4">
        <div
            class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-white/5 p-4 shadow-sm flex items-center gap-4 relative">
            <!-- Connector Line -->
            <div class="absolute w-4 h-0.5 bg-gray-100 dark:bg-gray-800 -left-6 top-1/2"></div>

            <img src="{{ $node->kader->foto_path ? asset('storage/' . $node->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($node->kader->nama_lengkap) . '&background=random&color=fff' }}"
                class="w-12 h-12 rounded-full object-cover ring-2 ring-emerald-50 dark:ring-white/5">
            <div>
                <h4 class="font-bold text-gray-900 dark:text-white text-sm">{{ $node->kader->nama_lengkap }}</h4>
                <p
                    class="text-[10px] font-bold uppercase tracking-wider {{ str_contains($node->jabatan, 'IPPNU') ? 'text-amber-600' : 'text-emerald-600 dark:text-emerald-400' }}">
                    {{ $node->jabatan }}
                </p>
            </div>
        </div>

        @if($node->children && $node->children->count() > 0)
            <div class="mt-2">
                @include('partials.mobile-node', ['nodes' => $node->children])
            </div>
        @endif
    </div>
@endforeach