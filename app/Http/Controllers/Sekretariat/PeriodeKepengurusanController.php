<?php

namespace App\Http\Controllers\Sekretariat;

use App\Http\Controllers\Controller;
use App\Models\Organisasi;
use App\Models\PeriodeKepengurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeriodeKepengurusanController extends Controller
{
    public function index()
    {
        $organisasis = Organisasi::orderBy('nama')->get();

        $aktif = PeriodeKepengurusan::where('is_active', true)
            ->get()
            ->groupBy('organisasi_id');

        $riwayat = PeriodeKepengurusan::with('organisasi')
            ->orderByDesc('created_at')
            ->get();

        return view('dashboard.sekretariat.master-data.periode', compact('organisasis', 'aktif', 'riwayat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'organisasi_id' => 'required|exists:organisasis,id',
            'jenis_organisasi' => 'required|in:IPNU,IPPNU',
            'periode_ke' => 'required|integer|min:1',
            'tgl_mulai' => 'nullable|date',
            'tgl_selesai' => 'nullable|date',
        ]);

        DB::transaction(function () use ($request) {
            // Aktifkan periode baru → otomatis nonaktifkan periode lama,
            // SCOPED per (organisasi_id, jenis_organisasi) — tidak menyentuh organisasi/jenis lain
            PeriodeKepengurusan::where('organisasi_id', $request->organisasi_id)
                ->where('jenis_organisasi', $request->jenis_organisasi)
                ->update(['is_active' => false]);

            PeriodeKepengurusan::create([
                'organisasi_id' => $request->organisasi_id,
                'jenis_organisasi' => $request->jenis_organisasi,
                'periode_ke' => $request->periode_ke,
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_selesai' => $request->tgl_selesai,
                'is_active' => true,
            ]);
        });

        return back()->with('success', 'Periode kepengurusan berhasil disimpan.');
    }
}
