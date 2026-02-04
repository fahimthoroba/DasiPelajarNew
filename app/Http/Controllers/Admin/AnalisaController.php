<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RealisasiProgram;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Departemen;
use App\Models\KategoriProgram;

class AnalisaController extends Controller
{
    public function index()
    {
        // 1. Kartu Statistik Utama
        $totalProgram = RealisasiProgram::count();
        $programTerlaksana = RealisasiProgram::where('status', 'Terlaksana')->count();
        $programBulanIni = RealisasiProgram::whereMonth('tgl_mulai', now()->month)
            ->whereYear('tgl_mulai', now()->year)
            ->count();

        // 2. Grafik Bulanan (Tahun Ini)
        $monthlyStats = RealisasiProgram::select(
            DB::raw('MONTH(tgl_mulai) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('tgl_mulai', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $monthlyStats[$i] ?? 0;
        }

        // 3. Peringkat PAC Teraktif & All PAC List (Data Table)
        // Kita ambil semua PAC dengan count proker mereka
        $allPacs = User::where('role', 'pac')
            ->withCount('realisasiPrograms as proker_count')
            ->with(['realisasiPrograms' => function ($q) {
                $q->latest('tgl_mulai')->limit(1);
            }])
            ->orderByDesc('proker_count')
            ->get()
            ->map(function ($pac) {
                // Add last activity attribute
                $lastProker = $pac->realisasiPrograms->first();
                $pac->last_activity = $lastProker ? $lastProker->tgl_mulai->format('d M Y') : '-';
                $pac->last_activity_raw = $lastProker ? $lastProker->tgl_mulai : null;
                return $pac;
            });

        $top5Pacs = $allPacs->take(5);


        // 4. GAP ANALYSIS: Distribusi per Kategori
        $programsPerKategori = RealisasiProgram::join('kategori_program', 'realisasi_program.kategori_program_id', '=', 'kategori_program.id')
            ->select('kategori_program.nama_kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori_program.nama_kategori', 'kategori_program.id') // Group by ID to be safe
            ->get();
            
        $kategoriLabels = $programsPerKategori->pluck('nama_kategori');
        $kategoriData = $programsPerKategori->pluck('total');
        $kategoriIds = $programsPerKategori->pluck('id');

        // 5. GAP ANALYSIS: Distribusi per Departemen
        // Menggunakan kolom departemen_id langsung di realisasi_program
        $programsPerDepartemen = RealisasiProgram::join('departemens', 'realisasi_program.departemen_id', '=', 'departemens.id')
            ->select('departemens.nama_departemen', DB::raw('count(*) as total'), 'departemens.id')
            ->groupBy('departemens.nama_departemen', 'departemens.id')
            ->get();

        $departemenLabels = $programsPerDepartemen->pluck('nama_departemen');
        $departemenData = $programsPerDepartemen->pluck('total');
        $departemenIds = $programsPerDepartemen->pluck('id');


        // 6. Calendar Heatmap Data (GitHub Style) - Enhanced for Density Analysis
        $year = now()->year;
        $dailyCounts = RealisasiProgram::join('users', 'realisasi_program.pac_id', '=', 'users.id')
            ->select(
                DB::raw('DATE(realisasi_program.tgl_mulai) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('users.role', 'pac')
            ->whereYear('realisasi_program.tgl_mulai', $year)
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Put the rest of heatmap logic here if not replacing whole block...
        // Actually, I can just replace the return statement to include new vars
        // But I need to define them first.
        // Let's replace the block from Gap Analysis to Return.


        // Calculate max density for scaling colors if needed, or use fixed levels
        $maxDaily = empty($dailyCounts) ? 1 : max($dailyCounts);

        $calendarData = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthStart = \Carbon\Carbon::createFromDate($year, $m, 1);
            $monthEnd = $monthStart->copy()->endOfMonth();

            $monthWeeks = [];
            $currentWeek = [];
            
            // Padding
            $startPadding = $monthStart->dayOfWeek;
            for ($i = 0; $i < $startPadding; $i++) {
                $currentWeek[] = ['isValid' => false];
            }

            $currentDate = $monthStart->copy();
            while ($currentDate->lte($monthEnd)) {
                $dateString = $currentDate->format('Y-m-d');
                $count = $dailyCounts[$dateString] ?? 0;

                // Determine Density Level (0-4)
                // 0: Empty
                // 1: 1 Event (Low)
                // 2: 2 Events (Medium)
                // 3: 3-4 Events (High)
                // 4: 5+ Events (Very High - "Bentrok Potensial")
                $level = 0;
                if ($count > 0) $level = 1;
                if ($count >= 2) $level = 2;
                if ($count >= 3) $level = 3;
                if ($count >= 5) $level = 4;

                $currentWeek[] = [
                    'date' => $currentDate->format('d M Y'),
                    'raw_date' => $dateString,
                    'count' => $count,
                    'isValid' => true,
                    'level' => $level
                ];

                if (count($currentWeek) === 7) {
                    $monthWeeks[] = $currentWeek;
                    $currentWeek = [];
                }

                $currentDate->addDay();
            }

            if (count($currentWeek) > 0) {
                while (count($currentWeek) < 7) {
                    $currentWeek[] = ['isValid' => false];
                }
                $monthWeeks[] = $currentWeek;
            }

            $calendarData[$m] = [
                'name' => $monthStart->translatedFormat('M'),
                'weeks' => $monthWeeks
            ];
        }

        return view('dashboard.admin.analisa.index', compact(
            'totalProgram',
            'programBulanIni',
            'chartData',
            'top5Pacs',
            'allPacs',          // New: Full List
            'kategoriLabels',   // New: Gap Analysis
            'kategoriData',     // New: Gap Analysis
            'kategoriIds',      // New: Interactivity
            'departemenLabels', // New: Gap Analysis
            'departemenData',   // New: Gap Analysis
            'departemenIds',    // New: Interactivity
            'calendarData',
            'year'
        ));
    }

    public function programsByDate($date)
    {
        $programs = RealisasiProgram::with(['pac', 'kategori', 'departemen'])
            ->whereDate('tgl_mulai', $date)
            ->orWhereDate('tgl_selesai', $date)
            ->latest('tgl_mulai')
            ->paginate(20);

        $title = "Kegiatan pada " . \Carbon\Carbon::parse($date)->translatedFormat('d F Y');
        
        return view('dashboard.admin.analisa.list', compact('programs', 'title'));
    }

    public function programsByDepartemen($id)
    {
        $departemen = Departemen::findOrFail($id);
        
        // Filter langsung by departemen_id
        $programs = RealisasiProgram::with(['pac', 'kategori', 'departemen'])
            ->where('departemen_id', $id)
            ->latest('tgl_mulai')
            ->paginate(20);

        $title = "Kegiatan Departemen: " . $departemen->nama_departemen;

        return view('dashboard.admin.analisa.list', compact('programs', 'title'));
    }

    public function programsByKategori($id)
    {
        $kategori = KategoriProgram::findOrFail($id);

        $programs = RealisasiProgram::with(['pac', 'kategori', 'departemen'])
            ->where('kategori_program_id', $id)
            ->latest('tgl_mulai')
            ->paginate(20);

        $title = "Kegiatan Kategori: " . $kategori->nama_kategori;

        return view('dashboard.admin.analisa.list', compact('programs', 'title'));
    }

    public function detail($id)
    {
        $pac = User::findOrFail($id);
        
        if ($pac->role !== 'pac') {
            abort(404);
        }

        $totalProker = $pac->realisasiPrograms()->count();
        $prokerTerlaksana = $pac->realisasiPrograms()->where('status', 'Terlaksana')->count();

        $monthlyStats = $pac->realisasiPrograms()
            ->select(
                DB::raw('MONTH(tgl_mulai) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('tgl_mulai', now()->year)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $monthlyStats[$i] ?? 0;
        }

        $programsPerKategori = $pac->realisasiPrograms()
            ->join('kategori_program', 'realisasi_program.kategori_program_id', '=', 'kategori_program.id')
            ->select('kategori_program.nama_kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori_program.nama_kategori')
            ->get();
        
        $kategoriLabels = $programsPerKategori->pluck('nama_kategori');
        $kategoriData = $programsPerKategori->pluck('total');

        // Recent Activity
        $recentProkers = $pac->realisasiPrograms()
            ->with(['kategori', 'departemen'])
            ->latest('tgl_mulai')
            ->take(10)
            ->get();

        return view('dashboard.admin.analisa.show', compact(
            'pac',
            'totalProker',
            'chartData',
            'kategoriLabels',
            'kategoriData',
            'recentProkers'
        ));
    }
}
