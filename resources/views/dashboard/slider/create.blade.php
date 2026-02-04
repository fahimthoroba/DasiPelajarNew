@extends('layouts.dashboard')

@section('title', 'Tambah Slide')

@section('content')
    <div class="max-w-2xl">
        <div class="mb-6">
            <a href="{{ route('dashboard.slider.index') }}"
                class="inline-flex items-center gap-2 text-gray-500 hover:text-emerald-600 transition-colors mb-2 text-sm">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Kembali
            </a>
            <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Tambah Slide Baru</h1>
        </div>

        <form action="{{ route('dashboard.slider.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 space-y-6">
            @csrf

            <!-- Image Upload -->
            <div x-data="imagePreview()">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Gambar Banner</label>
                <div
                    class="relative w-full aspect-video bg-gray-100 dark:bg-gray-900 rounded-xl overflow-hidden border-2 border-dashed border-gray-300 dark:border-gray-700 hover:border-emerald-500 transition-colors cursor-pointer group">
                    <input type="file" name="gambar_path" accept="image/*" required
                        class="absolute inset-0 z-20 opacity-0 cursor-pointer" @change="previewImage">

                    <div class="absolute inset-0 z-10 flex flex-col items-center justify-center text-gray-400 group-hover:text-emerald-500 transition-colors"
                        x-show="!imageUrl">
                        <span class="material-symbols-outlined text-4xl mb-2">add_photo_alternate</span>
                        <span class="text-xs font-medium">Upload Gambar (1920x1080)</span>
                    </div>

                    <img :src="imageUrl" class="absolute inset-0 w-full h-full object-cover z-10" x-show="imageUrl"
                        style="display: none;">
                </div>
                @error('gambar_path')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

            </div>

            <!-- Label & Title -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Label (Opsional)</label>
                    <input type="text" name="label" value="{{ old('label', ' ') }}"
                        placeholder="Contoh: Suara Pelajar Kediri"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium">
                    @error('label')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Teks kecil di atas judul (biasanya nama portal).</p>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Judul Utama</label>
                    <input type="text" name="judul_utama" value="{{ old('judul_utama') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                    @error('judul_utama')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Urutan Tampil
                        (Angka)</label>
                    <input type="number" name="urutan" value="{{ old('urutan', 0) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Deskripsi Singkat</label>
                <input type="text" name="sub_judul" value="{{ old('sub_judul') }}"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Link Tombol (Opsional)</label>
                <input type="url" name="link_tombol" value="{{ old('link_tombol') }}" placeholder="https://..."
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" value="1" checked id="activeCheck"
                    class="w-5 h-5 rounded text-emerald-600 focus:ring-emerald-500 border-gray-300">
                <label for="activeCheck" class="text-sm font-medium text-gray-700 dark:text-gray-300">Aktifkan Slide Ini
                    Sejak Awal</label>
            </div>

            <button type="submit"
                class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-emerald-600/20 transition-all">
                <span class="material-symbols-outlined">save</span>
                Simpan Slide
            </button>
        </form>
    </div>

    <script>
        function imagePreview() {
            return {
                imageUrl: null,
                previewImage(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.imageUrl = URL.createObjectURL(file);
                    }
                }
            }
        }
    </script>
@endsection