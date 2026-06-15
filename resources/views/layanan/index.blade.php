<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Layanan & Dokumen - PC IPNU IPPNU Kab. Kediri</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Outfit:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.theme-init')

    @php
        $kategoriConfig = [
            'Template Surat' => ['icon' => 'description',   'tint' => 'var(--dp-primary-tint)', 'color' => 'var(--dp-bg-primary)'],
            'Pedoman'        => ['icon' => 'menu_book',      'tint' => 'var(--dp-primary-tint)', 'color' => 'var(--dp-bg-primary)'],
            'Peraturan'      => ['icon' => 'gavel',          'tint' => 'var(--dp-primary-tint)', 'color' => 'var(--dp-bg-primary)'],
            'Formulir'       => ['icon' => 'assignment',     'tint' => 'var(--dp-gold-tint)',    'color' => 'var(--dp-gold)'],
            'Doa & Dzikir'   => ['icon' => 'auto_stories',  'tint' => 'var(--dp-gold-tint)',    'color' => 'var(--dp-gold)'],
            'Lainnya'        => ['icon' => 'folder',         'tint' => 'var(--dp-bg-surface-2)', 'color' => 'var(--dp-text-secondary)'],
        ];

        $fileTypeIcon = fn($path) => match(strtolower(pathinfo($path, PATHINFO_EXTENSION))) {
            'pdf'               => ['icon' => 'picture_as_pdf', 'label' => 'PDF'],
            'docx', 'doc'       => ['icon' => 'description',    'label' => 'DOCX'],
            'xlsx', 'xls'       => ['icon' => 'table_chart',    'label' => 'XLSX'],
            'zip', 'rar'        => ['icon' => 'folder_zip',     'label' => 'ZIP'],
            default             => ['icon' => 'draft',          'label' => 'FILE'],
        };
    @endphp

    <style>
        .tab-btn { transition: background 0.15s, color 0.15s, box-shadow 0.15s; }
        .tab-btn.active {
            background: var(--dp-bg-primary);
            color: var(--dp-text-on-primary);
            box-shadow: 0 2px 8px rgba(8,51,44,0.18);
        }
        .tab-btn:not(.active) { color: var(--dp-text-secondary); }
        .tab-btn:not(.active):hover { background: var(--dp-bg-surface-2); color: var(--dp-text-primary); }

        .file-card { transition: transform 0.18s, box-shadow 0.18s, border-color 0.18s; }
        .file-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px -4px rgba(8,51,44,0.12);
            border-color: var(--dp-border-strong) !important;
        }

        .download-btn { transition: background 0.15s, transform 0.1s; }
        .download-btn:hover { transform: scale(1.02); }
        .download-btn:active { transform: scale(0.98); }

        /* Hide scrollbar on tab scroll container — cross-browser */
        .tab-scroll { overflow-x: auto; -ms-overflow-style: none; scrollbar-width: none; }
        .tab-scroll::-webkit-scrollbar { display: none; }
    </style>
</head>

<body class="font-body antialiased transition-colors duration-300"
    style="background: var(--dp-bg-page); color: var(--dp-text-primary);"
    x-data="{
        activeTab: 'semua',
        setTab(t) { this.activeTab = t; }
    }">

    @include('partials.navbar')

    {{-- ===== HEADER ===== --}}
    <section class="pt-28 pb-16" style="background: var(--dp-bg-primary);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-xs font-bold uppercase tracking-[0.2em] mb-3" style="color: var(--dp-gold);">Pusat Unduhan</p>
                <h1 class="font-display font-black text-3xl md:text-5xl mb-4" style="color: var(--dp-text-on-primary);">
                    Layanan & Dokumen
                </h1>
                <p class="text-base md:text-lg max-w-2xl mx-auto" style="color: var(--dp-text-on-primary); opacity: 0.7;">
                    Template, pedoman, peraturan, dan dokumen resmi organisasi tersedia untuk diunduh.
                </p>
            </div>

            {{-- Stats Bar --}}
            <div class="mt-10 grid grid-cols-3 gap-4 max-w-lg mx-auto">
                <div class="text-center px-4 py-3 rounded-xl" style="background: rgba(255,255,255,0.07);">
                    <p class="font-display font-black text-xl sm:text-2xl" style="color: var(--dp-gold);">{{ $totalFile }}</p>
                    <p class="text-xs font-semibold uppercase tracking-widest mt-0.5" style="color: var(--dp-text-on-primary); opacity: 0.6;">File</p>
                </div>
                <div class="text-center px-4 py-3 rounded-xl" style="background: rgba(255,255,255,0.07);">
                    <p class="font-display font-black text-xl sm:text-2xl" style="color: var(--dp-gold);">{{ number_format($totalDownload) }}</p>
                    <p class="text-xs font-semibold uppercase tracking-widest mt-0.5" style="color: var(--dp-text-on-primary); opacity: 0.6;">Unduhan</p>
                </div>
                <div class="text-center px-4 py-3 rounded-xl" style="background: rgba(255,255,255,0.07);">
                    <p class="font-display font-black text-xl sm:text-2xl" style="color: var(--dp-gold);">{{ count($kategoris) }}</p>
                    <p class="text-xs font-semibold uppercase tracking-widest mt-0.5" style="color: var(--dp-text-on-primary); opacity: 0.6;">Kategori</p>
                </div>
            </div>
        </div>
    </section>

    <main class="pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Flash Error --}}
            @if(session('error'))
            <div class="mt-6 flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold"
                 style="background: var(--dp-danger-tint); color: var(--dp-danger); border: 1px solid rgba(232,70,58,0.25);">
                <span class="material-symbols-outlined text-base">error</span>
                {{ session('error') }}
            </div>
            @endif

            {{-- ===== CATEGORY TABS ===== --}}
            <div class="sticky top-16 z-30 pt-4 pb-3 -mx-4 px-4 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8"
                 style="background: var(--dp-bg-page);">
                <div class="tab-scroll flex gap-1.5 pb-1 flex-nowrap">
                    <button
                        @click="setTab('semua')"
                        :class="activeTab === 'semua' ? 'active' : ''"
                        class="tab-btn px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap flex-shrink-0"
                        style="border: 1px solid var(--dp-border);">
                        Semua
                        <span class="ml-1 opacity-60 font-normal">({{ $totalFile }})</span>
                    </button>
                    @foreach($kategoris as $kat)
                    @php $jumlah = ($layananPerKategori[$kat] ?? collect())->count(); @endphp
                    @if($jumlah > 0)
                    <button
                        @click="setTab('{{ Str::slug($kat) }}')"
                        :class="activeTab === '{{ Str::slug($kat) }}' ? 'active' : ''"
                        class="tab-btn px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap flex-shrink-0"
                        style="border: 1px solid var(--dp-border);">
                        {{ $kat }}
                        <span class="ml-1 opacity-60 font-normal">({{ $jumlah }})</span>
                    </button>
                    @endif
                    @endforeach
                </div>
            </div>

            {{-- ===== PER KATEGORI SECTIONS ===== --}}
            <div class="mt-6 space-y-10">
                @foreach($kategoris as $kat)
                @php
                    $items = $layananPerKategori[$kat] ?? collect();
                    $cfg   = $kategoriConfig[$kat] ?? $kategoriConfig['Lainnya'];
                    $slug  = Str::slug($kat);
                @endphp

                <div x-show="activeTab === 'semua' || activeTab === '{{ $slug }}'" x-transition>

                    {{-- Section header --}}
                    <div class="flex items-center gap-3 mb-5"
                         style="border-top: 3px solid var(--dp-bg-primary); padding-top: 0.75rem;">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                             style="background: {{ $cfg['tint'] }};">
                            <span class="material-symbols-outlined text-base" style="color: {{ $cfg['color'] }};">{{ $cfg['icon'] }}</span>
                        </div>
                        <div>
                            <h2 class="font-display font-bold text-lg leading-tight" style="color: var(--dp-text-primary);">{{ $kat }}</h2>
                        </div>
                        <span class="ml-auto text-xs font-bold px-2 py-0.5 rounded-full"
                              style="background: var(--dp-bg-surface-2); color: var(--dp-text-secondary); border: 1px solid var(--dp-border);">
                            {{ $items->count() }} file
                        </span>
                    </div>

                    @if($items->isEmpty())
                        {{-- Empty state --}}
                        <div class="py-10 text-center rounded-xl" style="border: 1px dashed var(--dp-border); background: var(--dp-bg-surface);">
                            <span class="material-symbols-outlined text-3xl block mb-2" style="color: var(--dp-text-secondary);">folder_off</span>
                            <p class="text-sm" style="color: var(--dp-text-secondary);">Belum ada dokumen di kategori ini.</p>
                        </div>
                    @else
                        {{-- File grid --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            @foreach($items as $file)
                            @php $ft = $fileTypeIcon($file->file_path); @endphp
                            <div class="file-card rounded-2xl flex flex-col overflow-hidden"
                                 style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">

                                {{-- Card top accent --}}
                                <div class="h-1.5 flex-shrink-0" style="background: {{ $cfg['color'] }};"></div>

                                <div class="p-5 flex flex-col flex-1">
                                    {{-- Icon + kategori badge --}}
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                                             style="background: {{ $cfg['tint'] }};">
                                            <span class="material-symbols-outlined text-xl" style="color: {{ $cfg['color'] }};">{{ $cfg['icon'] }}</span>
                                        </div>
                                        <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded"
                                              style="background: var(--dp-bg-surface-2); color: var(--dp-text-secondary); border: 1px solid var(--dp-border);">
                                            {{ $kat }}
                                        </span>
                                    </div>

                                    {{-- Judul --}}
                                    <h3 class="font-display font-bold text-sm leading-snug mb-1.5" style="color: var(--dp-text-primary);">
                                        {{ $file->judul }}
                                    </h3>

                                    {{-- Deskripsi --}}
                                    @if($file->deskripsi)
                                    <p class="text-xs leading-relaxed mb-3 flex-1"
                                       style="color: var(--dp-text-secondary); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $file->deskripsi }}
                                    </p>
                                    @else
                                    <div class="flex-1"></div>
                                    @endif

                                    {{-- Meta: tipe file + ukuran + counter --}}
                                    <div class="flex items-center gap-2 mb-4 mt-1">
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase px-1.5 py-0.5 rounded"
                                              style="background: var(--dp-bg-surface-2); color: var(--dp-text-secondary); border: 1px solid var(--dp-border);">
                                            <span class="material-symbols-outlined" style="font-size: 11px;">{{ $ft['icon'] }}</span>
                                            {{ $ft['label'] }}
                                        </span>
                                        @if($file->ukuran_file)
                                        <span class="text-[11px]" style="color: var(--dp-text-secondary);">{{ $file->ukuran_file }}</span>
                                        @endif
                                        <span class="ml-auto inline-flex items-center gap-1 text-[11px]" style="color: var(--dp-text-secondary);">
                                            <span class="material-symbols-outlined" style="font-size: 13px;">download</span>
                                            {{ number_format($file->jumlah_download) }}x
                                        </span>
                                    </div>

                                    {{-- Download button --}}
                                    <a href="{{ route('layanan.download', $file->id) }}"
                                       class="download-btn w-full inline-flex items-center justify-center gap-2 py-3 rounded-xl text-xs font-bold"
                                       style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);">
                                        <span class="material-symbols-outlined text-sm">download</span>
                                        Unduh
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                @endforeach
            </div>

        </div>
    </main>

    {{-- Floating "Minta Dokumen" button --}}
    <a href="https://wa.me/6281234567890?text=Halo%20DASI%20Pelajar%2C%20saya%20ingin%20meminta%20dokumen%3A%20"
       target="_blank" rel="noopener"
       class="fixed bottom-6 right-6 z-50 inline-flex items-center gap-2 px-4 py-3 rounded-full font-bold text-sm shadow-xl transition-transform hover:scale-105"
       style="background: var(--dp-gold); color: #08332c;">
        <span class="material-symbols-outlined text-base">chat</span>
        Minta Dokumen
    </a>

    @include('partials.footer')
</body>

</html>
