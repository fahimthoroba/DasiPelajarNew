<?php

namespace App\Http\Controllers;

use App\Models\FormKegiatan;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FormKegiatanController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $query = FormKegiatan::with(['programKerja', 'organisasi'])->latest();

        if (!in_array($user->role, ['admin', 'sekretaris'])) {
            $query->where('organisasi_id', $user->getActiveOrganisasiId());
        }

        $forms         = $query->paginate(15);
        $totalPeserta  = $forms->getCollection()->sum(fn($f) => $f->peserta()->count());
        $totalAktif    = $forms->getCollection()->where('is_open', true)->count();

        return view('dashboard.form-kegiatan.index', compact('forms', 'totalPeserta', 'totalAktif'));
    }

    public function create(Request $request)
    {
        $proker = null;
        if ($request->has('proker_id')) {
            $proker = ProgramKerja::find($request->proker_id);
        }

        return view('dashboard.form-kegiatan.create', compact('proker'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan'    => 'required|string|max:255',
            'is_open'          => 'nullable',
            'tgl_buka'         => 'nullable|date',
            'tgl_tutup'        => 'nullable|date|after_or_equal:tgl_buka',
            'custom_fields'    => 'nullable|string',
            'program_kerja_id' => 'nullable|string|exists:program_kerjas,id|unique:form_kegiatans,program_kerja_id',
        ]);

        $customFields = [];
        if ($request->filled('custom_fields')) {
            $decoded = json_decode($request->custom_fields, true);
            if (is_array($decoded)) {
                $customFields = $decoded;
            }
        }

        $user  = Auth::user();
        $orgId = $user->getActiveOrganisasiId();

        $form = FormKegiatan::create([
            'nama_kegiatan'    => $request->nama_kegiatan,
            'judul_form'       => $request->judul_form ?: null,
            'organisasi_id'    => $orgId,
            'program_kerja_id' => $request->program_kerja_id ?: null,
            'slug'             => Str::slug($request->nama_kegiatan . '-' . Str::random(5)),
            'is_open'          => $request->has('is_open'),
            'tgl_buka'         => $request->tgl_buka ?: null,
            'tgl_tutup'        => $request->tgl_tutup ?: null,
            'custom_fields'    => $customFields,
            'link_sukses'      => $request->link_sukses ?: null,
        ]);

        // Jika terkait proker, redirect ke proker show
        if ($form->program_kerja_id) {
            return redirect()
                ->route('dashboard.departemen.proker.show', $form->program_kerja_id)
                ->with('success', 'Form pendaftaran berhasil dibuat.');
        }

        return redirect()
            ->route('dashboard.form-kegiatan.show', $form->id)
            ->with('success', 'Form pendaftaran berhasil dibuat.');
    }

    public function show($id)
    {
        $form = FormKegiatan::with(['programKerja', 'organisasi'])->findOrFail($id);
        $this->authorizeAccess($form);

        $pesertas = $form->peserta()->latest()->paginate(20);

        return view('dashboard.form-kegiatan.show', compact('form', 'pesertas'));
    }

    public function edit($id)
    {
        $form = FormKegiatan::with('programKerja')->findOrFail($id);
        $this->authorizeAccess($form);

        return view('dashboard.form-kegiatan.edit', compact('form'));
    }

    public function update(Request $request, $id)
    {
        $form = FormKegiatan::findOrFail($id);
        $this->authorizeAccess($form);

        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'is_open'       => 'nullable',
            'tgl_buka'      => 'nullable|date',
            'tgl_tutup'     => 'nullable|date|after_or_equal:tgl_buka',
            'custom_fields' => 'nullable|string',
        ]);

        $customFields = $form->custom_fields ?? [];
        if ($request->filled('custom_fields')) {
            $decoded = json_decode($request->custom_fields, true);
            if (is_array($decoded)) {
                $customFields = $decoded;
            }
        }

        $form->update([
            'nama_kegiatan' => $request->nama_kegiatan,
            'judul_form'    => $request->judul_form ?: null,
            'is_open'       => $request->has('is_open'),
            'tgl_buka'      => $request->tgl_buka ?: null,
            'tgl_tutup'     => $request->tgl_tutup ?: null,
            'custom_fields' => $customFields,
            'link_sukses'   => $request->link_sukses ?: null,
        ]);

        return back()->with('success', 'Form berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $form = FormKegiatan::findOrFail($id);
        $this->authorizeAccess($form);

        $form->delete();

        return redirect()->route('dashboard.form-kegiatan.index')
            ->with('success', 'Form berhasil dihapus.');
    }

    public function toggleOpen($id)
    {
        $form = FormKegiatan::findOrFail($id);
        $this->authorizeAccess($form);

        $form->update(['is_open' => !$form->is_open]);

        return response()->json(['is_open' => $form->is_open]);
    }

    public function exportExcel($id)
    {
        $form = FormKegiatan::findOrFail($id);
        $this->authorizeAccess($form);

        $pesertas     = $form->peserta()->latest()->get();
        $customFields = $form->custom_fields ?? [];
        $filename     = 'Pendaftar_' . Str::slug($form->nama_kegiatan) . '_' . date('Y-m-d') . '.csv';

        $tempDir = storage_path('app/temp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $tempPath = $tempDir . '/' . $filename;
        $handle   = fopen($tempPath, 'w');
        fwrite($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

        $headerRow = ['No', 'Waktu Daftar', 'Nama Lengkap', 'Jenis Kelamin', 'No WhatsApp', 'Asal Instansi', 'Status'];
        foreach ($customFields as $field) {
            $headerRow[] = $field['label'];
        }
        fputcsv($handle, $headerRow, ';');

        foreach ($pesertas as $index => $peserta) {
            $row = [
                $index + 1,
                $peserta->created_at->format('d/m/Y H:i:s'),
                $peserta->nama_lengkap,
                $peserta->jenis_kelamin,
                $peserta->no_wa,
                $peserta->asal_instansi,
                ucfirst($peserta->status),
            ];
            $customAnswers = $peserta->custom_answers ?? [];
            foreach ($customFields as $field) {
                $row[] = $customAnswers[$field['label']] ?? '-';
            }
            fputcsv($handle, $row, ';');
        }

        fclose($handle);

        return response()->download($tempPath, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ])->deleteFileAfterSend(true);
    }

    public function downloadFiles($id)
    {
        $form = FormKegiatan::findOrFail($id);
        $this->authorizeAccess($form);

        $pesertas     = $form->peserta()->get();
        $customFields = $form->custom_fields ?? [];
        $fileFields   = array_filter($customFields, fn($f) => $f['type'] === 'file');

        if (empty($fileFields)) {
            return back()->with('error', 'Tidak ada field bertipe file pada form ini.');
        }

        $zipFilename = 'Files_' . Str::slug($form->nama_kegiatan) . '_' . date('Y-m-d') . '.zip';
        $tempDir     = storage_path('app/temp');

        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $zipPath = $tempDir . '/' . $zipFilename;
        $zip     = new \ZipArchive();

        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return back()->with('error', 'Gagal membuat file ZIP.');
        }

        $hasFiles = false;
        foreach ($pesertas as $peserta) {
            $customAnswers = $peserta->custom_answers ?? [];
            foreach ($fileFields as $field) {
                $fileUrl = $customAnswers[$field['label']] ?? null;
                if ($fileUrl && str_contains($fileUrl, '/storage/')) {
                    $relativePath = Str::after($fileUrl, '/storage/');
                    $fullPath     = storage_path('app/public/' . $relativePath);
                    if (file_exists($fullPath)) {
                        $ext         = pathinfo($fullPath, PATHINFO_EXTENSION);
                        $zipEntry    = Str::slug($peserta->nama_lengkap) . '_' . Str::slug($field['label']) . '.' . $ext;
                        $zip->addFile($fullPath, $zipEntry);
                        $hasFiles = true;
                    }
                }
            }
        }

        $zip->close();

        if (!$hasFiles) {
            @unlink($zipPath);
            return back()->with('error', 'Tidak ada file yang bisa didownload.');
        }

        return response()->download($zipPath, $zipFilename)->deleteFileAfterSend(true);
    }

    private function authorizeAccess(FormKegiatan $form): void
    {
        $user = Auth::user();
        if (in_array($user->role, ['admin', 'sekretaris'])) return;

        if ($form->organisasi_id !== $user->getActiveOrganisasiId()) {
            abort(403, 'Akses ditolak.');
        }
    }
}
