<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Absensi - {{ $absensi->judul }} - DASI Pelajar</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=3">

    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700;900&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @include('partials.theme-init')

    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Outfit', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="antialiased min-h-screen flex flex-col" style="background: var(--dp-bg-page); color: var(--dp-text-primary);">

    {{-- Header --}}
    <header class="py-4 px-4" style="background: var(--dp-bg-primary); border-bottom: 3px solid var(--dp-gold);">
        <div class="max-w-md mx-auto flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: var(--dp-gold);">
                <img src="{{ asset('favicon.png') }}" alt="Logo" class="w-5 h-5">
            </div>
            <span class="font-semibold text-lg tracking-tight" style="color: var(--dp-text-on-primary);">
                DASI<span style="color: var(--dp-gold);">PELAJAR</span>
            </span>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="flex-1 px-4 py-6">
        <div class="max-w-md mx-auto space-y-5">

            {{-- Session Info Card --}}
            <div class="rounded-xl p-5" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                <h1 class="font-display font-bold text-xl mb-3" style="color: var(--dp-text-primary);">
                    {{ $absensi->judul }}
                </h1>

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
                    $isOpen = $absensi->isOpen();
                @endphp

                <div class="flex items-center gap-2 flex-wrap mb-4">
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
                              style="background: var(--dp-danger-tint); color: var(--dp-danger);">
                            Ditutup
                        </span>
                    @endif
                </div>

                <div class="space-y-2">
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
                </div>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="px-4 py-3 rounded-lg flex items-center gap-3 text-sm"
                     style="background: var(--dp-primary-tint); border: 1px solid var(--dp-border-strong); color: var(--dp-text-primary);">
                    <span class="material-symbols-outlined text-lg shrink-0" style="color: var(--dp-status-done);">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="px-4 py-3 rounded-lg flex items-center gap-3 text-sm"
                     style="background: var(--dp-danger-tint); border: 1px solid var(--dp-danger); color: var(--dp-danger);">
                    <span class="material-symbols-outlined text-lg shrink-0">error</span>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Status: Session Closed --}}
            @if(!$isOpen)
                <div class="rounded-xl p-8 text-center" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4"
                         style="background: var(--dp-danger-tint);">
                        <span class="material-symbols-outlined text-3xl" style="color: var(--dp-danger);">lock</span>
                    </div>
                    <h2 class="font-display font-bold text-lg mb-2" style="color: var(--dp-text-primary);">Sesi Telah Ditutup</h2>
                    <p class="text-sm" style="color: var(--dp-text-secondary);">
                        Sesi absensi ini sudah tidak menerima kehadiran lagi.
                        Hubungi penyelenggara jika Anda merasa ini adalah kesalahan.
                    </p>
                </div>

            {{-- Status: Already Scanned --}}
            @elseif(isset($alreadyScanned) && $alreadyScanned)
                <div class="rounded-xl p-8 text-center" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4"
                         style="background: rgba(8,51,44,0.10);">
                        <span class="material-symbols-outlined text-3xl" style="color: var(--dp-status-done);">check_circle</span>
                    </div>
                    <h2 class="font-display font-bold text-lg mb-2" style="color: var(--dp-status-done);">Anda Sudah Tercatat</h2>
                    <p class="text-sm" style="color: var(--dp-text-secondary);">
                        Kehadiran Anda pada sesi ini sudah tercatat sebelumnya.
                        Tidak perlu melakukan konfirmasi lagi.
                    </p>
                </div>

            {{-- Status: Open — Show Form --}}
            @else
                <div class="rounded-xl p-5" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                    <h2 class="font-display font-bold text-lg mb-4 text-center" style="color: var(--dp-text-primary);">
                        Konfirmasi Kehadiran
                    </h2>

                    <form action="{{ route('absensi.process-scan', $absensi->kode_akses) }}" method="POST">
                        @csrf

                        @if(auth()->check() && auth()->user()->kader_id)
                            {{-- Authenticated kader --}}
                            <div class="rounded-lg p-4 mb-5"
                                 style="background: var(--dp-primary-tint); border: 1px solid var(--dp-border-strong);">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold"
                                         style="background: var(--dp-bg-primary); color: var(--dp-gold);">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold" style="color: var(--dp-text-primary);">{{ auth()->user()->name }}</p>
                                        <p class="text-[10px] uppercase tracking-wider font-semibold" style="color: var(--dp-text-secondary);">Kader Terdaftar</p>
                                    </div>
                                </div>
                            </div>

                            <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 py-3.5 rounded-lg font-bold text-sm transition-colors"
                                    style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);"
                                    onmouseover="this.style.background='var(--dp-bg-primary-hover)'"
                                    onmouseout="this.style.background='var(--dp-bg-primary)'">
                                <span class="material-symbols-outlined text-lg">how_to_reg</span>
                                Konfirmasi Kehadiran
                            </button>

                        @else
                            {{-- Guest / non-kader --}}
                            <div class="mb-5">
                                <label class="block text-[10px] font-bold uppercase tracking-widest mb-1.5"
                                       style="color: var(--dp-text-secondary);">Nama Lengkap <span style="color: var(--dp-danger);">*</span></label>
                                <input type="text" name="nama_peserta" value="{{ old('nama_peserta') }}" required
                                       placeholder="Masukkan nama lengkap Anda..."
                                       class="w-full px-4 py-3 rounded-lg text-sm outline-none transition-colors"
                                       style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);"
                                       onfocus="this.style.borderColor='var(--dp-gold)'"
                                       onblur="this.style.borderColor='var(--dp-border)'">
                                @error('nama_peserta')
                                    <p class="text-xs mt-1.5" style="color: var(--dp-danger);">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 py-3.5 rounded-lg font-bold text-sm transition-colors"
                                    style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);"
                                    onmouseover="this.style.background='var(--dp-bg-primary-hover)'"
                                    onmouseout="this.style.background='var(--dp-bg-primary)'">
                                <span class="material-symbols-outlined text-lg">how_to_reg</span>
                                Konfirmasi Kehadiran
                            </button>
                        @endif
                    </form>
                </div>
            @endif

        </div>
    </main>

    {{-- Footer --}}
    <footer class="py-4 px-4 text-center" style="border-top: 1px solid var(--dp-border);">
        <p class="text-xs" style="color: var(--dp-text-secondary);">
            Powered by <span class="font-semibold" style="color: var(--dp-bg-primary);">DASI</span><span class="font-semibold" style="color: var(--dp-gold);">PELAJAR</span>
        </p>
    </footer>

</body>

</html>
