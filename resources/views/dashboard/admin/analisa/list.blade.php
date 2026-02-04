@extends('layouts.dashboard')

@section('title', $title)

@section('content')
    <div class="space-y-6">
        <!-- Breadcrumb & Header -->
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                <a href="{{ route('dashboard.admin.analisa.index') }}" class="hover:text-emerald-600">Analisa Data</a>
                <span class="material-symbols-outlined text-xs">chevron_right</span>
                <span>List Kegiatan</span>
            </div>
            <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">{{ $title }}</h1>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-white/5 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 font-medium border-b border-gray-100 dark:border-gray-700">
                        <tr>
                            <th class="px-6 py-4">Nama PAC</th>
                            <th class="px-6 py-4">Nama Program</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Departemen</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($programs as $p)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-emerald-600">
                                {{ $p->pac->name ?? 'Unknown PAC' }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $p->nama_lokal }}
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $p->tgl_mulai->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded text-xs border border-gray-200 bg-gray-50">
                                    {{ $p->kategori->nama_kategori ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $p->departemen->nama_departemen ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-1 rounded-full text-xs font-bold
                                    {{ $p->status == 'Terlaksana' ? 'bg-emerald-100 text-emerald-700' : 
                                      ($p->status == 'Belum Terlaksana' ? 'bg-gray-100 text-gray-700' : 'bg-red-100 text-red-700') }}">
                                    {{ $p->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('dashboard.admin.analisa.detail', $p->pac_id) }}" 
                                   class="text-blue-600 hover:underline text-xs">
                                    Lihat PAC
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                Tidak ada kegiatan ditemukan untuk kriteria ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($programs->hasPages())
            <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                {{ $programs->links() }}
            </div>
            @endif
        </div>
    </div>
@endsection
