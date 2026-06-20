@extends('layouts.dashboard')

@section('title', 'Moderasi Komentar')

@section('content')
<div class="p-6 max-w-6xl mx-auto">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-display font-bold" style="color: var(--dp-text-primary);">Moderasi Komentar</h1>
        <p class="text-sm mt-1" style="color: var(--dp-text-secondary);">
            Komentar masuk perlu disetujui sebelum tampil di publik.
            @if($komentars->total() > 0)
                <span class="font-semibold" style="color: var(--dp-danger);">{{ $komentars->total() }} komentar menunggu persetujuan.</span>
            @endif
        </p>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
    <div class="mb-4 px-4 py-3 rounded-lg text-sm font-medium"
         style="background: rgba(8,51,44,0.08); color: var(--dp-bg-primary); border: 1px solid rgba(8,51,44,0.20);">
        {{ session('success') }}
    </div>
    @endif

    {{-- Table / Empty State --}}
    @if($komentars->count() > 0)
    <div class="rounded-lg overflow-hidden" style="border: 1px solid var(--dp-border); background: var(--dp-bg-surface);">
        <table class="w-full text-sm">
            <thead>
                <tr style="background: var(--dp-bg-surface-2); border-bottom: 1px solid var(--dp-border);">
                    <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider" style="color: var(--dp-text-secondary);">Artikel</th>
                    <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider" style="color: var(--dp-text-secondary);">Pengirim</th>
                    <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider" style="color: var(--dp-text-secondary);">Komentar</th>
                    <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider" style="color: var(--dp-text-secondary);">Waktu</th>
                    <th class="px-4 py-3 text-center font-semibold text-xs uppercase tracking-wider" style="color: var(--dp-text-secondary);">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($komentars as $komentar)
                <tr style="border-bottom: 1px solid var(--dp-border);" class="hover:bg-opacity-50 transition-colors">

                    {{-- Judul Berita --}}
                    <td class="px-4 py-3" style="max-width: 180px;">
                        @if($komentar->berita)
                        <a href="{{ route('berita.show', $komentar->berita->slug) }}" target="_blank"
                           class="text-sm font-medium hover:underline line-clamp-2"
                           style="color: var(--dp-bg-primary);">
                            {{ Str::limit($komentar->berita->judul, 50) }}
                        </a>
                        @else
                        <span class="text-xs" style="color: var(--dp-text-secondary);">(berita dihapus)</span>
                        @endif
                    </td>

                    {{-- Nama & Email --}}
                    <td class="px-4 py-3" style="min-width: 120px;">
                        <p class="font-medium text-sm" style="color: var(--dp-text-primary);">{{ $komentar->nama }}</p>
                        @if($komentar->email)
                        <p class="text-xs mt-0.5" style="color: var(--dp-text-secondary);">{{ $komentar->email }}</p>
                        @endif
                    </td>

                    {{-- Isi Komentar --}}
                    <td class="px-4 py-3" style="max-width: 280px; color: var(--dp-text-primary);">
                        <p class="text-sm leading-relaxed">{{ Str::limit($komentar->konten, 120) }}</p>
                        @if($komentar->parent_id)
                        <span class="inline-block mt-1 text-xs px-2 py-0.5 rounded"
                              style="background: var(--dp-gold-tint); color: var(--dp-text-gold);">Balasan</span>
                        @endif
                    </td>

                    {{-- Waktu --}}
                    <td class="px-4 py-3 text-xs whitespace-nowrap" style="color: var(--dp-text-secondary);">
                        {{ $komentar->created_at->format('d M Y') }}<br>
                        {{ $komentar->created_at->format('H:i') }}
                    </td>

                    {{-- Aksi --}}
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-2">
                            {{-- Setujui --}}
                            <form method="POST" action="{{ route('dashboard.berita.komentar.approve', $komentar) }}">
                                @csrf
                                <button type="submit"
                                        class="px-3 py-1.5 rounded text-xs font-semibold transition-colors"
                                        style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);"
                                        onmouseover="this.style.background='var(--dp-bg-primary-hover)'"
                                        onmouseout="this.style.background='var(--dp-bg-primary)'">
                                    <span class="material-symbols-outlined text-sm align-middle" style="font-size:14px;">check</span>
                                    Setujui
                                </button>
                            </form>

                            {{-- Tolak --}}
                            <form method="POST" action="{{ route('dashboard.berita.komentar.reject', $komentar) }}"
                                  onsubmit="return confirm('Hapus komentar dari \'{{ addslashes($komentar->nama) }}\' secara permanen?')">
                                @csrf
                                <button type="submit"
                                        class="px-3 py-1.5 rounded text-xs font-semibold transition-colors"
                                        style="background: var(--dp-danger-tint); color: var(--dp-danger);"
                                        onmouseover="this.style.background='var(--dp-danger)'; this.style.color='#fff'"
                                        onmouseout="this.style.background='var(--dp-danger-tint)'; this.style.color='var(--dp-danger)'">
                                    <span class="material-symbols-outlined text-sm align-middle" style="font-size:14px;">delete</span>
                                    Tolak
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($komentars->hasPages())
    <div class="mt-4">
        {{ $komentars->links() }}
    </div>
    @endif

    @else
    {{-- Empty State --}}
    <div class="rounded-lg p-12 text-center" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
        <span class="material-symbols-outlined text-5xl mb-3 block" style="color: var(--dp-border-strong);">mark_chat_read</span>
        <p class="font-semibold" style="color: var(--dp-text-primary);">Tidak ada komentar pending</p>
        <p class="text-sm mt-1" style="color: var(--dp-text-secondary);">Semua komentar sudah diproses ✓</p>
    </div>
    @endif

</div>
@endsection
