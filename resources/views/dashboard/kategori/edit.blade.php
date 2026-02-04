@extends('layouts.dashboard')

@section('title', 'Edit Kategori')

@section('content')
    <div class="max-w-xl">
        <div class="mb-6">
            <a href="{{ route('dashboard.kategori.index') }}"
                class="inline-flex items-center gap-2 text-gray-500 hover:text-emerald-600 transition-colors mb-2 text-sm">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Kembali
            </a>
            <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Edit Kategori</h1>
        </div>

        <form action="{{ route('dashboard.kategori.update', $kategori) }}" method="POST"
            class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Nama Kategori</label>
                <input type="text" name="nama" value="{{ old('nama', $kategori->nama) }}" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                @error('nama')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-emerald-600/20 transition-all">
                <span class="material-symbols-outlined">save</span>
                Simpan Perubahan
            </button>
        </form>
    </div>
@endsection