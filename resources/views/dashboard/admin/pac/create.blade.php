@extends('layouts.dashboard')

@section('title', 'Buat Akun PAC Baru')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard.admin.pac.index') }}"
                class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors text-gray-500">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div>
                <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Buat Akun PAC</h1>
                <p class="text-gray-500 text-sm mt-1">Tambahkan pengguna baru dengan role PAC.</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 p-6">
            <form action="{{ route('dashboard.admin.pac.store') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Nama PAC / Username --}}
                <div class="space-y-1">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Nama PAC (Username) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}"
                        placeholder="Contoh: PAC Mojoagung"
                        class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                    @error('name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="space-y-1">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Email Login <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}"
                        placeholder="pac.kecamatan@contoh.com"
                        class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                    <p class="text-[10px] text-gray-400">Email ini akan digunakan untuk login ke sistem.</p>
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="space-y-1">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password" id="password" required minlength="6"
                        placeholder="Minimal 6 karakter"
                        class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                    @error('password')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Korwas / Zona Wilayah --}}
                <div class="space-y-1">
                    <label for="zona_wilayah" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Korwas (Zona Wilayah) <span class="text-red-500">*</span>
                    </label>
                    <select name="zona_wilayah" id="zona_wilayah" required
                        class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all appearance-none">
                        <option value="">Pilih Zona...</option>
                        <option value="Timur" {{ old('zona_wilayah') == 'Timur' ? 'selected' : '' }}>Timur</option>
                        <option value="Barat" {{ old('zona_wilayah') == 'Barat' ? 'selected' : '' }}>Barat</option>
                        <option value="Utara" {{ old('zona_wilayah') == 'Utara' ? 'selected' : '' }}>Utara</option>
                        <option value="Selatan" {{ old('zona_wilayah') == 'Selatan' ? 'selected' : '' }}>Selatan</option>
                        <option value="Tengah" {{ old('zona_wilayah') == 'Tengah' ? 'selected' : '' }}>Tengah</option>
                    </select>
                    @error('zona_wilayah')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <a href="{{ route('dashboard.admin.pac.index') }}"
                        class="px-5 py-2 rounded-xl text-gray-600 hover:bg-gray-100 font-medium transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-medium shadow-lg shadow-emerald-500/20 transition-all transform hover:-translate-y-0.5">
                        Buat Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection