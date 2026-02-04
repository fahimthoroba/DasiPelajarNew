@extends('layouts.dashboard')

@section('title', 'Agenda & Absensi - ' . $proker->nama_proker)

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard.departemen.proker.show', $proker->id) }}"
                class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-white/10 transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Agenda & Absensi</h1>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm">
            <h2 class="font-bold text-lg mb-4">Buat Agenda Baru</h2>
            <form action="{{ route('dashboard.departemen.proker.agenda.store', $proker->id) }}" method="POST"
                enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                <!-- Judul -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 mb-1">Nama Agenda / Rapat</label>
                    <input type="text" name="judul" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm"
                        placeholder="Contoh: Rapat Koordinasi, Technical Meeting, dll.">
                </div>

                <!-- Jenis -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">Jenis Agenda</label>
                    <select name="jenis" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm">
                        <option value="rapat">Rapat</option>
                        <option value="kegiatan">Kegiatan Lapangan</option>
                    </select>
                </div>

                <!-- Waktu -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">Tanggal & Waktu</label>
                    <input type="datetime-local" name="tgl_waktu" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm">
                </div>

                <!-- Notulensi -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 mb-1">Upload Notulensi (Opsional)</label>
                    <input type="file" name="notulensi_path" accept=".pdf,.doc,.docx"
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div class="md:col-span-2 text-right">
                    <button type="submit"
                        class="bg-emerald-600 text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-emerald-700">
                        Simpan Agenda
                    </button>
                </div>
            </form>
        </div>

        <!-- List -->
        <div class="py-4 space-y-4">
            @forelse($proker->absensis as $agenda)
                <div class="flex gap-4 p-4 bg-white dark:bg-gray-800 rounded-xl border border-slate-100 dark:border-white/5 shadow-sm items-center">
                    
                    <!-- Date Box -->
                    <div class="w-16 h-16 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl flex flex-col items-center justify-center text-emerald-600 dark:text-emerald-400">
                        <span class="text-xs font-bold">{{ $agenda->tgl_waktu->format('M') }}</span>
                        <span class="text-xl font-bold">{{ $agenda->tgl_waktu->format('d') }}</span>
                    </div>

                    <!-- Info -->
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-slate-100 text-slate-500 border border-slate-200">
                                {{ $agenda->jenis }}
                            </span>
                            @if($agenda->status == 'buka')
                                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-green-100 text-green-600 border border-green-200">
                                    Buka
                                </span>
                            @else
                                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-red-100 text-red-600 border border-red-200">
                                    Tutup
                                </span>
                            @endif
                        </div>

                        <h3 class="font-bold text-slate-800 dark:text-white text-lg">{{ $agenda->judul }}</h3>
                        <p class="text-sm text-slate-500 mb-1">
                            <span class="material-symbols-outlined text-xs align-middle">schedule</span>
                            {{ $agenda->tgl_waktu->format('H:i') }} WIB
                            @if($agenda->lokasi)
                                <span class="mx-2">•</span>
                                <span class="material-symbols-outlined text-xs align-middle">location_on</span>
                                {{ $agenda->lokasi }}
                            @endif
                        </p>
                        
                        <div class="flex gap-4 mt-2">
                             @if($agenda->notulensi_path)
                                <a href="{{ Storage::url($agenda->notulensi_path) }}" target="_blank"
                                    class="text-xs font-bold text-blue-600 hover:underline flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">description</span> Baca Notulensi
                                </a>
                            @endif
                            <button class="text-xs font-bold text-slate-500 hover:text-emerald-600 flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">qr_code</span> Kode: {{ $agenda->kode_akses }}
                            </button>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-2">
                         <form action="{{ route('dashboard.departemen.proker.agenda.destroy', [$proker->id, $agenda->id]) }}"
                            method="POST" onsubmit="return confirm('Hapus agenda ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-slate-400 bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-slate-200">
                    <span class="material-symbols-outlined text-4xl mb-2">event_busy</span>
                    <p>Belum ada agenda atau rapat.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection