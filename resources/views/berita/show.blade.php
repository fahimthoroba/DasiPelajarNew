<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $berita->judul }} - {{ $pengaturan->nama_website ?? 'PC IPNU IPPNU Kediri' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- OG Meta -->
    <meta property="og:title" content="{{ $berita->judul }}">
    <meta property="og:description" content="{{ $berita->ringkasan_or_excerpt }}">
    @if($berita->thumbnail)
    <meta property="og:image" content="{{ asset('storage/' . $berita->thumbnail) }}">
    @endif

    <!-- OG Tags Lengkap -->
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="article">
    <meta property="og:site_name" content="{{ $pengaturan->nama_website ?? 'PC IPNU IPPNU Kediri' }}">
    @if($berita->tgl_publish)
    <meta property="article:published_time" content="{{ $berita->tgl_publish->toIso8601String() }}">
    @endif

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $berita->judul }}">
    <meta name="twitter:description" content="{{ $berita->ringkasan_or_excerpt }}">
    @if($berita->thumbnail)
    <meta name="twitter:image" content="{{ asset('storage/' . $berita->thumbnail) }}">
    @endif

    <!-- Meta Description & Canonical -->
    <meta name="description" content="{{ $berita->ringkasan_or_excerpt }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Outfit:wght@400;700;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }

        /* Prose styling */
        .prose-dp { line-height: 1.85; font-size: 1.05rem; }
        .prose-dp h1, .prose-dp h2, .prose-dp h3, .prose-dp h4 { font-family: 'Outfit', sans-serif; font-weight: 700; margin-top: 1.8em; margin-bottom: 0.6em; color: var(--dp-text-primary); }
        .prose-dp h2 { font-size: 1.5rem; }
        .prose-dp h3 { font-size: 1.25rem; }
        .prose-dp p { margin-bottom: 1.2em; color: var(--dp-text-primary); opacity: 0.85; }
        .prose-dp img { border-radius: 8px; margin: 1.5em 0; }
        .prose-dp blockquote { border-left: 3px solid var(--dp-gold); padding-left: 1em; margin: 1.5em 0; font-style: italic; color: var(--dp-text-secondary); }
        .prose-dp a { color: var(--dp-gold); text-decoration: underline; }
        .prose-dp ul, .prose-dp ol { padding-left: 1.5em; margin-bottom: 1.2em; }
        .prose-dp li { margin-bottom: 0.4em; }
        .prose-dp strong { color: var(--dp-text-primary); }

        /* Sticky sidebar */
        .sticky-sidebar { position: sticky; top: 6rem; }

        /* Comment avatar */
        .avatar-initial {
            width: 40px; height: 40px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 14px; text-transform: uppercase;
            background: var(--dp-bg-primary); color: var(--dp-gold);
        }
    </style>

    @include('partials.theme-init')
</head>

<body class="font-body antialiased transition-colors duration-300"
    style="background: var(--dp-bg-page); color: var(--dp-text-primary);">

    @include('partials.navbar')

    <main class="pt-24 pb-16 px-4 sm:px-6 min-h-screen">
        <div class="max-w-7xl mx-auto">

            {{-- Breadcrumb --}}
            <nav class="mb-6 text-sm" style="color: var(--dp-text-secondary);">
                <ol class="flex items-center flex-wrap gap-1">
                    <li><a href="{{ route('home') }}" class="hover:underline" style="color: var(--dp-text-secondary);">Beranda</a></li>
                    <li><span class="material-symbols-outlined text-sm align-middle">chevron_right</span></li>
                    <li><a href="{{ route('berita.index') }}" class="hover:underline" style="color: var(--dp-text-secondary);">Berita</a></li>
                    <li><span class="material-symbols-outlined text-sm align-middle">chevron_right</span></li>
                    <li><a href="{{ route('berita.index') }}" class="hover:underline" style="color: var(--dp-gold);">{{ $berita->kategori?->nama ?? 'Umum' }}</a></li>
                </ol>
            </nav>

            <div class="flex flex-col lg:flex-row gap-8">

                {{-- ═══════════════════════════════════════════
                     KONTEN UTAMA (Left)
                ═══════════════════════════════════════════ --}}
                <article class="flex-1 min-w-0">

                    {{-- Article Header --}}
                    <header class="mb-6">
                        {{-- Kategori badge --}}
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-block px-3 py-1 text-[10px] font-bold uppercase tracking-widest rounded"
                                style="background: var(--dp-bg-primary); color: var(--dp-gold);">
                                {{ $berita->kategori?->nama ?? 'Berita' }}
                            </span>
                            @if($berita->jenis && $berita->jenis !== 'berita')
                            <span class="inline-block px-3 py-1 text-[10px] font-bold uppercase tracking-widest rounded"
                                style="background: var(--dp-gold-tint); color: var(--dp-gold);">
                                {{ ucfirst($berita->jenis) }}
                            </span>
                            @endif
                        </div>

                        {{-- Title --}}
                        <h1 class="font-display font-black text-2xl md:text-3xl lg:text-4xl leading-tight mb-4"
                            style="color: var(--dp-text-primary);">
                            {{ $berita->judul }}
                        </h1>

                        {{-- Meta info --}}
                        <div class="flex flex-wrap items-center gap-4 text-sm pb-5 mb-6"
                            style="color: var(--dp-text-secondary); border-bottom: 1px solid var(--dp-border);">
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-base">person</span>
                                {{ $berita->user?->name ?? 'Redaksi' }}
                            </span>
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-base">calendar_today</span>
                                {{ $berita->tgl_publish?->translatedFormat('d F Y') }}
                            </span>
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-base">visibility</span>
                                {{ number_format($berita->views) }}x dibaca
                            </span>
                            @if($berita->sumber)
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-base">link</span>
                                Sumber: {{ $berita->sumber }}
                            </span>
                            @endif
                        </div>
                    </header>

                    {{-- Thumbnail --}}
                    @if($berita->thumbnail)
                    <div class="mb-8 rounded-lg overflow-hidden" style="border: 1px solid var(--dp-border);">
                        <img src="{{ asset('storage/' . $berita->thumbnail) }}"
                            alt="{{ $berita->judul }}"
                            class="w-full object-cover aspect-video"
                            fetchpriority="high">
                    </div>
                    @endif

                    {{-- Ringkasan --}}
                    @if($berita->ringkasan)
                    <div class="mb-8 p-4 rounded-lg text-sm italic"
                        style="background: var(--dp-bg-surface-2); border-left: 3px solid var(--dp-gold); color: var(--dp-text-secondary);">
                        {{ $berita->ringkasan }}
                    </div>
                    @endif

                    {{-- Article Body --}}
                    <div class="prose-dp mb-10" style="color: var(--dp-text-primary);">
                        {!! $berita->konten !!}
                    </div>

                    {{-- Tags --}}
                    @if($berita->tags->count())
                    <div class="flex flex-wrap items-center gap-2 mb-8 pb-6"
                        style="border-bottom: 1px solid var(--dp-border);">
                        <span class="material-symbols-outlined text-base" style="color: var(--dp-text-secondary);">sell</span>
                        @foreach($berita->tags as $tag)
                        <a href="{{ route('berita.arsip-tag', $tag->slug) }}"
                            class="inline-block px-3 py-1 rounded-full text-xs font-medium hover:shadow-sm transition-shadow"
                            style="background: var(--dp-primary-tint); color: var(--dp-text-secondary); border: 1px solid var(--dp-border);">
                            #{{ $tag->nama }}
                        </a>
                        @endforeach
                    </div>
                    @endif

                    {{-- Share --}}
                    <div class="flex items-center gap-3 mb-10 pb-8"
                        style="border-bottom: 1px solid var(--dp-border);">
                        <span class="text-sm font-semibold" style="color: var(--dp-text-secondary);">Bagikan:</span>
                        @php $shareUrl = urlencode(request()->url()); $shareTitle = urlencode($berita->judul); @endphp
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener"
                            class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold transition-opacity hover:opacity-80"
                            style="background: #1877F2; color: #fff;">fb</a>
                        <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank" rel="noopener"
                            class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold transition-opacity hover:opacity-80"
                            style="background: #1DA1F2; color: #fff;">tw</a>
                        <a href="https://api.whatsapp.com/send?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank" rel="noopener"
                            class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold transition-opacity hover:opacity-80"
                            style="background: #25D366; color: #fff;">wa</a>
                        <button onclick="navigator.clipboard.writeText(window.location.href);this.textContent='Tersalin!';setTimeout(()=>this.innerHTML='<span class=\'material-symbols-outlined text-base\'>content_copy</span>',2000)"
                            class="w-9 h-9 rounded-full flex items-center justify-center transition-opacity hover:opacity-80"
                            style="background: var(--dp-bg-surface-2); color: var(--dp-text-secondary); border: 1px solid var(--dp-border);">
                            <span class="material-symbols-outlined text-base">content_copy</span>
                        </button>
                    </div>

                    {{-- ═══════════════════════════════════════
                         KOMENTAR
                    ═══════════════════════════════════════ --}}
                    <section class="mb-12" id="komentar">
                        <div class="flex items-center justify-between mb-6"
                            style="border-top: 3px solid var(--dp-bg-primary); padding-top: 0.75rem;">
                            <h2 class="font-display font-bold text-xl" style="color: var(--dp-text-primary);">
                                Komentar ({{ $komentars->count() }})
                            </h2>
                        </div>

                        {{-- Flash message --}}
                        @if(session('komentar_success'))
                        <div class="mb-6 p-4 rounded-lg text-sm font-medium"
                            style="background: var(--dp-gold-tint); color: var(--dp-bg-primary); border: 1px solid var(--dp-border-gold);">
                            <span class="material-symbols-outlined text-base align-middle mr-1">check_circle</span>
                            {{ session('komentar_success') }}
                        </div>
                        @endif

                        {{-- Form komentar --}}
                        <div class="rounded-lg p-5 mb-8"
                            style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                            <h3 class="font-display font-bold text-base mb-4" style="color: var(--dp-text-primary);">
                                Tulis Komentar
                            </h3>
                            <form action="{{ route('berita.komentar.store', $berita->slug) }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-xs font-semibold mb-1" style="color: var(--dp-text-secondary);">Nama <span style="color: var(--dp-danger);">*</span></label>
                                        <input type="text" name="nama" required maxlength="100"
                                            value="{{ old('nama') }}"
                                            placeholder="Nama Anda"
                                            class="w-full px-3 py-2 rounded-md text-sm border focus:outline-none focus:ring-2"
                                            style="background: var(--dp-bg-page); border-color: var(--dp-border-strong); color: var(--dp-text-primary); --tw-ring-color: var(--dp-gold);">
                                        @error('nama')
                                        <span class="text-xs mt-1 block" style="color: var(--dp-danger);">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold mb-1" style="color: var(--dp-text-secondary);">Email <span class="opacity-50">(opsional)</span></label>
                                        <input type="email" name="email" maxlength="150"
                                            value="{{ old('email') }}"
                                            placeholder="email@contoh.com"
                                            class="w-full px-3 py-2 rounded-md text-sm border focus:outline-none focus:ring-2"
                                            style="background: var(--dp-bg-page); border-color: var(--dp-border-strong); color: var(--dp-text-primary); --tw-ring-color: var(--dp-gold);">
                                        @error('email')
                                        <span class="text-xs mt-1 block" style="color: var(--dp-danger);">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-xs font-semibold mb-1" style="color: var(--dp-text-secondary);">Komentar <span style="color: var(--dp-danger);">*</span></label>
                                    <textarea name="konten" required rows="4" maxlength="2000"
                                        placeholder="Tulis komentar Anda di sini..."
                                        class="w-full px-3 py-2 rounded-md text-sm border focus:outline-none focus:ring-2 resize-y"
                                        style="background: var(--dp-bg-page); border-color: var(--dp-border-strong); color: var(--dp-text-primary); --tw-ring-color: var(--dp-gold);">{{ old('konten') }}</textarea>
                                    @error('konten')
                                    <span class="text-xs mt-1 block" style="color: var(--dp-danger);">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="flex items-center justify-between">
                                    <p class="text-xs" style="color: var(--dp-text-secondary); opacity: 0.6;">
                                        Komentar akan tampil setelah disetujui moderator.
                                    </p>
                                    <button type="submit"
                                        class="px-5 py-2 rounded-md text-sm font-bold transition-opacity hover:opacity-90"
                                        style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);">
                                        Kirim Komentar
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Daftar komentar --}}
                        @if($komentars->count())
                        <div class="space-y-6">
                            @foreach($komentars as $komentar)
                            <div class="rounded-lg p-4"
                                style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                                <div class="flex gap-3">
                                    <div class="avatar-initial shrink-0">
                                        {{ strtoupper(substr($komentar->nama, 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="font-semibold text-sm" style="color: var(--dp-text-primary);">{{ $komentar->nama }}</span>
                                            <span class="text-xs" style="color: var(--dp-text-secondary);">{{ $komentar->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-sm leading-relaxed" style="color: var(--dp-text-primary); opacity: 0.85;">
                                            {{ $komentar->konten }}
                                        </p>

                                        {{-- Reply button --}}
                                        <button onclick="document.getElementById('reply-form-{{ $komentar->id }}').classList.toggle('hidden')"
                                            class="mt-2 text-xs font-semibold hover:underline"
                                            style="color: var(--dp-gold);">
                                            <span class="material-symbols-outlined text-xs align-middle">reply</span> Balas
                                        </button>

                                        {{-- Reply form (hidden) --}}
                                        <div id="reply-form-{{ $komentar->id }}" class="hidden mt-3 p-3 rounded-md"
                                            style="background: var(--dp-bg-surface-2);">
                                            <form action="{{ route('berita.komentar.store', $berita->slug) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="parent_id" value="{{ $komentar->id }}">
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                                                    <input type="text" name="nama" required maxlength="100" placeholder="Nama Anda"
                                                        class="w-full px-3 py-2 rounded-md text-xs border focus:outline-none focus:ring-2"
                                                        style="background: var(--dp-bg-page); border-color: var(--dp-border-strong); color: var(--dp-text-primary); --tw-ring-color: var(--dp-gold);">
                                                    <input type="email" name="email" maxlength="150" placeholder="Email (opsional)"
                                                        class="w-full px-3 py-2 rounded-md text-xs border focus:outline-none focus:ring-2"
                                                        style="background: var(--dp-bg-page); border-color: var(--dp-border-strong); color: var(--dp-text-primary); --tw-ring-color: var(--dp-gold);">
                                                </div>
                                                <textarea name="konten" required rows="2" maxlength="2000" placeholder="Tulis balasan..."
                                                    class="w-full px-3 py-2 rounded-md text-xs border focus:outline-none focus:ring-2 resize-y mb-3"
                                                    style="background: var(--dp-bg-page); border-color: var(--dp-border-strong); color: var(--dp-text-primary); --tw-ring-color: var(--dp-gold);"></textarea>
                                                <button type="submit"
                                                    class="px-4 py-1.5 rounded-md text-xs font-bold transition-opacity hover:opacity-90"
                                                    style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);">
                                                    Kirim Balasan
                                                </button>
                                            </form>
                                        </div>

                                        {{-- Replies --}}
                                        @if($komentar->replies->count())
                                        <div class="mt-4 space-y-4 pl-4"
                                            style="border-left: 2px solid var(--dp-border);">
                                            @foreach($komentar->replies as $reply)
                                            <div class="flex gap-3">
                                                <div class="avatar-initial shrink-0" style="width: 32px; height: 32px; font-size: 12px;">
                                                    {{ strtoupper(substr($reply->nama, 0, 1)) }}
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <span class="font-semibold text-xs" style="color: var(--dp-text-primary);">{{ $reply->nama }}</span>
                                                        <span class="text-xs" style="color: var(--dp-text-secondary);">{{ $reply->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <p class="text-xs leading-relaxed" style="color: var(--dp-text-primary); opacity: 0.85;">
                                                        {{ $reply->konten }}
                                                    </p>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-8 rounded-lg"
                            style="background: var(--dp-bg-surface); border: 1px dashed var(--dp-border-strong);">
                            <span class="material-symbols-outlined text-3xl mb-2 block" style="color: var(--dp-text-secondary);">forum</span>
                            <p class="text-sm" style="color: var(--dp-text-secondary);">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                        </div>
                        @endif
                    </section>

                    {{-- ═══════════════════════════════════════
                         REKOMENDASI BERITA (di bawah komentar)
                    ═══════════════════════════════════════ --}}
                    @if($rekomendasi->count())
                    <section class="mb-8">
                        <div class="flex items-center justify-between mb-5"
                            style="border-top: 3px solid var(--dp-bg-primary); padding-top: 0.75rem;">
                            <h2 class="font-display font-bold text-xl" style="color: var(--dp-text-primary);">
                                Berita Terkait
                            </h2>
                            <a href="{{ route('berita.index') }}" class="text-sm font-semibold hover:underline"
                                style="color: var(--dp-gold);">
                                Lihat Semua &rarr;
                            </a>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($rekomendasi as $rekom)
                            <a href="{{ route('berita.show', $rekom->slug) }}"
                                class="group rounded-lg overflow-hidden block hover:shadow-lg transition-shadow"
                                style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                                <div class="aspect-[16/10] overflow-hidden">
                                    <img src="{{ $rekom->thumbnail ? asset('storage/' . $rekom->thumbnail) : 'https://placehold.co/480x300/08332c/ba9e6f?text=DASI+Pelajar' }}"
                                        alt="{{ $rekom->judul }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        loading="lazy">
                                </div>
                                <div class="p-4">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="inline-block px-2 py-0.5 text-[9px] font-bold uppercase tracking-widest rounded"
                                            style="background: var(--dp-bg-primary); color: var(--dp-gold);">
                                            {{ $rekom->kategori?->nama ?? 'Berita' }}
                                        </span>
                                        <span class="text-xs" style="color: var(--dp-text-secondary);">
                                            {{ $rekom->tgl_publish?->translatedFormat('d M Y') }}
                                        </span>
                                    </div>
                                    <h3 class="font-display font-bold text-sm leading-tight line-clamp-2 group-hover:underline"
                                        style="color: var(--dp-text-primary);">
                                        {{ $rekom->judul }}
                                    </h3>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </section>
                    @endif

                </article>

                {{-- ═══════════════════════════════════════════
                     SIDEBAR (Right, sticky)
                ═══════════════════════════════════════════ --}}
                <aside class="w-full lg:w-80 shrink-0">
                    <div class="sticky-sidebar space-y-6">

                        {{-- Ad space --}}
                        <div class="rounded-lg overflow-hidden flex items-center justify-center"
                            style="background: var(--dp-bg-surface-2); border: 1px dashed var(--dp-border-strong); min-height: 250px;">
                            <div class="text-center py-8 px-4">
                                <p class="text-xs font-medium" style="color: var(--dp-text-secondary);">
                                    <span class="material-symbols-outlined text-2xl block mb-2">ad_group</span>
                                    Space Iklan<br>300 x 250
                                </p>
                            </div>
                        </div>

                        {{-- Berita Terbaru --}}
                        <div class="rounded-lg p-4" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                            <h3 class="font-display font-bold text-base mb-4 pb-2"
                                style="color: var(--dp-text-primary); border-bottom: 2px solid var(--dp-gold);">
                                Berita Terbaru
                            </h3>
                            <div class="space-y-4">
                                @forelse($berita_lainnya as $item)
                                <a href="{{ route('berita.show', $item->slug) }}" class="flex gap-3 group">
                                    <div class="w-20 h-16 rounded-md overflow-hidden shrink-0">
                                        <img src="{{ $item->thumbnail ? asset('storage/' . $item->thumbnail) : 'https://placehold.co/160x120/08332c/ba9e6f?text=DP' }}"
                                            alt="{{ $item->judul }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                            loading="lazy">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-semibold leading-tight line-clamp-2 group-hover:underline"
                                            style="color: var(--dp-text-primary);">
                                            {{ $item->judul }}
                                        </h4>
                                        <span class="text-xs mt-1 block" style="color: var(--dp-text-secondary);">
                                            {{ $item->tgl_publish?->translatedFormat('d M Y') }}
                                        </span>
                                    </div>
                                </a>
                                @empty
                                <p class="text-sm italic" style="color: var(--dp-text-secondary);">Belum ada berita lainnya.</p>
                                @endforelse
                            </div>

                            <div class="mt-4 pt-3 text-center" style="border-top: 1px solid var(--dp-border);">
                                <a href="{{ route('berita.index') }}" class="text-sm font-semibold hover:underline"
                                    style="color: var(--dp-gold);">
                                    Lihat Semua Berita &rarr;
                                </a>
                            </div>
                        </div>

                        {{-- Tags --}}
                        @if($berita->tags->count())
                        <div class="rounded-lg p-4" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                            <h3 class="font-display font-bold text-base mb-3 pb-2"
                                style="color: var(--dp-text-primary); border-bottom: 2px solid var(--dp-gold);">
                                Tag Artikel Ini
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($berita->tags as $tag)
                                <a href="{{ route('berita.arsip-tag', $tag->slug) }}"
                                    class="inline-block px-3 py-1 rounded-full text-xs font-medium hover:shadow-sm transition-shadow"
                                    style="background: var(--dp-primary-tint); color: var(--dp-text-secondary); border: 1px solid var(--dp-border);">
                                    #{{ $tag->nama }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- Ad space 2 --}}
                        <div class="rounded-lg overflow-hidden flex items-center justify-center"
                            style="background: var(--dp-bg-surface-2); border: 1px dashed var(--dp-border-strong); min-height: 250px;">
                            <div class="text-center py-8 px-4">
                                <p class="text-xs font-medium" style="color: var(--dp-text-secondary);">
                                    <span class="material-symbols-outlined text-2xl block mb-2">campaign</span>
                                    Space Iklan<br>300 x 250
                                </p>
                            </div>
                        </div>

                    </div>
                </aside>

            </div>
        </div>
    </main>

    @include('partials.footer')
</body>

</html>
