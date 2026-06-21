<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - DASI Pelajar</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=3">

    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700;900&family=Inter:wght@300;400;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @include('partials.theme-init')

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .font-display {
            font-family: 'Outfit', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Sidebar */
        .dash-sidebar {
            background: var(--dp-bg-primary);
            color: var(--dp-text-on-primary);
        }

        .dash-sidebar-link {
            color: rgba(244, 244, 244, 0.65);
            transition: all 0.15s ease;
        }

        .dash-sidebar-link:hover {
            color: var(--dp-text-on-primary);
            background: rgba(186, 158, 111, 0.1);
        }

        .dash-sidebar-link.active {
            color: var(--dp-gold);
            background: rgba(186, 158, 111, 0.12);
        }

        .dash-section-label {
            color: var(--dp-gold);
            opacity: 0.7;
        }

        /* Topbar */
        .dash-topbar {
            background: var(--dp-bg-surface);
            border-bottom: 1px solid var(--dp-border);
        }

        /* Scrollbar sidebar */
        .dash-sidebar nav::-webkit-scrollbar {
            width: 4px;
        }

        .dash-sidebar nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .dash-sidebar nav::-webkit-scrollbar-thumb {
            background: rgba(186, 158, 111, 0.2);
            border-radius: 4px;
        }
    </style>
</head>

<body class="antialiased" style="background: var(--dp-bg-page); color: var(--dp-text-primary);">

    <div class="min-h-screen flex" x-data="{ sidebarOpen: false }">

        {{-- ====== SIDEBAR ====== --}}
        <aside
            class="dash-sidebar fixed inset-y-0 left-0 z-50 w-64 shadow-xl transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-auto lg:flex lg:flex-col lg:h-screen lg:sticky lg:top-0"
            :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">

            {{-- Logo --}}
            <div class="h-16 flex items-center px-5" style="border-bottom: 1px solid rgba(186,158,111,0.15);">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                        style="background: var(--dp-gold);">
                        <img src="{{ asset('favicon.png') }}" alt="Logo" class="w-5 h-5">
                    </div>
                    <span class="font-semibold text-lg tracking-tight" style="color: var(--dp-text-on-primary);">
                        DASI<span style="color: var(--dp-gold);">PELAJAR</span>
                    </span>
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="p-3 space-y-0.5 overflow-y-auto flex-1">

                {{-- === Main === --}}
                @if(!in_array(auth()->user()->role, ['dep_organisasi', 'dep_kaderisasi']))
                    <p class="dash-section-label px-3 pt-4 pb-2 text-[10px] font-semibold uppercase tracking-widest">
                        Menu Utama
                    </p>
                    <a href="{{ route('dashboard') }}"
                        class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard') && !request()->routeIs('dashboard.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined text-xl">dashboard</span>
                        <span>Dashboard</span>
                    </a>
                @endif

                @if(in_array(auth()->user()->role, ['admin']))
                    <a href="{{ route('dashboard.pengaturan.index') }}"
                        class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard.pengaturan.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined text-xl">settings</span>
                        <span>Pengaturan Web</span>
                    </a>
                @endif

                {{-- === Lembaga Pers === --}}
                @if(auth()->user()->role === 'lmb_lpp')
                    @php
                        $komentarPending = \App\Models\KomentarBerita::where('is_approved', false)->count();
                    @endphp
                    <p class="dash-section-label px-3 pt-5 pb-2 text-[10px] font-semibold uppercase tracking-widest">
                        Lembaga Pers
                    </p>
                    <a href="{{ route('dashboard.berita.index') }}"
                        class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard.berita.*') && !request()->routeIs('dashboard.berita.komentar.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined text-xl">newspaper</span>
                        <span>Berita</span>
                    </a>
                    <a href="{{ route('dashboard.berita.komentar.index') }}"
                        class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard.berita.komentar.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined text-xl">chat</span>
                        <span>Komentar</span>
                        @if($komentarPending > 0)
                        <span class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-[#e8463a] rounded-full ml-auto">
                            {{ $komentarPending > 99 ? '99+' : $komentarPending }}
                        </span>
                        @endif
                    </a>
                    <a href="{{ route('dashboard.kategori.index') }}"
                        class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard.kategori.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined text-xl">category</span>
                        <span>Kategori</span>
                    </a>
                    <a href="{{ route('dashboard.media-visual.index') }}"
                        class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard.media-visual.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined text-xl">perm_media</span>
                        <span>Media Visual</span>
                    </a>
                @endif

                {{-- === Sekretariat === --}}
                @if(in_array(auth()->user()->role, ['admin', 'sekretaris']))
                    <p class="dash-section-label px-3 pt-5 pb-2 text-[10px] font-semibold uppercase tracking-widest">
                        Sekretariat
                    </p>
                    <a href="{{ route('dashboard.sekretariat.master-data.index') }}"
                        class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard.sekretariat.master-data.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined text-xl">folder_shared</span>
                        <span>Master Data</span>
                    </a>
                    <a href="{{ route('dashboard.sekretariat.organisasi.index') }}"
                        class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard.sekretariat.organisasi.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined text-xl">corporate_fare</span>
                        <span>Organisasi & Ranting</span>
                    </a>
                    <a href="{{ route('dashboard.sekretariat.absensi.index') }}"
                        class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard.sekretariat.absensi.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined text-xl">qr_code_scanner</span>
                        <span>Absensi & Kumpulan</span>
                    </a>
                    <a href="{{ route('dashboard.sekretariat.proker.index') }}"
                        class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard.sekretariat.proker.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined text-xl">event_available</span>
                        <span>Program Kerja</span>
                    </a>
                    <a href="{{ route('dashboard.sekretariat.surat-masuk.index') }}"
                        class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard.sekretariat.surat-masuk.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined text-xl">mail</span>
                        <span>Surat Masuk</span>
                    </a>
                    <a href="{{ route('dashboard.sekretariat.surat-keluar.index') }}"
                        class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard.sekretariat.surat-keluar.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined text-xl">send</span>
                        <span>Surat Keluar</span>
                    </a>
                @endif

                {{-- === Dep. Organisasi === --}}
                @if(in_array(auth()->user()->role, ['admin', 'pac', 'dep_organisasi', 'pr', 'pk']))
                    <p class="dash-section-label px-3 pt-5 pb-2 text-[10px] font-semibold uppercase tracking-widest">
                        Organisasi
                    </p>
                    <a href="{{ route('dashboard.sekretariat.sk.index') }}"
                        class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard.sekretariat.sk.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined text-xl">workspace_premium</span>
                        <span>Surat Keputusan</span>
                    </a>

                    <p class="dash-section-label px-3 pt-5 pb-2 text-[10px] font-semibold uppercase tracking-widest">
                        Dep. Organisasi
                    </p>
                    @if(in_array(auth()->user()->role, ['dep_organisasi']))
                        <a href="{{ route('dashboard.departemen.proker.index') }}"
                           class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard.departemen.proker.*') ? 'active' : '' }}">
                            <span class="material-symbols-outlined text-xl">event_note</span>
                            <span>Pelaksanaan Program</span>
                        </a>
                        <a href="{{ route('dashboard.form-kegiatan.index') }}"
                           class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard.form-kegiatan.*') ? 'active' : '' }}">
                            <span class="material-symbols-outlined text-xl">how_to_reg</span>
                            <span>Form Kegiatan</span>
                        </a>
                    @endif
                    <a href="{{ in_array(auth()->user()->role, ['pac', 'pr', 'pk']) ? route('dashboard.pac.proker.index') : route('dashboard.admin.proker.index') }}"
                        class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard.pac.proker.*') || request()->routeIs('dashboard.admin.proker.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined text-xl">event_available</span>
                        <span>Daftar Program Kerja</span>
                    </a>

                    @if(in_array(auth()->user()->role, ['admin', 'dep_organisasi']))
                        <a href="{{ route('dashboard.admin.analisa.index') }}"
                            class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard.admin.analisa.*') ? 'active' : '' }}">
                            <span class="material-symbols-outlined text-xl">analytics</span>
                            <span>Analisa Data</span>
                        </a>
                        <a href="{{ route('dashboard.admin.users.index') }}"
                            class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard.admin.users.*') ? 'active' : '' }}">
                            <span class="material-symbols-outlined text-xl">manage_accounts</span>
                            <span>Manajemen Pengguna</span>
                        </a>
                    @endif
                @endif

                {{-- === Dep. Kaderisasi === --}}
                @if(in_array(auth()->user()->role, ['admin', 'pac', 'dep_kaderisasi', 'pr', 'pk']))
                    <p class="dash-section-label px-3 pt-5 pb-2 text-[10px] font-semibold uppercase tracking-widest">
                        Dep. Kaderisasi
                    </p>
                    @if(in_array(auth()->user()->role, ['dep_kaderisasi']))
                        <a href="{{ route('dashboard.departemen.proker.index') }}"
                           class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard.departemen.proker.*') ? 'active' : '' }}">
                            <span class="material-symbols-outlined text-xl">event_note</span>
                            <span>Pelaksanaan Program</span>
                        </a>
                        <a href="{{ route('dashboard.form-kegiatan.index') }}"
                            class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard.form-kegiatan.*') ? 'active' : '' }}">
                            <span class="material-symbols-outlined text-xl">how_to_reg</span>
                            <span>Form Kegiatan</span>
                        </a>
                    @endif
                    <a href="{{ route('dashboard.kaderisasi.absensi.index') }}"
                        class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard.kaderisasi.absensi.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined text-xl">fact_check</span>
                        <span>Absensi Khusus</span>
                    </a>
                @endif

                {{-- === Ruang Kerja Departemen / Lembaga / Badan === --}}
                @if(auth()->user()->role == 'departemen' || (str_starts_with(auth()->user()->role, 'dep_') && !in_array(auth()->user()->role, ['dep_organisasi', 'dep_kaderisasi'])) || str_starts_with(auth()->user()->role, 'lmb_') || str_starts_with(auth()->user()->role, 'bdn_'))
                    <p class="dash-section-label px-3 pt-5 pb-2 text-[10px] font-semibold uppercase tracking-widest">
                        Ruang Kerja Anda
                    </p>
                    <a href="{{ route('dashboard.departemen.proker.index') }}"
                       class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard.departemen.proker.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined text-xl">event_note</span>
                        <span>Pelaksanaan Program</span>
                    </a>
                    <a href="{{ route('dashboard.form-kegiatan.index') }}"
                       class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard.form-kegiatan.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined text-xl">how_to_reg</span>
                        <span>Form Kegiatan</span>
                    </a>
                @endif

                {{-- Form Kegiatan untuk admin & sekretaris --}}
                @if(in_array(auth()->user()->role, ['admin', 'sekretaris']))
                    <a href="{{ route('dashboard.form-kegiatan.index') }}"
                       class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard.form-kegiatan.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined text-xl">how_to_reg</span>
                        <span>Form Kegiatan</span>
                    </a>
                @endif

                {{-- Logout (Mobile) --}}
                <div class="lg:hidden mt-6 pt-6" style="border-top: 1px solid rgba(186,158,111,0.15);">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors"
                            style="color: var(--dp-danger);">
                            <span class="material-symbols-outlined text-xl">logout</span>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>

            </nav>

            {{-- Sidebar footer --}}
            <div class="hidden lg:flex items-center gap-3 px-5 py-4"
                style="border-top: 1px solid rgba(186,158,111,0.15);">
                <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold"
                    style="background: var(--dp-gold); color: var(--dp-bg-primary);">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-semibold truncate" style="color: var(--dp-text-on-primary);">
                        {{ Auth::user()->name }}
                    </div>
                    <div class="text-[10px] uppercase tracking-wider" style="color: var(--dp-gold); opacity: 0.7;">
                        {{ Auth::user()->role ?? 'User' }}
                    </div>
                </div>
            </div>
        </aside>

        {{-- Overlay mobile --}}
        <div class="fixed inset-0 z-40 bg-black/50 lg:hidden" x-show="sidebarOpen" x-transition.opacity
            @click="sidebarOpen = false"></div>

        {{-- ====== MAIN CONTENT ====== --}}
        <div class="flex-1 flex flex-col min-h-screen overflow-hidden">

            {{-- Topbar --}}
            <header class="dash-topbar h-14 flex items-center justify-between px-4 lg:px-6 z-30 sticky top-0"
                style="backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);">

                {{-- Left: hamburger + breadcrumb --}}
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-1.5 rounded-lg transition-colors"
                        style="color: var(--dp-text-secondary);">
                        <span class="material-symbols-outlined text-2xl">menu</span>
                    </button>
                    <span class="hidden lg:block text-sm font-semibold" style="color: var(--dp-text-secondary);">
                        @yield('title')
                    </span>
                </div>

                {{-- Right: actions --}}
                <div class="flex items-center gap-2">
                    {{-- Visit site --}}
                    <a href="/" target="_blank"
                        class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors"
                        style="color: var(--dp-text-secondary); border: 1px solid var(--dp-border);">
                        <span class="material-symbols-outlined text-sm">open_in_new</span>
                        Lihat Situs
                    </a>

                    {{-- Theme toggle --}}
                    <button
                        onclick="document.documentElement.classList.toggle('dark'); localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');"
                        class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors"
                        style="color: var(--dp-text-secondary); border: 1px solid var(--dp-border);">
                        <span class="material-symbols-outlined text-lg">dark_mode</span>
                    </button>

                    {{-- Profile dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2.5 pl-3 focus:outline-none">
                            <div class="text-right hidden sm:block">
                                <div class="text-sm font-semibold leading-none" style="color: var(--dp-text-primary);">
                                    {{ Auth::user()->name }}
                                </div>
                                <div class="text-[10px] uppercase tracking-wider mt-0.5" style="color: var(--dp-gold);">
                                    {{ Auth::user()->role ?? 'User' }}
                                </div>
                            </div>
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold"
                                style="background: var(--dp-bg-primary); color: var(--dp-gold);">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </button>

                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-52 rounded-xl shadow-xl py-1 z-50"
                            style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);"
                            x-transition.origin.top.right x-cloak>
                            <div class="px-4 py-3" style="border-bottom: 1px solid var(--dp-border);">
                                <div class="text-sm font-semibold" style="color: var(--dp-text-primary);">
                                    {{ Auth::user()->name }}
                                </div>
                                <div class="text-xs mt-0.5" style="color: var(--dp-text-secondary);">
                                    {{ Auth::user()->email }}
                                </div>
                            </div>
                            <a href="{{ route('dashboard.profile.edit') }}" class="block px-4 py-2.5 text-sm transition-colors"
                                style="color: var(--dp-text-secondary);"
                                onmouseover="this.style.background='var(--dp-primary-tint)'"
                                onmouseout="this.style.background='transparent'">
                                Profil Saya
                            </a>
                            <div style="border-top: 1px solid var(--dp-border);"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2.5 text-sm transition-colors"
                                    style="color: var(--dp-danger);"
                                    onmouseover="this.style.background='var(--dp-danger-tint)'"
                                    onmouseout="this.style.background='transparent'">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Page content --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 lg:p-6">
                @yield('content')
            </main>

        </div>

    </div>

@stack('scripts')
</body>

</html>