<?php

namespace App\Http\Controllers\Departemen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgramKerja;
use Illuminate\Support\Facades\Auth;

class ProgramKerjaController extends Controller
{
    public function index()
    {
        $deptId = Auth::user()->departemen_id;
        $active_programs = ProgramKerja::where('departemen_id', $deptId)
            ->whereIn('status_pelaksanaan', ['Perencanaan', 'Persiapan', 'Pelaksanaan'])
            ->orderBy('tgl_pelaksanaan', 'asc')
            ->get();

        $completed_programs = ProgramKerja::where('departemen_id', $deptId)
            ->where('status_pelaksanaan', 'Selesai')
            ->latest('tgl_pelaksanaan')
            ->paginate(5);

        return view('dashboard.departemen.proker.index', compact('active_programs', 'completed_programs'));
    }

    public function show($id)
    {
        $proker = ProgramKerja::with(['departemen', 'kepanitiaans', 'absensis'])->findOrFail($id);
        // Authorization check if needed (e.g. only proker's department)
        return view('dashboard.departemen.proker.show', compact('proker'));
    }

    public function updateStatus(Request $request, $id)
    {
        $proker = ProgramKerja::findOrFail($id);

        // Simple logic: If status is 'Selesai', ensure LPJ exists? (Skip for now as requested just to remove dropdown)
        // Actually, user said "Remove dropdown status", implies status automation.
        // But for now, keeping the method for internal logic or manual override if needed.
        // I will focus on the sub-features first.

        $request->validate([
            'status_pelaksanaan' => 'required|in:Perencanaan,Persiapan,Pelaksanaan,Selesai'
        ]);

        $proker->update(['status_pelaksanaan' => $request->status_pelaksanaan]);
        return back()->with('success', 'Status program berhasil diperbarui.');
    }
    // --- Committee (Panitia) ---
    public function indexPanitia($id)
    {
        $proker = ProgramKerja::with('kepanitiaans.kader')->findOrFail($id);
        $kaders = \App\Models\Kader::all();
        return view('dashboard.departemen.proker.panitia', compact('proker', 'kaders'));
    }

    public function storePanitia(Request $request, $id)
    {
        $request->validate([
            'jabatan' => 'required|string',
            'kader_id' => 'nullable|exists:kaders,id',
            'nama_manual' => 'nullable|string|required_without:kader_id',
        ]);

        \App\Models\Kepanitiaan::create([
            'program_kerja_id' => $id,
            'kader_id' => $request->kader_id,
            'nama_manual' => $request->nama_manual,
            'jabatan' => $request->jabatan,
        ]);

        return back()->with('success', 'Panitia berhasil ditambahkan.');
    }

    public function destroyPanitia($id, $panitiaId)
    {
        \App\Models\Kepanitiaan::findOrFail($panitiaId)->delete();
        return back()->with('success', 'Panitia dihapus.');
    }

    // --- Agenda & Absensi (Merged) ---
    public function indexAgenda($id)
    {
        $proker = ProgramKerja::with('absensis')->findOrFail($id);
        return view('dashboard.departemen.proker.agenda', compact('proker'));
    }

    public function storeAgenda(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string',
            'tgl_waktu' => 'required|date',
            'jenis' => 'required|in:rapat,kegiatan',
            'notulensi_path' => 'nullable|file|mimes:pdf,doc,docx|max:3072',
        ]);

        $path = null;
        if ($request->hasFile('notulensi_path')) {
            $path = $request->file('notulensi_path')->store('notulensi', 'public');
        }

        \App\Models\Absensi::create([
            'program_kerja_id' => $id,
            'judul' => $request->judul,
            'jenis' => $request->jenis,
            'tgl_waktu' => $request->tgl_waktu,
            'notulensi_path' => $path,
            'created_by' => auth()->user()->id, // String ID
            'status' => 'buka',
            'kode_akses' => \Illuminate\Support\Str::random(6),
        ]);

        return back()->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function destroyAgenda($id, $agendaId)
    {
        $absensi = \App\Models\Absensi::findOrFail($agendaId);
        $absensi->delete();
        return back()->with('success', 'Agenda dihapus.');
    }

    // --- LPJ Upload ---
    public function updateLpj(Request $request, $id)
    {
        $proker = ProgramKerja::findOrFail($id);
        $request->validate(['lpj_path' => 'required|file|mimes:pdf|max:5120']);

        $path = $request->file('lpj_path')->store('lpj', 'public');

        $proker->update(['lpj_path' => $path]);
        return back()->with('success', 'LPJ berhasil diupload.');
    }

    // --- Registration Setup ---
    public function indexPendaftaran($id)
    {
        $proker = ProgramKerja::findOrFail($id);
        return view('dashboard.departemen.proker.pendaftaran', compact('proker'));
    }

    public function updatePendaftaran(Request $request, $id)
    {
        $proker = ProgramKerja::findOrFail($id);

        $data = [
            'is_public_registration' => $request->has('is_public_registration'),
        ];

        if ($data['is_public_registration'] && !$proker->registration_link_token) {
            $data['registration_link_token'] = \Illuminate\Support\Str::random(32);
        }

        $proker->update($data);
        return back()->with('success', 'Pengaturan pendaftaran diperbarui.');
    }
}
