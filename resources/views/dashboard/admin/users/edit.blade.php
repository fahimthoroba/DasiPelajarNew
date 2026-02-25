@extends('layouts.dashboard')

@section('title', 'Edit Akun Pengguna')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard.admin.users.index') }}"
                class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors text-gray-500">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div>
                <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Edit Akun Pengguna</h1>
                <p class="text-gray-500 text-sm mt-1">Perbarui data atau hak akses pengguna.</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 p-6">
            <form action="{{ route('dashboard.admin.users.update', $user->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Nama Pengguna / Username --}}
                <div class="space-y-1">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Nama Pengguna (Username) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $user->name) }}"
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
                    <input type="email" name="email" id="email" required value="{{ old('email', $user->email) }}"
                        class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="space-y-1">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Password (Opsional)
                    </label>
                    <input type="password" name="password" id="password" minlength="6"
                        placeholder="Biarkan kosong jika tidak ingin mengubah password"
                        class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                    @error('password')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Role Sistem --}}
                    <div class="space-y-1">
                        <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Role (Hak Akses) <span class="text-red-500">*</span>
                        </label>
                        <select name="role" id="role" required
                            class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all appearance-none">
                            <option value="">Pilih Role...</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin Web Penuh</option>
                            <option value="pc" {{ old('role', $user->role) == 'pc' ? 'selected' : '' }}>Pengurus Cabang</option>
                            <option value="pac" {{ old('role', $user->role) == 'pac' ? 'selected' : '' }}>Pimpinan Anak Cabang (PAC)</option>
                            <option value="departemen" {{ old('role', $user->role) == 'departemen' ? 'selected' : '' }}>Lembaga / Departemen PC</option>
                        </select>
                        @error('role')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Organisasi Detail (Opsional) --}}
                    <div class="space-y-1">
                        <label for="organisasi_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Tautkan ke Organisasi
                        </label>
                        <select name="organisasi_id" id="organisasi_id"
                            class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all appearance-none">
                            <option value="">Tidak Ditautkan (Akses Global/Pusat)</option>
                            @foreach($organisasis as $org)
                                <option value="{{ $org->id }}" {{ old('organisasi_id', $user->organisasi_id) == $org->id ? 'selected' : '' }}>
                                    {{ $org->tingkat }} {{ $org->nama }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-gray-400">Wajib diisi jika Role adalah PAC / PR / PK.</p>
                        @error('organisasi_id')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <a href="{{ route('dashboard.admin.users.index') }}"
                        class="px-5 py-2 rounded-xl text-gray-600 hover:bg-gray-100 font-medium transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-medium shadow-lg shadow-emerald-500/20 transition-all transform hover:-translate-y-0.5">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection