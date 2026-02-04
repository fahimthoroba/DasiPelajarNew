<?php

namespace App\Http\Controllers\Sekretariat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SuratKeluar;

class SuratKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $surat_keluar = SuratKeluar::latest('tgl_surat')->paginate(10);
        return view('dashboard.sekretariat.surat-keluar.index', compact('surat_keluar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $departemens = Departemen::all(); // If needed later
        return view('dashboard.sekretariat.surat-keluar.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_surat' => 'required',
            'tujuan' => 'required',
            'perihal' => 'required',
            'tgl_surat' => 'required|date',
            'file_arsip' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($request->hasFile('file_arsip')) {
            $path = $request->file('file_arsip')->store('surat-keluar', 'public');
            $validated['file_arsip'] = $path;
        }

        $validated['pembuat_id'] = auth()->id();

        SuratKeluar::create($validated);

        return redirect()->route('dashboard.sekretariat.surat-keluar.index')
            ->with('success', 'Surat keluar berhasil dicatat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
