<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $kategori->nama }} — {{ $pengaturan->nama_website ?? 'PC IPNU IPPNU Kediri' }}</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    <meta name="description" content="Kumpulan berita kategori {{ $kategori->nama }} dari {{ $pengaturan->nama_website ?? 'PC IPNU IPPNU Kediri' }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:title" content="{{ $kategori->nama }} | {{ $pengaturan->nama_website ?? 'PC IPNU IPPNU Kediri' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    @include('partials.theme-init')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background: var(--dp-bg-page); color: var(--dp-text-primary);">
    @include('partials.navbar')

    <main class="max-w-6xl mx-auto px-4 py-8">

        {{-- Breadcrumb --}}
        <nav class="text-sm mb-6" style="color: var(--dp-text-secondary);">
            <a href="{{ route('berita.index') }}" class="hover:underline">Portal Berita</a>
            <span class="mx-2">›</span>
            <span style="color: var(--dp-text-primary);">{{ $kategori->nama }}</span>
        </nav>

        {{-- Header --}}
        <div class="mb-8 pb-5" style="border-top: 3px solid var(--dp-bg-primary);">
            <div class="mt-4 flex items-center gap-3">
                <span class="text-xs font-semibold px-2 py-1 tracking-widest uppercase"
                      style="background: var(--dp-bg-primary); color: var(--dp-text-gold);">
                    Kategori
                </span>
            </div>
            <h1 class="font-display font-bold text-2xl md:text-3xl mt-2" style="color: var(--dp-text-primary);">
                {{ $kategori->nama }}
            </h1>
            <p class="mt-1 text-sm" style="color: var(--dp-text-secondary);">
                {{ $beritas->total() }} berita ditemukan
            </p>
        </div>

        <div class="flex flex-col md:flex-row gap-8">

            {{-- === KONTEN UTAMA === --}}
            <div class="flex-1 min-w-0">
                @if($beritas->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($beritas as $berita)
                    <article class="rounded overflow-hidden hover:shadow-md transition-shadow"
                             style="background: var(--dp-bg-surface); border: 0.5px solid var(--dp-border);">
                        {{-- Thumbnail --}}
                        <a href="{{ route('berita.show', $berita->slug) }}">
                            @if($berita->thumbnail)
                            <img src="{{ asset('storage/' . $berita->thumbnail) }}"
                                 alt="{{ $berita->judul }}"
                                 loading="lazy"
                                 class="w-full h-44 object-cover">
                            @else
                            <div class="w-full h-44 flex items-center justify-center"
                                 style="background: var(--dp-bg-surface-2);">
                                <span class="material-symbols-outlined text-4xl" style="color: var(--dp-text-secondary);">newspaper</span>
                            </div>
                            @endif
                        </a>

                        <div class="p-4">
                            {{-- Kategori badge --}}
                            <span class="text-[10px] font-semibold px-2 py-0.5 uppercase tracking-widest"
                                  style="background: var(--dp-bg-primary); color: var(--dp-text-gold);">
                                {{ $berita->kategori?->nama ?? $kategori->nama }}
                            </span>

                            {{-- Judul --}}
                            <h2 class="font-display font-bold mt-2 mb-2 leading-snug text-sm md:text-base">
                                <a href="{{ route('berita.show', $berita->slug) }}"
                                   class="hover:underline"
                                   style="color: var(--dp-text-primary);">
                                    {{ Str::limit($berita->judul, 70) }}
                                </a>
                            </h2>

                            {{-- Meta --}}
                            <div class="text-xs mt-3" style="color: var(--dp-text-secondary);">
                                {{ $berita->tgl_publish?->translatedFormat('d M Y') ?? '' }}
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $beritas->links() }}
                </div>

                @else
                {{-- Empty state --}}
                <div class="py-16 text-center rounded" style="background: var(--dp-bg-surface); border: 0.5px solid var(--dp-border);">
                    <span class="material-symbols-outlined text-5xl mb-4 block" style="color: var(--dp-text-secondary);">newspaper</span>
                    <p class="text-lg font-semibold" style="color: var(--dp-text-primary);">
                        Belum ada berita di kategori ini
                    </p>
                    <p class="mt-2 text-sm" style="color: var(--dp-text-secondary);">
                        Cek kembali nanti atau lihat kategori lainnya.
                    </p>
                    <a href="{{ route('berita.index') }}"
                       class="inline-block mt-4 px-5 py-2 rounded font-semibold text-sm transition-colors"
                       style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);">
                        ← Kembali ke Portal Berita
                    </a>
                </div>
                @endif
            </div>

            {{-- === SIDEBAR === --}}
            <aside class="w-full md:w-64 shrink-0">
                <div class="rounded p-4" style="background: var(--dp-bg-surface); border: 0.5px solid var(--dp-border);">
                    <h3 class="font-display font-bold text-sm mb-3 uppercase tracking-widest"
                        style="color: var(--dp-text-secondary);">Kategori Lainnya</h3>
                    <nav class="space-y-1">
                        @foreach($kategoris as $kat)
                        <a href="{{ route('berita.arsip-kategori', $kat->slug) }}"
                           class="flex items-center justify-between px-3 py-2 rounded text-sm transition-colors
                                  {{ $kat->slug === $kategori->slug ? 'font-bold' : '' }}"
                           style="color: {{ $kat->slug === $kategori->slug ? 'var(--dp-bg-primary)' : 'var(--dp-text-primary)' }};
                                  background: {{ $kat->slug === $kategori->slug ? 'var(--dp-primary-tint)' : 'transparent' }};">
                            <span>{{ $kat->nama }}</span>
                            <span class="text-xs px-1.5 py-0.5 rounded"
                                  style="background: var(--dp-gold-tint); color: var(--dp-text-gold);">
                                {{ $kat->beritas_count }}
                            </span>
                        </a>
                        @endforeach
                    </nav>
                </div>
            </aside>

        </div>
    </main>

    @include('partials.footer')
</body>
</html>
