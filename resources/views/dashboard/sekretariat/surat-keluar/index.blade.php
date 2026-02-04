@extends('layouts.dashboard')

@section('title', 'Surat Keluar')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Surat Keluar</h1>
                <p class="text-slate-500 dark:text-slate-400">Arsip surat yang dikeluarkan organisasi.</p>
            </div>
            <a href="{{ route('dashboard.sekretariat.surat-keluar.create') }}"
                class="bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-emerald-700 transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined">add</span>
                Buat Surat
            </a>
        </div>

        <!-- Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-100 dark:border-white/5 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-white/5 border-b border-slate-100 dark:border-white/5">
                            <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300">No. Surat</th>
                            <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300">Tujuan</th>
                            <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300">Perihal</th>
                            <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300">Tanggal</th>
                            <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                        @forelse($surat_keluar as $surat)
                            <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-400 font-mono">{{ $surat->no_surat }}</td>
                                <td class="px-6 py-4 text-slate-800 dark:text-white font-medium">{{ $surat->tujuan }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-400">{{ Str::limit($surat->perihal, 40) }}
                                </td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                                    {{ $surat->tgl_surat->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('dashboard.sekretariat.surat-keluar.edit', $surat->id) }}"
                                            class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                                            <span class="material-symbols-outlined text-lg">edit</span>
                                        </a>
                                        <form action="{{ route('dashboard.sekretariat.surat-keluar.destroy', $surat->id) }}"
                                            method="POST" onsubmit="return confirm('Hapus surat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                <span class="material-symbols-outlined text-lg">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                    <div class="flex flex-col items-center gap-2">
                                        <span class="material-symbols-outlined text-4xl opacity-50">outbox</span>
                                        <p>Belum ada surat keluar.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 dark:border-white/5">
                {{ $surat_keluar->links() }}
            </div>
        </div>
    </div>
@endsection