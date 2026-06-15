<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $form->judul_form ?? $form->nama_kegiatan ?? 'Pendaftaran Ditutup' }} — DASI Pelajar</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700;900&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.theme-init')
</head>
<body class="min-h-screen font-body antialiased flex items-center justify-center p-4 transition-colors duration-300"
    style="background: var(--dp-bg-page);">

    <div class="max-w-sm w-full text-center">

        {{-- Icon --}}
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full mb-6 mx-auto"
            style="background: var(--dp-gold-tint); border: 1px solid var(--dp-border-gold);">
            <span class="material-symbols-outlined text-4xl" style="color: var(--dp-gold);">inventory_2</span>
        </div>

        {{-- Judul --}}
        <h1 class="text-xl font-display font-bold mb-1" style="color: var(--dp-text-primary);">
            {{ $form->judul_form ?? $form->nama_kegiatan }}
        </h1>
        <p class="text-xs uppercase tracking-widest font-semibold mb-4" style="color: var(--dp-gold);">
            Pendaftaran Tidak Tersedia
        </p>

        {{-- Garis emas --}}
        <div class="w-12 h-0.5 mx-auto mb-4" style="background: var(--dp-gold);"></div>

        {{-- Pesan --}}
        <p class="text-sm font-body mb-8 leading-relaxed" style="color: var(--dp-text-secondary);">
            {{ $reason }}
        </p>

        {{-- Tombol kembali --}}
        <a href="{{ route('home') }}"
            class="inline-flex items-center justify-center gap-2 w-full px-6 py-3 rounded font-display font-bold text-sm transition-all"
            style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);"
            onmouseover="this.style.background='var(--dp-bg-primary-hover)'"
            onmouseout="this.style.background='var(--dp-bg-primary)'">
            <span class="material-symbols-outlined text-base">home</span>
            Kembali ke Beranda
        </a>

        <p class="mt-6 text-xs font-body" style="color: var(--dp-text-secondary);">
            &copy; {{ date('Y') }} DASI Pelajar — PC IPNU IPPNU Kabupaten Kediri
        </p>
    </div>

</body>
</html>
