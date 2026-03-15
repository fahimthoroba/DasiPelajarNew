<?php

namespace App\Http\Controllers\Layanan;

use App\Http\Controllers\Controller;
use App\Models\FormKegiatan;
use App\Models\PesertaKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormPendaftaranController extends Controller
{
    public function show($slug)
    {
        $form = FormKegiatan::where('slug', $slug)
            ->with('organisasi')
            ->firstOrFail();

        // Check if form is open
        if (!$form->is_open) {
            return view('layanan.form_closed', compact('form', 'slug'))->with('reason', 'Form pendaftaran telah ditutup oleh panitia.');
        }

        if ($form->tgl_buka && now() < $form->tgl_buka) {
            return view('layanan.form_closed', compact('form', 'slug'))->with('reason', 'Pendaftaran belum dibuka. Silahkan kembali pada ' . $form->tgl_buka->format('d/m/Y H:i'));
        }

        if ($form->tgl_tutup && now() > $form->tgl_tutup) {
            return view('layanan.form_closed', compact('form', 'slug'))->with('reason', 'Waktu pendaftaran telah berakhir pada ' . $form->tgl_tutup->format('d/m/Y H:i'));
        }

        // Generate view
        return view('layanan.form_pendaftaran', compact('form'));
    }

    public function submit(Request $request, $slug)
    {
        $form = FormKegiatan::where('slug', $slug)->firstOrFail();

        // Check again to prevent sneaky posts
        if (!$form->is_open || ($form->tgl_buka && now() < $form->tgl_buka) || ($form->tgl_tutup && now() > $form->tgl_tutup)) {
            return back()->with('error', 'Pendaftaran saat ini tidak dapat dilakukan.');
        }

        // Build validation rules dynamically based on custom_fields
        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'no_wa' => 'required|string|max:20',
            'asal_instansi' => 'required|string|max:255',
        ];

        $customFields = $form->custom_fields ?? [];
        
        foreach ($customFields as $index => $field) {
            $fieldName = 'custom_' . $index;
            $fieldRules = [];
            
            if (!empty($field['required'])) {
                $fieldRules[] = 'required';
            } else {
                $fieldRules[] = 'nullable';
            }

            if ($field['type'] == 'file') {
                $fieldRules[] = 'file';
                $fieldRules[] = 'max:5120'; // 5MB limit
            } elseif ($field['type'] == 'number') {
                $fieldRules[] = 'numeric';
            } else {
                $fieldRules[] = 'string';
            }
            
            $rules[$fieldName] = implode('|', $fieldRules);
        }

        $validated = $request->validate($rules);
        
        // Handle answers processing and file uploads
        $customAnswers = [];
        foreach ($customFields as $index => $field) {
            $fieldName = 'custom_' . $index;
            
            if ($request->has($fieldName) && $field['type'] != 'file') {
                $customAnswers[$field['label']] = $request->input($fieldName);
            } elseif ($request->hasFile($fieldName)) {
                $path = $request->file($fieldName)->store('pendaftaran_files', 'public');
                $customAnswers[$field['label']] = asset('storage/' . $path);
            }
        }

        // Try to associate with logged in user if available
        $userId = Auth::check() ? Auth::id() : null;

        PesertaKegiatan::create([
            'form_kegiatan_id' => $form->id,
            'user_id' => $userId,
            'nama_lengkap' => $validated['nama_lengkap'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'no_wa' => $validated['no_wa'],
            'asal_instansi' => $validated['asal_instansi'],
            'custom_answers' => $customAnswers,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Berhasil mendaftar! Terima kasih atas partisipasi Anda.');
    }
}
