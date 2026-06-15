@extends('layouts.dashboard')

@section('title', 'Input Program Kerja Baru')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard.sekretariat.proker.index') }}"
                class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-emerald-600 hover:border-emerald-500 hover:shadow-sm transition-all">
                <span class="material-symbols-outlined text-xl">arrow_back</span>
            </a>
            <div>
                <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Input Program Kerja Baru</h1>
                <p class="text-slate-500 text-sm">Delegasikan program kerja ke departemen pelaksana.</p>
            </div>
        </div>

        <div
            class="bg-white dark:bg-gray-800 p-6 md:p-8 rounded-3xl border border-slate-100 dark:border-white/5 shadow-sm max-w-3xl">
            <form action="{{ route('dashboard.sekretariat.proker.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Nama Program -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Nama Program
                        Kerja</label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">event</span>
                        <input type="text" name="nama_proker" value="{{ old('nama_proker') }}" required
                            class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl pl-12 pr-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition-all placeholder:text-slate-400"
                            placeholder="Contoh: Latihan Kader Muda (LAKMUD)">
                    </div>
                </div>

                <!-- Departemen Pelaksana -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Departemen
                        Pelaksana</label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">corporate_fare</span>
                        <select name="departemen_id" required
                            class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl pl-12 pr-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition-all text-slate-700 appearance-none">
                            <option value="">Pilih Departemen...</option>
                            @foreach($departemens as $dept)
                                <option value="{{ $dept->id }}" {{ old('departemen_id') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->nama_departemen }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tanggal Pelaksanaan -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Tanggal
                            Pelaksanaan</label>
                        <div class="relative">
                            <span
                                class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">calendar_month</span>
                            <input type="date" name="tgl_pelaksanaan" value="{{ old('tgl_pelaksanaan') }}" required
                                class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl pl-12 pr-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition-all">
                        </div>
                    </div>

                    <!-- Penanggung Jawab (Opsional) -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Penanggung Jawab
                            <span class="text-slate-400 font-normal">(Opsional)</span></label>
                        <div class="relative">
                            <span
                                class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">person</span>
                            <input type="text" name="penanggung_jawab" value="{{ old('penanggung_jawab') }}"
                                class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl pl-12 pr-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition-all placeholder:text-slate-400"
                                placeholder="Nama koordinator utama">
                        </div>
                    </div>
                </div>

                <hr class="border-slate-100 dark:border-white/10">

                <div class="flex justify-end gap-3">
                    <a href="{{ route('dashboard.sekretariat.proker.index') }}"
                        class="px-6 py-3 rounded-xl text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-8 py-3 rounded-xl text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm hover:shadow-emerald-600/20 transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">save</span> Simpan Program
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection