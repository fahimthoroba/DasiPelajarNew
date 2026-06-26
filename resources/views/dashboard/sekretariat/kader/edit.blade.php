@extends('layouts.dashboard')

@section('title', 'Edit Profil Kader')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-8 items-center justify-between">
            <a href="{{ route('dashboard.sekretariat.kader.index') }}"
                class="text-emerald-600 font-bold text-sm inline-flex items-center gap-1 hover:text-emerald-700 mb-2">
                <span class="material-symbols-outlined text-lg">arrow_back</span> Kembali
            </a>
            <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Edit Profil — {{ $kader->nama_lengkap }}</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Foto dan quote yang ditampilkan di modal Struktur Organisasi publik.</p>
        </div>

        <form action="{{ route('dashboard.sekretariat.kader.update', $kader->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')
            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm space-y-5">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Foto Profil</label>
                    @if($kader->foto_path)
                    <img src="{{ asset('storage/' . $kader->foto_path) }}" alt="{{ $kader->nama_lengkap }}"
                        class="w-20 h-20 rounded-full object-cover mb-3">
                    @endif
                    <input type="file" name="foto_path" accept="image/*"
                        class="w-full block text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                    @error('foto_path')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Quote</label>
                    <textarea name="quote" rows="3" maxlength="255"
                        class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 dark:text-white">{{ old('quote', $kader->quote) }}</textarea>
                    @error('quote')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <button type="submit"
                class="w-full bg-emerald-600 text-white font-bold py-4 rounded-xl hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-900/20">Simpan
                Perubahan</button>
        </form>
    </div>
@endsection
