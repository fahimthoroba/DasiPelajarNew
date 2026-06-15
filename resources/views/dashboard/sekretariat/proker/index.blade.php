@extends('layouts.dashboard')

@section('title', 'Program Kerja & Verifikasi LPJ')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold font-display" style="color: var(--dp-text-primary)">
                Program Kerja PC
            </h1>
            <p class="text-sm mt-0.5" style="color: var(--dp-text-secondary)">
                Input program kerja dan verifikasi LPJ departemen.
            </p>
        </div>
        <a href="{{ route('dashboard.sekretariat.proker.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl font-bold text-sm transition-all"
           style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary)">
            <span class="material-symbols-outlined text-sm">add</span>
            Input Proker Baru
        </a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold"
             style="background: var(--dp-primary-tint); color: var(--dp-bg-primary); border: 1px solid var(--dp-border);">
            <span class="material-symbols-outlined text-base">check_circle</span>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold"
             style="background: var(--dp-danger-tint); color: var(--dp-danger); border: 1px solid rgba(232,70,58,0.3);">
            <span class="material-symbols-outlined text-base">error</span>
            {{ session('error') }}
        </div>
    @endif

    {{-- Tabs --}}
    <div style="border-bottom: 2px solid var(--dp-border);">
        <nav class="-mb-0.5 flex gap-1">
            <a href="{{ route('dashboard.sekretariat.proker.index') }}"
               class="px-4 py-2.5 text-sm font-bold rounded-t-lg transition-colors"
               style="
                   border-bottom: 2px solid {{ $tab === 'semua' ? 'var(--dp-bg-primary)' : 'transparent' }};
                   color: {{ $tab === 'semua' ? 'var(--dp-bg-primary)' : 'var(--dp-text-secondary)' }};
                   background: {{ $tab === 'semua' ? 'var(--dp-primary-tint)' : 'transparent' }};
               ">
                Semua Program
            </a>
            <a href="{{ route('dashboard.sekretariat.proker.index', ['tab' => 'menunggu_verifikasi']) }}"
               class="px-4 py-2.5 text-sm font-bold rounded-t-lg transition-colors inline-flex items-center gap-2"
               style="
                   border-bottom: 2px solid {{ $tab === 'menunggu_verifikasi' ? 'var(--dp-gold)' : 'transparent' }};
                   color: {{ $tab === 'menunggu_verifikasi' ? 'var(--dp-gold)' : 'var(--dp-text-secondary)' }};
                   background: {{ $tab === 'menunggu_verifikasi' ? 'var(--dp-gold-tint)' : 'transparent' }};
               ">
                Menunggu Verifikasi
                @if($countMenunggu > 0)
                    <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-full"
                          style="background: var(--dp-gold); color: var(--dp-bg-primary)">
                        {{ $countMenunggu }}
                    </span>
                @endif
            </a>
        </nav>
    </div>

    {{-- Table --}}
    <div class="rounded-2xl overflow-hidden"
         style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr style="background: var(--dp-bg-surface-2); border-bottom: 1px solid var(--dp-border);">
                        <th class="px-5 py-3 text-xs font-bold uppercase tracking-widest"
                            style="color: var(--dp-text-secondary)">Nama Program</th>
                        <th class="px-5 py-3 text-xs font-bold uppercase tracking-widest"
                            style="color: var(--dp-text-secondary)">Departemen</th>
                        <th class="px-5 py-3 text-xs font-bold uppercase tracking-widest"
                            style="color: var(--dp-text-secondary)">Tanggal</th>
                        <th class="px-5 py-3 text-xs font-bold uppercase tracking-widest"
                            style="color: var(--dp-text-secondary)">Status</th>
                        @if($tab === 'menunggu_verifikasi')
                            <th class="px-5 py-3 text-xs font-bold uppercase tracking-widest text-center"
                                style="color: var(--dp-text-secondary)">Verifikasi</th>
                        @else
                            <th class="px-5 py-3 text-xs font-bold uppercase tracking-widest text-center"
                                style="color: var(--dp-text-secondary)">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($program_kerja as $item)
                        <tr class="transition-colors"
                            style="border-bottom: 1px solid var(--dp-border);"
                            onmouseover="this.style.background='var(--dp-bg-surface-2)'"
                            onmouseout="this.style.background='transparent'">

                            {{-- Nama Program --}}
                            <td class="px-5 py-4">
                                <p class="font-semibold text-sm" style="color: var(--dp-text-primary)">
                                    {{ $item->nama_proker }}
                                </p>
                                @if($item->penanggung_jawab)
                                    <p class="text-xs mt-0.5" style="color: var(--dp-text-secondary)">
                                        PJ: {{ $item->penanggung_jawab }}
                                    </p>
                                @endif
                            </td>

                            {{-- Departemen --}}
                            <td class="px-5 py-4">
                                <span class="text-xs font-bold px-2 py-0.5 rounded uppercase tracking-widest"
                                      style="background: var(--dp-bg-surface-2); color: var(--dp-text-secondary); border: 1px solid var(--dp-border);">
                                    {{ $item->departemen->nama_departemen ?? '-' }}
                                </span>
                            </td>

                            {{-- Tanggal --}}
                            <td class="px-5 py-4 text-sm" style="color: var(--dp-text-secondary)">
                                {{ $item->tgl_pelaksanaan->format('d M Y') }}
                            </td>

                            {{-- Status / Step --}}
                            <td class="px-5 py-4">
                                @if($item->current_step == 6)
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-widest"
                                          style="background: var(--dp-gold-tint); color: var(--dp-gold); border: 1px solid var(--dp-border-gold)">
                                        <span class="material-symbols-outlined text-xs">pending_actions</span>
                                        Menunggu Verifikasi
                                    </span>
                                @elseif($item->status_pelaksanaan == 'Selesai')
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-widest"
                                          style="background: var(--dp-primary-tint); color: var(--dp-bg-primary)">
                                        Selesai
                                    </span>
                                @elseif($item->lpj_catatan && $item->current_step == 5)
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-widest"
                                          style="background: var(--dp-danger-tint); color: var(--dp-danger)">
                                        LPJ Ditolak
                                    </span>
                                @else
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-widest"
                                          style="background: var(--dp-bg-surface-2); color: var(--dp-text-secondary); border: 1px solid var(--dp-border);">
                                        Step {{ $item->current_step }} — {{ $item->status_pelaksanaan }}
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-5 py-4">
                                @if($tab === 'menunggu_verifikasi')
                                    <div x-data="{ openTolak: false }" class="flex items-center justify-center gap-2">
                                        {{-- Terima --}}
                                        <form action="{{ route('dashboard.sekretariat.proker.verifikasi', $item->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Terima dan verifikasi LPJ {{ $item->nama_proker }}?')">
                                            @csrf
                                            <input type="hidden" name="action" value="terima">
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors"
                                                    style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary)">
                                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                                Terima
                                            </button>
                                        </form>

                                        {{-- Tolak (toggle form inline) --}}
                                        <button @click="openTolak = !openTolak"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors"
                                                style="border: 1px solid var(--dp-danger); color: var(--dp-danger)">
                                            <span class="material-symbols-outlined text-sm">cancel</span>
                                            Tolak
                                        </button>

                                        {{-- Detail --}}
                                        <a href="{{ route('dashboard.sekretariat.proker.show', $item->id) }}"
                                           class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors"
                                           style="background: var(--dp-bg-surface-2); color: var(--dp-text-secondary); border: 1px solid var(--dp-border)">
                                            <span class="material-symbols-outlined text-sm">visibility</span>
                                            Detail
                                        </a>

                                        {{-- Form Tolak inline (collapse) --}}
                                        <div x-show="openTolak" x-transition
                                             class="fixed inset-0 flex items-center justify-center z-50 px-4"
                                             style="background: rgba(0,0,0,0.55);"
                                             @click.self="openTolak = false"
                                             x-cloak>
                                            <div class="w-full max-w-md rounded-2xl p-6 shadow-2xl"
                                                 style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                                                <div class="flex items-start justify-between mb-4">
                                                    <div>
                                                        <h3 class="font-bold text-base font-display"
                                                            style="color: var(--dp-text-primary)">Tolak LPJ</h3>
                                                        <p class="text-xs mt-0.5" style="color: var(--dp-text-secondary)">
                                                            {{ $item->nama_proker }}
                                                        </p>
                                                    </div>
                                                    <button @click="openTolak = false"
                                                            style="color: var(--dp-text-secondary)">
                                                        <span class="material-symbols-outlined">close</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('dashboard.sekretariat.proker.verifikasi', $item->id) }}"
                                                      method="POST">
                                                    @csrf
                                                    <input type="hidden" name="action" value="tolak">
                                                    <label class="block text-xs font-bold mb-1"
                                                           style="color: var(--dp-text-secondary)">
                                                        Catatan Penolakan <span style="color: var(--dp-danger)">*</span>
                                                    </label>
                                                    <textarea name="lpj_catatan" required rows="4"
                                                              placeholder="Jelaskan apa yang perlu diperbaiki..."
                                                              class="w-full px-3 py-2 rounded-lg text-sm outline-none resize-none mb-4"
                                                              style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary)"></textarea>
                                                    <div class="flex gap-3">
                                                        <button type="button" @click="openTolak = false"
                                                                class="flex-1 py-2.5 rounded-xl text-sm font-bold"
                                                                style="background: var(--dp-bg-surface-2); color: var(--dp-text-secondary); border: 1px solid var(--dp-border)">
                                                            Batal
                                                        </button>
                                                        <button type="submit"
                                                                class="flex-1 py-2.5 rounded-xl text-sm font-bold"
                                                                style="background: var(--dp-danger); color: #fff">
                                                            Tolak & Kirim Catatan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex justify-center">
                                        <a href="{{ route('dashboard.sekretariat.proker.show', $item->id) }}"
                                           class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors"
                                           style="background: var(--dp-bg-surface-2); color: var(--dp-text-secondary); border: 1px solid var(--dp-border)">
                                            <span class="material-symbols-outlined text-sm">visibility</span>
                                            Detail
                                        </a>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-sm"
                                style="color: var(--dp-text-secondary)">
                                <span class="material-symbols-outlined text-3xl block mb-2">inbox</span>
                                @if($tab === 'menunggu_verifikasi')
                                    Tidak ada LPJ yang menunggu verifikasi.
                                @else
                                    Belum ada program kerja yang diinput.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($program_kerja->hasPages())
            <div class="px-5 py-3" style="border-top: 1px solid var(--dp-border);">
                {{ $program_kerja->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
