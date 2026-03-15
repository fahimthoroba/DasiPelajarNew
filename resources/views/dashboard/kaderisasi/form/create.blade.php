@extends('layouts.dashboard')

@section('title', 'Buat Form Baru')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Buat Form Kegiatan</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1 mb-4">Pilih kegiatan program kerja yang belum memiliki form pendaftaran online secara publik.</p>
        </div>
        <a href="{{ route('dashboard.kaderisasi.form.index') }}"
            class="inline-flex items-center justify-center gap-2 text-gray-500 hover:text-emerald-600 transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
            Batal
        </a>
    </div>

    <form action="{{ route('dashboard.kaderisasi.form.store') }}" method="POST"
        class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-white/5 shadow-sm p-6 max-w-2xl mx-auto space-y-6">
        @csrf

        <!-- Input Nama Kegiatan -->
        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Nama Kegiatan</label>
            <input type="text" name="nama_kegiatan" required placeholder="Masukkan Nama Kegiatan yang Pendaftarannya Dibuka..."
                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
            @error('nama_kegiatan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tanggal Buka / Tutup -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Pendaftaran Dibuka</label>
                <input type="datetime-local" name="tgl_buka" value="{{ old('tgl_buka') }}"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                @error('tgl_buka')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Pendaftaran Ditutup</label>
                <input type="datetime-local" name="tgl_tutup" value="{{ old('tgl_tutup') }}"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                @error('tgl_tutup')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <p class="text-xs text-emerald-600 bg-emerald-50 p-3 rounded-lg border border-emerald-100">
            <strong>Info:</strong> Setelah Form dibuat, Anda bisa masuk ke menu "Pengaturan (Konfigurasi Form)" untuk menambah pertanyaan-pertanyaan form (Custom Fields).
        </p>

        <!-- Submit -->
        <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-end">
            <button type="submit"
                class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-lg shadow-emerald-500/30">
                Lanjut Konfigurasi Form &rarr;
            </button>
        </div>
    </form>
@endsection
