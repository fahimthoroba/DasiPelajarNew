@extends('layouts.dashboard')

@section('title', 'Edit Berita')

@section('content')
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <style>
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;
        }

        .trix-button-group--file-tools {
            display: none !important;
        }

        trix-editor {
            background-color: transparent;
            border-radius: 0.75rem;
            padding: 1rem;
            min-height: 300px;
        }

        .dark trix-editor {
            color: #e2e8f0;
            border-color: #334155;
        }

        trix-toolbar {
            background: #f8fafc;
            border-radius: 0.75rem 0.75rem 0 0;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.5rem;
        }

        .dark trix-toolbar {
            background: #1e293b;
            border-color: #334155;
        }

        .dark .trix-button {
            filter: invert(1);
        }
    </style>

    <div class="mb-6">
        <a href="{{ route('dashboard.berita.index') }}"
            class="inline-flex items-center gap-2 text-gray-500 hover:text-emerald-600 transition-colors mb-2 text-sm">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Kembali ke Daftar
        </a>
        <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Edit Berita</h1>
    </div>

    <form action="{{ route('dashboard.berita.update', $beritum->id) }}" method="POST" enctype="multipart/form-data"
        class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf
        @method('PUT')

        <!-- Left Column: Content -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Title -->
            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Judul Berita</label>
                    <input type="text" name="judul" value="{{ old('judul', $beritum->judul) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-display font-bold text-lg">
                    @error('judul')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Konten Berita</label>
                    <div
                        class="border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-900 overflow-hidden">
                        <input id="konten" type="hidden" name="konten" value="{{ old('konten', $beritum->konten) }}">
                        <trix-editor input="konten"></trix-editor>
                    </div>
                    @error('konten')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

        </div>

        <!-- Right Column: Meta -->
        <div class="space-y-6">

            <!-- Publish Action -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5">
                <h3 class="font-bold text-gray-900 dark:text-white mb-4">Publikasi</h3>

                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Status</label>
                        <select name="status"
                            class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm">
                            <option value="published" {{ old('status', $beritum->status) == 'published' ? 'selected' : '' }}>
                                Published (Tayang)</option>
                            <option value="draft" {{ old('status', $beritum->status) == 'draft' ? 'selected' : '' }}>Draft
                                (Simpan Dulu)</option>
                            <option value="archived" {{ old('status', $beritum->status) == 'archived' ? 'selected' : '' }}>
                                Archived (Arsip)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kategori</label>
                        <select name="kategori_id"
                            class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm">
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                        <!-- Preselect JS Logic if needed, or simple standard Laravel Blade selected attribute logic (which loops are tricky with, but standard option selected works) -->
                        <script>
                            document.querySelector('select[name="kategori_id"]').value = "{{ old('kategori_id', $beritum->kategori_id) }}";
                        </script>
                    </div>
                </div>

                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-emerald-600/20 transition-all">
                    <span class="material-symbols-outlined">save</span>
                    Simpan Perubahan
                </button>
            </div>

            <!-- Thumbnail Image -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5"
                x-data="imagePreview()">
                <h3 class="font-bold text-gray-900 dark:text-white mb-4">Gambar Unggulan</h3>

                <div
                    class="relative w-full aspect-video bg-gray-100 dark:bg-gray-900 rounded-xl overflow-hidden border-2 border-dashed border-gray-300 dark:border-gray-700 hover:border-emerald-500 transition-colors cursor-pointer group">
                    <input type="file" name="thumbnail" accept="image/*"
                        class="absolute inset-0 z-20 opacity-0 cursor-pointer" @change="previewImage">

                    <!-- Placeholder (Show if NO image URL) -->
                    <div class="absolute inset-0 z-10 flex flex-col items-center justify-center text-gray-400 group-hover:text-emerald-500 transition-colors"
                        x-show="!imageUrl">
                        <span class="material-symbols-outlined text-4xl mb-2">add_photo_alternate</span>
                        <span class="text-xs font-medium">Upload New</span>
                    </div>

                    <!-- Preview (Show if image URL exists) -->
                    <img :src="imageUrl" class="absolute inset-0 w-full h-full object-cover z-10" x-show="imageUrl">

                    <!-- Overlay -->
                    <div class="absolute inset-0 z-20 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity"
                        x-show="imageUrl">
                        <span class="text-white text-xs font-bold">Ganti Gambar</span>
                    </div>
                </div>
                @error('thumbnail')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

            </div>

        </div>
    </form>

    <script>
        function imagePreview() {
            return {
                imageUrl: "{{ $beritum->thumbnail ? asset('storage/' . $beritum->thumbnail) : '' }}",
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