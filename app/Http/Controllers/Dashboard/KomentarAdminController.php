<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\KomentarBerita;

class KomentarAdminController extends Controller
{
    public function index()
    {
        $komentars = KomentarBerita::where('is_approved', false)
            ->with('berita')
            ->latest()
            ->paginate(20);

        return view('dashboard.berita.komentar.index', compact('komentars'));
    }

    public function approve(KomentarBerita $komentar)
    {
        $komentar->update(['is_approved' => true]);

        return redirect()
            ->route('dashboard.berita.komentar.index')
            ->with('success', "Komentar dari \"{$komentar->nama}\" disetujui.");
    }

    public function reject(KomentarBerita $komentar)
    {
        $nama = $komentar->nama;
        $komentar->delete();

        return redirect()
            ->route('dashboard.berita.komentar.index')
            ->with('success', "Komentar dari \"{$nama}\" dihapus.");
    }
}
