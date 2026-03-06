@extends('layouts.dashboard')

@section('title', 'Tulis Berita Baru')

@section('content')
    <!-- TinyMCE -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>

    <div class="mb-6">
        <a href="{{ route('dashboard.berita.index') }}"
            class="inline-flex items-center gap-2 text-gray-500 hover:text-emerald-600 transition-colors mb-2 text-sm">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Kembali ke Daftar
        </a>
        <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Tulis Berita Baru</h1>
    </div>

    <form action="{{ route('dashboard.berita.store') }}" method="POST" enctype="multipart/form-data"
        class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf

        <!-- Left Column: Content -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Title -->
            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Judul Berita</label>
                    <input type="text" name="judul" value="{{ old('judul') }}" required
                        placeholder="Masukkan judul berita yang menarik..."
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-display font-bold text-lg">
                    @error('judul')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Konten Berita</label>
                    <div
                        class="border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-900 overflow-hidden">
                        <textarea id="konten" name="konten" placeholder="Mulai menulis cerita...">{{ old('konten') }}</textarea>
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
                            <option value="published">Published (Tayang)</option>
                            <option value="draft">Draft (Simpan Dulu)</option>
                            <option value="archived">Archived (Arsip)</option>
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
                    </div>
                </div>

                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-emerald-600/20 transition-all">
                    <span class="material-symbols-outlined">save</span>
                    Simpan Berita
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

                    <!-- Placeholder -->
                    <div class="absolute inset-0 z-10 flex flex-col items-center justify-center text-gray-400 group-hover:text-emerald-500 transition-colors"
                        x-show="!imageUrl">
                        <span class="material-symbols-outlined text-4xl mb-2">add_photo_alternate</span>
                        <span class="text-xs font-medium">Upload Thumbnail</span>
                        <span class="text-[10px] mt-1 text-gray-400">Max 2MB. Ratio 16:9 recommended.</span>
                    </div>

                    <!-- Preview -->
                    <img :src="imageUrl" class="absolute inset-0 w-full h-full object-cover z-10" x-show="imageUrl"
                        style="display: none;">

                    <!-- Overlay on Hover when Image Exists -->
                    <div class="absolute inset-0 z-20 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity"
                        x-show="imageUrl" style="display: none;">
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
                imageUrl: null,
                previewImage(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.imageUrl = URL.createObjectURL(file);
                    }
                }
            }
        }

        tinymce.init({
            selector: '#konten',
            plugins: 'image link media autolink lists code table wordcount directionality advlist',
            toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image link media | code',
            image_advtab: true,
            automatic_uploads: true,
            images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '{{ route("dashboard.berita.upload_image", [], false) }}');
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                xhr.upload.onprogress = (e) => {
                    progress(e.loaded / e.total * 100);
                };

                xhr.onload = () => {
                    if (xhr.status === 403) {
                        reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                        return;
                    }
                    if (xhr.status < 200 || xhr.status >= 300) {
                        reject('HTTP Error: ' + xhr.status);
                        return;
                    }
                    const json = JSON.parse(xhr.responseText);
                    if (!json || typeof json.location != 'string') {
                        reject('Invalid JSON: ' + xhr.responseText);
                        return;
                    }
                    resolve(json.location);
                };

                xhr.onerror = () => {
                    reject('Image upload failed. Code: ' + xhr.status);
                };

                const formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            }),
            file_picker_types: 'image',
            file_picker_callback: function (cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                input.onchange = function () {
                    var file = this.files[0];
                    var reader = new FileReader();

                    reader.onload = function () {
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);

                        cb(blobInfo.blobUri(), { title: file.name });
                    };
                    reader.readAsDataURL(file);
                };

                input.click();
            },
            min_height: 400,
            promotion: false,
            skin: document.documentElement.classList.contains('dark') ? 'oxide-dark' : 'oxide',
            content_css: document.documentElement.classList.contains('dark') ? 'dark' : 'default',
            setup: function (editor) {
                editor.on('change', function () {
                    tinymce.triggerSave();
                });
            }
        });
    </script>
@endsection