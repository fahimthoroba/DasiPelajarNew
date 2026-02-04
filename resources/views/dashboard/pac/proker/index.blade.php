@extends('layouts.dashboard')

@section('title', 'Program Kerja')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Program Kerja & Kegiatan</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Kelola rencana dan realisasi kegiatan PAC Anda.</p>
        </div>
        <a href="{{ route('dashboard.pac.proker.create') }}"
            class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-5 rounded-xl transition-colors shadow-lg shadow-emerald-500/30">
            <span class="material-symbols-outlined">add_circle</span>
            Tambah Kegiatan
        </a>
    </div>

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
                <thead>
                    <tr
                        class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 uppercase tracking-wider font-bold">
                        <th class="px-6 py-4">Nama Kegiatan</th>
                        <th class="px-6 py-4">Departemen</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse($programs as $program)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $program->nama_lokal }}
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                {{ $program->departemen->nama_departemen ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                <span
                                    class="px-2 py-1 rounded bg-gray-100 dark:bg-gray-700 text-xs font-bold text-gray-600 dark:text-gray-300">
                                    {{ $program->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col">
                                    <span
                                        class="font-bold">{{ \Carbon\Carbon::parse($program->tgl_mulai)->translatedFormat('d M Y') }}</span>
                                    @if($program->tgl_selesai != $program->tgl_mulai)
                                        <span class="text-xs">s/d
                                            {{ \Carbon\Carbon::parse($program->tgl_selesai)->translatedFormat('d M Y') }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'Rencana' => 'bg-gray-100 text-gray-600',
                                        'Pasti' => 'bg-amber-100 text-amber-600',
                                        'Terlaksana' => 'bg-emerald-100 text-emerald-600',
                                    ];
                                    $color = $statusColors[$program->status] ?? 'bg-gray-100 text-gray-600';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $color }}">
                                    {{ $program->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Edit Button -->
                                    <a href="{{ route('dashboard.pac.proker.edit', $program->id) }}"
                                        class="p-2 rounded-lg text-gray-400 hover:bg-emerald-50 hover:text-emerald-600 transition-colors"
                                        title="Edit">
                                        <span class="material-symbols-outlined">edit</span>
                                    </a>

                                    <!-- Delete Form -->
                                    <form action="{{ route('dashboard.pac.proker.destroy', $program->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus kegiatan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 rounded-lg text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors"
                                            title="Hapus">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <div
                                    class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 mb-3">
                                    <span class="material-symbols-outlined text-2xl">event_busy</span>
                                </div>
                                <p>Belum ada program kerja yang ditambahkan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($programs->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-white/5">
                {{ $programs->links() }}
            </div>
        @endif
    </div>
@endsection