<?php

namespace App\Services;

use App\Models\NomorSuratCounter;
use App\Models\NomorSuratDibatalkan;
use App\Models\NomorSuratKepanitiaanCounter;
use App\Models\PeriodeKepengurusan;
use App\Models\ProgramKerja;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

class NomorSuratGenerator
{
    public function __construct(private NomorSuratFormatter $formatter)
    {
    }

    /**
     * $params: organisasi_id, jenis_surat, jenis_organisasi, kode_indeks,
     *          tingkat, bulan, tahun, program_kerja_id (untuk kepanitiaan/kepanitiaan_bersama)
     *
     * Return: ['no_surat' => string terformat, 'nomor_urut' => int mentah]
     */
    public function generate(array $params): array
    {
        return DB::transaction(function () use (&$params) {
            if (in_array($params['jenis_surat'], ['kepanitiaan', 'kepanitiaan_bersama'], true)) {
                $proker = ProgramKerja::findOrFail($params['program_kerja_id']);
                abort_if(
                    empty($proker->kode_surat_kepanitiaan),
                    422,
                    'Kode Surat Kepanitiaan belum diisi — lengkapi dulu di halaman Susunan Panitia.'
                );
                $params['nama_kepanitiaan'] = $proker->kode_surat_kepanitiaan;
            }

            $nomorUrut = match ($params['jenis_surat']) {
                'reguler' => $this->incrementCounterUtama($params),
                'kepanitiaan' => $this->incrementCounterKepanitiaan($params, $params['jenis_organisasi']),
                'kepanitiaan_bersama' => $this->incrementCounterKepanitiaan($params, 'Bersama'),
                'bersama' => throw new \InvalidArgumentException(
                    "jenis_surat 'bersama' harus dipanggil lewat generateBersama(), bukan generate()."
                ),
                default => throw new \InvalidArgumentException("jenis_surat tidak dikenal: {$params['jenis_surat']}"),
            };

            $noSurat = match ($params['jenis_surat']) {
                'reguler' => $params['jenis_organisasi'] === 'IPNU'
                    ? $this->formatter->formatIpnu($params, $nomorUrut)
                    : $this->formatter->formatIppnu($params, $nomorUrut),
                'kepanitiaan' => $this->formatter->formatKepanitiaan($params, $nomorUrut, $params['jenis_organisasi']),
                'kepanitiaan_bersama' => $this->formatter->formatKepanitiaanBersama($params, $nomorUrut),
            };

            return ['no_surat' => $noSurat, 'nomor_urut' => $nomorUrut];
        });
    }

    public function generateBersama(array $params): array
    {
        return DB::transaction(function () use ($params) {
            // 2 counter di-increment dalam 1 transaction — kalau salah satu gagal, keduanya rollback
            $paramsIpnu = $params;
            $nomorIpnu = $this->incrementCounterUtama($paramsIpnu, 'IPNU');

            $paramsIppnu = $params;
            $nomorIppnu = $this->incrementCounterUtama($paramsIppnu, 'IPPNU');

            return [
                'baris_ipnu' => $this->formatter->formatIpnu($paramsIpnu, $nomorIpnu),
                'baris_ippnu' => $this->formatter->formatIppnu($paramsIppnu, $nomorIppnu),
                'nomor_ipnu' => $nomorIpnu,
                'nomor_ippnu' => $nomorIppnu,
            ];
        });
    }

    /**
     * Increment counter utama. $params dimodifikasi by-reference untuk inject 'periode_ke'
     * yang dibutuhkan Formatter (periode aktif baru diketahui setelah lookup di sini,
     * bukan sesuatu yang caller bisa kirim duluan).
     */
    private function incrementCounterUtama(array &$params, ?string $jenisOrganisasiOverride = null): int
    {
        $organisasiId = $params['organisasi_id'];
        $jenisOrganisasi = $jenisOrganisasiOverride ?? $params['jenis_organisasi'];

        $periode = $this->resolvePeriodeAktif($organisasiId, $jenisOrganisasi);
        $params['periode_ke'] = $periode->periode_ke;

        // WAJIB: lockForUpdate() di dalam DB::transaction() (sudah dibungkus caller) — mencegah
        // race condition yang terbukti ada di HasCustomId (ADR-016, SELECT->increment->INSERT
        // tanpa locking). 2 request bersamaan tidak boleh menghasilkan nomor kembar.
        $counter = NomorSuratCounter::where([
            'organisasi_id' => $organisasiId,
            'jenis_organisasi' => $jenisOrganisasi,
            'periode_kepengurusan_id' => $periode->id,
        ])->lockForUpdate()->first();

        if (!$counter) {
            $counter = NomorSuratCounter::create([
                'organisasi_id' => $organisasiId,
                'jenis_organisasi' => $jenisOrganisasi,
                'periode_kepengurusan_id' => $periode->id,
                'nomor_terakhir' => 0,
            ]);
            // Re-lock row yang baru dibuat supaya konsisten dengan path "counter sudah ada"
            // (INSERT tidak otomatis exclusive-lock baris untuk transaksi konkuren lain yang juga baru SELECT)
            $counter = NomorSuratCounter::where('id', $counter->id)->lockForUpdate()->first();
        }

        return $this->nextNomor($counter);
    }

    /**
     * Increment counter kepanitiaan, scoped per (program_kerja_id, jenis_organisasi).
     * $params dimodifikasi by-reference untuk inject periode_ke yang dibutuhkan Formatter —
     * diambil dari periode aktif ORGANISASI (sama seperti counter utama), bukan dari proker,
     * karena periode kepengurusan tetap melekat ke organisasi, bukan ke kepanitiaan individual.
     */
    private function incrementCounterKepanitiaan(array &$params, string $jenisOrganisasi): int
    {
        $programKerjaId = $params['program_kerja_id'];

        if ($jenisOrganisasi === 'Bersama') {
            $params['periode_ke_ipnu'] = $this->resolvePeriodeAktif($params['organisasi_id'], 'IPNU')->periode_ke;
            $params['periode_ke_ippnu'] = $this->resolvePeriodeAktif($params['organisasi_id'], 'IPPNU')->periode_ke;
        } else {
            $params['periode_ke'] = $this->resolvePeriodeAktif($params['organisasi_id'], $jenisOrganisasi)->periode_ke;
        }

        // WAJIB: lockForUpdate() di dalam DB::transaction() (sudah dibungkus caller generate())
        $counter = NomorSuratKepanitiaanCounter::where([
            'program_kerja_id' => $programKerjaId,
            'jenis_organisasi' => $jenisOrganisasi,
        ])->lockForUpdate()->first();

        abort_if(
            !$counter,
            422,
            'Buku agenda surat kepanitiaan belum dibuat — pastikan susunan panitia sudah disimpan minimal sekali.'
        );

        return $this->nextNomor($counter);
    }

    /**
     * Cek freelist (nomor surat batal yang belum dipakai ulang) SEBELUM increment counter normal.
     * Dipanggil di dalam lockForUpdate()+DB::transaction() yang sama dengan caller — locking
     * pada query freelist (bukan cuma pada counter) wajib supaya 2 generate bersamaan tidak
     * sama-sama mengambil nomor freelist yang sama.
     */
    private function nextNomor($counter): int
    {
        $nomorBatal = NomorSuratDibatalkan::where('counter_id', $counter->id)
            ->where('counter_type', get_class($counter))
            ->where('sudah_dipakai_ulang', false)
            ->orderBy('nomor', 'asc')
            ->lockForUpdate()
            ->first();

        if ($nomorBatal) {
            $nomorBatal->update(['sudah_dipakai_ulang' => true]);
            return $nomorBatal->nomor;
        }

        $counter->increment('nomor_terakhir');

        return $counter->nomor_terakhir;
    }

    private function resolvePeriodeAktif(int $organisasiId, string $jenisOrganisasi): PeriodeKepengurusan
    {
        $periode = PeriodeKepengurusan::where('organisasi_id', $organisasiId)
            ->where('jenis_organisasi', $jenisOrganisasi)
            ->where('is_active', true)
            ->first();

        if (!$periode) {
            throw new HttpException(422, 'Set periode kepengurusan dulu di Master Data sebelum membuat surat.');
        }

        return $periode;
    }
}
