@php
    $theme = $theme ?? 'emerald';

    // Determine colors based on theme (IPNU vs IPPNU)
    // We utilize Tailwind classes that we can switch based on theme,
    // but the card background itself is handled by CSS variables for light/dark mode.

    $textColor = $theme === 'yellow' ? 'text-yellow-600 dark:text-yellow-500' : 'text-emerald-600 dark:text-primary';
    $borderColorName = $theme === 'yellow' ? 'border-yellow-500' : 'border-emerald-500';
    $hoverBorder = $theme === 'yellow' ? 'hover:border-yellow-500' : 'hover:border-emerald-500';
@endphp

<li>
    <div class="card-node {{ $hoverBorder }} group" @click="selected = { 
            nama: '{{ $node->kader->nama_lengkap }}', 
            jabatan: '{{ $node->jabatan }}', 
            foto: '{{ $node->kader->foto_path ? asset('storage/' . $node->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($node->kader->nama_lengkap) }}', 
            quote: '{{ $node->kader->quote }}'
        }; open = true">
        <div
            class="w-16 h-16 mx-auto rounded-full overflow-hidden border-2 {{ $borderColorName }} mb-2 group-hover:scale-110 transition-transform duration-300 bg-gray-100 dark:bg-gray-800">
            <img src="{{ $node->kader->foto_path ? asset('storage/' . $node->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($node->kader->nama_lengkap) }}"
                class="w-full h-full object-cover">
        </div>
        <div class="text-center">
            <h5
                class="text-xs font-bold line-clamp-1 group-hover:{{ $theme === 'yellow' ? 'text-yellow-400' : 'text-emerald-400' }} dark:group-hover:text-primary transition-colors">
                {{ $node->kader->nama_lengkap }}
            </h5>
            <p class="text-[10px] {{ $textColor }} uppercase tracking-wider line-clamp-1 font-bold">{{ $node->jabatan }}
            </p>
        </div>
    </div>

    @php
        // Find children of this node from the collection
        $children = $all->where('parent_id', $node->id);
    @endphp

    @if($children->count() > 0)
        <ul>
            @foreach($children as $child)
                @include('partials.org-node', ['node' => $child, 'all' => $all, 'theme' => $theme])
            @endforeach
        </ul>
    @endif
</li>