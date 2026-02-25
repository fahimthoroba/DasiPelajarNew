@extends('layouts.dashboard')

@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Manajemen Pengguna</h1>
                <p class="text-gray-500 text-sm mt-1">Kelola semua akun akses sistem (Admin, PC, PAC, dsb).</p>
            </div>
            <div class="flex gap-3">
                <form action="{{ route('dashboard.admin.users.index') }}" method="GET" class="flex items-center gap-2">
                    <select name="role" onchange="this.form.submit()" class="px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm focus:ring-2 focus:ring-emerald-500/50">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="pc" {{ request('role') == 'pc' ? 'selected' : '' }}>Pengurus Cabang</option>
                        <option value="pac" {{ request('role') == 'pac' ? 'selected' : '' }}>PAC</option>
                        <option value="departemen" {{ request('role') == 'departemen' ? 'selected' : '' }}>Lembaga/Departemen</option>
                    </select>
                </form>
                <a href="{{ route('dashboard.admin.users.create') }}"
                    class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-medium transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    Buat Akun Baru
                </a>
            </div>
        </div>

        <div
            class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-white/5 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 font-medium">
                        <tr>
                            <th class="px-6 py-4">Nama / Username</th>
                            <th class="px-6 py-4">Email Login</th>
                            <th class="px-6 py-4">Role</th>
                            <th class="px-6 py-4">Taut Organisasi</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-4 text-gray-500">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-md text-xs font-medium bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400 capitalize whitespace-nowrap">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 whitespace-nowrap">
                                        {{ $user->organisasi?->nama ?? 'Sistem Pusat (PC)' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                     <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('dashboard.admin.users.edit', $user->id) }}"
                                            class="text-amber-500 hover:text-amber-700 transition-colors" title="Edit Akun">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </a>

                                        @if($user->id !== auth()->id())
                                        <form action="{{ route('dashboard.admin.users.destroy', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus akun ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition-colors"
                                                title="Hapus Akun">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    Belum ada akun pengguna yang dibuat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="p-4 border-t border-gray-100 dark:border-white/5">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection