<?php

namespace App\Http\Controllers\Pac;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RealisasiProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programs = \App\Models\RealisasiProgram::where('pac_id', auth()->id())
            ->with('kategori')
            ->latest()
            ->paginate(10);

        return view('dashboard.pac.proker.index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = \App\Models\KategoriProgram::where('status_verifikasi', true)
            ->orWhere('dibuat_oleh_pac_id', auth()->id())
            ->orderBy('nama_kategori')
            ->get();

        $departemens = \App\Models\Departemen::orderBy('nama_departemen')->get();

        return view('dashboard.pac.proker.create', compact('kategoris', 'departemens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lokal' => 'required|string|max:255',
            'departemen_id' => 'required_without:kategori_program_id|exists:departemens,id',
            'kategori_program_id' => 'nullable|exists:kategori_program,id',
            'kategori_baru' => 'nullable|string|max:255|required_without:kategori_program_id',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'status' => 'required|in:Rencana,Pasti,Terlaksana',
            'target_peserta' => 'required|array',
            'deskripsi' => 'nullable|string',
        ]);

        $kategoriId = $request->kategori_program_id;

        // Logic Buat Kategori Baru
        if ($request->filled('kategori_baru') && !$kategoriId) {
            $slug = \Illuminate\Support\Str::slug($request->kategori_baru);

            // Cek duplikat slug
            while (\App\Models\KategoriProgram::where('slug', $slug)->exists()) {
                $slug = $slug . '-' . rand(1, 100);
            }

            $kategori = \App\Models\KategoriProgram::create([
                'nama_kategori' => $request->kategori_baru,
                'slug' => $slug,
                'departemen_id' => 'DEP-ORG', // Kategori default ke Organisasi atau bisa dihapus relasinya nanti
                'dibuat_oleh_pac_id' => auth()->id(),
                'status_verifikasi' => true, 
            ]);
            $kategoriId = $kategori->id;
        }

        // Logic Status -> Is Fix
        $isFix = in_array($request->status, ['Pasti', 'Terlaksana']);

        \App\Models\RealisasiProgram::create([
            'pac_id' => auth()->id(),
            'kategori_program_id' => $kategoriId,
            'departemen_id' => $request->departemen_id,
            'nama_lokal' => $request->nama_lokal,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'status' => $request->status,
            'is_fix' => $isFix,
            'target_peserta' => $request->target_peserta,
            'deskripsi' => $request->deskripsi,
        ]);

        $message = 'Program kerja berhasil ditambahkan.';

        if ($request->input('action') === 'create_another') {
            return redirect()->route('dashboard.pac.proker.create')->with('success', $message . ' Silakan tambah lagi.');
        }

        return redirect()->route('dashboard.pac.proker.index')->with('success', $message);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $program = \App\Models\RealisasiProgram::where('pac_id', auth()->id())->findOrFail($id);

        $kategoris = \App\Models\KategoriProgram::where('status_verifikasi', true)
            ->orWhere('dibuat_oleh_pac_id', auth()->id())
            ->orderBy('nama_kategori')
            ->get();

        $departemens = \App\Models\Departemen::orderBy('nama_departemen')->get();

        return view('dashboard.pac.proker.edit', compact('program', 'kategoris', 'departemens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $program = \App\Models\RealisasiProgram::where('pac_id', auth()->id())->findOrFail($id);

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
            'departemen_id' => $request->departemen_id,
            'nama_lokal' => $request->nama_lokal,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'status' => $request->status,
            'is_fix' => $isFix,
            'target_peserta' => $request->target_peserta,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('dashboard.pac.proker.index')->with('success', 'Program kerja berhasil diperbarui.');
    }
    public function destroy(string $id)
    {
        $program = \App\Models\RealisasiProgram::where('pac_id', auth()->id())->findOrFail($id);
        $program->delete();

        return back()->with('success', 'Program kerja berhasil dihapus.');
    }
}
