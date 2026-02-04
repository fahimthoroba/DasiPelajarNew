@extends('layouts.dashboard')

@section('title', 'Data Kader')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Data Kader</h1>
                <p class="text-slate-500 dark:text-slate-400">Database anggota dan kader organisasi.</p>
            </div>
            <a href="{{ route('dashboard.sekretariat.kader.create') }}"
                class="bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-emerald-700 transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined">add</span>
                Tambah Kader
            </a>
        </div>

        <!-- Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-100 dark:border-white/5 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-white/5 border-b border-slate-100 dark:border-white/5">
                            <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300">Nama Lengkap</th>
                            <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300">NIK Identity</th>
                            <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300">Domisili</th>
                            <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300">Kontak</th>
                            <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                        @forelse($kader as $member)
                            <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-700 overflow-hidden">
                                            @if($member->foto_path)
                                                <img src="{{ asset('storage/' . $member->foto_path) }}"
                                                    alt="{{ $member->nama_lengkap }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate-400">
                                                    <span class="material-symbols-outlined text-lg">person</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <span
                                                class="font-bold text-slate-800 dark:text-white block">{{ $member->nama_lengkap }}</span>
                                            <span
                                                class="text-xs text-slate-500">{{ $member->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-400 font-mono">{{ $member->nik }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                                    {{ $member->desa }}, {{ $member->kecamatan }}
                                </td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                                    {{ $member->no_hp }}
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
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500">Belum ada data kader.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 dark:border-white/5">
                {{ $kader->links() }}
            </div>
        </div>
    </div>
@endsection