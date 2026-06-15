@extends('layouts.dashboard')

@section('title', $proker->nama_proker)

@section('content')
<div class="space-y-8">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
        <div>
            <a href="{{ route('dashboard.departemen.proker.index') }}"
               class="inline-flex items-center gap-1 text-sm font-bold mb-2 transition-colors"
               style="color: var(--dp-bg-primary)">
                <span class="material-symbols-outlined text-lg">arrow_back</span> Kembali
            </a>
            <h1 class="text-2xl font-bold font-display" style="color: var(--dp-text-primary)">
                {{ $proker->nama_proker }}
            </h1>
            <div class="flex flex-wrap items-center gap-3 mt-2">
                <span class="flex items-center gap-1 text-sm" style="color: var(--dp-text-secondary)">
                    <span class="material-symbols-outlined text-base">calendar_today</span>
                    {{ $proker->tgl_pelaksanaan->format('d F Y') }}
                </span>
                <span class="flex items-center gap-1 text-sm" style="color: var(--dp-text-secondary)">
                    <span class="material-symbols-outlined text-base">person</span>
                    PJ: {{ $proker->penanggung_jawab ?? 'Belum Ditentukan' }}
                </span>
                @php
                    $statusStyle = match($proker->status_pelaksanaan) {
                        'Selesai'    => 'background: var(--dp-primary-tint); color: var(--dp-bg-primary)',
                        'Pelaksanaan'=> 'background: var(--dp-gold-tint); color: var(--dp-gold)',
                        default      => 'background: var(--dp-bg-surface-2); color: var(--dp-text-secondary)',
                    };
                @endphp
                <span class="text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-widest"
                      style="{{ $statusStyle }}">
                    {{ $proker->status_pelaksanaan }}
                </span>
            </div>
        </div>
    </div>

    {{-- Progress Stepper --}}
    <div class="p-6 md:p-8 rounded-2xl overflow-x-auto"
         style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
        <div class="relative flex items-center justify-between" style="min-width: 560px;">
            {{-- Connector track --}}
            <div class="absolute left-0 top-5 w-full h-0.5" style="background: var(--dp-border-strong); z-index: 0;"></div>

            @foreach(['Panitia', 'Rapat', 'Pendaftaran', 'Pelaksanaan', 'LPJ', 'Verifikasi'] as $index => $step)
                @php
                    $stepNumber = $index + 1;
                    $isActive   = $proker->current_step > $stepNumber;
                    $isCurrent  = $proker->current_step == $stepNumber;
                    if ($proker->status_pelaksanaan == 'Selesai') {
                        $isActive  = true;
                        $isCurrent = false;
                    }
                    $circleBg    = $isActive  ? 'var(--dp-bg-primary)'
                                 : ($isCurrent ? 'var(--dp-bg-primary)'
                                              : 'var(--dp-border-strong)');
                    $circleColor = ($isActive || $isCurrent) ? 'var(--dp-text-on-primary)' : 'var(--dp-text-secondary)';
                    $circleExtra = $isCurrent ? 'box-shadow: 0 0 0 4px var(--dp-gold-tint); transform: scale(1.1);' : '';
                    $labelColor  = ($isActive || $isCurrent) ? 'var(--dp-bg-primary)' : 'var(--dp-text-secondary)';
                @endphp
                <div class="relative flex flex-col items-center px-2 md:px-3"
                     style="background: var(--dp-bg-surface); z-index: 1;">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold mb-2 transition-all duration-300"
                         style="background: {{ $circleBg }}; color: {{ $circleColor }}; {{ $circleExtra }}">
                        @if($isActive)
                            <span class="material-symbols-outlined text-sm">check</span>
                        @else
                            {{ $stepNumber }}
                        @endif
                    </div>
                    <span class="text-[10px] md:text-xs font-bold" style="color: {{ $labelColor }}">
                        {{ $step }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- LPJ Ditolak Warning --}}
    @if($proker->lpj_catatan && $proker->current_step == 5)
        <div class="flex gap-4 items-start p-5 rounded-2xl"
             style="background: var(--dp-danger-tint); border: 1px solid rgba(232,70,58,0.25);">
            <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0"
                 style="background: rgba(232,70,58,0.15); color: var(--dp-danger)">
                <span class="material-symbols-outlined">warning</span>
            </div>
            <div class="flex-1">
                <h4 class="font-bold text-lg mb-1" style="color: var(--dp-danger)">LPJ Ditolak oleh BPH!</h4>
                <p class="text-sm font-semibold mb-2" style="color: var(--dp-danger)">
                    Perbaiki laporan Anda berdasarkan catatan berikut:
                </p>
                <div class="p-4 rounded-xl text-sm"
                     style="background: var(--dp-bg-surface); border: 1px solid rgba(232,70,58,0.2); color: var(--dp-text-primary)">
                    {!! nl2br(e($proker->lpj_catatan)) !!}
                </div>
            </div>
        </div>
    @endif

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold"
             style="background: var(--dp-primary-tint); color: var(--dp-bg-primary); border: 1px solid var(--dp-border);">
            <span class="material-symbols-outlined text-base">check_circle</span>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold"
             style="background: var(--dp-danger-tint); color: var(--dp-danger); border: 1px solid rgba(232,70,58,0.3);">
            <span class="material-symbols-outlined text-base">error</span>
            {{ session('error') }}
        </div>
    @endif

    {{-- Execution Menu Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

        {{-- 1. Bentuk Panitia --}}
        <a href="{{ route('dashboard.departemen.proker.panitia', $proker->id) }}"
           class="group block p-6 rounded-2xl transition-all hover:-translate-y-1"
           style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4 transition-colors"
                 style="background: var(--dp-primary-tint); color: var(--dp-bg-primary)">
                <span class="material-symbols-outlined text-2xl">groups</span>
            </div>
            <h3 class="font-bold text-base mb-1" style="color: var(--dp-text-primary)">Bentuk Panitia</h3>
            <p class="text-sm" style="color: var(--dp-text-secondary)">Susun struktur kepanitiaan kegiatan ini.</p>
            @if($proker->isStep1Complete())
                <span class="inline-block mt-3 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-widest"
                      style="background: var(--dp-bg-primary); color: var(--dp-text-gold)">
                    {{ $proker->kepanitiaans->count() }} Panitia
                </span>
            @endif
        </a>

        {{-- 2. Agenda & Absensi --}}
        <a href="{{ route('dashboard.departemen.proker.agenda.index', $proker->id) }}"
           class="group block p-6 rounded-2xl transition-all hover:-translate-y-1"
           style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4 transition-colors"
                 style="background: var(--dp-gold-tint); color: var(--dp-gold)">
                <span class="material-symbols-outlined text-2xl">event_note</span>
            </div>
            <h3 class="font-bold text-base mb-1" style="color: var(--dp-text-primary)">Agenda & Absensi</h3>
            <p class="text-sm" style="color: var(--dp-text-secondary)">Kelola jadwal & presensi rapat dan pelaksanaan.</p>
            @php
                $rapatCount       = $proker->absensis->where('jenis', 'rapat_panitia')->count();
                $pelaksanaanCount = $proker->absensis->where('jenis', 'pelaksanaan')->count();
            @endphp
            @if($rapatCount + $pelaksanaanCount > 0)
                <span class="inline-block mt-3 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-widest"
                      style="background: var(--dp-gold-tint); color: var(--dp-gold)">
                    {{ $rapatCount }} Rapat · {{ $pelaksanaanCount }} Sesi
                </span>
            @endif
        </a>

        {{-- 3. Form Pendaftaran --}}
        @php $formPendaftaran = $proker->formKegiatan; @endphp
        @if(!$formPendaftaran)
        {{-- Belum ada form: tombol ke halaman buat --}}
        <a href="{{ route('dashboard.form-kegiatan.create', ['proker_id' => $proker->id]) }}"
           class="group block p-6 rounded-2xl transition-all hover:-translate-y-1"
           style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4"
                 style="background: var(--dp-bg-surface-2); color: var(--dp-text-secondary)">
                <span class="material-symbols-outlined text-2xl">how_to_reg</span>
            </div>
            <h3 class="font-bold text-base mb-1" style="color: var(--dp-text-primary)">Form Pendaftaran</h3>
            <p class="text-sm mb-4" style="color: var(--dp-text-secondary)">
                Belum ada form. Klik untuk membuat form pendaftaran peserta.
            </p>
            <span class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1.5 rounded-lg"
                  style="background: var(--dp-primary-tint); color: var(--dp-bg-primary)">
                <span class="material-symbols-outlined text-sm">add</span>
                Buat Form
            </span>
        </a>
        @else
        {{-- Sudah ada form: ringkasan + link ke halaman kelola --}}
        <div x-data="{ isOpen: {{ $formPendaftaran->is_open ? 'true' : 'false' }} }"
             class="block p-6 rounded-2xl"
             style="background: var(--dp-bg-surface); border: 1.5px solid var(--dp-border-gold);">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                     style="background: var(--dp-gold-tint); color: var(--dp-gold)">
                    <span class="material-symbols-outlined text-2xl">how_to_reg</span>
                </div>
                <span class="text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-widest"
                      :style="isOpen
                        ? 'background: var(--dp-primary-tint); color: var(--dp-bg-primary)'
                        : 'background: var(--dp-danger-tint); color: var(--dp-danger)'"
                      x-text="isOpen ? '● Buka' : '● Tutup'">
                </span>
            </div>
            <h3 class="font-bold text-base mb-1" style="color: var(--dp-text-primary)">Form Pendaftaran</h3>
            <p class="text-sm mb-4" style="color: var(--dp-text-secondary)">
                <span class="font-black" style="color: var(--dp-text-primary)">
                    {{ $formPendaftaran->peserta()->count() }}
                </span> pendaftar terdaftar
            </p>
            <a href="{{ route('dashboard.form-kegiatan.show', $formPendaftaran->id) }}"
               class="flex items-center gap-2 w-full py-2 px-3 rounded-lg text-xs font-bold transition-colors"
               style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary)">
                <span class="material-symbols-outlined text-sm">open_in_new</span>
                Kelola Form
            </a>
        </div>
        @endif

        {{-- 4. Upload LPJ --}}
        <div x-data="{ openLpj: false }">
            <button @click="{{ $proker->isStep5Locked() ? '' : 'openLpj = true' }}"
                    class="w-full text-left p-6 rounded-2xl transition-all {{ $proker->isStep5Locked() ? 'cursor-not-allowed' : 'hover:-translate-y-1' }}"
                    style="background: var(--dp-bg-surface);
                           border: 1.5px solid {{ $proker->current_step >= 6 ? 'var(--dp-gold)' : 'var(--dp-border)' }};
                           opacity: {{ $proker->isStep5Locked() ? '0.45' : '1' }};">
                <div class="flex justify-between items-start">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4"
                         style="background: {{ $proker->isStep5Locked() ? 'var(--dp-bg-surface-2)' : 'var(--dp-primary-tint)' }};
                                color: {{ $proker->isStep5Locked() ? 'var(--dp-text-secondary)' : 'var(--dp-bg-primary)' }}">
                        <span class="material-symbols-outlined text-2xl">upload_file</span>
                    </div>
                    @if($proker->isStep5Locked())
                        <span class="material-symbols-outlined text-sm" style="color: var(--dp-text-secondary)">lock</span>
                    @endif
                </div>
                <h3 class="font-bold text-base mb-1" style="color: var(--dp-text-primary)">Upload LPJ</h3>
                <p class="text-sm" style="color: var(--dp-text-secondary)">
                    @if($proker->isStep5Locked())
                        Memerlukan sesi pelaksanaan yang ditutup.
                    @else
                        Unggah laporan pertanggungjawaban.
                    @endif
                </p>
                @if($proker->path_lpj && $proker->current_step == 6)
                    <span class="inline-block mt-3 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-widest"
                          style="background: var(--dp-gold-tint); color: var(--dp-gold); border: 1px solid var(--dp-border-gold)">
                        Menunggu Verifikasi
                    </span>
                @elseif($proker->status_pelaksanaan == 'Selesai')
                    <span class="inline-block mt-3 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-widest"
                          style="background: var(--dp-primary-tint); color: var(--dp-bg-primary)">
                        Terverifikasi ✓
                    </span>
                @endif
            </button>

            {{-- LPJ Modal — Fixed overlay, tidak terpengaruh overflow hidden --}}
            <div x-show="openLpj"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 flex items-center justify-center z-50 px-4"
                 style="background: rgba(0,0,0,0.55);"
                 @click.self="openLpj = false"
                 x-cloak>
                <div class="w-full max-w-md rounded-2xl p-6 shadow-2xl"
                     style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h3 class="font-bold text-base font-display" style="color: var(--dp-text-primary)">
                                Upload LPJ
                            </h3>
                            <p class="text-xs mt-0.5" style="color: var(--dp-text-secondary)">
                                {{ $proker->nama_proker }}
                            </p>
                        </div>
                        <button @click="openLpj = false"
                                class="p-1 rounded-lg transition-colors"
                                style="color: var(--dp-text-secondary)">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                    <form action="{{ route('dashboard.departemen.proker.lpj.update', $proker->id) }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        <label class="block text-xs font-bold mb-1" style="color: var(--dp-text-secondary)">
                            File LPJ (PDF, maks. 5MB)
                        </label>
                        <input type="file" name="lpj_path" accept=".pdf" required
                               class="w-full text-xs mb-5 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold"
                               style="color: var(--dp-text-secondary)">
                        <div class="flex gap-3">
                            <button type="button" @click="openLpj = false"
                                    class="flex-1 py-2.5 rounded-xl text-sm font-bold transition-colors"
                                    style="background: var(--dp-bg-surface-2); color: var(--dp-text-secondary); border: 1px solid var(--dp-border)">
                                Batal
                            </button>
                            <button type="submit"
                                    class="flex-1 py-2.5 rounded-xl text-sm font-bold transition-colors"
                                    style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary)">
                                Upload & Ajukan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
