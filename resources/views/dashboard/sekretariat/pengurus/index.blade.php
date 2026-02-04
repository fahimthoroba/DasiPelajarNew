@extends('layouts.dashboard')

@section('title', 'Manajemen Pengurus')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Pengurus Harian (PC)</h1>
            <a href="{{ route('dashboard.sekretariat.pengurus.create') }}"
                class="bg-emerald-600 text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-emerald-700 flex items-center gap-2">
                <span class="material-symbols-outlined">add</span> Tambah Pengurus
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 dark:bg-white/5 text-slate-500 font-bold uppercase text-xs">
                        <tr>
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">Nama & Jabatan</th>
                            <th class="px-6 py-4">Tingkatan</th>
                            <th class="px-6 py-4">Departemen</th>
                            <th class="px-6 py-4">SK</th>
                            <th class="px-6 py-4 text-center">Urutan</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                        @forelse($pengurus as $index => $p)
                            <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($p->kader?->foto_path)
                                            <img src="{{ Storage::url($p->kader->foto_path) }}" class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">
                                                {{ substr($p->kader?->nama_lengkap ?? 'X', 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-bold text-slate-800 dark:text-white">{{ $p->kader?->nama_lengkap ?? 'Kader Terhapus' }}</div>
                                            <div class="text-xs text-slate-500">{{ $p->jabatan }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-700 dark:text-slate-300">{{ $p->nama_tingkatan ?? '-' }}</div>
                                    <div class="text-xs text-slate-500 uppercase">{{ $p->tingkatan }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $p->departemenData->nama_departemen ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($p->sk)
                                        <span class="text-xs bg-blue-50 text-blue-600 px-2 py-1 rounded border border-blue-100">
                                            {{ $p->sk->nomor_sk }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-mono bg-slate-100 px-2 py-1 rounded text-xs">{{ $p->urutan_tampil }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('dashboard.sekretariat.pengurus.destroy', $p->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus pengurus ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-600 p-1">
                                            <span class="material-symbols-outlined text-lg">delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                    Belum ada data pengurus.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
