@extends('layouts.dashboard')

@section('title', 'Media Visual')

@section('content')

{{-- Tab Header --}}
<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h1 class="font-display font-bold text-2xl" style="color: var(--dp-text-primary);">Media Visual</h1>
        <p class="text-sm mt-1" style="color: var(--dp-text-secondary);">Kelola hero slider dan banner iklan website.</p>
    </div>
</div>

{{-- Tabs --}}
<div class="flex gap-1 mb-6 p-1 rounded-xl" style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border);">
    <a href="{{ route('dashboard.media-visual.index', ['tab' => 'slider']) }}"
       class="flex-1 text-center py-2 px-4 rounded-lg text-sm font-semibold transition-colors"
       style="{{ $tab === 'slider' ? 'background: var(--dp-bg-primary); color: var(--dp-text-on-primary);' : 'color: var(--dp-text-secondary);' }}">
        <span class="material-symbols-outlined text-base align-middle mr-1">view_carousel</span>
        Hero Slider
    </a>
    <a href="{{ route('dashboard.media-visual.index', ['tab' => 'iklan']) }}"
       class="flex-1 text-center py-2 px-4 rounded-lg text-sm font-semibold transition-colors"
       style="{{ $tab === 'iklan' ? 'background: var(--dp-bg-primary); color: var(--dp-text-on-primary);' : 'color: var(--dp-text-secondary);' }}">
        <span class="material-symbols-outlined text-base align-middle mr-1">campaign</span>
        Banner Iklan
    </a>
</div>

@if(session('success'))
    <div class="mb-5 px-4 py-3 rounded-lg flex items-center gap-3 text-sm"
         style="background: var(--dp-primary-tint); border: 1px solid var(--dp-border-strong); color: var(--dp-text-primary);">
        <span class="material-symbols-outlined text-lg shrink-0" style="color: var(--dp-status-done);">check_circle</span>
        {{ session('success') }}
    </div>
@endif

{{-- ===== TAB: HERO SLIDER ===== --}}
@if($tab === 'slider')

<div class="flex items-center justify-between mb-4">
    <div class="text-sm font-semibold" style="color: var(--dp-text-secondary);">
        {{ $sliders->count() }} slide aktif
    </div>
    <a href="{{ route('dashboard.media-visual.slider.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-bold transition-colors"
       style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);"
       onmouseover="this.style.background='var(--dp-bg-primary-hover)'"
       onmouseout="this.style.background='var(--dp-bg-primary)'">
        <span class="material-symbols-outlined text-lg">add</span>
        Tambah Slide
    </a>
</div>

@if($sliders->isEmpty())
    <div class="rounded-xl py-20 text-center" style="background: var(--dp-bg-surface); border: 1px dashed var(--dp-border-strong);">
        <span class="material-symbols-outlined text-4xl block mb-3" style="color: var(--dp-text-secondary);">view_carousel</span>
        <div class="font-display font-bold text-lg mb-1" style="color: var(--dp-text-primary);">Belum ada slide</div>
        <p class="text-sm" style="color: var(--dp-text-secondary);">Tambahkan gambar untuk hero slider.</p>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($sliders as $slider)
            <div class="rounded-xl overflow-hidden" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                {{-- Thumbnail --}}
                <div class="relative aspect-video">
                    <img src="{{ asset('storage/' . $slider->gambar_path) }}"
                         class="w-full h-full object-cover" alt="{{ $slider->judul_utama }}">
                    {{-- Status badge --}}
                    <div class="absolute top-2 right-2">
                        @if($slider->is_active)
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold"
                                  style="background: rgba(8,51,44,0.85); color: var(--dp-gold);">Aktif</span>
                        @else
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold"
                                  style="background: rgba(0,0,0,0.6); color: rgba(255,255,255,0.7);">Non-aktif</span>
                        @endif
                    </div>
                    {{-- Urutan badge --}}
                    <div class="absolute top-2 left-2">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold"
                              style="background: rgba(186,158,111,0.9); color: var(--dp-bg-primary);">
                            #{{ $slider->urutan }}
                        </span>
                    </div>
                    {{-- Overlay text --}}
                    @if($slider->judul_utama)
                    <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/70 to-transparent p-3">
                        @if($slider->label)
                            <span class="text-[10px] px-1.5 py-0.5 rounded mb-1 inline-block"
                                  style="background: rgba(186,158,111,0.25); color: #f4f4f4;">
                                {{ $slider->label }}
                            </span>
                        @endif
                        <h3 class="text-white font-bold text-sm leading-tight truncate">{{ $slider->judul_utama }}</h3>
                        @if($slider->sub_judul)
                            <p class="text-white/70 text-xs truncate">{{ $slider->sub_judul }}</p>
                        @endif
                    </div>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-between px-4 py-3"
                     style="border-top: 1px solid var(--dp-border);">
                    <span class="text-xs" style="color: var(--dp-text-secondary);">
                        @if($slider->link_tombol)
                            <span class="material-symbols-outlined text-sm align-middle mr-0.5" style="color: var(--dp-gold);">link</span>
                            Ada link
                        @else
                            Tanpa link
                        @endif
                    </span>
                    <div class="flex items-center gap-1">
                        <a href="{{ route('dashboard.media-visual.slider.edit', $slider) }}"
                           class="p-2 rounded-lg transition-colors" title="Edit"
                           style="color: var(--dp-text-secondary);"
                           onmouseover="this.style.background='var(--dp-primary-tint)'; this.style.color='var(--dp-bg-primary)'"
                           onmouseout="this.style.background='transparent'; this.style.color='var(--dp-text-secondary)'">
                            <span class="material-symbols-outlined text-lg">edit_square</span>
                        </a>
                        <form action="{{ route('dashboard.media-visual.slider.destroy', $slider) }}" method="POST"
                              onsubmit="return confirm('Hapus slide ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 rounded-lg transition-colors" title="Hapus"
                                    style="color: var(--dp-text-secondary);"
                                    onmouseover="this.style.background='var(--dp-danger-tint)'; this.style.color='var(--dp-danger)'"
                                    onmouseout="this.style.background='transparent'; this.style.color='var(--dp-text-secondary)'">
                                <span class="material-symbols-outlined text-lg">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endif {{-- end tab slider --}}

{{-- ===== TAB: BANNER IKLAN ===== --}}
@if($tab === 'iklan')

<div class="space-y-6">
    @foreach($positions as $slug => $info)
        @php $banner = $banners->get($slug); @endphp
        <div class="rounded-xl overflow-hidden" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);"
             x-data="imagePreview('{{ $banner && $banner->gambar_path ? asset('storage/'.$banner->gambar_path) : '' }}')">

            {{-- Position Header --}}
            <div class="flex items-center justify-between px-5 py-4"
                 style="border-bottom: 1px solid var(--dp-border); background: var(--dp-bg-surface-2);">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center"
                         style="background: var(--dp-primary-tint); color: var(--dp-bg-primary);">
                        <span class="material-symbols-outlined text-lg">{{ $info['icon'] }}</span>
                    </div>
                    <div>
                        <div class="font-display font-bold text-sm" style="color: var(--dp-text-primary);">
                            {{ $info['nama'] }}
                        </div>
                        <div class="text-xs" style="color: var(--dp-text-secondary);">
                            {{ $info['ukuran'] }} &mdash; {{ $info['lokasi'] }}
                        </div>
                    </div>
                </div>
                {{-- Status badge --}}
                @if($banner && $banner->gambar_path)
                    <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-1 rounded"
                          style="background: rgba(8,51,44,0.10); color: var(--dp-status-done);">
                        Terpasang
                    </span>
                @else
                    <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-1 rounded"
                          style="background: var(--dp-bg-surface-2); color: var(--dp-text-secondary); border: 1px solid var(--dp-border);">
                        Kosong
                    </span>
                @endif
            </div>

            {{-- Content: Preview + Form --}}
            <div class="p-5 grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Preview --}}
                <div>
                    <div class="text-[10px] font-bold uppercase tracking-widest mb-2" style="color: var(--dp-text-secondary);">
                        Preview Saat Ini
                    </div>
                    <div class="rounded-lg overflow-hidden flex items-center justify-center"
                         style="background: var(--dp-bg-surface-2); border: 1px dashed var(--dp-border-strong); min-height: {{ $slug === 'sidebar_berita' ? '200px' : '100px' }};">
                        @if($banner && $banner->gambar_path)
                            <img src="{{ asset('storage/'.$banner->gambar_path) }}"
                                 class="w-full h-full object-contain" alt="{{ $info['nama'] }}">
                        @else
                            <div class="text-center py-6 px-4">
                                <span class="material-symbols-outlined text-2xl block mb-1" style="color: var(--dp-border-strong);">image</span>
                                <p class="text-xs" style="color: var(--dp-text-secondary);">Belum ada banner</p>
                            </div>
                        @endif
                    </div>
                    @if($banner && $banner->link_url)
                        <div class="mt-2 text-xs flex items-center gap-1" style="color: var(--dp-text-secondary);">
                            <span class="material-symbols-outlined text-sm" style="color: var(--dp-gold);">link</span>
                            <span class="truncate">{{ $banner->link_url }}</span>
                        </div>
                    @endif
                </div>

                {{-- Upload Form --}}
                <div>
                    <div class="text-[10px] font-bold uppercase tracking-widest mb-2" style="color: var(--dp-text-secondary);">
                        Upload Banner Baru
                    </div>
                    <form action="{{ route('dashboard.media-visual.banner.update', $slug) }}" method="POST"
                          enctype="multipart/form-data" class="space-y-3">
                        @csrf

                        {{-- Image Upload Area --}}
                        <div class="relative rounded-lg overflow-hidden cursor-pointer group"
                             style="background: var(--dp-bg-surface-2); border: 2px dashed var(--dp-border-strong); min-height: 80px;"
                             onmouseover="this.style.borderColor='var(--dp-gold)'"
                             onmouseout="this.style.borderColor='var(--dp-border-strong)'">
                            <input type="file" name="gambar" accept="image/*"
                                   class="absolute inset-0 z-20 opacity-0 cursor-pointer w-full h-full"
                                   @change="previewImage">
                            <div class="flex flex-col items-center justify-center py-6 gap-1" x-show="!imageUrl">
                                <span class="material-symbols-outlined text-2xl" style="color: var(--dp-border-strong);">add_photo_alternate</span>
                                <span class="text-xs" style="color: var(--dp-text-secondary);">
                                    Klik atau seret gambar &middot; {{ $info['ukuran'] }}
                                </span>
                            </div>
                            <img :src="imageUrl" class="w-full object-contain max-h-32" x-show="imageUrl" style="display:none;">
                        </div>

                        {{-- Link URL --}}
                        <input type="url" name="link_url"
                               value="{{ $banner?->link_url }}"
                               placeholder="https://... (opsional, URL saat banner diklik)"
                               class="w-full px-3 py-2 rounded-lg text-sm outline-none"
                               style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);"
                               onfocus="this.style.borderColor='var(--dp-gold)'"
                               onblur="this.style.borderColor='var(--dp-border)'">

                        {{-- Active toggle --}}
                        <label class="flex items-center gap-2 text-sm cursor-pointer" style="color: var(--dp-text-secondary);">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1"
                                   {{ ($banner && $banner->is_active) || !$banner ? 'checked' : '' }}
                                   class="rounded accent-[#08332c]">
                            Tampilkan banner ini di website
                        </label>

                        <div class="flex gap-2">
                            <button type="submit"
                                    class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-lg text-sm font-bold transition-colors"
                                    style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);"
                                    onmouseover="this.style.background='var(--dp-bg-primary-hover)'"
                                    onmouseout="this.style.background='var(--dp-bg-primary)'">
                                <span class="material-symbols-outlined text-sm">upload</span>
                                Pasang Banner
                            </button>
                            @if($banner && $banner->gambar_path)
                                <form action="{{ route('dashboard.media-visual.banner.clear', $slug) }}" method="POST"
                                      onsubmit="return confirm('Hapus banner ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-2.5 rounded-lg text-sm font-bold transition-colors"
                                            style="background: var(--dp-danger-tint); color: var(--dp-danger); border: 1px solid var(--dp-danger);"
                                            title="Hapus banner">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </form>
                </div>

            </div>
        </div>
    @endforeach
</div>

@endif {{-- end tab iklan --}}

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

@endsection
