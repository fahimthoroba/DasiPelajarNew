@extends('layouts.dashboard')

@section('title', 'Manajemen Program Kerja')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Program Kerja</h1>
                <p class="text-slate-500 dark:text-slate-400">Kelola program kerja per departemen.</p>
            </div>
            <a href="{{ route('dashboard.sekretariat.departemen.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-blue-700 transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined">add</span>
                Catat Program
            </a>
        </div>

        <!-- Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-100 dark:border-white/5 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-white/5 border-b border-slate-100 dark:border-white/5">
                            <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300">Nama Program</th>
                            <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300">Departemen</th>
                            <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300">Tanggal</th>
                            <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300">Pelaksana</th>
                            <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                        @forelse($program_kerja as $proker)
                            <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-800 dark:text-white">
                                    {{ $proker->nama_proker }}
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-3 py-1 bg-blue-50 dark:bg-blue-900/20 text-blue-600 rounded-lg text-xs font-bold">
                                        {{ $proker->departemen->nama_departemen ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                                    {{ $proker->tgl_pelaksanaan->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                                    {{ $proker->penanggung_jawab ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="#" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                                            <span class="material-symbols-outlined text-lg">edit</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500">Belum ada program kerja tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 dark:border-white/5">
                {{ $program_kerja->links() }}
            </div>
        </div>
    </div>
@endsection