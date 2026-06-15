<nav class="fixed w-full z-50 bg-[#08332c] border-b-[3px] border-[#ba9e6f] transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <!-- Logo -->
                <div class="relative top-[2px] w-[38px] h-[38px]">
                    <img src="{{ asset('img/logo-dark.png') }}?v=2" alt="Logo"
                        class="absolute inset-0 w-full h-full object-contain">
                </div>
                <div class="leading-tight ml-1 w-fit">
                    <h1 class="font-display font-black text-2xl tracking-tight text-white">
                        DASI <span class="text-[#ba9e6f]">PELAJAR</span>
                    </h1>
                    <p class="text-[10px] tracking-wider [word-spacing:4px] text-white/60 font-medium">
                        PC IPNU IPPNU KAB. KEDIRI
                    </p>
                </div>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}"
                    class="{{ request()->routeIs('home') ? 'text-[#ba9e6f] font-bold' : 'text-white/80 font-medium hover:text-[#ba9e6f]' }} transition-colors">
                    Beranda
                </a>

                <a href="{{ route('berita.index') }}"
                    class="{{ request()->routeIs('berita.*') ? 'text-[#ba9e6f] font-bold' : 'text-white/80 font-medium hover:text-[#ba9e6f]' }} transition-colors">
                    Berita
                </a>

                <a href="{{ route('agenda') }}"
                    class="{{ request()->routeIs('agenda') ? 'text-[#ba9e6f] font-bold' : 'text-white/80 font-medium hover:text-[#ba9e6f]' }} transition-colors">
                    Program
                </a>

                <a href="{{ route('layanan') }}"
                    class="{{ request()->routeIs('layanan') ? 'text-[#ba9e6f] font-bold' : 'text-white/80 font-medium hover:text-[#ba9e6f]' }} transition-colors">
                    Layanan
                </a>
            </div>

            <!-- CTA & Theme Toggle -->
            <div class="flex items-center gap-4">
                <button onclick="toggleTheme()"
                    class="w-11 h-11 rounded-full bg-white/10 flex items-center justify-center text-white/70 hover:bg-[#ba9e6f]/20 hover:text-[#ba9e6f] transition-all">
                    <span class="material-symbols-outlined dark:hidden">light_mode</span>
                    <span class="material-symbols-outlined hidden dark:block">dark_mode</span>
                </button>

                <a href="{{ route('login') }}"
                    class="hidden md:inline-flex px-6 py-2.5 bg-[#ba9e6f] text-[#08332c] rounded-full font-bold text-sm hover:bg-[#d4bc91] transition-all hover:-translate-y-0.5">
                    Login Pengurus
                </a>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" onclick="toggleMobileMenu()"
                        class="p-2 min-w-[44px] min-h-[44px] flex items-center justify-center text-white/80 hover:text-[#ba9e6f] focus:outline-none">
                        <span class="material-symbols-outlined text-3xl">menu</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div id="mobile-menu"
        class="hidden md:hidden bg-[#08332c] border-t border-[#ba9e6f]/30 absolute w-full left-0 top-20 shadow-xl p-4 flex flex-col gap-4">
        <a href="{{ route('home') }}"
            class="block px-4 py-3 rounded-xl {{ request()->routeIs('home') ? 'bg-[#ba9e6f]/20 text-[#ba9e6f] font-bold' : 'text-white/80 hover:bg-white/5' }}">
            Beranda
        </a>
        <a href="{{ route('berita.index') }}"
            class="block px-4 py-3 rounded-xl {{ request()->routeIs('berita.*') ? 'bg-[#ba9e6f]/20 text-[#ba9e6f] font-bold' : 'text-white/80 hover:bg-white/5' }}">
            Berita
        </a>
        <a href="{{ route('agenda') }}"
            class="block px-4 py-3 rounded-xl {{ request()->routeIs('agenda') ? 'bg-[#ba9e6f]/20 text-[#ba9e6f] font-bold' : 'text-white/80 hover:bg-white/5' }}">
            Program
        </a>
        <a href="{{ route('layanan') }}"
            class="block px-4 py-3 rounded-xl {{ request()->routeIs('layanan') ? 'bg-[#ba9e6f]/20 text-[#ba9e6f] font-bold' : 'text-white/80 hover:bg-white/5' }}">
            Layanan
        </a>
        <a href="{{ route('login') }}"
            class="block w-full text-center px-6 py-3 bg-[#ba9e6f] text-[#08332c] rounded-xl font-bold hover:bg-[#d4bc91]">
            Login Pengurus
        </a>
    </div>
</nav>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
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

    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark')
    } else {
        document.documentElement.classList.remove('dark')
    }
</script>
