<?php

namespace App\Http\Controllers\Sekretariat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SuratMasuk;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $surat_masuk = SuratMasuk::latest('tgl_surat')->paginate(10);
        return view('dashboard.sekretariat.surat-masuk.index', compact('surat_masuk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.sekretariat.surat-masuk.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_surat' => 'required',
            'pengirim' => 'required',
            'perihal' => 'required',
            'tgl_surat' => 'required|date',
            'tgl_diterima' => 'required|date',
            'file_scan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'disposisi' => 'nullable',
        ]);

        if ($request->hasFile('file_scan')) {
            $path = $request->file('file_scan')->store('surat-masuk', 'public');
            $validated['file_scan'] = $path;
        }

        SuratMasuk::create($validated);

        return redirect()->route('dashboard.sekretariat.surat-masuk.index')
            ->with('success', 'Surat masuk berhasil dicatat.');
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
