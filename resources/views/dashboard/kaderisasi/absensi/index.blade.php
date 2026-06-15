@extends('layouts.dashboard')

@section('title', 'Manajemen Absensi')

@section('content')

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <h1 class="font-display font-bold text-2xl" style="color: var(--dp-text-primary);">Manajemen Absensi</h1>
    <a href="{{ route('dashboard.kaderisasi.absensi.create') }}"
       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg text-sm font-bold shrink-0 transition-colors"
       style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);"
       onmouseover="this.style.background='var(--dp-bg-primary-hover)'"
       onmouseout="this.style.background='var(--dp-bg-primary)'">
        <span class="material-symbols-outlined text-lg">add</span>
        Buat Sesi Baru
    </a>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
    @php
        $statItems = [
            ['label' => 'Total Sesi',      'value' => $stats['total'],       'icon' => 'event_note',    'tint' => 'var(--dp-primary-tint)',  'color' => 'var(--dp-bg-primary)'],
            ['label' => 'Sesi Aktif',       'value' => $stats['aktif'],       'icon' => 'radio_button_checked', 'tint' => 'rgba(8,51,44,0.10)', 'color' => 'var(--dp-status-done)'],
            ['label' => 'Sesi Selesai',     'value' => $stats['selesai'],     'icon' => 'check_circle',  'tint' => 'var(--dp-gold-tint)',     'color' => 'var(--dp-gold)'],
            ['label' => 'Total Kehadiran',  'value' => $stats['total_hadir'], 'icon' => 'groups',        'tint' => 'var(--dp-primary-tint)',  'color' => 'var(--dp-bg-primary)'],
        ];
    @endphp
    @foreach($statItems as $s)
        <div class="rounded-xl p-5" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-lg flex items-center justify-center"
                     style="background: {{ $s['tint'] }}; color: {{ $s['color'] }};">
                    <span class="material-symbols-outlined text-xl">{{ $s['icon'] }}</span>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-wider font-semibold" style="color: var(--dp-text-secondary);">{{ $s['label'] }}</p>
                    <h3 class="font-display text-2xl font-bold" style="color: var(--dp-text-primary);">{{ $s['value'] }}</h3>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- Filter Toolbar --}}
<div class="flex flex-col lg:flex-row lg:items-center gap-3 mb-5">
    <form method="GET" action="{{ route('dashboard.kaderisasi.absensi.index') }}"
          class="flex flex-col sm:flex-row gap-2 flex-1">
        <input type="text" name="q" value="{{ request('q') }}"
               placeholder="Cari judul sesi..."
               class="flex-1 px-4 py-2.5 rounded-lg text-sm outline-none transition-colors"
               style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border); color: var(--dp-text-primary);"
               onfocus="this.style.borderColor='var(--dp-gold)'"
               onblur="this.style.borderColor='var(--dp-border)'">

        <select name="jenis"
                class="px-3 py-2.5 rounded-lg text-sm outline-none"
                style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
            <option value="">Semua Jenis</option>
            <option value="rapat_rutin" {{ request('jenis') === 'rapat_rutin' ? 'selected' : '' }}>Rapat Rutin</option>
            <option value="rapat_departemen" {{ request('jenis') === 'rapat_departemen' ? 'selected' : '' }}>Rapat Departemen</option>
            <option value="rapat_panitia" {{ request('jenis') === 'rapat_panitia' ? 'selected' : '' }}>Rapat Panitia</option>
            <option value="pelaksanaan" {{ request('jenis') === 'pelaksanaan' ? 'selected' : '' }}>Pelaksanaan Kegiatan</option>
            <option value="rapat_pac" {{ request('jenis') === 'rapat_pac' ? 'selected' : '' }}>Rapat PAC</option>
            <option value="rapat_lembaga" {{ request('jenis') === 'rapat_lembaga' ? 'selected' : '' }}>Rapat Lembaga</option>
            <option value="rapat_badan" {{ request('jenis') === 'rapat_badan' ? 'selected' : '' }}>Rapat Badan</option>
        </select>

        <select name="status"
                class="px-3 py-2.5 rounded-lg text-sm outline-none"
                style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
            <option value="">Semua Status</option>
            <option value="buka" {{ request('status') === 'buka' ? 'selected' : '' }}>Aktif</option>
            <option value="tutup" {{ request('status') === 'tutup' ? 'selected' : '' }}>Selesai</option>
        </select>

        <button type="submit"
                class="px-4 py-2.5 rounded-lg text-sm font-semibold transition-colors"
                style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
            Filter
        </button>

        @if(request()->hasAny(['q', 'jenis', 'status']))
            <a href="{{ route('dashboard.kaderisasi.absensi.index') }}"
               class="px-4 py-2.5 rounded-lg text-sm font-semibold text-center transition-colors"
               style="background: var(--dp-danger-tint); border: 1px solid var(--dp-danger); color: var(--dp-danger);">
                Reset
            </a>
        @endif
    </form>
</div>

{{-- Alert --}}
@if(session('success'))
    <div class="mb-4 px-4 py-3 rounded-lg flex items-center gap-3 text-sm"
         style="background: var(--dp-primary-tint); border: 1px solid var(--dp-border-strong); color: var(--dp-text-primary);">
        <span class="material-symbols-outlined text-lg shrink-0" style="color: var(--dp-status-done);">check_circle</span>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 px-4 py-3 rounded-lg flex items-center gap-3 text-sm"
         style="background: var(--dp-danger-tint); border: 1px solid var(--dp-danger); color: var(--dp-danger);">
        <span class="material-symbols-outlined text-lg shrink-0">error</span>
        {{ session('error') }}
    </div>
@endif

{{-- Session List --}}
<div class="space-y-3">
    @forelse($sesiList as $sesi)
        @php
            $jenisLabels = [
                'rapat_rutin' => 'Rapat Rutin',
                'rapat_departemen' => 'Rapat Departemen',
                'rapat_panitia' => 'Rapat Panitia',
                'pelaksanaan' => 'Pelaksanaan Kegiatan',
                'rapat_pac' => 'Rapat PAC',
                'rapat_lembaga' => 'Rapat Lembaga',
                'rapat_badan' => 'Rapat Badan',
            ];
            $jenisIcons = [
                'rapat_rutin' => 'groups',
                'rapat_departemen' => 'meeting_room',
                'rapat_panitia' => 'diversity_3',
                'pelaksanaan' => 'event_available',
                'rapat_pac' => 'account_tree',
                'rapat_lembaga' => 'corporate_fare',
                'rapat_badan' => 'domain',
            ];
            $isOpen = $sesi->status === 'buka';
            $hadirCount = $sesi->records->where('status_kehadiran', 'hadir')->count();
        @endphp

        <div class="rounded-xl p-4 lg:p-5 transition-colors"
             style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);"
             onmouseover="this.style.borderColor='var(--dp-border-strong)'"
             onmouseout="this.style.borderColor='var(--dp-border)'">
            <div class="flex flex-col lg:flex-row lg:items-center gap-4">

                {{-- Left: Icon + Info --}}
                <div class="flex items-start gap-3.5 flex-1 min-w-0">
                    <div class="w-11 h-11 rounded-lg flex items-center justify-center shrink-0"
                         style="background: var(--dp-primary-tint); color: var(--dp-bg-primary);">
                        <span class="material-symbols-outlined text-xl">{{ $jenisIcons[$sesi->jenis] ?? 'event_note' }}</span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="font-display font-bold text-sm lg:text-base leading-tight line-clamp-1 mb-1"
                            style="color: var(--dp-text-primary);">
                            {{ $sesi->judul }}
                        </h3>
                        <div class="text-xs flex items-center gap-2 flex-wrap" style="color: var(--dp-text-secondary);">
                            @if($sesi->departemen)
                                <span>{{ $sesi->departemen->nama }}</span>
                                <span>·</span>
                            @endif
                            <span>{{ $sesi->creator->name ?? '-' }}</span>
                            <span>·</span>
                            <span>{{ $sesi->tanggal ? \Carbon\Carbon::parse($sesi->tanggal)->format('d M Y H:i') : '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Center: Badges --}}
                <div class="flex items-center gap-2 shrink-0">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider"
                          style="background: var(--dp-bg-surface-2); color: var(--dp-text-secondary);">
                        {{ $jenisLabels[$sesi->jenis] ?? $sesi->jenis }}
                    </span>
                    @if($isOpen)
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider"
                              style="background: rgba(8,51,44,0.10); color: var(--dp-status-done);">
                            <span class="w-1.5 h-1.5 rounded-full animate-pulse" style="background: var(--dp-status-done);"></span>
                            Aktif
                        </span>
                    @else
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider"
                              style="background: var(--dp-gold-tint); color: var(--dp-gold);">
                            Selesai
                        </span>
                    @endif
                </div>

                {{-- Right: Count + Actions --}}
                <div class="flex items-center gap-3 shrink-0">
                    <div class="flex items-center gap-1.5 text-sm font-semibold" style="color: var(--dp-text-primary);">
                        <span class="material-symbols-outlined text-lg" style="color: var(--dp-status-done);">how_to_reg</span>
                        {{ $hadirCount }}
                    </div>

                    <div class="flex items-center gap-0.5">
                        <a href="{{ route('dashboard.kaderisasi.absensi.show', $sesi->id) }}"
                           title="Lihat Detail"
                           class="p-2 rounded-lg transition-colors"
                           style="color: var(--dp-text-secondary);"
                           onmouseover="this.style.background='var(--dp-primary-tint)'; this.style.color='var(--dp-bg-primary)'"
                           onmouseout="this.style.background='transparent'; this.style.color='var(--dp-text-secondary)'">
                            <span class="material-symbols-outlined text-lg">visibility</span>
                        </a>

                        <form action="{{ route('dashboard.kaderisasi.absensi.destroy', $sesi->id) }}" method="POST"
                              onsubmit="return confirm('Hapus sesi absensi ini secara permanen?');">
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

            </div>
        </div>
    @empty
        <div class="rounded-xl overflow-hidden" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
            <div class="flex flex-col items-center justify-center py-20 text-center px-4">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4"
                     style="background: var(--dp-bg-surface-2);">
                    <span class="material-symbols-outlined text-3xl" style="color: var(--dp-text-secondary);">qr_code_scanner</span>
                </div>
                <div class="font-display font-bold text-lg mb-1" style="color: var(--dp-text-primary);">
                    Belum ada sesi absensi
                </div>
                <div class="text-sm mb-5" style="color: var(--dp-text-secondary);">
                    @if(request()->hasAny(['q', 'jenis', 'status']))
                        Tidak ada sesi yang cocok dengan filter.
                    @else
                        Mulai dengan membuat sesi absensi pertama.
                    @endif
                </div>
                @if(request()->hasAny(['q', 'jenis', 'status']))
                    <a href="{{ route('dashboard.kaderisasi.absensi.index') }}"
                       class="text-sm font-semibold px-4 py-2 rounded-lg"
                       style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
                        Hapus Filter
                    </a>
                @else
                    <a href="{{ route('dashboard.kaderisasi.absensi.create') }}"
                       class="text-sm font-bold px-5 py-2.5 rounded-lg"
                       style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);">
                        Buat Sesi Baru
                    </a>
                @endif
            </div>
        </div>
    @endforelse
</div>

{{-- Pagination --}}
@if($sesiList->hasPages())
    <div class="mt-5">
        {{ $sesiList->appends(request()->query())->links('pagination::tailwind') }}
    </div>
@endif

@endsection
