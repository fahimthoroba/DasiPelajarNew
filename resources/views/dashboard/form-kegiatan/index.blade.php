@extends('layouts.dashboard')

@section('title', 'Form Kegiatan')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold font-display" style="color: var(--dp-text-primary)">Form Kegiatan</h1>
            <p class="text-sm mt-0.5" style="color: var(--dp-text-secondary)">
                Kelola form pendaftaran untuk kegiatan dan program kerja.
            </p>
        </div>
        <a href="{{ route('dashboard.form-kegiatan.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold transition-colors"
           style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary)">
            <span class="material-symbols-outlined text-base">add</span>
            Buat Form Kegiatan
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="p-5 rounded-2xl" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
            <p class="text-[11px] font-bold uppercase tracking-widest mb-1" style="color: var(--dp-text-secondary)">Total Form</p>
            <p class="text-3xl font-black font-display" style="color: var(--dp-bg-primary)">{{ $forms->total() }}</p>
        </div>
        <div class="p-5 rounded-2xl" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
            <p class="text-[11px] font-bold uppercase tracking-widest mb-1" style="color: var(--dp-text-secondary)">Sedang Buka</p>
            <p class="text-3xl font-black font-display" style="color: var(--dp-gold)">{{ $totalAktif }}</p>
        </div>
        <div class="p-5 rounded-2xl" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
            <p class="text-[11px] font-bold uppercase tracking-widest mb-1" style="color: var(--dp-text-secondary)">Total Pendaftar</p>
            <p class="text-3xl font-black font-display" style="color: var(--dp-bg-primary)">{{ $totalPeserta }}</p>
        </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold"
             style="background: var(--dp-primary-tint); color: var(--dp-bg-primary); border: 1px solid var(--dp-border);">
            <span class="material-symbols-outlined text-base">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    {{-- Daftar Form --}}
    <div class="rounded-2xl overflow-hidden" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">

        @if($forms->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 px-6 text-center">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4"
                     style="background: var(--dp-bg-surface-2);">
                    <span class="material-symbols-outlined text-3xl" style="color: var(--dp-text-secondary)">how_to_reg</span>
                </div>
                <p class="font-bold text-base mb-1" style="color: var(--dp-text-primary)">Belum ada form kegiatan</p>
                <p class="text-sm mb-5" style="color: var(--dp-text-secondary)">
                    Buat form pendaftaran pertama untuk kegiatan atau program kerja Anda.
                </p>
                <a href="{{ route('dashboard.form-kegiatan.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold"
                   style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary)">
                    <span class="material-symbols-outlined text-base">add</span>
                    Buat Form Pertama
                </a>
            </div>
        @else
            {{-- Table header --}}
            <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-3 text-[10px] font-bold uppercase tracking-widest"
                 style="color: var(--dp-text-secondary); border-bottom: 1px solid var(--dp-border); background: var(--dp-bg-surface-2);">
                <div class="col-span-4">Nama Kegiatan</div>
                <div class="col-span-2">Program Kerja</div>
                <div class="col-span-2">Status</div>
                <div class="col-span-2">Pendaftar</div>
                <div class="col-span-2 text-right">Aksi</div>
            </div>

            @foreach($forms as $form)
            @php $pesertaCount = $form->peserta()->count(); @endphp
            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 md:gap-4 px-6 py-4 transition-colors hover:bg-[var(--dp-bg-surface-2)]"
                 style="border-bottom: 1px solid var(--dp-border);">

                {{-- Nama --}}
                <div class="md:col-span-4">
                    <a href="{{ route('dashboard.form-kegiatan.show', $form->id) }}"
                       class="font-bold text-sm hover:underline" style="color: var(--dp-text-primary)">
                        {{ $form->nama_kegiatan }}
                    </a>
                    <p class="text-[11px] mt-0.5 font-mono" style="color: var(--dp-text-secondary)">/form/{{ $form->slug }}</p>
                    @if($form->tgl_tutup)
                        <p class="text-[11px] mt-0.5" style="color: var(--dp-text-secondary)">
                            Tutup: {{ $form->tgl_tutup->format('d M Y') }}
                        </p>
                    @endif
                </div>

                {{-- Proker --}}
                <div class="md:col-span-2 flex items-center">
                    @if($form->programKerja)
                        <span class="text-[10px] font-bold px-2 py-1 rounded-lg max-w-full truncate"
                              style="background: var(--dp-primary-tint); color: var(--dp-bg-primary)">
                            {{ Str::limit($form->programKerja->nama_proker, 30) }}
                        </span>
                    @else
                        <span class="text-[11px]" style="color: var(--dp-text-secondary)">Mandiri</span>
                    @endif
                </div>

                {{-- Status --}}
                <div class="md:col-span-2 flex items-center">
                    @if($form->is_open)
                        <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-widest"
                              style="background: var(--dp-primary-tint); color: var(--dp-bg-primary);">
                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span> Buka
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-widest"
                              style="background: var(--dp-danger-tint); color: var(--dp-danger);">
                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span> Tutup
                        </span>
                    @endif
                </div>

                {{-- Peserta --}}
                <div class="md:col-span-2 flex items-center">
                    <span class="text-sm font-black" style="color: var(--dp-text-primary)">{{ $pesertaCount }}</span>
                    <span class="text-[11px] ml-1" style="color: var(--dp-text-secondary)">orang</span>
                </div>

                {{-- Aksi --}}
                <div class="md:col-span-2 flex items-center justify-end gap-2">
                    <a href="{{ route('dashboard.form-kegiatan.show', $form->id) }}"
                       class="p-2 rounded-lg transition-colors" style="color: var(--dp-text-secondary)"
                       title="Lihat Pendaftar">
                        <span class="material-symbols-outlined text-lg">group</span>
                    </a>
                    <a href="{{ route('dashboard.form-kegiatan.edit', $form->id) }}"
                       class="p-2 rounded-lg transition-colors" style="color: var(--dp-text-secondary)"
                       title="Edit Form">
                        <span class="material-symbols-outlined text-lg">edit</span>
                    </a>
                    <form action="{{ route('dashboard.form-kegiatan.destroy', $form->id) }}" method="POST"
                          onsubmit="return confirm('Hapus form ini? Semua data pendaftar ikut terhapus.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-2 rounded-lg transition-colors"
                                style="color: var(--dp-text-secondary)" title="Hapus">
                            <span class="material-symbols-outlined text-lg">delete</span>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach

            {{-- Pagination --}}
            @if($forms->hasPages())
            <div class="px-6 py-4">
                {{ $forms->links() }}
            </div>
            @endif
        @endif
    </div>

</div>
@endsection
