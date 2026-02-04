@extends('layouts.dashboard')

@section('title', 'Setup Pendaftaran - ' . $proker->nama_proker)

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard.departemen.proker.show', $proker->id) }}"
                class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-white/10 transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Setup Pendaftaran</h1>
        </div>

        <!-- Toggle Configuration -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="font-bold text-lg text-slate-800 dark:text-white">Tipe Pendaftaran</h2>
                    <p class="text-sm text-slate-500">Tentukan apakah pendaftaran ini terbuka untuk umum (Via Link) atau
                        Internal saja.</p>
                </div>

                <form action="{{ route('dashboard.departemen.proker.pendaftaran.update', $proker->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="flex items-center gap-2">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_public_registration" value="1" class="sr-only peer"
                                onchange="this.form.submit()" {{ $proker->is_public_registration ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                            </div>
                            <span class="ml-3 text-sm font-bold text-slate-800 dark:text-white">Link Publik</span>
                        </label>
                    </div>
                </form>
            </div>

            @if($proker->is_public_registration && $proker->registration_link_token)
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-xl p-4">
                    <label class="block text-xs font-bold text-blue-600 uppercase mb-2">Link Pendaftaran</label>
                    <div class="flex items-center gap-2">
                        <input type="text" readonly
                            value="{{ route('public.event.register', $proker->registration_link_token) }}"
                            class="flex-1 bg-white dark:bg-gray-800 border border-slate-200 dark:border-white/10 rounded-lg px-3 py-2 text-sm text-slate-600 font-mono">
                        <button
                            onclick="navigator.clipboard.writeText('{{ route('public.event.register', $proker->registration_link_token) }}')"
                            class="bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700 transition-colors">
                            <span class="material-symbols-outlined">content_copy</span>
                        </button>
                        <a href="{{ route('public.event.register', $proker->registration_link_token) }}" target="_blank"
                            class="bg-slate-200 dark:bg-white/10 text-slate-600 dark:text-slate-300 p-2 rounded-lg hover:bg-slate-300 transition-colors">
                            <span class="material-symbols-outlined">open_in_new</span>
                        </a>
                    </div>
                    <p class="text-xs text-blue-500 mt-2 flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">info</span>
                        Share link ini kepada calon peserta.
                    </p>
                </div>
            @else
                <div class="bg-slate-50 dark:bg-white/5 border border-slate-100 dark:border-white/5 rounded-xl p-4 text-center">
                    <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">link_off</span>
                    <p class="text-sm text-slate-500">Pendaftaran publik dinonaktifkan. Aktifkan toggle di atas untuk
                        mendapatkan link.</p>
                </div>
            @endif
        </div>

        <!-- Registrant List (Placeholder for now) -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-100 dark:border-white/5 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 dark:border-white/5 flex justify-between items-center">
                <h2 class="font-bold text-lg text-slate-800 dark:text-white">Data Pendaftar</h2>
                <span
                    class="bg-slate-100 dark:bg-white/10 text-slate-600 dark:text-slate-300 px-3 py-1 rounded-full text-xs font-bold">
                    {{ $proker->pendaftarans->count() }} Orang
                </span>
            </div>
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 dark:bg-white/5">
                    <tr>
                        <th class="px-6 py-4 font-bold text-slate-600">Nama</th>
                        <th class="px-6 py-4 font-bold text-slate-600">NIA / Status</th>
                        <th class="px-6 py-4 font-bold text-slate-600">Terdaftar</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                    @forelse($proker->pendaftarans as $pendaftar)
                        <tr>
                            <td class="px-6 py-4 font-bold">{{ $pendaftar->nama }}</td>
                            <td class="px-6 py-4">
                                @if($pendaftar->nia)
                                    <span class="font-mono text-xs">{{ $pendaftar->nia }}</span>
                                @else
                                    <span class="text-xs text-amber-600 bg-amber-100 px-2 py-1 rounded">Baru (Belum ada NIA)</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $pendaftar->created_at->format('d M H:i') }}</td>
                            <td class="px-6 py-4 text-right">
                                <button class="text-blue-600 font-bold hover:underline">Detail</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-400">Belum ada pendaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection