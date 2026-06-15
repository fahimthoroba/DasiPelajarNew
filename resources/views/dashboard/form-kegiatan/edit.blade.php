@extends('layouts.dashboard')

@section('title', 'Edit Form: ' . $form->nama_kegiatan)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Back --}}
    <a href="{{ route('dashboard.form-kegiatan.show', $form->id) }}"
       class="inline-flex items-center gap-1.5 text-sm font-bold transition-colors"
       style="color: var(--dp-bg-primary)">
        <span class="material-symbols-outlined text-lg">arrow_back</span>
        Kembali ke Detail Form
    </a>

    <div>
        <h1 class="text-2xl font-bold font-display" style="color: var(--dp-text-primary)">Edit Form Pendaftaran</h1>
        <p class="text-sm mt-1" style="color: var(--dp-text-secondary)">{{ $form->nama_kegiatan }}</p>
    </div>

    @if($form->programKerja)
    <div class="flex items-center gap-3 p-4 rounded-2xl"
         style="background: var(--dp-primary-tint); border: 1px solid var(--dp-border);">
        <span class="material-symbols-outlined text-xl" style="color: var(--dp-bg-primary)">event_note</span>
        <div>
            <p class="text-xs font-bold uppercase tracking-widest" style="color: var(--dp-text-secondary)">Terkait Program Kerja</p>
            <p class="font-bold text-sm" style="color: var(--dp-bg-primary)">{{ $form->programKerja->nama_proker }}</p>
        </div>
    </div>
    @endif

    <form action="{{ route('dashboard.form-kegiatan.update', $form->id) }}"
          method="POST"
          x-data="prokerFormBuilder({{ json_encode($form->custom_fields ?? []) }})"
          class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Informasi Dasar --}}
        <div class="p-6 rounded-2xl space-y-4" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
            <h2 class="font-bold" style="color: var(--dp-text-primary)">Informasi Dasar</h2>

            <div>
                <label class="block text-xs font-bold mb-1.5" style="color: var(--dp-text-secondary)">
                    Nama Kegiatan <span style="color: var(--dp-danger)">*</span>
                </label>
                <input type="text" name="nama_kegiatan" required
                       value="{{ old('nama_kegiatan', $form->nama_kegiatan) }}"
                       class="w-full px-4 py-2.5 rounded-xl text-sm"
                       style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
                <p class="text-[10px] mt-1" style="color: var(--dp-text-secondary)">Nama internal kegiatan, dipakai sebagai identitas di dashboard.</p>
            </div>

            <div>
                <label class="block text-xs font-bold mb-1.5" style="color: var(--dp-text-secondary)">
                    Judul Form (Publik)
                </label>
                <input type="text" name="judul_form"
                       value="{{ old('judul_form', $form->judul_form) }}"
                       placeholder="Contoh: Daftar Sekarang — Makesta 2026 Kab. Kediri"
                       class="w-full px-4 py-2.5 rounded-xl text-sm"
                       style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
                <p class="text-[10px] mt-1" style="color: var(--dp-text-secondary)">Judul yang ditampilkan di halaman form publik. Kosong = pakai Nama Kegiatan.</p>
            </div>

            <div>
                <label class="block text-xs font-bold mb-1.5" style="color: var(--dp-text-secondary)">
                    Link Setelah Daftar
                </label>
                <input type="url" name="link_sukses"
                       value="{{ old('link_sukses', $form->link_sukses) }}"
                       placeholder="https://chat.whatsapp.com/..."
                       class="w-full px-4 py-2.5 rounded-xl text-sm"
                       style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
                <p class="text-[10px] mt-1" style="color: var(--dp-text-secondary)">Opsional. Jika diisi, tombol akan muncul di halaman sukses pendaftaran (misal: link grup WhatsApp).</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold mb-1.5" style="color: var(--dp-text-secondary)">Dibuka Mulai</label>
                    <input type="datetime-local" name="tgl_buka"
                           value="{{ $form->tgl_buka ? $form->tgl_buka->format('Y-m-d\TH:i') : '' }}"
                           class="w-full px-4 py-2.5 rounded-xl text-sm"
                           style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
                </div>
                <div>
                    <label class="block text-xs font-bold mb-1.5" style="color: var(--dp-text-secondary)">Ditutup Pada</label>
                    <input type="datetime-local" name="tgl_tutup"
                           value="{{ $form->tgl_tutup ? $form->tgl_tutup->format('Y-m-d\TH:i') : '' }}"
                           class="w-full px-4 py-2.5 rounded-xl text-sm"
                           style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
                </div>
            </div>

            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_open" value="1" {{ $form->is_open ? 'checked' : '' }}
                       class="w-4 h-4 rounded accent-[#08332c]">
                <span class="text-sm font-bold" style="color: var(--dp-text-primary)">Form sedang buka</span>
            </label>
        </div>

        {{-- Field Standar (read-only preview) --}}
        <div class="p-6 rounded-2xl space-y-3" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
            <div>
                <h2 class="font-bold" style="color: var(--dp-text-primary)">Field Standar</h2>
                <p class="text-xs mt-1" style="color: var(--dp-text-secondary)">
                    Field berikut selalu ada di setiap form dan tidak bisa dihapus.
                </p>
            </div>
            @foreach([
                ['icon' => 'badge',       'label' => 'Nama Lengkap',   'type' => 'Teks Pendek',   'required' => true],
                ['icon' => 'wc',          'label' => 'Jenis Kelamin',  'type' => 'Pilihan Ganda', 'required' => true],
                ['icon' => 'smartphone',  'label' => 'Nomor HP / WA',  'type' => 'Teks Pendek',   'required' => true],
                ['icon' => 'home_pin',    'label' => 'Asal Instansi',  'type' => 'Teks Pendek',   'required' => true],
            ] as $sf)
            <div class="flex items-center justify-between px-4 py-3 rounded-xl"
                 style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border);">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-base" style="color: var(--dp-text-secondary)">{{ $sf['icon'] }}</span>
                    <span class="text-sm font-semibold" style="color: var(--dp-text-primary)">{{ $sf['label'] }}</span>
                    <span class="text-[10px]" style="color: var(--dp-text-secondary)">{{ $sf['type'] }}</span>
                </div>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded"
                      style="background: var(--dp-primary-tint); color: var(--dp-bg-primary)">Wajib</span>
            </div>
            @endforeach
        </div>

        {{-- Custom Fields --}}
        <div class="p-6 rounded-2xl space-y-4" style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
            <div>
                <h2 class="font-bold" style="color: var(--dp-text-primary)">Pertanyaan Tambahan</h2>
                <p class="text-xs mt-1" style="color: var(--dp-text-secondary)">
                    Tambahkan pertanyaan khusus di luar field standar di atas.
                </p>
            </div>

            <input type="hidden" name="custom_fields" x-bind:value="JSON.stringify(fields)">

            <div class="space-y-3">
                <template x-for="(field, index) in fields" :key="index">
                    <div class="relative p-4 rounded-xl"
                         style="background: var(--dp-bg-surface-2); border: 1px solid var(--dp-border);">
                        <button type="button" @click="removeField(index)"
                                class="absolute top-3 right-3 w-7 h-7 rounded-full flex items-center justify-center"
                                style="background: var(--dp-danger-tint); color: var(--dp-danger)">
                            <span class="material-symbols-outlined text-sm">close</span>
                        </button>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pr-10">
                            <div class="sm:col-span-2">
                                <label class="block text-[10px] font-bold mb-1" style="color: var(--dp-text-secondary)">Label Pertanyaan</label>
                                <input x-model="field.label" type="text" placeholder="Contoh: Ukuran Kaos" required
                                       class="w-full px-3 py-2 rounded-lg text-sm"
                                       style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold mb-1" style="color: var(--dp-text-secondary)">Tipe</label>
                                <select x-model="field.type"
                                        class="w-full px-3 py-2 rounded-lg text-sm"
                                        style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
                                    <option value="text">Teks Pendek</option>
                                    <option value="textarea">Teks Panjang</option>
                                    <option value="number">Angka</option>
                                    <option value="select">Pilihan Ganda</option>
                                    <option value="file">Upload File</option>
                                </select>
                            </div>
                            <div class="flex items-center">
                                <label class="flex items-center gap-2 cursor-pointer" @click="field.required = !field.required">
                                    <div class="w-9 h-5 rounded-full transition-colors relative shrink-0"
                                         :style="field.required ? 'background: var(--dp-bg-primary)' : 'background: var(--dp-border-strong)'">
                                        <div class="absolute top-0.5 w-4 h-4 rounded-full bg-white transition-transform shadow"
                                             :class="field.required ? 'translate-x-4' : 'translate-x-0.5'"></div>
                                    </div>
                                    <span class="text-xs font-bold" style="color: var(--dp-text-secondary)"
                                          x-text="field.required ? 'Wajib diisi' : 'Opsional'">Opsional</span>
                                </label>
                            </div>
                            <div class="sm:col-span-2" x-show="field.type === 'select'" x-transition>
                                <label class="block text-[10px] font-bold mb-1" style="color: var(--dp-text-secondary)">Pilihan (pisahkan koma)</label>
                                <input x-model="field.options" type="text" placeholder="Pilihan A, Pilihan B"
                                       class="w-full px-3 py-2 rounded-lg text-sm"
                                       style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <button type="button" @click="addField"
                    class="w-full py-3 rounded-xl text-sm font-bold flex items-center justify-center gap-2"
                    style="border: 2px dashed var(--dp-border); color: var(--dp-text-secondary);">
                <span class="material-symbols-outlined text-base">add</span>
                Tambah Pertanyaan
            </button>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('dashboard.form-kegiatan.show', $form->id) }}"
               class="flex-1 py-3 rounded-xl text-sm font-bold text-center"
               style="background: var(--dp-bg-surface-2); color: var(--dp-text-secondary); border: 1px solid var(--dp-border)">
                Batal
            </a>
            <button type="submit"
                    class="flex-1 py-3 rounded-xl text-sm font-bold"
                    style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary)">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function prokerFormBuilder(initialFields) {
    return {
        fields: initialFields.map(f => ({
            label: f.label || '',
            type: f.type || 'text',
            required: f.required || false,
            options: Array.isArray(f.options) ? f.options.join(', ') : (f.options || ''),
        })),
        addField() {
            this.fields.push({ label: '', type: 'text', required: false, options: '' });
        },
        removeField(index) {
            this.fields.splice(index, 1);
        },
    };
}
</script>
@endpush

@endsection
