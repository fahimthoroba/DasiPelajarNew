@extends('layouts.dashboard')

@section('title', 'Admin - Analisa Strategis & Data PAC')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div>
            <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Analisa Strategis & Data PAC</h1>
            <p class="text-gray-500 text-sm mt-1">Evaluasi kepadatan program, analisis kesenjangan, dan monitoring PAC.</p>
        </div>

        <!-- 1. Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Program -->
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg shadow-indigo-500/20">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                        <span class="material-symbols-outlined text-2xl">event_available</span>
                    </div>
                    <div>
                        <p class="text-indigo-100 text-sm font-medium">Total Program Terealisasi</p>
                        <h3 class="text-3xl font-bold">{{ $totalProgram }}</h3>
                    </div>
                </div>
            </div>

            <!-- Bulan Ini -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-white/5">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                        <span class="material-symbols-outlined text-2xl">calendar_month</span>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Kegiatan Bulan Ini</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $programBulanIni }}</h3>
                    </div>
                </div>
            </div>

            <!-- Program Terpadat (Placeholder logic for now) -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-white/5">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                        <span class="material-symbols-outlined text-2xl">timelapse</span>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Tahun</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $year }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. SCHEDULER / DENSITY MAP (Heatmap) -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-500">grid_view</span>
                        Peta Kepadatan Program ({{ $year }})
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">Identifikasi minggu kosong untuk menjadwalkan program PC.</p>
                </div>
                
                <div class="flex items-center gap-2 text-xs text-gray-500 border p-2 rounded-lg dark:border-gray-700">
                    <span>Kosong</span>
                    <div class="flex gap-1 items-center">
                        <div class="w-3 h-3 rounded-sm bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600" title="0 Program"></div>
                        <div class="w-3 h-3 rounded-sm bg-emerald-200" title="1 Program"></div>
                        <div class="w-3 h-3 rounded-sm bg-emerald-400" title="2 Program"></div>
                        <div class="w-3 h-3 rounded-sm bg-emerald-600" title="3-4 Programs"></div>
                        <div class="w-3 h-3 rounded-sm bg-rose-500" title="5+ Programs (Sangat Padat)"></div>
                    </div>
                    <span>Padat</span>
                </div>
            </div>

            <div class="flex items-start overflow-x-auto pb-2">
                <!-- Day Labels -->
                <div class="flex flex-col gap-1 mr-2 mt-[18px]">
                    <div class="h-3 w-4 text-[10px] text-gray-400 leading-3">M</div>
                    <div class="h-3 w-4 text-[10px] text-gray-400 leading-3">S</div>
                    <div class="h-3 w-4 text-[10px] text-gray-400 leading-3">S</div>
                    <div class="h-3 w-4 text-[10px] text-gray-400 leading-3">R</div>
                    <div class="h-3 w-4 text-[10px] text-gray-400 leading-3">K</div>
                    <div class="h-3 w-4 text-[10px] text-gray-400 leading-3">J</div>
                    <div class="h-3 w-4 text-[10px] text-gray-400 leading-3">S</div>
                </div>

                <!-- Grid -->
                <div class="flex-1">
                    <div class="flex gap-4 min-w-max">
                        @foreach($calendarData as $month)
                            <div class="flex flex-col gap-2">
                                <div class="text-[10px] font-bold text-gray-500 uppercase tracking-wider text-center bg-gray-50 dark:bg-gray-700/50 rounded py-0.5">
                                    {{ $month['name'] }}
                                </div>
                                <!-- Month Grid -->
                                <div class="flex gap-1">
                                    @foreach($month['weeks'] as $week)
                                        <div class="flex flex-col gap-1">
                                            @foreach($week as $day)
                                                @if($day['isValid'])
                                                    <a href="{{ route('dashboard.admin.analisa.date', $day['raw_date']) }}" 
                                                       class="w-3 h-3 rounded-sm cursor-pointer transition-all hover:scale-150 relative group block
                                                        {{ $day['level'] === 0 ? 'bg-gray-100 dark:bg-gray-700' :
                                                        ($day['level'] === 1 ? 'bg-emerald-200' :
                                                        ($day['level'] === 2 ? 'bg-emerald-400' :
                                                        ($day['level'] === 3 ? 'bg-emerald-600' : 'bg-rose-500 shadow-sm shadow-rose-500/50'))) }}"
                                                    >
                                                        <!-- Tooltip -->
                                                        <div class="pointer-events-none absolute bottom-full left-1/2 -translate-x-1/2 mb-2 hidden group-hover:block z-[9999] whitespace-nowrap">
                                                            <div class="bg-gray-900 text-white text-[10px] py-1 px-2 rounded shadow-lg relative">
                                                                <span class="font-bold block">{{ $day['date'] }}</span>
                                                                {{ $day['count'] }} Kegiatan
                                                                <!-- Triangle -->
                                                                <div class="w-2 h-2 bg-gray-900 absolute top-full left-1/2 -translate-x-1/2 -mt-1 rotate-45"></div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @else
                                                    <div class="w-3 h-3 bg-transparent"></div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. GAP ANALYSIS (Charts) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- By Department -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5">
                <h3 class="font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-500">pie_chart</span>
                    Gap Analysis: Distribusi per Departemen
                </h3>
                <div class="relative h-64">
                    <canvas id="deptChart"></canvas>
                </div>
                <p class="text-xs text-gray-500 mt-4 text-center">Menunjukkan departemen mana yang paling aktif dan paling pasif.</p>
            </div>

            <!-- By Category -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5">
                <h3 class="font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-pink-500">donut_small</span>
                    Gap Analysis: Jenis Kegiatan
                </h3>
                <div class="relative h-64">
                    <canvas id="catChart"></canvas>
                </div>
                 <p class="text-xs text-gray-500 mt-4 text-center">Proporsi jenis kegiatan yang telah dilaksanakan.</p>
            </div>
        </div>

        <!-- 4. PAC PERFORMANCE TABLE -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                <h3 class="font-bold text-gray-900 dark:text-white text-lg">Monitoring Performa PAC</h3>
                <div class="text-sm text-gray-500">
                    Total {{ $allPacs->count() }} PAC Terdaftar
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 font-medium border-b border-gray-100 dark:border-gray-700">
                        <tr>
                            <th class="px-6 py-4">Peringkat</th>
                            <th class="px-6 py-4">Nama PAC</th>
                            <th class="px-6 py-4">Zona</th>
                            <th class="px-6 py-4 text-center">Total Proker</th>
                            <th class="px-6 py-4 text-right">Aktivitas Terakhir</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($allPacs as $index => $pac)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full font-bold
                                    {{ $index < 3 ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-600' }}">
                                    #{{ $index + 1 }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $pac->name }}
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $pac->zona_wilayah ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 font-bold border border-emerald-100">
                                    {{ $pac->proker_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right text-gray-500">
                                {{ $pac->last_activity }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('dashboard.admin.analisa.detail', $pac->id) }}" 
                                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors shadow-sm">
                                    <span class="material-symbols-outlined text-[16px]">analytics</span>
                                    Analisa Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // Data Arrays (IDs for clicking)
            const deptIds = @json($departemenIds);
            const catIds = @json($kategoriIds);

            // 1. Dept Chart
            const ctxDept = document.getElementById('deptChart').getContext('2d');
            new Chart(ctxDept, {
                type: 'bar',
                data: {
                    labels: @json($departemenLabels),
                    datasets: [{
                        label: 'Jumlah Program',
                        data: @json($departemenData),
                        backgroundColor: '#3b82f6', // blue-500
                        borderRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y', // Horizontal Bar
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: { beginAtZero: true }
                    },
                    onClick: (e, activeEls) => {
                        if (activeEls.length > 0) {
                            const index = activeEls[0].index;
                            const id = deptIds[index];
                            if(id) window.location.href = "{{ route('dashboard.admin.analisa.index') }}/departemen/" + id;
                        }
                    },
                    onHover: (event, chartElement) => {
                        event.native.target.style.cursor = chartElement[0] ? 'pointer' : 'default';
                    }
                }
            });

            // 2. Category Chart
            const ctxCat = document.getElementById('catChart').getContext('2d');
            new Chart(ctxCat, {
                type: 'doughnut',
                data: {
                    labels: @json($kategoriLabels),
                    datasets: [{
                        data: @json($kategoriData),
                        backgroundColor: [
                            '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#6366f1'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right' }
                    },
                    cutout: '70%',
                    onClick: (e, activeEls) => {
                        if (activeEls.length > 0) {
                            const index = activeEls[0].index;
                            const id = catIds[index];
                            if(id) window.location.href = "{{ route('dashboard.admin.analisa.index') }}/kategori/" + id;
                        }
                    },
                    onHover: (event, chartElement) => {
                        event.native.target.style.cursor = chartElement[0] ? 'pointer' : 'default';
                    }
                }
            });
        });
    </script>
@endsection

