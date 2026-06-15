<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $form->judul_form ?? $form->nama_kegiatan }} — DASI Pelajar</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700;900&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.theme-init')
</head>

<body class="min-h-screen font-body antialiased transition-colors duration-300"
    style="background: var(--dp-bg-page); color: var(--dp-text-primary);"
    x-data="{ isSubmitting: false }">

    {{-- HEADER --}}
    <header style="background: var(--dp-bg-primary); border-bottom: 3px solid var(--dp-gold);" class="pt-12 pb-24 px-4">
        <div class="max-w-2xl mx-auto text-center">
            <p class="text-xs uppercase tracking-widest mb-3 font-body font-semibold" style="color: var(--dp-gold);">
                PC IPNU–IPPNU Kabupaten Kediri
            </p>
            <h1 class="text-2xl md:text-4xl font-display font-bold leading-tight" style="color: var(--dp-text-on-primary);">
                {{ $form->judul_form ?? $form->nama_kegiatan }}
            </h1>
            @if($form->judul_form && $form->judul_form !== $form->nama_kegiatan)
                <p class="mt-2 text-sm font-body opacity-70" style="color: var(--dp-text-on-primary);">
                    {{ $form->nama_kegiatan }}
                </p>
            @endif
            {{-- Tanggal tutup jika ada --}}
            @if($form->tgl_tutup)
                <div class="inline-flex items-center gap-1.5 mt-4 px-3 py-1.5 rounded text-xs font-semibold"
                    style="background: var(--dp-gold-tint); color: var(--dp-gold);">
                    <span class="material-symbols-outlined text-sm">schedule</span>
                    Ditutup {{ $form->tgl_tutup->format('d M Y, H:i') }} WIB
                </div>
            @endif
        </div>
    </header>

    <main class="max-w-2xl mx-auto -mt-10 px-4 pb-20 relative z-10">

        {{-- SUKSES STATE --}}
        @if(session('success'))
            <div class="rounded border-t-4 p-8 text-center shadow-lg mb-6"
                style="background: var(--dp-bg-surface); border-top-color: var(--dp-gold);">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full mb-4"
                    style="background: var(--dp-gold-tint);">
                    <span class="material-symbols-outlined text-3xl" style="color: var(--dp-gold);">verified</span>
                </div>
                <h2 class="text-xl font-display font-bold mb-2" style="color: var(--dp-text-primary);">
                    Pendaftaran Berhasil!
                </h2>
                <p class="text-sm font-body mb-2" style="color: var(--dp-text-secondary);">
                    {{ session('success') }}
                </p>
                <p class="text-sm font-body mb-6" style="color: var(--dp-text-secondary);">
                    Data Anda telah tercatat oleh panitia dan akan diverifikasi untuk proses lebih lanjut.
                </p>

                {{-- Link custom setelah sukses --}}
                @if($form->link_sukses)
                    <a href="{{ $form->link_sukses }}" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded font-display font-bold text-sm transition-all mb-3 w-full justify-center"
                        style="background: var(--dp-gold); color: var(--dp-bg-primary);">
                        <span class="material-symbols-outlined text-base">open_in_new</span>
                        Lanjutkan ke Tautan Panitia
                    </a>
                @endif

                <a href="{{ request()->url() }}"
                    class="inline-flex items-center gap-1.5 text-sm font-body transition-all"
                    style="color: var(--dp-text-secondary);">
                    <span class="material-symbols-outlined text-sm">refresh</span>
                    Daftar lagi
                </a>
            </div>

        {{-- FORM STATE --}}
        @else
            <div class="rounded border-t-4 shadow-lg overflow-hidden"
                style="background: var(--dp-bg-surface); border-top-color: var(--dp-gold);">

                {{-- Error alert --}}
                @if($errors->any())
                    <div class="mx-6 mt-6 p-4 rounded flex items-start gap-3 text-sm"
                        style="background: var(--dp-danger-tint); color: var(--dp-danger); border: 1px solid rgba(232,70,58,0.2);">
                        <span class="material-symbols-outlined text-lg shrink-0">error</span>
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('layanan.form.submit', $form->slug) }}" method="POST"
                    enctype="multipart/form-data" @submit="isSubmitting = true" class="p-6 md:p-8 space-y-5">
                    @csrf

                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="block text-sm font-semibold mb-1.5 font-body" style="color: var(--dp-text-primary);">
                            Nama Lengkap <span style="color: var(--dp-danger);">*</span>
                        </label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                            placeholder="Masukkan nama lengkap Anda"
                            class="w-full px-4 py-3 rounded text-sm font-body transition-all outline-none"
                            style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);"
                            onfocus="this.style.borderColor='var(--dp-gold)'; this.style.boxShadow='0 0 0 3px var(--dp-gold-tint)'"
                            onblur="this.style.borderColor='var(--dp-border)'; this.style.boxShadow='none'">
                    </div>

                    {{-- Jenis Kelamin + No WA --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold mb-1.5 font-body" style="color: var(--dp-text-primary);">
                                Jenis Kelamin <span style="color: var(--dp-danger);">*</span>
                            </label>
                            <select name="jenis_kelamin" required
                                class="w-full px-4 py-3 rounded text-sm font-body transition-all outline-none"
                                style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);"
                                onfocus="this.style.borderColor='var(--dp-gold)'"
                                onblur="this.style.borderColor='var(--dp-border)'">
                                <option value="">Pilih...</option>
                                <option value="Laki-Laki" {{ old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki (IPNU)</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan (IPPNU)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1.5 font-body" style="color: var(--dp-text-primary);">
                                Nomor WhatsApp <span style="color: var(--dp-danger);">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none material-symbols-outlined text-lg"
                                    style="color: var(--dp-text-secondary);">call</span>
                                <input type="tel" name="no_wa" value="{{ old('no_wa') }}" required
                                    placeholder="08XXXXXXXXXX"
                                    class="w-full pl-10 pr-4 py-3 rounded text-sm font-body transition-all outline-none"
                                    style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);"
                                    onfocus="this.style.borderColor='var(--dp-gold)'; this.style.boxShadow='0 0 0 3px var(--dp-gold-tint)'"
                                    onblur="this.style.borderColor='var(--dp-border)'; this.style.boxShadow='none'">
                            </div>
                        </div>
                    </div>

                    {{-- Asal Instansi --}}
                    <div>
                        <label class="block text-sm font-semibold mb-1.5 font-body" style="color: var(--dp-text-primary);">
                            Asal PAC / Instansi Pendelegasi <span style="color: var(--dp-danger);">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none material-symbols-outlined text-lg"
                                style="color: var(--dp-text-secondary);">home_pin</span>
                            <input type="text" name="asal_instansi" value="{{ old('asal_instansi') }}" required
                                placeholder="Contoh: PAC IPNU IPPNU Kec. Pare"
                                class="w-full pl-10 pr-4 py-3 rounded text-sm font-body transition-all outline-none"
                                style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);"
                                onfocus="this.style.borderColor='var(--dp-gold)'; this.style.boxShadow='0 0 0 3px var(--dp-gold-tint)'"
                                onblur="this.style.borderColor='var(--dp-border)'; this.style.boxShadow='none'">
                        </div>
                    </div>

                    {{-- Custom Fields --}}
                    @if($form->custom_fields && count($form->custom_fields) > 0)
                        <div class="pt-2">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="flex-1 h-px" style="background: var(--dp-border-gold);"></div>
                                <span class="text-xs font-semibold uppercase tracking-widest font-body px-2"
                                    style="color: var(--dp-gold);">Pertanyaan Tambahan</span>
                                <div class="flex-1 h-px" style="background: var(--dp-border-gold);"></div>
                            </div>

                            <div class="rounded p-5 space-y-5"
                                style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border-gold);">
                                @foreach($form->custom_fields as $index => $field)
                                    <div>
                                        <label class="block text-sm font-semibold mb-1.5 font-body" style="color: var(--dp-text-primary);">
                                            {{ $field['label'] }}
                                            @if(!empty($field['required']))
                                                <span class="text-xs font-normal ml-1 px-1.5 py-0.5 rounded"
                                                    style="color: var(--dp-danger); background: var(--dp-danger-tint);">Wajib</span>
                                            @endif
                                        </label>

                                        @if($field['type'] == 'text')
                                            <input type="text" name="custom_{{ $index }}"
                                                {{ !empty($field['required']) ? 'required' : '' }}
                                                value="{{ old('custom_' . $index) }}"
                                                class="w-full px-4 py-3 rounded text-sm font-body transition-all outline-none"
                                                style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border); color: var(--dp-text-primary);"
                                                onfocus="this.style.borderColor='var(--dp-gold)'"
                                                onblur="this.style.borderColor='var(--dp-border)'">

                                        @elseif($field['type'] == 'number')
                                            <input type="number" name="custom_{{ $index }}"
                                                {{ !empty($field['required']) ? 'required' : '' }}
                                                value="{{ old('custom_' . $index) }}"
                                                class="w-full px-4 py-3 rounded text-sm font-body transition-all outline-none"
                                                style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border); color: var(--dp-text-primary);"
                                                onfocus="this.style.borderColor='var(--dp-gold)'"
                                                onblur="this.style.borderColor='var(--dp-border)'">

                                        @elseif($field['type'] == 'textarea')
                                            <textarea name="custom_{{ $index }}" rows="3"
                                                {{ !empty($field['required']) ? 'required' : '' }}
                                                class="w-full px-4 py-3 rounded text-sm font-body transition-all outline-none resize-y"
                                                style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border); color: var(--dp-text-primary);"
                                                onfocus="this.style.borderColor='var(--dp-gold)'"
                                                onblur="this.style.borderColor='var(--dp-border)'">{{ old('custom_' . $index) }}</textarea>

                                        @elseif($field['type'] == 'select')
                                            @php $options = array_map('trim', explode(',', $field['options'] ?? '')); @endphp
                                            <select name="custom_{{ $index }}"
                                                {{ !empty($field['required']) ? 'required' : '' }}
                                                class="w-full px-4 py-3 rounded text-sm font-body transition-all outline-none"
                                                style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border); color: var(--dp-text-primary);"
                                                onfocus="this.style.borderColor='var(--dp-gold)'"
                                                onblur="this.style.borderColor='var(--dp-border)'">
                                                <option value="">Pilih...</option>
                                                @foreach($options as $opt)
                                                    <option value="{{ $opt }}"
                                                        {{ old('custom_' . $index) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                                @endforeach
                                            </select>

                                        @elseif($field['type'] == 'file')
                                            <input type="file" name="custom_{{ $index }}"
                                                {{ !empty($field['required']) ? 'required' : '' }}
                                                class="w-full text-sm font-body file:mr-3 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold transition-all"
                                                style="color: var(--dp-text-secondary);"
                                                x-bind:style="'--file-bg: var(--dp-bg-primary); --file-color: var(--dp-text-on-primary);'">
                                            <p class="text-xs mt-1 font-body" style="color: var(--dp-text-secondary);">
                                                Maksimal 5MB
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Submit --}}
                    <div class="pt-4 border-t" style="border-color: var(--dp-border);">
                        <button type="submit" :disabled="isSubmitting"
                            class="w-full flex items-center justify-center gap-2 py-3.5 px-6 rounded font-display font-bold text-sm transition-all disabled:opacity-60 disabled:cursor-wait"
                            style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);"
                            onmouseover="if(!this.disabled) this.style.background='var(--dp-bg-primary-hover)'"
                            onmouseout="this.style.background='var(--dp-bg-primary)'">
                            <span class="material-symbols-outlined text-base" x-show="!isSubmitting">send</span>
                            <svg x-show="isSubmitting" class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" style="display:none;">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span x-text="isSubmitting ? 'Memproses...' : 'Kirim Pendaftaran'">Kirim Pendaftaran</span>
                        </button>
                    </div>

                </form>
            </div>
        @endif

        {{-- Footer --}}
        <div class="mt-8 text-center text-xs font-body" style="color: var(--dp-text-secondary);">
            <p>&copy; {{ date('Y') }} DASI Pelajar — PC IPNU IPPNU Kabupaten Kediri</p>
        </div>
    </main>

</body>
</html>
