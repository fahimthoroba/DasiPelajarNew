@extends('layouts.dashboard')

@section('title', 'Tambah Kegiatan')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('dashboard.pac.proker.index') }}"
                class="inline-flex items-center gap-2 text-gray-500 hover:text-emerald-600 transition-colors mb-2 text-sm">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Kembali
            </a>
            <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Tambah Kegiatan Baru</h1>
        </div>

        @if(session('success'))
            <div
                class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 font-medium flex items-center gap-3 border border-emerald-100 dark:border-emerald-800">
                <span class="material-symbols-outlined">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('dashboard.pac.proker.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6"
            x-data="{ 
                    kategoriMode: 'select', 
                    toggleKategori() { 
                        this.kategoriMode = this.kategoriMode === 'select' ? 'new' : 'select'; 
                        if(this.kategoriMode === 'select') { $refs.newCatInput.value = ''; }
                    } 
                }">

            @csrf

            <!-- Left Column: Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 space-y-6">

                    <!-- Nama Kegiatan -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Nama Kegiatan
                            (Ingenious Name)</label>
                        <input type="text" name="nama_lokal" value="{{ old('nama_lokal') }}" required
                            placeholder="Contoh: Makesta Raya Zona Selatan"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-surface-light dark:bg-gray-900 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                        @error('nama_lokal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Departemen (Required for New Category, Optional/Informative otherwise) -->
                    <!-- Sesuai request: Nama, Departemen, Kategori -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Departemen Penanggung
                            Jawab</label>
                        <select name="departemen_id"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-surface-light dark:bg-gray-900 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                            <option value="">-- Pilih Departemen --</option>
                            @foreach($departemens as $dept)
                                <option value="{{ $dept->id }}" {{ old('departemen_id') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->nama_departemen }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1" x-show="kategoriMode === 'new'">*Wajib dipilih jika membuat
                            kategori baru.</p>
                        @error('departemen_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Kategori Setup -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Kategori Program</label>
                            <button type="button" @click="toggleKategori()"
                                class="text-xs font-bold text-emerald-600 hover:text-emerald-700 transition-colors">
                                <span
                                    x-text="kategoriMode === 'select' ? '+ Buat Kategori Baru' : 'Pilih dari yang ada'"></span>
                            </button>
                        </div>

                        <!-- Mode Select -->
                        <div x-show="kategoriMode === 'select'">
                            <select name="kategori_program_id"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-surface-light dark:bg-gray-900 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $cat)
                                    <option value="{{ $cat->id }}" {{ old('kategori_program_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Mode New Input -->
                        <div x-show="kategoriMode === 'new'" style="display: none;">
                            <input type="text" name="kategori_baru" x-ref="newCatInput"
                                placeholder="Ketik nama kategori baru..."
                                class="w-full px-4 py-3 rounded-xl border border-emerald-500 bg-emerald-50/50 dark:bg-emerald-900/10 focus:ring-emerald-500/20 transition-all">
                            <p class="text-xs text-emerald-600 mt-1">*Kategori langsung aktif tanpa verifikasi.</p>
                        </div>
                        @error('kategori_program_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        @error('kategori_baru') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Waktu -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Tanggal
                                Mulai</label>
                            <input type="date" name="tgl_mulai" value="{{ old('tgl_mulai') }}" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-surface-light dark:bg-gray-900 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Tanggal
                                Selesai</label>
                            <input type="date" name="tgl_selesai" value="{{ old('tgl_selesai') }}" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-surface-light dark:bg-gray-900 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Deskripsi &
                            Catatan</label>
                        <textarea name="deskripsi" rows="3" placeholder="Opsional..."
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-surface-light dark:bg-gray-900 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">{{ old('deskripsi') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Right Column: Settings -->
            <div class="lg:col-span-1 space-y-6">
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 space-y-6">

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Status Kegiatan</label>
                        <select name="status"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-surface-light dark:bg-gray-900 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                            <option value="Rencana">Rencana (Masih Konsep)</option>
                            <option value="Pasti">Pasti (Jadwal Fix)</option>
                            <option value="Terlaksana">Terlaksana (Selesai)</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-2">*Memilih "Pasti" atau "Terlaksana" otomatis menandai jadwal
                            sebagai FIX.</p>
                    </div>

                    <!-- Target Peserta -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Target Peserta</label>
                        <div
                            class="space-y-2 max-h-48 overflow-y-auto px-1 bg-surface-light dark:bg-gray-900/50 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                            @foreach(['Internal PAC', 'Pengurus Ranting', 'Alumni', 'Pelajar', 'Masyarakat', 'Banom NU Lain'] as $target)
                                <label
                                    class="flex items-center gap-3 p-1 rounded-lg hover:bg-white dark:hover:bg-gray-800 cursor-pointer">
                                    <input type="checkbox" name="target_peserta[]" value="{{ $target }}"
                                        class="w-4 h-4 rounded text-emerald-600 border-gray-300 focus:ring-emerald-500">
                                    <span class="text-sm text-gray-600 dark:text-gray-300">{{ $target }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-3 pt-4">
                        <button type="submit" name="action" value="save"
                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-emerald-500/20 transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">save</span>
                            Simpan
                        </button>

                        <button type="submit" name="action" value="create_another"
                            class="w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-white font-bold py-3 rounded-xl transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">add_circle</span>
                            Simpan & Buat Baru
                        </button>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection