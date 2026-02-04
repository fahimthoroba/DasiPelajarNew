<?php

namespace App\Http\Controllers\Sekretariat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Kader;

class KaderController extends Controller
{
    public function index()
    {
        $kader = Kader::latest()->paginate(10);
        return view('dashboard.sekretariat.kader.index', compact('kader'));
    }

    public function create()
    {
        return view('dashboard.sekretariat.kader.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|numeric|unique:kaders,nik',
            'nama_lengkap' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'required',
            'desa' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'foto_path' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('foto_path')) {
            $path = $request->file('foto_path')->store('kader-photos', 'public');
            $validated['foto_path'] = $path;
        }

        Kader::create($validated);

        return redirect()->route('dashboard.sekretariat.kader.index')->with('success', 'Data Kader berhasil ditambahkan.');
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
