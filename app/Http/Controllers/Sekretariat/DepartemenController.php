<?php

namespace App\Http\Controllers\Sekretariat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Departemen;
use App\Models\ProgramKerja;

class DepartemenController extends Controller
{
    public function index()
    {
        // Fetch Program Kerja instead of Departemen
        $program_kerja = ProgramKerja::with('departemen')->latest('tgl_pelaksanaan')->paginate(10);
        return view('dashboard.sekretariat.departemen.index', compact('program_kerja'));
    }

    public function create()
    {
        // Dropdown for Departemen
        $departemens = Departemen::all();
        return view('dashboard.sekretariat.departemen.create', compact('departemens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_proker' => 'required',
            'departemen_id' => 'required|exists:departemens,id',
            'tgl_pelaksanaan' => 'required|date',
            'penanggung_jawab' => 'nullable',
        ]);

        ProgramKerja::create($request->all());

        return redirect()->route('dashboard.sekretariat.departemen.index')
            ->with('success', 'Program Kerja berhasil ditambahkan.');
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
