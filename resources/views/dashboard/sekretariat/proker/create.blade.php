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
            <form action="{{ route('dashboard.sekretariat.proker.store') }}" method="POST" class="space-y-6"
                x-data="{
                    tipe: '{{ old('tipe_pelaksanaan', 'kepanitiaan') }}',
                    selectedDept: '{{ old('departemen_id') }}',
                    pengurusAll: {{ $pengurusList->toJson() }},
                    get pengurusFiltered() {
                        return this.selectedDept
                            ? this.pengurusAll.filter(p => p.departemen_id === this.selectedDept)
                            : [];
                    }
                }">
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
                        <select name="departemen_id" x-model="selectedDept" required
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

                <!-- Tipe Pelaksanaan -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Tipe Pelaksanaan</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="tipe_pelaksanaan" value="kepanitiaan" x-model="tipe"
                                class="text-emerald-600 focus:ring-emerald-500">
                            <span class="text-sm text-slate-700 dark:text-slate-300">Kepanitiaan Penuh</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="tipe_pelaksanaan" value="penanggung_jawab" x-model="tipe"
                                class="text-emerald-600 focus:ring-emerald-500">
                            <span class="text-sm text-slate-700 dark:text-slate-300">Penanggung Jawab</span>
                        </label>
                    </div>
                    <p class="text-xs text-slate-400 mt-2">
                        Kepanitiaan Penuh: untuk kegiatan besar yang butuh struktur panitia lengkap.
                        Penanggung Jawab: untuk rapat rutin/kegiatan kecil, cukup 1 orang bertanggung jawab.
                    </p>
                </div>

                <!-- Pilih Pengurus Penanggung Jawab (kondisional, di-scope ke Departemen Pelaksana terpilih) -->
                <div x-show="tipe === 'penanggung_jawab'" x-cloak>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Pengurus Penanggung Jawab</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">badge</span>
                        <select name="penanggung_jawab_pengurus_id" :disabled="!selectedDept"
                            class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl pl-12 pr-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition-all text-slate-700 appearance-none">
                            <option value="">Pilih Pengurus...</option>
                            <template x-for="p in pengurusFiltered" :key="p.id">
                                <option :value="p.id" x-text="p.label" :selected="p.id === '{{ old('penanggung_jawab_pengurus_id') }}'"></option>
                            </template>
                        </select>
                    </div>
                    <p class="text-xs text-slate-400 mt-1" x-show="!selectedDept">Pilih Departemen Pelaksana dulu untuk melihat daftar pengurusnya.</p>
                    @error('penanggung_jawab_pengurus_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

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