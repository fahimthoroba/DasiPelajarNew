@extends('layouts.dashboard')

@section('title', 'Catat Program Kerja')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-8 items-center justify-between">
            <a href="{{ route('dashboard.sekretariat.departemen.index') }}"
                class="text-blue-600 font-bold text-sm inline-flex items-center gap-1 hover:text-blue-700 mb-2">
                <span class="material-symbols-outlined text-lg">arrow_back</span> Kembali
            </a>
            <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Catat Program Kerja</h1>
        </div>

        <form action="{{ route('dashboard.sekretariat.departemen.store') }}" method="POST" class="space-y-6">
            @csrf
            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm space-y-5">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Program
                        Kerja</label>
                    <input type="text" name="nama_proker" required
                        class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 dark:text-white"
                        placeholder="Contoh: Makesta Raya 2025">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Departemen
                        Penanggung Jawab</label>
                    <select name="departemen_id" required
                        class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                        <option value="" disabled selected>Pilih Departemen</option>
                        @foreach($departemens as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->nama_departemen }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal
                            Pelaksanaan</label>
                        <input type="date" name="tgl_pelaksanaan" required
                            class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ketua Pelaksana
                            / PJ</label>
                        <input type="text" name="penanggung_jawab" placeholder="Opsional"
                            class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 dark:text-white">
                    </div>
                </div>
            </div>
            <button type="submit"
                class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-900/20">Simpan
                Program</button>
        </form>
    </div>
@endsection