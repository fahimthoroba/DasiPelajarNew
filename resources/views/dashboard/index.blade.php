@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    {{-- Welcome header --}}
    <div class="mb-6">
        <h1 class="font-display text-2xl font-bold" style="color: var(--dp-text-primary);">Dashboard</h1>
        <p class="text-sm mt-1" style="color: var(--dp-text-secondary);">
            Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong>
        </p>
    </div>

    {{-- Stats grid --}}
    @if(!empty($stats))
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

            @if(isset($stats['berita']))
                <div class="rounded-xl p-5" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-lg flex items-center justify-center"
                             style="background: var(--dp-primary-tint); color: var(--dp-bg-primary);">
                            <span class="material-symbols-outlined text-xl">newspaper</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-wider" style="color: var(--dp-text-secondary);">Total Berita</p>
                            <h3 class="font-display text-2xl font-bold" style="color: var(--dp-text-primary);">{{ $stats['berita'] }}</h3>
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($stats['surat_masuk']))
                <div class="rounded-xl p-5" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-lg flex items-center justify-center"
                             style="background: var(--dp-gold-tint); color: var(--dp-gold);">
                            <span class="material-symbols-outlined text-xl">mail</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-wider" style="color: var(--dp-text-secondary);">Surat Masuk</p>
                            <h3 class="font-display text-2xl font-bold" style="color: var(--dp-text-primary);">{{ $stats['surat_masuk'] }}</h3>
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($stats['surat_keluar']))
                <div class="rounded-xl p-5" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-lg flex items-center justify-center"
                             style="background: var(--dp-primary-tint); color: var(--dp-bg-primary);">
                            <span class="material-symbols-outlined text-xl">send</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-wider" style="color: var(--dp-text-secondary);">Surat Keluar</p>
                            <h3 class="font-display text-2xl font-bold" style="color: var(--dp-text-primary);">{{ $stats['surat_keluar'] }}</h3>
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($stats['kader']))
                <div class="rounded-xl p-5" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-lg flex items-center justify-center"
                             style="background: var(--dp-gold-tint); color: var(--dp-gold);">
                            <span class="material-symbols-outlined text-xl">groups</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-wider" style="color: var(--dp-text-secondary);">Total Kader</p>
                            <h3 class="font-display text-2xl font-bold" style="color: var(--dp-text-primary);">{{ $stats['kader'] }}</h3>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    @endif

    {{-- Info banner --}}
    <div class="rounded-xl p-6 lg:p-8 relative overflow-hidden" style="background: var(--dp-bg-primary);">
        {{-- Decorative --}}
        <div class="absolute -top-12 -right-12 w-48 h-48 rounded-full" style="background: rgba(186,158,111,0.08);"></div>
        <div class="absolute -bottom-8 -left-8 w-32 h-32 rounded-full" style="background: rgba(186,158,111,0.05);"></div>

        <div class="relative z-10 max-w-lg">
            <h2 class="font-display text-xl lg:text-2xl font-bold mb-3" style="color: var(--dp-text-on-primary);">
                Mulai Kelola Organisasi
            </h2>
            <p class="text-sm leading-relaxed mb-4" style="color: rgba(244,244,244,0.6);">
                Anda terdaftar sebagai
                <span class="font-semibold px-2 py-0.5 rounded text-xs uppercase tracking-wider"
                      style="background: var(--dp-gold-tint); color: var(--dp-gold);">
                    {{ Auth::user()->role }}
                </span>.
                Gunakan menu di samping untuk mengelola data dan konten.
            </p>
            <a href="/" target="_blank"
               class="inline-flex items-center gap-1.5 text-sm font-semibold transition-colors"
               style="color: var(--dp-gold);">
                <span class="material-symbols-outlined text-sm">open_in_new</span>
                Lihat Situs Publik
            </a>
        </div>
    </div>

    {{-- Quick actions --}}
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @if(in_array(Auth::user()->role, ['admin', 'pers']))
            <a href="{{ route('dashboard.berita.index') }}"
               class="group rounded-xl p-5 flex items-center gap-4 transition-all"
               style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);"
               onmouseover="this.style.borderColor='var(--dp-gold)'"
               onmouseout="this.style.borderColor='var(--dp-border)'">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center"
                     style="background: var(--dp-primary-tint); color: var(--dp-bg-primary);">
                    <span class="material-symbols-outlined">edit_note</span>
                </div>
                <div>
                    <div class="text-sm font-semibold" style="color: var(--dp-text-primary);">Tulis Berita</div>
                    <div class="text-xs" style="color: var(--dp-text-secondary);">Buat artikel baru</div>
                </div>
            </a>
        @endif

        @if(in_array(Auth::user()->role, ['admin', 'sekretaris']))
            <a href="{{ route('dashboard.sekretariat.surat-masuk.index') }}"
               class="group rounded-xl p-5 flex items-center gap-4 transition-all"
               style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);"
               onmouseover="this.style.borderColor='var(--dp-gold)'"
               onmouseout="this.style.borderColor='var(--dp-border)'">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center"
                     style="background: var(--dp-gold-tint); color: var(--dp-gold);">
                    <span class="material-symbols-outlined">inbox</span>
                </div>
                <div>
                    <div class="text-sm font-semibold" style="color: var(--dp-text-primary);">Surat Masuk</div>
                    <div class="text-xs" style="color: var(--dp-text-secondary);">Kelola surat masuk</div>
                </div>
            </a>

            <a href="{{ route('dashboard.sekretariat.master-data.index') }}"
               class="group rounded-xl p-5 flex items-center gap-4 transition-all"
               style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);"
               onmouseover="this.style.borderColor='var(--dp-gold)'"
               onmouseout="this.style.borderColor='var(--dp-border)'">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center"
                     style="background: var(--dp-primary-tint); color: var(--dp-bg-primary);">
                    <span class="material-symbols-outlined">database</span>
                </div>
                <div>
                    <div class="text-sm font-semibold" style="color: var(--dp-text-primary);">Master Data</div>
                    <div class="text-xs" style="color: var(--dp-text-secondary);">Kelola data kader & organisasi</div>
                </div>
            </a>
        @endif
    </div>
@endsection
