@extends('layouts.dashboard')

@section('title', 'Surat Keluar')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Buku Agenda Surat Keluar</h1>
                <p class="text-slate-500 dark:text-slate-400">
                    @if(in_array(auth()->user()->role, ['admin', 'sekretaris']))
                        Buku agenda utama + monitoring semua buku agenda kepanitiaan.
                    @else
                        Buku agenda kepanitiaan milik departemen Anda.
                    @endif
                </p>
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
                            <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300">Status Arsip</th>
                            <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300">Status Surat</th>
                            <th class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                        @forelse($surat_keluar as $surat)
                            <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors {{ $surat->status === 'dibatalkan' ? 'opacity-60' : '' }}">
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-400 font-mono whitespace-pre-line">{{ $surat->no_surat }}</td>
                                <td class="px-6 py-4 text-slate-800 dark:text-white font-medium">{{ $surat->tujuan }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-400">{{ Str::limit($surat->perihal, 40) }}
                                </td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                                    {{ $surat->tgl_surat->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($surat->status_arsip === 'lengkap')
                                    <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700">Lengkap</span>
                                    @else
                                    <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-amber-50 text-amber-700">Belum Lengkap</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($surat->status === 'dibatalkan')
                                    <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-red-50 text-red-700">Dibatalkan</span>
                                    @else
                                    <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">Aktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2" x-data="{ showBatalkan: false }">
                                        @if($surat->status !== 'dibatalkan' && in_array($surat->id, $writableIds))
                                        <a href="{{ route('dashboard.sekretariat.surat-keluar.edit', $surat->id) }}"
                                            class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                                            <span class="material-symbols-outlined text-lg">edit</span>
                                        </a>
                                        <button type="button" @click="showBatalkan = true"
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                            <span class="material-symbols-outlined text-lg">cancel</span>
                                        </button>

                                        <div x-show="showBatalkan" x-cloak
                                             class="fixed inset-0 flex items-center justify-center z-50 px-4"
                                             style="background: rgba(0,0,0,0.55);"
                                             @click.self="showBatalkan = false">
                                            <div class="w-full max-w-sm rounded-2xl p-6 shadow-2xl bg-white dark:bg-gray-800">
                                                <h3 class="font-bold text-base mb-2">Batalkan Surat?</h3>
                                                <p class="text-xs text-slate-500 mb-4">Nomor akan dipakai ulang di surat berikutnya. Surat ini tetap tersimpan untuk audit.</p>
                                                <form action="{{ route('dashboard.sekretariat.surat-keluar.batalkan', $surat->id) }}" method="POST">
                                                    @csrf
                                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Alasan</label>
                                                    <textarea name="alasan" required rows="2"
                                                        class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-3 py-2 text-sm mb-4"></textarea>
                                                    <div class="flex gap-3">
                                                        <button type="button" @click="showBatalkan = false"
                                                            class="flex-1 py-2 rounded-xl text-sm font-bold bg-slate-100 text-slate-600">Batal</button>
                                                        <button type="submit"
                                                            class="flex-1 py-2 rounded-xl text-sm font-bold bg-red-600 text-white">Ya, Batalkan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        @elseif($surat->status !== 'dibatalkan')
                                        <span class="text-xs text-slate-400 italic">Monitoring</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-slate-500">
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