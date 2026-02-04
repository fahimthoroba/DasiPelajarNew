@extends('layouts.dashboard')

@section('title', 'Dashboard Departemen')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Dashboard Departemen</h1>
                <p class="text-slate-500 dark:text-slate-400">Selamat datang, {{ Auth::user()->name }}</p>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm">
                <div class="text-slate-500 text-sm font-medium mb-1">Total Program</div>
                <div class="text-3xl font-bold text-slate-800 dark:text-white">{{ $stats['total'] }}</div>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm">
                <div class="text-amber-500 text-sm font-medium mb-1">Perencanaan</div>
                <div class="text-3xl font-bold text-amber-600">{{ $stats['perencanaan'] }}</div>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm">
                <div class="text-blue-500 text-sm font-medium mb-1">Sedang Jalan</div>
                <div class="text-3xl font-bold text-blue-600">{{ $stats['persiapan'] + $stats['pelaksanaan'] }}</div>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm">
                <div class="text-emerald-500 text-sm font-medium mb-1">Selesai</div>
                <div class="text-3xl font-bold text-emerald-600">{{ $stats['selesai'] }}</div>
            </div>
        </div>

        <!-- Quick Action -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-8 rounded-3xl text-white relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-2xl font-bold mb-2">Kelola Program Kerja</h2>
                <p class="text-blue-100 mb-6 max-w-lg">Susun kepanitiaan, atur jadwal, dan pantau eksekusi program kerja
                    departemen Anda disini.</p>
                <a href="{{ route('dashboard.departemen.proker.index') }}"
                    class="bg-white text-blue-800 px-6 py-3 rounded-xl font-bold hover:bg-blue-50 transition-colors inline-block">
                    Lihat Program Saya
                </a>
            </div>
            <div class="absolute right-0 top-0 h-full w-1/2 opacity-10">
                <!-- Decorative pattern can go here -->
                <span class="material-symbols-outlined text-[200px] absolute -right-10 -top-10">event_note</span>
            </div>
        </div>
    </div>
@endsection