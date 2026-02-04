<?php

namespace App\Http\Controllers\Sekretariat;

use App\Http\Controllers\Controller;
use App\Models\Pengurus;
use App\Models\Kader;
use App\Models\Departemen;
use App\Models\SuratKeputusan;
use Illuminate\Http\Request;

class PengurusController extends Controller
{
    public function index()
    {
        // Get structured data (Cabang only for now as requested)
        $pengurus = Pengurus::with(['kader', 'departemenData', 'sk'])
            ->where('tingkatan', 'Cabang')
            ->orderBy('urutan_tampil', 'asc')
            ->get();

        return view('dashboard.sekretariat.pengurus.index', compact('pengurus'));
    }

    public function create()
    {
        $kaders = Kader::orderBy('nama_lengkap')->get();
        $departemens = Departemen::all();
        $sks = SuratKeputusan::where('tgl_selesai', '>', now())->get(); // Only active SKs

        return view('dashboard.sekretariat.pengurus.create', compact('kaders', 'departemens', 'sks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kader_id' => 'required|exists:kaders,id',
            'jabatan' => 'required|string',
            'tingkatan' => 'required|in:Cabang,Anak Cabang,Ranting,Komisariat',
            'nama_tingkatan' => 'required|string',
            'departemen_id' => 'nullable|exists:departemens,id',
            'surat_keputusan_id' => 'required|exists:surat_keputusans,id',
        ]);

        // Auto-calculate Urutan Tampil
        $urutan = 99;
        $j = $request->jabatan;

        $priority = [
            'Ketua' => 1,
            'Wakil Ketua' => 2,
            'Sekretaris' => 3,
            'Wakil Sekretaris' => 4,
            'Bendahara' => 5,
            'Wakil Bendahara' => 6,
            'Koordinator' => 7,
            'Direktur' => 7,
            'Komandan' => 7,
            'Anggota' => 20
        ];

        if (isset($priority[$j])) {
            $urutan = $priority[$j];

            // Special logic for Department Heads so they appear together per department usually
            // but here we just sort by rank first. User asked "for anggota sesuai departemen".
            // If Anggota, we might want to group them.
            if ($j == 'Anggota' && $request->departemen_id) {
                // We add department ID's last digits or just keep it 20. 
                // Creating a sophisticated ordering might be complex solely on ID, 
                // but usually alphabetical by department name is better in the View Query.
                // For now, let's stick to base weight.
                $urutan = 20;
            }
        }

        Pengurus::create([
            'kader_id' => $request->kader_id,
            'surat_keputusan_id' => $request->surat_keputusan_id,
            'tingkatan' => $request->tingkatan,
            'nama_tingkatan' => $request->nama_tingkatan, // Dynamic logic
            'jabatan' => $request->jabatan,
            'departemen' => $request->departemen_id,
            'urutan_tampil' => $urutan,
            'is_active' => true,
        ]);

        return redirect()->route('dashboard.sekretariat.pengurus.index')->with('success', 'Pengurus berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $pengurus = Pengurus::findOrFail($id);
        $pengurus->delete();
        return back()->with('success', 'Data pengurus dihapus.');
    }
}
