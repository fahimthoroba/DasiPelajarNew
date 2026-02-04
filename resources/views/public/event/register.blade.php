@extends('layouts.app')

@section('title', 'Pendaftaran - ' . $proker->nama_proker)

@section('content')
    <div class="min-h-screen bg-slate-50 flex items-center justify-center p-4">
        <div class="max-w-2xl w-full bg-white p-8 rounded-3xl shadow-xl border border-slate-100">

            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold font-display text-slate-800 mb-2">{{ $proker->nama_proker }}</h1>
                <p class="text-slate-500 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">calendar_today</span>
                    {{ $proker->tgl_pelaksanaan->format('l, d F Y') }}
                    <span class="mx-2">•</span>
                    <span class="material-symbols-outlined text-sm">apartment</span>
                    {{ $proker->departemen->nama }}
                </p>
            </div>

            @if(session('success'))
                <div class="bg-green-50 text-green-700 p-6 rounded-2xl text-center mb-6">
                    <div
                        class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-3xl">check</span>
                    </div>
                    <h2 class="text-xl font-bold mb-2">Pendaftaran Berhasil!</h2>
                    <p>Data Anda telah kami terima.</p>
                </div>
            @else

                <!-- Smart Form -->
                <div x-data="registrationForm()">
                    <form action="{{ route('public.event.store', $proker->registration_link_token) }}" method="POST"
                        class="space-y-6">
                        @csrf

                        <!-- NIA Check -->
                        <div class="bg-blue-50 border border-blue-100 p-4 rounded-xl mb-6">
                            <h3 class="font-bold text-blue-800 text-sm mb-2 flex items-center gap-2">
                                <span class="material-symbols-outlined text-base">verified_user</span>
                                Anggota DASI Pelajar?
                            </h3>
                            <div class="flex gap-2">
                                <input type="text" x-model="nia" @blur="checkNia()" name="nia"
                                    class="flex-1 bg-white border border-blue-200 rounded-lg px-4 py-2 text-sm"
                                    placeholder="Masukkan NIA untuk isi otomatis">
                                <button type="button" @click="checkNia()"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-blue-700">
                                    Cek
                                </button>
                            </div>
                            <p x-show="found" x-transition
                                class="text-xs text-green-600 mt-2 font-bold flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">check_circle</span> Data ditemukan! Formulir
                                terisi otomatis.
                            </p>
                            <p x-show="notFound" x-transition class="text-xs text-amber-600 mt-2 flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">info</span> NIA tidak ditemukan. Silakan isi
                                formulir secara manual.
                            </p>
                        </div>

                        <!-- Biodata (Auto-filled or Manual) -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="nama" x-model="form.nama" :readonly="found"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Nomor HP (WA)</label>
                                <input type="text" name="no_hp" x-model="form.no_hp" :readonly="found"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Jenis Kelamin</label>
                                <select name="jenis_kelamin" x-model="form.jenis_kelamin" :disabled="found"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                                <!-- Hidden input to submit disabled select value -->
                                <input type="hidden" name="jenis_kelamin" x-model="form.jenis_kelamin" x-if="found">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" x-model="form.tempat_lahir" :readonly="found"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" x-model="form.tgl_lahir" :readonly="found"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Alamat Domisili</label>
                            <textarea name="alamat" x-model="form.alamat" :readonly="found" rows="3"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all"></textarea>
                        </div>

                        <div class="pt-4">
                            <button type="submit"
                                class="w-full bg-emerald-600 text-white font-bold py-4 rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-600/20">
                                Daftar Kegiatan
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <script>
        function registrationForm() {
            return {
                nia: '',
                found: false,
                notFound: false,
                form: {
                    nama: '',
                    no_hp: '',
                    jenis_kelamin: 'L',
                    tempat_lahir: '',
                    tgl_lahir: '',
                    alamat: ''
                },
                async checkNia() {
                    if (this.nia.length < 5) return;

                    try {
                        const response = await fetch('{{ route("public.check-nia") }}?nia=' + this.nia);
                        const result = await response.json();

                        if (result.found) {
                            this.found = true;
                            this.notFound = false;
                            this.form = result.data; // Assumes keys match
                        } else {
                            this.found = false;
                            this.notFound = true;
                            // Reset form or keep empty for manual input
                            this.form = { nama: '', no_hp: '', jenis_kelamin: 'L', tempat_lahir: '', tgl_lahir: '', alamat: '' };
                        }
                    } catch (error) {
                        console.error('Error verifying NIA', error);
                    }
                }
            }
        }
    </script>
@endsection