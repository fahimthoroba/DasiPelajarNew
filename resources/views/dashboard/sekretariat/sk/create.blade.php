@extends('layouts.dashboard')

@section('title', 'Input SK Baru')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard.sekretariat.sk.index') }}"
                class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-white/10 transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Input SK Baru</h1>
        </div>

        <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm">
            <form action="{{ route('dashboard.sekretariat.sk.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf

                <!-- Nomor SK -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Nomor Surat Keputusan
                        (SK)</label>
                    <input type="text" name="nomor_sk" required placeholder="Contoh: 05/PC/SK/XX/2025"
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 font-mono">
                </div>

                <!-- Judul -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Perihal / Judul
                        SK</label>
                    <input type="text" name="judul_sk" required placeholder="Contoh: Pengesahan Susunan Pengurus Ranting..."
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5">
                </div>

                <!-- Masa Berlaku -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Tanggal Mulai</label>
                        <input type="date" name="tgl_berlaku" required
                            class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Tanggal
                            Selesai</label>
                        <input type="date" name="tgl_selesai" required
                            class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5">
                    </div>
                </div>

                <!-- File Upload -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">File SK (PDF)</label>
                    <input type="file" name="file_sk" accept=".pdf"
                        class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                    <p class="text-xs text-slate-400 mt-1">*Maksimal 2MB.</p>
                </div>

                <div class="pt-4 text-right">
                    <button type="submit"
                        class="bg-emerald-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-emerald-700 transition-colors">
                        Simpan Data SK
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection