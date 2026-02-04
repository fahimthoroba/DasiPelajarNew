<!DOCTYPE html>
<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $pengaturan->nama_website ?? 'PC IPNU IPPNU Kediri' }} - Homepage</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Spline+Sans:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        // Check local storage or system preference
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }

        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }
    </script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#00dc82", // Neon Green
                        "background-light": "#f8f8f5",
                        "background-dark": "#051111", // Deep Charcoal as requested
                        "card-dark": "#1e293b", // Slate 800 for contrast
                        "glass-border": "rgba(255, 255, 255, 0.08)"
                    },
                    fontFamily: {
                        "display": ["Spline Sans", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "1rem",
                        "lg": "1.5rem",
                        "xl": "2rem",
                        "2xl": "2.5rem",
                        "full": "9999px"
                    },
                    boxShadow: {
                        "glow": "0 0 20px rgba(0, 220, 130, 0.25)",
                        "glow-sm": "0 0 10px rgba(0, 220, 130, 0.15)",
                        "glow-text": "0 0 10px rgba(0, 220, 130, 0.5)",
                        "card-glow": "0 0 15px rgba(0, 220, 130, 0.15)",
                    }
                },
            },
        }
    </script>
    <style>
        html {
            scroll-behavior: smooth;
        }

        ::-webkit-scrollbar {
            width: px;
        }

        ::-webkit-scrollbar-track {
            background: #0f172a;
        }

        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #00dc82;
        }

        .styled-card {
            background: rgba(255, 255, 255, 0.9);
            /* Semi-transparent white */
            backdrop-filter: blur(10px);
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
        }

        .dark .styled-card {
            background: rgba(30, 41, 59, 0.4);
            /* Slate-800 with opacity */
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2), inset 0 0 0 1px rgba(255, 255, 255, 0.05);
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .dark .glass-nav {
            background: rgba(5, 17, 17, 0.8);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .glass-panel-plain {
            background: rgba(255, 255, 255, 0.7);
            /* Semi-transparent for BG blobs */
            backdrop-filter: blur(12px);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .dark .glass-panel-plain {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .text-shadow-glow {
            text-shadow: 0 0 20px rgba(0, 220, 130, 0.4);
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-white antialiased selection:bg-primary selection:text-black overflow-x-hidden transition-colors duration-300">
    <div class="relative min-h-screen flex flex-col items-center">
        <header class="fixed top-6 z-50 w-full max-w-7xl px-4 sm:px-6">
            <div
                class="glass-nav rounded-full px-6 py-3 flex items-center justify-between shadow-2xl transition-all duration-300">
                <div class="flex items-center gap-3">
                    <div
                        class="h-9 w-9 rounded-full bg-primary flex items-center justify-center text-black shadow-glow-sm">
                        <span class="material-symbols-outlined text-xl">hub</span>
                    </div>
                    <h2 class="text-slate-900 dark:text-white text-lg font-bold tracking-tight hidden sm:block">
                        {{ $pengaturan->nama_website ?? 'PC IPNU IPPNU' }}
                    </h2>
                </div>
                <nav class="hidden md:flex items-center gap-8">
                    <a class="{{ request()->routeIs('home') ? 'text-slate-900 dark:text-white' : 'text-slate-500 dark:text-white/60' }} hover:text-primary transition-colors text-sm font-medium"
                        href="{{ route('home') }}">Beranda</a>
                    <a class="{{ request()->routeIs('berita.*') ? 'text-slate-900 dark:text-white' : 'text-slate-500 dark:text-white/60' }} hover:text-primary transition-colors text-sm font-medium"
                        href="{{ route('berita.index') }}">Berita</a>
                    <a class="text-slate-500 dark:text-white/60 hover:text-primary transition-colors text-sm font-medium"
                        href="{{ route('home') }}#layanan">Layanan</a>
                </nav>
                <div class="flex items-center gap-4">
                    <button onclick="toggleTheme()"
                        class="w-9 h-9 rounded-full bg-slate-200 dark:bg-white/5 flex items-center justify-center text-slate-900 dark:text-white hover:bg-primary hover:text-black transition-all">
                        <span class="material-symbols-outlined dark:hidden">light_mode</span>
                        <!-- Sun for Light Mode (to switch to dark) -->
                        <span class="material-symbols-outlined hidden dark:block">dark_mode</span>
                        <!-- Moon for Dark Mode -->
                    </button>
                    <button
                        class="bg-primary hover:bg-[#00b56b] text-black shadow-glow hover:shadow-glow-sm transition-all duration-300 font-bold text-xs md:text-sm px-6 py-2.5 rounded-full flex items-center gap-2">
                        <span>Login Pengurus</span>
                    </button>
                </div>
            </div>
        </header>
        <div class="fixed inset-0 pointer-events-none z-0">
            <div
                class="absolute -top-[20%] -left-[10%] w-[60%] h-[60%] bg-primary/10 blur-[150px] rounded-full animate-pulse">
            </div>
            <div class="absolute -bottom-[20%] -right-[10%] w-[50%] h-[50%] bg-primary/10 blur-[130px] rounded-full animate-blob"
                style="animation-delay: 2s">
            </div>
        </div>
        <main class="w-full max-w-7xl px-4 sm:px-6 z-10 pt-32 pb-20 flex flex-col gap-12 md:gap-24">
            <section
                class="relative w-full rounded-[2.5rem] overflow-hidden glass-panel-plain min-h-[500px] flex items-center justify-between p-0 md:p-0 border border-white/5 relative group">
                <!-- Slider Container -->
                <div id="hero-slider" class="absolute inset-0 w-full h-full">
                    @forelse($sliders as $index => $slider)
                        <div class="slider-item absolute inset-0 w-full h-full transition-opacity duration-1000 {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
                            data-index="{{ $index }}">
                            <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000 ease-in-out z-0"
                                style="background-image: url('{{ asset('storage/' . $slider->gambar_path) }}');"
                                x-show="activeSlide === {{ $index }}" x-transition:enter="opacity-0"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                x-transition:leave="opacity-100" x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0">
                                <!-- Clean Modern Gradient Overlay -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-black/30 dark:from-black dark:via-black/60 dark:to-black/40">
                                </div>
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-black/80 via-transparent to-black/80 opacity-60">
                                </div>
                            </div>
                            <div class="absolute inset-0 flex items-center p-8 md:p-16">
                                <div class="space-y-6 max-w-2xl">
                                    <div
                                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 text-primary text-xs font-bold uppercase tracking-wider">
                                        <span class="w-2 h-2 rounded-full bg-primary shadow-glow-sm"></span>
                                        Portal Organisasi
                                    </div>
                                    <h1 class="text-5xl md:text-7xl font-bold text-white leading-[1.1] tracking-tight">
                                        {{ $slider->judul_utama }}
                                    </h1>
                                    <p class="text-lg text-gray-400 font-light max-w-lg leading-relaxed">
                                        {{ $slider->sub_judul }}
                                    </p>
                                    @if($slider->show_button && $slider->link_tombol)
                                        <div class="mt-8">
                                            <a href="{{ $slider->link_tombol }}"
                                                class="px-8 py-4 bg-primary text-black font-bold rounded-full hover:shadow-glow transition-all">{{ $slider->teks_tombol }}</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- Fallback if no sliders -->
                        <div class="slider-item absolute inset-0 w-full h-full opacity-100 z-10">
                            <div class="absolute inset-0 bg-cover bg-center opacity-30 mix-blend-overlay"
                                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBSjoCCAAfFeOrhp2ZJD7HuUJkYj7D8-6H4yJ7W6Cn8p2phe8QFZrsQ3gsE2BaNpOLcmmBkSc3Js60NUzRl3XoFTPwoIPM5gBhVnsRcilfpMcizBtTy_kfZF68W6M8yrwmH8obhtYhzTW0CkvN264mQqD3iLrk-eTlLGcs-SRvZ1iCfEibPnvXFqkdyzc7PKhM4jsm4K_zGGtAK1FALVfh1CoUzTi_ixaKwa-B7Sec0kGCr0zYIa5-KPhJEHstzX22onHsgw5jRHic');">
                            </div>
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-background-dark via-background-dark/80 to-transparent">
                            </div>
                            <div class="absolute inset-0 flex items-center p-8 md:p-16">
                                <div class="space-y-6 max-w-2xl">
                                    <h1 class="text-5xl md:text-7xl font-bold text-white leading-[1.1] tracking-tight">
                                        PC IPNU IPPNU
                                    </h1>
                                    <p class="text-lg text-gray-400 font-light max-w-lg leading-relaxed">
                                        Selamat Datang di Portal Resmi.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
                <!-- Navigation Buttons -->
                <button onclick="prevSlide()"
                    class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-white/10 dark:bg-white/5 border border-white/20 dark:border-white/10 flex items-center justify-center text-white hover:bg-primary hover:text-black transition-all">
                    <span class="material-symbols-outlined">chevron_left</span>
                </button>
                <button onclick="nextSlide()"
                    class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-white/10 dark:bg-white/5 border border-white/20 dark:border-white/10 flex items-center justify-center text-white hover:bg-primary hover:text-black transition-all">
                    <span class="material-symbols-outlined">chevron_right</span>
                </button>
            </section>
            <section class="grid grid-cols-1 lg:grid-cols-12 gap-6 w-full">
                <div
                    class="lg:col-span-7 glass-panel-plain rounded-3xl p-8 md:p-12 flex flex-col justify-center relative overflow-hidden">
                    <div
                        class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary to-transparent opacity-50">
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-3">
                        <span class="w-1 h-8 bg-primary rounded-full shadow-glow"></span>
                        Profil Singkat
                    </h3>
                    <div
                        class="text-slate-600 dark:text-gray-400 text-lg leading-relaxed mb-6 prose prose-invert max-w-none">
                        {!! $pengaturan->profil_singkat ?? 'PC IPNU IPPNU Kediri adalah organisasi keterpelajaran di bawah naungan Nahdlatul Ulama...' !!}
                    </div>

                </div>
                <div class="lg:col-span-5 flex flex-col gap-4">
                    <div
                        class="glass-panel-plain p-6 rounded-3xl cursor-default group h-full hover:shadow-glow transition-all duration-300">
                        <div
                            class="w-12 h-12 bg-gray-100 dark:bg-white/5 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-primary group-hover:text-black transition-colors text-primary border border-gray-200 dark:border-white/10">
                            <span class="material-symbols-outlined text-2xl">track_changes</span>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Visi Organisasi</h4>
                        <div class="text-slate-600 dark:text-gray-400 text-sm prose prose-invert max-w-none">
                            {!! $pengaturan->visi ?? 'Terbentuknya pelajar bangsa yang bertaqwa...' !!}
                        </div>
                    </div>
                    <div
                        class="glass-panel-plain p-6 rounded-3xl cursor-default group h-full hover:shadow-glow transition-all duration-300">
                        <div
                            class="w-12 h-12 bg-gray-100 dark:bg-white/5 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-primary group-hover:text-black transition-colors text-primary border border-gray-200 dark:border-white/10">
                            <span class="material-symbols-outlined text-2xl">visibility</span>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Misi Utama</h4>
                        <div class="text-slate-600 dark:text-gray-400 text-sm prose prose-invert max-w-none">
                            {!! $pengaturan->misi ?? 'Mengembangkan potensi kader...' !!}
                        </div>
                    </div>
                </div>
            </section>

            <!-- Statistik & Agenda Section -->
            <section class="grid grid-cols-1 lg:grid-cols-12 gap-6 w-full">
                <!-- Statistik (Left, 4 cols) -->
                <div class="lg:col-span-4 flex flex-col gap-6">
                    <div
                        class="glass-panel-plain p-8 rounded-3xl w-full relative group overflow-hidden h-full flex flex-col justify-center">
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-primary/10 blur-[50px] rounded-full pointer-events-none">
                        </div>
                        <div class="relative z-10">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="material-symbols-outlined text-primary/70">groups</span>
                                <span
                                    class="text-xs font-bold text-primary dark:text-primary/70 uppercase tracking-widest">Statistik
                                    Data</span>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span
                                    class="text-6xl font-bold text-primary tracking-tighter tabular-nums drop-shadow-lg">{{ $statistik['total_kader'] ?? '0' }}</span>
                                <span class="text-xl text-slate-900 dark:text-white font-medium">Total Anggota</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Agenda (Right, 8 cols) -->
                <div class="lg:col-span-8 glass-panel-plain p-8 rounded-3xl">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
                            Agenda Terdekat
                            <span class="material-symbols-outlined text-primary opacity-50">calendar_month</span>
                        </h3>
                        <!-- <a href="#" class="text-xs font-bold text-primary hover:text-white transition-colors uppercase tracking-wider">Lihat Semua</a> -->
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Removed duplicate grid wrapper -->
                        @foreach(collect($agenda_terdekat)->take(2) as $agenda)
                            @php
                                $parts = explode(' ', $agenda['tanggal']);
                                $day = $parts[0] ?? '00';
                                $month = $parts[1] ?? '...';
                            @endphp
                            <div
                                class="flex gap-4 group cursor-pointer p-4 rounded-2xl hover:bg-slate-50 dark:hover:bg-white/5 transition-all border border-transparent hover:border-emerald-100 dark:hover:border-primary/30">
                                <div
                                    class="flex-shrink-0 w-16 h-16 rounded-xl bg-slate-100 dark:bg-slate-800/50 border border-slate-200 dark:border-white/10 flex flex-col items-center justify-center group-hover:bg-emerald-500 dark:group-hover:bg-primary group-hover:text-white dark:group-hover:text-black transition-all">
                                    <span
                                        class="text-xs text-slate-500 dark:text-gray-400 uppercase font-bold group-hover:text-white/90 dark:group-hover:text-black/70">{{ strtoupper(Str::limit($month, 3, '')) }}</span>
                                    <span
                                        class="text-xl text-slate-900 dark:text-white font-bold group-hover:text-white dark:group-hover:text-black">{{ $day }}</span>
                                </div>
                                <div>
                                    <h4
                                        class="text-lg font-bold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-primary transition-colors line-clamp-1">
                                        {{ $agenda['nama_acara'] }}
                                    </h4>
                                    @if($agenda['lokasi'])
                                        <p class="text-slate-500 dark:text-gray-400 text-xs mt-1 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">location_on</span>
                                            {{ $agenda['lokasi'] }}
                                        </p>
                                    @endif
                                    <p
                                        class="text-emerald-600 dark:text-primary text-sm mt-1 flex items-center gap-1 font-bold">
                                        <span class="material-symbols-outlined text-sm">timer</span>
                                        {{ $agenda['countdown'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if(count($agenda_terdekat) > 0)
                        <div class="mt-6 pt-4 border-t border-white/5 flex">
                            <a href="#layanan"
                                class="flex items-center gap-2 text-primary font-bold text-sm hover:gap-3 transition-all">
                                Lihat Seluruh Program Kerja <span
                                    class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </div>
                    @endif
                </div>
            </section>

            <section class="w-full space-y-8" id="pengurus-ipnu">
                <style>
                    @keyframes marquee {
                        0% {
                            transform: translateX(0%);
                        }

                        100% {
                            transform: translateX(-100%);
                        }
                    }

                    .animate-marquee {
                        animation: marquee 25s linear infinite;
                    }

                    .animate-marquee:hover {
                        animation-play-state: paused;
                    }

                    @keyframes marqueeReverse {
                        0% {
                            transform: translateX(-100%);
                        }

                        100% {
                            transform: translateX(0%);
                        }
                    }

                    .animate-marquee-reverse {
                        animation: marqueeReverse 25s linear infinite;
                    }

                    .animate-marquee-reverse:hover {
                        animation-play-state: paused;
                    }
                </style>

                <div class="flex items-center justify-between px-2">
                    <h3 class="text-3xl font-bold text-slate-900 dark:text-white relative">
                        Pengurus IPNU
                        <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-primary rounded-full"></span>
                    </h3>
                    <a href="{{ route('struktur-organisasi', ['tab' => 'ipnu']) }}"
                        class="text-sm font-bold text-primary hover:text-emerald-700 dark:hover:text-white transition-colors uppercase tracking-wider flex items-center gap-2 group">
                        Lihat Struktur IPNU
                        <span
                            class="material-symbols-outlined transition-transform group-hover:translate-x-1">arrow_forward</span>
                    </a>
                </div>

                <!-- Marquee Container -->
                <div class="relative w-full overflow-hidden py-10"
                    style="mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent); -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);">
                    <!-- Decorative Background for Cards Only -->
                    <div
                        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[200%] bg-gradient-to-br from-emerald-100/90 to-transparent dark:from-emerald-950/40 dark:to-transparent -z-10 blur-xl rounded-[100%] pointer-events-none">
                    </div>

                    <div class="flex gap-6 animate-marquee">
                        <!-- Card Item -->
                        <div
                            class="flex items-center justify-center shrink-0 w-64 h-full px-8 border-r border-emerald-500/30">
                            <h4 class="text-2xl font-black text-emerald-400 uppercase tracking-widest text-center">
                                Pengurus<br>IPNU</h4>
                        </div>

                        @forelse($pengurusIpnu as $p)
                            <div
                                class="inline-flex items-center gap-4 bg-white dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-500/30 rounded-xl p-3 pr-6 hover:bg-emerald-50 dark:hover:bg-emerald-900/40 transition-colors shrink-0 max-w-sm shadow-sm dark:shadow-none">
                                <img src="{{ $p->kader->foto_path ? asset('storage/' . $p->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($p->kader->nama_lengkap) }}"
                                    alt="{{ $p->kader->nama_lengkap }}"
                                    class="w-12 h-12 rounded-lg object-cover border-2 border-emerald-500/50">
                                <div>
                                    <h5 class="text-slate-900 dark:text-white font-bold text-lg truncate w-40">
                                        {{ $p->kader->nama_lengkap }}
                                    </h5>
                                    <p
                                        class="text-emerald-600 dark:text-emerald-400 text-sm font-medium uppercase tracking-wider">
                                        {{ $p->jabatan }}
                                    </p>
                                    @if($p->kader->quote)
                                        <p class="text-slate-500 dark:text-gray-400 text-xs italic mt-1 truncate w-40">
                                            "{{ $p->kader->quote }}"</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-gray-500 italic px-4">Belum ada data Pengurus IPNU.</div>
                        @endforelse
                    </div>
                </div>
            </section>

            <!-- Pengurus IPPNU Section -->
            <section class="w-full space-y-8 relative overflow-hidden" id="pengurus-ippnu">
                <!-- IPPNU Shape Moved to Marquee Container -->
                <div class="flex items-center justify-between px-2">
                    <h3 class="text-3xl font-bold text-slate-900 dark:text-white relative">
                        Pengurus IPPNU
                        <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-yellow-500/80 rounded-full"></span>
                    </h3>
                    <a href="{{ route('struktur-organisasi', ['tab' => 'ippnu']) }}"
                        class="text-sm font-bold text-yellow-600 dark:text-yellow-500 hover:text-yellow-800 dark:hover:text-white transition-colors uppercase tracking-wider flex items-center gap-2 group">
                        Lihat Struktur IPPNU
                        <span
                            class="material-symbols-outlined transition-transform group-hover:translate-x-1">arrow_forward</span>
                    </a>
                </div>

                <!-- Marquee Container (Right) -->
                <div class="relative w-full overflow-hidden py-10"
                    style="mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent); -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);">
                    <!-- Decorative Background for Cards Only -->
                    <div
                        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[200%] bg-gradient-to-bl from-yellow-100/90 to-transparent dark:from-yellow-950/40 dark:to-transparent -z-10 blur-xl rounded-[100%] pointer-events-none">
                    </div>

                    <div class="flex gap-6 animate-marquee-reverse">
                        <!-- Card Item -->
                        <div
                            class="flex items-center justify-center shrink-0 w-64 h-full px-8 border-r border-yellow-500/30">
                            <h4 class="text-2xl font-black text-yellow-400 uppercase tracking-widest text-center">
                                Pengurus<br>IPPNU</h4>
                        </div>

                        @forelse($pengurusIppnu as $p)
                            <div
                                class="inline-flex items-center gap-4 bg-white dark:bg-yellow-950/40 border border-yellow-200 dark:border-yellow-500/30 rounded-xl p-3 pr-6 hover:bg-yellow-50 dark:hover:bg-yellow-900/40 transition-colors shrink-0 max-w-sm shadow-sm dark:shadow-none">
                                <img src="{{ $p->kader->foto_path ? asset('storage/' . $p->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($p->kader->nama_lengkap) }}"
                                    alt="{{ $p->kader->nama_lengkap }}"
                                    class="w-12 h-12 rounded-lg object-cover border-2 border-yellow-500/50">
                                <div class="transform scale-x-[-1] text-right">
                                    <div class="transform scale-x-[-1] text-left">
                                        <h5 class="text-slate-900 dark:text-white font-bold text-lg truncate w-40">
                                            {{ $p->kader->nama_lengkap }}
                                        </h5>
                                        <p
                                            class="text-yellow-600 dark:text-yellow-400 text-sm font-medium uppercase tracking-wider">
                                            {{ $p->jabatan }}
                                        </p>
                                        @if($p->kader->quote)
                                            <p class="text-slate-500 dark:text-gray-400 text-xs italic mt-1 truncate w-40">
                                                "{{ $p->kader->quote }}"
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-gray-500 italic px-4 transform scale-x-[-1]">Belum ada data Pengurus IPPNU.
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            <!-- Kabar Terbaru Section -->
            <section class="w-full space-y-8" id="berita">
                <div class="flex items-center justify-between px-2">
                    <h3 class="text-3xl font-bold text-slate-900 dark:text-white relative">
                        Kabar Terbaru
                        <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-primary rounded-full"></span>
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse($berita_terbaru as $berita)
                        <article
                            class="group relative glass-panel-plain rounded-3xl overflow-hidden hover:border-primary/50 transition-all duration-300 hover:-translate-y-2 hover:shadow-glow shadow-sm dark:shadow-none hover:ring-1 hover:ring-primary dark:hover:ring-primary">
                            <div class="aspect-[4/3] overflow-hidden relative">
                                <img src="{{ $berita['image_url'] }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#121212] to-transparent opacity-60">
                                </div>
                            </div>

                            <div class="p-6 relative">
                                <div class="flex items-center gap-4 text-xs text-gray-400 mb-4">
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm text-primary">calendar_today</span>
                                        {{ $berita['tanggal'] }}
                                    </span>
                                </div>

                                <a href="{{ route('berita.show', $berita['slug']) }}" class="absolute inset-0 z-10"></a>

                                <h4
                                    class="text-xl font-bold text-slate-900 dark:text-white mb-3 leading-tight group-hover:text-primary transition-colors">
                                    {{ $berita['judul'] }}
                                </h4>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-3 text-center text-gray-500 italic">Belum ada berita terbaru.</div>
                    @endforelse
                </div>

                <a href="{{ route('berita.index') }}"
                    class="block w-full text-center py-4 rounded-2xl border border-gray-200 dark:border-white/10 text-slate-900 dark:text-white font-bold hover:bg-slate-50 dark:hover:bg-white/5 hover:border-primary/50 hover:text-primary transition-all duration-300 uppercase tracking-widest text-sm shadow-glow-sm hover:shadow-glow">
                    Lihat Semua Berita
                </a>
            </section>
        </main>
        <footer
            class="w-full border-t border-gray-200 dark:border-white/5 bg-slate-50 dark:bg-[#051111] py-16 relative z-10">
            <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div
                            class="h-10 w-10 rounded-full bg-primary flex items-center justify-center text-black shadow-glow-sm">
                            <span class="material-symbols-outlined">hub</span>
                        </div>
                        <div class="flex flex-col">
                            <span
                                class="font-bold text-slate-900 dark:text-white text-lg leading-tight">{{ $pengaturan->nama_website ?? 'PC IPNU IPPNU' }}</span>
                            <span class="text-primary text-xs tracking-wide">KAB. KEDIRI</span>
                        </div>
                    </div>
                    <p class="text-slate-600 dark:text-gray-400 text-sm leading-relaxed">
                        {{ $pengaturan->deskripsi_singkat ?? 'Membangun Peradaban Digital yang berkarakter Aswaja untuk masa depan Indonesia.' }}
                    </p>
                    <div class="text-xs text-slate-500 dark:text-gray-600">
                        © 2023 {{ $pengaturan->nama_website ?? 'PC IPNU IPPNU Kediri' }}.
                    </div>
                </div>
                <div>
                    <h4 class="text-slate-900 dark:text-white font-bold mb-6 flex items-center gap-2">
                        <span class="w-1 h-4 bg-primary rounded-full"></span>
                        Navigasi
                    </h4>
                    <ul class="space-y-3">
                        <li><a class="text-slate-600 dark:text-gray-400 hover:text-primary transition-colors text-sm flex items-center gap-2 group"
                                href="{{ route('home') }}"><span
                                    class="material-symbols-outlined text-[10px] opacity-0 group-hover:opacity-100 transition-all -ml-4 group-hover:ml-0">chevron_right</span>
                                Beranda</a></li>
                        <li><a class="text-slate-600 dark:text-gray-400 hover:text-primary transition-colors text-sm flex items-center gap-2 group"
                                href="{{ route('home') }}#profil"><span
                                    class="material-symbols-outlined text-[10px] opacity-0 group-hover:opacity-100 transition-all -ml-4 group-hover:ml-0">chevron_right</span>
                                Profil</a></li>
                        <li><a class="text-slate-600 dark:text-gray-400 hover:text-primary transition-colors text-sm flex items-center gap-2 group"
                                href="{{ route('berita.index') }}"><span
                                    class="material-symbols-outlined text-[10px] opacity-0 group-hover:opacity-100 transition-all -ml-4 group-hover:ml-0">chevron_right</span>
                                Berita</a></li>
                        <li><a class="text-slate-600 dark:text-gray-400 hover:text-primary transition-colors text-sm flex items-center gap-2 group"
                                href="{{ route('home') }}#layanan"><span
                                    class="material-symbols-outlined text-[10px] opacity-0 group-hover:opacity-100 transition-all -ml-4 group-hover:ml-0">chevron_right</span>
                                Layanan</a></li>
                        <li><a class="text-slate-600 dark:text-gray-400 hover:text-primary transition-colors text-sm flex items-center gap-2 group"
                                href="#"><span
                                    class="material-symbols-outlined text-[10px] opacity-0 group-hover:opacity-100 transition-all -ml-4 group-hover:ml-0">chevron_right</span>
                                Login Pengurus</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-slate-900 dark:text-white font-bold mb-6 flex items-center gap-2">
                        <span class="w-1 h-4 bg-primary rounded-full"></span>
                        Hubungi Kami
                    </h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-gray-400">
                            <span class="material-symbols-outlined text-primary mt-0.5 text-lg">chat</span>
                            <div>
                                <span class="block text-slate-900 dark:text-white font-medium mb-0.5">WhatsApp
                                    Admin</span>
                                <a class="hover:text-primary transition-colors"
                                    href="https://wa.me/{{ $pengaturan->no_wa ?? '' }}">{{ $pengaturan->no_wa ?? '+62 812-3456-7890' }}</a>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-gray-400">
                            <span class="material-symbols-outlined text-primary mt-0.5 text-lg">mail</span>
                            <div>
                                <span class="block text-slate-900 dark:text-white font-medium mb-0.5">Email</span>
                                <a class="hover:text-primary transition-colors"
                                    href="mailto:{{ $pengaturan->email ?? '' }}">{{ $pengaturan->email ??
                                    'sekretariat@ipnuippnukediri.or.id' }}</a>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-gray-400">
                            <span class="material-symbols-outlined text-primary mt-0.5 text-lg">location_on</span>
                            <div>
                                <span class="block text-slate-900 dark:text-white font-medium mb-0.5">Kantor</span>
                                <span>{{ $pengaturan->alamat ?? 'Jl. Imam Bonjol No. 12, Kediri' }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-slate-900 dark:text-white font-bold mb-6 flex items-center gap-2">
                        <span class="w-1 h-4 bg-primary rounded-full"></span>
                        Ikuti Kami
                    </h4>
                    <p class="text-slate-600 dark:text-gray-400 text-sm mb-4">Dapatkan update terbaru melalui media
                        sosial kami.</p>
                    <div class="flex items-center gap-3">
                        @if($pengaturan->facebook)
                            <a class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-white/5 border border-gray-200 dark:border-white/10 flex items-center justify-center text-slate-600 dark:text-gray-400 hover:bg-primary hover:text-black hover:border-primary transition-all duration-300 hover:-translate-y-1"
                                href="{{ $pengaturan->facebook }}" target="_blank">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.069-4.85.069-3.204 0-3.584-.012-4.849-.069-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z">
                                    </path>
                                </svg>
                            </a>
                        @endif
                        @if($pengaturan->tiktok)
                            <a class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:bg-primary hover:text-black hover:border-primary transition-all duration-300 hover:-translate-y-1"
                                href="{{ $pengaturan->tiktok }}" target="_blank">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z">
                                    </path>
                                </svg>
                            </a>
                        @endif
                        @if($pengaturan->instagram)
                            <a class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:bg-primary hover:text-black hover:border-primary transition-all duration-300 hover:-translate-y-1"
                                href="{{ $pengaturan->instagram }}" target="_blank">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z">
                                    </path>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </footer>
    </div>

</body>

</html>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slider-item');
        const totalSlides = slides.length;

        if (totalSlides > 0) {
            window.showSlide = function (index) {
                slides.forEach((slide, i) => {
                    if (i === index) {
                        slide.classList.remove('opacity-0', 'z-0');
                        slide.classList.add('opacity-100', 'z-10');
                    } else {
                        slide.classList.remove('opacity-100', 'z-10');
                        slide.classList.add('opacity-0', 'z-0');
                    }
                });
            }

            window.nextSlide = function () {
                currentSlide = (currentSlide + 1) % totalSlides;
                showSlide(currentSlide);
            }

            window.prevSlide = function () {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                showSlide(currentSlide);
            }

            // Auto play
            setInterval(nextSlide, 5000);
        }
    });

</script>