<?php

namespace App\Services;

use InvalidArgumentException;

class RomawiHelper
{
    public static function convert(int $angka): string
    {
        if ($angka <= 0) {
            throw new InvalidArgumentException("Angka untuk konversi Romawi harus positif, diberikan: {$angka}");
        }

        $map = [
            100 => 'C', 90 => 'XC', 50 => 'L', 40 => 'XL',
            10 => 'X', 9 => 'IX', 5 => 'V', 4 => 'IV', 1 => 'I',
        ];

        $hasil = '';
        foreach ($map as $nilai => $simbol) {
            while ($angka >= $nilai) {
                $hasil .= $simbol;
                $angka -= $nilai;
            }
        }

        return $hasil;
    }
}
