@extends('layouts.dashboard')

@section('title', 'Tulis Berita Baru')

@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>

{{-- Back + Header --}}
<div class="mb-5">
    <a href="{{ route('dashboard.berita.index') }}"
       class="inline-flex items-center gap-1.5 text-sm mb-3 transition-colors"
       style="color: var(--dp-text-secondary);"
       onmouseover="this.style.color='var(--dp-bg-primary)'"
       onmouseout="this.style.color='var(--dp-text-secondary)'">
        <span class="material-symbols-outlined text-base">arrow_back</span>
        Kembali ke Daftar
    </a>
    <h1 class="font-display font-bold text-2xl" style="color: var(--dp-text-primary);">Tulis Berita Baru</h1>
</div>

<form action="{{ route('dashboard.berita.store') }}" method="POST" enctype="multipart/form-data"
      class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    @csrf

    {{-- ===== LEFT: Content ===== --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Judul --}}
        <div class="rounded-xl p-5"
             style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
            <label class="block text-xs font-bold uppercase tracking-widest mb-2"
                   style="color: var(--dp-text-secondary);">Judul Berita</label>
            <input type="text" name="judul" value="{{ old('judul') }}" required
                   placeholder="Masukkan judul berita yang menarik..."
                   class="w-full px-4 py-3 rounded-lg font-display font-bold text-xl outline-none transition-colors"
                   style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);"
                   onfocus="this.style.borderColor='var(--dp-gold)'"
                   onblur="this.style.borderColor='var(--dp-border)'">
            @error('judul')
                <p class="text-xs mt-1.5" style="color: var(--dp-danger);">{{ $message }}</p>
            @enderror
        </div>

        {{-- Ringkasan --}}
        <div class="rounded-xl p-5"
             style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
            <label class="block text-xs font-bold uppercase tracking-widest mb-2"
                   style="color: var(--dp-text-secondary);">
                Ringkasan
                <span class="normal-case text-[10px] font-normal ml-1" style="color: var(--dp-text-secondary);">
                    (opsional — muncul di preview berita, maks 500 karakter)
                </span>
            </label>
            <textarea name="ringkasan" rows="3" maxlength="500"
                      placeholder="Tulis ringkasan singkat berita ini..."
                      class="w-full px-4 py-3 rounded-lg text-sm outline-none transition-colors resize-none"
                      style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);"
                      onfocus="this.style.borderColor='var(--dp-gold)'"
                      onblur="this.style.borderColor='var(--dp-border)'">{{ old('ringkasan') }}</textarea>
            @error('ringkasan')
                <p class="text-xs mt-1.5" style="color: var(--dp-danger);">{{ $message }}</p>
            @enderror
        </div>

        {{-- Konten --}}
        <div class="rounded-xl p-5"
             style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
            <label class="block text-xs font-bold uppercase tracking-widest mb-2"
                   style="color: var(--dp-text-secondary);">Isi Berita</label>
            <textarea id="konten" name="konten">{{ old('konten') }}</textarea>
            @error('konten')
                <p class="text-xs mt-1.5" style="color: var(--dp-danger);">{{ $message }}</p>
            @enderror
        </div>

    </div>

    {{-- ===== RIGHT: Meta ===== --}}
    <div class="space-y-5">

        {{-- Publikasi --}}
        <div class="rounded-xl p-5"
             style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
            <h3 class="font-display font-bold text-base mb-4" style="color: var(--dp-text-primary);">Publikasi</h3>

            <div class="space-y-4 mb-5">
                {{-- Status --}}
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest mb-1.5"
                           style="color: var(--dp-text-secondary);">Status</label>
                    <select name="status"
                            class="w-full px-3 py-2.5 rounded-lg text-sm outline-none"
                            style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
                        <option value="draft"     {{ old('status') === 'draft'     ? 'selected' : '' }}>Draft (Simpan Dulu)</option>
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published (Tayang)</option>
                        <option value="archived"  {{ old('status') === 'archived'  ? 'selected' : '' }}>Archived (Arsip)</option>
                    </select>
                </div>

                {{-- Jenis --}}
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest mb-1.5"
                           style="color: var(--dp-text-secondary);">Jenis Konten</label>
                    <select name="jenis"
                            class="w-full px-3 py-2.5 rounded-lg text-sm outline-none"
                            style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
                        <option value="berita"      {{ old('jenis') === 'berita'      ? 'selected' : '' }}>Berita</option>
                        <option value="opini"       {{ old('jenis') === 'opini'       ? 'selected' : '' }}>Opini</option>
                        <option value="pengumuman"  {{ old('jenis') === 'pengumuman'  ? 'selected' : '' }}>Pengumuman</option>
                        <option value="foto"        {{ old('jenis') === 'foto'        ? 'selected' : '' }}>Foto</option>
                    </select>
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest mb-1.5"
                           style="color: var(--dp-text-secondary);">Kategori</label>
                    <select name="kategori_id"
                            class="w-full px-3 py-2.5 rounded-lg text-sm outline-none"
                            style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}"
                                    {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="text-xs mt-1.5" style="color: var(--dp-danger);">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Headline Toggle --}}
                <label class="flex items-center gap-3 cursor-pointer py-2 px-3 rounded-lg transition-colors"
                       style="border: 1px solid var(--dp-border-gold); background: var(--dp-gold-tint);">
                    <input type="hidden" name="is_headline" value="0">
                    <input type="checkbox" name="is_headline" value="1"
                           {{ old('is_headline') ? 'checked' : '' }}
                           class="w-4 h-4 rounded accent-[#08332c]">
                    <div>
                        <div class="text-sm font-semibold" style="color: var(--dp-gold);">★ Headline</div>
                        <div class="text-[10px]" style="color: var(--dp-text-secondary);">Tampilkan di posisi utama</div>
                    </div>
                </label>
            </div>

            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 py-3 rounded-lg font-bold text-sm transition-colors"
                    style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);"
                    onmouseover="this.style.background='var(--dp-bg-primary-hover)'"
                    onmouseout="this.style.background='var(--dp-bg-primary)'">
                <span class="material-symbols-outlined text-lg">save</span>
                Simpan Berita
            </button>
        </div>

        {{-- Gambar Unggulan --}}
        <div class="rounded-xl p-5"
             style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);"
             x-data="imagePreview()">
            <h3 class="font-display font-bold text-base mb-3" style="color: var(--dp-text-primary);">Gambar Unggulan</h3>

            <div class="relative w-full aspect-video rounded-xl overflow-hidden cursor-pointer group"
                 style="background: var(--dp-bg-surface-2); border: 2px dashed var(--dp-border-strong);"
                 onmouseover="this.style.borderColor='var(--dp-gold)'"
                 onmouseout="this.style.borderColor='var(--dp-border-strong)'">
                <input type="file" name="thumbnail" accept="image/*"
                       class="absolute inset-0 z-20 opacity-0 cursor-pointer w-full h-full"
                       @change="previewImage">

                <div class="absolute inset-0 z-10 flex flex-col items-center justify-center gap-2"
                     x-show="!imageUrl">
                    <span class="material-symbols-outlined text-4xl" style="color: var(--dp-border-strong);">add_photo_alternate</span>
                    <span class="text-xs font-medium" style="color: var(--dp-text-secondary);">Upload Thumbnail</span>
                    <span class="text-[10px]" style="color: var(--dp-text-secondary);">Maks 2MB · Rasio 16:9</span>
                    <span class="text-[10px] text-center px-4" style="color: var(--dp-text-secondary);">Jika berita ini jadi headline utama, tampilan akan sedikit berbeda proporsinya (rasio 4:3, bento grid besar)</span>
                </div>

                <img :src="imageUrl" class="absolute inset-0 w-full h-full object-cover z-10"
                     x-show="imageUrl" style="display:none;">

                <div class="absolute inset-0 z-20 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity"
                     x-show="imageUrl" style="display:none;">
                    <span class="text-white text-xs font-bold">Ganti Gambar</span>
                </div>
            </div>
            @error('thumbnail')
                <p class="text-xs mt-1.5" style="color: var(--dp-danger);">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tags --}}
        <div class="rounded-xl p-5"
             style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);"
             x-data="tagInput('{{ old('tags_input', '') }}')">

            <h3 class="font-display font-bold text-base mb-1" style="color: var(--dp-text-primary);">Tags</h3>
            <p class="text-[10px] mb-3" style="color: var(--dp-text-secondary);">Pilih atau ketik tag baru, pisahkan dengan koma</p>

            {{-- Tag chips dari DB --}}
            @if($allTags->isNotEmpty())
                <div class="flex flex-wrap gap-1.5 mb-3">
                    @foreach($allTags as $tag)
                        <button type="button"
                                @click="toggleTag('{{ $tag->nama }}')"
                                :class="isSelected('{{ $tag->nama }}') ? 'tag-active' : 'tag-idle'"
                                class="px-2.5 py-1 rounded text-[11px] font-semibold transition-colors tag-chip">
                            #{{ $tag->nama }}
                        </button>
                    @endforeach
                </div>
            @endif

            {{-- Input tag baru --}}
            <input type="text"
                   placeholder="Ketik tag baru, enter untuk tambah..."
                   class="w-full px-3 py-2 rounded-lg text-sm outline-none mb-3"
                   style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);"
                   onfocus="this.style.borderColor='var(--dp-gold)'"
                   onblur="this.style.borderColor='var(--dp-border)'"
                   @keydown.enter.prevent="addTag($event.target.value); $event.target.value = ''"
                   @keydown.comma.prevent="addTag($event.target.value); $event.target.value = ''">

            {{-- Selected tags preview --}}
            <div class="flex flex-wrap gap-1.5" x-show="selectedTags.length > 0">
                <template x-for="t in selectedTags" :key="t">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-semibold"
                          style="background: var(--dp-gold-tint); color: var(--dp-gold);">
                        <span x-text="'#' + t"></span>
                        <button type="button" @click="removeTag(t)"
                                class="hover:opacity-70 transition-opacity leading-none">×</button>
                    </span>
                </template>
            </div>

            {{-- Hidden input --}}
            <input type="hidden" name="tags_input" :value="selectedTags.join(',')">
        </div>

    </div>
</form>

<style>
    .tag-chip.tag-active {
        background: var(--dp-bg-primary);
        color: var(--dp-gold);
    }
    .tag-chip.tag-idle {
        background: var(--dp-bg-surface-2);
        color: var(--dp-text-secondary);
        border: 1px solid var(--dp-border);
    }
    .tag-chip.tag-idle:hover {
        border-color: var(--dp-gold);
        color: var(--dp-gold);
    }
</style>

<script>
    function imagePreview() {
        return {
            imageUrl: null,
            previewImage(event) {
                const file = event.target.files[0];
                if (file) this.imageUrl = URL.createObjectURL(file);
            }
        };
    }

    function tagInput(initial) {
        return {
            selectedTags: initial ? initial.split(',').map(t => t.trim()).filter(t => t) : [],
            isSelected(name) { return this.selectedTags.includes(name); },
            toggleTag(name) {
                if (this.isSelected(name)) {
                    this.removeTag(name);
                } else {
                    this.addTag(name);
                }
            },
            addTag(name) {
                name = name.trim();
                if (name && !this.isSelected(name)) {
                    this.selectedTags.push(name);
                }
            },
            removeTag(name) {
                this.selectedTags = this.selectedTags.filter(t => t !== name);
            }
        };
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
            xhr.upload.onprogress = (e) => { progress(e.loaded / e.total * 100); };
            xhr.onload = () => {
                if (xhr.status === 403) { reject({ message: 'HTTP Error: ' + xhr.status, remove: true }); return; }
                if (xhr.status < 200 || xhr.status >= 300) { reject('HTTP Error: ' + xhr.status); return; }
                const json = JSON.parse(xhr.responseText);
                if (!json || typeof json.location != 'string') { reject('Invalid JSON: ' + xhr.responseText); return; }
                resolve(json.location);
            };
            xhr.onerror = () => { reject('Image upload failed. Code: ' + xhr.status); };
            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        }),
        min_height: 450,
        promotion: false,
        skin: document.documentElement.classList.contains('dark') ? 'oxide-dark' : 'oxide',
        content_css: document.documentElement.classList.contains('dark') ? 'dark' : 'default',
        setup: function (editor) {
            editor.on('change', function () { tinymce.triggerSave(); });
        }
    });
</script>

@endsection
