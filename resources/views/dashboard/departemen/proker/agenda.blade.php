@extends('layouts.dashboard')

@section('title', 'Agenda & Absensi - ' . $proker->nama_proker)

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('dashboard.departemen.proker.show', $proker->id) }}"
            class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-white/10 transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="text-2xl font-bold font-display" style="color: var(--dp-text-primary)">Agenda & Absensi</h1>
            <p class="text-sm mt-0.5" style="color: var(--dp-text-secondary)">{{ $proker->nama_proker }}</p>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold"
             style="background: rgba(8,51,44,0.08); color: var(--dp-bg-primary); border: 1px solid var(--dp-border);">
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

    {{-- ============================================================ --}}
    {{-- SECTION 1: RAPAT PANITIA --}}
    {{-- ============================================================ --}}
    <section>
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-bold font-display" style="color: var(--dp-text-primary)">
                    Rapat Panitia
                </h2>
                <p class="text-xs mt-0.5" style="color: var(--dp-text-secondary)">
                    Rapat persiapan sebelum pelaksanaan kegiatan
                </p>
            </div>
            @if($proker->isStep1Complete())
                <span class="text-xs font-bold px-3 py-1 rounded-full"
                      style="background: var(--dp-primary-tint); color: var(--dp-bg-primary)">
                    {{ $proker->absensis->where('jenis', 'rapat_panitia')->count() }} Rapat
                </span>
            @endif
        </div>

        {{-- Tambah Rapat Panitia --}}
        @if($proker->isStep1Complete())
            @if($proker->canCreateNewRapatPanitia())
                <div class="rounded-xl p-5 mb-4"
                     style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                    <h3 class="text-sm font-bold mb-3" style="color: var(--dp-text-primary)">Buat Rapat Baru</h3>
                    <form action="{{ route('dashboard.departemen.proker.agenda.store', $proker->id) }}"
                          method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @csrf
                        <input type="hidden" name="jenis" value="rapat_panitia">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold mb-1" style="color: var(--dp-text-secondary)">
                                Nama Rapat
                            </label>
                            <input type="text" name="judul" required
                                   placeholder="Contoh: Rapat Koordinasi I, Technical Meeting, dll."
                                   class="w-full px-3 py-2 rounded-lg text-sm outline-none"
                                   style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
                        </div>
                        <div>
                            <label class="block text-xs font-bold mb-1" style="color: var(--dp-text-secondary)">
                                Tanggal & Waktu
                            </label>
                            <input type="datetime-local" name="tgl_waktu" required
                                   class="w-full px-3 py-2 rounded-lg text-sm outline-none"
                                   style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
                        </div>
                        <div class="flex items-end">
                            <button type="submit"
                                    class="w-full px-4 py-2 rounded-lg text-sm font-bold transition-colors"
                                    style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);">
                                <span class="material-symbols-outlined text-sm align-middle mr-1">add</span>
                                Buat Rapat
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="flex items-start gap-3 px-4 py-3 rounded-xl mb-4 text-sm"
                     style="background: rgba(186,158,111,0.10); border: 1px solid var(--dp-border-gold); color: var(--dp-text-primary);">
                    <span class="material-symbols-outlined text-base mt-0.5" style="color: var(--dp-gold)">lock</span>
                    <div>
                        <p class="font-bold" style="color: var(--dp-gold)">Rapat baru terkunci</p>
                        <p class="text-xs mt-0.5" style="color: var(--dp-text-secondary)">
                            Tutup semua rapat yang masih buka dan upload notulensi untuk setiap rapat sebelum membuat rapat baru.
                        </p>
                    </div>
                </div>
            @endif
        @else
            <div class="flex items-start gap-3 px-4 py-3 rounded-xl mb-4 text-sm"
                 style="background: var(--dp-bg-surface); border: 1px dashed var(--dp-border-strong); color: var(--dp-text-secondary);">
                <span class="material-symbols-outlined text-base mt-0.5">info</span>
                <p>Bentuk kepanitiaan terlebih dahulu sebelum menjadwalkan rapat.</p>
            </div>
        @endif

        {{-- List Rapat Panitia --}}
        @php $rapatPanitia = $proker->absensis->where('jenis', 'rapat_panitia'); @endphp
        @if($rapatPanitia->count() > 0)
            <div class="space-y-3">
                @foreach($rapatPanitia as $agenda)
                    @php
                        $isClosed = $agenda->status === 'tutup';
                        $hasNotulensi = !empty($agenda->notulensi_path);
                        $needsAttention = $isClosed && !$hasNotulensi;
                    @endphp
                    <div x-data="{ showQr: false, showUpload: false }"
                         class="rounded-xl overflow-hidden transition-all"
                         style="background: var(--dp-bg-surface);
                                border: 1.5px solid {{ $needsAttention ? 'var(--dp-danger)' : 'var(--dp-border)' }};">

                        {{-- Card Header --}}
                        <div class="flex gap-4 p-4 items-start">
                            {{-- Date Box --}}
                            <div class="w-14 h-14 rounded-xl flex flex-col items-center justify-center shrink-0"
                                 style="background: var(--dp-primary-tint);">
                                <span class="text-[10px] font-bold uppercase" style="color: var(--dp-text-secondary)">
                                    {{ $agenda->tgl_waktu->format('M') }}
                                </span>
                                <span class="text-xl font-bold font-display" style="color: var(--dp-bg-primary)">
                                    {{ $agenda->tgl_waktu->format('d') }}
                                </span>
                            </div>

                            {{-- Info --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    @if($isClosed)
                                        <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded"
                                              style="background: var(--dp-primary-tint); color: var(--dp-bg-primary)">
                                            Tutup
                                        </span>
                                    @else
                                        <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded"
                                              style="background: rgba(16,185,129,0.12); color: #059669">
                                            Buka
                                        </span>
                                    @endif
                                    @if($hasNotulensi)
                                        <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded"
                                              style="background: var(--dp-gold-tint); color: var(--dp-gold)">
                                            Ada Notulensi
                                        </span>
                                    @elseif($needsAttention)
                                        <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded"
                                              style="background: var(--dp-danger-tint); color: var(--dp-danger)">
                                            Notulensi Belum Diupload
                                        </span>
                                    @endif
                                </div>
                                <h3 class="font-bold text-base truncate" style="color: var(--dp-text-primary)">
                                    {{ $agenda->judul }}
                                </h3>
                                <p class="text-xs mt-0.5" style="color: var(--dp-text-secondary)">
                                    <span class="material-symbols-outlined text-xs align-middle">schedule</span>
                                    {{ $agenda->tgl_waktu->format('H:i') }} WIB
                                    @if($agenda->lokasi)
                                        <span class="mx-1">·</span>
                                        {{ $agenda->lokasi }}
                                    @endif
                                </p>
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center gap-1 shrink-0">
                                {{-- QR Button --}}
                                @if($agenda->isOpen())
                                    <button @click="showQr = !showQr"
                                            class="p-2 rounded-lg transition-colors text-sm"
                                            style="color: var(--dp-text-secondary)"
                                            title="Tampilkan QR Absensi">
                                        <span class="material-symbols-outlined text-xl">qr_code_2</span>
                                    </button>
                                @endif

                                {{-- Notulensi Download --}}
                                @if($hasNotulensi)
                                    <a href="{{ Storage::url($agenda->notulensi_path) }}" target="_blank"
                                       class="p-2 rounded-lg transition-colors"
                                       style="color: var(--dp-gold)"
                                       title="Unduh Notulensi">
                                        <span class="material-symbols-outlined text-xl">description</span>
                                    </a>
                                @endif

                                {{-- Upload Notulensi Toggle --}}
                                @if($isClosed && !$hasNotulensi)
                                    <button @click="showUpload = !showUpload"
                                            class="p-2 rounded-lg transition-colors"
                                            style="color: var(--dp-danger)"
                                            title="Upload Notulensi">
                                        <span class="material-symbols-outlined text-xl">upload_file</span>
                                    </button>
                                @elseif($isClosed && $hasNotulensi)
                                    <button @click="showUpload = !showUpload"
                                            class="p-2 rounded-lg transition-colors"
                                            style="color: var(--dp-text-secondary)"
                                            title="Ganti Notulensi">
                                        <span class="material-symbols-outlined text-xl">upload_file</span>
                                    </button>
                                @endif

                                {{-- Close Button --}}
                                @if($agenda->isOpen())
                                    <form action="{{ route('dashboard.departemen.proker.agenda.close', [$proker->id, $agenda->id]) }}"
                                          method="POST" onsubmit="return confirm('Tutup sesi rapat ini? Absensi tidak dapat ditambah setelah ditutup.')">
                                        @csrf
                                        <button type="submit"
                                                class="p-2 rounded-lg transition-colors"
                                                style="color: var(--dp-text-secondary)"
                                                title="Tutup Sesi">
                                            <span class="material-symbols-outlined text-xl">lock</span>
                                        </button>
                                    </form>
                                @endif

                                {{-- Delete --}}
                                <form action="{{ route('dashboard.departemen.proker.agenda.destroy', [$proker->id, $agenda->id]) }}"
                                      method="POST" onsubmit="return confirm('Hapus agenda ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-2 rounded-lg transition-colors"
                                            style="color: var(--dp-danger)"
                                            title="Hapus">
                                        <span class="material-symbols-outlined text-xl">delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Warning Strip (notulensi belum upload) --}}
                        @if($needsAttention)
                            <div class="px-4 py-2 flex items-center gap-2 text-xs font-semibold"
                                 style="background: var(--dp-danger-tint); color: var(--dp-danger);">
                                <span class="material-symbols-outlined text-sm">warning</span>
                                Rapat ini ditutup tanpa notulensi — upload notulensi agar rapat berikutnya bisa dibuat.
                                <button @click="showUpload = true"
                                        class="ml-auto underline font-bold">
                                    Upload Sekarang
                                </button>
                            </div>
                        @endif

                        {{-- QR Panel (inline collapse) --}}
                        <div x-show="showQr" x-transition
                             class="border-t px-6 py-5"
                             style="border-color: var(--dp-border); background: var(--dp-bg-surface-2);">
                            <div class="flex flex-col items-center gap-3">
                                <p class="text-xs font-bold uppercase tracking-widest" style="color: var(--dp-text-secondary)">
                                    QR Code Absensi
                                </p>
                                <div class="w-48 h-48 bg-white rounded-xl p-3 shadow-sm">
                                    {!! $qrSvgs[$agenda->id] ?? '' !!}
                                </div>
                                <div class="text-center">
                                    <p class="text-[10px] font-bold uppercase tracking-widest mb-1" style="color: var(--dp-text-secondary)">
                                        Kode Akses
                                    </p>
                                    <p class="font-display font-bold text-3xl tracking-widest" style="color: var(--dp-bg-primary)">
                                        {{ $agenda->kode_akses }}
                                    </p>
                                </div>
                                <div class="w-full max-w-xs">
                                    <p class="text-[10px] font-bold uppercase tracking-widest mb-1" style="color: var(--dp-text-secondary)">
                                        Link Scan
                                    </p>
                                    <div class="flex items-center gap-2">
                                        <input type="text" readonly
                                               value="{{ route('absensi.scan', $agenda->kode_akses) }}"
                                               id="scan-url-{{ $agenda->id }}"
                                               class="flex-1 px-3 py-2 rounded-lg text-xs outline-none truncate"
                                               style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border); color: var(--dp-text-secondary);">
                                        <button type="button"
                                                onclick="document.getElementById('scan-url-{{ $agenda->id }}').select(); document.execCommand('copy');"
                                                class="px-3 py-2 rounded-lg text-xs font-bold transition-colors"
                                                style="background: var(--dp-primary-tint); color: var(--dp-bg-primary)">
                                            Salin
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Upload Notulensi Panel --}}
                        <div x-show="showUpload" x-transition
                             class="border-t px-5 py-4"
                             style="border-color: var(--dp-border); background: var(--dp-bg-surface-2);">
                            <form action="{{ route('dashboard.departemen.proker.agenda.notulensi', [$proker->id, $agenda->id]) }}"
                                  method="POST" enctype="multipart/form-data"
                                  class="flex items-center gap-3">
                                @csrf
                                <div class="flex-1">
                                    <label class="block text-xs font-bold mb-1" style="color: var(--dp-text-secondary)">
                                        {{ $hasNotulensi ? 'Ganti Notulensi' : 'Upload Notulensi' }}
                                    </label>
                                    <input type="file" name="notulensi" required accept=".pdf,.doc,.docx"
                                           class="w-full text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold"
                                           style="color: var(--dp-text-secondary)">
                                </div>
                                <button type="submit"
                                        class="shrink-0 px-4 py-2 rounded-lg text-sm font-bold mt-4 transition-colors"
                                        style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary)">
                                    Upload
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-10 rounded-xl"
                 style="background: var(--dp-bg-surface); border: 1px dashed var(--dp-border-strong); color: var(--dp-text-secondary)">
                <span class="material-symbols-outlined text-4xl mb-2">event_busy</span>
                <p class="text-sm">Belum ada rapat panitia.</p>
            </div>
        @endif
    </section>

    {{-- ============================================================ --}}
    {{-- SECTION 2: SESI PELAKSANAAN --}}
    {{-- ============================================================ --}}
    <section>
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-bold font-display" style="color: var(--dp-text-primary)">
                    Sesi Pelaksanaan
                </h2>
                <p class="text-xs mt-0.5" style="color: var(--dp-text-secondary)">
                    Sesi kegiatan hari-H
                </p>
            </div>
            @php $pelaksanaanCount = $proker->absensis->where('jenis', 'pelaksanaan')->count(); @endphp
            @if($pelaksanaanCount > 0)
                <span class="text-xs font-bold px-3 py-1 rounded-full"
                      style="background: var(--dp-primary-tint); color: var(--dp-bg-primary)">
                    {{ $pelaksanaanCount }} Sesi
                </span>
            @endif
        </div>

        {{-- Tambah Sesi Pelaksanaan --}}
        @if($proker->canProceedToPelaksanaan())
            <div class="rounded-xl p-5 mb-4"
                 style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                <h3 class="text-sm font-bold mb-3" style="color: var(--dp-text-primary)">Buat Sesi Baru</h3>
                <form action="{{ route('dashboard.departemen.proker.agenda.store', $proker->id) }}"
                      method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @csrf
                    <input type="hidden" name="jenis" value="pelaksanaan">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold mb-1" style="color: var(--dp-text-secondary)">
                            Nama Sesi
                        </label>
                        <input type="text" name="judul" required
                               placeholder="Contoh: Hari Pertama — Pembukaan, Sesi Materi I, dll."
                               class="w-full px-3 py-2 rounded-lg text-sm outline-none"
                               style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
                    </div>
                    <div>
                        <label class="block text-xs font-bold mb-1" style="color: var(--dp-text-secondary)">
                            Tanggal & Waktu
                        </label>
                        <input type="datetime-local" name="tgl_waktu" required
                               class="w-full px-3 py-2 rounded-lg text-sm outline-none"
                               style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                                class="w-full px-4 py-2 rounded-lg text-sm font-bold transition-colors"
                                style="background: var(--dp-gold); color: var(--dp-bg-primary);">
                            <span class="material-symbols-outlined text-sm align-middle mr-1">add</span>
                            Buat Sesi
                        </button>
                    </div>
                </form>
            </div>
        @else
            @php
                $lockReason = !$proker->isStep1Complete()
                    ? 'Kepanitiaan belum dibentuk.'
                    : 'Masih ada rapat panitia yang belum ditutup atau belum memiliki notulensi.';
            @endphp
            <div class="flex items-start gap-3 px-4 py-3 rounded-xl mb-4 text-sm"
                 style="background: var(--dp-bg-surface); border: 1px dashed var(--dp-border-strong);">
                <span class="material-symbols-outlined text-base mt-0.5" style="color: var(--dp-text-secondary)">lock</span>
                <div>
                    <p class="font-bold" style="color: var(--dp-text-primary)">Sesi Pelaksanaan terkunci</p>
                    <p class="text-xs mt-0.5" style="color: var(--dp-text-secondary)">{{ $lockReason }}</p>
                </div>
            </div>
        @endif

        {{-- List Sesi Pelaksanaan --}}
        @php $pelaksanaan = $proker->absensis->where('jenis', 'pelaksanaan'); @endphp
        @if($pelaksanaan->count() > 0)
            <div class="space-y-3">
                @foreach($pelaksanaan as $agenda)
                    @php
                        $isClosed = $agenda->status === 'tutup';
                        $hasNotulensi = !empty($agenda->notulensi_path);
                        $needsAttention = $isClosed && !$hasNotulensi;
                    @endphp
                    <div x-data="{ showQr: false, showUpload: false }"
                         class="rounded-xl overflow-hidden transition-all"
                         style="background: var(--dp-bg-surface);
                                border: 1.5px solid {{ $needsAttention ? 'var(--dp-danger)' : 'var(--dp-border)' }};">

                        {{-- Card Header --}}
                        <div class="flex gap-4 p-4 items-start">
                            {{-- Date Box (gold accent for pelaksanaan) --}}
                            <div class="w-14 h-14 rounded-xl flex flex-col items-center justify-center shrink-0"
                                 style="background: var(--dp-gold-tint);">
                                <span class="text-[10px] font-bold uppercase" style="color: var(--dp-gold)">
                                    {{ $agenda->tgl_waktu->format('M') }}
                                </span>
                                <span class="text-xl font-bold font-display" style="color: var(--dp-gold)">
                                    {{ $agenda->tgl_waktu->format('d') }}
                                </span>
                            </div>

                            {{-- Info --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    @if($isClosed)
                                        <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded"
                                              style="background: var(--dp-primary-tint); color: var(--dp-bg-primary)">
                                            Selesai
                                        </span>
                                    @else
                                        <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded"
                                              style="background: rgba(16,185,129,0.12); color: #059669">
                                            Berjalan
                                        </span>
                                    @endif
                                    @if($hasNotulensi)
                                        <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded"
                                              style="background: var(--dp-gold-tint); color: var(--dp-gold)">
                                            Ada Notulensi
                                        </span>
                                    @elseif($needsAttention)
                                        <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded"
                                              style="background: var(--dp-danger-tint); color: var(--dp-danger)">
                                            Notulensi Belum Diupload
                                        </span>
                                    @endif
                                </div>
                                <h3 class="font-bold text-base truncate" style="color: var(--dp-text-primary)">
                                    {{ $agenda->judul }}
                                </h3>
                                <p class="text-xs mt-0.5" style="color: var(--dp-text-secondary)">
                                    <span class="material-symbols-outlined text-xs align-middle">schedule</span>
                                    {{ $agenda->tgl_waktu->format('H:i') }} WIB
                                    @if($agenda->lokasi)
                                        <span class="mx-1">·</span>
                                        {{ $agenda->lokasi }}
                                    @endif
                                </p>
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center gap-1 shrink-0">
                                @if($agenda->isOpen())
                                    <button @click="showQr = !showQr"
                                            class="p-2 rounded-lg transition-colors"
                                            style="color: var(--dp-text-secondary)"
                                            title="Tampilkan QR Absensi">
                                        <span class="material-symbols-outlined text-xl">qr_code_2</span>
                                    </button>
                                @endif

                                @if($hasNotulensi)
                                    <a href="{{ Storage::url($agenda->notulensi_path) }}" target="_blank"
                                       class="p-2 rounded-lg transition-colors"
                                       style="color: var(--dp-gold)"
                                       title="Unduh Notulensi">
                                        <span class="material-symbols-outlined text-xl">description</span>
                                    </a>
                                @endif

                                @if($isClosed)
                                    <button @click="showUpload = !showUpload"
                                            class="p-2 rounded-lg transition-colors"
                                            style="color: {{ $needsAttention ? 'var(--dp-danger)' : 'var(--dp-text-secondary)' }}"
                                            title="{{ $hasNotulensi ? 'Ganti Notulensi' : 'Upload Notulensi' }}">
                                        <span class="material-symbols-outlined text-xl">upload_file</span>
                                    </button>
                                @endif

                                @if($agenda->isOpen())
                                    <form action="{{ route('dashboard.departemen.proker.agenda.close', [$proker->id, $agenda->id]) }}"
                                          method="POST" onsubmit="return confirm('Tutup sesi ini? Absensi tidak dapat ditambah setelah ditutup.')">
                                        @csrf
                                        <button type="submit"
                                                class="p-2 rounded-lg transition-colors"
                                                style="color: var(--dp-text-secondary)"
                                                title="Tutup Sesi">
                                            <span class="material-symbols-outlined text-xl">lock</span>
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('dashboard.departemen.proker.agenda.destroy', [$proker->id, $agenda->id]) }}"
                                      method="POST" onsubmit="return confirm('Hapus sesi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-2 rounded-lg transition-colors"
                                            style="color: var(--dp-danger)"
                                            title="Hapus">
                                        <span class="material-symbols-outlined text-xl">delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Warning Strip --}}
                        @if($needsAttention)
                            <div class="px-4 py-2 flex items-center gap-2 text-xs font-semibold"
                                 style="background: var(--dp-danger-tint); color: var(--dp-danger);">
                                <span class="material-symbols-outlined text-sm">warning</span>
                                Sesi ini selesai tanpa notulensi.
                                <button @click="showUpload = true"
                                        class="ml-auto underline font-bold">
                                    Upload Sekarang
                                </button>
                            </div>
                        @endif

                        {{-- QR Panel --}}
                        <div x-show="showQr" x-transition
                             class="border-t px-6 py-5"
                             style="border-color: var(--dp-border); background: var(--dp-bg-surface-2);">
                            <div class="flex flex-col items-center gap-3">
                                <p class="text-xs font-bold uppercase tracking-widest" style="color: var(--dp-text-secondary)">
                                    QR Code Absensi
                                </p>
                                <div class="w-48 h-48 bg-white rounded-xl p-3 shadow-sm">
                                    {!! $qrSvgs[$agenda->id] ?? '' !!}
                                </div>
                                <div class="text-center">
                                    <p class="text-[10px] font-bold uppercase tracking-widest mb-1" style="color: var(--dp-text-secondary)">
                                        Kode Akses
                                    </p>
                                    <p class="font-display font-bold text-3xl tracking-widest" style="color: var(--dp-gold)">
                                        {{ $agenda->kode_akses }}
                                    </p>
                                </div>
                                <div class="w-full max-w-xs">
                                    <div class="flex items-center gap-2">
                                        <input type="text" readonly
                                               value="{{ route('absensi.scan', $agenda->kode_akses) }}"
                                               id="scan-url-{{ $agenda->id }}"
                                               class="flex-1 px-3 py-2 rounded-lg text-xs outline-none truncate"
                                               style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border); color: var(--dp-text-secondary);">
                                        <button type="button"
                                                onclick="document.getElementById('scan-url-{{ $agenda->id }}').select(); document.execCommand('copy');"
                                                class="px-3 py-2 rounded-lg text-xs font-bold"
                                                style="background: var(--dp-gold-tint); color: var(--dp-gold)">
                                            Salin
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Upload Notulensi Panel --}}
                        <div x-show="showUpload" x-transition
                             class="border-t px-5 py-4"
                             style="border-color: var(--dp-border); background: var(--dp-bg-surface-2);">
                            <form action="{{ route('dashboard.departemen.proker.agenda.notulensi', [$proker->id, $agenda->id]) }}"
                                  method="POST" enctype="multipart/form-data"
                                  class="flex items-center gap-3">
                                @csrf
                                <div class="flex-1">
                                    <label class="block text-xs font-bold mb-1" style="color: var(--dp-text-secondary)">
                                        {{ $hasNotulensi ? 'Ganti Notulensi' : 'Upload Notulensi' }} (PDF/DOC, max 3MB)
                                    </label>
                                    <input type="file" name="notulensi" required accept=".pdf,.doc,.docx"
                                           class="w-full text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold"
                                           style="color: var(--dp-text-secondary)">
                                </div>
                                <button type="submit"
                                        class="shrink-0 px-4 py-2 rounded-lg text-sm font-bold mt-4 transition-colors"
                                        style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary)">
                                    Upload
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-10 rounded-xl"
                 style="background: var(--dp-bg-surface); border: 1px dashed var(--dp-border-strong); color: var(--dp-text-secondary)">
                <span class="material-symbols-outlined text-4xl mb-2">play_circle</span>
                <p class="text-sm">Belum ada sesi pelaksanaan.</p>
            </div>
        @endif
    </section>

</div>
@endsection
