@php
    // $pengaturan is already shared via AppServiceProvider
@endphp
<footer class="bg-black border-t border-gray-900 pt-20 pb-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 mb-16">
            <!-- Branding -->
            <div class="md:col-span-5 space-y-6">
                <!-- Brand -->
                <div class="flex items-center gap-3 relative">
                    <!-- Logo -->
                    <div class="relative w-[37px] h-[37px] -top-[-3px]">
                        <img src="{{ asset('img/logo-dark.png') }}?v=2" alt="Logo"
                            class="w-full h-full object-contain drop-shadow-lg">
                    </div>

                    <!-- Brand Text -->
                    <div class="leading-tight relative top-[1px]">
                        <h2 class="font-display font-black text-2xl tracking-tight text-white">
                            DASI <span class="text-amber-500">PELAJAR</span>
                        </h2>
                        <p class="text-[10px] font-bold uppercase tracking-[0.13em]
                       text-emerald-500/80">
                            PC IPNU IPPNU KAB. KEDIRI
                        </p>
                    </div>
                </div>

                <!-- Description -->
                <p class="text-gray-400 text-sm leading-relaxed max-w-sm">
                    Data Automatisasi Sinergi Informasi (DASI) Pelajar.
                    Sinergi membangun peradaban digital berkarakter Aswaja.
                </p>
            </div>


            <!-- Navigasi -->
            <div class="md:col-span-2">
                <h4
                    class="text-white font-bold text-lg mb-6 flex items-center gap-3 border-l-4 border-emerald-500 pl-3">
                    Navigasi
                </h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('home') }}"
                            class="text-gray-400 hover:text-emerald-400 transition-colors text-sm font-medium">Beranda</a>
                    </li>
                    <li><a href="{{ route('profil') }}"
                            class="text-gray-400 hover:text-emerald-400 transition-colors text-sm font-medium">Profil</a>
                    </li>
                    <li><a href="{{ route('berita.index') }}"
                            class="text-gray-400 hover:text-emerald-400 transition-colors text-sm font-medium">Berita</a>
                    </li>
                    <li><a href="{{ route('layanan') }}"
                            class="text-gray-400 hover:text-emerald-400 transition-colors text-sm font-medium">Layanan</a>
                    </li>
                    <li><a href="/login"
                            class="text-gray-400 hover:text-emerald-400 transition-colors text-sm font-medium">Login
                            Pengurus</a></li>
                </ul>
            </div>

            <!-- Hubungi Kami -->
            <div class="md:col-span-3">
                <h4
                    class="text-white font-bold text-lg mb-6 flex items-center gap-3 border-l-4 border-emerald-500 pl-3">
                    Hubungi Kami
                </h4>
                <ul class="space-y-6">
                    <li class="flex items-start gap-4 group">
                        <div
                            class="w-8 h-8 rounded-lg bg-gray-800 flex items-center justify-center text-emerald-500 shrink-0 group-hover:bg-emerald-900 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <span
                                class="block text-white font-bold text-sm group-hover:text-emerald-400 transition-colors">WhatsApp
                                Admin</span>
                            <span class="text-gray-500 text-xs">0812-3456-7890</span>
                        </div>
                    </li>
                    <li class="flex items-start gap-4 group">
                        <div
                            class="w-8 h-8 rounded-lg bg-gray-800 flex items-center justify-center text-emerald-500 shrink-0 group-hover:bg-emerald-900 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <span
                                class="block text-white font-bold text-sm group-hover:text-emerald-400 transition-colors">Email</span>
                            <span class="text-gray-500 text-xs">{{ $pengaturan->email ??
                                'admin@ipnuippnukediri.or.id'
                                }}</span>
                        </div>
                    </li>
                    <li class="flex items-start gap-4 group">
                        <div
                            class="w-8 h-8 rounded-lg bg-gray-800 flex items-center justify-center text-emerald-500 shrink-0 group-hover:bg-emerald-900 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="block text-white font-bold text-sm">Kantor</span>
                            <span
                                class="text-gray-500 text-xs leading-tight">{{ $pengaturan->alamat ?? 'Jl. Imam Bonjol No. 12, Kediri' }}</span>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Ikuti Kami -->
            <div class="md:col-span-2">
                <h4
                    class="text-white font-bold text-lg mb-6 flex items-center gap-3 border-l-4 border-emerald-500 pl-3">
                    Ikuti Kami
                </h4>
                <p class="text-gray-500 text-xs mb-6 leading-relaxed">
                    Dapatkan update terbaru melalui media sosial kami.
                </p>
                <div class="flex gap-3">
                    @if($pengaturan->instagram)
                        <a href="{{ $pengaturan->instagram }}"
                            class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-emerald-600 hover:text-white transition-all ring-1 ring-white/5 hover:ring-emerald-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                        </a>
                    @endif
                    @if($pengaturan->youtube)
                        <a href="{{ $pengaturan->youtube }}"
                            class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-red-600 hover:text-white transition-all ring-1 ring-white/5 hover:ring-red-500">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                            </svg>
                        </a>
                    @endif
                    @if($pengaturan->tiktok)
                        <a href="{{ $pengaturan->tiktok }}"
                            class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-black hover:text-white transition-all ring-1 ring-white/5 hover:ring-gray-600">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-xs text-gray-600 font-medium">
                &copy; {{ date('Y') }} PC IPNU IPPNU Kabupaten Kediri. All Rights Reserved.
            </p>
            <div class="flex gap-6 text-xs text-gray-600 font-bold uppercase tracking-wider">
                <a href="#" class="hover:text-emerald-500 transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-emerald-500 transition-colors">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>