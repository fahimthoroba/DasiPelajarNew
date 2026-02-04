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
    public function index(Request $request)
    {
        // 0. Filter Tahun (Default: Tahun Ini)
        $year = $request->input('year', now()->year);
        
        // Ambil semua tahun yang ada di database untuk dropdown
        $availableYears = RealisasiProgram::selectRaw('YEAR(tgl_mulai) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        // Jika tahun berjalan belum ada di DB (misal awal tahun belum ada proker), tetap munculkan
        if (!in_array(now()->year, $availableYears)) {
            array_unshift($availableYears, now()->year);
        }

        // 1. Kartu Statistik Utama
        $totalProgram = RealisasiProgram::count(); // Total seumur hidup
        $programTerlaksana = RealisasiProgram::where('status', 'Terlaksana')->count();
        $programBulanIni = RealisasiProgram::whereMonth('tgl_mulai', now()->month)
            ->whereYear('tgl_mulai', now()->year) // Tetap bulan ini di tahun berjalan (real-time)
            ->count();

        // 2. Grafik Bulanan (Sesuai Tahun Dipilih)
        $monthlyStats = RealisasiProgram::select(
            DB::raw('MONTH(tgl_mulai) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('tgl_mulai', $year) // Updated filter
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $monthlyStats[$i] ?? 0;
        }

        // 3. Peringkat PAC (Global / All Time) - Bisa diubah jika mau per tahun
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


        // 4. GAP ANALYSIS: Distribusi per Kategori (Global/All Time - atau mau per tahun?)
        // Biasanya Gap Analysis itu "Potret Saat Ini" atau "Total Kinerja". 
        // Untuk Heatmap yang spesifik per tahun, kita biarkan ini Global dulu atau filter $year juga?
        // User request spesifik Heatmap, tapi grafik bulanan pasti ikut tahun.
        // Mari kita buat Gap Analysis juga ikut Tahun agar sinkron.
        $programsPerKategori = RealisasiProgram::join('kategori_program', 'realisasi_program.kategori_program_id', '=', 'kategori_program.id')
            ->whereYear('realisasi_program.tgl_mulai', $year) // Added filter
            ->select('kategori_program.nama_kategori', DB::raw('count(*) as total'), 'kategori_program.id as cat_id')
            ->groupBy('kategori_program.nama_kategori', 'kategori_program.id')
            ->get();
            
        $kategoriLabels = $programsPerKategori->pluck('nama_kategori');
        $kategoriData = $programsPerKategori->pluck('total');
        $kategoriIds = $programsPerKategori->pluck('cat_id');

        // 5. GAP ANALYSIS: Distribusi per Departemen
        $programsPerDepartemen = RealisasiProgram::join('departemens', 'realisasi_program.departemen_id', '=', 'departemens.id')
            ->whereYear('realisasi_program.tgl_mulai', $year) // Added filter
            ->select('departemens.nama_departemen', DB::raw('count(*) as total'), 'departemens.id as dept_id')
            ->groupBy('departemens.nama_departemen', 'departemens.id')
            ->orderBy('total', 'asc')
            ->get();

        $departemenLabels = $programsPerDepartemen->pluck('nama_departemen');
        $departemenData = $programsPerDepartemen->pluck('total');
        $departemenIds = $programsPerDepartemen->pluck('dept_id');

        // 7. GAP ANALYSIS: Kategori Baru (1-5)
        $programsPerNewCat = RealisasiProgram::whereYear('tgl_mulai', $year)
            ->select('id_kategori_baru', DB::raw('count(*) as total'))
            ->groupBy('id_kategori_baru')
            ->get();

        $newCatMapping = [
            1 => 'Kaderisasi & Pengembangan SDM',
            2 => 'Organisasi & Administrasi',
            3 => 'Keagamaan & Sosial',
            4 => 'Minat Bakat & Kreativitas',
            5 => 'Peringatan & Apresiasi'
        ];

        $newCatLabels = [];
        $newCatData = [];
        $newCatIds = [];

        // Ensure all 5 categories are present even if 0
        foreach ($newCatMapping as $id => $label) {
            $count = $programsPerNewCat->where('id_kategori_baru', $id)->first()->total ?? 0;
            $newCatLabels[] = $label;
            $newCatData[] = $count;
            $newCatIds[] = $id;
        }


        // 6. Calendar Heatmap Data (GitHub Style) - Filtered by Year
        $dailyCounts = RealisasiProgram::join('users', 'realisasi_program.pac_id', '=', 'users.id')
            ->select(
                DB::raw('DATE(realisasi_program.tgl_mulai) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('users.role', 'pac')
            ->whereYear('realisasi_program.tgl_mulai', $year) // Updated filter
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

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
            'allPacs',
            'kategoriLabels',
            'kategoriData',
            'kategoriIds',
            'newCatLabels',     // New: New Cat Analysis
            'newCatData',       // New: New Cat Analysis
            'newCatIds',        // New: New Cat Analysis
            'departemenLabels',
            'departemenData',
            'departemenIds',
            'calendarData',
            'year',
            'availableYears'    // New Param
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

    public function programsByKategoriBaru($id)
    {
        $mapping = [
            1 => 'Kaderisasi & Pengembangan SDM',
            2 => 'Organisasi & Administrasi',
            3 => 'Keagamaan & Sosial',
            4 => 'Minat Bakat & Kreativitas',
            5 => 'Peringatan & Apresiasi'
        ];

        $namaKategori = $mapping[$id] ?? 'Kategori Tidak Dikenal';

        $programs = RealisasiProgram::with(['pac', 'kategori', 'departemen'])
            ->where('id_kategori_baru', $id)
            ->latest('tgl_mulai')
            ->paginate(20);

        $title = "Kegiatan Jenis: " . $namaKategori;

        return view('dashboard.admin.analisa.list', compact('programs', 'title'));
    }

    public function detail(Request $request, $id)
{
    $pac = User::findOrFail($id);
    
    if ($pac->role !== 'pac') {
        abort(404);
    }

    // Year Filter
    $availableYears = RealisasiProgram::selectRaw('YEAR(tgl_mulai) as year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year')
        ->toArray();

    // Add current year if empty or not present (optional)
    if (empty($availableYears)) {
        $availableYears = [now()->year];
    }
    
    $year = $request->input('year', now()->year);

    // Filter Stats based on Year? 
    // Usually 'Total Program' is all time, but 'Tren Bulanan' is specific year.
    // Let's make Monthly Stats year-specific.
    // OPTIONAL: Filter Total Program by year too? 
    // User asked "Tren keaktifan bulanan... bisa dipilih tahun".
    // I will keep Total Proker and Recent Activity as "All Time" (or maybe Recent is just recent).
    // But definitely filter Monthly Stats by $year.

    $totalProker = $pac->realisasiPrograms()->count(); // All time
    // $prokerTerlaksana = $pac->realisasiPrograms()->where('status', 'Terlaksana')->count(); // Unused variable?

    $monthlyStats = $pac->realisasiPrograms()
        ->select(
            DB::raw('MONTH(tgl_mulai) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->whereYear('tgl_mulai', $year) // Filter by Selected Year
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
        ->whereYear('realisasi_program.tgl_mulai', $year) // Make category chart also year-specific? User didn't explicitly ask, but it makes sense for "Analysis". Let's stick to Monthly Chart for now or do both? Usually dashboard is "Yearly View". I'll filter Category by Year too for consistency.
        ->get();
    
    $kategoriLabels = $programsPerKategori->pluck('nama_kategori');
    $kategoriData = $programsPerKategori->pluck('total');

    // Recent Activity (Keep it truly recent/latest, regardless of year filter? Or filter by year? "Recent" usually means latest. I'll keep it latest all time.)
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
        'recentProkers',
        'availableYears',
        'year'
    ));
}
}
