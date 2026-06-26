@extends('layouts.dashboard')

@section('title', 'Lengkapi Arsip Surat')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-8 items-center justify-between">
            <a href="{{ route('dashboard.sekretariat.surat-keluar.index') }}"
                class="text-emerald-600 font-bold text-sm inline-flex items-center gap-1 hover:text-emerald-700 mb-2">
                <span class="material-symbols-outlined text-lg">arrow_back</span> Kembali
            </a>
            <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Lengkapi Arsip Surat</h1>
            <p class="text-slate-500 dark:text-slate-400">Upload scan/foto surat yang sudah ditandatangani.</p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm space-y-4 mb-6">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Nomor Surat</p>
                <p class="font-mono text-sm whitespace-pre-line">{{ $surat->no_surat }}</p>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Perihal</p>
                <p class="text-sm">{{ $surat->perihal }}</p>
            </div>
            @if($surat->file_arsip)
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Arsip Saat Ini</p>
                <a href="{{ Storage::url($surat->file_arsip) }}" target="_blank" class="text-sm text-emerald-600 hover:underline">
                    Lihat file arsip
                </a>
            </div>
            @endif
        </div>

        <form action="{{ route('dashboard.sekretariat.surat-keluar.update', $surat->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                    {{ $surat->file_arsip ? 'Ganti File Arsip' : 'Upload File Arsip' }}
                </label>
                <input type="file" name="file_arsip" accept=".pdf,.doc,.docx" required
                    class="w-full block text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
            </div>

            <button type="submit"
                class="w-full bg-emerald-600 text-white font-bold py-4 rounded-xl hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-900/20">
                Upload & Tandai Lengkap
            </button>
        </form>
    </div>
@endsection
