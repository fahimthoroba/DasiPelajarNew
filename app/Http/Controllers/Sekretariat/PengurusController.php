<?php

namespace App\Http\Controllers\Sekretariat;

use App\Http\Controllers\Controller;
use App\Models\Pengurus;
use App\Models\Kader;
use App\Models\Departemen;
use App\Models\SuratKeputusan;
use App\Models\Organisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PengurusController extends Controller
{
    public function index(Request $request)
    {
        // Require Organisasi Context or fallback
        $organisasi_id = $request->organisasi_id;
        $sk_id = $request->sk_id;

        // Default to first PC if no context provided
        if (!$organisasi_id) {
            $defaultOrg = Organisasi::where('tingkat', 'PC')->first();
            if ($defaultOrg) {
                 return redirect()->route('dashboard.sekretariat.organisasi.show', $defaultOrg->id)->with('error', 'Pilih SK terlebih dahulu untuk mengedit struktur.');
            }
            return redirect()->route('dashboard.sekretariat.organisasi.index')->with('error', 'Pilih Organisasi terlebih dahulu.');
        }

        $organisasi = Organisasi::findOrFail($organisasi_id);
        $sk_aktif = $sk_id ? SuratKeputusan::findOrFail($sk_id) : SuratKeputusan::where('organisasi_id', $organisasi->id)->latest('tgl_berlaku')->first();

        // Get structured data for this specific Organization AND SK
        $pengurus = Pengurus::with(['kader', 'departemenData', 'sk'])
            ->where('organisasi_id', $organisasi->id)
            ->when($sk_aktif, function($query) use ($sk_aktif) {
                 return $query->where('surat_keputusan_id', $sk_aktif->id);
            })
            ->orderBy('urutan_tampil', 'asc')
            ->get();
            
        // Data for Dropdowns
        $kaders = Kader::orderBy('nama_lengkap')->get();
        // Use ID ordering or Name for now to prevent SQL error on missing column
        $departemens = Departemen::orderBy('id')->get();
        if (Schema::hasColumn('departemens', 'urutan_tampil')) {
             $departemens = Departemen::orderBy('urutan_tampil')->get();
        }
        
        $sks = SuratKeputusan::where('organisasi_id', $organisasi->id)->get();

        return view('dashboard.sekretariat.pengurus.index', compact('pengurus', 'kaders', 'departemens', 'sks', 'organisasi', 'sk_aktif'));
    }

    public function bulkStore(Request $request)
    {
        // Validate basic structure
        $request->validate([
            'organisasi_id' => 'required|exists:organisasis,id',
            'sk_id' => 'required|exists:surat_keputusans,id',
            'pengurus' => 'array',
        ]);

        $skId = $request->sk_id;
        $orgId = $request->organisasi_id;
        $organisasi = Organisasi::findOrFail($orgId);
        $tingkatan = $organisasi->tingkat; // PC, PAC, PR, PK
        
        \DB::transaction(function () use ($request, $skId, $orgId, $tingkatan, $organisasi) {
            // We need to save items in a specific order to establish parent_id relationships.
            // Map to store saved IDs: key (from form) => database_id
            $savedIds = [];
            
            // 1. Prepare Data Buckets
            $bucketRoot = [];       // Ketua
            $bucketExec = [];       // Sek, Ben, Waket (Dept Head)
            $bucketMid = [];        // Koord, Dept Wasek, Dept Waben
            $bucketMembers = [];    // Anggota
            
            foreach ($request->pengurus as $key => $value) {
                // Parse Key: 
                // ipnu_ketua (Root)
                // ipnu_sek (Exec)
                // dept_1_ipnu_waket (Exec - Dept Head)
                // dept_1_ipnu_koord (Mid - Reports to Waket)
                // dept_1_ipnu_anggota (Array of Members - Reports to Koord or Waket)
                
                $data = $value;
                $data['_key'] = $key; // Keep track of original key
                
                // Identify Role/Level
                if (str_contains($key, 'ketua') && !str_contains($key, 'waket') && !str_contains($key, 'dept')) {
                    $bucketRoot[] = $data;
                } elseif (str_contains($key, 'sek') && !str_contains($key, 'dept')) {
                     $bucketExec[] = $data; // Main Sek
                } elseif (str_contains($key, 'ben') && !str_contains($key, 'dept')) {
                     $bucketExec[] = $data; // Main Ben
                } elseif (str_contains($key, 'waket') || str_contains($key, 'komandan') || str_contains($key, 'direktur')) {
                     $bucketExec[] = $data; // Dept Head (labeled waket in key usually)
                } elseif (str_contains($key, 'koord')) {
                     $bucketMid[] = $data;
                } elseif (str_contains($key, 'wasek') || str_contains($key, 'waben')) {
                     $bucketMid[] = $data; // Dept Staff
                } elseif (str_contains($key, 'anggota')) {
                     // Handle array input for anggota
                     if (is_array($value)) {
                         foreach ($value as $idx => $item) {
                             $item['_key'] = $key; // e.g. dept_1_ipnu_anggota
                             $item['_idx'] = $idx;
                             $bucketMembers[] = $item;
                         }
                     }
                }
            }
            
            // Helper function to process items
            $processItem = function($item, $parentMap) use ($skId, $tingkatan, $organisasi, &$savedIds) {
                $nama = $item['kader_nama'] ?? null;
               
                // Delete if ID exists but name empty
                if (isset($item['id']) && empty($nama)) {
                    $pengurus = Pengurus::find($item['id']);
                    if ($pengurus) {
                        // Optionally remove linked user if needed, but safer to just delete pengurus
                        $pengurus->delete();
                    }
                    return null;
                }
                
                if (empty($nama)) return null;

                // Create/Find Kader
                $kader = Kader::firstOrCreate(
                    ['nama_lengkap' => $nama],
                    ['nik' => rand(100000, 999999)] // Placeholder NIK if new
                );

                // Auto Generate User Account if HP and DOB are provided
                $phone = $item['phone'] ?? null;
                $dob = $item['dob'] ?? null;
                $userId = null;

                if (!empty($phone) && !empty($dob)) {
                    // Cek apakah No HP (sebagai email/username) sudah ada
                    $existingUser = \App\Models\User::where('email', $phone)->first();
                    
                    if (!$existingUser) {
                        // Format DOB to Y-m-d if it comes from html date input, use as password
                        // Or if it comes as d-m-Y, strip dashes. Using raw $dob as password for simplicity:
                        $password = \Illuminate\Support\Facades\Hash::make(str_replace('-', '', $dob));

                        // Tentukan Role Sistem berdasarkan Tingkat Organisasi
                        $roleMap = [
                            'PC' => 'pc',
                            'PAC' => 'pac',
                            'PR' => 'pr',
                            'PK' => 'pk'
                        ];
                        $userRole = $roleMap[$organisasi->tingkat] ?? 'departemen';

                        $newUser = \App\Models\User::create([
                            'name' => $nama,
                            'email' => $phone, // Menggunakan NoHP sebagai pengganti Email
                            'password' => $password,
                            'role' => $userRole,
                            'organisasi_id' => $organisasi->id,
                        ]);

                        // Tautkan User ID ke Kader
                        $kader->user_id = $newUser->id;
                        $kader->no_hp = $phone;
                        $kader->tanggal_lahir = $dob;
                        $kader->save();
                    }
                }

                // Determine Category
                $kategori = $item['kategori'] ?? 'IPNU';
                $namaTingkatan = $organisasi->tingkat . ' ' . $kategori . ' ' . $organisasi->nama; // e.g. PAC IPNU Ngasem

                // Determine Parent ID based on Logic
                $parentId = null;
                $key = $item['_key'] ?? '';
                
                // Logic for Parent ID
                if (str_contains($key, 'sek') && !str_contains($key, 'dept')) {
                    // Main Sek -> Parent: Ketua of same Category
                    $parentId = $savedIds[strtolower($kategori) . '_ketua'] ?? null;
                } elseif (str_contains($key, 'ben') && !str_contains($key, 'dept')) {
                    // Main Ben -> Parent: Ketua
                    $parentId = $savedIds[strtolower($kategori) . '_ketua'] ?? null;
                } elseif (str_contains($key, 'waket') && str_contains($key, 'dept')) {
                    // Dept Head -> Parent: Ketua
                    $parentId = $savedIds[strtolower($kategori) . '_ketua'] ?? null;
                } elseif (str_contains($key, 'koord')) {
                    // Koord -> Parent: Dept Head (Waket)
                    // Key format: dept_{id}_{cat}_koord
                    $parts = explode('_', $key); // [dept, id, cat, koord]
                    if(count($parts) >= 3) {
                         $deptKey = "dept_{$parts[1]}_{$parts[2]}_waket";
                         $parentId = $savedIds[$deptKey] ?? null;
                    }
                } elseif (str_contains($key, 'wasek') && str_contains($key, 'dept')) {
                    // Dept Wakil Sekretaris -> Parent: Main Sekretaris
                    $mainSekKey = strtolower($kategori) . '_sek';
                    $parentId = $savedIds[$mainSekKey] ?? null;
                } elseif (str_contains($key, 'waben') && str_contains($key, 'dept')) {
                    // Dept Wakil Bendahara -> Parent: Main Bendahara
                    $mainBenKey = strtolower($kategori) . '_ben';
                    $parentId = $savedIds[$mainBenKey] ?? null;
                } elseif (str_contains($key, 'anggota')) {
                    // Anggota -> Parent: Koord (if exists) ELSE Dept Head
                    $parts = explode('_', $key);
                    if(count($parts) >= 3) {
                         $koordKey = "dept_{$parts[1]}_{$parts[2]}_koord";
                         $headKey = "dept_{$parts[1]}_{$parts[2]}_waket";
                         
                         $parentId = $savedIds[$koordKey] ?? $savedIds[$headKey] ?? null;
                    }
                }

                $data = [
                    'kader_id' => $kader->id,
                    'organisasi_id' => $organisasi->id,
                    'surat_keputusan_id' => $skId,
                    'tingkatan' => $tingkatan,
                    'nama_tingkatan' => $namaTingkatan,
                    'kategori' => $kategori, 
                    'jabatan' => $item['jabatan'],
                    'departemen_id' => $item['departemen_id'] ?? null,
                    'parent_id' => $parentId,
                    'urutan_tampil' => $item['urutan_tampil'] ?? 99,
                    'is_active' => true,
                ];

                if (isset($item['id'])) {
                    Pengurus::where('id', $item['id'])->update($data);
                    $objId = $item['id'];
                } else {
                    $obj = Pengurus::create($data);
                    $objId = $obj->id;
                }
                
                // Store ID in map
                $savedIds[$key] = $objId;
                return $objId;
            };

            // EXECUTE PASSES
            // 1. Root (Ketua)
            foreach ($bucketRoot as $item) $processItem($item, $savedIds);
            
            // 2. Exec (Sek, Ben, Dept Heads)
            foreach ($bucketExec as $item) $processItem($item, $savedIds);
            
            // 3. Mid (Koord, Dept Staff)
            foreach ($bucketMid as $item) $processItem($item, $savedIds);
            
            // 4. Members
            // Add sequential ordering for members?
            $memberCounters = []; // key -> count
            foreach ($bucketMembers as $item) {
                 $k = $item['_key'];
                 if (!isset($memberCounters[$k])) $memberCounters[$k] = 1;
                 $item['urutan_tampil'] = $memberCounters[$k]++;
                 $processItem($item, $savedIds);
            }
        });

        return redirect()->back()->with('success', 'Struktur Pengurus berhasil diperbarui dengan Hierarki Otomatis.');
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
