@extends('layouts.dashboard')

@section('title', 'Buat Sesi Absensi')

@section('content')

{{-- Back + Header --}}
<div class="mb-5">
    <a href="{{ route('dashboard.kaderisasi.absensi.index') }}"
       class="inline-flex items-center gap-1.5 text-sm mb-3 transition-colors"
       style="color: var(--dp-text-secondary);"
       onmouseover="this.style.color='var(--dp-bg-primary)'"
       onmouseout="this.style.color='var(--dp-text-secondary)'">
        <span class="material-symbols-outlined text-base">arrow_back</span>
        Kembali ke Daftar
    </a>
    <h1 class="font-display font-bold text-2xl" style="color: var(--dp-text-primary);">Buat Sesi Absensi</h1>
</div>

{{-- Alert --}}
@if(session('error'))
    <div class="mb-4 px-4 py-3 rounded-lg flex items-center gap-3 text-sm"
         style="background: var(--dp-danger-tint); border: 1px solid var(--dp-danger); color: var(--dp-danger);">
        <span class="material-symbols-outlined text-lg shrink-0">error</span>
        {{ session('error') }}
    </div>
@endif

<form action="{{ route('dashboard.kaderisasi.absensi.store') }}" method="POST">
    @csrf

    <div class="max-w-2xl space-y-5">

        {{-- Main Fields Card --}}
        <div class="rounded-xl p-5" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
            <h3 class="font-display font-bold text-base mb-4" style="color: var(--dp-text-primary);">Informasi Sesi</h3>

            <div class="space-y-4">

                {{-- Judul --}}
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest mb-1.5"
                           style="color: var(--dp-text-secondary);">Judul Sesi <span style="color: var(--dp-danger);">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul') }}" required
                           placeholder="Contoh: Rapat Rutin Bulanan Maret 2026"
                           class="w-full px-4 py-3 rounded-lg text-sm outline-none transition-colors"
                           style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);"
                           onfocus="this.style.borderColor='var(--dp-gold)'"
                           onblur="this.style.borderColor='var(--dp-border)'">
                    @error('judul')
                        <p class="text-xs mt-1.5" style="color: var(--dp-danger);">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jenis --}}
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest mb-1.5"
                           style="color: var(--dp-text-secondary);">Jenis Sesi <span style="color: var(--dp-danger);">*</span></label>
                    <select name="jenis" required
                            class="w-full px-3 py-2.5 rounded-lg text-sm outline-none"
                            style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
                        <option value="">-- Pilih Jenis --</option>
                        <option value="rapat_rutin" {{ old('jenis') === 'rapat_rutin' ? 'selected' : '' }}>Rapat Rutin</option>
                        <option value="rapat_departemen" {{ old('jenis') === 'rapat_departemen' ? 'selected' : '' }}>Rapat Departemen</option>
                        <option value="rapat_panitia" {{ old('jenis') === 'rapat_panitia' ? 'selected' : '' }}>Rapat Panitia</option>
                        <option value="pelaksanaan" {{ old('jenis') === 'pelaksanaan' ? 'selected' : '' }}>Pelaksanaan Kegiatan</option>
                        <option value="rapat_pac" {{ old('jenis') === 'rapat_pac' ? 'selected' : '' }}>Rapat PAC</option>
                        <option value="rapat_lembaga" {{ old('jenis') === 'rapat_lembaga' ? 'selected' : '' }}>Rapat Lembaga</option>
                        <option value="rapat_badan" {{ old('jenis') === 'rapat_badan' ? 'selected' : '' }}>Rapat Badan</option>
                    </select>
                    @error('jenis')
                        <p class="text-xs mt-1.5" style="color: var(--dp-danger);">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal & Waktu --}}
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest mb-1.5"
                           style="color: var(--dp-text-secondary);">Tanggal & Waktu <span style="color: var(--dp-danger);">*</span></label>
                    <input type="datetime-local" name="tanggal" value="{{ old('tanggal') }}" required
                           class="w-full px-4 py-3 rounded-lg text-sm outline-none transition-colors"
                           style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);"
                           onfocus="this.style.borderColor='var(--dp-gold)'"
                           onblur="this.style.borderColor='var(--dp-border)'">
                    @error('tanggal')
                        <p class="text-xs mt-1.5" style="color: var(--dp-danger);">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Lokasi --}}
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest mb-1.5"
                           style="color: var(--dp-text-secondary);">Lokasi <span class="normal-case text-[10px] font-normal">(opsional)</span></label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                           placeholder="Contoh: Kantor PC IPNU Kab. Kediri"
                           class="w-full px-4 py-3 rounded-lg text-sm outline-none transition-colors"
                           style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);"
                           onfocus="this.style.borderColor='var(--dp-gold)'"
                           onblur="this.style.borderColor='var(--dp-border)'">
                    @error('lokasi')
                        <p class="text-xs mt-1.5" style="color: var(--dp-danger);">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest mb-1.5"
                           style="color: var(--dp-text-secondary);">Deskripsi <span class="normal-case text-[10px] font-normal">(opsional)</span></label>
                    <textarea name="deskripsi" rows="3"
                              placeholder="Catatan tambahan tentang sesi ini..."
                              class="w-full px-4 py-3 rounded-lg text-sm outline-none transition-colors resize-none"
                              style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);"
                              onfocus="this.style.borderColor='var(--dp-gold)'"
                              onblur="this.style.borderColor='var(--dp-border)'">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-xs mt-1.5" style="color: var(--dp-danger);">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- Program Kerja Info (if linked) --}}
        @if(isset($programKerja) && $programKerja)
            <div class="rounded-xl p-5" style="background: var(--dp-gold-tint); border: 1px solid var(--dp-border-gold);">
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-xl shrink-0 mt-0.5" style="color: var(--dp-gold);">link</span>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest mb-1" style="color: var(--dp-gold);">Terhubung dengan Program Kerja</p>
                        <p class="text-sm font-semibold" style="color: var(--dp-text-primary);">{{ $programKerja->nama }}</p>
                    </div>
                </div>
                <input type="hidden" name="program_kerja_id" value="{{ $programKerja->id }}">
            </div>
        @endif

        {{-- Action Buttons --}}
        <div class="flex items-center gap-3">
            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg text-sm font-bold transition-colors"
                    style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);"
                    onmouseover="this.style.background='var(--dp-bg-primary-hover)'"
                    onmouseout="this.style.background='var(--dp-bg-primary)'">
                <span class="material-symbols-outlined text-lg">qr_code</span>
                Simpan & Tampilkan QR
            </button>

            <a href="{{ route('dashboard.kaderisasi.absensi.index') }}"
               class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg text-sm font-semibold transition-colors"
               style="border: 1px solid var(--dp-border); color: var(--dp-text-secondary);"
               onmouseover="this.style.borderColor='var(--dp-border-strong)'; this.style.color='var(--dp-text-primary)'"
               onmouseout="this.style.borderColor='var(--dp-border)'; this.style.color='var(--dp-text-secondary)'">
                Batal
            </a>
        </div>

    </div>

</form>

@endsection
