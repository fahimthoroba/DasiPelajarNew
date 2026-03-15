<?php

namespace App\Http\Controllers\Kaderisasi;

use App\Http\Controllers\Controller;
use App\Models\FormKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FormKegiatanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $query = FormKegiatan::with('organisasi')->latest();
        
        if ($user->role !== 'admin') {
            $orgId = $user->getActiveOrganisasiId();
            $query->where('organisasi_id', $orgId);
        }
        
        $forms = $query->paginate(10);
        
        return view('dashboard.kaderisasi.form.index', compact('forms'));
    }

    public function create()
    {
        return view('dashboard.kaderisasi.form.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'is_open' => 'nullable',
            'tgl_buka' => 'nullable|date',
            'tgl_tutup' => 'nullable|date|after_or_equal:tgl_buka',
            'custom_fields' => 'nullable|string',
        ]);
        
        $slug = Str::slug($request->nama_kegiatan . '-' . Str::random(5));
        
        // Decode JSON string from hidden input (Alpine.js JSON.stringify)
        $customFields = [];
        if ($request->filled('custom_fields')) {
            $decoded = json_decode($request->custom_fields, true);
            if (is_array($decoded)) {
                $customFields = $decoded;
            }
        }
        
        $user = Auth::user();
        $orgId = $user->getActiveOrganisasiId();
        
        FormKegiatan::create([
            'nama_kegiatan' => $request->nama_kegiatan,
            'organisasi_id' => $orgId,
            'slug' => $slug,
            'is_open' => $request->has('is_open'),
            'tgl_buka' => $request->tgl_buka,
            'tgl_tutup' => $request->tgl_tutup,
            'custom_fields' => $customFields,
        ]);
        
        return redirect()->route('dashboard.kaderisasi.form.index')->with('success', 'Form Pendaftaran berhasil dibuat.');
    }

    public function show($id)
    {
        $form = FormKegiatan::findOrFail($id);
        $this->authorizeAccess($form);
        
        $pesertas = $form->peserta()->latest()->paginate(20);
        return view('dashboard.kaderisasi.form.show', compact('form', 'pesertas'));
    }

    public function edit($id)
    {
        $form = FormKegiatan::findOrFail($id);
        $this->authorizeAccess($form);
        
        return view('dashboard.kaderisasi.form.edit', compact('form'));
    }

    public function update(Request $request, $id)
    {
        $form = FormKegiatan::findOrFail($id);
        $this->authorizeAccess($form);
        
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'is_open' => 'nullable',
            'tgl_buka' => 'nullable|date',
            'tgl_tutup' => 'nullable|date|after_or_equal:tgl_buka',
            'custom_fields' => 'nullable|string',
        ]);
        
        // Decode JSON string from hidden input (Alpine.js JSON.stringify)
        $customFields = $form->custom_fields ?? [];
        if ($request->filled('custom_fields')) {
            $decoded = json_decode($request->custom_fields, true);
            if (is_array($decoded)) {
                $customFields = $decoded;
            }
        }
        
        $form->update([
            'nama_kegiatan' => $request->nama_kegiatan,
            'is_open' => $request->has('is_open'),
            'tgl_buka' => $request->tgl_buka,
            'tgl_tutup' => $request->tgl_tutup,
            'custom_fields' => $customFields,
        ]);
        
        return redirect()->route('dashboard.kaderisasi.form.index')->with('success', 'Form Pendaftaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $form = FormKegiatan::findOrFail($id);
        $this->authorizeAccess($form);
        
        $form->delete();
        return redirect()->route('dashboard.kaderisasi.form.index')->with('success', 'Form Pendaftaran berhasil dihapus.');
    }

    /**
     * Export all participants to Excel-compatible CSV
     */
    public function exportExcel($id)
    {
        $form = FormKegiatan::findOrFail($id);
        $this->authorizeAccess($form);

        $pesertas = $form->peserta()->latest()->get();
        $customFields = $form->custom_fields ?? [];

        $filename = 'Pendaftar_' . Str::slug($form->nama_kegiatan) . '_' . date('Y-m-d') . '.csv';
        
        // Ensure temp directory exists
        $tempDir = storage_path('app/temp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }
        
        $tempPath = $tempDir . '/' . $filename;
        $handle = fopen($tempPath, 'w');
        
        // UTF-8 BOM for Excel compatibility
        fwrite($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Header row
        $headerRow = ['No', 'Waktu Daftar', 'Nama Lengkap', 'Jenis Kelamin', 'No WhatsApp', 'Asal Instansi/PAC', 'Status'];
        
        // Add custom field headers
        foreach ($customFields as $field) {
            $headerRow[] = $field['label'];
        }
        
        fputcsv($handle, $headerRow, ';'); // Use semicolon separator for Excel compatibility

        // Data rows
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

            // Add custom answers
            $customAnswers = $peserta->custom_answers ?? [];
            foreach ($customFields as $field) {
                $label = $field['label'];
                $value = $customAnswers[$label] ?? '-';
                $row[] = $value;
            }

            fputcsv($handle, $row, ';');
        }

        fclose($handle);

        return response()->download($tempPath, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ])->deleteFileAfterSend(true);
    }

    /**
     * Download all uploaded files as ZIP
     */
    public function downloadFiles($id)
    {
        $form = FormKegiatan::findOrFail($id);
        $this->authorizeAccess($form);

        $pesertas = $form->peserta()->get();
        $customFields = $form->custom_fields ?? [];
        
        // Check if there are any file fields
        $fileFields = array_filter($customFields, fn($f) => $f['type'] === 'file');
        if (empty($fileFields)) {
            return back()->with('error', 'Tidak ada field bertipe file pada form ini.');
        }

        $zipFilename = 'Files_' . Str::slug($form->nama_kegiatan) . '_' . date('Y-m-d') . '.zip';
        $zipPath = storage_path('app/temp/' . $zipFilename);
        
        // Ensure temp directory exists
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return back()->with('error', 'Gagal membuat file ZIP.');
        }

        $hasFiles = false;
        foreach ($pesertas as $peserta) {
            $customAnswers = $peserta->custom_answers ?? [];
            
            foreach ($fileFields as $field) {
                $label = $field['label'];
                $fileUrl = $customAnswers[$label] ?? null;
                
                if ($fileUrl && str_contains($fileUrl, '/storage/')) {
                    // Extract relative path from URL
                    $relativePath = Str::after($fileUrl, '/storage/');
                    $fullPath = storage_path('app/public/' . $relativePath);
                    
                    if (file_exists($fullPath)) {
                        $ext = pathinfo($fullPath, PATHINFO_EXTENSION);
                        $zipEntryName = Str::slug($peserta->nama_lengkap) . '_' . Str::slug($label) . '.' . $ext;
                        $zip->addFile($fullPath, $zipEntryName);
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
    
    private function authorizeAccess(FormKegiatan $form)
    {
        $user = Auth::user();
        if ($user->role === 'admin') return;
        
        if ($form->organisasi_id !== $user->getActiveOrganisasiId()) {
            abort(403, 'Unauthorized access to this form.');
        }
    }
}

