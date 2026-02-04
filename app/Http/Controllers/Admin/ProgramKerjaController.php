<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\KategoriProgram;
use App\Models\RealisasiProgram;
use App\Models\User;
use Illuminate\Http\Request;

class ProgramKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = RealisasiProgram::with(['pac', 'kategori', 'departemen']);

        // Filter by PAC
        if ($request->filled('pac_id')) {
            $query->where('pac_id', $request->pac_id);
        }

        // Search by Name
        if ($request->filled('search')) {
            $query->where('nama_lokal', 'like', '%' . $request->search . '%');
        }

        $programs = $query->latest()->paginate(10)->withQueryString();

        // List of PAC users for filter dropdown
        $pacs = User::where('role', 'pac')->orderBy('name')->get();

        return view('dashboard.admin.proker.index', compact('programs', 'pacs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Admin can edit ANY program (no where 'pac_id' check)
        $program = RealisasiProgram::findOrFail($id);

        $kategoris = KategoriProgram::where('status_verifikasi', true)
            ->orWhere('dibuat_oleh_pac_id', $program->pac_id) // Allow category created by the program owner
            ->orderBy('nama_kategori')
            ->get();

        $departemens = Departemen::orderBy('nama_departemen')->get();

        return view('dashboard.admin.proker.edit', compact('program', 'kategoris', 'departemens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $program = RealisasiProgram::findOrFail($id);

        $request->validate([
            'nama_lokal' => 'required|string|max:255',
            'departemen_id' => 'nullable|exists:departemens,id',
            'kategori_program_id' => 'required|exists:kategori_program,id',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'status' => 'required|in:Rencana,Pasti,Terlaksana',
            'target_peserta' => 'required|array',
            'deskripsi' => 'nullable|string',
        ]);

        // Logic Status -> Is Fix
        $isFix = in_array($request->status, ['Pasti', 'Terlaksana']);

        $program->update([
            'kategori_program_id' => $request->kategori_program_id,
            'nama_lokal' => $request->nama_lokal,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'status' => $request->status,
            'is_fix' => $isFix,
            'target_peserta' => $request->target_peserta,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('dashboard.admin.proker.index')->with('success', 'Program kerja berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $program = RealisasiProgram::findOrFail($id);
        $program->delete();

        return back()->with('success', 'Program kerja berhasil dihapus.');
    }
}
