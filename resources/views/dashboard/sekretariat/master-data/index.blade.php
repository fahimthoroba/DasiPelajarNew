@extends('layouts.dashboard')

@section('title', 'Master Data Sekretariat')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Master Data</h1>
                <p class="text-slate-500 dark:text-slate-400">Kelola data referensi kesekretariatan.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card: Data Kader -->
            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm hover:shadow-md transition-all group">
                <div
                    class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-2xl">groups</span>
                </div>
                <h3 class="font-bold text-lg mb-2 text-slate-800 dark:text-white">Data Kader</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Kelola data anggota dan kader.</p>
                <a href="{{ route('dashboard.sekretariat.kader.index') }}"
                    class="inline-flex items-center text-sm font-bold text-emerald-600 hover:text-emerald-700">
                    Kelola Data <span class="material-symbols-outlined text-base ml-1">arrow_forward</span>
                </a>
            </div>

            <!-- Card: Departemen -->
            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm hover:shadow-md transition-all group">
                <div
                    class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center text-blue-600 dark:text-blue-400 mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-2xl">work_outline</span>
                </div>
                <h3 class="font-bold text-lg mb-2 text-slate-800 dark:text-white">Departemen</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Kelola daftar departemen/lembaga.</p>
                <a href="{{ route('dashboard.sekretariat.departemen.index') }}"
                    class="inline-flex items-center text-sm font-bold text-blue-600 hover:text-blue-700">
                    Kelola Data <span class="material-symbols-outlined text-base ml-1">arrow_forward</span>
                </a>
            </div>

            <!-- Card: Inventaris -->
            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm hover:shadow-md transition-all group">
                <div
                    class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center text-amber-600 dark:text-amber-400 mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-2xl">inventory_2</span>
                </div>
                <h3 class="font-bold text-lg mb-2 text-slate-800 dark:text-white">Inventaris</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Data aset dan barang organisasi.</p>
                <a href="{{ route('dashboard.sekretariat.inventaris.index') }}"
                    class="inline-flex items-center text-sm font-bold text-amber-600 hover:text-amber-700">
                    Kelola Data <span class="material-symbols-outlined text-base ml-1">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>
@endsection