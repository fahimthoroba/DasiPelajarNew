<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agenda & Program Kerja - PC IPNU IPPNU Kediri</title>
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
                        emerald: { 900: '#022C22', 800: '#064E3B', 400: '#34D399', },
                        amber: { 900: '#78350F', 700: '#B45309', 400: '#FBBF24', },
                        surface: { light: '#F8F8F8', dark: '#121212', }
                    },
                    fontFamily: { display: ['Outfit', 'sans-serif'], body: ['Inter', 'sans-serif'], }
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

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span class="text-emerald-300 font-bold tracking-widest uppercase text-sm mb-4 block">Jadwal &
                Laporan</span>
            <h1 class="font-display font-black text-4xl md:text-6xl text-white mb-6">Agenda Kegiatan</h1>
            <p class="text-xl text-emerald-100 max-w-2xl mx-auto font-light leading-relaxed">
                Jadwal lengkap kegiatan dan program kerja PC IPNU IPPNU Kabupaten Kediri.
            </p>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="py-20 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div
                class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-white/5 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead
                            class="bg-gray-50 dark:bg-gray-900/50 text-gray-600 dark:text-gray-400 uppercase tracking-wider font-bold border-b border-gray-100 dark:border-white/5">
                            <tr>
                                <th class="p-6">Nama Kegiatan</th>
                                <th class="p-6">Tanggal</th>
                                <th class="p-6">Tempat</th>
                                <th class="p-6">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                            @forelse($agendas as $agenda)
                                @php
                                    $tgl = \Carbon\Carbon::parse($agenda->tgl_pelaksanaan)->startOfDay();
                                    $now = now()->startOfDay();
                                    $statusClass = '';
                                    $statusLabel = '';

                                    if ($agenda->status_lpj === 'Terverifikasi') {
                                        $statusClass = 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400';
                                        $statusLabel = 'Terlaksana';
                                    } elseif ($tgl->equalTo($now)) {
                                        $statusClass = 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 animate-pulse';
                                        $statusLabel = 'Sedang Dilaksanakan';
                                    } elseif ($tgl->isPast()) {
                                        $statusClass = 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400';
                                        $statusLabel = 'Belum Terlaksana / Menunggu LPJ';
                                    } else {
                                        $statusClass = 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400';
                                        $statusLabel = 'Segera';
                                    }
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-6 font-bold text-gray-900 dark:text-white text-base">
                                        {{ $agenda->nama_proker }}
                                    </td>
                                    <td class="p-6 whitespace-nowrap text-gray-600 dark:text-gray-400">
                                        {{ $tgl->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="p-6 text-gray-600 dark:text-gray-400">
                                        {{ $agenda->lokasi ?? '-' }}
                                    </td>
                                    <td class="p-6">
                                        <span
                                            class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-12 text-center text-gray-500 italic">
                                        Belum ada data agenda.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

    @include('partials.footer')

</body>

</html>