@extends('layouts.dashboard')

@section('title', 'Konfigurasi Form: ' . $form->nama_kegiatan)

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <a href="{{ route('dashboard.kaderisasi.form.index') }}"
            class="inline-flex items-center gap-2 text-gray-500 hover:text-emerald-600 transition-colors mb-2 text-sm">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Kembali ke Daftar Form
        </a>
        <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Konstruksi Form Pendaftaran</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm">Kegiatan: <strong>{{ $form->nama_kegiatan }}</strong></p>
    </div>
    
    <div class="flex items-center gap-3">
        <a href="{{ url('/form/' . $form->slug) }}" target="_blank"
            class="inline-flex items-center justify-center gap-2 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 hover:bg-blue-200 transition-colors font-bold py-2.5 px-5 rounded-xl">
            <span class="material-symbols-outlined text-sm">open_in_new</span>
            Pratinjau Halaman
        </a>
    </div>
</div>

{{-- Validation Error Display --}}
@if ($errors->any())
    <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 font-medium border border-red-100 dark:border-red-800">
        <div class="flex items-center gap-2 mb-2">
            <span class="material-symbols-outlined">error</span>
            <strong>Gagal menyimpan! Periksa kesalahan berikut:</strong>
        </div>
        <ul class="list-disc pl-8 text-sm space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 font-medium flex items-center gap-3 border border-emerald-100 dark:border-emerald-800">
        <span class="material-symbols-outlined">check_circle</span>
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('dashboard.kaderisasi.form.update', $form->id) }}" method="POST"
    x-data="formBuilder({{ json_encode($form->custom_fields ?? []) }})" 
    class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    @csrf
    @method('PUT')
    
    <!-- Kolom Kiri: Pertanyaan Dinamis -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-white/5 shadow-sm p-6 overflow-hidden">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-500">dynamic_form</span>
                Bidang Pertanyaan Khusus
            </h2>
            
            <!-- Bidang Data Pokok (Tidak bisa dihapus) -->
            <div class="mb-6 space-y-3 opacity-70">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Pertanyaan Utama (Selalu Ada)</p>
                @php
                    $defaults = [
                        ['label' => 'Nama Lengkap', 'type' => 'Text'],
                        ['label' => 'Jenis Kelamin', 'type' => 'Dropdown'],
                        ['label' => 'Nomor WhatsApp', 'type' => 'Number'],
                        ['label' => 'Asal PAC/Instansi', 'type' => 'Text'],
                    ];
                @endphp
                @foreach($defaults as $def)
                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                    <div>
                        <span class="font-bold text-gray-700 dark:text-gray-300">{{ $def['label'] }}</span>
                        <span class="text-xs text-white bg-red-500 px-2 py-0.5 rounded-full ml-2 font-bold">Wajib</span>
                    </div>
                    <div>
                        <span class="text-xs px-2 py-1 bg-gray-200 dark:bg-gray-700 rounded-md text-gray-600 dark:text-gray-400">{{ $def['type'] }}</span>
                        <span class="material-symbols-outlined text-gray-400 text-sm ml-2 cursor-not-allowed">lock</span>
                    </div>
                </div>
                @endforeach
            </div>

            <hr class="border-gray-100 dark:border-white/10 my-6">

            <!-- Alpine.js loop for custom items -->
            <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider mb-4 border-l-4 border-emerald-500 pl-2">Tambahkan Pertanyaan Baru</p>
            
            <!-- Hidden JSON Input field to submit via standard form POST -->
            <input type="hidden" name="custom_fields" x-bind:value="JSON.stringify(fields)">

            <template x-for="(field, index) in fields" :key="index">
                <div class="relative p-5 rounded-xl border-2 border-dashed border-emerald-200 dark:border-emerald-900/40 bg-emerald-50/50 dark:bg-emerald-900/10 mb-4 transition-all">
                    <!-- Hapus Field -->
                    <button type="button" @click="removeField(index)" 
                        class="absolute top-4 right-4 text-red-400 hover:text-red-600 bg-white dark:bg-gray-800 rounded-full p-1 shadow-sm transition-colors">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Label Pertanyaan -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-1">Pertanyaan <span x-text="index + 1"></span></label>
                            <input x-model="field.label" type="text" placeholder="Contoh: Ukuran Baju?" required
                                class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500/20">
                        </div>

                        <!-- Tipe Data -->
                        <div>
                            <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-1">Tipe Jawaban</label>
                            <select x-model="field.type" 
                                class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-white">
                                <option value="text">Teks Pendek</option>
                                <option value="textarea">Teks Panjang (Paragraf)</option>
                                <option value="number">Angka (Nomor)</option>
                                <option value="select">Pilihan Ganda (Dropdown)</option>
                                <option value="file">Upload File / Gambar / PDF</option>
                            </select>
                        </div>

                        <!-- Sifat Wajib - REDESIGNED untuk lebih jelas -->
                        <div class="flex items-end pb-2">
                            <div @click="field.required = !field.required" 
                                class="flex items-center gap-3 cursor-pointer select-none group">
                                <!-- Toggle Track -->
                                <div class="relative w-12 h-7 rounded-full transition-colors duration-300 shadow-inner"
                                    :class="field.required ? 'bg-emerald-500' : 'bg-gray-300 dark:bg-gray-600'">
                                    <div class="absolute top-[3px] left-[3px] w-[22px] h-[22px] bg-white rounded-full shadow-md transition-transform duration-300"
                                        :class="field.required ? 'translate-x-[20px]' : 'translate-x-0'"></div>
                                </div>
                                <!-- Label + Badge -->
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-bold transition-colors duration-200"
                                        :class="field.required ? 'text-emerald-700 dark:text-emerald-400' : 'text-gray-500 dark:text-gray-400'">
                                        Wajib Diisi?
                                    </span>
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full transition-all duration-200"
                                        :class="field.required 
                                            ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800' 
                                            : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-500 border border-gray-200 dark:border-gray-700'"
                                        x-text="field.required ? 'YA, WAJIB' : 'OPSIONAL'"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Opsi Dropdown jika type == select -->
                        <div class="md:col-span-2 mt-2" x-show="field.type === 'select'" x-transition>
                            <label class="block text-xs text-gray-500 mb-1">Tentukan Pilihan (Pisahkan dengan koma)</label>
                            <input x-model="field.options" type="text" placeholder="Contoh: S, M, L, XL, XXL"
                                class="w-full px-3 py-2 border-b-2 border-emerald-300 dark:border-emerald-700 bg-transparent text-sm focus:outline-none focus:border-emerald-600">
                        </div>
                    </div>
                </div>
            </template>

            <!-- Tombol Tambah -->
            <button type="button" @click="addField" 
                class="mt-4 w-full py-3 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-700 hover:border-emerald-500 hover:bg-emerald-50 dark:hover:bg-emerald-900/10 text-gray-600 dark:text-gray-300 hover:text-emerald-600 flex items-center justify-center gap-2 font-bold transition-all">
                <span class="material-symbols-outlined">add</span>
                Buat Pertanyaan Kustom Baru
            </button>
        </div>
    </div>

    <!-- Kolom Kanan: Pengaturan Ekstra -->
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-white/5 shadow-sm p-6 overflow-hidden space-y-5">
            <h3 class="font-bold text-gray-900 dark:text-white mb-2">Publikasi Link</h3>
            
            <!-- Status Toggle - REDESIGNED untuk lebih jelas -->
            <div x-data="{ isOpen: {{ $form->is_open ? 'true' : 'false' }} }">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-3">Status Form Pendaftaran</label>
                
                <!-- Actual hidden checkbox for form submission -->
                <input type="checkbox" name="is_open" value="1" x-bind:checked="isOpen" class="hidden" :checked="isOpen">
                
                <!-- Visual Toggle Button -->
                <div @click="isOpen = !isOpen; $el.closest('div[x-data]').querySelector('input[name=is_open]').checked = isOpen" 
                    class="flex items-center gap-4 p-4 rounded-xl border-2 cursor-pointer select-none transition-all duration-300"
                    :class="isOpen 
                        ? 'bg-emerald-50 dark:bg-emerald-900/20 border-emerald-300 dark:border-emerald-700' 
                        : 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800'">
                    
                    <!-- Toggle Track -->
                    <div class="relative w-14 h-8 rounded-full transition-colors duration-300 shadow-inner shrink-0"
                        :class="isOpen ? 'bg-emerald-500' : 'bg-red-400'">
                        <div class="absolute top-[3px] left-[3px] w-[26px] h-[26px] bg-white rounded-full shadow-md transition-transform duration-300 flex items-center justify-center"
                            :class="isOpen ? 'translate-x-[24px]' : 'translate-x-0'">
                            <span class="material-symbols-outlined text-[14px] transition-colors"
                                :class="isOpen ? 'text-emerald-500' : 'text-red-400'"
                                x-text="isOpen ? 'check' : 'close'"></span>
                        </div>
                    </div>
                    
                    <!-- Status Text -->
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-sm transition-colors"
                                :class="isOpen ? 'text-emerald-700 dark:text-emerald-400' : 'text-red-600 dark:text-red-400'"
                                x-text="isOpen ? 'Pendaftaran DIBUKA' : 'Pendaftaran DITUTUP'"></span>
                            <span class="w-2.5 h-2.5 rounded-full animate-pulse"
                                :class="isOpen ? 'bg-emerald-500' : 'bg-red-500'"></span>
                        </div>
                        <p class="text-[11px] mt-1 transition-colors"
                            :class="isOpen ? 'text-emerald-600/70' : 'text-red-500/70'"
                            x-text="isOpen ? 'Publik dapat mengakses dan mengisi form.' : 'Link form masih bisa diakses tapi tidak bisa di-submit.'"></p>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Nama Kegiatan</label>
                <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan', $form->nama_kegiatan) }}" required
                    class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm">
                @error('nama_kegiatan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- URL Form Publik -->
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">URL Form Publik</label>
                <div class="flex items-center gap-2">
                    <input type="text" value="{{ url('/form/' . $form->slug) }}" readonly
                        class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-xs text-blue-600 dark:text-blue-400 font-mono">
                    <button type="button" onclick="navigator.clipboard.writeText('{{ url('/form/' . $form->slug) }}'); this.innerHTML='<span class=\'material-symbols-outlined text-sm\'>done</span>'; setTimeout(() => this.innerHTML='<span class=\'material-symbols-outlined text-sm\'>content_copy</span>', 2000)"
                        class="shrink-0 p-2 rounded-lg bg-gray-100 hover:bg-emerald-100 text-gray-500 hover:text-emerald-600 transition-colors" title="Salin URL">
                        <span class="material-symbols-outlined text-sm">content_copy</span>
                    </button>
                </div>
            </div>

            <hr class="border-gray-100 dark:border-white/10">

            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Buka Sejak Tanggal</label>
                <input type="datetime-local" name="tgl_buka" value="{{ old('tgl_buka', $form->tgl_buka ? $form->tgl_buka->format('Y-m-d\TH:i') : '') }}"
                    class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm">
                <p class="text-[11px] text-gray-400 mt-1">Kosongkan jika langsung dibuka.</p>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Tutup Otomatis Pada</label>
                <input type="datetime-local" name="tgl_tutup" value="{{ old('tgl_tutup', $form->tgl_tutup ? $form->tgl_tutup->format('Y-m-d\TH:i') : '') }}"
                    class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm">
                <p class="text-[11px] text-gray-400 mt-1">Kosongkan jika tidak ada batas waktu.</p>
            </div>

            <button type="submit" 
                class="w-full mt-4 flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-emerald-500/30 transition-all">
                <span class="material-symbols-outlined">save</span>
                Simpan Perubahan
            </button>
        </div>
    </div>
</form>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('formBuilder', (initialFields) => ({
            fields: initialFields || [],
            addField() {
                this.fields.push({
                    label: '',
                    name: '',
                    type: 'text',
                    required: false,
                    options: ''
                });
            },
            removeField(index) {
                this.fields.splice(index, 1);
            }
        }));
    });

    // Sync Alpine.js isOpen state with the hidden checkbox before form submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const isOpenData = document.querySelector('[x-data]');
        // Ensure the hidden checkbox reflects the Alpine state
    });
</script>
@endsection
