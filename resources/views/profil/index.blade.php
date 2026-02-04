<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil & Sejarah - PC IPNU IPPNU Kediri</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Outfit:wght@400;700;900&display=swap"
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
                        emerald: {
                            900: '#022C22',
                            800: '#064E3B',
                            400: '#34D399',
                        },
                        amber: {
                            900: '#78350F',
                            700: '#B45309',
                            400: '#FBBF24',
                        },
                        gold: {
                            500: '#C5A059',
                            600: '#9F803A',
                        },
                        surface: {
                            light: '#F8F8F8',
                            dark: '#121212',
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
    @include('partials.theme-init')
</head>

<body
    class="bg-gray-50 dark:bg-[#051111] text-gray-900 dark:text-gray-100 font-body antialiased transition-colors duration-300 flex flex-col min-h-screen">

    @include('partials.navbar')

    <!-- HERO SECTION -->
    <section class="pt-40 pb-20 bg-emerald-900 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10">
        </div>
        <div
            class="absolute top-0 right-0 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
        </div>
        <div
            class="absolute bottom-0 left-0 w-72 h-72 bg-amber-500/20 rounded-full blur-2xl translate-y-1/2 -translate-x-1/4">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span class="text-emerald-300 font-bold tracking-widest uppercase text-sm mb-4 block">Tentang Kami</span>
            <h1 class="font-display font-black text-4xl md:text-6xl text-white mb-6">Profil, Visi & Misi</h1>
            <p class="text-xl text-emerald-100 max-w-2xl mx-auto font-light leading-relaxed">
                Mengenal lebih dekat PC IPNU IPPNU Kabupaten Kediri sebagai wadah perjuangan pelajar Nahdlatul Ulama.
            </p>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="py-20 relative">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Profil Singkat -->
            <div class="mb-20">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-2 h-10 bg-emerald-600 rounded-full"></div>
                    <h2 class="font-display font-bold text-3xl text-gray-900 dark:text-white">Profil Singkat</h2>
                </div>
                <div
                    class="prose prose-lg dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 leading-relaxed bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-white/5">
                    @if($pengaturan && $pengaturan->profil_singkat)
                        {!! nl2br(e($pengaturan->profil_singkat)) !!}
                    @else
                        <p class="italic text-gray-400">Belum ada data profil singkat.</p>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Visi -->
                <div>
                    <div class="flex items-center gap-4 mb-8">
                        <div
                            class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center text-amber-600 dark:text-amber-500">
                            <span class="material-symbols-outlined text-2xl">visibility</span>
                        </div>
                        <h2 class="font-display font-bold text-3xl text-gray-900 dark:text-white">Visi</h2>
                    </div>
                    <div
                        class="bg-gradient-to-br from-amber-50 to-white dark:from-gray-800 dark:to-gray-900 p-8 rounded-3xl shadow-sm border border-amber-100 dark:border-white/5 h-full relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                            <span class="material-symbols-outlined text-9xl">visibility</span>
                        </div>
                        <p
                            class="text-3l font-display font-medium text-gray-800 dark:text-gray-100 relative z-10 leading-relaxed">
                            "{{ $pengaturan->visi ?? 'Terbentuknya pelajar bangsa yang bertaqwa kepada Allah SWT, berilmu, berakhlaq mulia dan berwawasan kebangsaan serta bertanggungjawab atas tegak dan terlaksananya syariat Islam menurut faham ahlussunnah wal jamaah an nahdliyah yang berdasarkan Pancasila dan Undang-Undang Dasar 1945.' }}"
                        </p>
                    </div>
                </div>

                <!-- Misi -->
                <div>
                    <div class="flex items-center gap-4 mb-8">
                        <div
                            class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-500">
                            <span class="material-symbols-outlined text-2xl">rocket_launch</span>
                        </div>
                        <h2 class="font-display font-bold text-3xl text-gray-900 dark:text-white">Misi</h2>
                    </div>
                    <div
                        class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-white/5 h-full">
                        @if($pengaturan && $pengaturan->misi)
                            <div class="prose prose-emerald dark:prose-invert">
                                {!! $pengaturan->misi !!}
                                <!-- Assuming Misi is stored as HTML/List or we explode it. Usually it's rich text or multiline. -->
                                <!-- If it's plain text, we might want to split by newline -->
                                @if(!Str::contains($pengaturan->misi, '<'))
                                    <ul class="space-y-4">
                                        @foreach(explode("\n", $pengaturan->misi) as $misi)
                                            @if(trim($misi))
                                                <!-- <li class="flex gap-3">
                                                                                                    <span class="mt-1.5 w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                                                                                                    <span class="text-gray-700 dark:text-gray-300">{{ $misi }}</span>
                                                                                                </li> -->
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @else
                            <p class="italic text-gray-400">Belum ada data misi.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </section>

    @include('partials.footer')

</body>

</html>