@extends('layouts.dashboard')

@section('title', 'Kategori Berita')

@section('content')

<div class="flex flex-col lg:flex-row gap-6">

    {{-- === KIRI: Daftar Kategori === --}}
    <div class="flex-1 min-w-0">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="font-display font-bold text-2xl" style="color: var(--dp-text-primary);">Kategori Berita</h1>
                <p class="text-sm mt-0.5" style="color: var(--dp-text-secondary);">
                    {{ $kategoris->count() }} kategori tersedia
                </p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 px-4 py-3 rounded-lg flex items-center gap-3 text-sm"
                 style="background: var(--dp-primary-tint); border: 1px solid var(--dp-border-strong); color: var(--dp-text-primary);">
                <span class="material-symbols-outlined text-lg shrink-0" style="color: var(--dp-status-done);">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-xl overflow-hidden" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">

            {{-- Header --}}
            <div class="grid grid-cols-[1fr_auto_auto_auto] items-center px-5 py-3 text-[10px] font-bold uppercase tracking-widest"
                 style="background: var(--dp-bg-surface-2); border-bottom: 1px solid var(--dp-border); color: var(--dp-text-secondary);">
                <span>Nama Kategori</span>
                <span class="px-4">Slug</span>
                <span class="px-4">Berita</span>
                <span>Aksi</span>
            </div>

            @forelse($kategoris as $kategori)
                <div class="grid grid-cols-[1fr_auto_auto_auto] items-center px-5 py-4 transition-colors"
                     style="border-bottom: 1px solid var(--dp-border);"
                     onmouseover="this.style.background='var(--dp-primary-tint)'"
                     onmouseout="this.style.background='transparent'"
                     x-data="{ editing: false }">

                    {{-- Name (normal) --}}
                    <div x-show="!editing">
                        <div class="font-display font-bold text-sm" style="color: var(--dp-text-primary);">
                            {{ $kategori->nama }}
                        </div>
                    </div>

                    {{-- Name (editing) --}}
                    <form x-show="editing" action="{{ route('dashboard.kategori.update', $kategori) }}" method="POST"
                          class="flex items-center gap-2" x-cloak>
                        @csrf @method('PUT')
                        <input type="text" name="nama" value="{{ $kategori->nama }}" required
                               class="px-3 py-1.5 rounded-lg text-sm outline-none"
                               style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-gold); color: var(--dp-text-primary);"
                               @keydown.escape="editing = false">
                        <button type="submit" class="p-1.5 rounded-lg transition-colors"
                                style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);">
                            <span class="material-symbols-outlined text-sm">check</span>
                        </button>
                        <button type="button" @click="editing = false" class="p-1.5 rounded-lg"
                                style="color: var(--dp-text-secondary);">
                            <span class="material-symbols-outlined text-sm">close</span>
                        </button>
                    </form>

                    {{-- Slug --}}
                    <div class="px-4">
                        <code class="text-xs px-2 py-0.5 rounded"
                              style="background: var(--dp-bg-surface-2); color: var(--dp-text-secondary);">
                            {{ $kategori->slug }}
                        </code>
                    </div>

                    {{-- Berita count --}}
                    <div class="px-4 text-center">
                        <span class="text-xs font-bold px-2 py-0.5 rounded"
                              style="background: var(--dp-primary-tint); color: var(--dp-text-secondary);">
                            {{ $kategori->beritas_count ?? ($kategori->beritas()->count()) }}
                        </span>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-1">
                        <button type="button" @click="editing = !editing"
                                class="p-2 rounded-lg transition-colors" title="Edit"
                                style="color: var(--dp-text-secondary);"
                                onmouseover="this.style.background='var(--dp-primary-tint)'; this.style.color='var(--dp-bg-primary)'"
                                onmouseout="this.style.background='transparent'; this.style.color='var(--dp-text-secondary)'">
                            <span class="material-symbols-outlined text-lg">edit_square</span>
                        </button>
                        <form action="{{ route('dashboard.kategori.destroy', $kategori) }}" method="POST"
                              onsubmit="return confirm('Hapus kategori {{ $kategori->nama }}? Semua berita akan kehilangan kategori ini.');">
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
            @empty
                <div class="py-16 text-center px-4">
                    <span class="material-symbols-outlined text-3xl block mb-3" style="color: var(--dp-text-secondary);">label</span>
                    <div class="font-display font-bold mb-1" style="color: var(--dp-text-primary);">Belum ada kategori</div>
                    <p class="text-sm" style="color: var(--dp-text-secondary);">Tambahkan kategori pertama di sebelah kanan.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- === KANAN: Form Tambah === --}}
    <div class="w-full lg:w-72 shrink-0">
        <div class="rounded-xl p-5 sticky top-20" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
            <h3 class="font-display font-bold text-base mb-1" style="color: var(--dp-text-primary);">Tambah Kategori</h3>
            <p class="text-xs mb-4" style="color: var(--dp-text-secondary);">
                Slug otomatis dibuat dari nama kategori.
            </p>
            <form action="{{ route('dashboard.kategori.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest mb-1.5"
                           style="color: var(--dp-text-secondary);">Nama Kategori</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required
                           placeholder="Contoh: Kaderisasi, Kegiatan..."
                           class="w-full px-3 py-2.5 rounded-lg text-sm outline-none"
                           style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);"
                           onfocus="this.style.borderColor='var(--dp-gold)'"
                           onblur="this.style.borderColor='var(--dp-border)'">
                    @error('nama')
                        <p class="text-xs mt-1.5" style="color: var(--dp-danger);">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 py-2.5 rounded-lg font-bold text-sm transition-colors"
                        style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);"
                        onmouseover="this.style.background='var(--dp-bg-primary-hover)'"
                        onmouseout="this.style.background='var(--dp-bg-primary)'">
                    <span class="material-symbols-outlined text-lg">add</span>
                    Simpan Kategori
                </button>
            </form>

            <div class="mt-5 pt-5" style="border-top: 1px solid var(--dp-border);">
                <p class="text-[10px] font-bold uppercase tracking-widest mb-2" style="color: var(--dp-text-secondary);">Catatan</p>
                <ul class="text-xs space-y-1" style="color: var(--dp-text-secondary);">
                    <li>&bull; Klik ikon edit pada baris untuk rename langsung</li>
                    <li>&bull; Hapus hanya jika tidak ada berita yang menggunakan kategori tersebut</li>
                </ul>
            </div>
        </div>
    </div>

</div>
@endsection
