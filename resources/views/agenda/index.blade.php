<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agenda & Program Kerja - PC IPNU IPPNU Kediri</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Outfit:wght@400;700;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .status-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }
        .timeline-line { position: absolute; left: 19px; top: 40px; bottom: 0; width: 2px; background: var(--dp-border-strong); }
    </style>

    @include('partials.theme-init')
</head>

<body class="font-body antialiased transition-colors duration-300"
    style="background: var(--dp-bg-page); color: var(--dp-text-primary);">

    @include('partials.navbar')

    {{-- Hero --}}
    <section class="pt-28 pb-12" style="background: var(--dp-bg-primary);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="text-xs font-bold uppercase tracking-widest mb-3 block"
                style="color: var(--dp-gold);">Jadwal & Program</span>
            <h1 class="font-display font-black text-3xl md:text-5xl mb-4"
                style="color: var(--dp-text-on-primary);">
                Agenda Kegiatan
            </h1>
            <p class="text-base md:text-lg max-w-2xl mx-auto" style="color: var(--dp-text-on-primary); opacity: 0.7;">
                Jadwal lengkap kegiatan dan program kerja PC IPNU IPPNU Kabupaten Kediri.
            </p>
        </div>
    </section>

    {{-- Stat cards --}}
    <section class="-mt-6 relative z-10 mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @php
                $now = now()->startOfDay();
                $upcoming = $agendas->filter(fn($a) => \Carbon\Carbon::parse($a->tgl_pelaksanaan)->startOfDay()->gte($now));
                $done = $agendas->filter(fn($a) => $a->status_lpj === 'Terverifikasi');
                $pending = $agendas->filter(fn($a) => \Carbon\Carbon::parse($a->tgl_pelaksanaan)->startOfDay()->lt($now) && $a->status_lpj !== 'Terverifikasi');
            @endphp
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="rounded-lg p-4 text-center" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                    <div class="font-display font-black text-2xl" style="color: var(--dp-text-primary);">{{ $agendas->count() }}</div>
                    <div class="text-xs font-medium mt-1" style="color: var(--dp-text-secondary);">Total Program</div>
                </div>
                <div class="rounded-lg p-4 text-center" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                    <div class="font-display font-black text-2xl" style="color: var(--dp-gold);">{{ $upcoming->count() }}</div>
                    <div class="text-xs font-medium mt-1" style="color: var(--dp-text-secondary);">Akan Datang</div>
                </div>
                <div class="rounded-lg p-4 text-center" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                    <div class="font-display font-black text-2xl" style="color: var(--dp-status-done);">{{ $done->count() }}</div>
                    <div class="text-xs font-medium mt-1" style="color: var(--dp-text-secondary);">Terlaksana</div>
                </div>
                <div class="rounded-lg p-4 text-center" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                    <div class="font-display font-black text-2xl" style="color: var(--dp-danger);">{{ $pending->count() }}</div>
                    <div class="text-xs font-medium mt-1" style="color: var(--dp-text-secondary);">Menunggu LPJ</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Main content --}}
    <section class="pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">

                {{-- Timeline cards --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between mb-6"
                        style="border-top: 3px solid var(--dp-bg-primary); padding-top: 0.75rem;">
                        <h2 class="font-display font-bold text-xl" style="color: var(--dp-text-primary);">
                            Daftar Kegiatan
                        </h2>
                        <span class="text-sm" style="color: var(--dp-text-secondary);">
                            {{ $agendas->count() }} program
                        </span>
                    </div>

                    @forelse($agendas as $agenda)
                        @php
                            $tgl = \Carbon\Carbon::parse($agenda->tgl_pelaksanaan)->startOfDay();
                            $now = now()->startOfDay();

                            if ($agenda->status_lpj === 'Terverifikasi') {
                                $statusLabel = 'Terlaksana';
                                $statusColor = 'var(--dp-status-done)';
                                $statusBg = 'var(--dp-primary-tint)';
                                $icon = 'check_circle';
                            } elseif ($tgl->equalTo($now)) {
                                $statusLabel = 'Hari Ini';
                                $statusColor = 'var(--dp-gold)';
                                $statusBg = 'var(--dp-gold-tint)';
                                $icon = 'play_circle';
                            } elseif ($tgl->gt($now)) {
                                $statusLabel = 'Akan Datang';
                                $statusColor = 'var(--dp-gold)';
                                $statusBg = 'var(--dp-gold-tint)';
                                $icon = 'schedule';
                            } else {
                                $statusLabel = 'Menunggu LPJ';
                                $statusColor = 'var(--dp-danger)';
                                $statusBg = 'var(--dp-danger-tint)';
                                $icon = 'pending';
                            }
                        @endphp

                        <div class="rounded-lg p-5 mb-4 transition-shadow hover:shadow-md"
                            style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                            <div class="flex flex-col sm:flex-row sm:items-start gap-4">
                                {{-- Date block --}}
                                <div class="shrink-0 w-16 text-center rounded-lg py-2"
                                    style="background: var(--dp-bg-primary);">
                                    <div class="font-display font-black text-xl leading-none" style="color: var(--dp-text-on-primary);">
                                        {{ $tgl->format('d') }}
                                    </div>
                                    <div class="text-[10px] uppercase tracking-wider font-bold mt-1" style="color: var(--dp-gold);">
                                        {{ $tgl->translatedFormat('M Y') }}
                                    </div>
                                </div>

                                {{-- Content --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2 mb-2">
                                        <h3 class="font-display font-bold text-base" style="color: var(--dp-text-primary);">
                                            {{ $agenda->nama_proker }}
                                        </h3>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider"
                                            style="background: {{ $statusBg }}; color: {{ $statusColor }};">
                                            <span class="material-symbols-outlined" style="font-size: 12px;">{{ $icon }}</span>
                                            {{ $statusLabel }}
                                        </span>
                                    </div>

                                    @if($agenda->deskripsi_kegiatan)
                                    <p class="text-sm mb-3 line-clamp-2" style="color: var(--dp-text-secondary);">
                                        {{ $agenda->deskripsi_kegiatan }}
                                    </p>
                                    @endif

                                    <div class="flex flex-wrap items-center gap-4 text-xs" style="color: var(--dp-text-secondary);">
                                        @if($agenda->lokasi)
                                        <span class="flex items-center gap-1">
                                            <span class="material-symbols-outlined" style="font-size: 14px;">location_on</span>
                                            {{ $agenda->lokasi }}
                                        </span>
                                        @endif
                                        @if($agenda->penanggung_jawab)
                                        <span class="flex items-center gap-1">
                                            <span class="material-symbols-outlined" style="font-size: 14px;">person</span>
                                            {{ $agenda->penanggung_jawab }}
                                        </span>
                                        @endif
                                        @if($tgl->gt($now))
                                        <span class="flex items-center gap-1 font-semibold" style="color: var(--dp-gold);">
                                            <span class="material-symbols-outlined" style="font-size: 14px;">timer</span>
                                            {{ (int) $now->diffInDays($tgl) }} hari lagi
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16 rounded-lg"
                            style="background: var(--dp-bg-surface); border: 1px dashed var(--dp-border-strong);">
                            <span class="material-symbols-outlined text-4xl mb-3 block" style="color: var(--dp-text-secondary);">event_busy</span>
                            <h3 class="font-display font-bold text-lg mb-1" style="color: var(--dp-text-primary);">Belum Ada Agenda</h3>
                            <p class="text-sm" style="color: var(--dp-text-secondary);">Data program kerja belum tersedia.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Sidebar --}}
                <aside class="w-full lg:w-72 shrink-0 space-y-6">
                    {{-- Agenda Terdekat --}}
                    @if($upcoming->count())
                    <div class="rounded-lg p-4" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                        <h3 class="font-display font-bold text-base mb-4 pb-2"
                            style="color: var(--dp-text-primary); border-bottom: 2px solid var(--dp-gold);">
                            Agenda Terdekat
                        </h3>
                        <div class="space-y-3">
                            @foreach($upcoming->sortBy('tgl_pelaksanaan')->take(5) as $up)
                            <div class="flex gap-3 items-start">
                                <div class="shrink-0 w-10 text-center rounded py-1"
                                    style="background: var(--dp-gold-tint);">
                                    <div class="font-display font-bold text-sm leading-none" style="color: var(--dp-gold);">
                                        {{ \Carbon\Carbon::parse($up->tgl_pelaksanaan)->format('d') }}
                                    </div>
                                    <div class="text-[8px] uppercase font-bold" style="color: var(--dp-text-secondary);">
                                        {{ \Carbon\Carbon::parse($up->tgl_pelaksanaan)->translatedFormat('M') }}
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold leading-tight" style="color: var(--dp-text-primary);">
                                        {{ $up->nama_proker }}
                                    </h4>
                                    <span class="text-xs" style="color: var(--dp-text-secondary);">
                                        {{ $up->lokasi ?? 'Belum ditentukan' }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Status legend --}}
                    <div class="rounded-lg p-4" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                        <h3 class="font-display font-bold text-base mb-4 pb-2"
                            style="color: var(--dp-text-primary); border-bottom: 2px solid var(--dp-gold);">
                            Keterangan Status
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex items-center gap-2">
                                <span class="status-dot" style="background: var(--dp-status-done);"></span>
                                <span style="color: var(--dp-text-primary);">Terlaksana</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="status-dot" style="background: var(--dp-status-on);"></span>
                                <span style="color: var(--dp-text-primary);">Akan Datang / Hari Ini</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="status-dot" style="background: var(--dp-status-fail);"></span>
                                <span style="color: var(--dp-text-primary);">Menunggu LPJ</span>
                            </div>
                        </div>
                    </div>

                    {{-- Info box --}}
                    <div class="rounded-lg p-4" style="background: var(--dp-gold-tint); border: 1px solid var(--dp-border-gold);">
                        <div class="flex gap-3">
                            <span class="material-symbols-outlined shrink-0" style="color: var(--dp-gold);">info</span>
                            <p class="text-xs leading-relaxed" style="color: var(--dp-text-primary);">
                                Program kerja dikelola oleh masing-masing departemen dan lembaga PC IPNU IPPNU Kab. Kediri.
                                Realisasi dilaporkan melalui sistem LPJ digital.
                            </p>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    @include('partials.footer')
</body>

</html>
