<?php

namespace App\Http\Controllers\Departemen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgramKerja;
use Illuminate\Support\Facades\Auth;

class ProgramKerjaController extends Controller
{
    public function index()
    {
        $deptId = Auth::user()->departemen_id;
        $active_programs = ProgramKerja::where('departemen_id', $deptId)
            ->whereIn('status_pelaksanaan', ['Perencanaan', 'Persiapan', 'Pelaksanaan'])
            ->orderBy('tgl_pelaksanaan', 'asc')
            ->get();

        $completed_programs = ProgramKerja::where('departemen_id', $deptId)
            ->where('status_pelaksanaan', 'Selesai')
            ->latest('tgl_pelaksanaan')
            ->paginate(5);

        return view('dashboard.departemen.proker.index', compact('active_programs', 'completed_programs'));
    }

    public function show($id)
    {
        $proker = ProgramKerja::with(['departemen', 'kepanitiaans', 'absensis', 'formKegiatan'])->findOrFail($id);
        return view('dashboard.departemen.proker.show', compact('proker'));
    }

    public function updateStatus(Request $request, $id)
    {
        $proker = ProgramKerja::findOrFail($id);

        // Simple logic: If status is 'Selesai', ensure LPJ exists? (Skip for now as requested just to remove dropdown)
        // Actually, user said "Remove dropdown status", implies status automation.
        // But for now, keeping the method for internal logic or manual override if needed.
        // I will focus on the sub-features first.

        $request->validate([
            'status_pelaksanaan' => 'required|in:Perencanaan,Persiapan,Pelaksanaan,Selesai'
        ]);

        $proker->update(['status_pelaksanaan' => $request->status_pelaksanaan]);
        return back()->with('success', 'Status program berhasil diperbarui.');
    }
    // --- Committee (Panitia) ---
    // Daftar sie tetap
    private array $sieList = [
        'acara'          => 'Sie Acara',
        'konsumsi'       => 'Sie Konsumsi',
        'dokumentasi'    => 'Sie Dokumentasi',
        'perkap'         => 'Sie Perkap',
        'humas'          => 'Sie Humas',
        'sekretariatan'  => 'Sie Sekretariatan',
        'keamanan'       => 'Sie Keamanan',
        'kesehatan'      => 'Sie Kesehatan',
    ];

    public function indexPanitia($id)
    {
        $proker = ProgramKerja::with('kepanitiaans.kader')->findOrFail($id);
        $kaders = \App\Models\Kader::orderBy('nama_lengkap')->get();

        // Kelompokkan panitia yang sudah ada untuk pre-fill form
        $existing       = $proker->kepanitiaans->keyBy('jabatan');
        $existingAnggota = $proker->kepanitiaans->groupBy('jabatan');
        $sieList        = $this->sieList;

        return view('dashboard.departemen.proker.panitia',
            compact('proker', 'kaders', 'existing', 'existingAnggota', 'sieList'));
    }

    public function bulkStorePanitia(Request $request, $id)
    {
        $proker = ProgramKerja::findOrFail($id);

        // Hapus semua panitia lama, lalu re-insert
        $proker->kepanitiaans()->delete();

        $inserted = 0;

        // BPH: Ketua, Sekretaris, Bendahara
        $bphMap = [
            'ketua'      => 'Ketua Panitia',
            'sekretaris' => 'Sekretaris',
            'bendahara'  => 'Bendahara',
        ];
        foreach ($bphMap as $key => $jabatan) {
            $kaderId = $request->input("bph.$key");
            if ($kaderId) {
                \App\Models\Kepanitiaan::create([
                    'program_kerja_id' => $id,
                    'kader_id'         => $kaderId,
                    'jabatan'          => $jabatan,
                ]);
                $inserted++;
            }
        }

        // Sie sections: CO + dynamic anggota
        foreach ($this->sieList as $slug => $label) {
            $coId = $request->input("sie.$slug.co");
            if ($coId) {
                \App\Models\Kepanitiaan::create([
                    'program_kerja_id' => $id,
                    'kader_id'         => $coId,
                    'jabatan'          => "CO $label",
                ]);
                $inserted++;
            }
            foreach ($request->input("sie.$slug.anggota", []) as $anggotaId) {
                if ($anggotaId) {
                    \App\Models\Kepanitiaan::create([
                        'program_kerja_id' => $id,
                        'kader_id'         => $anggotaId,
                        'jabatan'          => "Anggota $label",
                    ]);
                    $inserted++;
                }
            }
        }

        // Advance step jika baru selesai step 1
        if ($inserted > 0 && $proker->current_step == 1) {
            $proker->update(['current_step' => 2, 'status_pelaksanaan' => 'Persiapan']);
        } elseif ($inserted === 0 && $proker->current_step == 2) {
            $proker->update(['current_step' => 1, 'status_pelaksanaan' => 'Perencanaan']);
        }

        return redirect()->route('dashboard.departemen.proker.panitia', $id)
            ->with('success', 'Susunan panitia berhasil disimpan.');
    }

    public function destroyPanitia($id, $panitiaId)
    {
        \App\Models\Kepanitiaan::findOrFail($panitiaId)->delete();
        return back()->with('success', 'Panitia dihapus.');
    }

    // --- Agenda & Absensi (Merged) ---
    public function indexAgenda($id)
    {
        $proker = ProgramKerja::with('absensis')->findOrFail($id);

        $qrSvgs = [];
        $options = new \chillerlan\QRCode\QROptions([
            'outputType' => \chillerlan\QRCode\QRCode::OUTPUT_MARKUP_SVG,
            'imageBase64' => false,
        ]);
        foreach ($proker->absensis as $absensi) {
            $scanUrl = route('absensi.scan', $absensi->kode_akses);
            $qrSvgs[$absensi->id] = (new \chillerlan\QRCode\QRCode($options))->render($scanUrl);
        }

        return view('dashboard.departemen.proker.agenda', compact('proker', 'qrSvgs'));
    }

    public function storeAgenda(Request $request, $id)
    {
        $request->validate([
            'judul'     => 'required|string',
            'tgl_waktu' => 'required|date',
            'jenis'     => 'required|in:rapat_panitia,pelaksanaan',
        ]);

        $proker = ProgramKerja::findOrFail($id);

        if ($request->jenis === 'rapat_panitia' && !$proker->canCreateNewRapatPanitia()) {
            return back()->with('error', 'Akses ditolak: Semua rapat sebelumnya harus sudah ditutup dan memiliki file notulensi.');
        }

        if ($request->jenis === 'pelaksanaan') {
            if (!$proker->canProceedToPelaksanaan()) {
                return back()->with('error', 'Akses ditolak: Pastikan kepanitiaan sudah dibentuk dan semua rapat panitia sudah selesai beserta notulensinya.');
            }
            if ($proker->current_step < 4) {
                $proker->update(['current_step' => 4, 'status_pelaksanaan' => 'Pelaksanaan']);
            }
        }

        \App\Models\Absensi::create([
            'program_kerja_id' => $id,
            'departemen_id'    => $proker->departemen_id,
            'judul'            => $request->judul,
            'jenis'            => $request->jenis,
            'tgl_waktu'        => $request->tgl_waktu,
            'notulensi_path'   => null,
            'created_by'       => auth()->user()->id,
            'status'           => 'buka',
            'kode_akses'       => \Illuminate\Support\Str::random(6),
        ]);

        return back()->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function closeAgenda($id, $agendaId)
    {
        $absensi = \App\Models\Absensi::findOrFail($agendaId);
        $absensi->close();
        return back()->with('success', 'Sesi absensi ditutup.');
    }

    public function uploadNotulensi(Request $request, $id, $agendaId)
    {
        $request->validate([
            'notulensi' => 'required|file|mimes:pdf,doc,docx|max:3072',
        ]);

        $absensi = \App\Models\Absensi::findOrFail($agendaId);
        $path = $request->file('notulensi')->store('notulensi', 'public');
        $absensi->update(['notulensi_path' => $path]);

        return back()->with('success', 'Notulensi berhasil diupload.');
    }

    public function destroyAgenda($id, $agendaId)
    {
        $absensi = \App\Models\Absensi::findOrFail($agendaId);
        $absensi->delete();
        return back()->with('success', 'Agenda dihapus.');
    }

    // --- LPJ Upload ---
    public function updateLpj(Request $request, $id)
    {
        $proker = ProgramKerja::findOrFail($id);

        if ($proker->isStep5Locked()) {
            return back()->with('error', 'Akses ditolak: Belum ada Sesi Pelaksanaan Kegiatan yang ditutup/selesai.');
        }

        $request->validate(['lpj_path' => 'required|file|mimes:pdf|max:5120']);

        $path = $request->file('lpj_path')->store('lpj', 'public');

        $nextRevision = ($proker->lpjRevisions()->max('revision_number') ?? 0) + 1;

        \App\Models\LpjRevision::create([
            'program_kerja_id' => $proker->id,
            'revision_number'  => $nextRevision,
            'file_path'        => $path,
            'submitted_by'     => Auth::id(),
            'submitted_at'     => now(),
            'status'           => 'pending',
        ]);

        $proker->update([
            'path_lpj' => $path,
            'current_step' => 6 // Menunggu Verifikasi
        ]);

        return back()->with('success', 'LPJ berhasil diupload. Menunggu verifikasi dari BPH.');
    }

}
