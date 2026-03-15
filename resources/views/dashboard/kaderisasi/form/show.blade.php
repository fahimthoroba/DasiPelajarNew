@extends('layouts.dashboard')

@section('title', 'Data Pendaftar: ' . $form->nama_kegiatan)

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <a href="{{ route('dashboard.kaderisasi.form.index') }}"
            class="inline-flex items-center gap-2 text-gray-500 hover:text-emerald-600 transition-colors mb-2 text-sm">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Kembali ke Daftar Form
        </a>
        <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Daftar Pendaftar</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm">Kegiatan: <strong>{{ $form->nama_kegiatan }}</strong></p>
    </div>
    
    <div class="flex items-center gap-2 flex-wrap">
        {{-- Statistik ringkas --}}
        <div class="flex items-center gap-4 mr-4">
            <div class="text-center">
                <p class="text-2xl font-extrabold text-emerald-600">{{ $pesertas->total() }}</p>
                <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Total</p>
            </div>
            <div class="w-px h-8 bg-gray-200 dark:bg-gray-700"></div>
            <div class="text-center">
                <p class="text-2xl font-extrabold text-blue-600">{{ $form->peserta()->where('jenis_kelamin', 'Laki-Laki')->count() }}</p>
                <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Laki-Laki</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-extrabold text-pink-500">{{ $form->peserta()->where('jenis_kelamin', 'Perempuan')->count() }}</p>
                <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Perempuan</p>
            </div>
        </div>

        {{-- Action Buttons --}}
        <button onclick="window.print()" 
            class="inline-flex flex-col items-center justify-center p-2.5 rounded-xl border border-gray-200 hover:bg-gray-50 text-gray-600 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800 transition-colors" title="Cetak">
            <span class="material-symbols-outlined">print</span>
            <span class="text-[10px] font-bold">Cetak</span>
        </button>

        <a href="{{ route('dashboard.kaderisasi.form.export-excel', $form->id) }}" 
            class="inline-flex flex-col items-center justify-center p-2.5 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 dark:bg-emerald-900/30 dark:border-emerald-800/50 hover:bg-emerald-100 transition-colors" title="Download Excel/CSV">
            <span class="material-symbols-outlined">download</span>
            <span class="text-[10px] font-bold">Excel</span>
        </a>

        @php
            $hasFileFields = collect($form->custom_fields ?? [])->contains('type', 'file');
        @endphp
        @if($hasFileFields)
            <a href="{{ route('dashboard.kaderisasi.form.download-files', $form->id) }}" 
                class="inline-flex flex-col items-center justify-center p-2.5 rounded-xl bg-blue-50 text-blue-600 border border-blue-100 dark:bg-blue-900/30 dark:border-blue-800/50 hover:bg-blue-100 transition-colors" title="Download semua file upload sebagai ZIP">
                <span class="material-symbols-outlined">folder_zip</span>
                <span class="text-[10px] font-bold">Files ZIP</span>
            </a>
        @endif
    </div>
</div>

@if(session('error'))
    <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 font-medium flex items-center gap-3 border border-red-100 dark:border-red-800">
        <span class="material-symbols-outlined">error</span>
        {{ session('error') }}
    </div>
@endif

<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-white/5 shadow-sm overflow-hidden mt-4">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 uppercase tracking-wider font-bold text-xs">
                    <th class="px-5 py-4">No</th>
                    <th class="px-5 py-4">Waktu Daftar</th>
                    <th class="px-5 py-4">Nama Lengkap</th>
                    <th class="px-5 py-4">JK</th>
                    <th class="px-5 py-4">No WhatsApp</th>
                    <th class="px-5 py-4">Instansi/PAC</th>
                    @foreach($form->custom_fields ?? [] as $field)
                        <th class="px-5 py-4">
                            {{ $field['label'] }}
                            @if($field['type'] === 'file')
                                <span class="material-symbols-outlined text-[11px] align-middle">attach_file</span>
                            @endif
                        </th>
                    @endforeach
                    <th class="px-5 py-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                @forelse($pesertas as $index => $peserta)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-5 py-4 text-gray-400 text-xs">{{ $pesertas->firstItem() + $index }}</td>
                        <td class="px-5 py-4 text-xs text-gray-500 whitespace-nowrap">{{ $peserta->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-5 py-4 font-bold text-gray-900 dark:text-white whitespace-nowrap">{{ $peserta->nama_lengkap }}</td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            @if($peserta->jenis_kelamin === 'Laki-Laki')
                                <span class="px-2 py-0.5 bg-blue-50 text-blue-600 rounded text-[11px] font-bold">L</span>
                            @else
                                <span class="px-2 py-0.5 bg-pink-50 text-pink-600 rounded text-[11px] font-bold">P</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 font-mono text-emerald-600 text-xs whitespace-nowrap">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $peserta->no_wa) }}" target="_blank" class="hover:underline inline-flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">chat</span>
                                {{ $peserta->no_wa }}
                            </a>
                        </td>
                        <td class="px-5 py-4 text-gray-700 dark:text-gray-300 text-xs">{{ $peserta->asal_instansi }}</td>
                        
                        {{-- Custom field answers inline --}}
                        @php $answers = $peserta->custom_answers ?? []; @endphp
                        @foreach($form->custom_fields ?? [] as $field)
                            <td class="px-5 py-4 text-xs">
                                @php $answer = $answers[$field['label']] ?? '-'; @endphp
                                
                                @if($field['type'] === 'file' && $answer !== '-' && !empty($answer))
                                    {{-- File/Image: Show preview + download link --}}
                                    @php
                                        $isImage = preg_match('/\.(jpg|jpeg|png|gif|webp|svg)$/i', $answer);
                                    @endphp
                                    @if($isImage)
                                        <a href="{{ $answer }}" target="_blank" class="group inline-flex flex-col items-center gap-1">
                                            <img src="{{ $answer }}" alt="Upload" class="w-10 h-10 object-cover rounded-lg border border-gray-200 group-hover:border-emerald-400 transition-colors shadow-sm">
                                            <span class="text-[10px] text-blue-500 group-hover:underline">Buka</span>
                                        </a>
                                    @else
                                        <a href="{{ $answer }}" target="_blank" class="inline-flex items-center gap-1 text-blue-600 hover:underline font-medium">
                                            <span class="material-symbols-outlined text-sm">download</span>
                                            Download
                                        </a>
                                    @endif
                                @else
                                    <span class="text-gray-700 dark:text-gray-300">{{ $answer }}</span>
                                @endif
                            </td>
                        @endforeach

                        <td class="px-5 py-4">
                            @if($peserta->status == 'pending')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-[11px] font-bold whitespace-nowrap">Menunggu</span>
                            @elseif($peserta->status == 'approved')
                                <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[11px] font-bold whitespace-nowrap">Disetujui</span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-lg text-[11px] font-bold whitespace-nowrap">{{ ucfirst($peserta->status) }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ 7 + count($form->custom_fields ?? []) }}" class="px-6 py-16 text-center text-gray-500">
                            <span class="material-symbols-outlined text-5xl block mb-3 opacity-30">group_off</span>
                            <p class="font-bold text-gray-600 dark:text-gray-400">Belum ada satupun yang mendaftar</p>
                            <p class="text-xs text-gray-400 mt-1">Bagikan link form ke calon peserta untuk mulai menerima pendaftaran.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pesertas->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 dark:border-white/5">
            {{ $pesertas->links() }}
        </div>
    @endif
</div>

{{-- Info Bar --}}
<div class="mt-4 flex flex-wrap items-center gap-3 text-xs text-gray-400">
    <div class="flex items-center gap-1">
        <span class="material-symbols-outlined text-sm">info</span>
        Export Excel akan menyertakan semua data termasuk jawaban custom field.
    </div>
    @if($hasFileFields ?? false)
        <span>•</span>
        <div class="flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">folder_zip</span>
            "Files ZIP" akan mengunduh semua file upload peserta dalam satu ZIP.
        </div>
    @endif
</div>
@endsection
