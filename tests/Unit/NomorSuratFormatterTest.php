<?php

namespace Tests\Unit;

use App\Services\NomorSuratFormatter;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class NomorSuratFormatterTest extends TestCase
{
    private NomorSuratFormatter $formatter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->formatter = new NomorSuratFormatter();
    }

    public function test_format_ipnu_reguler(): void
    {
        $hasil = $this->formatter->formatIpnu([
            'tingkat' => 'PC',
            'kode_indeks' => 'A',
            'periode_ke' => 16,
            'bulan' => 3,
            'tahun' => 2025,
        ], 5);

        $this->assertSame('005/PC/A/XVI/7354/III/25', $hasil);
    }

    public function test_format_ippnu_reguler(): void
    {
        $hasil = $this->formatter->formatIppnu([
            'tingkat' => 'PP',
            'kode_indeks' => 'SK',
            'periode_ke' => 16,
            'bulan' => 3,
            'tahun' => 2020,
        ], 5);

        $this->assertSame('005/PP/SK/7455/XVI/III/2020', $hasil);
    }

    public function test_ipnu_dan_ippnu_urutan_kolom_berbeda(): void
    {
        $params = [
            'tingkat' => 'PC',
            'kode_indeks' => 'A',
            'periode_ke' => 16,
            'bulan' => 6,
            'tahun' => 2025,
        ];

        $ipnu = $this->formatter->formatIpnu($params, 7);
        $ippnu = $this->formatter->formatIppnu($params, 5);

        // IPNU: periodisasi sebelum tahun lahir, tahun 2 digit
        $this->assertSame('007/PC/A/XVI/7354/VI/25', $ipnu);
        // IPPNU: tahun lahir sebelum periodisasi, tahun 4 digit — urutan TERTUKAR dari IPNU
        $this->assertSame('005/PC/A/7455/XVI/VI/2025', $ippnu);
    }

    public function test_format_kepanitiaan_ipnu(): void
    {
        $hasil = $this->formatter->formatKepanitiaan([
            'tingkat' => 'PC',
            'nama_kepanitiaan' => 'MAKESTA',
            'periode_ke' => 16,
            'bulan' => 8,
            'tahun' => 2025,
        ], 3, 'IPNU');

        $this->assertSame('003/PC/Pan.MAKESTA/XVI/7354/VIII/25', $hasil);
    }

    public function test_format_kepanitiaan_ippnu(): void
    {
        $hasil = $this->formatter->formatKepanitiaan([
            'tingkat' => 'PC',
            'nama_kepanitiaan' => 'MAKESTA',
            'periode_ke' => 16,
            'bulan' => 8,
            'tahun' => 2025,
        ], 2, 'IPPNU');

        $this->assertSame('002/PC/Pan.MAKESTA/7455/XVI/VIII/2025', $hasil);
    }

    public function test_format_kepanitiaan_bersama(): void
    {
        $hasil = $this->formatter->formatKepanitiaanBersama([
            'tingkat' => 'PC',
            'nama_kepanitiaan' => 'MAKESTA',
            'periode_ke_ipnu' => 16,
            'periode_ke_ippnu' => 16,
            'bulan' => 6,
            'tahun' => 2025,
        ], 1);

        $this->assertSame('001/PC/Pan.MAKESTA/XVI-XVI/7354-7455/VI/25', $hasil);
    }

    public function test_format_kepanitiaan_dengan_nama_kosong_tidak_crash(): void
    {
        $hasil = $this->formatter->formatKepanitiaan([
            'tingkat' => 'PC',
            'nama_kepanitiaan' => '',
            'periode_ke' => 16,
            'bulan' => 1,
            'tahun' => 2025,
        ], 1, 'IPNU');

        $this->assertSame('001/PC/Pan./XVI/7354/I/25', $hasil);
    }

    #[DataProvider('romawiProvider')]
    public function test_romawi_konversi_benar(int $angka, string $expected): void
    {
        $reflection = new \ReflectionMethod(NomorSuratFormatter::class, 'romawi');
        $reflection->setAccessible(true);

        $this->assertSame($expected, $reflection->invoke($this->formatter, $angka));
    }

    public static function romawiProvider(): array
    {
        return [
            'satu' => [1, 'I'],
            'empat' => [4, 'IV'],
            'sembilan' => [9, 'IX'],
            'enam belas' => [16, 'XVI'],
            'empat puluh' => [40, 'XL'],
            'sembilan puluh sembilan' => [99, 'XCIX'],
        ];
    }

    public function test_romawi_nol_melempar_exception(): void
    {
        $reflection = new \ReflectionMethod(NomorSuratFormatter::class, 'romawi');
        $reflection->setAccessible(true);

        $this->expectException(InvalidArgumentException::class);
        $reflection->invoke($this->formatter, 0);
    }

    public function test_romawi_negatif_melempar_exception(): void
    {
        $reflection = new \ReflectionMethod(NomorSuratFormatter::class, 'romawi');
        $reflection->setAccessible(true);

        $this->expectException(InvalidArgumentException::class);
        $reflection->invoke($this->formatter, -5);
    }
}
