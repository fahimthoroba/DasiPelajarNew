@extends('layouts.dashboard')

@section('title', 'Pendaftar: ' . $form->nama_kegiatan)

@section('content')
<div class="space-y-6">

    {{-- Back --}}
    @if($form->program_kerja_id && $form->programKerja)
        <a href="{{ route('dashboard.departemen.proker.show', $form->program_kerja_id) }}"
           class="inline-flex items-center gap-1.5 text-sm font-bold transition-colors"
           style="color: var(--dp-bg-primary)">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Kembali ke {{ $form->programKerja->nama_proker }}
        </a>
    @else
        <a href="{{ route('dashboard.form-kegiatan.index') }}"
           class="inline-flex items-center gap-1.5 text-sm font-bold transition-colors"
           style="color: var(--dp-bg-primary)">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Kembali ke Daftar Form
        </a>
    @endif

    {{-- Header --}}
    <div x-data="{ isOpen: {{ $form->is_open ? 'true' : 'false' }} }"
         class="p-6 rounded-2xl"
         style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
            <div class="flex-1">
                <div class="flex flex-wrap items-center gap-2 mb-2">
                    {{-- Status badge --}}
                    <span class="text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-widest"
                          :style="isOpen
                            ? 'background: var(--dp-primary-tint); color: var(--dp-bg-primary)'
                            : 'background: var(--dp-danger-tint); color: var(--dp-danger)'"
                          x-text="isOpen ? '● Buka' : '● Tutup'">
                    </span>
                    @if($form->programKerja)
                        <span class="text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-widest"
                              style="background: var(--dp-gold-tint); color: var(--dp-gold)">
                            Program Kerja
                        </span>
                    @endif
                </div>
                <h1 class="text-xl font-bold font-display" style="color: var(--dp-text-primary)">
                    {{ $form->nama_kegiatan }}
                </h1>
                @if($form->programKerja)
                    <p class="text-sm mt-1" style="color: var(--dp-text-secondary)">
                        Terkait: {{ $form->programKerja->nama_proker }}
                    </p>
                @endif

                {{-- Link publik --}}
                <div class="flex items-center gap-2 mt-3 p-3 rounded-xl"
                     style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border);">
                    <span class="material-symbols-outlined text-sm shrink-0" style="color: var(--dp-text-secondary)">link</span>
                    <span class="text-xs font-mono truncate flex-1" style="color: var(--dp-text-secondary)">
                        {{ url('/form/' . $form->slug) }}
                    </span>
                    <button type="button"
                            onclick="navigator.clipboard.writeText('{{ url('/form/' . $form->slug) }}');
                                     this.querySelector('span').textContent='done';
                                     setTimeout(() => this.querySelector('span').textContent='content_copy', 2000)"
                            class="shrink-0 p-1 rounded-lg transition-colors"
                            style="color: var(--dp-text-secondary)" title="Salin link">
                        <span class="material-symbols-outlined text-sm">content_copy</span>
                    </button>
                    <a href="{{ url('/form/' . $form->slug) }}" target="_blank"
                       class="shrink-0 p-1 rounded-lg transition-colors"
                       style="color: var(--dp-text-secondary)" title="Buka di tab baru">
                        <span class="material-symbols-outlined text-sm">open_in_new</span>
                    </a>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-wrap items-center gap-2">
                {{-- Toggle buka/tutup --}}
                <button @click="
                    fetch('{{ route('dashboard.form-kegiatan.toggle', $form->id) }}', {
                        method: 'PATCH',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                    }).then(r => r.json()).then(d => { isOpen = d.is_open })"
                        class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold transition-colors"
                        :style="isOpen
                          ? 'background: var(--dp-danger-tint); color: var(--dp-danger)'
                          : 'background: var(--dp-primary-tint); color: var(--dp-bg-primary)'"
                        x-text="isOpen ? 'Tutup Form' : 'Buka Form'">
                </button>

                <a href="{{ route('dashboard.form-kegiatan.edit', $form->id) }}"
                   class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold transition-colors"
                   style="background: var(--dp-bg-surface-2); color: var(--dp-text-secondary); border: 1px solid var(--dp-border)">
                    <span class="material-symbols-outlined text-base">tune</span>
                    Edit Form
                </a>

                <a href="{{ route('dashboard.form-kegiatan.export-excel', $form->id) }}"
                   class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold transition-colors"
                   style="background: var(--dp-bg-surface-2); color: var(--dp-text-secondary); border: 1px solid var(--dp-border)">
                    <span class="material-symbols-outlined text-base">download</span>
                    Excel
                </a>

                @php $hasFileFields = collect($form->custom_fields ?? [])->contains('type', 'file'); @endphp
                @if($hasFileFields)
                <a href="{{ route('dashboard.form-kegiatan.download-files', $form->id) }}"
                   class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold transition-colors"
                   style="background: var(--dp-bg-surface-2); color: var(--dp-text-secondary); border: 1px solid var(--dp-border)">
                    <span class="material-symbols-outlined text-base">folder_zip</span>
                    File ZIP
                </a>
                @endif
            </div>
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

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="p-5 rounded-2xl text-center" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
            <p class="text-3xl font-black font-display" style="color: var(--dp-bg-primary)">{{ $pesertas->total() }}</p>
            <p class="text-[11px] font-bold uppercase tracking-widest mt-1" style="color: var(--dp-text-secondary)">Total</p>
        </div>
        <div class="p-5 rounded-2xl text-center" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
            <p class="text-3xl font-black font-display" style="color: var(--dp-bg-primary)">
                {{ $form->peserta()->where('jenis_kelamin', 'Laki-Laki')->count() }}
            </p>
            <p class="text-[11px] font-bold uppercase tracking-widest mt-1" style="color: var(--dp-text-secondary)">Laki-Laki</p>
        </div>
        <div class="p-5 rounded-2xl text-center" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
            <p class="text-3xl font-black font-display" style="color: var(--dp-gold)">
                {{ $form->peserta()->where('jenis_kelamin', 'Perempuan')->count() }}
            </p>
            <p class="text-[11px] font-bold uppercase tracking-widest mt-1" style="color: var(--dp-text-secondary)">Perempuan</p>
        </div>
    </div>

    {{-- Tabel Peserta --}}
    <div class="rounded-2xl overflow-hidden" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
        <div class="px-6 py-4 flex items-center justify-between"
             style="border-bottom: 1px solid var(--dp-border); background: var(--dp-bg-surface-2);">
            <h2 class="font-bold" style="color: var(--dp-text-primary)">Daftar Pendaftar</h2>
            @if($pesertas->total() > 0)
                <span class="text-[10px] font-bold px-2 py-1 rounded"
                      style="background: var(--dp-primary-tint); color: var(--dp-bg-primary)">
                    {{ $pesertas->total() }} orang
                </span>
            @endif
        </div>

        @if($pesertas->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <span class="material-symbols-outlined text-4xl mb-3" style="color: var(--dp-border-strong)">how_to_reg</span>
                <p class="font-bold mb-1" style="color: var(--dp-text-primary)">Belum ada pendaftar</p>
                <p class="text-sm" style="color: var(--dp-text-secondary)">Bagikan link form kepada calon peserta.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--dp-border);">
                            <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-widest whitespace-nowrap" style="color: var(--dp-text-secondary)">No</th>
                            <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-widest whitespace-nowrap" style="color: var(--dp-text-secondary)">Nama</th>
                            <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-widest whitespace-nowrap" style="color: var(--dp-text-secondary)">JK</th>
                            <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-widest whitespace-nowrap" style="color: var(--dp-text-secondary)">No WA</th>
                            <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-widest whitespace-nowrap" style="color: var(--dp-text-secondary)">Asal</th>
                            @foreach($form->custom_fields ?? [] as $field)
                                <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-widest whitespace-nowrap" style="color: var(--dp-text-secondary)">
                                    {{ $field['label'] }}
                                </th>
                            @endforeach
                            <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-widest whitespace-nowrap" style="color: var(--dp-text-secondary)">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesertas as $i => $peserta)
                        <tr class="transition-colors hover:bg-[var(--dp-bg-surface-2)]"
                            style="border-bottom: 1px solid var(--dp-border);">
                            <td class="px-5 py-3.5 text-xs" style="color: var(--dp-text-secondary)">
                                {{ $pesertas->firstItem() + $i }}
                            </td>
                            <td class="px-5 py-3.5 font-semibold whitespace-nowrap" style="color: var(--dp-text-primary)">
                                {{ $peserta->nama_lengkap }}
                            </td>
                            <td class="px-5 py-3.5 text-xs whitespace-nowrap" style="color: var(--dp-text-secondary)">
                                {{ $peserta->jenis_kelamin }}
                            </td>
                            <td class="px-5 py-3.5 text-xs whitespace-nowrap">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $peserta->no_wa) }}"
                                   target="_blank" class="hover:underline" style="color: var(--dp-bg-primary)">
                                    {{ $peserta->no_wa }}
                                </a>
                            </td>
                            <td class="px-5 py-3.5 text-xs" style="color: var(--dp-text-secondary)">
                                {{ $peserta->asal_instansi }}
                            </td>
                            @foreach($form->custom_fields ?? [] as $field)
                            @php $answer = $peserta->custom_answers[$field['label']] ?? '-'; @endphp
                            <td class="px-5 py-3.5 text-xs" style="color: var(--dp-text-secondary)">
                                @if($field['type'] === 'file' && $answer !== '-')
                                    <a href="{{ $answer }}" target="_blank"
                                       class="inline-flex items-center gap-1 text-xs font-bold hover:underline"
                                       style="color: var(--dp-bg-primary)">
                                        <span class="material-symbols-outlined text-sm">attach_file</span>
                                        Lihat File
                                    </a>
                                @else
                                    {{ $answer }}
                                @endif
                            </td>
                            @endforeach
                            <td class="px-5 py-3.5 text-[11px] whitespace-nowrap" style="color: var(--dp-text-secondary)">
                                {{ $peserta->created_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($pesertas->hasPages())
            <div class="px-6 py-4">
                {{ $pesertas->links() }}
            </div>
            @endif
        @endif
    </div>

</div>
@endsection
