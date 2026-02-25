<?php

namespace App\Http\Controllers\Sekretariat;

use App\Http\Controllers\Controller;
use App\Models\Organisasi;
use App\Models\SuratKeputusan;
use Illuminate\Http\Request;

class OrganisasiController extends Controller
{
    public function index()
    {
        $organisasis = Organisasi::with('parent')->latest()->get();
        $pcs = Organisasi::where('tingkat', 'PC')->get();
        return view('dashboard.sekretariat.organisasi.index', compact('organisasis', 'pcs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tingkat' => 'required|in:PC,PAC,PR,PK',
            'parent_id' => 'nullable|exists:organisasis,id',
            'alamat_sekretariat' => 'nullable|string',
            'zona_wilayah' => 'nullable|string',
        ]);

        Organisasi::create($validated);
        return back()->with('success', 'Organisasi berhasil ditambahkan');
    }

    public function show(Organisasi $organisasi)
    {
        // Load Surat Keputusan milik organisasi ini
        $sks = SuratKeputusan::where('organisasi_id', $organisasi->id)->latest('tgl_berlaku')->get();
        return view('dashboard.sekretariat.organisasi.show', compact('organisasi', 'sks'));
    }

    public function destroy(Organisasi $organisasi)
    {
        $organisasi->delete();
        return back()->with('success', 'Organisasi berhasil dihapus');
    }
}
