@extends('layouts.dashboard')

@section('title', 'Buat Surat Keluar')

@section('content')
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8 items-center justify-between">
            <a href="{{ route('dashboard.sekretariat.surat-keluar.index') }}"
                class="text-emerald-600 font-bold text-sm inline-flex items-center gap-1 hover:text-emerald-700 mb-2">
                <span class="material-symbols-outlined text-lg">arrow_back</span> Kembali
            </a>
            <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Buat Surat Keluar</h1>
            <p class="text-slate-500 dark:text-slate-400">Catat surat yang akan dikirimkan.</p>
        </div>

        <form action="{{ route('dashboard.sekretariat.surat-keluar.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf

            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm space-y-5">

                <!-- No Surat -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nomor Surat</label>
                    <input type="text" name="no_surat" required
                        class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 dark:text-white"
                        placeholder="Contoh: 001/PC/IPNU/XII/2025">
                </div>

                <!-- Tujuan -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tujuan Surat</label>
                    <input type="text" name="tujuan" required
                        class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 dark:text-white"
                        placeholder="Contoh: PAC IPNU IPPNU Pare">
                </div>

                <!-- Perihal -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Perihal</label>
                    <input type="text" name="perihal" required
                        class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 dark:text-white"
                        placeholder="Contoh: Undangan Pelantikan">
                </div>

                <!-- Tgl Surat -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal
                        Surat</label>
                    <input type="date" name="tgl_surat" required value="{{ date('Y-m-d') }}"
                        class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-slate-600 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                </div>

                <!-- File Arsip -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Arsip Surat
                        (Opsional)</label>
                    <input type="file" name="file_arsip" accept=".pdf,.doc,.docx"
                        class="w-full block text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                    <p class="text-xs text-slate-400 mt-1">Simpan salinan surat untuk arsip (PDF/Word).</p>
                </div>

                <input type="hidden" name="pembuat_id" value="{{ auth()->id() }}">
            </div>

            <button type="submit"
                class="w-full bg-emerald-600 text-white font-bold py-4 rounded-xl hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-900/20">
                Simpan Data
            </button>
        </form>
    </div>
@endsection