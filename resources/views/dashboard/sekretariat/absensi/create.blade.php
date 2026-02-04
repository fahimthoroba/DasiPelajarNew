@extends('layouts.dashboard')

@section('title', 'Buat Agenda Baru')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard.sekretariat.absensi.index') }}"
                class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-white/10 transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Buat Agenda Baru</h1>
        </div>

        <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm">
            <form action="{{ route('dashboard.sekretariat.absensi.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Judul -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Nama Agenda /
                        Kegiatan</label>
                    <input type="text" name="judul" required placeholder="Contoh: Rapat Rutin Bulanan, Halal bi Halal..."
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5">
                </div>

                <!-- Jenis & Waktu -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Jenis Agenda</label>
                        <select name="jenis" required
                            class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5">
                            <option value="rapat">Rapat Internal</option>
                            <option value="kegiatan">Kegiatan Umum</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Tanggal &
                            Waktu</label>
                        <input type="datetime-local" name="tgl_waktu" required
                            class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5">
                    </div>
                </div>

                <!-- Lokasi -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Lokasi (Opsional)</label>
                    <input type="text" name="lokasi" placeholder="Nama Tempat / Link Zoom"
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5">
                </div>

                <div class="pt-4 text-right">
                    <button type="submit"
                        class="bg-emerald-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-emerald-700 transition-colors">
                        Simpan Agenda
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection