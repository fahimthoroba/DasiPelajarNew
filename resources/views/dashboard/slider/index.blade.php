@extends('layouts.dashboard')

@section('title', 'Slider Hero')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Slider Hero Homepage</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Kelola banner slide yang tampil di halaman depan.</p>
        </div>
        <a href="{{ route('dashboard.slider.create') }}"
            class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-5 rounded-xl transition-colors shadow-lg shadow-emerald-500/30">
            <span class="material-symbols-outlined">add</span>
            Tambah Slide
        </a>
    </div>

    @if(session('success'))
        <div
            class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 font-medium flex items-center gap-3 border border-emerald-100 dark:border-emerald-800">
            <span class="material-symbols-outlined">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($sliders as $slider)
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-100 dark:border-white/5 shadow-sm group hover:shadow-lg transition-all">
                <div class="relative aspect-video">
                    <img src="{{ asset('storage/' . $slider->gambar_path) }}" class="w-full h-full object-cover">
                    <div class="absolute top-2 right-2">
                        @if($slider->is_active)
                            <span class="px-2 py-1 rounded-full text-xs font-bold bg-emerald-500 text-white shadow-sm">Aktif</span>
                        @else
                            <span class="px-2 py-1 rounded-full text-xs font-bold bg-gray-500 text-white shadow-sm">Non-Aktif</span>
                        @endif
                    </div>
                    <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/80 to-transparent p-4">
                        <span
                            class="inline-block px-2 py-0.5 rounded text-[10px] bg-white/20 backdrop-blur-sm text-white border border-white/20 mb-1">
                            {{ $slider->label ?? '-' }}
                        </span>
                        <h3 class="text-white font-bold text-lg truncate">{{ $slider->judul_utama }}</h3>
                        <p class="text-gray-300 text-xs">{{ $slider->sub_judul }}</p>
                    </div>
                </div>
                <div class="p-4 flex items-center justify-between">
                    <div class="text-xs font-bold text-gray-500 uppercase tracking-widest">
                        Urutan: {{ $slider->urutan }}
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('dashboard.slider.edit', $slider) }}"
                            class="p-2 rounded-lg text-gray-500 hover:bg-emerald-50 hover:text-emerald-600 transition-colors"
                            title="Edit">
                            <span class="material-symbols-outlined">edit_square</span>
                        </a>
                        <form action="{{ route('dashboard.slider.destroy', $slider) }}" method="POST"
                            onsubmit="return confirm('Hapus slider ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="p-2 rounded-lg text-gray-500 hover:bg-red-50 hover:text-red-600 transition-colors"
                                title="Hapus">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-24 text-center">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-400 mb-4">
                    <span class="material-symbols-outlined text-3xl">view_carousel</span>
                </div>
                <h3 class="text-gray-900 dark:text-white font-bold mb-1">Belum ada slider</h3>
                <p class="text-gray-500 text-sm">Tambahkan gambar slider untuk halaman depan.</p>
            </div>
        @endforelse
    </div>
@endsection