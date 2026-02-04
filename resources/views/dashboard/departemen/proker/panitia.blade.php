@extends('layouts.dashboard')

@section('title', 'Bentuk Panitia - ' . $proker->nama_proker)

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard.departemen.proker.show', $proker->id) }}"
                class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-white/10 transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Susunan Panitia</h1>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm">
            <h2 class="font-bold text-lg mb-4">Tambah Panitia</h2>
            <form action="{{ route('dashboard.departemen.proker.panitia.store', $proker->id) }}" method="POST"
                class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">Jabatan</label>
                    <input type="text" name="jabatan"
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm"
                        placeholder="Contoh: Ketua Panitia">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">Pilih Kader (Opsional)</label>
                    <select name="kader_id" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm">
                        <option value="">-- Pilih Kader Departemen --</option>
                        @foreach($kaders as $kader)
                            <option value="{{ $kader->id }}">{{ $kader->nama_lengkap }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">Atau Nama Manual</label>
                    <input type="text" name="nama_manual"
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm"
                        placeholder="Jika bukan kader">
                </div>
                <div class="md:col-span-3 text-right">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-blue-700">Simpan
                        Panitia</button>
                </div>
            </form>
        </div>

        <!-- List -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-100 dark:border-white/5 overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 dark:bg-white/5">
                    <tr>
                        <th class="px-6 py-4 font-bold text-slate-600">Jabatan</th>
                        <th class="px-6 py-4 font-bold text-slate-600">Nama</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                    @forelse($proker->kepanitiaans as $panitia)
                        <tr>
                            <td class="px-6 py-4 font-bold">{{ $panitia->jabatan }}</td>
                            <td class="px-6 py-4">{{ $panitia->kader ? $panitia->kader->nama_lengkap : $panitia->nama_manual }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form
                                    action="{{ route('dashboard.departemen.proker.panitia.destroy', [$proker->id, $panitia->id]) }}"
                                    method="POST" onsubmit="return confirm('Hapus panitia ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-700 text-xs font-bold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-slate-400">Belum ada panitia terbentuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection