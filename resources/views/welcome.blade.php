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

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .gradient-text {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Ambient floating blobs */
        @keyframes floatBlob1 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -40px) scale(1.05); }
            66% { transform: translate(-20px, 20px) scale(0.97); }
        }
        @keyframes floatBlob2 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(-40px, 30px) scale(1.03); }
            66% { transform: translate(25px, -20px) scale(0.98); }
        }
        @keyframes floatBlob3 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(20px, 30px) scale(1.04); }
        }
        .blob-1 { animation: floatBlob1 12s ease-in-out infinite; }
        .blob-2 { animation: floatBlob2 15s ease-in-out infinite; }
        .blob-3 { animation: floatBlob3 10s ease-in-out infinite; }
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
        <!-- Ambient Animated Background -->
        <div class="blob-1 absolute top-0 right-0 w-[700px] h-[700px] rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"
            style="background: radial-gradient(circle, rgba(8,51,44,0.12) 0%, transparent 70%);">
        </div>
        <div class="blob-2 absolute bottom-0 left-0 w-[600px] h-[600px] rounded-full blur-3xl translate-y-1/3 -translate-x-1/4"
            style="background: radial-gradient(circle, rgba(186,158,111,0.10) 0%, transparent 70%);">
        </div>
        <div class="blob-3 absolute top-1/2 left-1/2 w-[400px] h-[400px] rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2 opacity-40"
            style="background: radial-gradient(circle, rgba(8,51,44,0.06) 0%, transparent 70%);">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10" data-aos="fade-up">
            <div class="text-center max-w-4xl mx-auto">
                <span
                    class="inline-block py-1 px-3 rounded-full bg-[#ba9e6f]/10 dark:bg-[#ba9e6f]/20 text-[#ba9e6f] text-xs font-bold tracking-widest uppercase mb-6 border border-[#ba9e6f]/20">
                    Sistem Manajemen Organisasi Terpadu
                </span>
                <h1
                    class="font-display font-black text-3xl sm:text-5xl md:text-7xl text-gray-900 dark:text-white mb-8 leading-tight">
                    Menggerakkan <span
                        class="bg-gradient-to-r from-[#08332c] to-[#0f4a3a] dark:from-emerald-400 dark:to-emerald-600 gradient-text text-transparent">Pelajar</span>,<br>
                    Membangun <span
                        class="bg-gradient-to-r from-[#ba9e6f] to-[#d4bc91] gradient-text text-transparent">Peradaban.</span>
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-400 mb-10 max-w-2xl mx-auto font-light leading-relaxed">
                    {{ $pengaturan->deskripsi_singkat ?? 'Platform digital resmi PC IPNU IPPNU Kabupaten Kediri. Pusat informasi, kaderisasi, dan administrasi organisasi dalam satu ekosistem.' }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#berita"
                        class="px-8 py-4 bg-[#08332c] text-white rounded-full font-bold text-lg hover:bg-[#0f4a3a] hover:shadow-xl hover:shadow-[#08332c]/20 transition-all hover:-translate-y-1">
                        Baca Berita Terkini
                    </a>
                    <a href="{{ route('profil') }}"
                        class="px-8 py-4 bg-white dark:bg-white/5 text-[#08332c] dark:text-white border border-gray-200 dark:border-white/10 rounded-full font-bold text-lg hover:bg-gray-50 dark:hover:bg-white/10 transition-all hover:-translate-y-1">
                        Tentang Kami
                    </a>
                </div>
            </div>

            <!-- Stats Cards (Floating) -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-20 max-w-5xl mx-auto">

                {{-- Total Pelajar --}}
                <div class="bg-white dark:bg-[#0f2a1e] p-6 rounded-2xl border border-[#08332c]/10 dark:border-[#ba9e6f]/10 shadow-md hover:shadow-xl hover:-translate-y-2 hover:border-[#08332c]/30 dark:hover:border-[#ba9e6f]/25 transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-3 opacity-[0.07] group-hover:opacity-15 transition-opacity duration-300">
                        <svg class="w-14 h-14 text-[#08332c] dark:text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                        </svg>
                    </div>
                    <div class="w-8 h-1 bg-[#08332c] rounded-full mb-3"></div>
                    <p class="text-[#4a6b60] dark:text-white/50 font-medium text-xs uppercase tracking-wider mb-1">Total Pelajar</p>
                    <h3 class="font-display font-black text-3xl text-[#08332c] dark:text-white">
                        {{ number_format($statistik['total_kader']) }}
                    </h3>
                </div>

                {{-- PAC Aktif --}}
                <div class="bg-white dark:bg-[#0f2a1e] p-6 rounded-2xl border border-[#08332c]/10 dark:border-[#ba9e6f]/10 shadow-md hover:shadow-xl hover:-translate-y-2 hover:border-[#ba9e6f]/40 dark:hover:border-[#ba9e6f]/25 transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-3 opacity-[0.07] group-hover:opacity-15 transition-opacity duration-300">
                        <svg class="w-14 h-14 text-[#ba9e6f]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10.496 2.132a1 1 0 00-.992 0l-7 4A1 1 0 003 8v7a1 1 0 100 2h14a1 1 0 100-2V8a1 1 0 00.504-1.868l-7-4zM6 9a1 1 0 00-1 1v3a1 1 0 102 0v-3a1 1 0 00-1-1zm3 1a1 1 0 012 0v3a1 1 0 11-2 0v-3zm5-1a1 1 0 00-1 1v3a1 1 0 102 0v-3a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="w-8 h-1 bg-[#ba9e6f] rounded-full mb-3"></div>
                    <p class="text-[#4a6b60] dark:text-white/50 font-medium text-xs uppercase tracking-wider mb-1">PAC Aktif</p>
                    <h3 class="font-display font-black text-3xl text-[#ba9e6f]">
                        {{ $statistik['total_pac'] }}
                        <span class="text-sm text-[#4a6b60] dark:text-white/40 font-normal">Kec.</span>
                    </h3>
                </div>

                {{-- PK Aktif --}}
                <div class="bg-white dark:bg-[#0f2a1e] p-6 rounded-2xl border border-[#08332c]/10 dark:border-[#ba9e6f]/10 shadow-md hover:shadow-xl hover:-translate-y-2 hover:border-[#08332c]/30 dark:hover:border-[#ba9e6f]/25 transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-3 opacity-[0.07] group-hover:opacity-15 transition-opacity duration-300">
                        <svg class="w-14 h-14 text-[#08332c] dark:text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    <div class="w-8 h-1 bg-[#08332c] rounded-full mb-3"></div>
                    <p class="text-[#4a6b60] dark:text-white/50 font-medium text-xs uppercase tracking-wider mb-1">PK Aktif</p>
                    <h3 class="font-display font-black text-3xl text-[#08332c] dark:text-white">
                        {{ $statistik['total_pk'] ?? 0 }}
                        <span class="text-sm text-[#4a6b60] dark:text-white/40 font-normal">Unit</span>
                    </h3>
                </div>

                {{-- Ranting Aktif --}}
                <div class="bg-white dark:bg-[#0f2a1e] p-6 rounded-2xl border border-[#08332c]/10 dark:border-[#ba9e6f]/10 shadow-md hover:shadow-xl hover:-translate-y-2 hover:border-[#ba9e6f]/40 dark:hover:border-[#ba9e6f]/25 transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-3 opacity-[0.07] group-hover:opacity-15 transition-opacity duration-300">
                        <svg class="w-14 h-14 text-[#ba9e6f]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="w-8 h-1 bg-[#ba9e6f] rounded-full mb-3"></div>
                    <p class="text-[#4a6b60] dark:text-white/50 font-medium text-xs uppercase tracking-wider mb-1">Ranting Aktif</p>
                    <h3 class="font-display font-black text-3xl text-[#ba9e6f]">
                        {{ $statistik['total_ranting'] }}
                        <span class="text-sm text-[#4a6b60] dark:text-white/40 font-normal">Desa</span>
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
                        <span class="text-[#08332c] dark:text-[#ba9e6f]">Terkini</span>
                    </h2>
                    <p class="text-gray-500 dark:text-gray-400 text-lg">Kabar organisasi dan wawasan keislaman.</p>
                </div>
                <a href="{{ route('berita.index') }}"
                    class="flex items-center gap-2 font-bold text-[#ba9e6f] hover:text-[#d4bc91] transition-colors">
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
                        class="md:col-span-2 md:row-span-2 group relative bg-white dark:bg-[#0f2a1e] rounded-2xl md:rounded-3xl shadow-sm md:shadow-lg overflow-hidden flex flex-row md:block items-center transition-all hover:-translate-y-1 hover:shadow-xl duration-300 p-3 md:p-0 gap-4 md:gap-0 border border-[#08332c]/8 dark:border-[#ba9e6f]/10 md:border-none">
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
                                class="md:px-3 md:py-1 md:bg-[#08332c] md:text-white text-[#08332c] dark:text-[#ba9e6f] md:text-xs text-[10px] font-bold md:rounded-full md:mb-4 inline-block tracking-wide uppercase">Highlight</span>
                            <a href="{{ route('berita.show', $berita_terbaru[0]['slug']) }}">
                                <h3
                                    class="text-sm md:text-3xl font-display font-bold text-gray-900 dark:text-white md:text-white mb-1 md:mb-2 leading-tight group-hover:text-[#08332c] md:group-hover:text-[#ba9e6f] transition-colors line-clamp-2 md:line-clamp-3">
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
                        class="md:col-span-1 md:row-span-1 group relative bg-white dark:bg-[#0f2a1e] rounded-2xl md:rounded-3xl shadow-sm md:shadow-md overflow-hidden flex flex-row md:block items-center transition-all hover:-translate-y-1 hover:shadow-xl duration-300 p-3 md:p-0 gap-4 md:gap-0 border border-[#08332c]/8 dark:border-[#ba9e6f]/10 md:border-none">
                        <div
                            class="order-last md:order-none w-24 h-24 md:absolute md:inset-0 md:w-full md:h-full shrink-0 rounded-lg md:rounded-none overflow-hidden">
                            <img src="{{ $berita_terbaru[1]['image_url'] }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        </div>
                        <div class="hidden md:block absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                        <div class="flex-1 md:absolute md:bottom-0 md:p-6 relative z-10">
                            <span
                                class="text-[#ba9e6f] text-[10px] md:text-xs font-bold uppercase tracking-wider mb-1 block">{{ $berita_terbaru[1]['kategori'] ?? 'Info' }}</span>
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
                        class="md:col-span-1 md:row-span-1 group relative bg-white dark:bg-[#0f2a1e] rounded-2xl md:rounded-3xl shadow-sm md:shadow-md overflow-hidden flex flex-row md:block items-center transition-all hover:-translate-y-1 hover:shadow-xl duration-300 p-3 md:p-0 gap-4 md:gap-0 border border-[#08332c]/8 dark:border-[#ba9e6f]/10 md:border-none">
                        <div
                            class="order-last md:order-none w-24 h-24 md:absolute md:inset-0 md:w-full md:h-full shrink-0 rounded-lg md:rounded-none overflow-hidden">
                            <img src="{{ $berita_terbaru[2]['image_url'] }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        </div>
                        <div class="hidden md:block absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                        <div class="flex-1 md:absolute md:bottom-0 md:p-6 relative z-10">
                            <span
                                class="text-[#08332c] dark:text-[#ba9e6f] text-[10px] md:text-xs font-bold uppercase tracking-wider mb-1 block">{{ $berita_terbaru[2]['kategori'] ?? 'Info' }}</span>
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
                        class="md:col-span-2 md:row-span-1 bg-white dark:bg-[#0f2a1e] rounded-2xl md:rounded-3xl p-3 md:p-6 flex items-center gap-4 md:gap-6 border border-[#08332c]/8 dark:border-[#ba9e6f]/10 hover:border-[#08332c]/20 dark:hover:border-[#ba9e6f]/30 hover:-translate-y-1 hover:shadow-xl transition-all duration-300 group cursor-pointer">
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
                                    class="text-sm md:text-xl font-display font-bold text-gray-900 dark:text-white mb-1 md:mb-2 line-clamp-2 group-hover:text-[#08332c] dark:group-hover:text-[#ba9e6f] transition-colors">
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
    <section id="program" class="py-24 bg-[#f4f4f4] dark:bg-[#051a12] transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-16 items-center">
                <div>
                    <span
                        class="text-[#ba9e6f] font-bold tracking-widest uppercase text-sm mb-2 block">Agenda
                        Organisasi</span>
                    <h2 class="font-display font-black text-4xl text-gray-900 dark:text-white mb-6">Program Kerja <br>&
                        <span class="text-[#08332c] dark:text-[#ba9e6f]">Kegiatan Terdekat</span>
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md text-lg">Pantau terus kegiatan PC IPNU
                        IPPNU Kediri. Jangan
                        lewatkan momentum kaderisasi dan syiar organisasi.</p>

                    <a href="{{ route('agenda') }}"
                        class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-[#08332c] text-white shadow-lg shadow-[#08332c]/20 hover:bg-[#0f4a3a] hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($agenda_terdekat as $prog)
                        <div
                            class="bg-white dark:bg-[#0f2a1e] p-5 rounded-xl border border-[#08332c]/8 dark:border-[#ba9e6f]/10 flex items-center gap-5 group hover:border-[#08332c]/20 dark:hover:border-[#ba9e6f]/25 hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                            <div
                                class="flex-shrink-0 w-16 h-16 bg-[#08332c]/5 dark:bg-[#08332c]/40 text-[#08332c] dark:text-[#ba9e6f] rounded-xl flex flex-col items-center justify-center border border-[#08332c]/10 dark:border-white/5">
                                <span
                                    class="text-xs font-bold uppercase">{{ date('M', strtotime($prog['tgl_raw'])) }}</span>
                                <span
                                    class="text-2xl font-black font-display">{{ date('d', strtotime($prog['tgl_raw'])) }}</span>
                            </div>
                            <div class="flex-grow">
                                <h4
                                    class="font-bold text-lg text-gray-900 dark:text-white group-hover:text-[#08332c] dark:group-hover:text-[#ba9e6f] transition-colors">
                                    {{ $prog['nama_acara'] }}
                                </h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    <span
                                        class="font-bold uppercase tracking-wider text-[10px] px-2 py-0.5 rounded-full {{ $prog['countdown'] == 'Sedang Dilaksanakan' ? 'bg-[#08332c]/10 text-[#08332c] dark:bg-[#08332c]/40 dark:text-[#ba9e6f] animate-pulse' : 'bg-[#ba9e6f]/10 text-[#ba9e6f]' }}">
                                        {{ $prog['countdown'] }}
                                    </span>
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <button class="p-2 text-gray-300 hover:text-[#08332c] dark:hover:text-[#ba9e6f] transition-colors">
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
    <section class="py-24 bg-[#f4f4f4] dark:bg-[#051a12] overflow-hidden relative transition-colors duration-300"
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
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8 flex flex-wrap justify-between items-end gap-2">
                <div>
                    <span
                        class="text-[#ba9e6f] font-bold tracking-widest uppercase text-sm mb-2 block">Struktur
                        Organisasi</span>
                    <h3 class="font-display font-black text-3xl md:text-4xl text-gray-900 dark:text-white">
                        Pengurus <span class="text-[#08332c] dark:text-[#ba9e6f]">IPNU</span>
                    </h3>
                </div>
                <a href="{{ route('struktur-organisasi', ['tab' => 'ipnu']) }}"
                    class="hidden sm:flex text-[#ba9e6f] font-bold items-center gap-2 hover:gap-3 transition-all">Lihat
                    Bagan Lengkap <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg></a>
            </div>

            <!-- IPNU Swiper -->
            <div class="swiper mySwiper-ipnu w-full pb-10">
                <div class="swiper-wrapper">
                    @forelse($pengurusIpnu as $p)
                        @php
                            $parts = array_filter(explode(' ', $p->kader->nama_lengkap));
                            $initials = strtoupper(substr(array_values($parts)[0] ?? 'X', 0, 1) . substr(array_values($parts)[1] ?? array_values($parts)[0] ?? 'X', 0, 1));
                        @endphp
                        <div class="swiper-slide shrink-0" style="width:240px; padding: 0 7px;">
                            <div class="flex items-center gap-3 bg-white dark:bg-[#0f2a1e] border border-[#08332c]/10 dark:border-[#ba9e6f]/10 rounded-xl p-3 hover:border-[#08332c]/30 dark:hover:border-[#ba9e6f]/25 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group cursor-pointer h-full">
                                <div class="w-11 h-11 rounded-full overflow-hidden border-2 border-[#08332c]/10 group-hover:border-[#08332c] dark:group-hover:border-[#ba9e6f] transition-all duration-300 shrink-0">
                                    @if($p->kader->foto_path)
                                        <img src="{{ asset('storage/' . $p->kader->foto_path) }}" alt="{{ $p->kader->nama_lengkap }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-[#08332c] text-[#ba9e6f] font-bold text-sm select-none">{{ $initials }}</div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h5 class="text-gray-900 dark:text-white font-bold text-sm leading-tight truncate">
                                        {{ \Illuminate\Support\Str::words($p->kader->nama_lengkap, 2, '') }}
                                    </h5>
                                    <p class="text-[#08332c] dark:text-[#ba9e6f] text-[10px] font-bold uppercase tracking-wide truncate">
                                        {{ $p->jabatan }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="swiper-slide w-full text-center text-gray-400 italic py-4">Data Pengurus Sedang Diupdate.</div>
                    @endforelse
                </div>
                <div class="swiper-pagination mt-4"></div>
            </div>
        </div>

        <!-- IPPNU SECTION -->
        <div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8 flex flex-wrap justify-between items-end gap-2">
                <div>
                    <span class="text-[#ba9e6f] font-bold tracking-widest uppercase text-sm mb-2 block">Struktur Organisasi</span>
                    <h3 class="font-display font-black text-3xl md:text-4xl text-gray-900 dark:text-white">
                        Pengurus <span class="text-[#08332c] dark:text-[#ba9e6f]">IPPNU</span>
                    </h3>
                </div>
                <a href="{{ route('struktur-organisasi', ['tab' => 'ippnu']) }}"
                    class="hidden sm:flex text-[#ba9e6f] font-bold items-center gap-2 hover:gap-3 transition-all">Lihat Bagan
                    Lengkap <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg></a>
            </div>

            <!-- IPPNU Swiper -->
            <div class="swiper mySwiper-ippnu w-full pb-10">
                <div class="swiper-wrapper">
                    @forelse($pengurusIppnu as $p)
                        @php
                            $parts = array_filter(explode(' ', $p->kader->nama_lengkap));
                            $initials = strtoupper(substr(array_values($parts)[0] ?? 'X', 0, 1) . substr(array_values($parts)[1] ?? array_values($parts)[0] ?? 'X', 0, 1));
                        @endphp
                        <div class="swiper-slide shrink-0" style="width:240px; padding: 0 7px;">
                            <div class="flex items-center gap-3 bg-white dark:bg-[#0f2a1e] border border-[#ba9e6f]/15 dark:border-[#ba9e6f]/10 rounded-xl p-3 hover:border-[#ba9e6f]/40 dark:hover:border-[#ba9e6f]/30 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group cursor-pointer h-full">
                                <div class="w-11 h-11 rounded-full overflow-hidden border-2 border-[#ba9e6f]/20 group-hover:border-[#ba9e6f] transition-all duration-300 shrink-0">
                                    @if($p->kader->foto_path)
                                        <img src="{{ asset('storage/' . $p->kader->foto_path) }}" alt="{{ $p->kader->nama_lengkap }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-[#ba9e6f] text-[#08332c] font-bold text-sm select-none">{{ $initials }}</div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h5 class="text-gray-900 dark:text-white font-bold text-sm leading-tight truncate">
                                        {{ \Illuminate\Support\Str::words($p->kader->nama_lengkap, 2, '') }}
                                    </h5>
                                    <p class="text-[#ba9e6f] text-[10px] font-bold uppercase tracking-wide truncate">
                                        {{ $p->jabatan }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="swiper-slide w-full text-center text-gray-400 italic py-4">Data Pengurus Sedang Diupdate.</div>
                    @endforelse
                </div>
                <div class="swiper-pagination mt-4"></div>
            </div>
        </div>

    </section>

    @include('partials.footer')

</body>

</html>