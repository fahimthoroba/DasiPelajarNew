@extends('layouts.dashboard')

@section('title', 'Detail Absensi')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard.sekretariat.absensi.index') }}"
                class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-white/10 transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div>
                <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">{{ $agenda->judul }}</h1>
                <p class="text-slate-500">{{ $agenda->tgl_waktu->format('l, d F Y H:i') }} WIB • {{ $agenda->lokasi ?? 'Online' }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- QR Code Panel -->
            <div class="md:col-span-1">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm text-center">
                    <h3 class="font-bold text-lg mb-4">Scan QR Absensi</h3>
                    <div class="bg-white p-4 rounded-xl border border-slate-100 inline-block mb-4">
                        {!! QrCode::size(200)->generate($qrUrl) !!}
                    </div>
                    <p class="text-xs text-slate-400 mb-4">Arahkan kamera HP kader ke kode QR ini untuk mengisi daftar hadir otomatis.</p>
                    
                    <div class="bg-slate-50 rounded-lg p-3">
                        <p class="text-xs font-bold text-slate-500 mb-1">Kode Manual</p>
                        <p class="text-2xl font-mono font-bold tracking-widest text-slate-800">{{ $agenda->kode_akses }}</p>
                    </div>
                </div>
            </div>

            <!-- Attendance List -->
            <div class="md:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 dark:border-white/5 flex justify-between items-center">
                        <h3 class="font-bold text-lg">Daftar Hadir</h3>
                        <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold">
                            Total: {{ $agenda->records->count() }}
                        </span>
                    </div>
                    <div class="max-h-[500px] overflow-y-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-slate-50 dark:bg-white/5 text-slate-500 font-bold uppercase text-xs sticky top-0">
                                <tr>
                                    <th class="px-6 py-4">No</th>
                                    <th class="px-6 py-4">Nama Kader</th>
                                    <th class="px-6 py-4">Waktu Hadir</th>
                                    <th class="px-6 py-4">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                                @forelse($agenda->records as $index => $record)
                                    <tr>
                                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-slate-800 dark:text-white">{{ $record->kader->nama_lengkap }}</div>
                                            <div class="text-xs text-slate-500">{{ $record->kader->nia ?? 'Belum ada NIA' }}</div>
                                        </td>
                                        <td class="px-6 py-4 font-mono text-xs">
                                            {{ $record->created_at->format('H:i:s') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs font-bold">Hadir</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                            Belum ada yang hadir.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
