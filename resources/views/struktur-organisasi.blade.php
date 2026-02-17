<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Struktur Organisasi - PC {{ $orgName }} Kediri</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <!-- Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
        /* --- CSS KHUSUS UNTUK TREE --- */

        /* 1. Horizontal Tree (Untuk Wakil Ketua & Koordinator) */
        .tree ul {
            padding-top: 20px;
            position: relative;
            transition: all 0.5s;
            display: flex;
            justify-content: center;
        }

        .tree li {
            float: left;
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 10px 0 10px;
            transition: all 0.5s;
        }

        /* Garis Konektor Horizontal */
        .tree li::before,
        .tree li::after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            border-top: 2px solid #cbd5e1;
            width: 50%;
            height: 20px;
        }

        .tree li::after {
            right: auto;
            left: 50%;
            border-left: 2px solid #cbd5e1;
        }

        .tree li:only-child::after,
        .tree li:only-child::before {
            display: none;
        }

        .tree li:only-child {
            padding-top: 0;
        }

        .tree li:first-child::before,
        .tree li:last-child::after {
            border: 0 none;
        }

        .tree li:last-child::before {
            border-right: 2px solid #e1cbcbff;
            border-radius: 0 5px 0 0;
        }

        .tree li:first-child::after {
            border-radius: 5px 0 0 0;
        }

        .tree ul ul::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            border-left: 2px solid #e1cbcbff;
            width: 0;
            height: 20px;
        }

        /* 2. Vertical Left-Line Tree (Untuk Wakil Sekretaris & Anggota Lembaga) 
           Style: Garis lurus di kiri, anak cabang ke kanan */
        .vertical-left-tree {
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Rata Kiri */
            position: relative;
            padding-left: 20px;
            /* Space untuk garis vertikal */
            margin-top: 10px;
        }

        /* Garis Utama Vertikal di Kiri */
        .vertical-left-tree::before {
            content: '';
            position: absolute;
            top: 0;
            left: 10px;
            /* Posisi garis */
            height: 100%;
            border-left: 2px solid #cbd5e1;
            z-index: 0;
        }

        /* Item List */
        .v-item {
            position: relative;
            margin-bottom: 10px;
            width: 100%;
        }

        /* Garis Cabang Horizontal Kecil ke Kartu */
        .v-item::before {
            content: '';
            position: absolute;
            top: 24px;
            /* Tengah-tengah kartu kecil */
            left: -10px;
            /* Connect ke garis utama */
            width: 10px;
            height: 2px;
            background: #cbd5e1;
        }

        /* Penutup garis vertikal agar tidak bablas ke bawah di item terakhir */
        .v-item:last-child {
            background: transparent;
        }

        .vertical-left-tree .v-item:last-child::after {
            content: '';
            position: absolute;
            top: 24px;
            left: -12px;
            width: 4px;
            bottom: 0;
            background: #f8fafc;
            /* Tutupi sisa garis dengan warna background */
        }

        /* 3. Card Styles */
        .card-node {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 12px 10px;
            width: 140px;
            transition: all 0.3s ease;
            cursor: pointer;
            z-index: 20;
            margin: 0 auto;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        /* Card Kecil untuk list vertikal */
        .card-node-small {
            width: 100%;
            max-width: 180px;
            padding: 8px;
            border-radius: 12px;
            flex-direction: row;
            gap: 10px;
            align-items: center;
        }

        .card-node:hover {
            transform: translateY(-5px);
            border-color: #10b981;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .photo-wrapper {
            width: 70px;
            height: 70px;
            border-radius: 9999px;
            overflow: hidden;
            margin-bottom: 8px;
            border: 3px solid #f0fdf4;
            box-shadow: 0 0 0 1px #10b981;
        }

        .card-node-small .photo-wrapper {
            width: 40px;
            height: 40px;
            margin-bottom: 0;
            border-width: 1px;
        }

        .photo-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .role-badge {
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            padding: 2px 8px;
            border-radius: 99px;
            margin-bottom: 4px;
        }

        .name-text {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 12px;
            color: #1e293b;
            line-height: 1.2;
            text-align: center;
        }

        :is(.dark .name-text) {
            color: #f3f4f6;
        }

        :is(.dark .card-node) {
            background-color: #1f2937;
            border-color: rgba(255, 255, 255, 0.1);
            box-shadow: none;
        }

        :is(.dark .vertical-left-tree::before),
        :is(.dark .tree li::leading),
        :is(.dark .tree li::after),
        :is(.dark .tree li::before),
        :is(.dark .v-item::before),
        :is(.dark .tree ul ul::before) {
            border-color: rgba(255, 255, 255, 0.1);
        }

        :is(.dark .v-item::before) {
            background-color: rgba(255, 255, 255, 0.1);
        }

        :is(.dark .vertical-left-tree .v-item:last-child::after) {
            background-color: #051111;
            /* Match body bg */
        }

        .card-node-small .name-text {
            text-align: left;
        }

        /* Mobile View */
        /* Mobile View CSS Removed to allow horizontal scrolling of desktop tree */

        @media (min-width: 769px) {
            .mobile-list {
                display: none;
            }
        }
    </style>
    @include('partials.theme-init')
</head>

<body
    class="bg-surface-light dark:bg-[#051111] font-body text-slate-800 dark:text-gray-100 antialiased transition-colors duration-300"
    x-data="{ modalOpen: false, activePerson: {} }">
    @include('partials.navbar')

    <main class="pt-32 pb-24 px-4 sm:px-6 relative min-h-screen">
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="text-center mb-12">
                <span
                    class="inline-block px-3 py-1 {{ $tab === 'ippnu' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700' }} rounded-full text-xs font-bold uppercase tracking-wider mb-4">Masa
                    Khidmat {{ $periode }}</span>
                <h2 class="font-display font-black text-3xl md:text-5xl text-gray-900 dark:text-white mb-6">Struktur
                    <span
                        class="{{ $tab === 'ippnu' ? 'text-amber-500' : 'text-emerald-600 dark:text-emerald-500' }}">{{ $orgName }}</span>
                </h2>

                <div class="flex justify-center gap-4 mt-8">
                    <a href="?tab=ipnu"
                        class="px-6 py-2 rounded-full font-bold text-sm transition-all {{ $tab !== 'ippnu' ? 'bg-emerald-800 text-white shadow-lg' : 'bg-white text-gray-500 border border-gray-200' }}">IPNU</a>
                    <a href="?tab=ippnu"
                        class="px-6 py-2 rounded-full font-bold text-sm transition-all {{ $tab === 'ippnu' ? 'bg-amber-600 text-white shadow-lg' : 'bg-white text-gray-500 border border-gray-200' }}">IPPNU</a>
                </div>
            </div>

            <div class="w-full overflow-x-auto pb-12 desktop-tree">
                <div class="min-w-[1200px] mx-auto px-8 pt-8">
                    @php
                        // LOGIKA DATA
                        $ketua = $pengurusTree->first(fn($n) => \Illuminate\Support\Str::contains($n->jabatan, 'Ketua') && !\Illuminate\Support\Str::contains($n->jabatan, 'Wakil'));
                        if (!$ketua)
                            $ketua = $pengurusTree->first();

                        if ($ketua) {
                            // Subordinates is everyone else
                            $subordinates = $pengurusTree->filter(fn($n) => $n->id !== $ketua->id);

                            // Helper Filters
                            $filterJob = fn($keyword, $exclude = 'Wakil') => $subordinates->filter(
                                fn($c) =>
                                \Illuminate\Support\Str::contains($c->jabatan, $keyword) &&
                                ($exclude ? !\Illuminate\Support\Str::contains($c->jabatan, $exclude) : true)
                            )->sortBy('urutan_tampil');

                            $mainSek = $filterJob('Sekretaris');
                            $wakilSek = $filterJob('Wakil Sekretaris', null);
                            $mainBen = $filterJob('Bendahara');
                            $wakilBen = $filterJob('Wakil Bendahara', null);
                            $waka = $filterJob('Wakil Ketua', null);

                            // Departemen / Lembaga logic based on 'Koordinator' or 'Direktur'
                            // We group by Department if available, or just list leaders
                            $usedIds = $mainSek->pluck('id')
                                ->merge($wakilSek->pluck('id'))
                                ->merge($mainBen->pluck('id'))
                                ->merge($wakilBen->pluck('id'))
                                ->merge($waka->pluck('id'))
                                ->push($ketua->id);

                            // Find Department/Lembaga Heads (Koordinator/Direktur/Komandan)
                            $deptHeads = $subordinates->whereNotIn('id', $usedIds)
                                ->filter(
                                    fn($c) =>
                                    \Illuminate\Support\Str::contains($c->jabatan, ['Koordinator', 'Direktur', 'Komandan', 'Ketua'])
                                    && !\Illuminate\Support\Str::contains($c->jabatan, ['Wakil'])
                                )
                                ->sortBy('urutan_tampil');

                            // Remaining are Members (Anggota)
                            $usedIds = $usedIds->merge($deptHeads->pluck('id'));
                            $members = $subordinates->whereNotIn('id', $usedIds);

                            // Mapping Members to their Department Heads for display
                            // We attach 'children' property dynamically for the view loop
                            $lembaga = $deptHeads->map(function ($head) use ($members) {
                                // Find members with same departemen_id
                                if ($head->departemen) {
                                    $head->children = $members->where('departemen', $head->departemen);
                                } else {
                                    $head->children = collect();
                                }
                                return $head;
                            });

                            // Split Layout Logic for Wakas
                            $wakaSplit = ceil($waka->count() / 2);
                            $wakaLeft = $waka->take($wakaSplit);
                            $wakaRight = $waka->skip($wakaSplit);
                        }
                    @endphp

                    @if($ketua)
                        <div class="flex flex-col items-center relative">

                            <div class="absolute top-20 bottom-0 left-1/2 -translate-x-1/2 w-0.5 bg-slate-300 z-0"></div>

                            <div class="relative z-20 mb-10 flex flex-col items-center">
                                @include('partials.card-item', ['node' => $ketua, 'tab' => $tab])
                                <div class="absolute top-full left-1/2 -translate-x-1/2 h-8 w-0.5 bg-slate-300"></div>
                            </div>

                            <div class="grid grid-cols-12 gap-8 w-full mb-20 relative z-10">
                                <div class="absolute top-10 left-[30%] right-[30%] h-0.5 bg-slate-300 -z-10"></div>

                                <div class="col-span-5 flex flex-col items-end pr-8 relative">
                                    <div class="flex gap-4 justify-end">
                                        @foreach($mainSek as $s)
                                            <div class="flex flex-col items-end">

                                                @include('partials.card-item', ['node' => $s, 'tab' => $tab])

                                                @if($wakilSek->count() > 0)
                                                    <div class="vertical-left-tree">
                                                        @foreach($wakilSek as $ws)
                                                            <div class="v-item">
                                                                @include('partials.card-item-small', ['node' => $ws, 'tab' => $tab])
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-span-2"></div>

                                <div class="col-span-5 flex flex-col items-start pl-8 relative">
                                    <div class="flex gap-4">
                                        @foreach($mainBen as $b)
                                            <div class="flex flex-col items-start">

                                                @include('partials.card-item', ['node' => $b, 'tab' => $tab])

                                                @if($wakilBen->count() > 0)
                                                    <div class="vertical-left-tree">
                                                        @foreach($wakilBen as $wb)
                                                            <div class="v-item">
                                                                @include('partials.card-item-small', ['node' => $wb, 'tab' => $tab])
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="w-full relative z-10 mb-16">
                                <div class="absolute top-0 left-10 right-10 h-0.5 bg-slate-300 -z-10"></div>

                                <div class="grid grid-cols-2 gap-12 pt-8">
                                    <div class="flex flex-wrap justify-center gap-8 border-r border-slate-200/50">
                                        @foreach($wakaLeft as $wk)
                                            <div class="flex flex-col items-center relative">
                                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 h-8 w-0.5 bg-slate-300">
                                                </div>

                                                @include('partials.card-item', ['node' => $wk, 'tab' => $tab])
                                                @if($wk->children->isNotEmpty())

                                                    <div class="vertical-left-tree mt-4 w-full">
                                                        @foreach($wk->children as $kord)
                                                            <div class="v-item">
                                                                <div
                                                                    class="absolute -top-8 left-1/2 -translate-x-1/2 h-8 w-0.5 bg-slate-300">
                                                                </div>
                                                                @include('partials.card-item-small', ['node' => $kord, 'tab' => $tab])

                                                                @if($kord->children->isNotEmpty())
                                                                    <div class="vertical-left-tree mt-2">
                                                                        @foreach($kord->children as $anggota)
                                                                            <div class="v-item">
                                                                                @include('partials.card-item-small', ['node' => $anggota, 'tab' => $tab])
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="flex flex-wrap justify-center gap-8">
                                        @foreach($wakaRight as $wk)
                                            <div class="flex flex-col items-center relative">
                                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 h-8 w-0.5 bg-slate-300">
                                                </div>

                                                @include('partials.card-item', ['node' => $wk, 'tab' => $tab])

                                                @if($wk->children->isNotEmpty())
                                                    <div class="vertical-left-tree mt-4 w-full">
                                                        @foreach($wk->children as $kord)
                                                            <div class="v-item">
                                                                <div
                                                                    class="absolute -top-8 left-1/2 -translate-x-1/2 h-8 w-0.5 bg-slate-300">
                                                                </div>
                                                                @include('partials.card-item-small', ['node' => $kord, 'tab' => $tab])

                                                                @if($kord->children->isNotEmpty())
                                                                    <div class="vertical-left-tree mt-2">
                                                                        @foreach($kord->children as $anggota)
                                                                            <div class="v-item">
                                                                                @include('partials.card-item-small', ['node' => $anggota, 'tab' => $tab])
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            @if($lembaga->count() > 0)
                                <div class="w-full relative z-10 pt-10">
                                    <div class="absolute top-10 left-20 right-20 h-0.5 bg-slate-300 -z-10"></div>

                                    <div class="flex justify-center flex-wrap gap-12 pt-8">
                                        @foreach($lembaga as $l)
                                            <div class="flex flex-col items-center relative">
                                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 h-16 w-0.5 bg-slate-300">
                                                </div>

                                                @include('partials.card-item', ['node' => $l, 'tab' => $tab])

                                                @if($l->children->isNotEmpty())
                                                    <div class="vertical-left-tree mt-4">
                                                        @foreach($l->children as $member)
                                                            <div class="v-item">
                                                                @include('partials.card-item-small', ['node' => $member, 'tab' => $tab])
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                        </div>
                    @endif
                </div>
            </div>

            <!-- Mobile list removed to use horizontally scrollable desktop tree -->

        </div>
    </main>

    <div x-show="modalOpen" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="fixed inset-0 bg-black/80 backdrop-blur-sm" @click="modalOpen = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div
                class="relative bg-white rounded-2xl shadow-2xl max-w-sm w-full overflow-hidden transform transition-all">
                <button @click="modalOpen = false"
                    class="absolute top-4 right-4 z-10 bg-black/50 text-white rounded-full p-1"><span
                        class="material-symbols-outlined text-lg">close</span></button>
                <div class="w-full h-80 bg-gray-100 relative">
                    <img :src="activePerson.image" class="w-full h-full object-cover">
                    <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <div class="inline-block px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider mb-2"
                            :class="activePerson.roleClass || 'bg-emerald-600'" x-text="activePerson.role"></div>
                        <h3 class="font-display font-black text-2xl leading-tight" x-text="activePerson.name"></h3>
                    </div>
                </div>
                <div class="p-6 bg-gray-50">
                    <p class="text-gray-600 italic text-sm" x-text="activePerson.quote || 'Belum ada quotes.'"></p>
                </div>
            </div>
        </div>
    </div>
    @include('partials.footer')
</body>

</html>