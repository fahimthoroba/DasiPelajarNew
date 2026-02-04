@extends('layouts.dashboard')

@section('title', 'Manajemen Berita')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Berita & Artikel</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Kelola konten berita yang akan tampil di website.</p>
        </div>
        <a href="{{ route('dashboard.berita.create') }}"
            class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-5 rounded-xl transition-colors shadow-lg shadow-emerald-500/30">
            <span class="material-symbols-outlined">add</span>
            Tambah Berita
        </a>
    </div>

    <!-- success Alert -->
    @if(session('success'))
        <div
            class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 font-medium flex items-center gap-3 border border-emerald-100 dark:border-emerald-800">
            <span class="material-symbols-outlined">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-white/5 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead
                    class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Berita</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Status & Tanggal</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($beritas as $berita)
                        <tr class="group hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-12 bg-gray-200 rounded-lg overflow-hidden shrink-0">
                                        @if($berita->thumbnail)
                                            <img src="{{ asset('storage/' . $berita->thumbnail) }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <span class="material-symbols-outlined text-lg">image</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="max-w-xs">
                                        <div class="font-bold text-gray-900 dark:text-white line-clamp-2 leading-tight mb-1">
                                            {{ $berita->judul }}</div>
                                        <div class="text-xs text-gray-500">Oleh: {{ $berita->user->name ?? 'Unknown' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                                    {{ $berita->kategori->nama ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <div>
                                        @if($berita->status == 'published')
                                            <span
                                                class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 dark:text-emerald-400">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Published
                                            </span>
                                        @elseif($berita->status == 'draft')
                                            <span
                                                class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-600 dark:text-amber-400">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Draft
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-600 dark:text-gray-400">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span> Archived
                                            </span>
                                        @endif
                                    </div>
                                    <span class="text-xs text-gray-400">
                                        {{ $berita->created_at->format('d M Y') }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('dashboard.berita.edit', $berita) }}"
                                        class="p-2 rounded-lg text-gray-500 hover:bg-emerald-50 hover:text-emerald-600 transition-colors"
                                        title="Edit">
                                        <span class="material-symbols-outlined">edit_square</span>
                                    </a>
                                    <form action="{{ route('dashboard.berita.destroy', $berita) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
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
                            <td colspan="4" class="px-6 py-24 text-center">
                                <div
                                    class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-400 mb-4">
                                    <span class="material-symbols-outlined text-3xl">newspaper</span>
                                </div>
                                <h3 class="text-gray-900 dark:text-white font-bold mb-1">Belum ada berita</h3>
                                <p class="text-gray-500 text-sm">Mulai dengan membuat berita baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($beritas->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-gray-800/50">
                {{ $beritas->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
@endsection