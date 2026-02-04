@extends('layouts.dashboard')

@section('title', 'Analisa Detail PAC - ' . $pac->name)

@section('content')
    <div class="space-y-8">
        <!-- Breadcrumb & Header -->
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                <a href="{{ route('dashboard.admin.analisa.index') }}" class="hover:text-emerald-600">Analisa Data</a>
                <span class="material-symbols-outlined text-xs">chevron_right</span>
                <span>Detail PAC</span>
            </div>
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">{{ $pac->name }}</h1>
                    <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[18px]">location_on</span>
                            {{ $pac->zona_wilayah ?? 'Zona Belum Diisi' }}
                        </span>
                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[18px]">mail</span>
                            {{ $pac->email }}
                        </span>
                    </div>
                </div>
                <!-- Action Buttons if needed -->
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-100 dark:border-white/5 shadow-sm">
                <p class="text-xs font-medium text-gray-500 uppercase">Total Program</p>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalProker }}</span>
                    <span class="text-sm text-emerald-600">Kegiatan</span>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-100 dark:border-white/5 shadow-sm">
                <p class="text-xs font-medium text-gray-500 uppercase">Masa Khidmat</p>
                <div class="mt-2">
                    <span class="text-lg font-bold text-gray-900 dark:text-white">
                        {{ \Carbon\Carbon::parse($pac->masa_khidmat_mulai)->format('Y') }} - 
                        {{ \Carbon\Carbon::parse($pac->masa_khidmat_selesai)->format('Y') }}
                    </span>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-100 dark:border-white/5 shadow-sm">
                <p class="text-xs font-medium text-gray-500 uppercase">Alamat Sekretariat</p>
                <div class="mt-2">
                    <span class="text-sm font-medium text-gray-900 dark:text-white line-clamp-2">
                        {{ $pac->alamat_sekretariat ?? '-' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Monthly Activity -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-white/5 shadow-sm">
                <h3 class="font-bold text-gray-900 dark:text-white mb-6">Tren Keaktifan Bulanan</h3>
                <div class="h-64 relative">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>

            <!-- Category Distribution -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-white/5 shadow-sm">
                <h3 class="font-bold text-gray-900 dark:text-white mb-6">Fokus Program Kerja</h3>
                <div class="h-64 relative flex items-center justify-center">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Activity Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-white/5 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                <h3 class="font-bold text-gray-900 dark:text-white">10 Program Terakhir</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 font-medium">
                        <tr>
                            <th class="px-6 py-4">Nama Program</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Departemen</th>
                            <th class="px-6 py-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($recentProkers as $p)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $p->nama_lokal }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $p->tgl_mulai->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded text-xs border border-gray-200 bg-gray-50">
                                    {{ $p->kategori->nama_kategori ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $p->departemen->nama_departemen ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-1 rounded-full text-xs font-bold
                                    {{ $p->status == 'Terlaksana' ? 'bg-emerald-100 text-emerald-700' : 
                                      ($p->status == 'Belum Terlaksana' ? 'bg-gray-100 text-gray-700' : 'bg-red-100 text-red-700') }}">
                                    {{ $p->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada data program kerja.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Monthly Chart
            new Chart(document.getElementById('monthlyChart'), {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        label: 'Jumlah Kegiatan',
                        data: @json($chartData),
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                }
            });

            // Category Chart
            new Chart(document.getElementById('categoryChart'), {
                type: 'pie',
                data: {
                    labels: @json($kategoriLabels),
                    datasets: [{
                        data: @json($kategoriData),
                        backgroundColor: ['#34d399', '#60a5fa', '#f472b6', '#a78bfa', '#fbbf24']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        });
    </script>
@endsection
