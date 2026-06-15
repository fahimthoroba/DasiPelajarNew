@extends('layouts.dashboard')

@section('title', 'Detail & Verifikasi LPJ')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard.sekretariat.proker.index') }}"
                class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-emerald-600 hover:border-emerald-500 hover:shadow-sm transition-all">
                <span class="material-symbols-outlined text-xl">arrow_back</span>
            </a>
            <div>
                <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">{{ $proker->nama_proker }}</h1>
                <p class="text-slate-500 text-sm">Pelaksana: {{ $proker->departemen->nama_departemen ?? '-' }}</p>
            </div>
        </div>

        <!-- Stats summary -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm">
                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Status Proker</p>
                <p class="font-bold text-lg text-slate-800 dark:text-white">{{ $proker->status_pelaksanaan }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm">
                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Tahap Saat Ini</p>
                <p class="font-bold text-lg text-emerald-600">Step {{ $proker->current_step }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm">
                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Tanggal</p>
                <p class="font-bold text-lg text-slate-800 dark:text-white">{{ $proker->tgl_pelaksanaan->format('d M Y') }}
                </p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm">
                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Panitia / Sesi</p>
                <p class="font-bold text-lg text-slate-800 dark:text-white">{{ $proker->kepanitiaans->count() }} Org /
                    {{ $proker->absensis->count() }} Sesi</p>
            </div>
        </div>

        @if($proker->current_step == 6)
            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-amber-200 shadow-sm overflow-hidden">
                <div
                    class="bg-amber-50 border-b border-amber-100 p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h3 class="font-bold text-amber-800 text-lg flex items-center gap-2">
                            <span class="material-symbols-outlined">pending_actions</span> Verifikasi LPJ
                        </h3>
                        <p class="text-amber-700 text-sm mt-1">Laporan Pertanggung Jawaban butuh review Anda.</p>
                    </div>

                    <a href="{{ Storage::url($proker->path_lpj) }}" target="_blank"
                        class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-700 px-5 py-2.5 rounded-xl text-sm font-bold shadow-sm border border-slate-200 transition-colors">
                        <span class="material-symbols-outlined text-sm">download</span> Unduh Dokumen LPJ
                    </a>
                </div>
                <div class="p-6">
                    <form action="{{ route('dashboard.sekretariat.proker.verifikasi', $proker->id) }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Persetujuan
                                LPJ</label>
                            <div class="flex flex-col gap-3">
                                <label
                                    class="flex items-center p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-emerald-50 hover:border-emerald-200 transition-colors">
                                    <input type="radio" name="action" value="terima"
                                        class="w-4 h-4 text-emerald-600 outline-none" required x-data @change="showNote = false"
                                        id="radioTerima">
                                    <div class="ml-3 flex-1">
                                        <span class="block text-sm font-bold text-emerald-700">Terima LPJ</span>
                                        <span class="block text-xs text-slate-500">Program Kerja dinyatakan selesai
                                            seluruhnya.</span>
                                    </div>
                                    <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                                </label>
                                <label
                                    class="flex items-center p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-red-50 hover:border-red-200 transition-colors">
                                    <input type="radio" name="action" value="tolak" class="w-4 h-4 text-red-600 outline-none"
                                        required x-data @change="showNote = true" id="radioTolak">
                                    <div class="ml-3 flex-1">
                                        <span class="block text-sm font-bold text-red-700">Tolak dengan Revisi</span>
                                        <span class="block text-xs text-slate-500">Kembalikan ke Departemen agar LPJ
                                            diperbaiki.</span>
                                    </div>
                                    <span class="material-symbols-outlined text-red-600">cancel</span>
                                </label>
                            </div>
                        </div>

                        <!-- Catatan Penolakan (AlpineJS) -->
                        <div x-data="{ showNote: false }" x-init="
                            document.getElementById('radioTolak').addEventListener('change', () => showNote = true);
                            document.getElementById('radioTerima').addEventListener('change', () => showNote = false);
                        ">
                            <div x-show="showNote" x-collapse class="mb-6">
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Catatan Revisi
                                    <span class="text-red-500">*</span></label>
                                <textarea name="lpj_catatan" rows="3"
                                    placeholder="Sebutkan bagian mana saja yang perlu direvisi oleh departemen pelaksana..."
                                    class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl p-4 text-sm focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all resize-none"></textarea>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                            <button type="submit"
                                class="px-8 py-3 rounded-xl text-sm font-bold text-white bg-slate-800 hover:bg-slate-900 shadow-sm transition-all flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">task_alt</span> Simpan Keputusan Verifikasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @elseif($proker->status_pelaksanaan == 'Selesai')
            <div
                class="bg-emerald-50 text-emerald-600 p-6 rounded-3xl text-sm font-bold border border-emerald-100 text-center flex flex-col items-center">
                <span class="material-symbols-outlined text-4xl mb-2">verified</span>
                <p class="text-lg">Program Kerja Telah Selesai</p>
                <p class="font-normal text-emerald-600 mt-1">Penyelesaian telah diverifikasi oleh BPH Kesekretariatan.</p>

                @if($proker->path_lpj)
                    <a href="{{ Storage::url($proker->path_lpj) }}" target="_blank"
                        class="mt-4 inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-sm transition-colors">
                        <span class="material-symbols-outlined text-sm">download</span> Unduh Arsip LPJ Terakhir
                    </a>
                @endif
            </div>
        @else
            <div
                class="bg-blue-50 text-blue-600 p-6 rounded-3xl text-sm font-bold border border-blue-100 text-center flex flex-col items-center">
                <span class="material-symbols-outlined text-4xl mb-2">published_with_changes</span>
                <p class="text-lg">Program Sedang Berjalan</p>
                <p class="font-normal text-blue-600 mt-1">Menunggu departemen pelaksana mencapai Tahap 5 (Upload LPJ).</p>
            </div>
        @endif
    </div>
@endsection