@php
    $isAnggotaGroup = $node->children->contains(function ($child) {
        return \Illuminate\Support\Str::contains($child->jabatan, 'Anggota');
    });
@endphp

<li class="{{ $isAnggotaGroup ? '!p-0 !float-none' : '' }}">
    <div class="card-node group {{ $isAnggotaGroup ? '!mb-4' : '' }}" @click="activePerson = { 
            name: '{{ $node->kader->nama_lengkap }}', 
            role: '{{ $node->jabatan }}', 
            image: '{{ $node->kader->foto_path ? asset('storage/' . $node->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($node->kader->nama_lengkap) . '&background=' . ($color === 'amber' ? 'f59e0b' : '10b981') . '&color=fff' }}', 
            quote: '{{ $node->kader->quote ?? '' }}' 
         }; modalOpen = true;">

        <div class="photo-wrapper {{ $color === 'amber' ? '!border-amber-50 !shadow-amber-500 group-hover:!shadow-amber-200' : '' }}"
            style="{{ $color === 'amber' ? 'box-shadow: 0 0 0 1px #f59e0b;' : '' }}">
            <img src="{{ $node->kader->foto_path ? asset('storage/' . $node->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($node->kader->nama_lengkap) . '&background=' . ($color === 'amber' ? 'f59e0b' : '10b981') . '&color=fff' }}"
                alt="Foto">
        </div>

        <span
            class="role-badge {{ $color === 'amber' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700' }}">
            {{ $node->jabatan }}
        </span>

        <div class="name-text">{{ \Illuminate\Support\Str::words($node->kader->nama_lengkap, 2, '') }}</div>
    </div>

    @if($node->children->isNotEmpty())
        <ul class="{{ $isAnggotaGroup ? '!flex-col !items-center !pt-4 !pl-0 relative' : '' }}">
            <!-- Custom Line for Vertical Stack -->
            @if($isAnggotaGroup)
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-0.5 h-4 bg-slate-300"></div>
            @endif

            @foreach($node->children as $child)
                @include('partials.tree-node', ['node' => $child, 'color' => $color])
            @endforeach
        </ul>
    @endif
</li>