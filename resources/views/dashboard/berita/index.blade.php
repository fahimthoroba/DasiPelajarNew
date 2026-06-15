@extends('layouts.dashboard')

@section('title', 'Manajemen Berita')

@section('content')

{{-- Stats Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
    @php
        $statItems = [
            ['label' => 'Total Berita', 'value' => $stats['total'],     'color' => 'var(--dp-text-primary)'],
            ['label' => 'Published',    'value' => $stats['published'], 'color' => 'var(--dp-status-done)'],
            ['label' => 'Draft',        'value' => $stats['draft'],     'color' => 'var(--dp-gold)'],
            ['label' => 'Arsip',        'value' => $stats['archived'],  'color' => 'var(--dp-text-secondary)'],
        ];
    @endphp
    @foreach($statItems as $s)
        <div class="rounded-xl px-4 py-4" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
            <div class="text-[10px] uppercase tracking-widest font-semibold mb-2" style="color: var(--dp-text-secondary);">
                {{ $s['label'] }}
            </div>
            <div class="text-3xl font-bold font-display leading-none" style="color: {{ $s['color'] }};">
                {{ $s['value'] }}
            </div>
        </div>
    @endforeach
</div>

{{-- Toolbar --}}
<div class="flex flex-col lg:flex-row lg:items-center gap-3 mb-5">
    <form method="GET" action="{{ route('dashboard.berita.index') }}"
          class="flex flex-col sm:flex-row gap-2 flex-1">
        <input type="text" name="q" value="{{ request('q') }}"
               placeholder="Cari judul berita..."
               class="flex-1 px-4 py-2.5 rounded-lg text-sm outline-none transition-colors"
               style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border); color: var(--dp-text-primary);"
               onfocus="this.style.borderColor='var(--dp-gold)'"
               onblur="this.style.borderColor='var(--dp-border)'">

        <select name="status"
                class="px-3 py-2.5 rounded-lg text-sm outline-none"
                style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
            <option value="">Semua Status</option>
            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
            <option value="draft"     {{ request('status') === 'draft'     ? 'selected' : '' }}>Draft</option>
            <option value="archived"  {{ request('status') === 'archived'  ? 'selected' : '' }}>Arsip</option>
        </select>

        <select name="kategori"
                class="px-3 py-2.5 rounded-lg text-sm outline-none"
                style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
            <option value="">Semua Kategori</option>
            @foreach($kategoris as $k)
                <option value="{{ $k->id }}" {{ request('kategori') == $k->id ? 'selected' : '' }}>
                    {{ $k->nama }}
                </option>
            @endforeach
        </select>

        <button type="submit"
                class="px-4 py-2.5 rounded-lg text-sm font-semibold transition-colors"
                style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
            Filter
        </button>

        @if(request()->hasAny(['q', 'status', 'kategori']))
            <a href="{{ route('dashboard.berita.index') }}"
               class="px-4 py-2.5 rounded-lg text-sm font-semibold text-center transition-colors"
               style="background: var(--dp-danger-tint); border: 1px solid var(--dp-danger); color: var(--dp-danger);">
                Reset
            </a>
        @endif
    </form>

    <a href="{{ route('dashboard.berita.create') }}"
       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg text-sm font-bold shrink-0 transition-colors"
       style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);"
       onmouseover="this.style.background='var(--dp-bg-primary-hover)'"
       onmouseout="this.style.background='var(--dp-bg-primary)'">
        <span class="material-symbols-outlined text-lg">add</span>
        Tulis Berita
    </a>
</div>

{{-- Alert --}}
@if(session('success'))
    <div class="mb-4 px-4 py-3 rounded-lg flex items-center gap-3 text-sm"
         style="background: var(--dp-primary-tint); border: 1px solid var(--dp-border-strong); color: var(--dp-text-primary);">
        <span class="material-symbols-outlined text-lg shrink-0" style="color: var(--dp-status-done);">check_circle</span>
        {{ session('success') }}
    </div>
@endif

{{-- Berita List --}}
<div class="rounded-xl overflow-hidden" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">

    {{-- Table header --}}
    <div class="hidden lg:grid grid-cols-[2fr_1fr_auto_auto] items-center px-5 py-3 text-[10px] font-bold uppercase tracking-widest"
         style="background: var(--dp-bg-surface-2); border-bottom: 1px solid var(--dp-border); color: var(--dp-text-secondary);">
        <span>Berita</span>
        <span>Kategori & Penulis</span>
        <span>Status</span>
        <span class="text-right pr-1">Aksi</span>
    </div>

    @forelse($beritas as $berita)
        <div class="flex items-start gap-4 px-4 py-4 transition-colors"
             style="border-bottom: 1px solid var(--dp-border);"
             onmouseover="this.style.background='var(--dp-primary-tint)'"
             onmouseout="this.style.background='transparent'">

            {{-- Thumbnail --}}
            <div class="w-20 h-14 lg:w-24 lg:h-16 rounded-lg overflow-hidden shrink-0"
                 style="background: var(--dp-bg-surface-2);">
                @if($berita->thumbnail)
                    <img src="{{ asset('storage/' . $berita->thumbnail) }}"
                         class="w-full h-full object-cover" alt="{{ $berita->judul }}">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-2xl"
                              style="color: var(--dp-border-strong);">image</span>
                    </div>
                @endif
            </div>

            {{-- Content --}}
            <div class="flex-1 min-w-0">
                {{-- Badges --}}
                <div class="flex items-center gap-1.5 flex-wrap mb-1.5">
                    @php
                        $statusStyle = match($berita->status) {
                            'published' => 'background:rgba(8,51,44,0.10);color:var(--dp-status-done)',
                            'draft'     => 'background:rgba(186,158,111,0.15);color:var(--dp-gold)',
                            default     => 'background:var(--dp-bg-surface-2);color:var(--dp-text-secondary)',
                        };
                        $statusLabel = match($berita->status) {
                            'published' => 'Published',
                            'draft'     => 'Draft',
                            default     => 'Arsip',
                        };
                    @endphp
                    <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded"
                          style="{{ $statusStyle }}">{{ $statusLabel }}</span>

                    @if($berita->is_headline)
                        <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded"
                              style="background:rgba(186,158,111,0.20); color:var(--dp-gold);">
                            ★ Headline
                        </span>
                    @endif

                    @if($berita->jenis && $berita->jenis !== 'berita')
                        <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded"
                              style="background: var(--dp-bg-surface-2); color: var(--dp-text-secondary);">
                            {{ $berita->jenis }}
                        </span>
                    @endif
                </div>

                {{-- Judul --}}
                <div class="font-display font-bold text-sm lg:text-base leading-tight line-clamp-1 mb-1"
                     style="color: var(--dp-text-primary);">
                    {{ $berita->judul }}
                </div>

                {{-- Meta --}}
                <div class="text-xs flex items-center gap-2 flex-wrap" style="color: var(--dp-text-secondary);">
                    <span>{{ $berita->kategori->nama ?? 'Tanpa Kategori' }}</span>
                    <span>·</span>
                    <span>{{ $berita->user->name ?? '-' }}</span>
                    <span>·</span>
                    <span>{{ $berita->created_at->format('d M Y') }}</span>
                    @if($berita->views)
                        <span>·</span>
                        <span>{{ number_format($berita->views) }} views</span>
                    @endif
                </div>

                {{-- Tags --}}
                @if($berita->tags->isNotEmpty())
                    <div class="flex gap-1 flex-wrap mt-1.5">
                        @foreach($berita->tags as $tag)
                            <span class="text-[10px] px-1.5 py-0.5 rounded"
                                  style="background: var(--dp-gold-tint); color: var(--dp-gold);">
                                #{{ $tag->nama }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-0.5 shrink-0">
                @if($berita->status === 'published')
                    <a href="{{ route('berita.show', $berita->slug) }}" target="_blank"
                       title="Lihat di website"
                       class="p-2 rounded-lg transition-colors"
                       style="color: var(--dp-text-secondary);"
                       onmouseover="this.style.background='var(--dp-primary-tint)'; this.style.color='var(--dp-bg-primary)'"
                       onmouseout="this.style.background='transparent'; this.style.color='var(--dp-text-secondary)'">
                        <span class="material-symbols-outlined text-lg">open_in_new</span>
                    </a>
                @endif

                <a href="{{ route('dashboard.berita.edit', $berita) }}"
                   title="Edit"
                   class="p-2 rounded-lg transition-colors"
                   style="color: var(--dp-text-secondary);"
                   onmouseover="this.style.background='var(--dp-primary-tint)'; this.style.color='var(--dp-bg-primary)'"
                   onmouseout="this.style.background='transparent'; this.style.color='var(--dp-text-secondary)'">
                    <span class="material-symbols-outlined text-lg">edit_square</span>
                </a>

                <form action="{{ route('dashboard.berita.destroy', $berita) }}" method="POST"
                      onsubmit="return confirm('Hapus berita ini secara permanen?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            title="Hapus"
                            class="p-2 rounded-lg transition-colors"
                            style="color: var(--dp-text-secondary);"
                            onmouseover="this.style.background='var(--dp-danger-tint)'; this.style.color='var(--dp-danger)'"
                            onmouseout="this.style.background='transparent'; this.style.color='var(--dp-text-secondary)'">
                        <span class="material-symbols-outlined text-lg">delete</span>
                    </button>
                </form>
            </div>

        </div>
    @empty
        <div class="flex flex-col items-center justify-center py-20 text-center px-4">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4"
                 style="background: var(--dp-bg-surface-2);">
                <span class="material-symbols-outlined text-3xl" style="color: var(--dp-text-secondary);">newspaper</span>
            </div>
            <div class="font-display font-bold text-lg mb-1" style="color: var(--dp-text-primary);">
                Belum ada berita
            </div>
            <div class="text-sm mb-5" style="color: var(--dp-text-secondary);">
                @if(request()->hasAny(['q','status','kategori']))
                    Tidak ada berita yang cocok dengan filter.
                @else
                    Mulai dengan menulis berita pertama.
                @endif
            </div>
            @if(request()->hasAny(['q','status','kategori']))
                <a href="{{ route('dashboard.berita.index') }}"
                   class="text-sm font-semibold px-4 py-2 rounded-lg"
                   style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
                    Hapus Filter
                </a>
            @else
                <a href="{{ route('dashboard.berita.create') }}"
                   class="text-sm font-bold px-5 py-2.5 rounded-lg"
                   style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);">
                    Tulis Berita
                </a>
            @endif
        </div>
    @endforelse

    {{-- Pagination --}}
    @if($beritas->hasPages())
        <div class="px-5 py-4" style="border-top: 1px solid var(--dp-border);">
            {{ $beritas->links('pagination::tailwind') }}
        </div>
    @endif

</div>

@endsection
