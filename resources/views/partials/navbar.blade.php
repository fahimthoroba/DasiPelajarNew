<nav
    class="fixed w-full z-50 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md border-b border-gray-100 dark:border-white/5 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <!-- Logo -->
                <!-- Logo -->
                <div class="relative top-[2px] w-[38px] h-[38px]">
                    <!-- Light Mode Logo (Green) -->
                    <img src="{{ asset('img/logo-light.png') }}?v=2" alt="Logo"
                        class="absolute inset-0 w-full h-full object-contain dark:hidden">

                    <!-- Dark Mode Logo (White) -->
                    <img src="{{ asset('img/logo-dark.png') }}?v=2" alt="Logo"
                        class="absolute inset-0 w-full h-full object-contain hidden dark:block">
                </div>
                <div class="leading-tight ml-1 w-fit">
                    <h1 class="font-display font-black text-2xl tracking-tight text-emerald-900 dark:text-white">
                        DASI <span class="text-amber-700 dark:text-amber-500">PELAJAR</span>
                    </h1>

                    <p
                        class="text-[10px] tracking-wider [word-spacing:4px] text-gray-500 dark:text-gray-400 font-medium">
                        PC IPNU IPPNU KAB. KEDIRI
                    </p>
                </div>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}"
                    class="{{ request()->routeIs('home') ? 'text-emerald-900 dark:text-emerald-400 font-bold' : 'text-gray-500 dark:text-gray-400 font-medium hover:text-emerald-800 dark:hover:text-emerald-400' }} transition-colors">
                    Beranda
                </a>

                <a href="{{ request()->routeIs('home') ? '#berita' : route('berita.index') }}"
                    class="{{ request()->routeIs('berita.*') ? 'text-emerald-900 dark:text-emerald-400 font-bold' : 'text-gray-500 dark:text-gray-400 font-medium hover:text-emerald-800 dark:hover:text-emerald-400' }} transition-colors">
                    Berita
                </a>

                <a href="{{ request()->routeIs('home') ? '#program' : url('/#program') }}"
                    class="text-gray-500 dark:text-gray-400 font-medium hover:text-emerald-800 dark:hover:text-emerald-400 transition-colors">
                    Program
                </a>

                <a href="{{ route('layanan') }}"
                    class="{{ request()->routeIs('layanan') ? 'text-emerald-900 dark:text-emerald-400 font-bold' : 'text-gray-500 dark:text-gray-400 font-medium hover:text-emerald-800 dark:hover:text-emerald-400' }} transition-colors">
                    Layanan
                </a>
            </div>

            <!-- CTA & Theme Toggle -->
            <div class="flex items-center gap-4">
                <button onclick="toggleTheme()"
                    class="w-9 h-9 rounded-full bg-gray-100 dark:bg-white/10 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-emerald-100 dark:hover:bg-emerald-900 hover:text-emerald-700 dark:hover:text-emerald-400 transition-all">
                    <span class="material-symbols-outlined dark:hidden">light_mode</span>
                    <span class="material-symbols-outlined hidden dark:block">dark_mode</span>
                </button>

                <a href="{{ route('login') }}"
                    class="hidden md:inline-flex px-6 py-2.5 bg-emerald-800 text-white rounded-full font-bold text-sm shadow-lg shadow-emerald-800/20 hover:bg-emerald-900 transition-all hover:-translate-y-0.5">
                    Login Pengurus
                </a>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" onclick="toggleMobileMenu()"
                        class="text-gray-500 dark:text-gray-400 hover:text-emerald-800 focus:outline-none">
                        <span class="material-symbols-outlined text-3xl">menu</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div id="mobile-menu"
        class="hidden md:hidden bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-white/5 absolute w-full left-0 top-20 shadow-xl p-4 flex flex-col gap-4">
        <a href="{{ route('home') }}"
            class="block px-4 py-3 rounded-xl {{ request()->routeIs('home') ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 font-bold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5' }}">
            Beranda
        </a>
        <a href="{{ route('berita.index') }}"
            class="block px-4 py-3 rounded-xl {{ request()->routeIs('berita.*') ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 font-bold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5' }}">
            Berita
        </a>
        <a href="{{ request()->routeIs('home') ? '#program' : url('/#program') }}"
            class="block px-4 py-3 rounded-xl text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5">
            Program
        </a>
        <a href="{{ route('layanan') }}"
            class="block px-4 py-3 rounded-xl {{ request()->routeIs('layanan') ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 font-bold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5' }}">
            Layanan
        </a>
        <a href="/admin"
            class="block w-full text-center px-6 py-3 bg-emerald-800 text-white rounded-xl font-bold hover:bg-emerald-900">
            Login Pengurus
        </a>
    </div>
</nav>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    }

    // Theme Toggle Logic...
    function toggleTheme() {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.theme = 'light';
        } else {
            document.documentElement.classList.add('dark');
            localStorage.theme = 'dark';
        }
    }

    // Initial Check (Run this here ensuring it catches if head script missed it or on nav load)
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark')
    } else {
        document.documentElement.classList.remove('dark')
    }
</script>