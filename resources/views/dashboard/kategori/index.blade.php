@extends('layouts.dashboard')

@section('title', 'Kategori Berita')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Kategori Berita</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Kelola kategori untuk pengelompokan berita.</p>
        </div>
        <a href="{{ route('dashboard.kategori.create') }}"
            class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-5 rounded-xl transition-colors shadow-lg shadow-emerald-500/30">
            <span class="material-symbols-outlined">add</span>
            Tambah Kategori
        </a>
    </div>

    @if(session('success'))
        <div
            class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 font-medium flex items-center gap-3 border border-emerald-100 dark:border-emerald-800">
            <span class="material-symbols-outlined">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <div
        class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-white/5 shadow-sm overflow-hidden max-w-3xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead
                    class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Nama Kategori</th>
                        <th class="px-6 py-4">Slug</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($kategoris as $kategori)
                        <tr class="group hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                            <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                                {{ $kategori->nama }}
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-gray-500">
                                {{ $kategori->slug }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('dashboard.kategori.edit', $kategori) }}"
                                        class="p-2 rounded-lg text-gray-500 hover:bg-emerald-50 hover:text-emerald-600 transition-colors"
                                        title="Edit">
                                        <span class="material-symbols-outlined">edit_square</span>
                                    </a>
                                    <form action="{{ route('dashboard.kategori.destroy', $kategori) }}" method="POST"
                                        onsubmit="return confirm('Hapus kategori ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 rounded-lg text-gray-500 hover:bg-red-50 hover:text-red-600 transition-colors"
                                            title="Hapus">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                                Belum ada kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection