<?php

namespace App\Http\Controllers\Sekretariat;

use App\Http\Controllers\Controller;
use App\Models\SuratKeputusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratKeputusanController extends Controller
{
    public function index()
    {
        $sks = SuratKeputusan::orderBy('tgl_berlaku', 'desc')->get();
        return view('dashboard.sekretariat.sk.index', compact('sks'));
    }

    public function create()
    {
        return view('dashboard.sekretariat.sk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_sk' => 'required|string|unique:surat_keputusans,nomor_sk',
            'judul_sk' => 'required|string',
            'tgl_berlaku' => 'required|date',
            'tgl_selesai' => 'required|date|after:tgl_berlaku',
            'file_sk' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('file_sk')) {
            $path = $request->file('file_sk')->store('public/sk');
        }

        SuratKeputusan::create([
            'nomor_sk' => $request->nomor_sk,
            'judul_sk' => $request->judul_sk,
            'tgl_berlaku' => $request->tgl_berlaku,
            'tgl_selesai' => $request->tgl_selesai,
            'file_sk_path' => $path,
        ]);

        return redirect()->route('dashboard.sekretariat.sk.index')->with('success', 'Surat Keputusan berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $sk = SuratKeputusan::findOrFail($id);

        if ($sk->file_sk_path) {
            Storage::delete($sk->file_sk_path);
        }

        $sk->delete();
        return back()->with('success', 'Data SK dihapus.');
    }
}
