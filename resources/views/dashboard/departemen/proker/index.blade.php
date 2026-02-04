@extends('layouts.dashboard')

@section('title', 'Program Kerja Saya')

@section('content')
    <div class="space-y-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Program Kerja Saya</h1>
                <p class="text-slate-500 dark:text-slate-400">Daftar program kerja yang ditugaskan ke departemen Anda.</p>
            </div>
        </div>

        <!-- Active Programs (Cards) -->
        <div>
            <h2 class="font-bold text-lg text-slate-800 dark:text-white mb-4">Sedang Berjalan / Akan Datang</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($active_programs as $proker)
                    <div
                        class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm hover:shadow-md transition-all group">
                        <div class="flex justify-between items-start mb-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold 
                                    {{ $proker->status_pelaksanaan == 'Perencanaan' ? 'bg-slate-100 text-slate-600' : '' }}
                                    {{ $proker->status_pelaksanaan == 'Persiapan' ? 'bg-amber-100 text-amber-600' : '' }}
                                    {{ $proker->status_pelaksanaan == 'Pelaksanaan' ? 'bg-blue-100 text-blue-600' : '' }}
                                ">
                                {{ $proker->status_pelaksanaan }}
                            </span>
                            <span class="text-xs text-slate-400 font-mono">{{ $proker->tgl_pelaksanaan->format('d M') }}</span>
                        </div>
                        <h3
                            class="font-bold text-xl text-slate-800 dark:text-white mb-2 group-hover:text-blue-600 transition-colors">
                            {{ $proker->nama_proker }}
                        </h3>
                        <p class="text-sm text-slate-500 mb-6 line-clamp-2">
                            {{ $proker->deskripsi_kegiatan ?? 'Belum ada deskripsi.' }}
                        </p>
                        <a href="{{ route('dashboard.departemen.proker.show', $proker->id) }}"
                            class="w-full block text-center bg-slate-50 dark:bg-white/5 text-slate-700 dark:text-slate-300 font-bold py-3 rounded-xl hover:bg-slate-100 dark:hover:bg-white/10 transition-colors">
                            Kelola Program
                        </a>
                    </div>
                @empty
                    <div
                        class="col-span-3 text-center py-12 bg-slate-50 dark:bg-white/5 rounded-2xl border border-dashed border-slate-200 dark:border-white/10">
                        <p class="text-slate-500">Tidak ada program aktif saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Completed Programs (Table) -->
        @if($completed_programs->count() > 0)
            <div>
                <h2 class="font-bold text-lg text-slate-800 dark:text-white mb-4">Riwayat Program</h2>
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-100 dark:border-white/5 overflow-hidden">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-white/5 border-b border-slate-100 dark:border-white/5">
                                <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300">Nama Program</th>
                                <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300">Tanggal</th>
                                <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300">LPJ</th>
                                <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                            @foreach($completed_programs as $proker)
                                <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4 font-bold text-slate-800 dark:text-white">{{ $proker->nama_proker }}</td>
                                    <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                                        {{ $proker->tgl_pelaksanaan->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-3 py-1 bg-emerald-100 text-emerald-600 rounded-full text-xs font-bold">Verified</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('dashboard.departemen.proker.show', $proker->id) }}"
                                            class="text-blue-600 hover:underline">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="px-6 py-4 border-t border-slate-100 dark:border-white/5">
                        {{ $completed_programs->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection