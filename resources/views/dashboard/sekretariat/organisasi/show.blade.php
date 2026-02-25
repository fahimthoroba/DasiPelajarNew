@extends('layouts.dashboard')

@section('content')
<div class="p-4 sm:p-6 space-y-6">
    <!-- Breadcrumb & Header -->
    <div>
        <nav class="flex text-sm text-slate-500 dark:text-slate-400 mb-4 cursor-default">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard.sekretariat.organisasi.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                        Data Organisasi
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-slate-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ml-1 font-medium text-slate-700 dark:text-slate-200">{{ $organisasi->nama }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <h1 class="text-3xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
            {{ $organisasi->nama }}
            <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400 align-middle">
                {{ $organisasi->tingkat }}
            </span>
        </h1>
        <p class="text-slate-600 dark:text-slate-400 mt-2">Pilih periode SK kepengurusan untuk mengelola anggota strukturnya.</p>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
    <div class="p-4 rounded-xl relative overflow-hidden bg-emerald-50 text-emerald-800 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 to-transparent"></div>
        <div class="relative flex items-start gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <!-- SK List Section -->
    <div class="bg-white dark:bg-[#0f172a] rounded-2xl border border-slate-200/60 dark:border-white/5 overflow-hidden shadow-sm">
        <div class="px-6 py-5 border-b border-slate-200 dark:border-white/10 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900 dark:text-white">Daftar Surat Keputusan (SK)</h3>
                <p class="text-sm text-slate-500 mt-0.5">Riwayat periode kepengurusan {{ $organisasi->nama }}</p>
            </div>
            <!-- Toggle Modal for SK - In Future could be its own dedicated controller method -->
            <button onclick="document.getElementById('modal-tambah-sk').classList.remove('hidden')" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-xl text-emerald-700 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-500/10 dark:text-emerald-400 dark:hover:bg-emerald-500/20 transition-colors">
                <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah SK
            </button>
        </div>

        <div class="divide-y divide-slate-100 dark:divide-white/5">
            @forelse($sks as $sk)
            <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 {{ $sk->tgl_selesai >= now()->format('Y-m-d') ? 'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400' }}">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h4 class="font-bold text-slate-900 dark:text-white text-lg">{{ $sk->judul_sk }}</h4>
                            @if($sk->tgl_selesai >= now()->format('Y-m-d'))
                                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400 text-xs font-semibold">Aktif</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400 text-xs font-semibold">Demisioner</span>
                            @endif
                        </div>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">No: {{ $sk->nomor_sk }} | Jabatan: {{ \Carbon\Carbon::parse($sk->tgl_berlaku)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($sk->tgl_selesai)->format('d M Y') }}</p>
                    </div>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('dashboard.sekretariat.pengurus.index', ['organisasi_id' => $organisasi->id, 'sk_id' => $sk->id]) }}" class="inline-flex justify-center items-center px-5 py-2.5 text-sm font-medium rounded-xl text-white bg-emerald-600 hover:bg-emerald-700 transition-colors shadow-sm focus:ring-4 focus:ring-emerald-500/20">
                        Input / Edit Struktur
                    </a>
                </div>
            </div>
            @empty
            <div class="p-8 text-center">
                <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto mb-4 text-slate-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h3 class="text-slate-900 dark:text-white font-medium mb-1">Belum Ada SK</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm">Tambahkan Surat Keputusan pertama untuk memulai input struktur kepengurusan {{ $organisasi->tingkat }}.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Placeholder Modal Tambah SK -->
<div id="modal-tambah-sk" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <!-- Di implementasikan menyusul, diarahkan ke create form standard dulu / ajax di kemudian hari -->
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="fixed inset-0 bg-slate-900/50 dark:bg-slate-900/80 backdrop-blur-sm transition-opacity" onclick="document.getElementById('modal-tambah-sk').classList.add('hidden')"></div>
        <div class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-[#0f172a] text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200 dark:border-white/10 p-6">
             <h3 class="text-xl font-bold mb-4 dark:text-white">Tambah Surat Keputusan</h3>
             <form action="{{ route('dashboard.sekretariat.sk.store') }}" method="POST">
                @csrf
                <input type="hidden" name="organisasi_id" value="{{ $organisasi->id }}">
                <div class="space-y-4 mb-6">
                     <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nomor SK</label>
                        <input type="text" name="nomor_sk" required class="w-full rounded-xl border-slate-200 dark:border-white/10 dark:bg-slate-900 dark:text-white py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Judul SK (Contoh: Kepengurusan PR Sukorejo 2024-2026)</label>
                        <input type="text" name="judul_sk" required class="w-full rounded-xl border-slate-200 dark:border-white/10 dark:bg-slate-900 dark:text-white py-2">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Mulai Berlaku</label>
                            <input type="date" name="tgl_berlaku" required class="w-full rounded-xl border-slate-200 dark:border-white/10 dark:bg-slate-900 dark:text-white py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Akhir Masa Khidmat</label>
                            <input type="date" name="tgl_selesai" required class="w-full rounded-xl border-slate-200 dark:border-white/10 dark:bg-slate-900 dark:text-white py-2">
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('modal-tambah-sk').classList.add('hidden')" class="px-4 py-2 text-sm text-slate-600 border border-slate-300 rounded-xl">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl">Simpan SK</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
