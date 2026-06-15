@extends('layouts.dashboard')

@section('title', 'Detail Sesi Absensi')

@section('content')

@php
    $jenisLabels = [
        'rapat_rutin' => 'Rapat Rutin',
        'rapat_departemen' => 'Rapat Departemen',
        'rapat_panitia' => 'Rapat Panitia',
        'pelaksanaan' => 'Pelaksanaan Kegiatan',
        'rapat_pac' => 'Rapat PAC',
        'rapat_lembaga' => 'Rapat Lembaga',
        'rapat_badan' => 'Rapat Badan',
    ];
    $isOpen = $absensi->status === 'buka';
@endphp

{{-- Header --}}
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
    <div>
        <a href="{{ route('dashboard.kaderisasi.absensi.index') }}"
           class="inline-flex items-center gap-1.5 text-sm mb-3 transition-colors"
           style="color: var(--dp-text-secondary);"
           onmouseover="this.style.color='var(--dp-bg-primary)'"
           onmouseout="this.style.color='var(--dp-text-secondary)'">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            Kembali ke Daftar
        </a>
        <h1 class="font-display font-bold text-2xl mb-2" style="color: var(--dp-text-primary);">
            {{ $absensi->judul }}
        </h1>
        <div class="flex items-center gap-2 flex-wrap">
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider"
                  style="background: var(--dp-bg-surface-2); color: var(--dp-text-secondary);">
                {{ $jenisLabels[$absensi->jenis] ?? $absensi->jenis }}
            </span>
            @if($isOpen)
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider"
                      style="background: rgba(8,51,44,0.10); color: var(--dp-status-done);">
                    <span class="w-1.5 h-1.5 rounded-full animate-pulse" style="background: var(--dp-status-done);"></span>
                    Aktif
                </span>
            @else
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider"
                      style="background: var(--dp-gold-tint); color: var(--dp-gold);">
                    Selesai
                </span>
            @endif
        </div>
    </div>
    <div class="flex items-center gap-2">
        @if($isOpen)
            <form action="{{ route('dashboard.kaderisasi.absensi.close', $absensi->id) }}" method="POST"
                  onsubmit="return confirm('Tutup sesi absensi ini? Peserta tidak bisa scan lagi.');">
                @csrf
                @method('PATCH')
                <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-semibold transition-colors"
                        style="background: var(--dp-danger-tint); border: 1px solid var(--dp-danger); color: var(--dp-danger);"
                        onmouseover="this.style.background='var(--dp-danger)'; this.style.color='#fff'"
                        onmouseout="this.style.background='var(--dp-danger-tint)'; this.style.color='var(--dp-danger)'">
                    <span class="material-symbols-outlined text-lg">lock</span>
                    Tutup Sesi
                </button>
            </form>
        @else
            <form action="{{ route('dashboard.kaderisasi.absensi.reopen', $absensi->id) }}" method="POST"
                  onsubmit="return confirm('Buka kembali sesi ini?');">
                @csrf
                @method('PATCH')
                <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-semibold transition-colors"
                        style="background: var(--dp-primary-tint); border: 1px solid var(--dp-border-strong); color: var(--dp-bg-primary);"
                        onmouseover="this.style.background='var(--dp-bg-primary)'; this.style.color='var(--dp-text-on-primary)'"
                        onmouseout="this.style.background='var(--dp-primary-tint)'; this.style.color='var(--dp-bg-primary)'">
                    <span class="material-symbols-outlined text-lg">lock_open</span>
                    Buka Kembali
                </button>
            </form>
        @endif
    </div>
</div>

{{-- Alert --}}
@if(session('success'))
    <div class="mb-4 px-4 py-3 rounded-lg flex items-center gap-3 text-sm"
         style="background: var(--dp-primary-tint); border: 1px solid var(--dp-border-strong); color: var(--dp-text-primary);">
        <span class="material-symbols-outlined text-lg shrink-0" style="color: var(--dp-status-done);">check_circle</span>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 px-4 py-3 rounded-lg flex items-center gap-3 text-sm"
         style="background: var(--dp-danger-tint); border: 1px solid var(--dp-danger); color: var(--dp-danger);">
        <span class="material-symbols-outlined text-lg shrink-0">error</span>
        {{ session('error') }}
    </div>
@endif

{{-- Info Bar --}}
<div class="rounded-xl p-4 mb-6 flex flex-wrap gap-x-6 gap-y-2"
     style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
    @if($absensi->departemen)
        <div class="flex items-center gap-2 text-sm">
            <span class="material-symbols-outlined text-base" style="color: var(--dp-text-secondary);">corporate_fare</span>
            <span style="color: var(--dp-text-secondary);">{{ $absensi->departemen->nama }}</span>
        </div>
    @endif
    <div class="flex items-center gap-2 text-sm">
        <span class="material-symbols-outlined text-base" style="color: var(--dp-text-secondary);">calendar_today</span>
        <span style="color: var(--dp-text-secondary);">{{ $absensi->tanggal ? \Carbon\Carbon::parse($absensi->tanggal)->format('d M Y, H:i') : '-' }}</span>
    </div>
    @if($absensi->lokasi)
        <div class="flex items-center gap-2 text-sm">
            <span class="material-symbols-outlined text-base" style="color: var(--dp-text-secondary);">location_on</span>
            <span style="color: var(--dp-text-secondary);">{{ $absensi->lokasi }}</span>
        </div>
    @endif
    <div class="flex items-center gap-2 text-sm">
        <span class="material-symbols-outlined text-base" style="color: var(--dp-text-secondary);">person</span>
        <span style="color: var(--dp-text-secondary);">{{ $absensi->creator->name ?? '-' }}</span>
    </div>
    @if($absensi->programKerja)
        <div class="flex items-center gap-2 text-sm">
            <span class="material-symbols-outlined text-base" style="color: var(--dp-gold);">link</span>
            <span style="color: var(--dp-gold);">{{ $absensi->programKerja->nama }}</span>
        </div>
    @endif
</div>

{{-- Two Column Layout --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="absensiLive('{{ $absensi->id }}', '{{ $absensi->status }}')">

    {{-- Left: QR Panel --}}
    <div class="lg:col-span-1 space-y-5">

        {{-- QR Code Card --}}
        <div class="rounded-xl p-5 relative overflow-hidden"
             style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
            <h3 class="font-display font-bold text-base mb-4 text-center" style="color: var(--dp-text-primary);">
                QR Code Absensi
            </h3>

            <div class="relative mx-auto" style="max-width: 240px;">
                <div class="w-full aspect-square flex items-center justify-center rounded-xl p-4"
                     style="background: #ffffff;">
                    {!! $qrSvg !!}
                </div>

                @if(!$isOpen)
                    <div class="absolute inset-0 rounded-xl flex flex-col items-center justify-center"
                         style="background: rgba(0,0,0,0.7); backdrop-filter: blur(4px);">
                        <span class="material-symbols-outlined text-4xl mb-2" style="color: var(--dp-danger);">lock</span>
                        <span class="text-sm font-bold" style="color: #ffffff;">Sesi Ditutup</span>
                    </div>
                @endif
            </div>

            {{-- Kode Akses --}}
            <div class="mt-4 text-center">
                <p class="text-[10px] font-bold uppercase tracking-widest mb-1" style="color: var(--dp-text-secondary);">Kode Akses</p>
                <p class="font-display font-bold text-2xl tracking-widest" style="color: var(--dp-bg-primary);">
                    {{ $absensi->kode_akses }}
                </p>
            </div>

            {{-- Scan URL --}}
            <div class="mt-4" x-data="{ copied: false }">
                <p class="text-[10px] font-bold uppercase tracking-widest mb-1.5" style="color: var(--dp-text-secondary);">Link Absensi</p>
                <div class="flex items-center gap-2">
                    <input type="text" readonly
                           value="{{ route('absensi.scan', $absensi->kode_akses) }}"
                           id="scan-url"
                           class="flex-1 px-3 py-2 rounded-lg text-xs outline-none truncate"
                           style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-secondary);">
                    <button type="button"
                            @click="navigator.clipboard.writeText(document.getElementById('scan-url').value); copied = true; setTimeout(() => copied = false, 2000)"
                            class="p-2 rounded-lg transition-colors shrink-0"
                            style="background: var(--dp-primary-tint); color: var(--dp-bg-primary);"
                            onmouseover="this.style.background='var(--dp-bg-primary)'; this.style.color='var(--dp-text-on-primary)'"
                            onmouseout="this.style.background='var(--dp-primary-tint)'; this.style.color='var(--dp-bg-primary)'">
                        <span class="material-symbols-outlined text-lg" x-text="copied ? 'check' : 'content_copy'"></span>
                    </button>
                </div>
                <p class="text-[10px] mt-1 font-semibold" style="color: var(--dp-status-done);" x-show="copied" x-cloak>
                    Link berhasil disalin!
                </p>
            </div>

            {{-- Share Button --}}
            <button type="button"
                    onclick="if(navigator.share) { navigator.share({ title: '{{ $absensi->judul }}', url: '{{ route('absensi.scan', $absensi->kode_akses) }}' }); } else { document.getElementById('scan-url').select(); document.execCommand('copy'); }"
                    class="w-full mt-4 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-semibold transition-colors"
                    style="border: 1px solid var(--dp-border-gold); color: var(--dp-gold); background: var(--dp-gold-tint);"
                    onmouseover="this.style.background='var(--dp-gold)'; this.style.color='var(--dp-bg-primary)'"
                    onmouseout="this.style.background='var(--dp-gold-tint)'; this.style.color='var(--dp-gold)'">
                <span class="material-symbols-outlined text-lg">share</span>
                Bagikan Link
            </button>
        </div>

    </div>

    {{-- Right: Attendee List --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Mini Stats --}}
        <div class="grid grid-cols-3 gap-3">
            <div class="rounded-xl p-4 text-center" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                <p class="text-[10px] uppercase tracking-wider font-semibold mb-1" style="color: var(--dp-text-secondary);">Total Hadir</p>
                <p class="font-display text-2xl font-bold" style="color: var(--dp-text-primary);" x-text="hadir"></p>
            </div>
            <div class="rounded-xl p-4 text-center" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                <p class="text-[10px] uppercase tracking-wider font-semibold mb-1" style="color: var(--dp-text-secondary);">Kader</p>
                <p class="font-display text-2xl font-bold" style="color: var(--dp-status-done);" x-text="records.filter(r => r.tipe_peserta === 'kader').length"></p>
            </div>
            <div class="rounded-xl p-4 text-center" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                <p class="text-[10px] uppercase tracking-wider font-semibold mb-1" style="color: var(--dp-text-secondary);">Umum</p>
                <p class="font-display text-2xl font-bold" style="color: var(--dp-gold);" x-text="records.filter(r => r.tipe_peserta === 'umum').length"></p>
            </div>
        </div>

        {{-- Tabs + Table --}}
        <div class="rounded-xl overflow-hidden" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">

            {{-- Tab Header --}}
            <div class="flex items-center gap-0 px-4 pt-3" style="border-bottom: 1px solid var(--dp-border);">
                <button @click="tab = 'semua'"
                        :style="tab === 'semua' ? 'color: var(--dp-bg-primary); border-bottom: 2px solid var(--dp-bg-primary);' : 'color: var(--dp-text-secondary); border-bottom: 2px solid transparent;'"
                        class="px-4 pb-3 text-sm font-semibold transition-colors">
                    Semua (<span x-text="records.length"></span>)
                </button>
                <button @click="tab = 'kader'"
                        :style="tab === 'kader' ? 'color: var(--dp-bg-primary); border-bottom: 2px solid var(--dp-bg-primary);' : 'color: var(--dp-text-secondary); border-bottom: 2px solid transparent;'"
                        class="px-4 pb-3 text-sm font-semibold transition-colors">
                    Kader
                </button>
                <button @click="tab = 'umum'"
                        :style="tab === 'umum' ? 'color: var(--dp-bg-primary); border-bottom: 2px solid var(--dp-bg-primary);' : 'color: var(--dp-text-secondary); border-bottom: 2px solid transparent;'"
                        class="px-4 pb-3 text-sm font-semibold transition-colors">
                    Umum
                </button>
            </div>

            {{-- Table Header --}}
            <div class="hidden lg:grid grid-cols-[40px_1fr_80px_90px_80px_100px] items-center px-5 py-3 text-[10px] font-bold uppercase tracking-widest"
                 style="background: var(--dp-bg-surface-2); border-bottom: 1px solid var(--dp-border); color: var(--dp-text-secondary);">
                <span>No</span>
                <span>Nama</span>
                <span>Tipe</span>
                <span>Status</span>
                <span>Metode</span>
                <span class="text-right">Waktu</span>
            </div>

            {{-- Table Body --}}
            <div class="divide-y" style="border-color: var(--dp-border);">
                <template x-for="(record, index) in filteredRecords" :key="record.id">
                    <div class="grid grid-cols-1 lg:grid-cols-[40px_1fr_80px_90px_80px_100px] items-center px-5 py-3 gap-2 lg:gap-0 transition-colors"
                         onmouseover="this.style.background='var(--dp-primary-tint)'"
                         onmouseout="this.style.background='transparent'">
                        <span class="hidden lg:block text-sm" style="color: var(--dp-text-secondary);" x-text="index + 1"></span>
                        <span class="text-sm font-semibold" style="color: var(--dp-text-primary);" x-text="record.nama"></span>
                        <span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider"
                                  :style="record.tipe_peserta === 'kader' ? 'background: rgba(8,51,44,0.10); color: var(--dp-status-done);' : 'background: var(--dp-gold-tint); color: var(--dp-gold);'"
                                  x-text="record.tipe_peserta === 'kader' ? 'Kader' : 'Umum'"></span>
                        </span>
                        <span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider"
                                  :style="record.status_kehadiran === 'hadir' ? 'background: rgba(8,51,44,0.10); color: var(--dp-status-done);' :
                                          record.status_kehadiran === 'izin' ? 'background: var(--dp-gold-tint); color: var(--dp-gold);' :
                                          record.status_kehadiran === 'sakit' ? 'background: rgba(186,158,111,0.20); color: var(--dp-text-secondary);' :
                                          'background: var(--dp-danger-tint); color: var(--dp-danger);'"
                                  x-text="record.status_kehadiran.charAt(0).toUpperCase() + record.status_kehadiran.slice(1)"></span>
                        </span>
                        <span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider"
                                  style="background: var(--dp-bg-surface-2); color: var(--dp-text-secondary);"
                                  x-text="record.metode === 'scan' ? 'Scan' : 'Manual'"></span>
                        </span>
                        <span class="text-xs text-right" style="color: var(--dp-text-secondary);" x-text="record.waktu"></span>
                    </div>
                </template>
            </div>

            {{-- Empty State --}}
            <div x-show="filteredRecords.length === 0" class="py-16 text-center" x-cloak>
                <div class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-3"
                     style="background: var(--dp-bg-surface-2);">
                    <span class="material-symbols-outlined text-2xl" style="color: var(--dp-text-secondary);">person_off</span>
                </div>
                <p class="text-sm font-semibold" style="color: var(--dp-text-primary);">Belum ada peserta</p>
                <p class="text-xs mt-1" style="color: var(--dp-text-secondary);">Peserta akan muncul saat mereka scan QR code.</p>
            </div>

        </div>

        {{-- Add Manual Section --}}
        @if($isOpen)
            <div x-data="{ showModal: false, tipe: 'kader' }">
                <button @click="showModal = true" type="button"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold transition-colors"
                        style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);"
                        onmouseover="this.style.background='var(--dp-bg-primary-hover)'"
                        onmouseout="this.style.background='var(--dp-bg-primary)'">
                    <span class="material-symbols-outlined text-lg">person_add</span>
                    Tambah Manual
                </button>

                {{-- Modal --}}
                <div x-show="showModal" x-cloak
                     class="fixed inset-0 z-50 flex items-center justify-center p-4"
                     style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);">
                    <div @click.away="showModal = false"
                         class="w-full max-w-md rounded-xl p-6 shadow-2xl"
                         style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);"
                         x-transition>

                        <div class="flex items-center justify-between mb-5">
                            <h3 class="font-display font-bold text-lg" style="color: var(--dp-text-primary);">Tambah Peserta Manual</h3>
                            <button @click="showModal = false" type="button"
                                    class="p-1 rounded-lg transition-colors"
                                    style="color: var(--dp-text-secondary);"
                                    onmouseover="this.style.background='var(--dp-bg-surface-2)'"
                                    onmouseout="this.style.background='transparent'">
                                <span class="material-symbols-outlined text-xl">close</span>
                            </button>
                        </div>

                        <form action="{{ route('dashboard.kaderisasi.absensi.add-manual', $absensi->id) }}" method="POST">
                            @csrf

                            {{-- Tipe Toggle --}}
                            <div class="mb-4">
                                <label class="block text-[10px] font-bold uppercase tracking-widest mb-2"
                                       style="color: var(--dp-text-secondary);">Tipe Peserta</label>
                                <div class="flex rounded-lg overflow-hidden" style="border: 1px solid var(--dp-border);">
                                    <button type="button" @click="tipe = 'kader'"
                                            :style="tipe === 'kader' ? 'background: var(--dp-bg-primary); color: var(--dp-text-on-primary);' : 'background: var(--dp-bg-surface-2); color: var(--dp-text-secondary);'"
                                            class="flex-1 px-4 py-2.5 text-sm font-semibold transition-colors">
                                        Kader
                                    </button>
                                    <button type="button" @click="tipe = 'umum'"
                                            :style="tipe === 'umum' ? 'background: var(--dp-bg-primary); color: var(--dp-text-on-primary);' : 'background: var(--dp-bg-surface-2); color: var(--dp-text-secondary);'"
                                            class="flex-1 px-4 py-2.5 text-sm font-semibold transition-colors">
                                        Peserta Umum
                                    </button>
                                </div>
                                <input type="hidden" name="tipe_peserta" :value="tipe">
                            </div>

                            {{-- Kader Select --}}
                            <div x-show="tipe === 'kader'" class="mb-4">
                                <label class="block text-[10px] font-bold uppercase tracking-widest mb-1.5"
                                       style="color: var(--dp-text-secondary);">Pilih Kader</label>
                                <select name="kader_id"
                                        class="w-full px-3 py-2.5 rounded-lg text-sm outline-none"
                                        style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
                                    <option value="">-- Pilih Kader --</option>
                                    @if(isset($kaders))
                                        @foreach($kaders as $kader)
                                            <option value="{{ $kader->id }}">{{ $kader->nama_lengkap }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            {{-- Nama Peserta Umum --}}
                            <div x-show="tipe === 'umum'" class="mb-4">
                                <label class="block text-[10px] font-bold uppercase tracking-widest mb-1.5"
                                       style="color: var(--dp-text-secondary);">Nama Peserta</label>
                                <input type="text" name="nama_peserta"
                                       placeholder="Masukkan nama lengkap..."
                                       class="w-full px-4 py-2.5 rounded-lg text-sm outline-none transition-colors"
                                       style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);"
                                       onfocus="this.style.borderColor='var(--dp-gold)'"
                                       onblur="this.style.borderColor='var(--dp-border)'">
                            </div>

                            {{-- Status Kehadiran --}}
                            <div class="mb-5">
                                <label class="block text-[10px] font-bold uppercase tracking-widest mb-1.5"
                                       style="color: var(--dp-text-secondary);">Status Kehadiran</label>
                                <select name="status_kehadiran"
                                        class="w-full px-3 py-2.5 rounded-lg text-sm outline-none"
                                        style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
                                    <option value="hadir">Hadir</option>
                                    <option value="izin">Izin</option>
                                    <option value="sakit">Sakit</option>
                                    <option value="alpha">Alpha</option>
                                </select>
                            </div>

                            {{-- Submit --}}
                            <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 py-3 rounded-lg font-bold text-sm transition-colors"
                                    style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);"
                                    onmouseover="this.style.background='var(--dp-bg-primary-hover)'"
                                    onmouseout="this.style.background='var(--dp-bg-primary)'">
                                <span class="material-symbols-outlined text-lg">person_add</span>
                                Tambah Peserta
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        @endif

    </div>

</div>

<script>
    function absensiLive(absensiId, initialStatus) {
        return {
            records: @json($records ?? []),
            total: {{ $totalRecords ?? 0 }},
            hadir: {{ $totalHadir ?? 0 }},
            status: initialStatus,
            tab: 'semua',
            init() {
                if (this.status === 'buka') {
                    this.startPolling();
                }
            },
            async loadRecords() {
                try {
                    const res = await fetch('/dashboard/kaderisasi/absensi/' + absensiId + '/attendees');
                    const data = await res.json();
                    this.records = data.records;
                    this.total = data.total;
                    this.hadir = data.hadir;
                    this.status = data.status;
                } catch(e) {
                    // Silent fail
                }
            },
            startPolling() {
                setInterval(() => {
                    if (this.status === 'buka') {
                        this.loadRecords();
                    }
                }, 5000);
            },
            get filteredRecords() {
                if (this.tab === 'semua') return this.records;
                return this.records.filter(r => r.tipe_peserta === this.tab);
            }
        }
    }
</script>

@endsection
