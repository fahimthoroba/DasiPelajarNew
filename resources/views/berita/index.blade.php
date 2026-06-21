<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal Berita - PC IPNU IPPNU Kediri</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Meta Description & Canonical -->
    <meta name="description" content="Portal berita terkini dari PC IPNU-IPPNU Kabupaten Kediri — organisasi, kaderisasi, kegiatan, dan informasi pelajar.">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- OG Tags -->
    <meta property="og:title" content="Portal Berita | {{ $pengaturan->nama_website ?? 'PC IPNU IPPNU Kediri' }}">
    <meta property="og:description" content="Portal berita terkini dari PC IPNU-IPPNU Kabupaten Kediri.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ $pengaturan->nama_website ?? 'PC IPNU IPPNU Kediri' }}">

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Outfit:wght@400;700;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-4 { display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; }

        /* Ticker animation */
        @keyframes ticker-scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .ticker-animate { animation: ticker-scroll 30s linear infinite; }
        .ticker-animate:hover { animation-play-state: paused; }

        /* Section header style */
        .section-header {
            border-top: 3px solid var(--dp-bg-primary);
            padding-top: 0.75rem;
        }
        .dark .section-header {
            border-top-color: var(--dp-gold);
        }
    </style>

    @include('partials.theme-init')
</head>

<body class="font-body antialiased transition-colors duration-300"
    style="background: var(--dp-bg-page); color: var(--dp-text-primary);">

    @include('partials.navbar')

    {{-- ═══════════════════════════════════════════════════════════════
         TICKER BAR -- Breaking news / headline ticker
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="pt-20">
        <div style="background: var(--dp-bg-primary);" class="overflow-hidden">
            <div class="max-w-7xl mx-auto flex items-center">
                {{-- Label --}}
                <div class="shrink-0 px-4 py-2 font-bold text-xs uppercase tracking-widest"
                    style="background: var(--dp-gold); color: var(--dp-bg-primary);">
                    Terkini
                </div>
                {{-- Scrolling text --}}
                <div class="overflow-hidden flex-1 py-2">
                    <div class="ticker-animate flex whitespace-nowrap gap-12 px-4">
                        @foreach($headline->take(5) as $h)
                            <a href="{{ route('berita.show', $h->slug) }}"
                                class="text-sm hover:underline"
                                style="color: var(--dp-text-on-primary);">
                                <span style="color: var(--dp-gold);">&#9679;</span>
                                {{ $h->judul }}
                            </a>
                        @endforeach
                        {{-- Duplicate for seamless loop --}}
                        @foreach($headline->take(5) as $h)
                            <a href="{{ route('berita.show', $h->slug) }}"
                                class="text-sm hover:underline"
                                style="color: var(--dp-text-on-primary);">
                                <span style="color: var(--dp-gold);">&#9679;</span>
                                {{ $h->judul }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="pb-16 px-4 sm:px-6">
        <div class="max-w-7xl mx-auto">

            {{-- ═══════════════════════════════════════════════════════
                 HERO SLIDER -- Tanpa overlay (user request)
            ═══════════════════════════════════════════════════════ --}}
            @if($sliders->count())
            <section class="mt-6 mb-8">
                <div class="rounded-lg overflow-hidden" style="border: 1px solid var(--dp-border);">
                    <div class="swiper mySwiperBerita w-full aspect-[16/9] md:aspect-[3/1]">
                        <div class="swiper-wrapper">
                            @foreach($sliders as $slider)
                                <div class="swiper-slide relative w-full h-full">
                                    <img src="{{ asset('storage/' . $slider->gambar_path) }}"
                                        class="w-full h-full object-cover"
                                        alt="{{ $slider->judul_utama }}"
                                        loading="lazy">
                                    {{-- NO overlay -- user explicitly said no overlay for ad visibility --}}
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </section>
            @endif

            {{-- ═══════════════════════════════════════════════════════
                 HEADLINE BENTO -- 5 berita utama, bento grid bervariasi
            ═══════════════════════════════════════════════════════ --}}
            @if($headline->count())
            <section class="mb-10">
                <div class="section-header flex items-center justify-between mb-5">
                    <h2 class="font-display font-bold text-xl md:text-2xl" style="color: var(--dp-text-primary);">
                        Berita Utama
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    {{-- Main headline (large) --}}
                    @if($headline->count() >= 1)
                    @php $main = $headline[0]; @endphp
                    <a href="{{ route('berita.show', $main->slug) }}"
                        class="md:col-span-2 md:row-span-2 group rounded-lg overflow-hidden relative block"
                        style="border: 1px solid var(--dp-border);">
                        <div class="aspect-[4/3] md:aspect-auto md:h-full">
                            <img src="{{ $main->thumbnail ? asset('storage/' . $main->thumbnail) : 'https://placehold.co/800x600/08332c/ba9e6f?text=DASI+Pelajar' }}"
                                alt="{{ $main->judul }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                fetchpriority="high">
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 p-5 bg-gradient-to-t from-black/80 via-black/40 to-transparent">
                            <span class="inline-block px-2 py-0.5 text-[10px] font-bold uppercase tracking-widest rounded mb-2"
                                style="background: var(--dp-gold); color: var(--dp-bg-primary);">
                                {{ $main->kategori?->nama ?? 'Berita' }}
                            </span>
                            <h3 class="font-display font-bold text-lg md:text-2xl text-white leading-tight line-clamp-3">
                                {{ $main->judul }}
                            </h3>
                            <p class="text-white/70 text-sm mt-2 line-clamp-2 hidden md:block">
                                {{ $main->ringkasan_or_excerpt }}
                            </p>
                        </div>
                    </a>
                    @endif

                    {{-- Secondary headlines (4 smaller cards) --}}
                    @foreach($headline->slice(1, 4) as $item)
                    <a href="{{ route('berita.show', $item->slug) }}"
                        class="group rounded-lg overflow-hidden relative block"
                        style="border: 1px solid var(--dp-border);">
                        <div class="aspect-[16/10]">
                            <img src="{{ $item->thumbnail ? asset('storage/' . $item->thumbnail) : 'https://placehold.co/600x400/08332c/ba9e6f?text=DASI+Pelajar' }}"
                                alt="{{ $item->judul }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                loading="lazy">
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/80 to-transparent">
                            <span class="inline-block px-2 py-0.5 text-[9px] font-bold uppercase tracking-widest rounded mb-1"
                                style="background: var(--dp-bg-primary); color: var(--dp-gold);">
                                {{ $item->kategori?->nama ?? 'Berita' }}
                            </span>
                            <h3 class="font-display font-bold text-sm text-white leading-tight line-clamp-2">
                                {{ $item->judul }}
                            </h3>
                        </div>
                    </a>
                    @endforeach
                </div>
            </section>
            @endif

            {{-- Leaderboard Banner --}}
            @if(isset($banners['leaderboard_berita']) && $banners['leaderboard_berita']->is_active)
            <section class="mb-10">
                @php $lb = $banners['leaderboard_berita']; @endphp
                @if($lb->link_url)
                    <a href="{{ $lb->link_url }}" target="_blank" rel="noopener" class="block rounded-lg overflow-hidden max-w-full">
                        <img src="{{ asset('storage/'.$lb->gambar_path) }}" alt="Banner" class="w-full object-contain" style="max-height: 90px;" loading="lazy">
                    </a>
                @else
                    <div class="rounded-lg overflow-hidden max-w-full">
                        <img src="{{ asset('storage/'.$lb->gambar_path) }}" alt="Banner" class="w-full object-contain" style="max-height: 90px;" loading="lazy">
                    </div>
                @endif
            </section>
            @endif

            {{-- ═══════════════════════════════════════════════════════
                 MAIN CONTENT + SIDEBAR
            ═══════════════════════════════════════════════════════ --}}
            <div class="flex flex-col lg:flex-row gap-8">

                {{-- === KONTEN UTAMA (Left) === --}}
                <div class="flex-1 min-w-0">

                    {{-- ──── BERITA PER KATEGORI ──── --}}
                    @foreach($kategoris as $kat)
                        @php
                            $slug = $kat->slug ?? \Illuminate\Support\Str::slug($kat->nama);
                            $items = $berita_per_kategori[$slug] ?? collect();
                        @endphp
                        @if($items->count())
                        <section class="mb-10">
                            <div class="section-header flex items-center justify-between mb-5">
                                <h2 class="font-display font-bold text-lg md:text-xl" style="color: var(--dp-text-primary);">
                                    {{ $kat->nama }}
                                </h2>
                                <a href="{{ route('berita.arsip-kategori', $kat->slug) }}"
                                    class="text-sm font-semibold hover:underline"
                                    style="color: var(--dp-gold);">
                                    Lihat Semua &rarr;
                                </a>
                            </div>

                            {{-- Bento layout: 1 besar kiri + 3 kecil kanan --}}
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                {{-- Big card --}}
                                @if($items->count() >= 1)
                                @php $first = $items[0]; @endphp
                                <a href="{{ route('berita.show', $first->slug) }}"
                                    class="md:row-span-3 group rounded-lg overflow-hidden relative block"
                                    style="border: 1px solid var(--dp-border);">
                                    <div class="aspect-[4/3]">
                                        <img src="{{ $first->thumbnail ? asset('storage/' . $first->thumbnail) : 'https://placehold.co/600x450/08332c/ba9e6f?text=' . urlencode($kat->nama) }}"
                                            alt="{{ $first->judul }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                            loading="lazy">
                                    </div>
                                    <div class="p-4" style="background: var(--dp-bg-surface);">
                                        <span class="inline-block px-2 py-0.5 text-[9px] font-bold uppercase tracking-widest rounded mb-2"
                                            style="background: var(--dp-bg-primary); color: var(--dp-gold);">
                                            {{ $kat->nama }}
                                        </span>
                                        <h3 class="font-display font-bold text-base leading-tight line-clamp-2 mb-2 group-hover:underline"
                                            style="color: var(--dp-text-primary);">
                                            {{ $first->judul }}
                                        </h3>
                                        <p class="text-sm line-clamp-3" style="color: var(--dp-text-secondary);">
                                            {{ $first->ringkasan_or_excerpt }}
                                        </p>
                                        <div class="mt-3 text-xs" style="color: var(--dp-text-secondary);">
                                            {{ $first->tgl_publish?->translatedFormat('d M Y') }}
                                        </div>
                                    </div>
                                </a>
                                @endif

                                {{-- Small cards --}}
                                <div class="md:col-span-2 flex flex-col gap-4">
                                    @foreach($items->slice(1, 4) as $item)
                                    <a href="{{ route('berita.show', $item->slug) }}"
                                        class="group flex gap-4 rounded-lg overflow-hidden p-3 hover:shadow-md transition-shadow"
                                        style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                                        <div class="w-28 h-20 md:w-32 md:h-24 rounded-md overflow-hidden shrink-0">
                                            <img src="{{ $item->thumbnail ? asset('storage/' . $item->thumbnail) : 'https://placehold.co/320x240/08332c/ba9e6f?text=' . urlencode($kat->nama) }}"
                                                alt="{{ $item->judul }}"
                                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                                loading="lazy">
                                        </div>
                                        <div class="flex-1 min-w-0 flex flex-col justify-center">
                                            <span class="text-[9px] font-bold uppercase tracking-widest mb-1"
                                                style="color: var(--dp-gold);">
                                                {{ $kat->nama }}
                                            </span>
                                            <h4 class="font-display font-bold text-sm leading-tight line-clamp-2 mb-1 group-hover:underline"
                                                style="color: var(--dp-text-primary);">
                                                {{ $item->judul }}
                                            </h4>
                                            <span class="text-xs" style="color: var(--dp-text-secondary);">
                                                {{ $item->tgl_publish?->translatedFormat('d M Y') }}
                                            </span>
                                        </div>
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </section>

                        {{-- Banner Antara Kategori --}}
                        @if($loop->iteration % 2 === 0 && !$loop->last)
                        @if(isset($banners['between_categories']) && $banners['between_categories']->is_active)
                        <section class="mb-10">
                            @php $bc = $banners['between_categories']; @endphp
                            @if($bc->link_url)
                                <a href="{{ $bc->link_url }}" target="_blank" rel="noopener" class="block rounded-lg overflow-hidden">
                                    <img src="{{ asset('storage/'.$bc->gambar_path) }}" alt="Banner" class="w-full object-cover" style="max-height: 70px;" loading="lazy">
                                </a>
                            @else
                                <div class="rounded-lg overflow-hidden">
                                    <img src="{{ asset('storage/'.$bc->gambar_path) }}" alt="Banner" class="w-full object-cover" style="max-height: 70px;" loading="lazy">
                                </div>
                            @endif
                        </section>
                        @endif
                        @endif

                        @endif
                    @endforeach

                    {{-- ──── SEMUA BERITA (Paginated) ──── --}}
                    <section class="mb-10">
                        <div class="section-header flex items-center justify-between mb-5">
                            <h2 class="font-display font-bold text-lg md:text-xl" style="color: var(--dp-text-primary);">
                                Semua Berita
                            </h2>
                        </div>

                        @if(isset($search) && $search)
                        <div class="mb-4">
                            <p class="text-sm" style="color: var(--dp-text-secondary);">
                                Hasil pencarian untuk:
                                <span class="font-semibold" style="color: var(--dp-text-primary);">"{{ $search }}"</span>
                                — {{ $semua_berita->total() }} artikel ditemukan
                            </p>
                            <a href="{{ route('berita.index') }}"
                               class="text-xs hover:underline"
                               style="color: var(--dp-text-secondary);">
                                ✕ Hapus pencarian
                            </a>
                        </div>
                        @endif

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @forelse($semua_berita as $berita)
                            <a href="{{ route('berita.show', $berita->slug) }}"
                                class="group rounded-lg overflow-hidden block hover:shadow-lg transition-shadow"
                                style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                                <div class="aspect-[16/10] overflow-hidden">
                                    <img src="{{ $berita->thumbnail ? asset('storage/' . $berita->thumbnail) : 'https://placehold.co/480x300/08332c/ba9e6f?text=DASI+Pelajar' }}"
                                        alt="{{ $berita->judul }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        loading="lazy">
                                </div>
                                <div class="p-4">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="inline-block px-2 py-0.5 text-[9px] font-bold uppercase tracking-widest rounded"
                                            style="background: var(--dp-bg-primary); color: var(--dp-gold);">
                                            {{ $berita->kategori?->nama ?? 'Berita' }}
                                        </span>
                                        <span class="text-xs" style="color: var(--dp-text-secondary);">
                                            {{ $berita->tgl_publish?->translatedFormat('d M Y') }}
                                        </span>
                                    </div>
                                    <h3 class="font-display font-bold text-sm leading-tight line-clamp-2 mb-2 group-hover:underline"
                                        style="color: var(--dp-text-primary);">
                                        {{ $berita->judul }}
                                    </h3>
                                    <p class="text-xs line-clamp-2" style="color: var(--dp-text-secondary);">
                                        {{ $berita->ringkasan_or_excerpt }}
                                    </p>
                                </div>
                            </a>
                            @empty
                            <div class="col-span-full text-center py-16 rounded-lg"
                                style="background: var(--dp-bg-surface); border: 1px dashed var(--dp-border-strong);">
                                <span class="material-symbols-outlined text-4xl mb-3 block" style="color: var(--dp-text-secondary);">newspaper</span>
                                @if(isset($search) && $search)
                                <h3 class="font-display font-bold text-lg mb-1" style="color: var(--dp-text-primary);">Tidak ada hasil untuk "{{ $search }}"</h3>
                                <p class="text-sm" style="color: var(--dp-text-secondary);">Coba kata kunci lain, atau periksa ejaan.</p>
                                <a href="{{ route('berita.index') }}"
                                   class="inline-block mt-4 px-5 py-2 rounded font-semibold text-sm"
                                   style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);">
                                    Lihat Semua Berita
                                </a>
                                @else
                                <h3 class="font-display font-bold text-lg mb-1" style="color: var(--dp-text-primary);">Belum Ada Berita</h3>
                                <p class="text-sm" style="color: var(--dp-text-secondary);">Nantikan informasi terbaru dari kami.</p>
                                @endif
                            </div>
                            @endforelse
                        </div>

                        {{-- Pagination --}}
                        @if($semua_berita->hasPages())
                        <div class="mt-8">
                            {{ $semua_berita->links() }}
                        </div>
                        @endif
                    </section>
                </div>

                {{-- === SIDEBAR (Right) === --}}
                <aside class="w-full lg:w-80 shrink-0 space-y-8">

                    {{-- Sidebar: Search --}}
                    <div class="rounded-lg p-4" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                        <form action="{{ route('berita.index') }}" method="GET" class="flex gap-2">
                            <input type="text" name="q" placeholder="Cari berita..."
                                class="flex-1 px-3 py-2 rounded-md text-sm border focus:outline-none focus:ring-2"
                                style="background: var(--dp-bg-page); border-color: var(--dp-border-strong); color: var(--dp-text-primary); --tw-ring-color: var(--dp-gold);"
                                value="{{ request('q') }}">
                            <button type="submit" class="px-3 py-2 rounded-md"
                                style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);">
                                <span class="material-symbols-outlined text-lg">search</span>
                            </button>
                        </form>
                    </div>

                    {{-- Sidebar Banner --}}
                    @if(isset($banners['sidebar_berita']) && $banners['sidebar_berita']->is_active)
                    @php $sb = $banners['sidebar_berita']; @endphp
                    @if($sb->link_url)
                        <a href="{{ $sb->link_url }}" target="_blank" rel="noopener" class="block rounded-lg overflow-hidden" style="min-height: 250px;">
                            <img src="{{ asset('storage/'.$sb->gambar_path) }}" alt="Banner" class="w-full object-cover" loading="lazy">
                        </a>
                    @else
                        <div class="rounded-lg overflow-hidden" style="min-height: 250px;">
                            <img src="{{ asset('storage/'.$sb->gambar_path) }}" alt="Banner" class="w-full object-cover" loading="lazy">
                        </div>
                    @endif
                    @endif

                    {{-- Sidebar: Berita Populer --}}
                    @if($berita_populer->count())
                    <div class="rounded-lg p-4" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                        <h3 class="font-display font-bold text-base mb-4 pb-2"
                            style="color: var(--dp-text-primary); border-bottom: 2px solid var(--dp-gold);">
                            Berita Populer
                        </h3>
                        <div class="space-y-4">
                            @foreach($berita_populer as $pop)
                            <a href="{{ route('berita.show', $pop->slug) }}" class="flex gap-3 group">
                                <span class="font-display font-bold text-2xl leading-none shrink-0 w-8 text-center"
                                    style="color: var(--dp-gold);">
                                    {{ $loop->iteration }}
                                </span>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold leading-tight line-clamp-2 group-hover:underline"
                                        style="color: var(--dp-text-primary);">
                                        {{ $pop->judul }}
                                    </h4>
                                    <span class="text-xs mt-1 block" style="color: var(--dp-text-secondary);">
                                        {{ $pop->views }} x dibaca
                                    </span>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Sidebar: Kategori --}}
                    <div class="rounded-lg p-4" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                        <h3 class="font-display font-bold text-base mb-4 pb-2"
                            style="color: var(--dp-text-primary); border-bottom: 2px solid var(--dp-gold);">
                            Kategori
                        </h3>
                        <div class="space-y-2">
                            @foreach($kategoris as $kat)
                            <a href="{{ route('berita.arsip-kategori', $kat->slug ?? \Illuminate\Support\Str::slug($kat->nama)) }}"
                                class="flex items-center justify-between py-2 px-3 rounded-md text-sm hover:shadow-sm transition-shadow"
                                style="background: var(--dp-bg-surface-2); color: var(--dp-text-primary);">
                                <span>{{ $kat->nama }}</span>
                                <span class="text-xs font-bold px-2 py-0.5 rounded"
                                    style="background: var(--dp-primary-tint); color: var(--dp-text-secondary);">
                                    {{ $kat->beritas_count ?? 0 }}
                                </span>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Sidebar: Tags Populer --}}
                    @if($tags_populer->count())
                    <div class="rounded-lg p-4" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                        <h3 class="font-display font-bold text-base mb-4 pb-2"
                            style="color: var(--dp-text-primary); border-bottom: 2px solid var(--dp-gold);">
                            Tag Populer
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tags_populer as $tag)
                            <a href="{{ route('berita.arsip-tag', $tag->slug) }}"
                                class="inline-block px-3 py-1 rounded-full text-xs font-medium hover:shadow-sm transition-shadow"
                                style="background: var(--dp-primary-tint); color: var(--dp-text-primary); border: 1px solid var(--dp-border);">
                                #{{ $tag->nama }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Sidebar: Ad Space 2 --}}
                    <div class="rounded-lg overflow-hidden flex items-center justify-center"
                        style="background: var(--dp-bg-surface-2); border: 1px dashed var(--dp-border-strong); min-height: 250px;">
                        <div class="text-center py-8 px-4">
                            <p class="text-xs font-medium" style="color: var(--dp-text-secondary);">
                                <span class="material-symbols-outlined text-2xl block mb-2">campaign</span>
                                Space Iklan<br>300 x 250
                            </p>
                        </div>
                    </div>

                </aside>
            </div>

        </div>
    </main>

    @include('partials.footer')
</body>

</html>
