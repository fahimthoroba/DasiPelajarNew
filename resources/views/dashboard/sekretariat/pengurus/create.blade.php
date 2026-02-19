@extends('layouts.dashboard')

@section('title', 'Tambah Pengurus')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard.sekretariat.pengurus.index') }}"
                class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-white/10 transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Tambah Pengurus Baru</h1>
        </div>

        <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm">
            <form action="{{ route('dashboard.sekretariat.pengurus.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Kader Selection -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Pilih Kader</label>
                    <select name="kader_id" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5">
                        <option value="">-- Cari Kader --</option>
                        @foreach($kaders as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_lengkap }} ({{ $k->nik }})</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-slate-400 mt-1">*Hanya menampilkan kader yang terdaftar.</p>
                </div>

                <!-- Tingkatan -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Tingkatan</label>
                        <select name="tingkatan" required
                            class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5">
                            <option value="Cabang">Cabang (PC)</option>
                            <option value="Anak Cabang">Anak Cabang (PAC)</option>
                            <option value="Ranting">Ranting (PR)</option>
                            <option value="Komisariat">Komisariat (PK)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Nama
                            Tingkatan</label>
                        <input type="text" name="nama_tingkatan" required
                            placeholder="Contoh: PC Kediri, PAC Mojo, Desa Ngadi..."
                            class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5">
                        <p class="text-xs text-slate-400 mt-1">Isi sesuai level (Kecamatan/Desa/Sekolah).</p>
                    </div>
                </div>

                <!-- Jabatan -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Jabatan</label>
                    <select name="jabatan" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5">
                        <option value="">-- Pilih Jabatan --</option>
                        <option value="Ketua">Ketua</option>
                        <option value="Wakil Ketua">Wakil Ketua</option>
                        <option value="Sekretaris">Sekretaris</option>
                        <option value="Wakil Sekretaris">Wakil Sekretaris</option>
                        <option value="Bendahara">Bendahara</option>
                        <option value="Wakil Bendahara">Wakil Bendahara</option>
                        <option value="Koordinator">Koordinator</option>
                        <option value="Direktur">Direktur</option>
                        <option value="Komandan">Komandan</option>
                        <option value="Anggota">Anggota</option>
                    </select>
                </div>

                <!-- Atasan Langsung (Parent) -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Atasan Langsung (Parent)</label>
                    <select name="parent_id" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5">
                        <option value="">-- Tidak Memiliki Atasan Langsung (Root) --</option>
                        @foreach($parents as $p)
                            <option value="{{ $p->id }}">
                                {{ $p->jabatan }} - {{ $p->kader->nama_lengkap }} 
                                {{ $p->departemenData ? '('.$p->departemenData->nama_departemen.')' : '' }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-slate-400 mt-1">
                        Contoh: Anggota Dept -> Pilih Koordinator Dept. | Koordinator/W.Sek/W.Ben -> Pilih Wakil Ketua.
                    </p>
                </div>

                <!-- Departemen (Optional) -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Departemen / Lembaga</label>
                    <select name="departemen_id" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5">
                        <option value="">-- Tidak Terikat Departemen/Lembaga --</option>
                        @foreach($departemens as $d)
                            <option value="{{ $d->id }}">{{ $d->nama_departemen }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-slate-400 mt-1">
                        Wajib diisi untuk Wakil Ketua, Koordinator, dan Anggota Departemen.
                    </p>
                </div>

                <!-- SK Setup -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Dasar SK</label>
                    <select name="surat_keputusan_id" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5">
                        @foreach($sks as $sk)
                            <option value="{{ $sk->id }}">{{ $sk->nomor_sk }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="pt-4 text-right">
                    <button type="submit"
                        class="bg-emerald-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-emerald-700 transition-colors">
                        Simpan Pengurus
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection