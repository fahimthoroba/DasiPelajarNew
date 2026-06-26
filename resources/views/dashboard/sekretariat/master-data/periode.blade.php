@extends('layouts.dashboard')

@section('title', 'Periode Kepengurusan')

@section('content')
    <div class="space-y-6" x-data="{
        romawi(n) {
            if (!n || n <= 0) return '';
            const map = [[100,'C'],[90,'XC'],[50,'L'],[40,'XL'],[10,'X'],[9,'IX'],[5,'V'],[4,'IV'],[1,'I']];
            let result = '';
            let num = parseInt(n);
            for (const [val, sym] of map) {
                while (num >= val) { result += sym; num -= val; }
            }
            return result;
        }
    }">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard.sekretariat.master-data.index') }}"
                class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-emerald-600 hover:border-emerald-500 hover:shadow-sm transition-all">
                <span class="material-symbols-outlined text-xl">arrow_back</span>
            </a>
            <div>
                <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Periode Kepengurusan</h1>
                <p class="text-slate-500 dark:text-slate-400">Set periode aktif per organisasi, dipakai untuk format nomor surat.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                <span class="material-symbols-outlined text-base">check_circle</span>
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold bg-red-50 text-red-700 border border-red-200">
                <span class="material-symbols-outlined text-base">error</span>
                {{ $errors->first() }}
            </div>
        @endif

        @foreach($organisasis as $org)
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm">
            <h3 class="font-bold text-lg mb-4 text-slate-800 dark:text-white">{{ $org->nama }}</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @foreach(['IPNU', 'IPPNU'] as $jenis)
                @php
                    $periodeAktif = ($aktif[$org->id] ?? collect())->firstWhere('jenis_organisasi', $jenis);
                @endphp
                <form action="{{ route('dashboard.sekretariat.master-data.periode.store') }}" method="POST"
                      x-data="{ periodeKe: {{ $periodeAktif->periode_ke ?? '' }} }"
                      class="p-4 rounded-xl border border-slate-100 dark:border-white/5 space-y-3">
                    @csrf
                    <input type="hidden" name="organisasi_id" value="{{ $org->id }}">
                    <input type="hidden" name="jenis_organisasi" value="{{ $jenis }}">

                    <div class="flex items-center justify-between">
                        <span class="font-bold text-sm" style="color: {{ $jenis === 'IPNU' ? '#08332c' : '#ba9e6f' }};">{{ $jenis }}</span>
                        @if($periodeAktif)
                            <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700">
                                Aktif: <span x-text="romawi(periodeKe) || '{{ $periodeAktif->periode_romawi }}'"></span>
                            </span>
                        @else
                            <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-500">Belum diset</span>
                        @endif
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Periode ke</label>
                        <input type="number" name="periode_ke" min="1" x-model="periodeKe" required
                            class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-sm">
                        <p class="text-xs text-slate-400 mt-1">Preview: <span class="font-bold" x-text="romawi(periodeKe) || '—'"></span></p>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Mulai</label>
                            <input type="date" name="tgl_mulai" value="{{ $periodeAktif?->tgl_mulai?->format('Y-m-d') }}"
                                class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Selesai</label>
                            <input type="date" name="tgl_selesai" value="{{ $periodeAktif?->tgl_selesai?->format('Y-m-d') }}"
                                class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-sm">
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full px-4 py-2 rounded-lg text-sm font-bold bg-emerald-600 text-white hover:bg-emerald-700 transition-colors">
                        Aktifkan Periode Ini
                    </button>
                </form>
                @endforeach
            </div>
        </div>
        @endforeach

        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm">
            <h3 class="font-bold text-lg mb-4 text-slate-800 dark:text-white">Riwayat</h3>
            @if($riwayat->count())
            <div class="divide-y divide-slate-100 dark:divide-white/5">
                @foreach($riwayat as $r)
                <div class="flex items-center justify-between py-3 text-sm">
                    <div>
                        <span class="font-bold">{{ $r->periode_romawi }}</span>
                        <span class="text-slate-400 mx-1">·</span>
                        <span>{{ $r->organisasi->nama ?? '—' }}</span>
                        <span class="text-slate-400 mx-1">·</span>
                        <span>{{ $r->jenis_organisasi }}</span>
                        @if($r->tgl_mulai || $r->tgl_selesai)
                            <span class="text-slate-400">
                                ({{ $r->tgl_mulai?->format('Y') }}{{ $r->tgl_selesai ? '-' . $r->tgl_selesai->format('Y') : '' }})
                            </span>
                        @endif
                    </div>
                    <span class="text-xs font-bold px-2 py-0.5 rounded-full {{ $r->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                        {{ $r->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-sm text-slate-400">Belum ada riwayat periode.</p>
            @endif
        </div>
    </div>
@endsection
