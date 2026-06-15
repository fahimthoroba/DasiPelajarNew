@extends('layouts.dashboard')

@section('title', 'Edit Slide Hero')

@section('content')
<div class="max-w-2xl">
    <div class="mb-5">
        <a href="{{ route('dashboard.media-visual.index') }}"
           class="inline-flex items-center gap-1.5 text-sm mb-3 transition-colors"
           style="color: var(--dp-text-secondary);"
           onmouseover="this.style.color='var(--dp-bg-primary)'"
           onmouseout="this.style.color='var(--dp-text-secondary)'">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            Kembali ke Media Visual
        </a>
        <h1 class="font-display font-bold text-2xl" style="color: var(--dp-text-primary);">Edit Slide</h1>
    </div>

    <form action="{{ route('dashboard.media-visual.slider.update', $slider) }}" method="POST" enctype="multipart/form-data"
          class="space-y-5" x-data="imagePreview('{{ asset('storage/'.$slider->gambar_path) }}')">
        @csrf
        @method('PUT')

        {{-- Gambar --}}
        <div class="rounded-xl p-5" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
            <label class="block text-[10px] font-bold uppercase tracking-widest mb-3" style="color: var(--dp-text-secondary);">
                Gambar Banner
            </label>
            <div class="relative w-full aspect-video rounded-lg overflow-hidden cursor-pointer group"
                 style="background: var(--dp-bg-surface-2); border: 2px dashed var(--dp-border-strong);"
                 onmouseover="this.style.borderColor='var(--dp-gold)'"
                 onmouseout="this.style.borderColor='var(--dp-border-strong)'">
                <input type="file" name="gambar_path" accept="image/*"
                       class="absolute inset-0 z-20 opacity-0 cursor-pointer w-full h-full"
                       @change="previewImage">
                <div class="absolute inset-0 z-10 flex flex-col items-center justify-center gap-2" x-show="!imageUrl">
                    <span class="material-symbols-outlined text-4xl" style="color: var(--dp-border-strong);">add_photo_alternate</span>
                    <span class="text-xs" style="color: var(--dp-text-secondary);">Klik untuk ganti gambar</span>
                </div>
                <img :src="imageUrl" class="absolute inset-0 w-full h-full object-cover z-10" x-show="imageUrl">
                <div class="absolute inset-0 z-20 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity" x-show="imageUrl">
                    <span class="text-white text-xs font-bold">Ganti Gambar</span>
                </div>
            </div>
        </div>

        {{-- Teks Opsional --}}
        <div class="rounded-xl p-5" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
            <p class="text-[10px] font-bold uppercase tracking-widest mb-4" style="color: var(--dp-text-secondary);">Teks Overlay (Opsional)</p>
            <div class="space-y-4">
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest mb-1.5" style="color: var(--dp-text-secondary);">Label</label>
                    <input type="text" name="label" value="{{ old('label', $slider->label) }}"
                           placeholder="Contoh: Suara Pelajar Kediri"
                           class="w-full px-3 py-2.5 rounded-lg text-sm outline-none"
                           style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);"
                           onfocus="this.style.borderColor='var(--dp-gold)'"
                           onblur="this.style.borderColor='var(--dp-border)'">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest mb-1.5" style="color: var(--dp-text-secondary);">Judul Utama</label>
                    <input type="text" name="judul_utama" value="{{ old('judul_utama', $slider->judul_utama) }}"
                           class="w-full px-3 py-2.5 rounded-lg font-display font-bold text-base outline-none"
                           style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);"
                           onfocus="this.style.borderColor='var(--dp-gold)'"
                           onblur="this.style.borderColor='var(--dp-border)'">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest mb-1.5" style="color: var(--dp-text-secondary);">Sub Judul</label>
                    <input type="text" name="sub_judul" value="{{ old('sub_judul', $slider->sub_judul) }}"
                           class="w-full px-3 py-2.5 rounded-lg text-sm outline-none"
                           style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);"
                           onfocus="this.style.borderColor='var(--dp-gold)'"
                           onblur="this.style.borderColor='var(--dp-border)'">
                </div>
            </div>
        </div>

        {{-- Pengaturan --}}
        <div class="rounded-xl p-5" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
            <p class="text-[10px] font-bold uppercase tracking-widest mb-4" style="color: var(--dp-text-secondary);">Pengaturan</p>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest mb-1.5" style="color: var(--dp-text-secondary);">Urutan Tampil</label>
                    <input type="number" name="urutan" value="{{ old('urutan', $slider->urutan) }}" min="0"
                           class="w-full px-3 py-2.5 rounded-lg text-sm outline-none"
                           style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest mb-1.5" style="color: var(--dp-text-secondary);">Link Tombol</label>
                    <input type="url" name="link_tombol" value="{{ old('link_tombol', $slider->link_tombol) }}" placeholder="https://..."
                           class="w-full px-3 py-2.5 rounded-lg text-sm outline-none"
                           style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);"
                           onfocus="this.style.borderColor='var(--dp-gold)'"
                           onblur="this.style.borderColor='var(--dp-border)'">
                </div>
            </div>
            <label class="flex items-center gap-2 text-sm cursor-pointer" style="color: var(--dp-text-secondary);">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" {{ $slider->is_active ? 'checked' : '' }} class="rounded accent-[#08332c]">
                Status Aktif
            </label>
        </div>

        <button type="submit"
                class="w-full flex items-center justify-center gap-2 py-3 rounded-xl font-bold text-sm transition-colors"
                style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);"
                onmouseover="this.style.background='var(--dp-bg-primary-hover)'"
                onmouseout="this.style.background='var(--dp-bg-primary)'">
            <span class="material-symbols-outlined text-lg">save</span>
            Simpan Perubahan
        </button>
    </form>

    <script>
        function imagePreview(initial) {
            return {
                imageUrl: initial || null,
                previewImage(event) {
                    const file = event.target.files[0];
                    if (file) this.imageUrl = URL.createObjectURL(file);
                }
            };
        }
    </script>
</div>
@endsection
