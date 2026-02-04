<div class="card-node card-node-small group hover:bg-gray-50" @click="activePerson = { 
        name: '{{ $node->kader->nama_lengkap }}', 
        role: '{{ $node->jabatan }}', 
        image: '{{ $node->kader->foto_path ? asset('storage/' . $node->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($node->kader->nama_lengkap) . '&background=' . ($tab === 'ippnu' ? 'f59e0b' : '10b981') . '&color=fff' }}', 
        quote: '{{ $node->kader->quote ?? '' }}',
        roleClass: '{{ $tab === 'ippnu' ? 'bg-amber-500' : 'bg-emerald-600' }}'
    }; modalOpen = true;">

    <div class="photo-wrapper {{ $tab === 'ippnu' ? '!border-amber-50 !shadow-amber-500' : '' }}">
        <img src="{{ $node->kader->foto_path ? asset('storage/' . $node->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($node->kader->nama_lengkap) . '&background=' . ($tab === 'ippnu' ? 'f59e0b' : '10b981') . '&color=fff' }}"
            alt="Foto">
    </div>
    <div>
        <div class="name-text text-left">{{ \Illuminate\Support\Str::words($node->kader->nama_lengkap, 3, '') }}</div>
        <span
            class="text-[9px] text-gray-400 font-bold uppercase tracking-wider">{{ $role ?? $node->jabatan_lengkap }}</span>
    </div>
</div>