<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran: {{ $form->nama_kegiatan }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>

<body class="bg-gray-50/50 min-h-screen font-sans selection:bg-emerald-500 selection:text-white"
    x-data="{ isSubmitting: false }">

    <!-- Header Section -->
    <header
        class="bg-gradient-to-br from-emerald-800 via-emerald-700 to-emerald-900 pt-14 pb-32 px-4 shadow-lg relative z-10">

        <div class="max-w-3xl mx-auto flex flex-col items-center justify-center text-center px-4">
            <h1 class="text-3xl md:text-5xl font-display font-extrabold text-white leading-tight"
                style="text-shadow: 0 2px 8px rgba(0,0,0,0.3);">
                {{ $form->nama_kegiatan }}
            </h1>
        </div>
    </header>

    <main class="max-w-2xl mx-auto -mt-24 px-4 pb-24 relative z-20">

        @if(session('success'))
            <div
                class="bg-emerald-50 text-emerald-800 p-6 rounded-2xl shadow-xl shadow-emerald-500/10 mb-8 border border-emerald-100 flex items-start gap-4">
                <span class="material-symbols-outlined text-emerald-600 text-3xl shrink-0">verified</span>
                <div>
                    <h3 class="font-bold text-lg mb-1">{{ session('success') }}</h3>
                    <p class="text-sm opacity-80">Terima Kasih, pendaftaran Anda telah tercatat oleh panitia. Data Anda akan
                        diverifikasi untuk proses lebih lanjut.</p>
                </div>
            </div>
        @else

            <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100/50 p-6 md:p-10">

                @if ($errors->any())
                    <div
                        class="bg-red-50 text-red-600 p-4 rounded-xl border border-red-100 text-sm mb-6 flex items-start gap-3">
                        <span class="material-symbols-outlined shrink-0 mt-0.5">error</span>
                        <ul class="list-disc pl-5 mt-1 opacity-90 font-medium space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('layanan.form.submit', $form->slug) }}" method="POST" enctype="multipart/form-data"
                    @submit="isSubmitting = true">
                    @csrf

                    <div class="space-y-6">


                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white text-gray-900 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Jenis Kelamin</label>
                                <select name="jenis_kelamin" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white text-gray-900 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all">
                                    <option value="">Pilih...</option>
                                    <option value="Laki-Laki" {{ old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>
                                        Laki-Laki (IPNU)</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan (IPPNU)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nomor WhatsApp Pribadi</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none opacity-50">
                                        <span class="material-symbols-outlined text-lg">call</span>
                                    </div>
                                    <input type="tel" name="no_wa" value="{{ old('no_wa') }}" required
                                        placeholder="08XXXXXXXXXX"
                                        class="w-full px-4 py-3 ps-12 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white text-gray-900 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Asal PAC / Instansi
                                Pendelegasi</label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none opacity-50">
                                    <span class="material-symbols-outlined text-lg">home_pin</span>
                                </div>
                                <input type="text" name="asal_instansi" value="{{ old('asal_instansi') }}" required
                                    placeholder="Contoh: PAC IPNU IPPNU Kecamatan XX"
                                    class="w-full px-4 py-3 ps-12 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white text-gray-900 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all">
                            </div>
                        </div>

                        @if($form->custom_fields && count($form->custom_fields) > 0)
                            <div class="pt-4 mt-4 border-t border-gray-100"></div>

                            <div class="space-y-6 bg-emerald-50/50 border border-emerald-100 rounded-2xl p-6">
                                @foreach($form->custom_fields as $index => $field)
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">
                                            {{ $field['label'] }}
                                            @if(!empty($field['required']))
                                                <span
                                                    class="text-xs text-red-500 font-normal ml-1 border border-red-200 bg-red-50 px-1 py-0.5 rounded">*Wajib</span>
                                            @endif
                                        </label>

                                        @if($field['type'] == 'text')
                                                    <input type="text" name="custom_{{ $index }}" {{ !empty($field['required']) ? 'required'
                                            : '' }} value="{{ old('custom_' . $index) }}"
                                                        class="w-full px-4 py-3 rounded-xl border border-emerald-200 bg-white focus:bg-white text-gray-900 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all">

                                        @elseif($field['type'] == 'number')
                                                    <input type="number" name="custom_{{ $index }}" {{ !empty($field['required']) ? 'required'
                                            : '' }} value="{{ old('custom_' . $index) }}"
                                                        class="w-full px-4 py-3 rounded-xl border border-emerald-200 bg-white focus:bg-white text-gray-900 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all">

                                        @elseif($field['type'] == 'textarea')
                                                    <textarea name="custom_{{ $index }}" rows="3" {{ !empty($field['required']) ? 'required'
                                            : '' }}
                                                        class="w-full px-4 py-3 rounded-xl border border-emerald-200 bg-white focus:bg-white text-gray-900 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all resize-y">{{ old('custom_' . $index) }}</textarea>

                                        @elseif($field['type'] == 'select')
                                            @php $options = array_map('trim', explode(',', $field['options'] ?? '')); @endphp
                                            <select name="custom_{{ $index }}" {{ !empty($field['required']) ? 'required' : '' }}
                                                class="w-full px-4 py-3 rounded-xl border border-emerald-200 bg-white focus:bg-white text-gray-900 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all">
                                                <option value="">Pilih...</option>
                                                @foreach($options as $opt)
                                                    <option value="{{ $opt }}" {{ old('custom_' . $index) == $opt ? 'selected' : '' }}>{{ $opt
                                                                            }}</option>
                                                @endforeach
                                            </select>

                                        @elseif($field['type'] == 'file')
                                                    <input type="file" name="custom_{{ $index }}" {{ !empty($field['required']) ? 'required'
                                            : '' }}
                                                        class="w-full px-3 py-2.5 rounded-xl border border-emerald-200 bg-emerald-50 text-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10  file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-all">
                                                    <p class="text-xs text-gray-500 mt-1">Maksimal 5MB.</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </div>

                    <div class="mt-10 pt-6 border-t border-gray-100">
                        <button type="submit" :disabled="isSubmitting"
                            class="w-full justify-center flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-display font-bold py-4 px-6 rounded-2xl transition-all shadow-xl shadow-emerald-600/20 disabled:opacity-50 disabled:cursor-wait">
                            <span class="material-symbols-outlined" x-show="!isSubmitting">send</span>
                            <svg x-show="isSubmitting" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display: none;">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span x-text="isSubmitting ? 'Memproses Pendaftaran...' : 'Kirim Pendaftaran Sekarang'">Kirim
                                Pendaftaran Sekarang</span>
                        </button>
                    </div>
                </form>
            </div>

        @endif

        <div class="mt-8 text-center text-xs text-gray-400 font-medium">
            <p>&copy; 2026 Sistem Kaderisasi Terpadu Dasi Pelajar</p>
            <p class="mt-1">Pimpinan Cabang IPNU IPPNU Kabupaten Kediri</p>
        </div>
    </main>
</body>

</html>