@extends('layouts.dashboard')

@section('title', 'Overview')

@section('content')
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Dashboard</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Selamat datang kembali, {{ Auth::user()->name }}!</p>
        </div>
    </div>

    <!-- Dynamic Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @if(isset($stats['berita']))
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 flex items-center justify-center">
                        <span class="material-symbols-outlined">newspaper</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Berita</p>
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $stats['berita'] }}</h3>
                    </div>
                </div>
            </div>
        @endif

        @if(isset($stats['surat_masuk']))
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 flex items-center justify-center">
                        <span class="material-symbols-outlined">mail</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Surat Masuk</p>
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $stats['surat_masuk'] }}</h3>
                    </div>
                </div>
            </div>
        @endif

        @if(isset($stats['surat_keluar']))
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-orange-50 dark:bg-orange-900/20 text-orange-600 flex items-center justify-center">
                        <span class="material-symbols-outlined">send</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Surat Keluar</p>
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $stats['surat_keluar'] }}</h3>
                    </div>
                </div>
            </div>
        @endif

        @if(isset($stats['kader']))
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-900/20 text-purple-600 flex items-center justify-center">
                        <span class="material-symbols-outlined">groups</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Kader</p>
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $stats['kader'] }}</h3>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="bg-emerald-900 rounded-3xl p-8 relative overflow-hidden text-white shadow-xl">
        <div class="relative z-10 max-w-xl">
            <h2 class="text-3xl font-display font-bold mb-4">Mulai Kelola Konten</h2>
            <p class="text-emerald-100 mb-6">Anda terdaftar sebagai <strong>{{ Auth::user()->role }}</strong>. Silakan akses
                menu di samping untuk mengelola data.</p>
        </div>
        <div
            class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
        </div>
    </div>
@endsection