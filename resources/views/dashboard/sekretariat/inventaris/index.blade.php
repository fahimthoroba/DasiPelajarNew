@extends('layouts.dashboard')

@section('title', 'Data Inventaris')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Data Inventaris</h1>
                <p class="text-slate-500 dark:text-slate-400">Aset dan barang milik organisasi.</p>
            </div>
            <a href="{{ route('dashboard.sekretariat.inventaris.create') }}"
                class="bg-amber-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-amber-700 transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined">add</span>
                Catat Barang
            </a>
        </div>

        <!-- Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-100 dark:border-white/5 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-white/5 border-b border-slate-100 dark:border-white/5">
                            <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300">Nama Barang</th>
                            <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300">Kode</th>
                            <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300">Kondisi</th>
                            <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300">Lokasi</th>
                            <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                        @forelse($inventaris as $barang)
                            <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4">
                                    <span
                                        class="font-bold text-slate-800 dark:text-white block">{{ $barang->nama_barang }}</span>
                                    <span class="text-xs text-slate-500">{{ $barang->tgl_pengadaan->format('Y') }}</span>
                                </td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-400 font-mono">{{ $barang->kode_barang }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($barang->kondisi == 'baik')
                                        <span
                                            class="px-3 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 rounded-full text-xs font-bold">Baik</span>
                                    @elseif($barang->kondisi == 'rusak_ringan')
                                        <span
                                            class="px-3 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-600 rounded-full text-xs font-bold">Rusak
                                            Ringan</span>
                                    @else
                                        <span
                                            class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-600 rounded-full text-xs font-bold">Rusak
                                            Berat</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-400">{{ $barang->lokasi }}</td>
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
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500">Belum ada data inventaris.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 dark:border-white/5">
                {{ $inventaris->links() }}
            </div>
        </div>
    </div>
@endsection