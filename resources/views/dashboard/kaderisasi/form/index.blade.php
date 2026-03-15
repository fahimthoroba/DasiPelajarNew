@extends('layouts.dashboard')

@section('title', 'Form Pendaftaran Kegiatan')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Form Kegiatan</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Kelola pendaftaran form untuk event yang akan diselenggarakan.</p>
        </div>
        <a href="{{ route('dashboard.kaderisasi.form.create') }}"
            class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-5 rounded-xl transition-colors shadow-lg shadow-emerald-500/30">
            <span class="material-symbols-outlined">add_circle</span>
            Buat Form
        </a>
    </div>

    @if(session('success'))
        <div
            class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 font-medium flex items-center gap-3 border border-emerald-100 dark:border-emerald-800">
            <span class="material-symbols-outlined">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-white/5 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr
                        class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 uppercase tracking-wider font-bold">
                        <th class="px-6 py-4">Nama Kegiatan</th>
                        <th class="px-6 py-4">URL Form Publik</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Pendaftar</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse($forms as $form)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $form->nama_kegiatan }}
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $form->organisasi->nama ?? 'Tanpa Instansi' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-blue-600 dark:text-blue-400">
                                <a href="{{ url('/form/' . $form->slug) }}" target="_blank" class="hover:underline flex items-center gap-1">
                                    {{ url('/form/' . $form->slug) }}
                                    <span class="material-symbols-outlined text-xs">open_in_new</span>
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                @if($form->is_open)
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-600">
                                        Dibuka
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-600">
                                        Ditutup
                                    </span>
                                @endif
                                
                                @if($form->tgl_buka || $form->tgl_tutup)
                                    <div class="text-[10px] text-gray-500 mt-1">
                                        {{ $form->tgl_buka ? $form->tgl_buka->format('d/m/Y') : '' }} - {{ $form->tgl_tutup ? $form->tgl_tutup->format('d/m/Y') : 'Selamanya' }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('dashboard.kaderisasi.form.show', $form->id) }}" class="inline-flex items-center gap-2 px-3 py-1 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-lg text-emerald-600 font-bold transition-colors">
                                    <span class="material-symbols-outlined text-sm">group</span>
                                    {{ $form->peserta()->count() }} Orang
                                </a>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Edit Configuration -->
                                    <a href="{{ route('dashboard.kaderisasi.form.edit', $form->id) }}"
                                        class="p-2 rounded-lg text-gray-400 hover:bg-emerald-50 hover:text-emerald-600 transition-colors"
                                        title="Konfigurasi Form">
                                        <span class="material-symbols-outlined">settings</span>
                                    </a>

                                    <!-- Delete Form -->
                                    <form action="{{ route('dashboard.kaderisasi.form.destroy', $form->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus link form ini? Data peserta juga akan terhapus!');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 rounded-lg text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors"
                                            title="Hapus">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <div
                                    class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 mb-3">
                                    <span class="material-symbols-outlined text-2xl">how_to_reg</span>
                                </div>
                                <p>Belum ada form pendaftaran yang dibuat.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($forms->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-white/5">
                {{ $forms->links() }}
            </div>
        @endif
    </div>
@endsection
