<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $berita->judul }} - {{ $pengaturan->nama_website ?? 'PC IPNU IPPNU Kediri' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        emerald: { 900: '#022C22', 800: '#064E3B', 600: '#059669', 500: '#10b981', 400: '#34D399', 50: '#ecfdf5' },
                        amber: { 900: '#78350F', 700: '#B45309', 400: '#FBBF24', 50: '#fffbeb' },
                        gold: { 500: '#C5A059', 600: '#9F803A' },
                        surface: { light: '#F8F8F8', card: '#FFFFFF', dark: '#121212' }
                    },
                    fontFamily: {
                        display: ['Outfit', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .prose h1,
        .prose h2,
        .prose h3 {
            font-family: 'Outfit', sans-serif;
        }

        /* Prose Dark Mode fix */
        :is(.dark .prose) {
            color: #d1d5db;
        }

        :is(.dark .prose h1),
        :is(.dark .prose h2),
        :is(.dark .prose h3),
        :is(.dark .prose h4),
        :is(.dark .prose strong) {
            color: #f9fafb;
        }
    </style>
    @include('partials.theme-init')
</head>

<body
    class="bg-surface-light dark:bg-[#051111] text-gray-900 dark:text-gray-100 font-body antialiased transition-colors duration-300">

    @include('partials.navbar')

    <main class="pt-32 pb-24 px-4 sm:px-6 relative min-h-screen">
        <!-- Abstract Background -->
        <div
            class="absolute top-20 left-0 w-96 h-96 bg-emerald-500/5 dark:bg-emerald-500/10 rounded-full blur-3xl -translate-x-1/2 pointer-events-none">
        </div>
        <div
            class="absolute top-40 right-0 w-96 h-96 bg-amber-500/5 dark:bg-amber-500/10 rounded-full blur-3xl translate-x-1/2 pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto relative z-10">
            <!-- Breadcrumb -->
            <nav class="flex mb-8 text-sm text-gray-500 animate-fade-in-up">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center hover:text-emerald-800 transition-colors">
                            <span class="material-symbols-outlined text-lg mr-1">home</span>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <span class="material-symbols-outlined text-lg">chevron_right</span>
                            <a href="{{ route('berita.index') }}"
                                class="ml-1 hover:text-emerald-800 dark:hover:text-emerald-400 transition-colors">Berita</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <span class="material-symbols-outlined text-lg">chevron_right</span>
                            <span
                                class="ml-1 text-gray-900 dark:text-gray-100 font-medium truncate max-w-[200px]">{{ \Illuminate\Support\Str::limit($berita->judul, 20) }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-8">
                    <article
                        class="bg-white dark:bg-gray-800 rounded-3xl p-6 md:p-10 shadow-xl shadow-gray-100 dark:shadow-none border border-gray-100 dark:border-white/10 transition-colors">
                        <!-- Header -->
                        <div class="mb-8 border-b border-gray-100 dark:border-white/10 pb-8">
                            <div
                                class="flex flex-wrap items-center gap-4 text-xs md:text-sm text-gray-500 dark:text-gray-400 mb-6">
                                <span
                                    class="bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 px-3 py-1 rounded-full font-bold uppercase tracking-wider text-[10px] border border-emerald-100 dark:border-white/5">
                                    {{ $berita->kategoriBerita->nama_kategori ?? 'Berita' }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                                    {{ \Carbon\Carbon::parse($berita->tgl_publish)->translatedFormat('d F Y') }}
                                </span>
                                <span class="w-1 h-1 rounded-full bg-gray-300 dark:bg-gray-600"></span>
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px]">person</span>
                                    {{ $berita->user->name ?? 'Admin' }}
                                </span>
                            </div>

                            <h1
                                class="font-display font-black text-3xl md:text-4xl lg:text-5xl text-gray-900 dark:text-white leading-tight mb-6">
                                {{ $berita->judul }}
                            </h1>
                        </div>

                        <!-- Hero Image -->
                        @if($berita->thumbnail)
                            <div class="mb-10 rounded-2xl overflow-hidden relative group">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-10">
                                </div>
                                <img src="{{ asset('storage/' . $berita->thumbnail) }}" alt="{{ $berita->judul }}"
                                    class="w-full object-cover aspect-video group-hover:scale-105 transition-transform duration-700">
                            </div>
                        @endif

                        <!-- Body -->
                        <div
                            class="prose prose-lg prose-emerald max-w-none text-gray-600 dark:text-gray-300 leading-loose prose-headings:text-gray-900 dark:prose-headings:text-white prose-img:rounded-xl">
                            {!! $berita->konten !!}
                        </div>

                        <!-- Share / Tags (Optional) -->
                        <div class="mt-12 pt-8 border-t border-gray-100 dark:border-white/10">
                            <h4 class="font-bold text-gray-900 dark:text-white mb-4">Bagikan Berita</h4>
                            <div class="flex gap-2">
                                <button
                                    class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all"><span
                                        class="font-bold">fb</span></button>
                                <button
                                    class="w-10 h-10 rounded-full bg-sky-50 text-sky-500 flex items-center justify-center hover:bg-sky-500 hover:text-white transition-all"><span
                                        class="font-bold">tw</span></button>
                                <button
                                    class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center hover:bg-green-600 hover:text-white transition-all"><span
                                        class="font-bold">wa</span></button>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-4 space-y-8">
                    <!-- Recent Posts -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-xl shadow-gray-100 dark:shadow-none border border-gray-100 dark:border-white/10 sticky top-28 transition-colors">
                        <h3
                            class="font-display font-bold text-xl text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <span class="w-1 h-6 bg-emerald-600 rounded-full"></span>
                            Berita Terbaru
                        </h3>
                        <div class="space-y-6">
                            @forelse($berita_lainnya as $item)
                                <a href="{{ route('berita.show', $item->slug) }}"
                                    class="group flex gap-4 items-start pb-6 border-b border-gray-50 dark:border-white/5 last:border-0 last:pb-0">
                                    <div
                                        class="w-20 h-20 rounded-xl overflow-hidden shrink-0 relative bg-gray-100 dark:bg-gray-700">
                                        <img src="{{ $item->thumbnail ? asset('storage/' . $item->thumbnail) : 'https://placehold.co/100x100?text=No+Image' }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4
                                            class="font-bold text-sm text-gray-800 dark:text-gray-200 line-clamp-2 leading-snug group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors">
                                            {{ $item->judul }}
                                        </h4>
                                        <p class="text-xs text-gray-400 mt-2 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[12px]">calendar_today</span>
                                            {{ \Carbon\Carbon::parse($item->tgl_publish)->translatedFormat('d M Y') }}
                                        </p>
                                    </div>
                                </a>
                            @empty
                                <p class="text-gray-400 text-sm italic">Belum ada berita lainnya.</p>
                            @endforelse
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100 dark:border-white/10 text-center">
                            <a href="{{ route('berita.index') }}"
                                class="inline-flex items-center gap-2 text-sm font-bold text-emerald-800 dark:text-emerald-400 hover:text-emerald-900 dark:hover:text-emerald-300 transition-colors">
                                Lihat Semua Berita <span class="material-symbols-outlined">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>

</html>