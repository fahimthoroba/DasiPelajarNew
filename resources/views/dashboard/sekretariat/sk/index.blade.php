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
                            <th class="px-6 py-4">Nama Organisasi</th>
                            <th class="px-6 py-4">Nomor SK</th>
                            <th class="px-6 py-4">Perihal / Judul</th>
                            <th class="px-6 py-4">Masa Berlaku</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Status (Periode)</th>
                            <th class="px-6 py-4 text-center">File</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                        @forelse($sks as $sk)
                            <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-800 dark:text-white">
                                    {{ $sk->organisasi?->tingkat }} {{ $sk->organisasi?->nama }}
                                </td>
                                <td class="px-6 py-4 font-mono font-bold text-slate-700 dark:text-slate-300">
                                    {{ $sk->nomor_sk }}
                                </td>
                                <td class="px-6 py-4 font-bold text-slate-800 dark:text-white">
                                    {{ $sk->judul_sk }}
                                </td>
                                <td class="px-6 py-4 text-xs whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($sk->tgl_berlaku)->format('d M Y') }} - 
                                    {{ \Carbon\Carbon::parse($sk->tgl_selesai)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $colors = [
                                            'Draft' => 'bg-slate-100 text-slate-700',
                                            'Menunggu Pengesahan PC' => 'bg-amber-100 text-amber-700',
                                            'Aktif' => 'bg-emerald-100 text-emerald-700',
                                            'Demisioner' => 'bg-purple-100 text-purple-700',
                                            'Ditolak' => 'bg-red-100 text-red-700'
                                        ];
                                        $color = $colors[$sk->status] ?? 'bg-slate-100 text-slate-700';
                                    @endphp
                                    <span class="{{ $color }} px-2 py-1 rounded text-[10px] font-bold uppercase whitespace-nowrap">
                                        {{ $sk->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if(\Carbon\Carbon::now()->between($sk->tgl_berlaku, $sk->tgl_selesai))
                                        <span class="text-emerald-500 font-bold text-xs"><span class="material-symbols-outlined text-[14px] align-middle">check_circle</span></span>
                                    @else
                                        <span class="text-rose-500 font-bold text-xs"><span class="material-symbols-outlined text-[14px] align-middle">cancel</span></span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($sk->file_sk_path)
                                        <a href="{{ Storage::url($sk->file_sk_path) }}" target="_blank"
                                           class="text-blue-600 hover:text-blue-800 transition-colors inline-block" title="Lihat PDF">
                                            <span class="material-symbols-outlined text-lg">description</span>
                                        </a>
                                    @else
                                        <span class="text-slate-300">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-2">
                                        @if(in_array(auth()->user()->role, ['admin', 'pc']) && $sk->status === 'Menunggu Pengesahan PC')
                                            <!-- Approve Button -->
                                            <form action="{{ route('dashboard.sekretariat.sk.update-status', $sk->id) }}" method="POST"
                                                onsubmit="return confirm('Sahkan SK ini menjadi Aktif?')">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="Aktif">
                                                <button type="submit" class="bg-emerald-50 text-emerald-600 hover:bg-emerald-100 px-2 py-1 rounded shadow-sm transition-colors text-xs font-bold" title="Sahkan SK">
                                                    Sahkan
                                                </button>
                                            </form>
                                            
                                            <!-- Reject Button -->
                                            <form action="{{ route('dashboard.sekretariat.sk.update-status', $sk->id) }}" method="POST"
                                                onsubmit="return confirm('Tolak pengajuan SK ini?')">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="Ditolak">
                                                <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-100 px-2 py-1 rounded shadow-sm transition-colors text-xs font-bold" title="Tolak SK">
                                                    Tolak
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('dashboard.sekretariat.sk.destroy', $sk->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus Data SK ini?')" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-slate-400 hover:text-red-600 p-1 transition-colors" title="Hapus SK">
                                                <span class="material-symbols-outlined text-lg">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-slate-400">
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
