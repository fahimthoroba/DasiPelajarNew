<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DASI PELAJAR KEDIRI</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.png') }}">

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Outfit:wght@400;700;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        emerald: {
                            900: '#022C22',
                            800: '#064E3B', // IPNU Primary
                            400: '#34D399',
                        },
                        amber: {
                            900: '#78350F',
                            700: '#B45309', // IPPNU Primary
                            400: '#FBBF24',
                        },
                        gold: {
                            500: '#C5A059', // Premium Accent
                            600: '#9F803A',
                        },
                        surface: {
                            light: '#F8F8F8',
                            dark: '#121212',
                            card: '#FFFFFF',
                        }
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
        .gradient-text {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-pattern {
            background-color: #064E3B;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2308604b' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
    </style>
    @include('partials.theme-init')
</head>

<body
    class="bg-surface-light dark:bg-[#051111] text-gray-900 dark:text-gray-100 font-body antialiased transition-colors duration-300">

    <!-- NAVBAR -->
    <!-- NAVBAR -->
    @include('partials.navbar')

    <!-- HERO SECTION -->
    <!-- HERO SECTION SLIDER -->
    <header
        class="relative pt-32 pb-24 lg:pt-48 lg:pb-32 overflow-hidden bg-surface-light dark:bg-[#051111] transition-colors duration-300">
        <!-- Abstract Background -->
        <div
            class="absolute top-0 right-0 w-[600px] h-[600px] bg-emerald-100 dark:bg-emerald-900/20 rounded-full blur-3xl opacity-50 -translate-y-1/2 translate-x-1/2">
        </div>
        <div
            class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-amber-50 dark:bg-amber-900/20 rounded-full blur-3xl opacity-60 translate-y-1/2 -translate-x-1/4">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10" data-aos="fade-up">
            <div class="text-center max-w-4xl mx-auto">
                <span
                    class="inline-block py-1 px-3 rounded-full bg-gold-500/10 dark:bg-gold-500/20 text-gold-600 dark:text-gold-400 text-xs font-bold tracking-widest uppercase mb-6 border border-gold-500/20">
                    Sistem Manajemen Organisasi Terpadu
                </span>
                <h1
                    class="font-display font-black text-5xl md:text-7xl text-gray-900 dark:text-white mb-8 leading-tight">
                    Menggerakkan <span
                        class="bg-gradient-to-r from-emerald-800 to-emerald-600 dark:from-emerald-400 dark:to-emerald-600 gradient-text text-transparent">Pelajar</span>,<br>
                    Membangun <span
                        class="bg-gradient-to-r from-amber-700 to-amber-500 dark:from-amber-400 dark:to-amber-600 gradient-text text-transparent">Peradaban.</span>
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-400 mb-10 max-w-2xl mx-auto font-light leading-relaxed">
                    {{ $pengaturan->deskripsi_singkat ?? 'Platform digital resmi PC IPNU IPPNU Kabupaten Kediri. Pusat informasi, kaderisasi, dan administrasi organisasi dalam satu ekosistem.' }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#berita"
                        class="px-8 py-4 bg-emerald-800 text-white rounded-full font-bold text-lg hover:shadow-xl hover:shadow-emerald-800/20 transition-all hover:-translate-y-1">
                        Baca Berita Terkini
                    </a>
                    <a href="{{ route('profil') }}"
                        class="px-8 py-4 bg-white dark:bg-white/5 text-emerald-900 dark:text-white border border-gray-200 dark:border-white/10 rounded-full font-bold text-lg hover:bg-gray-50 dark:hover:bg-white/10 transition-all hover:-translate-y-1">
                        Tentang Kami
                    </a>
                </div>
            </div>

            <!-- Stats Cards (Floating) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-20 max-w-5xl mx-auto">
                <div
                    class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl shadow-gray-200/50 dark:shadow-none border-b-4 border-emerald-800 relative overflow-hidden group hover:-translate-y-2 transition-transform">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="w-16 h-16 text-emerald-800 dark:text-emerald-500" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                            </path>
                        </svg>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 font-medium text-sm uppercase tracking-wider mb-2">Total
                        Pelajar</p>
                    <h3 class="font-display font-black text-4xl text-emerald-900 dark:text-white">
                        {{ number_format($statistik['total_kader']) }}
                    </h3>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl shadow-gray-200/50 dark:shadow-none border-b-4 border-amber-700 relative overflow-hidden group hover:-translate-y-2 transition-transform">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="w-16 h-16 text-amber-700 dark:text-amber-500" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10.496 2.132a1 1 0 00-.992 0l-7 4A1 1 0 003 8v7a1 1 0 100 2h14a1 1 0 100-2V8a1 1 0 00.504-1.868l-7-4zM6 9a1 1 0 00-1 1v3a1 1 0 102 0v-3a1 1 0 00-1-1zm3 1a1 1 0 012 0v3a1 1 0 11-2 0v-3zm5-1a1 1 0 00-1 1v3a1 1 0 102 0v-3a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 font-medium text-sm uppercase tracking-wider mb-2">PAC
                        Aktif</p>
                    <h3 class="font-display font-black text-4xl text-amber-700 dark:text-amber-500">
                        {{ $statistik['total_pac'] }} <span class="text-lg text-gray-400 font-normal">Kecamatan</span>
                    </h3>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl shadow-gray-200/50 dark:shadow-none border-b-4 border-gold-500 relative overflow-hidden group hover:-translate-y-2 transition-transform">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="w-16 h-16 text-gold-600 dark:text-gold-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 font-medium text-sm uppercase tracking-wider mb-2">
                        Ranting Aktif</p>
                    <h3 class="font-display font-black text-4xl text-gold-600 dark:text-gold-500">
                        {{ $statistik['total_ranting'] }} <span class="text-lg text-gray-400 font-normal">Desa</span>
                    </h3>
                </div>
            </div>
        </div>
    </header>



    <!-- NEWS/MAGAZINE SECTION -->
    <section id="berita" class="py-24 bg-white dark:bg-[#051111] relative transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="font-display font-black text-3xl md:text-5xl text-gray-900 dark:text-white mb-2">Berita
                        <span class="text-emerald-800 dark:text-emerald-500">Terkini</span>
                    </h2>
                    <p class="text-gray-500 dark:text-gray-400 text-lg">Kabar organisasi dan wawasan keislaman.</p>
                </div>
                <a href="{{ route('berita.index') }}"
                    class="flex items-center gap-2 font-bold text-emerald-800 hover:text-emerald-600 transition-colors">
                    Lihat Semua Berita <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>

            <!-- Bento Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 md:grid-rows-2 gap-4 md:gap-6 h-auto md:h-[600px]">

                @if(isset($berita_terbaru[0]))
                    <!-- Main News (Big Left) -->
                    <div
                        class="md:col-span-2 md:row-span-2 group relative bg-white dark:bg-gray-800 rounded-2xl md:rounded-3xl shadow-sm md:shadow-lg overflow-hidden flex flex-row md:block items-center transition-all p-3 md:p-0 gap-4 md:gap-0 border border-gray-100 dark:border-white/5 md:border-none">
                        <!-- Image -->
                        <div
                            class="order-last md:order-none w-24 h-24 md:absolute md:inset-0 md:w-full md:h-full shrink-0 rounded-lg md:rounded-none overflow-hidden">
                            <img src="{{ $berita_terbaru[0]['image_url'] }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        </div>

                        <!-- Overlay only on Desktop -->
                        <div
                            class="hidden md:block absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent">
                        </div>

                        <!-- Content -->
                        <div class="flex-1 md:absolute md:bottom-0 md:p-8 relative z-10">
                            <span
                                class="md:px-3 md:py-1 md:bg-emerald-600 md:text-white text-emerald-600 dark:text-emerald-400 md:text-xs text-[10px] font-bold md:rounded-full md:mb-4 inline-block tracking-wide uppercase">Highlight</span>
                            <a href="{{ route('berita.show', $berita_terbaru[0]['slug']) }}">
                                <h3
                                    class="text-sm md:text-3xl font-display font-bold text-gray-900 dark:text-white md:text-white mb-1 md:mb-2 leading-tight group-hover:text-emerald-600 md:group-hover:text-emerald-300 transition-colors line-clamp-2 md:line-clamp-3">
                                    {{ $berita_terbaru[0]['judul'] }}
                                </h3>
                            </a>
                            <p class="hidden md:block text-gray-300 line-clamp-2 text-sm">
                                {{ $berita_terbaru[0]['summary'] }}
                            </p>

                            <!-- Mobile Meta -->
                            <div class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 md:hidden">
                                {{ $berita_terbaru[0]['tanggal'] }}
                            </div>
                        </div>
                    </div>
                @endif

                @if(isset($berita_terbaru[1]))
                    <!-- Top Right 1 -->
                    <div
                        class="md:col-span-1 md:row-span-1 group relative bg-white dark:bg-gray-800 rounded-2xl md:rounded-3xl shadow-sm md:shadow-md overflow-hidden flex flex-row md:block items-center transition-all p-3 md:p-0 gap-4 md:gap-0 border border-gray-100 dark:border-white/5 md:border-none">
                        <div
                            class="order-last md:order-none w-24 h-24 md:absolute md:inset-0 md:w-full md:h-full shrink-0 rounded-lg md:rounded-none overflow-hidden">
                            <img src="{{ $berita_terbaru[1]['image_url'] }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        </div>
                        <div class="hidden md:block absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                        <div class="flex-1 md:absolute md:bottom-0 md:p-6 relative z-10">
                            <span
                                class="text-amber-500 md:text-amber-400 text-[10px] md:text-xs font-bold uppercase tracking-wider mb-1 block">{{ $berita_terbaru[1]['kategori'] ?? 'Info' }}</span>
                            <a href="{{ route('berita.show', $berita_terbaru[1]['slug']) }}">
                                <h3
                                    class="text-sm md:text-lg font-display font-bold text-gray-900 dark:text-white md:text-white leading-tight md:group-hover:underline line-clamp-2">
                                    {{ $berita_terbaru[1]['judul'] }}
                                </h3>
                            </a>
                            <div class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 md:hidden">
                                {{ $berita_terbaru[1]['tanggal'] }}
                            </div>
                        </div>
                    </div>
                @endif

                @if(isset($berita_terbaru[2]))
                    <!-- Top Right 2 -->
                    <div
                        class="md:col-span-1 md:row-span-1 group relative bg-white dark:bg-gray-800 rounded-2xl md:rounded-3xl shadow-sm md:shadow-md overflow-hidden flex flex-row md:block items-center transition-all p-3 md:p-0 gap-4 md:gap-0 border border-gray-100 dark:border-white/5 md:border-none">
                        <div
                            class="order-last md:order-none w-24 h-24 md:absolute md:inset-0 md:w-full md:h-full shrink-0 rounded-lg md:rounded-none overflow-hidden">
                            <img src="{{ $berita_terbaru[2]['image_url'] }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        </div>
                        <div class="hidden md:block absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                        <div class="flex-1 md:absolute md:bottom-0 md:p-6 relative z-10">
                            <span
                                class="text-emerald-500 md:text-emerald-400 text-[10px] md:text-xs font-bold uppercase tracking-wider mb-1 block">{{ $berita_terbaru[2]['kategori'] ?? 'Info' }}</span>
                            <a href="{{ route('berita.show', $berita_terbaru[2]['slug']) }}">
                                <h3
                                    class="text-sm md:text-lg font-display font-bold text-gray-900 dark:text-white md:text-white leading-tight md:group-hover:underline line-clamp-2">
                                    {{ $berita_terbaru[2]['judul'] }}
                                </h3>
                            </a>
                            <div class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 md:hidden">
                                {{ $berita_terbaru[2]['tanggal'] }}
                            </div>
                        </div>
                    </div>
                @endif

                @if(isset($berita_terbaru[3]))
                    <!-- Bottom Wide -->
                    <div
                        class="md:col-span-2 md:row-span-1 bg-white dark:bg-gray-800 md:bg-surface-light md:dark:bg-gray-800 rounded-2xl md:rounded-3xl p-3 md:p-6 flex items-center gap-4 md:gap-6 border border-gray-100 dark:border-white/10 hover:border-emerald-200 dark:hover:border-emerald-500/50 transition-colors group cursor-pointer shadow-sm md:shadow-none">
                        <div
                            class="w-24 h-24 md:w-1/3 md:h-full rounded-lg md:rounded-2xl overflow-hidden relative shrink-0 order-last md:order-first">
                            <img src="{{ $berita_terbaru[3]['image_url'] }}"
                                class="absolute inset-0 w-full h-full object-cover">
                        </div>
                        <div class="flex-1">
                            <div class="hidden md:flex items-center gap-2 mb-2 text-xs text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $berita_terbaru[3]['tanggal'] }}
                            </div>
                            <span
                                class="md:hidden text-indigo-500 text-[10px] font-bold uppercase tracking-wider mb-1 block">{{ $berita_terbaru[3]['kategori'] ?? 'Artikel' }}</span>
                            <a href="{{ route('berita.show', $berita_terbaru[3]['slug']) }}">
                                <h3
                                    class="text-sm md:text-xl font-display font-bold text-gray-900 dark:text-white mb-1 md:mb-2 line-clamp-2 group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors">
                                    {{ $berita_terbaru[3]['judul'] }}
                                </h3>
                            </a>
                            <p class="hidden md:block text-gray-500 dark:text-gray-400 text-sm line-clamp-2">
                                {{ $berita_terbaru[3]['summary'] }}
                            </p>
                            <div class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 md:hidden">
                                {{ $berita_terbaru[3]['tanggal'] }}
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </section>

    <!-- PROGRAM CHECKER -->
    <section id="program" class="py-24 bg-gray-50 dark:bg-[#0b1717] transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div>
                    <span
                        class="text-gold-600 dark:text-gold-500 font-bold tracking-widest uppercase text-sm mb-2 block">Agenda
                        Organisasi</span>
                    <h2 class="font-display font-black text-4xl text-gray-900 dark:text-white mb-6">Program Kerja <br>&
                        <span class="text-emerald-800 dark:text-emerald-500">Kegiatan Terdekat</span>
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md text-lg">Pantau terus kegiatan PC IPNU
                        IPPNU Kediri. Jangan
                        lewatkan momentum kaderisasi dan syiar organisasi.</p>

                    <a href="{{ route('agenda') }}"
                        class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-emerald-800 text-white shadow-lg shadow-emerald-800/20 hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($agenda_terdekat as $prog)
                        <div
                            class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-white/10 flex items-center gap-6 group hover:border-emerald-200 dark:hover:border-emerald-500/50 transition-all">
                            <div
                                class="flex-shrink-0 w-16 h-16 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-400 rounded-xl flex flex-col items-center justify-center border border-emerald-100 dark:border-white/5">
                                <span
                                    class="text-xs font-bold uppercase">{{ date('M', strtotime($prog['tgl_raw'])) }}</span>
                                <span
                                    class="text-2xl font-black font-display">{{ date('d', strtotime($prog['tgl_raw'])) }}</span>
                            </div>
                            <div class="flex-grow">
                                <h4
                                    class="font-bold text-lg text-gray-900 dark:text-white group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors">
                                    {{ $prog['nama_acara'] }}
                                </h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    <span
                                        class="font-bold uppercase tracking-wider text-[10px] px-2 py-0.5 rounded-full {{ $prog['countdown'] == 'Sedang Dilaksanakan' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-400 animate-pulse' : 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' }}">
                                        {{ $prog['countdown'] }}
                                    </span>
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <button class="p-2 text-gray-300 hover:text-emerald-600 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-gray-400 italic">Belum ada program terjadwal.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- STRUKTUR PENGURUS ANIMATION -->
    <section class="py-24 bg-white dark:bg-[#051111] overflow-hidden relative transition-colors duration-300"
        id="struktur">
        <style>
            .marquee-container {
                mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
            }

            @keyframes marquee {
                0% {
                    transform: translateX(0%);
                }

                100% {
                    transform: translateX(-50%);
                }
            }

            .animate-marquee {
                animation: marquee 80s linear infinite;
                width: max-content;
            }

            .animate-marquee:hover {
                animation-play-state: paused;
            }

            @keyframes marqueeReverse {
                0% {
                    transform: translateX(-50%);
                }

                100% {
                    transform: translateX(0%);
                }
            }

            .animate-marquee-reverse {
                animation: marqueeReverse 80s linear infinite;
                width: max-content;
            }

            .animate-marquee-reverse:hover {
                animation-play-state: paused;
            }
        </style>

        <!-- IPNU SECTION -->
        <div class="mb-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8 flex justify-between items-end">
                <div>
                    <span
                        class="text-emerald-600 dark:text-emerald-500 font-bold tracking-widest uppercase text-sm mb-2 block">Struktur
                        Organisasi</span>
                    <h3 class="font-display font-black text-3xl md:text-4xl text-gray-900 dark:text-white">
                        Pengurus <span class="text-emerald-800 dark:text-emerald-500">IPNU</span>
                    </h3>
                </div>
                <a href="{{ route('struktur-organisasi', ['tab' => 'ipnu']) }}"
                    class="text-emerald-800 dark:text-emerald-400 font-bold flex items-center gap-2 hover:gap-3 transition-all">Lihat
                    Bagan Lengkap <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg></a>
            </div>

            <!-- IPNU Swiper -->
            <div class="swiper mySwiper-ipnu w-full px-4 pb-12">
                <div class="swiper-wrapper">
                    @forelse($pengurusIpnu as $p)
                        <div class="swiper-slide w-[300px]">
                            <div
                                class="flex flex-col gap-3 bg-surface-light dark:bg-gray-800 border border-gray-100 dark:border-white/10 rounded-xl p-4 hover:border-emerald-200 dark:hover:border-emerald-500/50 hover:shadow-lg transition-all h-full group">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-14 h-14 rounded-full overflow-hidden border-2 border-emerald-100 dark:border-emerald-800 group-hover:border-emerald-500 transition-colors shrink-0">
                                        <img src="{{ $p->kader->foto_path ? asset('storage/' . $p->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($p->kader->nama_lengkap) . '&background=059669&color=fff' }}"
                                            alt="{{ $p->kader->nama_lengkap }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                    <div>
                                        <h5
                                            class="text-gray-900 dark:text-white font-bold text-base leading-tight font-display">
                                            {{ \Illuminate\Support\Str::words($p->kader->nama_lengkap, 2, '') }}
                                        </h5>
                                        <p
                                            class="text-emerald-600 dark:text-emerald-400 text-xs font-bold uppercase tracking-wide">
                                            {{ $p->jabatan }}
                                        </p>
                                    </div>
                                </div>
                                <!-- Quote -->
                                @if($p->kader->quote)
                                    <div
                                        class="relative bg-emerald-50 dark:bg-emerald-900/30 rounded-lg p-3 mt-1 group-hover:bg-emerald-100/50 dark:group-hover:bg-emerald-900/50 transition-colors">
                                        <span
                                            class="absolute top-2 left-2 text-emerald-200 dark:text-emerald-700 text-4xl font-serif leading-3 opacity-50">“</span>
                                        <p
                                            class="text-emerald-800 dark:text-emerald-300 text-xs italic leading-relaxed relative z-10 pl-2">
                                            {{ \Illuminate\Support\Str::limit($p->kader->quote, 60) }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="swiper-slide w-full text-center text-gray-400 italic">Data Pengurus Sedang Diupdate.</div>
                    @endforelse
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>

        <!-- IPPNU SECTION -->
        <div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8 flex justify-between items-end">
                <div>
                    <h3 class="font-display font-black text-3xl md:text-4xl text-gray-900">
                        Pengurus <span class="text-amber-500">IPPNU</span>
                    </h3>
                </div>
                <a href="{{ route('struktur-organisasi', ['tab' => 'ippnu']) }}"
                    class="text-amber-600 font-bold flex items-center gap-2 hover:gap-3 transition-all">Lihat Bagan
                    Lengkap <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg></a>
            </div>

            <!-- IPPNU Swiper -->
            <div class="swiper mySwiper-ippnu w-full px-4 pb-12">
                <div class="swiper-wrapper">
                    @forelse($pengurusIppnu as $p)
                        <div class="swiper-slide w-[300px]">
                            <div
                                class="flex flex-col gap-3 bg-surface-light dark:bg-gray-800 border border-gray-100 dark:border-white/10 rounded-xl p-4 hover:border-amber-200 dark:hover:border-amber-500/50 hover:shadow-lg transition-all h-full group">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-14 h-14 rounded-full overflow-hidden border-2 border-amber-100 dark:border-amber-800 group-hover:border-amber-500 transition-colors shrink-0">
                                        <img src="{{ $p->kader->foto_path ? asset('storage/' . $p->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($p->kader->nama_lengkap) . '&background=f59e0b&color=fff' }}"
                                            alt="{{ $p->kader->nama_lengkap }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                    <div>
                                        <h5
                                            class="text-gray-900 dark:text-white font-bold text-base leading-tight font-display">
                                            {{ \Illuminate\Support\Str::words($p->kader->nama_lengkap, 2, '') }}
                                        </h5>
                                        <p
                                            class="text-amber-600 dark:text-amber-500 text-xs font-bold uppercase tracking-wide">
                                            {{ $p->jabatan }}
                                        </p>
                                    </div>
                                </div>
                                @if($p->kader->quote)
                                    <div
                                        class="relative bg-amber-50 dark:bg-amber-900/30 rounded-lg p-3 mt-1 group-hover:bg-amber-100/50 dark:group-hover:bg-amber-900/50 transition-colors">
                                        <span
                                            class="absolute top-2 left-2 text-amber-300 dark:text-amber-700 text-4xl font-serif leading-3 opacity-50">“</span>
                                        <p
                                            class="text-amber-800 dark:text-amber-300 text-xs italic leading-relaxed relative z-10 pl-2">
                                            {{ \Illuminate\Support\Str::limit($p->kader->quote, 60) }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="swiper-slide w-full text-center text-gray-400 italic">Data Pengurus Sedang Diupdate.</div>
                    @endforelse
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var heroSwiper = new Swiper(".mySwiper", {
            spaceBetween: 0,
            centeredSlides: true,
            effect: "fade",
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });

        var ipnuSwiper = new Swiper(".mySwiper-ipnu", {
            slidesPerView: 1,
            spaceBetween: 20,
            autoplay: {
                delay: 2000,
                disableOnInteraction: false,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });

        var ippnuSwiper = new Swiper(".mySwiper-ippnu", {
            slidesPerView: 1,
            spaceBetween: 20,
            autoplay: {
                delay: 2500, // Slightly different speed for visual variety
                disableOnInteraction: false,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
    </script>
</body>

</html>