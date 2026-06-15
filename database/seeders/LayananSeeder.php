<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Template Surat
            [
                'judul'           => 'Template Surat Undangan Rapat',
                'deskripsi'       => 'Template surat undangan rapat resmi untuk PAC, PR, dan PK. Format standar IPNU-IPPNU siap pakai.',
                'kategori'        => 'Template Surat',
                'file_path'       => 'layanan/template-surat-undangan-rapat.docx',
                'ukuran_file'     => '45 KB',
                'jumlah_download' => 34,
            ],
            [
                'judul'           => 'Template Surat Rekomendasi Kader',
                'deskripsi'       => 'Surat rekomendasi resmi untuk kader yang mengikuti kegiatan di luar organisasi, pelantikan, atau perpindahan.',
                'kategori'        => 'Template Surat',
                'file_path'       => 'layanan/template-surat-rekomendasi-kader.docx',
                'ukuran_file'     => '38 KB',
                'jumlah_download' => 21,
            ],
            [
                'judul'           => 'Template Surat Permohonan Izin Kegiatan',
                'deskripsi'       => 'Surat permohonan izin kegiatan kepada instansi pemerintah, sekolah, atau ponpes.',
                'kategori'        => 'Template Surat',
                'file_path'       => 'layanan/template-surat-izin-kegiatan.docx',
                'ukuran_file'     => '52 KB',
                'jumlah_download' => 18,
            ],

            // Pedoman
            [
                'judul'           => 'Pedoman Kaderisasi IPNU 2024',
                'deskripsi'       => 'Panduan lengkap sistem kaderisasi IPNU meliputi MAKESTA, LAKMUD, dan LAKUT beserta kurikulumnya.',
                'kategori'        => 'Pedoman',
                'file_path'       => 'layanan/pedoman-kaderisasi-ipnu-2024.pdf',
                'ukuran_file'     => '2.1 MB',
                'jumlah_download' => 87,
            ],
            [
                'judul'           => 'Juklak Masa Kesetiaan Anggota (MAKESTA)',
                'deskripsi'       => 'Petunjuk pelaksanaan MAKESTA lengkap: tujuan, materi, metode, dan evaluasi untuk panitia penyelenggara.',
                'kategori'        => 'Pedoman',
                'file_path'       => 'layanan/juklak-makesta.pdf',
                'ukuran_file'     => '1.8 MB',
                'jumlah_download' => 63,
            ],
            [
                'judul'           => 'Panduan Administrasi Organisasi',
                'deskripsi'       => 'Panduan lengkap tata kelola administrasi organisasi IPNU-IPPNU dari tingkat PC hingga PK.',
                'kategori'        => 'Pedoman',
                'file_path'       => 'layanan/panduan-administrasi-organisasi.pdf',
                'ukuran_file'     => '3.2 MB',
                'jumlah_download' => 45,
            ],

            // Peraturan
            [
                'judul'           => 'AD/ART IPNU Hasil Kongres 2021',
                'deskripsi'       => 'Anggaran Dasar dan Anggaran Rumah Tangga IPNU yang disahkan pada Kongres IPNU XVII tahun 2021.',
                'kategori'        => 'Peraturan',
                'file_path'       => 'layanan/adart-ipnu-2021.pdf',
                'ukuran_file'     => '4.5 MB',
                'jumlah_download' => 112,
            ],
            [
                'judul'           => 'Peraturan Perkumpulan IPNU',
                'deskripsi'       => 'Peraturan perkumpulan yang mengatur tata kelola organisasi, sanksi, dan mekanisme penyelesaian sengketa internal.',
                'kategori'        => 'Peraturan',
                'file_path'       => 'layanan/peraturan-perkumpulan-ipnu.pdf',
                'ukuran_file'     => '2.8 MB',
                'jumlah_download' => 56,
            ],

            // Formulir
            [
                'judul'           => 'Formulir Pendaftaran Kader Baru',
                'deskripsi'       => 'Formulir registrasi anggota baru IPNU-IPPNU. Wajib diisi sebelum mengikuti MAKESTA.',
                'kategori'        => 'Formulir',
                'file_path'       => 'layanan/formulir-pendaftaran-kader-baru.pdf',
                'ukuran_file'     => '120 KB',
                'jumlah_download' => 74,
            ],

            // Doa & Dzikir
            [
                'judul'           => 'Kumpulan Doa Harian IPNU',
                'deskripsi'       => 'Kumpulan doa harian, doa pembuka dan penutup kegiatan, serta dzikir yang dibaca dalam setiap pertemuan resmi IPNU.',
                'kategori'        => 'Doa & Dzikir',
                'file_path'       => 'layanan/kumpulan-doa-harian-ipnu.pdf',
                'ukuran_file'     => '280 KB',
                'jumlah_download' => 93,
            ],

            // Lainnya
            [
                'judul'           => 'Kalender Program Kerja 2025',
                'deskripsi'       => 'Kalender tahunan program kerja PC IPNU-IPPNU Kab. Kediri masa khidmat 2025-2027.',
                'kategori'        => 'Lainnya',
                'file_path'       => 'layanan/kalender-program-kerja-2025.pdf',
                'ukuran_file'     => '580 KB',
                'jumlah_download' => 39,
            ],
        ];

        foreach ($data as $item) {
            Layanan::create(array_merge($item, ['is_active' => true]));
        }
    }
}
