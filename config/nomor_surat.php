<?php

// Daftar kode indeks resmi IPNU/IPPNU, sesuai Format-Nomor-Surat.md §2-§3.
// Config array, BUKAN tabel database — daftar ini tetap dari AD/ART, tidak perlu CRUD.

return [
    'kode_indeks' => [
        'IPNU' => [
            'A' => 'Surat untuk lingkungan internal IPNU',
            'B' => 'Surat untuk lingkungan eksternal IPNU',
            'C' => 'Surat untuk NU, Banom lain, dan lembaga di lingkungan NU',
            'SK' => 'Surat Keputusan',
            'SP' => 'Surat Pengesahan',
            'SPk' => 'Surat Pengangkatan',
            'SPh' => 'Surat Pemberhentian',
            'SRP' => 'Surat Rekomendasi Pengesahan',
            'SM' => 'Surat Mandat',
            'ST' => 'Surat Tugas',
            'SPt' => 'Surat Pengantar',
            'SKt' => 'Surat Keterangan',
            'SPi' => 'Surat Peringatan',
            'SR' => 'Surat Rekomendasi',
            'SI' => 'Surat Instruksi',
            'SPy' => 'Surat Pernyataan',
            'SE' => 'Surat Edaran',
            'SKu' => 'Surat Kuasa',
        ],
        'IPPNU' => [
            'A' => 'Surat untuk lingkungan internal IPPNU',
            'B' => 'Surat untuk lingkungan eksternal IPPNU',
            'C' => 'Surat untuk NU, Banom lain, dan lembaga di lingkungan NU',
            'SK' => 'Surat Keputusan',
            'SP' => 'Surat Pengesahan',
            'SRP' => 'Surat Rekomendasi Pengesahan',
            'SR' => 'Surat Rekomendasi',
            'SPk/SPh' => 'Surat Pengangkatan / Pemberhentian',
            'SM' => 'Surat Mandat',
            'Sk' => 'Surat Kuasa',
            'S.Ins. PP' => 'Instruksi Pimpinan Pusat',
            'S.Ins. PW' => 'Instruksi Pimpinan Wilayah',
            'S.Ins. PC' => 'Instruksi Pimpinan Cabang',
            'S.Ins. PAC' => 'Instruksi Pimpinan Anak Cabang',
            'SPt' => 'Surat Pengantar',
            'Si. PP' => 'Siaran Pimpinan Pusat',
            'Si. PW' => 'Siaran Pimpinan Wilayah',
            'Si. PC' => 'Siaran Pimpinan Cabang',
            'Si. PAC' => 'Siaran Pimpinan Anak Cabang',
            'Si. PR' => 'Siaran Pimpinan Ranting',
            'Si. PK' => 'Siaran Pimpinan Komisariat',
            'Si. PCI' => 'Siaran Pimpinan Cabang Istimewa',
            'S.Ket' => 'Surat Keterangan',
        ],
    ],

    'tingkat' => [
        'PP' => 'Pimpinan Pusat',
        'PW' => 'Pimpinan Wilayah',
        'PC' => 'Pimpinan Cabang',
        'PCI' => 'Pimpinan Cabang Istimewa',
        'PAC' => 'Pimpinan Anak Cabang',
        'PK' => 'Pimpinan Komisariat',
        'PR' => 'Pimpinan Ranting',
    ],
];
