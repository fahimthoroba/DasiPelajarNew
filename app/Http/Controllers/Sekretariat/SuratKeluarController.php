<?php

namespace App\Http\Controllers\Sekretariat;

use App\Http\Controllers\Controller;
use App\Models\NomorSuratCounter;
use App\Models\NomorSuratDibatalkan;
use App\Models\NomorSuratKepanitiaanCounter;
use App\Models\Organisasi;
use App\Models\PeriodeKepengurusan;
use App\Models\ProgramKerja;
use App\Models\SuratKeluar;
use App\Services\NomorSuratGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SuratKeluarController extends Controller
{
    /**
     * Scope VIEW (lihat): Sekretaris/admin lihat SEMUA surat (termasuk semua buku agenda
     * kepanitiaan, untuk monitoring). Koordinator Departemen/Lembaga/Badan (role dep_, lmb_, bdn_):
     * HANYA surat kepanitiaan milik proker departemen mereka sendiri — tidak boleh lihat buku agenda utama.
     */
    private function scopeView($query)
    {
        $user = Auth::user();

        if (in_array($user->role, ['admin', 'sekretaris'], true)) {
            return $query;
        }

        return $this->scopeKepanitiaanDepartemen($query, $user);
    }

    /**
     * Scope WRITE (edit/batalkan/hapus): Sekretaris/admin HANYA boleh tulis ke buku agenda
     * utama (reguler/bersama) — TIDAK BOLEH sentuh surat kepanitiaan siapapun, sekalipun bisa
     * melihatnya (read-only murni untuk monitoring, bukan override akses ke domain departemen).
     * Koordinator Departemen/Lembaga/Badan: CRUD penuh tapi tetap di-scope ke departemen sendiri.
     */
    private function scopeWrite($query)
    {
        $user = Auth::user();

        if (in_array($user->role, ['admin', 'sekretaris'], true)) {
            return $query->whereIn('jenis_surat', ['reguler', 'bersama']);
        }

        return $this->scopeKepanitiaanDepartemen($query, $user);
    }

    private function scopeKepanitiaanDepartemen($query, $user)
    {
        return $query->whereIn('jenis_surat', ['kepanitiaan', 'kepanitiaan_bersama'])
            ->whereHas('programKerja', function ($q) use ($user) {
                $q->where('departemen_id', $user->departemen_id);
            });
    }

    public function index()
    {
        $surat_keluar = $this->scopeView(SuratKeluar::query())
            ->latest('tgl_surat')
            ->paginate(10);

        $writableIds = $this->scopeWrite(SuratKeluar::query())->pluck('id')->all();

        return view('dashboard.sekretariat.surat-keluar.index', compact('surat_keluar', 'writableIds'));
    }

    public function create()
    {
        $user = Auth::user();
        abort_unless(
            in_array($user->role, ['admin', 'sekretaris'], true) || !empty($user->departemen_id),
            403,
            'Anda tidak punya akses ke Buku Agenda Surat.'
        );

        $organisasis = Organisasi::orderBy('nama')->get();
        $kodeIndeks = config('nomor_surat.kode_indeks');

        // Sekretaris/admin: lihat SEMUA proker kepanitiaan (WRITE tetap dibatasi ke reguler/bersama
        // di store(), lihat guard di bawah). dep_*/lmb_*/bdn_*: HANYA proker milik departemen sendiri.
        $prokerQuery = ProgramKerja::where('tipe_pelaksanaan', 'kepanitiaan')
            ->whereNotNull('kode_surat_kepanitiaan');

        if (!in_array($user->role, ['admin', 'sekretaris'], true)) {
            $prokerQuery->where('departemen_id', $user->departemen_id);
        }

        $prokerKepanitiaan = $prokerQuery->orderBy('kode_surat_kepanitiaan')->get();

        return view('dashboard.sekretariat.surat-keluar.create', compact('organisasis', 'kodeIndeks', 'prokerKepanitiaan'));
    }

    public function store(Request $request, NomorSuratGenerator $generator)
    {
        $user = Auth::user();
        $isSekretariat = in_array($user->role, ['admin', 'sekretaris'], true);

        abort_unless($isSekretariat || !empty($user->departemen_id), 403, 'Anda tidak punya akses ke Buku Agenda Surat.');

        $request->validate([
            'jenis_surat' => 'required|in:reguler,bersama,kepanitiaan,kepanitiaan_bersama',
            'organisasi_id' => 'required|exists:organisasis,id',
            'tujuan' => 'required|string',
            'perihal' => 'required|string',
            'tgl_surat' => 'required|date',
            'jenis_organisasi' => 'required_if:jenis_surat,reguler,kepanitiaan|nullable|in:IPNU,IPPNU',
            'kode_indeks' => 'required_if:jenis_surat,reguler|nullable|string',
            'program_kerja_id' => 'required_if:jenis_surat,kepanitiaan,kepanitiaan_bersama|nullable|exists:program_kerjas,id',
            'file_arsip' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // GUARD UTAMA: dep_*/lmb_*/bdn_* HANYA boleh jenis_surat kepanitiaan/kepanitiaan_bersama —
        // tidak pernah boleh menulis ke buku agenda utama, sekalipun request dipalsukan langsung.
        if (!$isSekretariat) {
            abort_unless(
                in_array($request->jenis_surat, ['kepanitiaan', 'kepanitiaan_bersama'], true),
                403,
                'Hanya Sekretaris yang bisa menerbitkan surat buku agenda utama.'
            );

            // GUARD KEDUA: program_kerja_id yang dipilih WAJIB milik departemen user sendiri —
            // cegah Departemen A menerbitkan surat atas nama proker Departemen B.
            $proker = ProgramKerja::findOrFail($request->program_kerja_id);
            abort_unless(
                $proker->departemen_id === $user->departemen_id,
                403,
                'Program kerja yang dipilih bukan milik departemen Anda.'
            );
        }

        $org = Organisasi::findOrFail($request->organisasi_id);
        $tgl = \Carbon\Carbon::parse($request->tgl_surat);

        $params = [
            'organisasi_id' => $org->id,
            'jenis_surat' => $request->jenis_surat,
            'jenis_organisasi' => $request->jenis_organisasi,
            'kode_indeks' => $request->kode_indeks,
            'program_kerja_id' => $request->program_kerja_id,
            'tingkat' => $org->tingkat,
            'bulan' => $tgl->month,
            'tahun' => $tgl->year,
        ];

        $data = [
            'organisasi_id' => $org->id,
            'jenis_surat' => $request->jenis_surat,
            'jenis_organisasi' => $request->jenis_organisasi,
            'kode_indeks' => $request->kode_indeks,
            'program_kerja_id' => $request->program_kerja_id,
            'tujuan' => $request->tujuan,
            'perihal' => $request->perihal,
            'tgl_surat' => $request->tgl_surat,
            'pembuat_id' => Auth::id(),
            'status_arsip' => 'nomor_terbit',
        ];

        if ($request->jenis_surat === 'bersama') {
            $hasil = $generator->generateBersama($params);
            $data['no_surat'] = $hasil['baris_ipnu'] . "\n" . $hasil['baris_ippnu'];
            $data['nomor_urut'] = $hasil['nomor_ipnu'];
            $data['nomor_urut_pasangan'] = $hasil['nomor_ippnu'];
        } else {
            $hasil = $generator->generate($params);
            $data['no_surat'] = $hasil['no_surat'];
            $data['nomor_urut'] = $hasil['nomor_urut'];

            if (in_array($request->jenis_surat, ['kepanitiaan', 'kepanitiaan_bersama'], true)) {
                $proker = ProgramKerja::find($request->program_kerja_id);
                $data['nama_kepanitiaan'] = $proker?->kode_surat_kepanitiaan;
            }
        }

        if ($request->hasFile('file_arsip')) {
            $data['file_arsip'] = $request->file('file_arsip')->store('surat-keluar', 'public');
            $data['status_arsip'] = 'lengkap';
        }

        SuratKeluar::create($data);

        return redirect()->route('dashboard.sekretariat.surat-keluar.index')
            ->with('success', 'Surat keluar berhasil dibuat dan nomor diterbitkan.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $surat = $this->scopeWrite(SuratKeluar::query())->findOrFail($id);

        return view('dashboard.sekretariat.surat-keluar.edit', compact('surat'));
    }

    public function update(Request $request, string $id)
    {
        $surat = $this->scopeWrite(SuratKeluar::query())->findOrFail($id);

        $request->validate([
            'file_arsip' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $path = $request->file('file_arsip')->store('surat-keluar', 'public');

        // Upload file_arsip TIDAK mengubah nomor_urut/no_surat — murni tambah file,
        // status berubah otomatis jadi 'lengkap' (Fase 2 alur 2-fase)
        $surat->update([
            'file_arsip' => $path,
            'status_arsip' => 'lengkap',
        ]);

        return redirect()->route('dashboard.sekretariat.surat-keluar.index')
            ->with('success', 'Arsip surat berhasil diupload.');
    }

    public function destroy(string $id)
    {
        $surat = $this->scopeWrite(SuratKeluar::query())->findOrFail($id);
        $surat->delete();

        return back()->with('success', 'Surat keluar dihapus.');
    }

    /**
     * Batalkan surat (bukan hapus — tetap ada untuk audit trail). Memicu freelist:
     * nomor yang dibebaskan akan "ketarik" otomatis di generate surat berikutnya
     * yang scope-nya sama, via NomorSuratGenerator::nextNomor().
     */
    public function batalkan(Request $request, string $id)
    {
        $surat = $this->scopeWrite(SuratKeluar::query())->findOrFail($id);

        $request->validate(['alasan' => 'required|string|max:255']);

        DB::transaction(function () use ($surat, $request) {
            $surat->update(['status' => 'dibatalkan']);

            if ($surat->jenis_surat === 'bersama') {
                // Surat Bersama punya 2 nomor (IPNU+IPPNU) — insert 2 row freelist, atomic
                $this->insertFreelist($surat, 'IPNU', $surat->nomor_urut);
                $this->insertFreelist($surat, 'IPPNU', $surat->nomor_urut_pasangan);
            } else {
                $jenisOrganisasiCounter = $surat->jenis_surat === 'kepanitiaan_bersama'
                    ? 'Bersama'
                    : $surat->jenis_organisasi;
                $this->insertFreelist($surat, $jenisOrganisasiCounter, $surat->nomor_urut);
            }
        });

        return back()->with('success', 'Surat dibatalkan. Nomor akan dipakai ulang di surat berikutnya.');
    }

    private function insertFreelist(SuratKeluar $surat, string $jenisOrganisasiCounter, ?int $nomor): void
    {
        if (!$nomor) {
            return;
        }

        $counter = in_array($surat->jenis_surat, ['kepanitiaan', 'kepanitiaan_bersama'], true)
            ? NomorSuratKepanitiaanCounter::where('program_kerja_id', $surat->program_kerja_id)
                ->where('jenis_organisasi', $jenisOrganisasiCounter)
                ->first()
            : NomorSuratCounter::where('organisasi_id', $surat->organisasi_id)
                ->where('jenis_organisasi', $jenisOrganisasiCounter)
                ->whereHas('periodeKepengurusan', fn ($q) => $q->where('is_active', true))
                ->first();

        abort_if(!$counter, 422, 'Counter nomor surat untuk surat ini tidak ditemukan — tidak bisa membatalkan.');

        NomorSuratDibatalkan::create([
            'counter_id' => $counter->id,
            'counter_type' => get_class($counter),
            'nomor' => $nomor,
            'dibatalkan_at' => now(),
            'dibatalkan_by' => Auth::id(),
            'alasan' => request('alasan'),
        ]);
    }
}
