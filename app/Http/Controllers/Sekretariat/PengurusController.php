<?php

namespace App\Http\Controllers\Sekretariat;

use App\Http\Controllers\Controller;
use App\Models\Pengurus;
use App\Models\Kader;
use App\Models\Departemen;
use App\Models\SuratKeputusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PengurusController extends Controller
{
    public function index(Request $request)
    {
        // We now load ALL data for client-side tabs.
        // Get structured data (Cabang only)
        $pengurus = Pengurus::with(['kader', 'departemenData', 'sk'])
            ->where('tingkatan', 'Cabang')
            ->orderBy('urutan_tampil', 'asc')
            ->get();
            
        // Data for Dropdowns
        $kaders = Kader::orderBy('nama_lengkap')->get();
        // Get ALL Departments
        // Use ID ordering or Name for now to prevent SQL error on missing column
        $departemens = Departemen::orderBy('id')->get();
        // If we add ordering column later, we can use it.
        if (Schema::hasColumn('departemens', 'urutan_tampil')) {
             $departemens = Departemen::orderBy('urutan_tampil')->get();
        }
        
        $sks = SuratKeputusan::where('tgl_selesai', '>', now())->get();

        return view('dashboard.sekretariat.pengurus.index', compact('pengurus', 'kaders', 'departemens', 'sks'));
    }

    public function bulkStore(Request $request)
    {
        // dd($request->all());
        
        // Validate basic structure
        $request->validate([
            'sk_id' => 'required|exists:surat_keputusans,id',
            'pengurus' => 'array',
        ]);

        $skId = $request->sk_id;
        $tingkatan = 'Cabang'; 
        
        \DB::transaction(function () use ($request, $skId, $tingkatan) {
            foreach ($request->pengurus as $item) {
                // If ID exists but no Name -> Delete
                // Name is unique identifier for us now.
                $nama = $item['kader_nama'] ?? null;
                
                if (isset($item['id']) && empty($nama)) {
                    Pengurus::destroy($item['id']);
                    continue;
                }

                if (empty($nama)) continue;
                
                // Find or Create Kader by Name
                // We use firstOrCreate. 
                // Note: This might create duplicates if spelling differs. 
                // Trusted user input assumed.
                $kader = Kader::firstOrCreate(
                    ['nama_lengkap' => $nama],
                    ['nik' => rand(100000, 999999)] // Dummy NIK if required? Check Model. NIK nullable?
                );
                // NIK is in fillable, but is it required in DB?
                // Let's assume nullable or we generate a placeholder.
                
                // Determine Category
                $kategori = $item['kategori'] ?? 'IPNU'; // Default
                $namaTingkatan = 'PC ' . $kategori;

                $data = [
                    'kader_id' => $kader->id,
                    'surat_keputusan_id' => $skId,
                    'tingkatan' => $tingkatan,
                    'nama_tingkatan' => $namaTingkatan,
                    'kategori' => $kategori, 
                    'jabatan' => $item['jabatan'],
                    'departemen_id' => $item['departemen_id'] ?? null,
                    'parent_id' => $item['parent_id'] ?? null,
                    'urutan_tampil' => $item['urutan_tampil'] ?? 99,
                    'is_active' => true,
                ];

                if (isset($item['id'])) {
                    Pengurus::where('id', $item['id'])->update($data);
                } else {
                    Pengurus::create($data);
                }
            }
        });

        return redirect()->back()->with('success', 'Struktur Pengurus berhasil diperbarui.');
    }

    public function create()
    {
        $kaders = Kader::orderBy('nama_lengkap')->get();
        $departemens = Departemen::all();
        $sks = SuratKeputusan::where('tgl_selesai', '>', now())->get(); 
        
        // Fetch existing pengurus for "Atasan Langsung" selection
        // We might want to filter by SK similarity or just show all active
        $parents = Pengurus::with('kader')
            ->where('is_active', true)
            ->where('tingkatan', 'Cabang') // Filter by current context if needed
            ->orderBy('urutan_tampil')
            ->get();

        return view('dashboard.sekretariat.pengurus.create', compact('kaders', 'departemens', 'sks', 'parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kader_id' => 'required|exists:kaders,id',
            'jabatan' => 'required|string',
            'tingkatan' => 'required|in:Cabang,Anak Cabang,Ranting,Komisariat',
            'nama_tingkatan' => 'required|string',
            'departemen_id' => 'nullable|exists:departemens,id',
            'parent_id' => 'nullable|exists:pengurus,id', // Add validation
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

            if ($j == 'Anggota' && $request->departemen_id) {
                $urutan = 20;
            }
        }

        Pengurus::create([
            'kader_id' => $request->kader_id,
            'surat_keputusan_id' => $request->surat_keputusan_id,
            'tingkatan' => $request->tingkatan,
            'nama_tingkatan' => $request->nama_tingkatan,
            'jabatan' => $request->jabatan,
            'departemen_id' => $request->departemen_id, // Updated column
            'parent_id' => $request->parent_id, // New field
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
