@extends('layouts.dashboard')

@section('title', $proker->nama_proker)

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md::items-center justify-between gap-4">
            <div>
                <a href="{{ route('dashboard.departemen.proker.index') }}"
                    class="text-emerald-600 font-bold text-sm inline-flex items-center gap-1 hover:text-emerald-700 mb-2">
                    <span class="material-symbols-outlined text-lg">arrow_back</span> Kembali
                </a>
                <h1 class="text-3xl font-bold font-display text-slate-800 dark:text-white">{{ $proker->nama_proker }}</h1>
                <div class="flex items-center gap-4 mt-2 text-slate-500 dark:text-slate-400">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-lg">calendar_today</span>
                        {{ $proker->tgl_pelaksanaan->format('l, d F Y') }}
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-lg">person</span>
                        PJ: {{ $proker->penanggung_jawab ?? 'Belum Ditentukan' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Progress Stepper (Visual Only) -->
        <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl border border-slate-100 dark:border-white/5 shadow-sm">
            <div class="relative flex items-center justify-between w-full">
                <div class="absolute left-0 top-1/2 w-full h-1 bg-slate-100 dark:bg-white/5 -z-0"></div>

                @foreach(['Perencanaan', 'Persiapan', 'Pelaksanaan', 'Selesai'] as $index => $step)
                    @php
                        $isActive = in_array($proker->status_pelaksanaan, array_slice(['Perencanaan', 'Persiapan', 'Pelaksanaan', 'Selesai'], $index));
                        $isCurrent = $proker->status_pelaksanaan == $step;
                    @endphp
                    <div class="relative z-10 flex flex-col items-center bg-white dark:bg-gray-800 px-4">
                        <div
                            class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white mb-2 transition-all duration-300
                                                                        {{ $isActive ? 'bg-emerald-600 scale-110' : 'bg-slate-200' }} {{ $isCurrent ? 'ring-4 ring-emerald-100 dark:ring-emerald-900/50' : '' }}">
                            {{ $index + 1 }}
                        </div>
                        <span
                            class="text-xs font-bold {{ $isActive ? 'text-emerald-600' : 'text-slate-400' }}">{{ $step }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Execution Menu Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- 1. Bentuk Panitia -->
            <a href="{{ route('dashboard.departemen.proker.panitia', $proker->id) }}"
                class="group bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                <div
                    class="w-12 h-12 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center mb-4 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-2xl">groups</span>
                </div>
                <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-1">Bentuk Panitia</h3>
                <p class="text-sm text-slate-500">Susun struktur kepanitiaan kegiatan ini.</p>
            </a>

            <!-- 2. Agenda & Absensi -->
            <a href="{{ route('dashboard.departemen.proker.agenda.index', $proker->id) }}"
                class="group bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                <div
                    class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-2xl">event_note</span>
                </div>
                <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-1">Agenda & Absensi</h3>
                <p class="text-sm text-slate-500">Kelola jadwal & presensi.</p>
            </a>

            <!-- 3. Administrasi (Surat & Daftar) -->
            <div
                class="group bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm hover:shadow-md transition-all">
                <div
                    class="w-12 h-12 rounded-xl bg-teal-100 text-teal-600 flex items-center justify-center mb-4 group-hover:bg-teal-600 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-2xl">description</span>
                </div>
                <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-2">Administrasi</h3>
                <div class="space-y-2">
                    <a href="{{ route('dashboard.sekretariat.surat-keluar.create', ['proker_id' => $proker->id]) }}"
                        class="block w-full text-left text-sm font-bold text-slate-600 dark:text-slate-300 hover:text-emerald-600 flex items-center gap-2">
                        <span class="material-symbols-outlined text-base">forward_to_inbox</span> Buat Surat
                    </a>
                    <a href="{{ route('dashboard.departemen.proker.pendaftaran', $proker->id) }}"
                        class="block w-full text-left text-sm font-bold text-slate-600 dark:text-slate-300 hover:text-emerald-600 flex items-center gap-2">
                        <span class="material-symbols-outlined text-base">app_registration</span> Form Pendaftaran
                    </a>
                </div>
            </div>

            <!-- 4. Upload LPJ -->
            <div x-data="{ openLpj: false }" class="relative">
                <button @click="openLpj = true"
                    class="w-full text-left group bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm hover:shadow-md transition-all hover:-translate-y-1 {{ $proker->status_pelaksanaan == 'Selesai' ? 'ring-2 ring-emerald-500' : '' }}">
                    <div
                        class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-2xl">upload_file</span>
                    </div>
                    <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-1">Upload LPJ</h3>
                    <p class="text-sm text-slate-500">Unggah laporan pertanggung jawaban kegiatan.</p>
                    @if($proker->lpj_path)
                        <span
                            class="inline-block mt-2 text-xs bg-emerald-100 text-emerald-700 px-2 py-1 rounded font-bold">Sudah
                            Diupload</span>
                    @endif
                </button>

                <!-- LPJ Modal -->
                <div x-show="openLpj"
                    class="absolute top-full left-0 mt-2 w-full bg-white dark:bg-gray-800 p-4 rounded-xl shadow-xl border border-slate-100 z-20"
                    @click.away="openLpj = false" x-cloak>
                    <form action="{{ route('dashboard.departemen.proker.lpj.update', $proker->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <label class="block text-xs font-bold text-slate-500 mb-1">File LPJ (PDF)</label>
                        <input type="file" name="lpj_path" accept=".pdf"
                            class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 mb-2">
                        <button type="submit"
                            class="w-full bg-emerald-600 text-white text-xs font-bold py-2 rounded-lg hover:bg-emerald-700">Upload</button>
                        @if($proker->lpj_path)
                            <a href="{{ Storage::url($proker->lpj_path) }}" target="_blank"
                                class="block text-center text-xs text-blue-600 hover:underline mt-2">Lihat File Saat Ini</a>
                        @endif
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection