<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Struktur Organisasi - PC {{ $orgName }} Kab. Kediri</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @php
        $isIppnu = ($tab === 'ippnu');

        // Helper: generate local SVG initials avatar
        function orgAvatar($name, $bg = '#08332c', $color = '#ba9e6f') {
            $initials = collect(explode(' ', $name))->take(2)->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))->join('');
            return "data:image/svg+xml," . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="120" height="120"><rect width="120" height="120" rx="60" fill="'.$bg.'"/><text x="50%" y="54%" dominant-baseline="central" text-anchor="middle" font-size="44" font-weight="700" font-family="sans-serif" fill="'.$color.'">'.$initials.'</text></svg>');
        }

        function personImg($person, $bg = '#08332c', $color = '#ba9e6f') {
            return $person->kader->foto_path
                ? asset('storage/' . $person->kader->foto_path)
                : orgAvatar($person->kader->nama_lengkap, $bg, $color);
        }

        function personData($person) {
            return json_encode([
                'name'  => $person->kader->nama_lengkap,
                'role'  => $person->jabatan_lengkap ?? $person->jabatan,
                'dept'  => $person->departemenData->nama_departemen ?? '',
                'image' => personImg($person),
                'quote' => $person->kader->quote ?? '',
            ]);
        }
    @endphp

    <style>
        /* ========== ORG CHART CONNECTOR LINES ========== */
        .connector-v { width: 2px; background: var(--dp-border-strong); margin: 0 auto; }
        .connector-h { height: 2px; background: var(--dp-border-strong); }
        .dark .connector-v, .dark .connector-h { background: var(--dp-border); }

        /* Card */
        .org-card {
            background: var(--dp-bg-surface);
            border: 1px solid var(--dp-border);
            border-radius: 10px;
            padding: 10px 8px 8px;
            width: 140px;
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            transition: transform 0.2s, border-color 0.2s, box-shadow 0.2s;
            position: relative;
            z-index: 10;
        }
        .org-card:hover {
            transform: translateY(-4px);
            border-color: var(--dp-gold);
            box-shadow: 0 8px 20px -4px rgba(8,51,44,0.12);
        }
        .org-card-sm { width: 126px; padding: 8px 6px 6px; }
        .org-card-xs { width: 118px; padding: 6px 4px 4px; border-style: dashed; }

        .org-photo {
            width: 56px; height: 56px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--dp-gold-tint);
            margin-bottom: 6px;
        }
        .org-photo-lg { width: 68px; height: 68px; border-color: var(--dp-gold); }

        .org-name {
            font-size: 0.7rem; font-weight: 700; line-height: 1.15;
            color: var(--dp-text-primary); text-align: center;
            margin-bottom: 2px;
        }
        .org-role {
            font-size: 0.6rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.04em;
            color: var(--dp-gold); text-align: center;
        }
        .org-dept {
            font-size: 0.55rem; font-weight: 500;
            color: var(--dp-text-secondary); text-align: center;
            margin-top: 1px;
        }

        /* Lembaga card accent */
        .org-card-lembaga {
            background: var(--dp-gold-tint);
            border-color: var(--dp-border-gold);
        }

        /* Section label */
        .section-label {
            display: inline-block;
            font-size: 0.65rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.12em;
            color: var(--dp-text-secondary);
            padding: 4px 14px;
            border: 1px solid var(--dp-border);
            border-radius: 999px;
            background: var(--dp-bg-surface);
        }

        /* Row layout for sm/xs cards (avatar left of name) */
        .org-card-row {
            flex-direction: row;
            align-items: center;
            gap: 6px;
            width: auto;
            min-width: 110px;
            max-width: 158px;
            padding: 5px 8px;
        }
        .org-photo-mini {
            width: 26px; height: 26px;
            border-radius: 50%;
            object-fit: cover;
            border: 1.5px solid var(--dp-gold-tint);
            flex-shrink: 0;
        }
        .org-photo-mini-xs {
            width: 20px; height: 20px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid var(--dp-border);
            flex-shrink: 0;
        }
        .org-card-row .org-name,
        .org-card-row .org-role,
        .org-card-row .org-dept {
            text-align: left;
            margin-bottom: 0;
        }

        /* Mobile accordion */
        @media (max-width: 1023px) {
            .desktop-chart { display: none; }
            .mobile-chart { display: block; }
        }
        @media (min-width: 1024px) {
            .desktop-chart { display: block; }
            .mobile-chart { display: none; }
        }
    </style>
</head>

<body class="min-h-screen" style="background: var(--dp-bg-page);" x-data="{ modalOpen: false, activePerson: {} }">
    @include('partials.navbar')

    <main class="pt-28 pb-16">
        {{-- ===== HEADER ===== --}}
        <div class="max-w-7xl mx-auto px-4 text-center mb-10">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] mb-3" style="color: var(--dp-gold);">Struktur Organisasi</p>
            <h1 class="font-display font-black text-3xl md:text-5xl mb-3" style="color: var(--dp-text-primary);">
                PC <span style="color: {{ $isIppnu ? 'var(--dp-gold)' : 'var(--dp-bg-primary)' }};">{{ $orgName }}</span>
            </h1>
            <p class="text-base mb-6" style="color: var(--dp-text-secondary);">Masa Khidmat {{ $periode }} &mdash; Kabupaten Kediri</p>

            {{-- TABS --}}
            <div class="inline-flex p-1 rounded-full shadow-md" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                <a href="?tab=ipnu"
                   class="px-8 py-3 min-h-[44px] flex items-center rounded-full text-sm font-bold transition-all"
                   style="{{ $tab === 'ipnu' ? 'background: var(--dp-bg-primary); color: var(--dp-text-on-primary); box-shadow: 0 0 0 1.5px var(--dp-gold);' : 'color: var(--dp-text-secondary);' }}">
                   PC IPNU
                </a>
                <a href="?tab=ippnu"
                   class="px-8 py-3 min-h-[44px] flex items-center rounded-full text-sm font-bold transition-all"
                   style="{{ $tab === 'ippnu' ? 'background: var(--dp-gold); color: #08332c;' : 'color: var(--dp-text-secondary);' }}">
                   PC IPPNU
                </a>
            </div>
        </div>

        @if($ketua)
        {{-- ===== DESKTOP CHART ===== --}}
        <div class="desktop-chart w-full overflow-x-auto">
            @include('struktur-organisasi.bagan')
        </div>

        {{-- ===== MOBILE CHART (Accordion + Toggle Bagan Penuh) ===== --}}
        <div class="mobile-chart" x-data="{ showFullChart: false, openSection: 'bph' }">

            {{-- Toggle "Lihat Bagan Penuh" --}}
            <div class="max-w-lg mx-auto px-4 flex justify-end mb-3">
                <button @click="showFullChart = !showFullChart"
                    class="text-xs font-bold px-4 py-2 rounded-full flex items-center gap-1 shadow-sm transition-colors"
                    style="background: var(--dp-bg-primary); color: var(--dp-text-gold);">
                    <span x-text="showFullChart ? 'Tampilan Ringkas' : 'Lihat Bagan Penuh'"></span>
                    <span class="material-symbols-outlined text-base" x-text="showFullChart ? 'unfold_less' : 'unfold_more'"></span>
                </button>
            </div>

            {{-- Bagan penuh — reuse partial yang sama dengan desktop --}}
            <div x-show="showFullChart" class="w-full overflow-x-auto" style="-webkit-overflow-scrolling: touch;">
                @include('struktur-organisasi.bagan')
                <p class="text-center text-xs mt-2 mb-4" style="color: var(--dp-text-secondary);">
                    &larr; Geser untuk melihat bagan lengkap &rarr;
                </p>
            </div>

            {{-- Accordion ringkas (default) --}}
            <div x-show="!showFullChart" class="max-w-lg mx-auto px-4">

            {{-- Ketua Card (always visible) --}}
            <div class="flex flex-col items-center mb-6">
                <div class="org-card mx-auto" style="width: 180px;" @click='activePerson = {!! personData($ketua) !!}; modalOpen = true'>
                    <img src="{{ personImg($ketua) }}" class="org-photo org-photo-lg" alt="{{ $ketua->kader->nama_lengkap }}">
                    <div class="org-name text-[0.85rem]">{{ $ketua->kader->nama_lengkap }}</div>
                    <div class="org-role">{{ $ketua->jabatan }}</div>
                </div>
            </div>

            {{-- BPH Section --}}
            <div class="mb-3 rounded-lg overflow-hidden" style="border: 1px solid var(--dp-border); background: var(--dp-bg-surface);">
                <button @click="openSection = openSection === 'bph' ? '' : 'bph'"
                    class="w-full px-4 py-3 flex items-center justify-between text-left">
                    <span class="font-bold text-sm" style="color: var(--dp-text-primary);">Badan Pengurus Harian</span>
                    <svg :class="openSection === 'bph' ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="openSection === 'bph'" x-collapse>
                    <div class="px-4 pb-4 space-y-2">
                        @if($sekretaris)
                        <div class="p-3 rounded-lg" style="background: var(--dp-bg-surface-2);">
                            <p class="font-bold text-xs" style="color: var(--dp-text-primary);">{{ $sekretaris->kader->nama_lengkap }}</p>
                            <p class="text-[0.65rem] uppercase font-semibold" style="color: var(--dp-gold);">Sekretaris</p>
                            @foreach($sekretaris->wakilList as $wasek)
                            <div class="mt-1 ml-3 flex items-center gap-2">
                                <div class="w-1 h-1 rounded-full" style="background: var(--dp-gold);"></div>
                                <span class="text-xs" style="color: var(--dp-text-secondary);">{{ $wasek->kader->nama_lengkap }} <span class="opacity-60">- {{ $wasek->departemenData->nama_departemen ?? '' }}</span></span>
                            </div>
                            @endforeach
                        </div>
                        @endif
                        @if($bendahara)
                        <div class="p-3 rounded-lg" style="background: var(--dp-bg-surface-2);">
                            <p class="font-bold text-xs" style="color: var(--dp-text-primary);">{{ $bendahara->kader->nama_lengkap }}</p>
                            <p class="text-[0.65rem] uppercase font-semibold" style="color: var(--dp-gold);">Bendahara</p>
                            @foreach($bendahara->wakilList as $wabend)
                            <div class="mt-1 ml-3 flex items-center gap-2">
                                <div class="w-1 h-1 rounded-full" style="background: var(--dp-gold);"></div>
                                <span class="text-xs" style="color: var(--dp-text-secondary);">{{ $wabend->kader->nama_lengkap }} <span class="opacity-60">- {{ $wabend->departemenData->nama_departemen ?? '' }}</span></span>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Departemen Sections --}}
            @foreach($departemenList as $waket)
            <div class="mb-3 rounded-lg overflow-hidden" style="border: 1px solid var(--dp-border); background: var(--dp-bg-surface);">
                <button @click="openSection = openSection === 'dept-{{ $loop->index }}' ? '' : 'dept-{{ $loop->index }}'"
                    class="w-full px-4 py-3 flex items-center justify-between text-left">
                    <div>
                        <span class="font-bold text-sm" style="color: var(--dp-text-primary);">{{ $waket->departemenData->nama_departemen ?? 'Departemen' }}</span>
                        <span class="text-xs ml-2" style="color: var(--dp-text-secondary);">{{ \Illuminate\Support\Str::words($waket->kader->nama_lengkap, 2) }}</span>
                    </div>
                    <svg :class="openSection === 'dept-{{ $loop->index }}' ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="openSection === 'dept-{{ $loop->index }}'" x-collapse>
                    <div class="px-4 pb-4 space-y-1">
                        <div class="p-2 rounded flex items-center gap-2" style="background: var(--dp-bg-surface-2);">
                            <span class="text-[0.6rem] uppercase font-bold px-2 py-0.5 rounded" style="background: var(--dp-bg-primary); color: var(--dp-gold);">Waket</span>
                            <span class="text-xs font-semibold" style="color: var(--dp-text-primary);">{{ $waket->kader->nama_lengkap }}</span>
                        </div>
                        @if($waket->koordinator)
                        <div class="p-2 rounded flex items-center gap-2 ml-3" style="background: var(--dp-bg-surface-2);">
                            <span class="text-[0.6rem] uppercase font-bold px-2 py-0.5 rounded" style="background: var(--dp-gold-tint); color: var(--dp-gold);">Koord</span>
                            <span class="text-xs" style="color: var(--dp-text-primary);">{{ $waket->koordinator->kader->nama_lengkap }}</span>
                        </div>
                            @foreach($waket->koordinator->anggotaList as $anggota)
                            <div class="p-2 rounded flex items-center gap-2 ml-6">
                                <div class="w-1 h-1 rounded-full" style="background: var(--dp-gold);"></div>
                                <span class="text-xs" style="color: var(--dp-text-secondary);">{{ $anggota->kader->nama_lengkap }}</span>
                            </div>
                            @endforeach
                        @endif
                        @foreach($waket->anggotaLangsung as $anggota)
                        <div class="p-2 rounded flex items-center gap-2 ml-3">
                            <div class="w-1 h-1 rounded-full" style="background: var(--dp-gold);"></div>
                            <span class="text-xs" style="color: var(--dp-text-secondary);">{{ $anggota->kader->nama_lengkap }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Lembaga Sections --}}
            @if($lembagaList->count())
            <div class="mb-3 rounded-lg overflow-hidden" style="border: 1px solid var(--dp-border-gold); background: var(--dp-bg-surface);">
                <button @click="openSection = openSection === 'lembaga' ? '' : 'lembaga'"
                    class="w-full px-4 py-3 flex items-center justify-between text-left">
                    <span class="font-bold text-sm" style="color: var(--dp-text-primary);">Lembaga & Badan</span>
                    <svg :class="openSection === 'lembaga' ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="openSection === 'lembaga'" x-collapse>
                    <div class="px-4 pb-4 space-y-2">
                        @foreach($lembagaList as $head)
                        <div class="p-3 rounded-lg" style="background: var(--dp-gold-tint);">
                            <p class="font-bold text-xs" style="color: var(--dp-text-primary);">{{ $head->kader->nama_lengkap }}</p>
                            <p class="text-[0.65rem] uppercase font-semibold" style="color: var(--dp-gold);">{{ $head->jabatan }} {{ $head->departemenData->nama_departemen ?? '' }}</p>
                            @foreach($head->anggotaList as $anggota)
                            <div class="mt-1 ml-3 flex items-center gap-2">
                                <div class="w-1 h-1 rounded-full" style="background: var(--dp-gold);"></div>
                                <span class="text-xs" style="color: var(--dp-text-secondary);">{{ $anggota->kader->nama_lengkap }}</span>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            </div>{{-- end x-show="!showFullChart" --}}
        </div>

        @else
        {{-- Empty state --}}
        <div class="text-center py-20">
            <p class="text-lg" style="color: var(--dp-text-secondary);">Data pengurus {{ $orgName }} belum tersedia.</p>
        </div>
        @endif
    </main>

    {{-- ===== PERSON MODAL ===== --}}
    <div x-show="modalOpen" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" @click="modalOpen = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative rounded-2xl shadow-2xl max-w-sm w-full overflow-hidden"
                 style="background: var(--dp-bg-surface);"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">
                <button @click="modalOpen = false"
                    class="absolute top-3 right-3 z-10 w-8 h-8 rounded-full flex items-center justify-center"
                    style="background: rgba(0,0,0,0.4); color: white;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <div class="w-full h-72 relative" style="background: var(--dp-bg-primary);">
                    <img :src="activePerson.image" class="w-full h-full object-cover opacity-90" alt="">
                    <div class="absolute inset-x-0 bottom-0 h-32" style="background: linear-gradient(to top, var(--dp-bg-primary), transparent);"></div>
                    <div class="absolute bottom-4 left-4 right-4">
                        <div class="inline-block px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider mb-2"
                             style="background: var(--dp-gold); color: #08332c;"
                             x-text="activePerson.role"></div>
                        <template x-if="activePerson.dept">
                            <div class="text-xs mb-1" style="color: var(--dp-gold-light);" x-text="activePerson.dept"></div>
                        </template>
                        <h3 class="font-display font-black text-2xl leading-tight" style="color: var(--dp-text-on-primary);" x-text="activePerson.name"></h3>
                    </div>
                </div>
                <div class="p-5" style="background: var(--dp-bg-surface-2);">
                    <p class="italic text-sm" style="color: var(--dp-text-secondary);" x-text="activePerson.quote || 'Belum ada quote.'"></p>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')
</body>

</html>
