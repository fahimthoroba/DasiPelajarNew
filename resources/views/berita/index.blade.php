<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Berita & Informasi - PC IPNU IPPNU Kediri</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
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
    @include('partials.theme-init')
</head>

<body
    class="bg-surface-light dark:bg-[#022C22] font-body text-slate-800 dark:text-gray-100 antialiased selection:bg-emerald-200 selection:text-emerald-900 transition-colors duration-300">

    @include('partials.navbar')

    <main class="pt-32 pb-24 px-4 sm:px-6 relative min-h-screen">
        <div class="max-w-7xl mx-auto relative z-10">
            <!-- Page Title / Hero Slider -->
            <div
                class="mb-12 relative overflow-hidden rounded-3xl bg-emerald-900 border border-emerald-800 dark:border-white/10 text-white shadow-2xl group h-[400px] md:h-[500px]">

                <!-- Swiper Container -->
                <div class="swiper mySwiper w-full h-full absolute inset-0 z-0">
                    <div class="swiper-wrapper">
                        @forelse($sliders as $slider)
                            <div class="swiper-slide relative w-full h-full">
                                <img src="{{ asset('storage/' . $slider->gambar_path) }}" class="w-full h-full object-cover"
                                    alt="{{ $slider->judul_utama }}">
                                <!-- Overlay Gradient (Dark from Left to Right, covering 75%) -->
                                <div
                                    class="absolute inset-y-0 left-0 w-full md:w-[75%] bg-gradient-to-r from-black/75 via-black/45 to-transparent z-5">
                                </div>

                                <!-- Content (Left Aligned) -->
                                <div class="absolute inset-0 flex items-center justify-start z-20 p-8 md:p-16">
                                    <div class="max-w-3xl" data-aos="fade-right">
                                        <span
                                            class="inline-block px-3 py-1 bg-white/10 backdrop-blur rounded-lg text-emerald-300 text-xs font-bold uppercase tracking-widest mb-4">
                                            {{ $slider->label ?? 'Suara Pelajar Kediri' }}
                                        </span>

                                        {{-- Title First --}}
                                        <h1
                                            class="font-display font-black text-3xl md:text-5xl lg:text-6xl text-white mb-4 leading-tight drop-shadow-lg">
                                            {{ $slider->judul_utama }}
                                        </h1>

                                        {{-- Subtitle / Description Below --}}
                                        @if($slider->sub_judul)
                                            <p
                                                class="text-gray-200 text-lg md:text-xl mb-8 leading-relaxed max-w-xl font-light">
                                                {{ $slider->sub_judul }}
                                            </p>
                                        @endif

                                        {{-- Button Below Text --}}
                                        @if($slider->link_tombol)
                                            <a href="{{ $slider->link_tombol }}"
                                                class="inline-flex items-center gap-2 px-8 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-base md:text-lg hover:shadow-lg hover:shadow-emerald-600/20 transition-all hover:-translate-y-1">
                                                {{ $slider->teks_tombol ?? 'Selengkapnya' }}
                                                <span class="material-symbols-outlined text-xl">arrow_forward</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="swiper-slide relative w-full h-full">
                                <div class="absolute inset-0 bg-emerald-900"></div>
                                <div
                                    class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <!-- Pagination/Nav could go here if needed, but keeping it clean for a header background feel -->
                </div>


            </div>

            <!-- Swiper CSS/JS (CDN for now, or ensure installed) -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
            <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
            <script>
                var swiper = new Swiper(".mySwiper", {
                    spaceBetween: 0,
                    effect: "fade",
                    centeredSlides: true,
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false,
                    },
                    loop: true,
                });
            </script>

            <!-- News Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 auto-rows-min">
                @forelse($berita_list as $berita)
                    @php
                        // Cycle of 12 pattern (Mirrored Block)
                        $pos = ($loop->iteration - 1) % 12;

                        // Default Mobile Classes (Flex Row, Image Right, Fixed Thumbnail)
                        $wrapperClasses = "group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-100 dark:border-white/10 hover:border-emerald-200 dark:hover:border-emerald-500/50 hover:shadow-xl hover:shadow-emerald-900/5 dark:shadow-none transition-all duration-300 flex flex-row items-center gap-4 p-3 h-full relative";
                        $imageWrapperClasses = "w-24 h-24 rounded-lg overflow-hidden shrink-0 order-last relative";
                        $imageClasses = "object-cover w-full h-full group-hover:scale-110 transition-transform duration-700";
                        $contentClasses = "flex-1 min-w-0 py-1";
                        $titleClasses = "font-display font-bold text-sm text-gray-900 dark:text-white leading-tight group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors line-clamp-2 mb-1";
                        $metaClasses = "text-[10px] text-gray-500 dark:text-gray-400 mb-1";
                        $summaryClasses = "hidden";

                        // Logic Helper
                        $isBig = in_array($pos, [0, 9]);
                        $isWide = in_array($pos, [4, 11]);
                        $isSmall = !($isBig || $isWide);

                        // Desktop Bento Overrides
                        if ($isBig) {
                            // BIG FEATURE (2x3) - Vertical Stack
                            $wrapperClasses .= " md:col-span-2 lg:col-span-2 lg:row-span-3 md:flex md:flex-col md:items-start md:gap-0 md:p-0";
                            $imageWrapperClasses = "md:w-full md:aspect-[16/9] md:h-auto md:order-first md:rounded-none";
                            $contentClasses = "md:p-8 md:flex md:flex-col md:grow md:w-full";
                            $titleClasses = "md:text-3xl lg:text-4xl md:text-gray-900 md:dark:text-white md:mb-4 md:line-clamp-3";
                            $metaClasses = "md:text-gray-500 md:mb-3 md:text-sm";
                            $summaryClasses = "hidden md:block md:text-gray-500 md:dark:text-gray-400 md:text-base md:line-clamp-4 md:mb-6";
                        } elseif ($isWide) {
                            // WIDE FEATURE (2x1) - Horizontal Side-by-Side
                            $wrapperClasses .= " md:col-span-2 lg:col-span-2 lg:row-span-1 md:flex md:flex-row md:items-center md:gap-6 md:p-6";
                            $imageWrapperClasses = "md:w-1/3 md:h-full md:order-last md:rounded-xl"; // Image Right for consistency
                            $contentClasses = "md:block md:flex-1";
                            $titleClasses = "md:text-2xl md:text-gray-900 md:dark:text-white md:mb-2";
                            $metaClasses = "md:text-gray-500 md:mb-2 md:text-xs";
                            $summaryClasses = "hidden md:block md:text-gray-500 md:dark:text-gray-400 md:text-sm md:line-clamp-2";
                        } else {
                            // SMALL CARDS (1x1) - Horizontal Side-by-Side
                            $wrapperClasses .= " md:col-span-1 lg:col-span-1 lg:row-span-1 md:flex md:flex-row md:items-center md:gap-4 md:p-4";
                            $imageWrapperClasses = "md:w-28 md:h-28 lg:w-32 lg:h-32 md:order-last md:rounded-lg";
                            $contentClasses = "md:flex-1 md:min-w-0";
                            $titleClasses = "md:text-lg md:text-gray-900 md:dark:text-white md:mb-2 md:line-clamp-2";
                            $metaClasses = "md:text-gray-500 md:mb-2 md:text-xs";
                            $summaryClasses = "hidden";
                        }
                    @endphp

                    <article class="{{ $wrapperClasses }}">
                        <!-- Image Container -->
                        <div class="{{ $imageWrapperClasses }}">
                            <img src="{{ $berita->thumbnail ? asset('storage/' . $berita->thumbnail) : 'https://placehold.co/800x600/e2e8f0/1e293b?text=DasiPelajar' }}"
                                alt="{{ $berita->judul }}" class="{{ $imageClasses }}">

                            <!-- Category Badge -->
                            <span
                                class="absolute top-2 left-2 bg-white/90 dark:bg-gray-900/90 backdrop-blur text-emerald-800 dark:text-emerald-400 text-[8px] md:text-[10px] font-black uppercase px-2 py-1 rounded shadow-sm z-20">
                                {{ $berita->kategori?->nama ?? 'Berita' }}
                            </span>
                        </div>

                        <!-- Content Container -->
                        <div class="{{ $contentClasses }}">
                            <!-- Meta -->
                            <div class="{{ $metaClasses }}">
                                {{ \Carbon\Carbon::parse($berita->tgl_publish)->translatedFormat('d M Y') }}
                            </div>

                            <!-- Title -->
                            <h3 class="{{ $titleClasses }}">
                                <a href="{{ route('berita.show', $berita->slug) }}" class="focus:outline-none">
                                    <span class="absolute inset-0 z-10" aria-hidden="true"></span>
                                    {{ $berita->judul }}
                                </a>
                            </h3>

                            <!-- Summary (Hidden on Mobile/Small) -->
                            <p class="{{ $summaryClasses }}">
                                {{ Str::limit(strip_tags($berita->konten), 120) }}
                            </p>

                            <!-- Read More (Big Only) -->
                            @if($isBig)
                                <div
                                    class="hidden md:flex pt-4 mt-auto items-center text-sm font-bold text-emerald-600 dark:text-emerald-400 group-hover:gap-2 transition-all">
                                    Baca Selengkapnya <span class="material-symbols-outlined text-lg ml-1">arrow_forward</span>
                                </div>
                            @endif
                        </div>
                    </article>
                @empty
                    <div
                        class="col-span-full text-center py-24 bg-white dark:bg-gray-800 rounded-3xl border border-dashed border-gray-200 dark:border-gray-700">
                        <div
                            class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 mb-6">
                            <span class="material-symbols-outlined text-4xl">newspaper</span>
                        </div>
                        <h3 class="text-gray-900 dark:text-white font-bold text-xl mb-2">Belum Ada Berita</h3>
                        <p class="text-gray-500 dark:text-gray-400">Nantikan informasi terbaru dari kami.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-16">
                {{ $berita_list->links('pagination::tailwind') }}
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>

</html>