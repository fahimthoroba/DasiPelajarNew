@extends('layouts.dashboard')

@section('title', 'Manajemen SK')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Surat Keputusan (SK)</h1>
            <a href="{{ route('dashboard.sekretariat.sk.create') }}"
                class="bg-emerald-600 text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-emerald-700 flex items-center gap-2">
                <span class="material-symbols-outlined">add</span> Input SK Baru
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 dark:bg-white/5 text-slate-500 font-bold uppercase text-xs">
                        <tr>
                            <th class="px-6 py-4">Nomor SK</th>
                            <th class="px-6 py-4">Perihal / Judul</th>
                            <th class="px-6 py-4">Masa Berlaku</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">File</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                        @forelse($sks as $sk)
                            <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 font-mono font-bold text-slate-700 dark:text-slate-300">
                                    {{ $sk->nomor_sk }}
                                </td>
                                <td class="px-6 py-4 font-bold text-slate-800 dark:text-white">
                                    {{ $sk->judul_sk }}
                                </td>
                                <td class="px-6 py-4 text-xs">
                                    {{ \Carbon\Carbon::parse($sk->tgl_berlaku)->format('d M Y') }} - 
                                    {{ \Carbon\Carbon::parse($sk->tgl_selesai)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if(\Carbon\Carbon::now()->between($sk->tgl_berlaku, $sk->tgl_selesai))
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold uppercase">Aktif</span>
                                    @else
                                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold uppercase">Non-Aktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($sk->file_sk_path)
                                        <a href="{{ Storage::url($sk->file_sk_path) }}" target="_blank"
                                           class="text-blue-600 hover:underline text-xs font-bold flex items-center justify-end gap-1">
                                            <span class="material-symbols-outlined text-sm">attach_file</span> Lihat PDF
                                        </a>
                                    @else
                                        <span class="text-slate-400 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('dashboard.sekretariat.sk.destroy', $sk->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus Data SK ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-600 p-1">
                                            <span class="material-symbols-outlined text-lg">delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                    Belum ada data SK.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
