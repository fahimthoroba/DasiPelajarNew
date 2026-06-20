<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\HeroSlider;
use App\Models\Kader;
use App\Models\KategoriBerita;
use App\Models\KomentarBerita;
use App\Models\Pengurus;
use App\Models\PengaturanWeb;
use App\Models\ProgramKerja;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $statistik = [
            'total_kader'   => Kader::count(),
            'total_pac'     => \App\Models\Organisasi::where('tingkat', 'PAC')->count() ?: 26,
            'total_ranting' => \App\Models\Organisasi::where('tingkat', 'PR')->count()  ?: 343,
            'total_pk'      => \App\Models\Organisasi::where('tingkat', 'PK')->count()  ?: 0,
        ];

        $sliders = HeroSlider::where('is_active', true)->orderBy('urutan', 'asc')->get();
        $pengaturan = Cache::remember('pengaturan_web', 3600, fn() => PengaturanWeb::first());

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
            return $p->kategori === 'IPNU';
        })->values();

        $pengurusIppnu = $pengurusHarian->filter(function ($p) {
            return $p->kategori === 'IPPNU';
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
        $berita = Berita::where('slug', $slug)
            ->where('status', 'Published')
            ->with('kategori', 'tags', 'user')
            ->firstOrFail();
        $berita->increment('views');

        // Sidebar: berita terbaru (sticky)
        $berita_lainnya = Berita::published()
            ->where('id', '!=', $berita->id)
            ->with('kategori')
            ->latest('tgl_publish')
            ->limit(5)
            ->get();

        // Rekomendasi: berita se-kategori (bawah komentar)
        $rekomendasi = Berita::published()
            ->where('id', '!=', $berita->id)
            ->where('kategori_berita_id', $berita->kategori_berita_id)
            ->with('kategori')
            ->latest('tgl_publish')
            ->limit(6)
            ->get();

        // Komentar (approved, top-level + replies)
        $komentars = $berita->komentars()
            ->approved()
            ->topLevel()
            ->with(['replies' => fn($q) => $q->approved()->oldest()])
            ->latest()
            ->get();

        $pengaturan = Cache::remember('pengaturan_web', 3600, fn() => PengaturanWeb::first());

        return view('berita.show', compact(
            'berita', 'berita_lainnya', 'rekomendasi', 'komentars', 'pengaturan'
        ));
    }

    public function storeKomentar(Request $request, $slug)
    {
        $berita = Berita::where('slug', $slug)->where('status', 'Published')->firstOrFail();

        $validated = $request->validate([
            'nama'      => 'required|string|max:100',
            'email'     => 'nullable|email|max:150',
            'konten'    => 'required|string|max:2000',
            'parent_id' => 'nullable|exists:komentar_beritas,id',
        ]);

        $berita->komentars()->create($validated);

        return back()->with('komentar_success', 'Komentar berhasil dikirim dan sedang menunggu moderasi.');
    }

    public function indexBerita(Request $request)
    {
        $pengaturan = Cache::remember('pengaturan_web', 3600, fn() => PengaturanWeb::first());

        // Hero sliders
        $sliders = HeroSlider::where('is_active', true)->orderBy('urutan', 'asc')->get();

        // Headline (max 5 untuk bento utama)
        $headline = Berita::published()->headline()
            ->with('kategori', 'tags')
            ->latest('tgl_publish')
            ->limit(5)
            ->get();

        // Berita per kategori (masing-masing 6 artikel) — satu query, group di PHP
        $kategoris = KategoriBerita::withCount(['beritas' => fn($q) => $q->published()])->get();
        $semua_berita_kategori = Berita::published()
            ->with('kategori', 'tags')
            ->latest('tgl_publish')
            ->get();
        $berita_per_kategori = [];
        foreach ($kategoris as $kat) {
            $berita_per_kategori[$kat->slug ?? Str::slug($kat->nama)] = $semua_berita_kategori
                ->where('kategori_berita_id', $kat->id)
                ->take(6)
                ->values();
        }

        // Berita populer (sidebar, by views)
        $berita_populer = Berita::published()
            ->with('kategori')
            ->orderByDesc('views')
            ->limit(5)
            ->get();

        // Berita terbaru (sidebar)
        $berita_terbaru = Berita::published()
            ->with('kategori')
            ->latest('tgl_publish')
            ->limit(5)
            ->get();

        // Semua berita paginated (bagian bawah)
        $semua_berita = Berita::published()
            ->with('kategori', 'tags')
            ->latest('tgl_publish')
            ->paginate(12);

        // Tags populer
        $tags_populer = Tag::withCount('beritas')
            ->orderByDesc('beritas_count')
            ->limit(15)
            ->get();

        // Banner iklan
        $banners = \App\Models\BannerIklan::where('is_active', true)->get()->keyBy('posisi');

        return view('berita.index', compact(
            'pengaturan', 'sliders', 'headline',
            'kategoris', 'berita_per_kategori',
            'berita_populer', 'berita_terbaru',
            'semua_berita', 'tags_populer', 'banners'
        ));
    }

    public function arsipTag(string $slug)
    {
        $pengaturan = Cache::remember('pengaturan_web', 3600, fn() => PengaturanWeb::first());

        $tag = Tag::where('slug', $slug)->firstOrFail();

        $beritas = $tag->beritas()
            ->published()
            ->with('kategori', 'tags')
            ->latest('tgl_publish')
            ->paginate(12);

        $tags_populer = Tag::withCount('beritas')
            ->orderByDesc('beritas_count')
            ->limit(20)
            ->get();

        return view('berita.arsip-tag', compact('pengaturan', 'tag', 'beritas', 'tags_populer'));
    }

    public function arsipKategori(string $slug)
    {
        $pengaturan = Cache::remember('pengaturan_web', 3600, fn() => PengaturanWeb::first());

        $kategori = KategoriBerita::where('slug', $slug)->firstOrFail();

        $beritas = Berita::where('kategori_berita_id', $kategori->id)
            ->published()
            ->with('kategori')
            ->latest('tgl_publish')
            ->paginate(12);

        $kategoris = KategoriBerita::withCount(['beritas' => fn($q) => $q->published()])
            ->having('beritas_count', '>', 0)
            ->get();

        return view('berita.arsip-kategori', compact('pengaturan', 'kategori', 'beritas', 'kategoris'));
    }

    public function struktur(Request $request)
    {
        $pengaturan = Cache::remember('pengaturan_web', 3600, fn() => PengaturanWeb::first());
        $tab = $request->get('tab', 'ipnu');
        $targetKategori = strtoupper($tab);
        $orgName = ($tab === 'ippnu') ? 'IPPNU' : 'IPNU';

        $allPengurus = Pengurus::with('kader', 'departemenData')
            ->where('tingkatan', 'Cabang')
            ->where('kategori', $targetKategori)
            ->where('is_active', true)
            ->orderBy('urutan_tampil', 'asc')
            ->get();

        $childrenMap = $allPengurus->groupBy('parent_id');
        $getChildren = fn($parentId) => $childrenMap->get($parentId) ?? collect();

        // Ketua (root node)
        $ketua = $allPengurus->first(fn($p) => $p->jabatan === 'Ketua');

        $sekretaris = null;
        $bendahara = null;
        $departemenList = collect();
        $lembagaList = collect();

        if ($ketua) {
            $rootChildren = $getChildren($ketua->id);

            // Sekretaris + Wakil Sekretaris children
            $sekretaris = $rootChildren->first(fn($p) => $p->jabatan === 'Sekretaris');
            if ($sekretaris) {
                $sekretaris->wakilList = $getChildren($sekretaris->id)
                    ->filter(fn($p) => Str::contains($p->jabatan, 'Wakil Sekretaris'))
                    ->sortBy('urutan_tampil')
                    ->values();
            }

            // Bendahara + Wakil Bendahara children
            $bendahara = $rootChildren->first(fn($p) => $p->jabatan === 'Bendahara');
            if ($bendahara) {
                $bendahara->wakilList = $getChildren($bendahara->id)
                    ->filter(fn($p) => Str::contains($p->jabatan, 'Wakil Bendahara'))
                    ->sortBy('urutan_tampil')
                    ->values();
            }

            // Wakil Ketua (departemen heads) — each with Koordinator → Anggota subtree
            $departemenList = $rootChildren
                ->filter(fn($p) => Str::contains($p->jabatan, 'Wakil Ketua'))
                ->sortBy('urutan_tampil')
                ->values()
                ->map(function ($waket) use ($getChildren) {
                    $waketChildren = $getChildren($waket->id);
                    $waket->koordinator = $waketChildren->first(fn($p) => $p->jabatan === 'Koordinator');
                    if ($waket->koordinator) {
                        $waket->koordinator->anggotaList = $getChildren($waket->koordinator->id)
                            ->sortBy('urutan_tampil')->values();
                    }
                    $waket->anggotaLangsung = $waketChildren
                        ->filter(fn($p) => $p->jabatan === 'Anggota')
                        ->sortBy('urutan_tampil')->values();
                    return $waket;
                });

            // Lembaga & Badan heads — filter by departemenData->jenis
            $lembagaList = $rootChildren
                ->filter(fn($p) => $p->departemenData &&
                    in_array($p->departemenData->jenis, ['lembaga', 'badan']))
                ->sortBy('urutan_tampil')
                ->values()
                ->map(function ($head) use ($getChildren) {
                    $head->anggotaList = $getChildren($head->id)
                        ->sortBy('urutan_tampil')->values();
                    return $head;
                });
        }

        // Periode dari SK
        $periode = '2024-2026';
        $sk = \App\Models\SuratKeputusan::latest()->first();
        if ($sk && $sk->tgl_berlaku && $sk->tgl_selesai) {
            $periode = Carbon::parse($sk->tgl_berlaku)->format('Y') . '-' . Carbon::parse($sk->tgl_selesai)->format('Y');
        }

        return view('struktur-organisasi', compact(
            'ketua', 'sekretaris', 'bendahara', 'departemenList', 'lembagaList',
            'pengaturan', 'tab', 'orgName', 'periode'
        ));
    }

    public function profil()
    {
        $pengaturan = Cache::remember('pengaturan_web', 3600, fn() => PengaturanWeb::first());
        return view('profil.index', compact('pengaturan'));
    }

    public function agenda()
    {
        $pengaturan = Cache::remember('pengaturan_web', 3600, fn() => PengaturanWeb::first());
        $agendas = ProgramKerja::orderBy('tgl_pelaksanaan', 'desc')->get();
        return view('agenda.index', compact('pengaturan', 'agendas'));
    }
}
