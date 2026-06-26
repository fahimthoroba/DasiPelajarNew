@extends('layouts.dashboard')

@section('title', 'Susunan Panitia — ' . $proker->nama_proker)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('dashboard.departemen.proker.show', $proker->id) }}"
            class="w-10 h-10 bg-white dark:bg-gray-800 border border-slate-200 dark:border-white/10 rounded-full flex items-center justify-center text-slate-500 hover:text-[var(--dp-gold)] hover:border-[var(--dp-gold)] transition-all shadow-sm">
            <span class="material-symbols-outlined text-xl">arrow_back</span>
        </a>
        <div>
            <h1 class="text-2xl font-bold font-display" style="color:var(--dp-text-primary)">Susunan Panitia</h1>
            <p class="text-sm" style="color:var(--dp-text-secondary)">{{ $proker->nama_proker }}</p>
        </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div class="p-4 rounded-xl text-sm font-bold flex items-center gap-2 border"
            style="background:rgba(8,51,44,0.06);color:var(--dp-bg-primary);border-color:rgba(8,51,44,0.2)">
            <span class="material-symbols-outlined text-base">check_circle</span> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 rounded-xl text-sm font-bold flex items-center gap-2 border"
            style="background:var(--dp-danger-tint);color:var(--dp-danger);border-color:rgba(232,70,58,0.2)">
            <span class="material-symbols-outlined text-base">warning</span> {{ session('error') }}
        </div>
    @endif

    {{-- FORM BULK --}}
    <form action="{{ route('dashboard.departemen.proker.panitia.bulk-store', $proker->id) }}" method="POST"
        class="space-y-6">
        @csrf

        {{-- === KODE SURAT KEPANITIAAN === --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border shadow-sm p-6" style="border-color:var(--dp-border)">
            <label class="block text-xs font-bold uppercase tracking-wider mb-1.5" style="color:var(--dp-text-secondary)">
                Kode Surat Kepanitiaan <span style="color:var(--dp-danger)">*</span>
            </label>
            <input type="text" name="kode_surat" required
                value="{{ old('kode_surat', $proker->kode_surat_kepanitiaan) }}"
                placeholder="Contoh: MAKESTA"
                class="w-full rounded-lg px-3 py-2.5 text-sm border focus:outline-none transition-all"
                style="background:var(--dp-bg-surface-2);border-color:var(--dp-border);color:var(--dp-text-primary)">
            <p class="text-xs mt-1.5" style="color:var(--dp-text-secondary)">
                Kode singkat untuk nomor surat (tampil sebagai "Pan.{kode}"). Diisi manual, tidak otomatis dari nama program kerja.
            </p>
            @error('kode_surat')
                <p class="text-xs mt-1" style="color:var(--dp-danger)">{{ $message }}</p>
            @enderror
        </div>

        {{-- === BPH === --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border shadow-sm overflow-hidden"
            style="border-color:var(--dp-border)">
            <div class="px-6 py-4 border-b flex items-center gap-3"
                style="background:var(--dp-bg-primary);border-color:rgba(186,158,111,0.3)">
                <span class="material-symbols-outlined" style="color:var(--dp-gold)">star</span>
                <h2 class="font-bold text-base" style="color:var(--dp-text-on-primary)">Panitia Inti (BPH)</h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach(['ketua' => 'Ketua Panitia', 'sekretaris' => 'Sekretaris', 'bendahara' => 'Bendahara'] as $key => $label)
                    @php $selected = $existing->get($label)?->kader_id; @endphp
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider mb-1.5"
                            style="color:var(--dp-text-secondary)">{{ $label }}</label>
                        <select name="bph[{{ $key }}]"
                            class="w-full rounded-lg px-3 py-2.5 text-sm border focus:outline-none transition-all"
                            style="background:var(--dp-bg-surface-2);border-color:var(--dp-border);color:var(--dp-text-primary)">
                            <option value="">— Pilih Kader —</option>
                            @foreach($kaders as $kader)
                                <option value="{{ $kader->id }}" {{ $selected === $kader->id ? 'selected' : '' }}>
                                    {{ $kader->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- === SIE SECTIONS === --}}
        @foreach($sieList as $slug => $label)
            @php
                $coKey          = "CO $label";
                $anggotaKey     = "Anggota $label";
                $existingCo     = $existing->get($coKey)?->kader_id;
                $existingAngIds = $existingAnggota->get($anggotaKey, collect())->pluck('kader_id')->toArray();
            @endphp
            <div class="bg-white dark:bg-gray-800 rounded-2xl border shadow-sm overflow-hidden"
                style="border-color:var(--dp-border)"
                x-data="sieBlock({{ json_encode($existingAngIds) }})">

                {{-- Header Sie --}}
                <div class="px-6 py-3.5 border-b flex items-center justify-between"
                    style="background:var(--dp-bg-surface-2);border-color:var(--dp-border)">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full inline-block" style="background:var(--dp-gold)"></span>
                        <h3 class="font-bold text-sm" style="color:var(--dp-text-primary)">{{ $label }}</h3>
                    </div>
                    <span class="text-xs font-bold px-2 py-0.5 rounded-full" style="background:var(--dp-primary-tint);color:var(--dp-text-secondary)">
                        CO + <span x-text="anggota.length"></span> Anggota
                    </span>
                </div>

                <div class="p-6 space-y-4">
                    {{-- CO --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider mb-1.5"
                            style="color:var(--dp-gold)">Koordinator (CO)</label>
                        <select name="sie[{{ $slug }}][co]"
                            class="w-full rounded-lg px-3 py-2.5 text-sm border focus:outline-none transition-all"
                            style="background:var(--dp-bg-surface-2);border-color:var(--dp-border-gold);color:var(--dp-text-primary)">
                            <option value="">— Pilih CO —</option>
                            @foreach($kaders as $kader)
                                <option value="{{ $kader->id }}" {{ $existingCo === $kader->id ? 'selected' : '' }}>
                                    {{ $kader->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Anggota (dinamis) --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider mb-2"
                            style="color:var(--dp-text-secondary)">Anggota</label>

                        <div class="space-y-2">
                            <template x-for="(kaderId, idx) in anggota" :key="idx">
                                <div class="flex gap-2 items-center">
                                    <select :name="`sie[{{ $slug }}][anggota][${idx}]`"
                                        x-init="$el.value = kaderId"
                                        @change="anggota[idx] = $event.target.value"
                                        class="flex-1 rounded-lg px-3 py-2 text-sm border focus:outline-none transition-all"
                                        style="background:var(--dp-bg-surface-2);border-color:var(--dp-border);color:var(--dp-text-primary)">
                                        <option value="">— Pilih Anggota —</option>
                                        @foreach($kaders as $kader)
                                            <option value="{{ $kader->id }}">{{ $kader->nama_lengkap }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" @click="anggota.splice(idx, 1)"
                                        class="p-2 rounded-lg transition-colors flex-shrink-0 hover:opacity-80"
                                        style="color:var(--dp-danger);background:var(--dp-danger-tint)">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                    </button>
                                </div>
                            </template>
                        </div>

                        <button type="button" @click="anggota.push('')"
                            class="mt-2 text-xs font-bold flex items-center gap-1 px-3 py-1.5 rounded-lg border transition-all hover:opacity-80"
                            style="color:var(--dp-bg-primary);border-color:var(--dp-border-strong);background:var(--dp-primary-tint)">
                            <span class="material-symbols-outlined text-sm">add</span> Tambah Anggota
                        </button>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Submit --}}
        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('dashboard.departemen.proker.show', $proker->id) }}"
                class="px-6 py-2.5 rounded-xl text-sm font-bold transition-colors"
                style="color:var(--dp-text-secondary);background:var(--dp-bg-surface-2)">
                Batal
            </a>
            <button type="submit"
                class="px-8 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2 shadow-sm transition-all hover:opacity-90"
                style="background:var(--dp-bg-primary);color:var(--dp-text-on-primary)">
                <span class="material-symbols-outlined text-sm">save</span> Simpan Susunan Panitia
            </button>
        </div>
    </form>

    {{-- === RINGKASAN === --}}
    @if($proker->kepanitiaans->isNotEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-2xl border shadow-sm overflow-hidden"
            style="border-color:var(--dp-border)">
            <div class="px-6 py-4 border-b" style="border-color:var(--dp-border)">
                <h3 class="font-bold text-sm" style="color:var(--dp-text-primary)">
                    Susunan Panitia Tersimpan ({{ $proker->kepanitiaans->count() }} orang)
                </h3>
            </div>
            <div class="divide-y" style="--tw-divide-opacity:1;border-color:var(--dp-border)">
                @foreach($proker->kepanitiaans->sortBy('jabatan') as $panitia)
                    <div class="flex items-center justify-between px-6 py-3 text-sm">
                        <div class="flex items-center gap-3">
                            <span class="w-1.5 h-1.5 rounded-full flex-shrink-0"
                                style="background:{{ str_starts_with($panitia->jabatan, 'CO') ? 'var(--dp-gold)' : 'var(--dp-border-strong)' }}">
                            </span>
                            <span class="font-bold" style="color:var(--dp-text-secondary)">{{ $panitia->jabatan }}</span>
                        </div>
                        <span style="color:var(--dp-text-primary)">
                            {{ $panitia->kader?->nama_lengkap ?? '—' }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('sieBlock', (existing) => ({
            anggota: existing.length > 0 ? existing : [],
        }))
    })
</script>
@endsection
