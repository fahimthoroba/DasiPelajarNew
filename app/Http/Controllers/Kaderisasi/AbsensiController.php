<?php

namespace App\Http\Controllers\Kaderisasi;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\AbsensiRecord;
use App\Models\Kader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class AbsensiController extends Controller
{
    /**
     * List all attendance sessions
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Absensi::with(['departemen', 'creator', 'records'])
            ->orderBy('tgl_waktu', 'desc');

        // Filter by departemen for non-admin
        if (!in_array($user->role, ['admin', 'sekretaris'])) {
            $query->where('departemen_id', $user->departemen_id);
        }

        // Search
        if ($request->filled('q')) {
            $query->where('judul', 'like', '%' . $request->q . '%');
        }

        // Filter by jenis
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sesiList = $query->paginate(12);

        // Stats
        $statsQuery = Absensi::query();
        if (!in_array($user->role, ['admin', 'sekretaris'])) {
            $statsQuery->where('departemen_id', $user->departemen_id);
        }
        $stats = [
            'total'       => (clone $statsQuery)->count(),
            'aktif'       => (clone $statsQuery)->open()->count(),
            'selesai'     => (clone $statsQuery)->closed()->count(),
            'total_hadir' => AbsensiRecord::whereIn('absensi_id',
                (clone $statsQuery)->pluck('id')
            )->where('status_kehadiran', 'hadir')->count(),
        ];

        return view('dashboard.kaderisasi.absensi.index', compact('sesiList', 'stats'));
    }

    /**
     * Show create form
     */
    public function create(Request $request)
    {
        $programKerja = null;
        if ($request->filled('program_kerja_id')) {
            $programKerja = \App\Models\ProgramKerja::find($request->program_kerja_id);
        }

        return view('dashboard.kaderisasi.absensi.create', compact('programKerja'));
    }

    /**
     * Store new attendance session
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'            => 'required|string|max:255',
            'jenis'            => 'required|in:' . implode(',', array_keys(Absensi::JENIS_LABELS)),
            'tgl_waktu'        => 'required|date',
            'lokasi'           => 'nullable|string|max:255',
            'deskripsi'        => 'nullable|string',
            'program_kerja_id' => 'nullable|exists:program_kerjas,id',
        ]);

        $user = auth()->user();

        $absensi = Absensi::create([
            'judul'            => $request->judul,
            'jenis'            => $request->jenis,
            'tgl_waktu'        => $request->tgl_waktu,
            'lokasi'           => $request->lokasi,
            'deskripsi'        => $request->deskripsi,
            'departemen_id'    => $user->departemen_id,
            'organisasi_id'    => $user->getActiveOrganisasiId(),
            'kode_akses'       => strtoupper(Str::random(8)),
            'status'           => 'buka',
            'created_by'       => $user->id,
            'program_kerja_id' => $request->program_kerja_id,
        ]);

        return redirect()
            ->route('dashboard.kaderisasi.absensi.show', $absensi->id)
            ->with('success', 'Sesi absensi berhasil dibuat. QR Code siap ditampilkan.');
    }

    /**
     * Show session detail with QR code and attendance list
     */
    public function show($id)
    {
        $absensi = Absensi::with(['records.kader', 'departemen', 'creator', 'programKerja'])
            ->findOrFail($id);

        // Generate QR Code (cached 24 jam, invalidate saat close/reopen)
        $scanUrl = route('absensi.scan', $absensi->kode_akses);
        $qrSvg = Cache::remember("qr_absensi_{$id}", 86400, function () use ($scanUrl) {
            $options = new QROptions([
                'outputType'  => QRCode::OUTPUT_MARKUP_SVG,
                'scale'       => 10,
                'imageBase64' => false,
            ]);
            return (new QRCode($options))->render($scanUrl);
        });

        // Separate kader and umum records
        $recordsKader = $absensi->records->where('tipe_peserta', 'kader');
        $recordsUmum  = $absensi->records->where('tipe_peserta', 'umum');

        return view('dashboard.kaderisasi.absensi.show', compact(
            'absensi', 'qrSvg', 'scanUrl', 'recordsKader', 'recordsUmum'
        ));
    }

    /**
     * Add attendee manually (kader or umum)
     */
    public function addManual(Request $request, $id)
    {
        $absensi = Absensi::findOrFail($id);

        $request->validate([
            'tipe_peserta'     => 'required|in:kader,umum',
            'kader_id'         => 'required_if:tipe_peserta,kader|nullable|exists:kaders,id',
            'nama_peserta'     => 'required_if:tipe_peserta,umum|nullable|string|max:255',
            'status_kehadiran' => 'required|in:hadir,izin,sakit,alpha',
        ]);

        // Check duplicate for kader
        if ($request->tipe_peserta === 'kader' && $request->kader_id) {
            $exists = $absensi->records()
                ->where('kader_id', $request->kader_id)
                ->exists();
            if ($exists) {
                return back()->with('error', 'Kader ini sudah tercatat di sesi ini.');
            }
        }

        AbsensiRecord::create([
            'absensi_id'       => $absensi->id,
            'kader_id'         => $request->tipe_peserta === 'kader' ? $request->kader_id : null,
            'nama_peserta'     => $request->tipe_peserta === 'umum' ? $request->nama_peserta : null,
            'tipe_peserta'     => $request->tipe_peserta,
            'status_kehadiran' => $request->status_kehadiran,
            'metode'           => 'manual',
            'waktu_hadir'      => now(),
        ]);

        return back()->with('success', 'Peserta berhasil ditambahkan.');
    }

    /**
     * Close attendance session
     */
    public function close($id)
    {
        $absensi = Absensi::findOrFail($id);

        if (!$absensi->isOpen()) {
            return back()->with('error', 'Sesi sudah ditutup sebelumnya.');
        }

        $absensi->close();
        Cache::forget("qr_absensi_{$id}");

        return back()->with('success', 'Sesi absensi berhasil ditutup.');
    }

    /**
     * Reopen attendance session
     */
    public function reopen($id)
    {
        $absensi = Absensi::findOrFail($id);

        $absensi->update([
            'status'    => 'buka',
            'closed_at' => null,
        ]);
        Cache::forget("qr_absensi_{$id}");

        return back()->with('success', 'Sesi absensi dibuka kembali.');
    }

    /**
     * Delete attendance session
     */
    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->records()->delete();
        $absensi->delete();

        return redirect()
            ->route('dashboard.kaderisasi.absensi.index')
            ->with('success', 'Sesi absensi berhasil dihapus.');
    }

    /**
     * Public scan page (requires login)
     */
    public function scan($kode)
    {
        $absensi = Absensi::where('kode_akses', $kode)->firstOrFail();
        $user = auth()->user();

        // Check if kader already scanned
        $alreadyScanned = false;
        if ($user && $user->kader_id) {
            $alreadyScanned = $absensi->records()
                ->where('kader_id', $user->kader_id)
                ->exists();
        }

        return view('dashboard.kaderisasi.absensi.scan', compact('absensi', 'alreadyScanned'));
    }

    /**
     * Process scan / attendance submission
     */
    public function processScan(Request $request, $kode)
    {
        $absensi = Absensi::where('kode_akses', $kode)->firstOrFail();

        if (!$absensi->isOpen()) {
            return back()->with('error', 'Sesi absensi sudah ditutup.');
        }

        $user = auth()->user();

        // Kader scan
        if ($user && $user->kader_id) {
            $exists = $absensi->records()
                ->where('kader_id', $user->kader_id)
                ->exists();

            if ($exists) {
                return back()->with('error', 'Anda sudah tercatat hadir di sesi ini.');
            }

            AbsensiRecord::create([
                'absensi_id'       => $absensi->id,
                'kader_id'         => $user->kader_id,
                'tipe_peserta'     => 'kader',
                'status_kehadiran' => 'hadir',
                'metode'           => 'scan',
                'waktu_hadir'      => now(),
            ]);

            return back()->with('success', 'Absensi berhasil! Kehadiran Anda tercatat.');
        }

        // Peserta umum
        $request->validate([
            'nama_peserta' => 'required|string|max:255',
        ]);

        AbsensiRecord::create([
            'absensi_id'       => $absensi->id,
            'nama_peserta'     => $request->nama_peserta,
            'tipe_peserta'     => 'umum',
            'status_kehadiran' => 'hadir',
            'metode'           => 'scan',
            'waktu_hadir'      => now(),
        ]);

        return back()->with('success', 'Absensi berhasil! Kehadiran tercatat.');
    }

    /**
     * API endpoint for real-time attendee list (polling)
     */
    public function attendees($id)
    {
        $absensi = Absensi::with('records.kader')->findOrFail($id);

        $data = $absensi->records->map(function ($record) {
            return [
                'id'               => $record->id,
                'nama'             => $record->nama,
                'tipe_peserta'     => $record->tipe_peserta,
                'status_kehadiran' => $record->status_kehadiran,
                'metode'           => $record->metode,
                'waktu_hadir'      => $record->waktu_hadir?->format('H:i'),
            ];
        });

        return response()->json([
            'total'   => $data->count(),
            'hadir'   => $data->where('status_kehadiran', 'hadir')->count(),
            'records' => $data->values(),
            'status'  => $absensi->status,
        ]);
    }
}
