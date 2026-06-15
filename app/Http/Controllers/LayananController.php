<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Support\Facades\Storage;

class LayananController extends Controller
{
    public function index()
    {
        $kategoris = [
            'Template Surat',
            'Pedoman',
            'Peraturan',
            'Formulir',
            'Doa & Dzikir',
            'Lainnya',
        ];

        $layananPerKategori = Layanan::aktif()
            ->orderBy('kategori')
            ->orderBy('judul')
            ->get()
            ->groupBy('kategori');

        $totalFile     = Layanan::aktif()->count();
        $totalDownload = Layanan::aktif()->sum('jumlah_download');

        return view('layanan.index', compact(
            'layananPerKategori',
            'totalFile',
            'totalDownload',
            'kategoris'
        ));
    }

    public function download($id)
    {
        $layanan = Layanan::aktif()->findOrFail($id);

        if (!Storage::disk('public')->exists($layanan->file_path)) {
            return redirect()->route('layanan')
                ->with('error', 'File "' . $layanan->judul . '" belum tersedia saat ini. Silakan coba lagi nanti.');
        }

        $layanan->increment('jumlah_download');

        $ext      = pathinfo($layanan->file_path, PATHINFO_EXTENSION);
        $filename = $layanan->judul . ($ext ? '.' . $ext : '');

        return Storage::disk('public')->download($layanan->file_path, $filename);
    }
}
