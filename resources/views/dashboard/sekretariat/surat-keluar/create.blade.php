@extends('layouts.dashboard')

@section('title', 'Buat Surat Keluar')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-8 items-center justify-between">
            <a href="{{ route('dashboard.sekretariat.surat-keluar.index') }}"
                class="text-emerald-600 font-bold text-sm inline-flex items-center gap-1 hover:text-emerald-700 mb-2">
                <span class="material-symbols-outlined text-lg">arrow_back</span> Kembali
            </a>
            <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Buat Surat Keluar</h1>
            <p class="text-slate-500 dark:text-slate-400">Nomor surat akan diterbitkan otomatis sesuai format resmi.</p>
        </div>

        @if($errors->any())
        <div class="mb-4 px-4 py-3 rounded-xl text-sm font-semibold bg-red-50 text-red-700 border border-red-200">
            {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('dashboard.sekretariat.surat-keluar.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6"
            x-data="{
                jenisSurat: 'reguler',
                jenisOrganisasi: '',
                kodeIndeksIpnu: {{ \Illuminate\Support\Js::from($kodeIndeks['IPNU'] ?? []) }},
                kodeIndeksIppnu: {{ \Illuminate\Support\Js::from($kodeIndeks['IPPNU'] ?? []) }},
                get kodeIndeksList() {
                    return this.jenisOrganisasi === 'IPPNU' ? this.kodeIndeksIppnu : this.kodeIndeksIpnu;
                }
            }">
            @csrf

            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm space-y-5">

                <!-- Jenis Surat -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jenis Surat</label>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach(['reguler' => 'Reguler', 'bersama' => 'Bersama', 'kepanitiaan' => 'Kepanitiaan', 'kepanitiaan_bersama' => 'Kepanitiaan Bersama'] as $val => $label)
                        <label class="flex items-center gap-2 p-3 rounded-xl border cursor-pointer"
                            :class="jenisSurat === '{{ $val }}' ? 'border-emerald-500 bg-emerald-50' : 'border-slate-200'">
                            <input type="radio" name="jenis_surat" value="{{ $val }}" x-model="jenisSurat"
                                class="text-emerald-600 focus:ring-emerald-500" {{ $val === 'reguler' ? 'checked' : '' }}>
                            <span class="text-sm font-semibold">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Organisasi -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Organisasi</label>
                    <select name="organisasi_id" required
                        class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm">
                        <option value="">Pilih Organisasi...</option>
                        @foreach($organisasis as $org)
                        <option value="{{ $org->id }}">{{ $org->nama }} ({{ $org->tingkat }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Jenis Organisasi (Reguler + Kepanitiaan) -->
                <div x-show="jenisSurat === 'reguler' || jenisSurat === 'kepanitiaan'" x-cloak>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jenis Organisasi</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2"><input type="radio" name="jenis_organisasi" value="IPNU" x-model="jenisOrganisasi"> IPNU</label>
                        <label class="flex items-center gap-2"><input type="radio" name="jenis_organisasi" value="IPPNU" x-model="jenisOrganisasi"> IPPNU</label>
                    </div>
                </div>

                <!-- Kode Indeks (Reguler saja) -->
                <div x-show="jenisSurat === 'reguler'" x-cloak>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kode Indeks</label>
                    <select name="kode_indeks"
                        class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm">
                        <option value="">Pilih Kode Indeks...</option>
                        <template x-for="(label, kode) in kodeIndeksList" :key="kode">
                            <option :value="kode" x-text="kode + ' — ' + label"></option>
                        </template>
                    </select>
                </div>

                <!-- ProgramKerja Kepanitiaan -->
                <div x-show="jenisSurat === 'kepanitiaan' || jenisSurat === 'kepanitiaan_bersama'" x-cloak>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kepanitiaan</label>
                    @if($prokerKepanitiaan->isEmpty())
                    <p class="text-sm text-amber-600">Belum ada Program Kerja kepanitiaan dengan Kode Surat terisi. Lengkapi dulu di halaman Susunan Panitia.</p>
                    @else
                    <select name="program_kerja_id"
                        class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm">
                        <option value="">Pilih Kepanitiaan...</option>
                        @foreach($prokerKepanitiaan as $p)
                        <option value="{{ $p->id }}">Pan.{{ $p->kode_surat_kepanitiaan }} — {{ $p->nama_proker }}</option>
                        @endforeach
                    </select>
                    @endif
                </div>

                <!-- Tujuan -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tujuan Surat</label>
                    <input type="text" name="tujuan" required
                        class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3"
                        placeholder="Contoh: PAC IPNU IPPNU Pare">
                </div>

                <!-- Perihal -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Perihal</label>
                    <input type="text" name="perihal" required
                        class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3"
                        placeholder="Contoh: Undangan Pelantikan">
                </div>

                <!-- Tgl Surat -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Surat</label>
                    <input type="date" name="tgl_surat" required value="{{ date('Y-m-d') }}"
                        class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3">
                </div>

                <!-- File Arsip (Opsional, Fase 2 bisa belakangan) -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Arsip Surat (Opsional)</label>
                    <input type="file" name="file_arsip" accept=".pdf,.doc,.docx"
                        class="w-full block text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                    <p class="text-xs text-slate-400 mt-1">Boleh dikosongkan sekarang, upload belakangan setelah surat fisik selesai ditandatangani.</p>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-emerald-600 text-white font-bold py-4 rounded-xl hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-900/20 mt-6">
                Simpan & Terbitkan Nomor
            </button>
        </form>
    </div>
@endsection
