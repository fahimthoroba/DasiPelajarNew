<?php

namespace App\Http\Controllers\Sekretariat;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kader;
use App\Models\AbsensiRecord;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AbsensiController extends Controller
{
    public function index()
    {
        // General agenda (program_kerja_id is null)
        $agendas = Absensi::whereNull('program_kerja_id')
            ->orderBy('tgl_waktu', 'desc')
            ->get();

        return view('dashboard.sekretariat.absensi.index', compact('agendas'));
    }

    public function create()
    {
        return view('dashboard.sekretariat.absensi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'jenis' => 'required|in:rapat,kegiatan',
            'tgl_waktu' => 'required|date',
            'lokasi' => 'nullable|string',
        ]);

        Absensi::create([
            'judul' => $request->judul,
            'jenis' => $request->jenis,
            'tgl_waktu' => $request->tgl_waktu,
            'lokasi' => $request->lokasi,
            'status' => 'buka',
            'kode_akses' => strtoupper(\Illuminate\Support\Str::random(6)),
            'created_by' => auth()->id(), // Assuming logged in user string ID
            // program_kerja_id is NULL for General Absensi
        ]);

        return redirect()->route('dashboard.sekretariat.absensi.index')->with('success', 'Agenda berhasil dibuat.');
    }

    public function show($id)
    {
        $agenda = Absensi::with('records.kader')->findOrFail($id);

        // Generate QR Code content (URL to attendance form)
        // For now, simple URL. In future, signed URL.
        $qrUrl = route('public.absensi.form', ['code' => $agenda->kode_akses]);

        return view('dashboard.sekretariat.absensi.show', compact('agenda', 'qrUrl'));
    }

    public function destroy($id)
    {
        $agenda = Absensi::findOrFail($id);
        $agenda->delete();
        return back()->with('success', 'Agenda dihapus.');
    }
}
