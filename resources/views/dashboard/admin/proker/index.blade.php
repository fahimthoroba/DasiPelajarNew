@extends('layouts.dashboard')

@section('title', 'Admin - Daftar Program Kerja')

@section('content')
    <div class="space-y-6">
        <!-- Header & Filter -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Program Kerja PAC</h1>
                <p class="text-gray-500 text-sm mt-1">Kelola dan pantau seluruh kegiatan PAC.</p>
            </div>

            <form action="{{ route('dashboard.admin.proker.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <!-- Search -->
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kegiatan..."
                    class="px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:border-emerald-500 focus:ring-emerald-500/20 text-sm">

                <!-- Filter PAC -->
                <select name="pac_id" onchange="this.form.submit()"
                    class="px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:border-emerald-500 focus:ring-emerald-500/20 text-sm min-w-[200px]">
                    <option value="">-- Semua PAC --</option>
                    @foreach($pacs as $pac)
                        <option value="{{ $pac->id }}" {{ request('pac_id') == $pac->id ? 'selected' : '' }}>
                            {{ $pac->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        @if(session('success'))
            <div
                class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 font-medium border border-emerald-100 dark:border-emerald-800 flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        <!-- Card List (Table) -->
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead
                        class="text-xs text-gray-500 uppercase bg-gray-50/50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700">
                        <tr>
                            <th class="px-6 py-4 font-bold">Nama Kegiatan</th>
                            <th class="px-6 py-4 font-bold">Pemilik (PAC)</th>
                            <th class="px-6 py-4 font-bold">Kategori / Dept</th>
                            <th class="px-6 py-4 font-bold">Waktu</th>
                            <th class="px-6 py-4 font-bold">Status</th>
                            <th class="px-6 py-4 font-bold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($programs as $program)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                                    {{ $program->nama_lokal }}
                                                </td>
                                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                                    <div class="flex items-center gap-2">
                                                        <span
                                                            class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold">
                                                            {{ substr($program->pac->name ?? '?', 0, 1) }}
                                                        </span>
                                                        {{ $program->pac->name ?? 'Deleted User' }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                                    <div class="flex flex-col gap-1 items-start">
                                                        <span
                                                            class="px-2 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-xs font-bold text-gray-600 dark:text-gray-300">
                                                            {{ $program->kategori->nama_kategori ?? 'Umum' }}
                                                        </span>
                                                        @if($program->departemen)
                                                            <span class="text-xs text-blue-600">
                                                                {{ $program->departemen->nama_departemen }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                                    <div class="flex flex-col">
                                                        <span class="font-medium text-gray-900 dark:text-gray-200">
                                                            {{ $program->tgl_mulai->format('d M') }} -
                                                            {{ $program->tgl_selesai->format('d M Y') }}
                                                        </span>
                                                        <span class="text-xs text-gray-400">
                                                            {{ $program->tgl_mulai->diffInDays($program->tgl_selesai) + 1 }} Hari
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    @php
                                                        $statusClass = match ($program->status) {
                                                            'Rencana' => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300',
                                                            'Pasti' => 'bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400',
                                                            'Terlaksana' => 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400',
                                                            default => 'bg-gray-100 text-gray-600'
                                                        };
                                                    @endphp
                             <span
                                                        class="px-2.5 py-1 rounded-full text-xs font-bold border border-transparent {{ $statusClass }}">
                                                        {{ $program->status }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-right">
                                                    <div class="flex items-center justify-end gap-2">
                                                        <!-- Edit Check -->
                                                        <a href="{{ route('dashboard.admin.proker.edit', $program->id) }}"
                                                            class="p-2 rounded-lg text-gray-400 hover:bg-emerald-50 hover:text-emerald-600 transition-colors"
                                                            title="Edit">
                                                            <span class="material-symbols-outlined">edit</span>
                                                        </a>

                                                        <form action="{{ route('dashboard.admin.proker.destroy', $program->id) }}" method="POST"
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
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center gap-3">
                                        <span class="material-symbols-outlined text-4xl text-gray-300">event_busy</span>
                                        <p>Belum ada program kerja yang ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                {{ $programs->links() }}
            </div>
        </div>
    </div>
@endsection