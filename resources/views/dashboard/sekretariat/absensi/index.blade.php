@extends('layouts.dashboard')

@section('title', 'Jadwal Absensi & Kumpulan')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Absensi & Kumpulan</h1>
                <p class="text-sm text-slate-500">Kelola jadwal rapat rutin dan kegiatan umum.</p>
            </div>
            <a href="{{ route('dashboard.sekretariat.absensi.create') }}"
                class="bg-emerald-600 text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-emerald-700 flex items-center gap-2">
                <span class="material-symbols-outlined">add</span> Buat Agenda
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($agendas as $agenda)
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm hover:shadow-md transition-all p-6 relative group">
                    <div class="flex justify-between items-start mb-4">
                        <div
                            class="flex flex-col items-center justify-center bg-emerald-50 text-emerald-600 rounded-xl w-14 h-14">
                            <span class="text-xs font-bold uppercase">{{ $agenda->tgl_waktu->format('M') }}</span>
                            <span class="text-xl font-bold">{{ $agenda->tgl_waktu->format('d') }}</span>
                        </div>
                        <div class="flex gap-2">
                            @if($agenda->status == 'buka')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold uppercase">Buka</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold uppercase">Tutup</span>
                            @endif
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="text-slate-400 hover:text-slate-600 p-1">
                                    <span class="material-symbols-outlined">more_vert</span>
                                </button>
                                <div x-show="open" @click.away="open = false"
                                    class="absolute right-0 top-full mt-1 w-32 bg-white dark:bg-gray-700 rounded-lg shadow-lg border border-slate-100 dark:border-white/5 py-1 z-10"
                                    x-cloak>
                                    <a href="{{ route('dashboard.sekretariat.absensi.show', $agenda->id) }}"
                                        class="block px-4 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-white/5">Detail</a>
                                    <form action="{{ route('dashboard.sekretariat.absensi.destroy', $agenda->id) }}"
                                        method="POST" onsubmit="return confirm('Hapus agenda ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-1">{{ $agenda->judul }}</h3>
                    <div class="text-sm text-slate-500 space-y-1 mb-4">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-base">schedule</span>
                            {{ $agenda->tgl_waktu->format('H:i') }} WIB
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-base">location_on</span>
                            {{ $agenda->lokasi ?? 'Online / Menyesuaikan' }}
                        </div>
                    </div>

                    <a href="{{ route('dashboard.sekretariat.absensi.show', $agenda->id) }}"
                        class="block w-full text-center py-2 rounded-lg border border-emerald-600 text-emerald-600 font-bold text-sm hover:bg-emerald-50 transition-colors">
                        Lihat Absensi
                    </a>
                </div>
            @empty
                <div
                    class="col-span-full text-center py-12 text-slate-400 bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-slate-200">
                    <span class="material-symbols-outlined text-4xl mb-2">event_busy</span>
                    <p>Belum ada agenda rapat umum.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection