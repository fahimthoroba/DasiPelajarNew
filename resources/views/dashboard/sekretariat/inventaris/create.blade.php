@extends('layouts.dashboard')

@section('title', 'Catat Inventaris')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-8 items-center justify-between">
            <a href="{{ route('dashboard.sekretariat.inventaris.index') }}"
                class="text-amber-600 font-bold text-sm inline-flex items-center gap-1 hover:text-amber-700 mb-2">
                <span class="material-symbols-outlined text-lg">arrow_back</span> Kembali
            </a>
            <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Catat Barang</h1>
        </div>

        <form action="{{ route('dashboard.sekretariat.inventaris.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm space-y-5">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Barang</label>
                    <input type="text" name="nama_barang" required
                        class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kode Barang</label>
                    <input type="text" name="kode_barang" required
                        class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 dark:text-white">
                </div>
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kondisi</label>
                        <select name="kondisi"
                            class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 dark:text-white">
                            <option value="baik">Baik</option>
                            <option value="rusak_ringan">Rusak Ringan</option>
                            <option value="rusak_berat">Rusak Berat</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tgl
                            Pengadaan</label>
                        <input type="date" name="tgl_pengadaan" required
                            class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 dark:text-white">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Lokasi</label>
                    <input type="text" name="lokasi" required
                        class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 dark:text-white">
                </div>
            </div>
            <button type="submit"
                class="w-full bg-amber-600 text-white font-bold py-4 rounded-xl hover:bg-amber-700 transition-colors shadow-lg shadow-amber-900/20">Simpan
                Data</button>
        </form>
    </div>
@endsection