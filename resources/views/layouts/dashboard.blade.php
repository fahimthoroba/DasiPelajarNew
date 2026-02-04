<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - DasiPelajar</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=3">

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        emerald: { 900: '#022C22', 800: '#064E3B', 600: '#059669', 500: '#10b981', 400: '#34D399', 50: '#ecfdf5' },
                        amber: { 900: '#78350F', 700: '#B45309', 400: '#FBBF24', 50: '#fffbeb' },
                        surface: { light: '#F8FAFC', card: '#FFFFFF', dark: '#0F172A' }
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
        [x-cloak] {
            display: none !important;
        }
    </style>
    <!-- Alpine.js for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body
    class="font-body text-slate-800 dark:text-gray-100 antialiased bg-surface-light dark:bg-[#051111] transition-colors duration-300">

    <div class="min-h-screen flex" x-data="{ sidebarOpen: false }">

        <!-- Sidebar -->
        <aside
            class="hidden lg:flex flex-col w-64 bg-emerald-900 text-white shadow-xl h-screen sticky top-0 overflow-y-auto z-50 transition-all duration-300"
            :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">

            <!-- Logo -->
            <div class="h-16 flex items-center justify-center border-b border-emerald-800/50">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-2 font-display font-black text-xl tracking-tight">
                    <img src="{{ asset('favicon.png') }}" alt="Logo" class="w-6 h-6">
                    <span>DASI<span class="text-amber-400">PELAJAR</span></span>
                </a>
            </div>

            <!-- Menu -->
            <nav class="p-4 space-y-1 overflow-y-auto h-[calc(100vh-4rem)]">

                @if(auth()->user()->role !== 'dep_organisasi')
                    <p class="px-4 py-2 text-xs font-bold text-emerald-400 uppercase tracking-wider">Main</p>

                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-emerald-800/50 text-emerald-100 hover:text-white transition-colors {{ request()->routeIs('dashboard') ? 'bg-emerald-800 text-white shadow-lg shadow-emerald-900/20' : '' }}">
                        <span class="material-symbols-outlined">dashboard</span>
                        <span class="font-medium">Dashboard</span>
                    </a>
                @endif

                @if(in_array(auth()->user()->role, ['admin']))
                    <a href="{{ route('dashboard.pengaturan.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-emerald-800/50 text-emerald-100 hover:text-white transition-colors {{ request()->routeIs('dashboard.pengaturan.*') ? 'bg-emerald-800 text-white shadow-lg shadow-emerald-900/20' : '' }}">
                        <span class="material-symbols-outlined">settings</span>
                        <span class="font-medium">Pengaturan Web</span>
                    </a>
                @endif

                <!-- Lembaga Pers Module -->
                @if(in_array(auth()->user()->role, ['admin', 'pers']))
                    <p class="px-4 py-2 mt-6 text-xs font-bold text-emerald-400 uppercase tracking-wider">Lembaga Pers</p>

                    <a href="{{ route('dashboard.berita.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-emerald-800/50 text-emerald-100 hover:text-white transition-colors {{ request()->routeIs('dashboard.berita.*') ? 'bg-emerald-800 text-white shadow-lg shadow-emerald-900/20' : '' }}">
                        <span class="material-symbols-outlined">newspaper</span>
                        <span class="font-medium">Berita</span>
                    </a>

                    <a href="{{ route('dashboard.kategori.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-emerald-800/50 text-emerald-100 hover:text-white transition-colors {{ request()->routeIs('dashboard.kategori.*') ? 'bg-emerald-800 text-white shadow-lg shadow-emerald-900/20' : '' }}">
                        <span class="material-symbols-outlined">category</span>
                        <span class="font-medium">Kategori</span>
                    </a>

                    <a href="{{ route('dashboard.slider.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-emerald-800/50 text-emerald-100 hover:text-white transition-colors {{ request()->routeIs('dashboard.slider.*') ? 'bg-emerald-800 text-white shadow-lg shadow-emerald-900/20' : '' }}">
                        <span class="material-symbols-outlined">view_carousel</span>
                        <span class="font-medium">Slider Hero</span>
                    </a>
                @endif

                <!-- Sekretariat Module -->
                @if(in_array(auth()->user()->role, ['admin', 'sekretaris']))
                    <p class="px-4 py-2 mt-6 text-xs font-bold text-emerald-400 uppercase tracking-wider">Sekretariat</p>

                    <a href="{{ route('dashboard.sekretariat.master-data.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-emerald-800/50 text-emerald-100 hover:text-white transition-colors {{ request()->routeIs('dashboard.sekretariat.master-data.*') ? 'bg-emerald-800 text-white shadow-lg shadow-emerald-900/20' : '' }}">
                        <span class="material-symbols-outlined">folder_shared</span>
                        <span class="font-medium">Master Data</span>
                    </a>

                    <a href="{{ route('dashboard.sekretariat.pengurus.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-emerald-800/50 text-emerald-100 hover:text-white transition-colors {{ request()->routeIs('dashboard.sekretariat.pengurus.*') ? 'bg-emerald-800 text-white shadow-lg shadow-emerald-900/20' : '' }}">
                        <span class="material-symbols-outlined">groups</span>
                        <span class="font-medium">Pengurus</span>
                    </a>

                    <a href="{{ route('dashboard.sekretariat.sk.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-emerald-800/50 text-emerald-100 hover:text-white transition-colors {{ request()->routeIs('dashboard.sekretariat.sk.*') ? 'bg-emerald-800 text-white shadow-lg shadow-emerald-900/20' : '' }}">
                        <span class="material-symbols-outlined">workspace_premium</span>
                        <span class="font-medium">Surat Keputusan (SK)</span>
                    </a>

                    <a href="{{ route('dashboard.sekretariat.absensi.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-emerald-800/50 text-emerald-100 hover:text-white transition-colors {{ request()->routeIs('dashboard.sekretariat.absensi.*') ? 'bg-emerald-800 text-white shadow-lg shadow-emerald-900/20' : '' }}">
                        <span class="material-symbols-outlined">qr_code_scanner</span>
                        <span class="font-medium">Absensi & Kumpulan</span>
                    </a>

                    <a href="{{ route('dashboard.sekretariat.surat-masuk.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-emerald-800/50 text-emerald-100 hover:text-white transition-colors {{ request()->routeIs('dashboard.sekretariat.surat-masuk.*') ? 'bg-emerald-800 text-white shadow-lg shadow-emerald-900/20' : '' }}">
                        <span class="material-symbols-outlined">mail</span>
                        <span class="font-medium">Surat Masuk</span>
                    </a>

                    <a href="{{ route('dashboard.sekretariat.surat-keluar.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-emerald-800/50 text-emerald-100 hover:text-white transition-colors {{ request()->routeIs('dashboard.sekretariat.surat-keluar.*') ? 'bg-emerald-800 text-white shadow-lg shadow-emerald-900/20' : '' }}">
                        <span class="material-symbols-outlined">send</span>
                        <span class="font-medium">Surat Keluar</span>
                    </a>
                @endif

                <!-- Dep. Organisasi Module (PAC & Admin & Dep. Organisasi) -->
                @if(in_array(auth()->user()->role, ['admin', 'pac', 'dep_organisasi']))
                    <p class="px-4 py-2 mt-6 text-xs font-bold text-emerald-400 uppercase tracking-wider">Dep. Organisasi
                    </p>

                    <a href="{{ auth()->user()->role === 'pac' ? route('dashboard.pac.proker.index') : route('dashboard.admin.proker.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-emerald-800/50 text-emerald-100 hover:text-white transition-colors {{ request()->routeIs('dashboard.pac.proker.*') || request()->routeIs('dashboard.admin.proker.*') ? 'bg-emerald-800 text-white shadow-lg shadow-emerald-900/20' : '' }}">
                        <span class="material-symbols-outlined">event_available</span>
                        <span class="font-medium">Daftar Program Kerja</span>
                    </a>

                    @if(in_array(auth()->user()->role, ['admin', 'dep_organisasi']))
                        <a href="{{ route('dashboard.admin.analisa.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-emerald-800/50 text-emerald-100 hover:text-white transition-colors {{ request()->routeIs('dashboard.admin.analisa.*') ? 'bg-emerald-800 text-white shadow-lg shadow-emerald-900/20' : '' }}">
                            <span class="material-symbols-outlined">analytics</span>
                            <span class="font-medium">Analisa Data</span>
                        </a>

                        <a href="{{ route('dashboard.admin.pac.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-emerald-800/50 text-emerald-100 hover:text-white transition-colors {{ request()->routeIs('dashboard.admin.pac.*') ? 'bg-emerald-800 text-white shadow-lg shadow-emerald-900/20' : '' }}">
                            <span class="material-symbols-outlined">manage_accounts</span>
                            <span class="font-medium">Manajemen Akun PAC</span>
                        </a>
                    @endif
                @endif

                <!-- Departemen Module -->
                @if(auth()->user()->role == 'departemen')
                    <p class="px-4 py-2 mt-6 text-xs font-bold text-emerald-400 uppercase tracking-wider">
                        {{ auth()->user()->name }}
                    </p>

                    <a href="{{ route('dashboard.departemen.proker.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-emerald-800/50 text-emerald-100 hover:text-white transition-colors {{ request()->routeIs('dashboard.departemen.proker.*') ? 'bg-emerald-800 text-white shadow-lg shadow-emerald-900/20' : '' }}">
                        <span class="material-symbols-outlined">event_note</span>
                        <span class="font-medium">Program Kerja</span>
                    </a>
                @endif

                <!-- Logout (Mobile Only) -->
                <div class="lg:hidden mt-8 pt-8 border-t border-emerald-800">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-900/50 text-red-300 hover:text-white transition-colors">
                            <span class="material-symbols-outlined">logout</span>
                            <span class="font-medium">Logout</span>
                        </button>
                    </form>
                </div>

            </nav>
        </aside>

        <!-- Overlay -->
        <div class="fixed inset-0 z-40 bg-black/50 lg:hidden" x-show="sidebarOpen" x-transition.opacity
            @click="sidebarOpen = false"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-h-screen overflow-hidden">

            <!-- Topbar -->
            <header
                class="h-16 bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-white/5 flex items-center justify-between px-4 lg:px-6 shadow-sm z-30">
                <!-- Hamburger -->
                <button @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden text-gray-500 hover:text-emerald-600 focus:outline-none">
                    <span class="material-symbols-outlined text-3xl">menu</span>
                </button>

                <!-- Search/Title (Placeholder) -->
                <div class="hidden lg:block text-sm font-medium text-gray-500">
                    @yield('title')
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-4">
                    <!-- Dark Mode Toggle (Simple JS Implementation or placeholder) -->
                    <button onclick="document.documentElement.classList.toggle('dark')"
                        class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-500 dark:text-gray-400">
                        <span class="material-symbols-outlined">dark_mode</span>
                    </button>

                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-3 focus:outline-none">
                            <div class="text-right hidden sm:block">
                                <div class="text-sm font-bold text-gray-900 dark:text-white leading-none">
                                    {{ Auth::user()->name }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                    {{ Auth::user()->role ?? 'User' }}
                                </div>
                            </div>
                            <div
                                class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-lg">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 py-1"
                            x-transition.origin.top.right x-cloak>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Profil
                                Saya</a>
                            <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Body -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-surface-light dark:bg-[#051111] p-4 lg:p-8">
                @yield('content')
            </main>

        </div>

    </div>

</body>

</html>