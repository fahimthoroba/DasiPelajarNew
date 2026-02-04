@extends('layouts.dashboard')

@section('title', 'Admin - Edit Kegiatan')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('dashboard.admin.proker.index') }}"
                class="inline-flex items-center gap-2 text-gray-500 hover:text-emerald-600 transition-colors mb-2 text-sm">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Kembali
            </a>
            <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Edit Program Kerja (Admin Mode)</h1>
            <p class="text-sm text-gray-500">Mengedit kegiatan milik PAC:
                <strong>{{ $program->pac->name ?? 'Unknown' }}</strong></p>
        </div>

        @if(session('success'))
            <div
                class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 font-medium flex items-center gap-3 border border-emerald-100 dark:border-emerald-800">
                <span class="material-symbols-outlined">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('dashboard.admin.proker.update', $program->id) }}" method="POST"
            class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            @csrf
            @method('PUT')

            <!-- Left Column: Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 space-y-6">

                    <!-- Nama Kegiatan -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Nama Kegiatan</label>
                        <input type="text" name="nama_lokal" value="{{ old('nama_lokal', $program->nama_lokal) }}" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-surface-light dark:bg-gray-900 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                        @error('nama_lokal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Kategori
                            Program</label>
                        <select name="kategori_program_id"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-surface-light dark:bg-gray-900 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                            @foreach($kategoris as $cat)
                                <option value="{{ $cat->id }}" {{ old('kategori_program_id', $program->kategori_program_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_program_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Deskripsi &
                            Catatan</label>
                        <textarea name="deskripsi" rows="3"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-surface-light dark:bg-gray-900 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">{{ old('deskripsi', $program->deskripsi) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Right Column: Settings -->
            <div class="lg:col-span-1 space-y-6">
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 space-y-6">

                    <!-- Waktu -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Tanggal
                                Mulai</label>
                            <input type="date" name="tgl_mulai"
                                value="{{ old('tgl_mulai', $program->tgl_mulai->format('Y-m-d')) }}" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-surface-light dark:bg-gray-900 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Tanggal
                                Selesai</label>
                            <input type="date" name="tgl_selesai"
                                value="{{ old('tgl_selesai', $program->tgl_selesai->format('Y-m-d')) }}" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-surface-light dark:bg-gray-900 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Status Kegiatan</label>
                        <select name="status"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-surface-light dark:bg-gray-900 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                            <option value="Rencana" {{ old('status', $program->status) == 'Rencana' ? 'selected' : '' }}>
                                Rencana (Masih Konsep)</option>
                            <option value="Pasti" {{ old('status', $program->status) == 'Pasti' ? 'selected' : '' }}>Pasti
                                (Jadwal Fix)</option>
                            <option value="Terlaksana" {{ old('status', $program->status) == 'Terlaksana' ? 'selected' : '' }}>Terlaksana (Selesai)</option>
                        </select>
                    </div>

                    <!-- Target Peserta -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Target Peserta</label>
                        <div
                            class="space-y-2 max-h-48 overflow-y-auto px-1 bg-surface-light dark:bg-gray-900/50 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                            @foreach(['Internal PAC', 'Pengurus Ranting', 'Alumni', 'Pelajar', 'Masyarakat', 'Banom NU Lain'] as $target)
                                <label
                                    class="flex items-center gap-3 p-1 rounded-lg hover:bg-white dark:hover:bg-gray-800 cursor-pointer">
                                    <input type="checkbox" name="target_peserta[]" value="{{ $target }}" {{ in_array($target, old('target_peserta', $program->target_peserta ?? [])) ? 'checked' : '' }}
                                        class="w-4 h-4 rounded text-emerald-600 border-gray-300 focus:ring-emerald-500">
                                    <span class="text-sm text-gray-600 dark:text-gray-300">{{ $target }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-emerald-500/20 transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">save</span>
                        Simpan Perubahan
                    </button>

                </div>
            </div>
        </form>
    </div>
@endsection