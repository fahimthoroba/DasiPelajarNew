<?php

namespace App\Http\Controllers\Sekretariat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgramKerja;
use App\Models\Departemen;
use Illuminate\Support\Facades\Auth;

class ProgramKerjaController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'semua');

        $query = ProgramKerja::with('departemen')->latest('tgl_pelaksanaan');

        if ($tab === 'menunggu_verifikasi') {
            $query->where('current_step', 6);
        }

        $program_kerja = $query->paginate(10);

        $countMenunggu = ProgramKerja::where('current_step', 6)->count();

        return view('dashboard.sekretariat.proker.index', compact('program_kerja', 'tab', 'countMenunggu'));
    }

    public function create()
    {
        $departemens = Departemen::all();
        return view('dashboard.sekretariat.proker.create', compact('departemens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_proker' => 'required',
            'departemen_id' => 'required|exists:departemens,id',
            'tgl_pelaksanaan' => 'required|date',
            'penanggung_jawab' => 'nullable',
        ]);

        ProgramKerja::create([
            'nama_proker' => $request->nama_proker,
            'departemen_id' => $request->departemen_id,
            'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
            'penanggung_jawab' => $request->penanggung_jawab,
            'status_pelaksanaan' => 'Perencanaan',
            'current_step' => 1,
        ]);

        return redirect()->route('dashboard.sekretariat.proker.index')
            ->with('success', 'Program Kerja berhasil diinput dan dilimpahkan ke Departemen terkait.');
    }

    public function show($id)
    {
        $proker = ProgramKerja::with(['departemen', 'kepanitiaans.kader', 'absensis', 'lpjRevisions'])->findOrFail($id);
        return view('dashboard.sekretariat.proker.show', compact('proker'));
    }

    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:terima,tolak',
            'lpj_catatan' => 'required_if:action,tolak|nullable|string'
        ]);

        $proker = ProgramKerja::findOrFail($id);
        $latestRevision = $proker->lpjRevisions()->first();

        if ($request->action === 'terima') {
            $latestRevision?->update([
                'status' => 'diterima',
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
            ]);

            $proker->update([
                'status_pelaksanaan' => 'Selesai',
                'verified_by' => Auth::id(),
                'verified_at' => now(),
            ]);
            return redirect()->route('dashboard.sekretariat.proker.index', ['tab' => 'menunggu_verifikasi'])->with('success', 'LPJ berhasil diverifikasi. Program Kerja Selesai.');
        } else {
            $latestRevision?->update([
                'status' => 'ditolak',
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
                'catatan' => $request->lpj_catatan,
            ]);

            // Tolak — reset step & status, kirim catatan
            $proker->update([
                'current_step'       => 5,
                'status_pelaksanaan' => 'Pelaksanaan',
                'lpj_catatan'        => $request->lpj_catatan,
                'verified_by'        => null,
                'verified_at'        => null,
            ]);
            return redirect()->route('dashboard.sekretariat.proker.index', ['tab' => 'menunggu_verifikasi'])->with('error', 'LPJ ditolak. Catatan perbaikan telah dikirim ke Departemen.');
        }
    }
}
