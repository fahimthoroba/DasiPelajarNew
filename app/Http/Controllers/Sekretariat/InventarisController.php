<?php

namespace App\Http\Controllers\Sekretariat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Inventaris;

class InventarisController extends Controller
{
    public function index()
    {
        $inventaris = Inventaris::latest()->paginate(10);
        return view('dashboard.sekretariat.inventaris.index', compact('inventaris'));
    }

    public function create()
    {
        return view('dashboard.sekretariat.inventaris.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kode_barang' => 'required',
            'kondisi' => 'required',
            'tgl_pengadaan' => 'required|date',
            'lokasi' => 'required'
        ]);

        Inventaris::create($request->all());

        return redirect()->route('dashboard.sekretariat.inventaris.index')->with('success', 'Data Inventaris berhasil ditambahkan.');
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
