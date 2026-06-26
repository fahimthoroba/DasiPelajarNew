<?php

namespace App\Services;

class NomorSuratFormatter
{
    private const TAHUN_LAHIR = ['IPNU' => '7354', 'IPPNU' => '7455'];

    public function formatIpnu(array $p, int $nomorUrut): string
    {
        // No / Tingkat / Indeks / Periodisasi / 7354 / Bulan / Tahun(2 digit)
        return sprintf(
            '%03d/%s/%s/%s/%s/%s/%s',
            $nomorUrut,
            $p['tingkat'],
            $p['kode_indeks'],
            $this->romawi($p['periode_ke']),
            self::TAHUN_LAHIR['IPNU'],
            $this->romawi($p['bulan']),
            substr((string) $p['tahun'], -2)
        );
    }

    public function formatIppnu(array $p, int $nomorUrut): string
    {
        // No / Tingkat / Indeks / 7455 / Periodisasi / Bulan / Tahun(4 digit)
        return sprintf(
            '%03d/%s/%s/%s/%s/%s/%s',
            $nomorUrut,
            $p['tingkat'],
            $p['kode_indeks'],
            self::TAHUN_LAHIR['IPPNU'],
            $this->romawi($p['periode_ke']),
            $this->romawi($p['bulan']),
            $p['tahun']
        );
    }

    public function formatKepanitiaan(array $p, int $nomorUrut, string $jenisOrganisasi): string
    {
        $kodeKepanitiaan = 'Pan.' . $p['nama_kepanitiaan'];

        return $jenisOrganisasi === 'IPNU'
            ? sprintf(
                '%03d/%s/%s/%s/%s/%s/%s',
                $nomorUrut,
                $p['tingkat'],
                $kodeKepanitiaan,
                $this->romawi($p['periode_ke']),
                self::TAHUN_LAHIR['IPNU'],
                $this->romawi($p['bulan']),
                substr((string) $p['tahun'], -2)
            )
            : sprintf(
                '%03d/%s/%s/%s/%s/%s/%s',
                $nomorUrut,
                $p['tingkat'],
                $kodeKepanitiaan,
                self::TAHUN_LAHIR['IPPNU'],
                $this->romawi($p['periode_ke']),
                $this->romawi($p['bulan']),
                $p['tahun']
            );
    }

    public function formatKepanitiaanBersama(array $p, int $nomorUrut): string
    {
        // No / Tingkat / Pan.Kegiatan / PeriodeIPNU-PeriodeIPPNU / 7354-7455 / Bulan / Tahun
        return sprintf(
            '%03d/%s/Pan.%s/%s-%s/%s-%s/%s/%s',
            $nomorUrut,
            $p['tingkat'],
            $p['nama_kepanitiaan'],
            $this->romawi($p['periode_ke_ipnu']),
            $this->romawi($p['periode_ke_ippnu']),
            self::TAHUN_LAHIR['IPNU'],
            self::TAHUN_LAHIR['IPPNU'],
            $this->romawi($p['bulan']),
            substr((string) $p['tahun'], -2)
        );
    }

    private function romawi(int $angka): string
    {
        return RomawiHelper::convert($angka);
    }
}
