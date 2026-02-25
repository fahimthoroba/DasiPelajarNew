@extends('layouts.dashboard')

@section('content')
<div class="p-4 sm:p-6 space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-emerald-600 to-teal-500 dark:from-emerald-400 dark:to-teal-300">
                Data Organisasi
            </h1>
            <p class="text-slate-600 dark:text-slate-400 mt-1 text-sm">Kelola struktur PC, PAC, PR, dan PK.</p>
        </div>
        <div class="flex gap-2">
            <button onclick="document.getElementById('modal-tambah-organisasi').classList.remove('hidden')" class="inline-flex items-center px-4 py-2.5 text-sm font-medium rounded-xl text-white bg-emerald-600 hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-500/20 transition-all shadow-lg shadow-emerald-500/30">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Organisasi
            </button>
        </div>
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

    <!-- Cards List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($organisasis as $org)
        <div class="bg-white dark:bg-[#0f172a] rounded-2xl border border-slate-200/60 dark:border-white/5 overflow-hidden shadow-sm hover:shadow-md transition-shadow relative group">
            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r {{ $org->tingkat === 'PC' ? 'from-emerald-500 to-teal-400' : ($org->tingkat === 'PAC' ? 'from-blue-500 to-indigo-400' : 'from-amber-500 to-orange-400') }}"></div>
            
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold {{ $org->tingkat === 'PC' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400' : ($org->tingkat === 'PAC' ? 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400' : 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400') }}">
                            {{ $org->tingkat }}
                        </span>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mt-3">{{ $org->nama }}</h3>
                        @if($org->parent)
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                Induk: <span class="font-medium text-slate-700 dark:text-slate-300">{{ $org->parent->nama }}</span>
                            </p>
                        @endif
                    </div>
                </div>

                <div class="mt-6 flex gap-2">
                    <a href="{{ route('dashboard.sekretariat.organisasi.show', $org->id) }}" class="flex-1 inline-flex justify-center items-center px-4 py-2 text-sm font-medium rounded-xl text-emerald-700 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-500/10 dark:text-emerald-400 dark:hover:bg-emerald-500/20 transition-colors">
                        Kelola Organisasi
                    </a>
                    
                    <form action="{{ route('dashboard.sekretariat.organisasi.destroy', $org->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus organisasi ini? Semua data terkait (SK, Pengurus) mungkin terhapus.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex justify-center items-center p-2 text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 dark:bg-red-500/10 dark:hover:bg-red-500/20 rounded-xl transition-colors" title="Hapus Organisasi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal Tambah Organisasi -->
<div id="modal-tambah-organisasi" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="fixed inset-0 bg-slate-900/50 dark:bg-slate-900/80 backdrop-blur-sm transition-opacity" onclick="document.getElementById('modal-tambah-organisasi').classList.add('hidden')"></div>

        <div class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-[#0f172a] text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200 dark:border-white/10">
            <div class="px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-slate-200 dark:border-white/10">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                        <h3 class="text-xl font-bold leading-6 text-slate-900 dark:text-white" id="modal-title">Tambah Organisasi Baru</h3>
                        <p class="text-sm text-slate-500 mt-1">Pilih tingkat dan nama organisasi lokal.</p>
                    </div>
                </div>
            </div>
            
            <form action="{{ route('dashboard.sekretariat.organisasi.store') }}" method="POST">
                @csrf
                <div class="px-6 py-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tingkatan</label>
                        <select name="tingkat" class="w-full rounded-xl border-slate-200 dark:border-white/10 dark:bg-slate-900 dark:text-white py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-shadow">
                            <option value="PAC">Pimpinan Anak Cabang (PAC)</option>
                            <option value="PR">Pimpinan Ranting (PR)</option>
                            <option value="PK">Pimpinan Komisariat (PK)</option>
                            <option value="PC">Pimpinan Cabang (PC)</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama Organisasi (Contoh: "PAC Ngasem" / "PR Sukorejo")</label>
                        <input type="text" name="nama" required placeholder="Masukkan nama..." class="w-full rounded-xl border-slate-200 dark:border-white/10 dark:bg-slate-900 dark:text-white py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-shadow">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Induk Organisasi (Opsional, khusus PR/PK)</label>
                        <select name="parent_id" class="w-full rounded-xl border-slate-200 dark:border-white/10 dark:bg-slate-900 dark:text-white py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-shadow">
                            <option value="">-- Tidak Ada / Langsung Mandiri --</option>
                            @foreach($organisasis->whereIn('tingkat', ['PC', 'PAC']) as $induk)
                                <option value="{{ $induk->id }}">{{ $induk->nama }} ({{ $induk->tingkat }})</option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-slate-500">Contoh: PR Sukorejo induknya adalah PAC Ngasem.</p>
                    </div>
                </div>
                
                <div class="bg-slate-50 dark:bg-[#020617] px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-200 dark:border-white/10">
                    <button type="submit" class="inline-flex w-full justify-center rounded-xl bg-emerald-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-emerald-700 sm:ml-3 sm:w-auto transition-colors">Simpan</button>
                    <button type="button" onclick="document.getElementById('modal-tambah-organisasi').classList.add('hidden')" class="mt-3 inline-flex w-full justify-center rounded-xl px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 ring-1 ring-inset ring-slate-300 dark:ring-white/10 hover:bg-slate-50 dark:hover:bg-white/5 sm:mt-0 sm:w-auto transition-colors">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
