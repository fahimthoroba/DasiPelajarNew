<div class="card-node group" @click="activePerson = { 
        name: '{{ $node->kader->nama_lengkap }}', 
        role: '{{ $node->jabatan }}', 
        image: '{{ $node->kader->foto_path ? asset('storage/' . $node->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($node->kader->nama_lengkap) . '&background=' . ($tab === 'ippnu' ? 'f59e0b' : '10b981') . '&color=fff' }}', 
        quote: '{{ $node->kader->quote ?? '' }}',
        roleClass: '{{ $tab === 'ippnu' ? 'bg-amber-500' : 'bg-emerald-600' }}'
    }; modalOpen = true;">

    <div class="photo-wrapper {{ $tab === 'ippnu' ? '!border-amber-50 !shadow-amber-500 group-hover:!shadow-amber-200' : '' }}"
        style="{{ $tab === 'ippnu' ? 'box-shadow: 0 0 0 1px #f59e0b;' : '' }}">
        <img src="{{ $node->kader->foto_path ? asset('storage/' . $node->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($node->kader->nama_lengkap) . '&background=' . ($tab === 'ippnu' ? 'f59e0b' : '10b981') . '&color=fff' }}"
            alt="Foto">
    </div>
    <span
        class="role-badge {{ $tab === 'ippnu' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700' }}">{{ $node->jabatan_lengkap }}</span>
    <div class="name-text text-center">{{ \Illuminate\Support\Str::words($node->kader->nama_lengkap, 2, '') }}</div>
</div>