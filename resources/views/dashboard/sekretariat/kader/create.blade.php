@extends('layouts.dashboard')

@section('title', 'Tambah Kader')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-8 items-center justify-between">
            <a href="{{ route('dashboard.sekretariat.kader.index') }}"
                class="text-emerald-600 font-bold text-sm inline-flex items-center gap-1 hover:text-emerald-700 mb-2">
                <span class="material-symbols-outlined text-lg">arrow_back</span> Kembali
            </a>
            <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Tambah Kader Baru</h1>
        </div>

        <form action="{{ route('dashboard.sekretariat.kader.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm space-y-5">
                <!-- Data Diri -->
                <div class="border-b border-slate-100 dark:border-white/5 pb-4 mb-4">
                    <h3 class="font-bold text-slate-800 dark:text-white mb-4">Identitas Diri</h3>
                    <div class="grid grid-cols-1 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">NIK (Nomor
                                Induk Kependudukan)</label>
                            <input type="number" name="nik" required
                                class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama
                                Lengkap</label>
                            <input type="text" name="nama_lengkap" required
                                class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 dark:text-white">
                        </div>
                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tempat
                                    Lahir</label>
                                <input type="text" name="tempat_lahir" required
                                    class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal
                                    Lahir</label>
                                <input type="date" name="tgl_lahir" required
                                    class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 dark:text-white">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jenis
                                Kelamin</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="jenis_kelamin" value="L"
                                        class="text-emerald-600 focus:ring-emerald-500" checked>
                                    <span class="text-slate-700 dark:text-slate-300">Laki-laki</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="jenis_kelamin" value="P"
                                        class="text-emerald-600 focus:ring-emerald-500">
                                    <span class="text-slate-700 dark:text-slate-300">Perempuan</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Domisili -->
                <div class="border-b border-slate-100 dark:border-white/5 pb-4 mb-4">
                    <h3 class="font-bold text-slate-800 dark:text-white mb-4">Kontak & Domisili</h3>
                    <div class="grid grid-cols-1 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nomor HP /
                                WhatsApp</label>
                            <input type="text" name="no_hp" required
                                class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 dark:text-white">
                        </div>
                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Desa /
                                    Kelurahan</label>
                                <input type="text" name="desa" required
                                    class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 dark:text-white">
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kecamatan</label>
                                <input type="text" name="kecamatan" required
                                    class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 dark:text-white">
                            </div>
                        </div>
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kabupaten</label>
                            <input type="text" name="kabupaten" value="Kediri" required
                                class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 dark:text-white">
                        </div>
                    </div>
                </div>

                <!-- Foto -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Foto Profil</label>
                    <input type="file" name="foto_path" accept="image/*"
                        class="w-full block text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                </div>
            </div>
            <button type="submit"
                class="w-full bg-emerald-600 text-white font-bold py-4 rounded-xl hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-900/20">Simpan
                Data Kader</button>
        </form>
    </div>
@endsection