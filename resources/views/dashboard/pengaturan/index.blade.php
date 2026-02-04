@extends('layouts.dashboard')

@section('title', 'Pengaturan Website')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Pengaturan Website</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Atur identitas, kontak, dan teks dinamis website.</p>
        </div>
    </div>

    @if(session('success'))
        <div
            class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 font-medium flex items-center gap-3 border border-emerald-100 dark:border-emerald-800">
            <span class="material-symbols-outlined">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div
            class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 font-medium border border-red-100 dark:border-red-800">
            <h4 class="font-bold mb-2">Terjadi Kesalahan:</h4>
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dashboard.pengaturan.update') }}" method="POST" enctype="multipart/form-data"
        x-data="{ tab: 'identitas' }" class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        @csrf
        @method('PUT')

        <!-- Sidebar Menu Settings -->
        <div class="lg:col-span-1 space-y-2">
            <button type="button" @click="tab = 'identitas'"
                :class="tab === 'identitas' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/20' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'"
                class="w-full text-left px-5 py-3 rounded-xl font-bold transition-all flex items-center gap-3">
                <span class="material-symbols-outlined">badge</span>
                Identitas Website
            </button>

            <button type="button" @click="tab = 'sosmed'"
                :class="tab === 'sosmed' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/20' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'"
                class="w-full text-left px-5 py-3 rounded-xl font-bold transition-all flex items-center gap-3">
                <span class="material-symbols-outlined">share</span>
                Kontak & Sosmed
            </button>

            <div class="pt-6">
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-emerald-800 hover:bg-emerald-900 text-white font-bold py-3 rounded-xl shadow-lg shadow-emerald-900/20 transition-all">
                    <span class="material-symbols-outlined">save</span>
                    Simpan Perubahan
                </button>
            </div>
        </div>

        <!-- Content Area -->
        <div
            class="lg:col-span-3 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 min-h-[500px]">

            <!-- Tab: Identitas -->
            <div x-show="tab === 'identitas'" x-transition.opacity class="space-y-6">
                <h3
                    class="text-xl font-bold text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-4 mb-6">
                    Identitas Website</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Nama Website</label>
                        <input type="text" name="nama_website" value="{{ old('nama_website', $pengaturan->nama_website) }}"
                            required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Upload Logo</label>
                        <input type="file" name="logo" accept="image/*"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-500 text-sm focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                        @if($pengaturan->logo_path)
                            <div class="mt-2 text-xs text-gray-500">Logo saat ini: <a
                                    href="{{ asset('storage/' . $pengaturan->logo_path) }}" target="_blank"
                                    class="text-emerald-600 hover:underline">Lihat</a></div>
                        @endif
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Deskripsi Singkat (Meta
                        Description)</label>
                    <textarea name="deskripsi_singkat" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">{{ old('deskripsi_singkat', $pengaturan->deskripsi_singkat) }}</textarea>
                </div>
            </div>



            <!-- Tab: Kontak & Sosmed -->
            <div x-show="tab === 'sosmed'" x-transition.opacity class="space-y-6" style="display: none;">
                <h3
                    class="text-xl font-bold text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-4 mb-6">
                    Kontak & Media Sosial</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $pengaturan->email) }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">WhatsApp</label>
                        <input type="text" name="no_wa" value="{{ old('no_wa', $pengaturan->no_wa) }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Alamat Lengkap</label>
                        <input type="text" name="alamat" value="{{ old('alamat', $pengaturan->alamat) }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Link Facebook</label>
                        <input type="url" name="facebook" value="{{ old('facebook', $pengaturan->facebook) }}"
                            placeholder="https://facebook.com/..."
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Link Instagram</label>
                        <input type="url" name="instagram" value="{{ old('instagram', $pengaturan->instagram) }}"
                            placeholder="https://instagram.com/..."
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Link YouTube</label>
                        <input type="url" name="youtube" value="{{ old('youtube', $pengaturan->youtube) }}"
                            placeholder="https://youtube.com/..."
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Link TikTok</label>
                        <input type="url" name="tiktok" value="{{ old('tiktok', $pengaturan->tiktok) }}"
                            placeholder="https://tiktok.com/..."
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500/20 transition-all">
                    </div>
                </div>
            </div>

        </div>
    </form>
@endsection