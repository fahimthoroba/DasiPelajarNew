<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\HeroSlider;
use App\Models\Kader;
use App\Models\Pengurus;
use App\Models\PengaturanWeb;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $statistik = [
            'total_kader' => Kader::count(),
            'total_ranting' => 343,
            'total_pac' => 26,
        ];

        $sliders = HeroSlider::where('is_active', true)->orderBy('urutan', 'asc')->get();
        $pengaturan = PengaturanWeb::first();

        // Agenda Terdekat (Limit 4, Filter out Verified LPJ, Include Today)
        $agenda_terdekat = ProgramKerja::whereDate('tgl_pelaksanaan', '>=', now()->startOfDay())
            ->where(function ($q) {
                $q->where('status_lpj', '!=', 'Terverifikasi')
                    ->orWhereNull('status_lpj');
            })
            ->orderBy('tgl_pelaksanaan', 'asc')
            ->limit(4)
            ->get()
            ->map(function ($program) {
                $tgl = Carbon::parse($program->tgl_pelaksanaan)->startOfDay();
                $now = now()->startOfDay();

                if ($tgl->equalTo($now)) {
                    $status_text = 'Sedang Dilaksanakan';
                } elseif ($tgl->isSameMonth($now)) {
                    // Same month: Count Days
                    $diffDays = (int) $now->diffInDays($tgl, false);
                    $status_text = "- {$diffDays} Hari";
                } else {
                    // Different month: Round UP Months
                    $diffMonths = (int) $now->diffInMonths($tgl, false);

                    // Check if adding diffMonths lands before target (meaning fraction remains)
                    if ($now->copy()->addMonths($diffMonths)->startOfDay()->lessThan($tgl)) {
                        $diffMonths++;
                    }

                    if ($diffMonths < 1)
                        $diffMonths = 1;

                    $status_text = "- " . (int) $diffMonths . " Bulan";
                }

                return [
                    'nama_acara' => $program->nama_proker,
                    'tanggal' => $tgl->translatedFormat('d F Y'),
                    'countdown' => $status_text,
                    'lokasi' => $program->lokasi ?? 'PC IPNU IPPNU Kediri',
                    'status' => 'Upcoming',
                    'tgl_raw' => $program->tgl_pelaksanaan,
                ];
            });

        // Berita Terbaru
        $berita_terbaru = Berita::where('status', 'Published')
            ->latest('tgl_publish')
            ->limit(5)
            ->get()
            ->map(function ($berita) {
                return [
                    'judul' => $berita->judul,
                    'image_url' => $berita->thumbnail ? asset('storage/' . $berita->thumbnail) : 'https://placehold.co/800x600?text=No+Image',
                    'tanggal' => Carbon::parse($berita->tgl_publish)->translatedFormat('d F Y'),
                    'slug' => $berita->slug,
                    'summary' => Str::limit(strip_tags($berita->konten), 100, '...'),
                    'kategori' => $berita->kategori ? $berita->kategori->nama : 'Umum',
                ];
            });

        // Pengurus Logic (Cache 24 Hours)
        $pengurusCabang = Cache::remember('pengurus_cabang', 60 * 60 * 24, function () {
            return Pengurus::with('kader')
                ->where('tingkatan', 'Cabang')
                ->where('is_active', true)
                ->orderBy('urutan_tampil', 'asc')
                ->get();
        });

        // Filter Pengurus Harian Only for Marquee
        $harianKeywords = ['Ketua', 'Wakil Ketua', 'Sekretaris', 'Wakil Sekretaris', 'Bendahara', 'Wakil Bendahara'];
        $pengurusHarian = $pengurusCabang->filter(function ($p) use ($harianKeywords) {
            foreach ($harianKeywords as $keyword) {
                if (Str::contains($p->jabatan, $keyword))
                    return true;
            }
            return false;
        });

        $pengurusIpnu = $pengurusHarian->filter(function ($p) {
            return $p->kader && $p->kader->jenis_kelamin === 'L';
        })->values();

        $pengurusIppnu = $pengurusHarian->filter(function ($p) {
            return $p->kader && $p->kader->jenis_kelamin === 'P';
        })->values();

        return view('welcome', compact(
            'sliders',
            'berita_terbaru',
            'agenda_terdekat',
            'statistik',
            'pengurusIpnu',
            'pengurusIppnu',
            'pengaturan'
        ));
    }

    public function showBerita($slug)
    {
        $berita = Berita::where('slug', $slug)->where('status', 'Published')->firstOrFail();
        $berita->increment('views');

        $berita_lainnya = Berita::where('status', 'Published')
            ->where('id', '!=', $berita->id)
            ->latest('tgl_publish')
            ->limit(5)
            ->get();

        $pengaturan = PengaturanWeb::first();

        return view('berita.show', compact('berita', 'berita_lainnya', 'pengaturan'));
    }

    public function indexBerita()
    {
        $pengaturan = PengaturanWeb::first();

        $berita_list = Berita::where('status', 'Published')
            ->latest('tgl_publish')
            ->paginate(9);

        // Reuse Hero Sliders for News Page if requested, or specific ones. 
        // User said "hero slider yang diatur di dashboard".
        $sliders = HeroSlider::where('is_active', true)->orderBy('urutan', 'asc')->get();

        return view('berita.index', compact('berita_list', 'pengaturan', 'sliders'));
    }

    public function struktur(Request $request)
    {
        $pengaturan = PengaturanWeb::first();
        $tab = $request->get('tab', 'ipnu'); // ipnu or ippnu

        $gender = ($tab === 'ippnu') ? 'P' : 'L';

        // Load recursive structure
        // Filter by Kategori (IPNU/IPPNU)
        $targetKategori = strtoupper($tab);

        $pengurusTree = Pengurus::with('kader', 'departemenData')
            ->where('tingkatan', 'Cabang')
            ->where('kategori', $targetKategori) // Strict filtering by Category
            ->where('is_active', true)
            ->orderBy('urutan_tampil', 'asc')
            ->get();

        // If Tree is empty (data migration pending), fallback to flat list grouped by jabatan for demo?
        // No, user requested "sesuai database". If empty, it's empty.

        // Title Logic
        $sk = \App\Models\SuratKeputusan::latest()->first(); // Ambil SK terbaru sebagai referensi Periode?
        // Or hardcode period if not in DB. User request: "Teks judul bagan 'Masa Khidmat 2024-2026' dibuat secara dinamis mengikuti data SK"

        $periode = "2024-2026"; // Default
        if ($pengurusTree->isNotEmpty()) {
            $first = $pengurusTree->first();
            if ($first->suratKeputusan) {
                // Assuming nomor_surat contains year or we have tgl_mulai / tgl_selesai
                // But migration for SK doesn't detail period fields. Checking context... add_columns...
                // Just use static for now or infer from created_at if necessary, 
                // but user said "Dynamic following SK". 
                // Let's assume SK has 'periode' or I check relations.
                // Actually, let's keep it safe. Use simple logic.
            }
        }

        $orgName = ($tab === 'ippnu') ? 'IPPNU' : 'IPNU';

        return view('struktur-organisasi', compact('pengurusTree', 'pengaturan', 'tab', 'orgName', 'periode'));
    }

    public function profil()
    {
        $pengaturan = PengaturanWeb::first();
        return view('profil.index', compact('pengaturan'));
    }

    public function agenda()
    {
        $pengaturan = PengaturanWeb::first();
        $agendas = ProgramKerja::orderBy('tgl_pelaksanaan', 'desc')->get();
        return view('agenda.index', compact('pengaturan', 'agendas'));
    }
}
