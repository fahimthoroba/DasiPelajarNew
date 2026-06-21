-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2026 at 10:57 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dasidb_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensis`
--

CREATE TABLE `absensis` (
  `id` varchar(255) NOT NULL,
  `program_kerja_id` varchar(255) DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `jenis` enum('rapat_rutin','rapat_departemen','rapat_panitia','pelaksanaan','rapat_pac','rapat_lembaga','rapat_badan') DEFAULT 'rapat_departemen',
  `deskripsi` text DEFAULT NULL,
  `tgl_waktu` datetime NOT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `departemen_id` varchar(255) DEFAULT NULL,
  `organisasi_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kode_akses` varchar(255) DEFAULT NULL,
  `status` enum('buka','tutup') NOT NULL DEFAULT 'buka',
  `closed_at` timestamp NULL DEFAULT NULL,
  `notulensi_path` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absensis`
--

INSERT INTO `absensis` (`id`, `program_kerja_id`, `judul`, `jenis`, `deskripsi`, `tgl_waktu`, `lokasi`, `departemen_id`, `organisasi_id`, `kode_akses`, `status`, `closed_at`, `notulensi_path`, `created_by`, `created_at`, `updated_at`) VALUES
('abs001', NULL, 'rapat pengurus rutin', 'rapat_rutin', NULL, '2026-01-08 04:57:00', NULL, NULL, NULL, 'WFMNNC', 'buka', NULL, NULL, 'use001', '2026-01-02 17:54:49', '2026-01-02 17:54:49'),
('abs002', 'proker002', 'qweqweqwe', 'rapat_panitia', NULL, '2026-04-23 00:30:00', NULL, 'dep008', NULL, 'K4h02Y', 'tutup', '2026-04-21 10:31:55', NULL, 'use002', '2026-04-21 10:30:43', '2026-04-21 10:31:55');

-- --------------------------------------------------------

--
-- Table structure for table `absensi_records`
--

CREATE TABLE `absensi_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `absensi_id` varchar(255) NOT NULL,
  `kader_id` varchar(255) DEFAULT NULL,
  `nama_peserta` varchar(255) DEFAULT NULL,
  `tipe_peserta` enum('kader','umum') NOT NULL DEFAULT 'kader',
  `metode` enum('scan','manual') NOT NULL DEFAULT 'scan',
  `status_kehadiran` enum('hadir','izin','sakit','alpha') NOT NULL,
  `waktu_hadir` datetime NOT NULL,
  `keterangan` text DEFAULT NULL,
  `bukti_foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absensi_records`
--

INSERT INTO `absensi_records` (`id`, `absensi_id`, `kader_id`, `nama_peserta`, `tipe_peserta`, `metode`, `status_kehadiran`, `waktu_hadir`, `keterangan`, `bukti_foto`, `created_at`, `updated_at`) VALUES
(1, 'abs001', NULL, 'bagio', 'umum', 'scan', 'hadir', '2026-03-19 16:17:17', NULL, NULL, '2026-03-19 09:17:17', '2026-03-19 09:17:17'),
(2, 'abs002', NULL, 'bagio', 'umum', 'scan', 'hadir', '2026-04-21 17:31:22', NULL, NULL, '2026-04-21 10:31:22', '2026-04-21 10:31:22');

-- --------------------------------------------------------

--
-- Table structure for table `banner_iklans`
--

CREATE TABLE `banner_iklans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `posisi` varchar(50) NOT NULL,
  `gambar_path` varchar(255) DEFAULT NULL,
  `link_url` varchar(500) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banner_iklans`
--

INSERT INTO `banner_iklans` (`id`, `posisi`, `gambar_path`, `link_url`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'sidebar_berita', 'banners/hePZybQSxrMT3iVUfik0hXIhtaa4lJeX7SvoQSwd.png', NULL, 1, '2026-03-19 01:02:13', '2026-03-19 01:02:13');

-- --------------------------------------------------------

--
-- Table structure for table `beritas`
--

CREATE TABLE `beritas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kategori_berita_id` bigint(20) UNSIGNED NOT NULL,
  `jenis` enum('berita','opini','pengumuman','foto') NOT NULL DEFAULT 'berita',
  `user_id` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `konten` text NOT NULL,
  `ringkasan` text DEFAULT NULL,
  `views` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `sumber` varchar(255) DEFAULT NULL,
  `status` enum('Draft','Published') NOT NULL DEFAULT 'Draft',
  `is_headline` tinyint(1) NOT NULL DEFAULT 0,
  `tgl_publish` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `beritas`
--

INSERT INTO `beritas` (`id`, `kategori_berita_id`, `jenis`, `user_id`, `judul`, `slug`, `thumbnail`, `konten`, `ringkasan`, `views`, `sumber`, `status`, `is_headline`, `tgl_publish`, `created_at`, `updated_at`) VALUES
(1, 3, 'berita', 'use001', 'Rakercab PC IPNU IPPNU Kabupaten Kediri 2026: Menyatukan Visi Gerakan Pelajar', 'rakercab-pc-ipnu-ippnu-kabupaten-kediri-2026-menyatukan-visi-gerakan-pelajar-UZzKr', 'thumbnails/vpdEHLjgyDebArxkAxR5gMbX5qC3VROFgfVzIlvA.jpg', '<p>Rapat Kerja Cabang (Rakercab) tahunan PC IPNU IPPNU Kabupaten Kediri resmi digelar pada Sabtu-Minggu, 15-16 Maret 2026, bertempat di Aula Gedung NU Kabupaten Kediri.</p>\r\n<p>Kegiatan yang dihadiri lebih dari 200 delegasi dari 26 Pimpinan Anak Cabang (PAC) se-Kabupaten Kediri ini membahas evaluasi program kerja tahun sebelumnya serta merancang program strategis untuk tahun 2026.</p>\r\n<p>Ketua PC IPNU Kabupaten Kediri menyampaikan bahwa Rakercab tahun ini mengangkat tema \"Menyatukan Visi, Menguatkan Aksi: Gerakan Pelajar untuk Kediri Bermartabat\".</p>\r\n<p>\"Kami ingin memastikan setiap PAC memiliki peta jalan yang jelas dalam menjalankan program kaderisasi, dakwah, dan pemberdayaan pelajar di tingkat kecamatan,\" ungkapnya dalam sambutan pembukaan.</p>\r\n<p>Beberapa poin penting yang dihasilkan antara lain: penetapan target 1000 kader baru melalui program MAKESTA di setiap PAC, peluncuran aplikasi DASI Pelajar sebagai sistem informasi digital organisasi, serta pembentukan tim relawan tanggap bencana yang terkoordinasi dengan BPBD Kabupaten Kediri.</p>', 'Rapat Kerja Cabang tahunan PC IPNU IPPNU Kabupaten Kediri resmi digelar di Aula Gedung NU Kediri. Lebih dari 200 delegasi dari 26 PAC hadir membahas program kerja strategis tahun 2026.', 307, NULL, 'Published', 1, '2026-03-15', '2026-03-18 02:47:07', '2026-06-20 15:25:32'),
(2, 3, 'berita', 'use001', 'Pelantikan Pengurus Baru PC IPNU IPPNU Kediri Masa Khidmat 2024-2026', 'pelantikan-pengurus-baru-pc-ipnu-ippnu-kediri-masa-khidmat-2024-2026-hbsly', 'thumbnails/QcBbUk1mucZ1N4h8paMOdIKuoirbC0J5v6ZN5FWo.jpg', '<p>Pelantikan pengurus baru PC IPNU IPPNU Kabupaten Kediri masa khidmat 2024-2026 berlangsung khidmat di Pendopo Kabupaten Kediri pada Minggu, 10 Maret 2026.</p>\r\n<p>Acara yang dihadiri oleh Bupati Kediri, Ketua PCNU Kabupaten Kediri, serta ratusan kader dari seluruh penjuru kabupaten ini menandai babak baru kepemimpinan organisasi pelajar terbesar di Kediri.</p>\r\n<p>Dalam sambutannya, Bupati Kediri menyampaikan apresiasi terhadap peran IPNU IPPNU dalam membina generasi muda. \"Saya yakin pengurus baru ini akan membawa organisasi ke level yang lebih baik, terutama dalam menghadapi tantangan era digital,\" ujarnya.</p>\r\n<p>Ketua terpilih menyampaikan visi untuk menjadikan IPNU IPPNU Kediri sebagai organisasi pelajar yang adaptif terhadap perkembangan zaman namun tetap berpegang pada nilai-nilai Ahlussunnah wal Jamaah.</p>', 'Prosesi pelantikan pengurus baru berlangsung khidmat di Pendopo Kabupaten Kediri. Bupati Kediri turut hadir memberikan amanat kepada jajaran pengurus.', 342, NULL, 'Draft', 1, '2026-03-10', '2026-03-18 02:47:08', '2026-03-19 00:03:17'),
(3, 3, 'berita', 'use001', 'CBP IPNU Kediri Gelar Latihan Disiplin dan Bela Negara di Lereng Gunung Kelud', 'cbp-ipnu-kediri-gelar-latihan-disiplin-dan-bela-negara-di-lereng-gunung-kelud-7ONOM', NULL, '<p>Lembaga Corps Brigade Pembangunan (CBP) PC IPNU Kabupaten Kediri menggelar kegiatan Latihan Disiplin dan Bela Negara pada 5-7 Maret 2026 di kawasan lereng Gunung Kelud, Kecamatan Ngancar.</p><p>Sebanyak 75 peserta dari berbagai PAC mengikuti kegiatan yang meliputi baris-berbaris, survival training, outbound kepemimpinan, serta materi wawasan kebangsaan.</p><p>\"Kegiatan ini bertujuan membentuk karakter kader yang disiplin, tangguh, dan cinta tanah air,\" ujar Koordinator CBP PC IPNU Kediri.</p><p>Peserta juga dibekali materi pertolongan pertama dan teknik evakuasi dasar yang dapat diaplikasikan saat terjadi bencana alam di wilayah Kediri.</p>', 'Corps Brigade Pembangunan (CBP) IPNU Kediri mengadakan latihan fisik dan mental selama tiga hari di kawasan lereng Gunung Kelud.', 156, NULL, 'Published', 0, '2026-03-05', '2026-03-18 02:47:08', '2026-03-18 02:47:08'),
(4, 3, 'berita', 'use001', 'KPP IPPNU Kediri Adakan Pelatihan Kepemimpinan Perempuan Muda', 'kpp-ippnu-kediri-adakan-pelatihan-kepemimpinan-perempuan-muda-IoY0q', NULL, '<p>Lembaga Korps Pelajar Putri (KPP) PC IPPNU Kabupaten Kediri mengadakan Pelatihan Kepemimpinan Perempuan Muda pada Sabtu, 1 Maret 2026, di Gedung Serbaguna Kecamatan Pare.</p><p>Kegiatan yang diikuti oleh 120 kader putri dari 20 PAC ini menghadirkan narasumber dari Dinas Pemberdayaan Perempuan dan Perlindungan Anak Kabupaten Kediri serta aktivis perempuan dari kalangan NU.</p><p>Materi yang disampaikan meliputi public speaking, manajemen konflik, advokasi kebijakan, serta pemberdayaan ekonomi perempuan berbasis komunitas.</p><p>\"Kami ingin kader IPPNU tidak hanya aktif di organisasi, tapi juga mampu menjadi agen perubahan di masyarakat,\" tegas Ketua IPPNU Kediri.</p>', 'Korps Pelajar Putri (KPP) IPPNU Kediri bekerjasama dengan Dinas Pemberdayaan Perempuan mengadakan pelatihan kepemimpinan yang diikuti 120 kader putri.', 198, NULL, 'Published', 0, '2026-03-01', '2026-03-18 02:47:08', '2026-03-18 02:47:08'),
(5, 3, 'berita', 'use001', 'IPNU IPPNU Kediri Salurkan Bantuan untuk Korban Banjir Kecamatan Kandat', 'ipnu-ippnu-kediri-salurkan-bantuan-untuk-korban-banjir-kecamatan-kandat-VBppd', NULL, '<p>Merespon bencana banjir yang melanda tiga desa di Kecamatan Kandat pada Jumat, 28 Februari 2026, tim relawan PC IPNU IPPNU Kabupaten Kediri bergerak cepat melakukan aksi kemanusiaan.</p><p>Sebanyak 50 relawan yang tergabung dalam Satgas Tanggap Bencana diberangkatkan dengan membawa bantuan berupa sembako, air bersih, selimut, dan perlengkapan kebersihan.</p><p>Koordinator Satgas menyampaikan bahwa bantuan dikumpulkan dari donasi kader dan simpatisan dalam waktu kurang dari 24 jam. \"Solidaritas kader luar biasa. Kami berhasil mengumpulkan bantuan senilai lebih dari Rp 15 juta,\" ungkapnya.</p><p>Selain bantuan material, tim relawan juga membantu proses evakuasi dan pembersihan rumah warga yang terendam banjir.</p>', 'Tim relawan IPNU IPPNU Kediri bergerak cepat menyalurkan bantuan logistik dan kebutuhan dasar bagi warga terdampak banjir di tiga desa Kecamatan Kandat.', 234, NULL, 'Published', 0, '2026-02-28', '2026-03-18 02:47:08', '2026-03-18 02:47:08'),
(6, 3, 'berita', 'use001', 'Gebyar Sholawat dan Pengajian Akbar Memperingati Maulid Nabi di Pare', 'gebyar-sholawat-dan-pengajian-akbar-memperingati-maulid-nabi-di-pare-8pSPL', NULL, '<p>PAC IPNU IPPNU Pare berkolaborasi dengan MWC NU Pare menyelenggarakan Gebyar Sholawat dan Pengajian Akbar dalam rangka memperingati Maulid Nabi Muhammad SAW pada Sabtu malam, 22 Februari 2026.</p><p>Acara yang berlangsung di Lapangan Kecamatan Pare ini dihadiri ribuan jamaah dari berbagai kalangan. Grup sholawat dari Ponpes Lirboyo dan Al-Falah Ploso turut memeriahkan acara.</p><p>Pengajian akbar diisi oleh KH. Ahmad Muzammil dari Ponpes Lirboyo yang menyampaikan tausiyah tentang meneladani akhlak Rasulullah SAW dalam kehidupan sehari-hari.</p>', 'Ribuan warga dan kader memadati lapangan Kecamatan Pare dalam acara Gebyar Sholawat dan Pengajian Akbar memperingati Maulid Nabi Muhammad SAW.', 312, NULL, 'Published', 0, '2026-02-22', '2026-03-18 02:47:08', '2026-03-18 02:47:08'),
(7, 4, 'berita', 'use001', 'MAKESTA Angkatan 47: Mencetak 150 Kader Baru IPNU IPPNU Kediri', 'makesta-angkatan-47-mencetak-150-kader-baru-ipnu-ippnu-kediri-O87Wt', NULL, '<p>PC IPNU IPPNU Kabupaten Kediri resmi melaksanakan Masa Kesetiaan Anggota (MAKESTA) angkatan ke-47 pada 8-9 Maret 2026 di Pondok Pesantren Al-Falah Ploso, Kecamatan Mojo.</p><p>Sebanyak 150 calon kader baru yang berasal dari berbagai SMA, SMK, MA, dan pondok pesantren di Kabupaten Kediri mengikuti rangkaian kegiatan yang meliputi materi ke-NU-an, ke-IPNU/IPPNU-an, wawasan kebangsaan, serta praktik organisasi.</p><p>Departemen Kaderisasi PC IPNU Kediri menyampaikan bahwa MAKESTA tahun ini menggunakan metode pembelajaran yang lebih interaktif. \"Kami mengurangi ceramah satu arah dan lebih banyak menggunakan diskusi kelompok, studi kasus, dan simulasi,\" jelasnya.</p><p>Para peserta juga diperkenalkan dengan sistem DASI Pelajar sebagai platform digital organisasi yang akan mereka gunakan sebagai kader resmi.</p>', 'Masa Kesetiaan Anggota (MAKESTA) angkatan ke-47 resmi dilaksanakan selama dua hari. Sebanyak 150 calon kader baru mengikuti proses kaderisasi awal organisasi.', 191, NULL, 'Published', 1, '2026-03-08', '2026-03-18 02:47:08', '2026-06-18 12:38:38'),
(8, 4, 'berita', 'use001', 'Lakmud IPNU Kediri: Membangun Kapasitas Kader Tingkat Madya', 'lakmud-ipnu-kediri-membangun-kapasitas-kader-tingkat-madya-IKI11', NULL, '<p>Departemen Kaderisasi PC IPNU Kabupaten Kediri menyelenggarakan Latihan Kader Muda (Lakmud) pada 22-24 Februari 2026 di Wisma Haji Kabupaten Kediri.</p><p>Sebanyak 60 kader yang telah melewati jenjang MAKESTA mengikuti pelatihan intensif selama tiga hari yang membahas kepemimpinan organisasi, manajemen konflik, analisis sosial, serta teknik advokasi.</p><p>Kegiatan ini juga menghadirkan alumni IPNU IPPNU yang kini berkiprah di berbagai bidang sebagai motivator dan mentor bagi para peserta.</p>', 'Latihan Kader Muda (Lakmud) digelar untuk meningkatkan kapasitas 60 kader yang telah melewati jenjang MAKESTA.', 124, NULL, 'Published', 0, '2026-02-22', '2026-03-18 02:47:08', '2026-03-18 02:47:08'),
(9, 2, 'opini', 'use001', 'Merawat Tradisi Intelektual di Era Digital: Tantangan Kader NU Milenial', 'merawat-tradisi-intelektual-di-era-digital-tantangan-kader-nu-milenial-rcSOW', NULL, '<p>Di tengah deras arus informasi digital, kader muda Nahdlatul Ulama menghadapi dilema yang tidak sederhana: bagaimana mempertahankan tradisi intelektual pesantren yang kaya dan mendalam, sambil tetap relevan di era yang serba cepat dan serba instan?</p><p>Tradisi <em>bahtsul masail</em>, pengajian kitab kuning, dan diskusi-diskusi intelektual yang menjadi ciri khas pesantren adalah kekayaan yang tidak dimiliki oleh tradisi pendidikan manapun. Namun, metode-metode ini kerap dianggap \"lambat\" dan \"ketinggalan zaman\" oleh generasi yang terbiasa dengan informasi instan dari media sosial.</p><p>Tugas kader IPNU IPPNU adalah menjadi jembatan — menerjemahkan kedalaman tradisi pesantren ke dalam bahasa dan medium yang dipahami generasi digital, tanpa mengorbankan substansinya.</p><p>Inilah yang disebut sebagai <em>al-muhafadzah ala al-qadim al-shalih wa al-akhdzu bi al-jadid al-ashlah</em> — memelihara tradisi lama yang baik dan mengambil tradisi baru yang lebih baik.</p>', 'Refleksi mendalam tentang bagaimana kader muda NU dapat mempertahankan tradisi keilmuan pesantren sambil beradaptasi dengan revolusi digital yang mengubah cara berpikir generasi muda.', 178, NULL, 'Published', 0, '2026-03-13', '2026-03-18 02:47:08', '2026-03-18 02:47:08'),
(10, 2, 'opini', 'use001', 'Mengapa Organisasi Pelajar Masih Relevan di Tahun 2026?', 'mengapa-organisasi-pelajar-masih-relevan-di-tahun-2026-M3gSx', NULL, '<p>Pertanyaan ini kerap muncul, terutama dari kalangan yang melihat organisasi kepemudaan sebagai entitas usang yang gagal beradaptasi. Namun data menunjukkan sebaliknya.</p><p>Organisasi pelajar seperti IPNU IPPNU menyediakan sesuatu yang tidak bisa diberikan oleh platform digital manapun: <strong>pengalaman langsung</strong> dalam berinteraksi, bernegosiasi, memimpin, dan bertanggung jawab.</p><p>Soft skills seperti kepemimpinan, komunikasi, dan manajemen konflik hanya bisa diasah melalui praktik nyata — bukan melalui video tutorial atau kursus online.</p><p>Justru di era atomisasi sosial yang dipicu media sosial, organisasi pelajar menjadi salah satu ruang terakhir di mana generasi muda bisa membangun solidaritas genuine dan belajar tentang kehidupan kolektif.</p>', 'Di era ketika semua bisa dipelajari secara online, apakah organisasi pelajar tradisional seperti IPNU IPPNU masih punya tempat? Artikel ini menjawab dengan tegas: ya, justru semakin relevan.', 145, NULL, 'Published', 0, '2026-03-06', '2026-03-18 02:47:08', '2026-03-18 02:47:08'),
(11, 2, 'opini', 'use001', 'Catatan dari Pesantren: Belajar Sabar dari Kitab Kuning', 'catatan-dari-pesantren-belajar-sabar-dari-kitab-kuning-uLyIN', NULL, '<p>Ada sebuah pelajaran yang tidak tertulis di kurikulum manapun namun menjadi fondasi utama pendidikan pesantren: kesabaran. Bukan kesabaran pasif yang hanya menunggu, melainkan kesabaran aktif yang terus berproses.</p><p>Ketika duduk di hadapan kiai, membaca baris demi baris kitab kuning dengan metode <em>bandongan</em>, seorang santri belajar bahwa ilmu tidak bisa diunduh secara instan. Ada proses, ada waktu, ada pengulangan yang tampaknya membosankan namun sesungguhnya membentuk karakter.</p><p>Di era serba cepat ini, kemampuan untuk sabar dalam berproses adalah keunggulan kompetitif yang luar biasa. Dan pesantren, dengan segala kesederhanaannya, telah mengajarkan itu selama berabad-abad.</p>', 'Seorang santri berbagi pengalamannya belajar kesabaran melalui proses mengaji kitab kuning yang panjang dan mendalam di pesantren tradisional.', 201, NULL, 'Published', 0, '2026-02-26', '2026-03-18 02:47:08', '2026-03-18 02:47:08'),
(12, 5, 'berita', 'use001', 'Kajian Ramadan: Fiqih Puasa Kontemporer untuk Pelajar', 'kajian-ramadan-fiqih-puasa-kontemporer-untuk-pelajar-8SHX0', NULL, '<p>Menyambut bulan Ramadan 1447 H, Departemen Dakwah PC IPNU Kabupaten Kediri menggelar seri Kajian Ramadan bertajuk \"Fiqih Puasa Kontemporer untuk Pelajar\" pada setiap Ahad pagi selama bulan Sya\'ban.</p><p>Kajian yang dilaksanakan secara hybrid (luring di Aula PCNU Kediri dan daring via Zoom) ini membahas berbagai persoalan fiqih puasa yang relevan dengan kehidupan pelajar masa kini.</p><p>Beberapa topik yang dibahas antara lain: hukum puasa bagi pelajar yang mengikuti ujian berat, penggunaan infus vitamin saat puasa, serta etika bermedia sosial di bulan Ramadan.</p>', 'Departemen Dakwah PC IPNU Kediri mengadakan seri kajian Ramadan yang membahas fiqih puasa kontemporer khusus untuk kalangan pelajar.', 167, NULL, 'Published', 0, '2026-03-11', '2026-03-18 02:47:08', '2026-03-18 02:47:08'),
(13, 5, 'berita', 'use001', 'Ngaji Filsafat: Diskusi Rutin yang Memadukan Tradisi dan Modernitas', 'ngaji-filsafat-diskusi-rutin-yang-memadukan-tradisi-dan-modernitas-CPVNA', NULL, '<p>Setiap Kamis malam, puluhan kader IPNU IPPNU Kediri berkumpul di sebuah warung kopi di Pare untuk mengikuti forum diskusi bertajuk \"Ngaji Filsafat\".</p><p>Forum yang digagas oleh Departemen Dakwah ini membahas karya-karya pemikir Islam klasik seperti Imam Al-Ghazali, Ibn Rushd, dan Ibn Khaldun, serta pemikir kontemporer seperti Gus Dur, Said Nursi, dan Tariq Ramadan.</p><p>\"Kami ingin menunjukkan bahwa tradisi intelektual Islam sangat kaya dan bisa menjadi referensi untuk menjawab tantangan-tantangan kontemporer,\" ujar fasilitator diskusi.</p>', 'Forum diskusi \"Ngaji Filsafat\" menjadi wadah kader muda mempelajari pemikiran Islam klasik dan kontemporer dengan pendekatan kritis.', 134, NULL, 'Published', 0, '2026-03-04', '2026-03-18 02:47:08', '2026-03-18 02:47:08'),
(14, 6, 'pengumuman', 'use001', 'Pendaftaran Beasiswa Kader Berprestasi IPNU IPPNU Kediri Tahun 2026 Dibuka', 'pendaftaran-beasiswa-kader-berprestasi-ipnu-ippnu-kediri-tahun-2026-dibuka-L1P8z', NULL, '<p><strong>Pengumuman Resmi</strong></p><p>PC IPNU IPPNU Kabupaten Kediri membuka pendaftaran Beasiswa Kader Berprestasi Tahun 2026 bagi kader aktif yang memenuhi kriteria.</p><p><strong>Kuota:</strong> 20 penerima (10 jenjang SMA/SMK/MA, 10 jenjang Perguruan Tinggi)</p><p><strong>Persyaratan:</strong></p><ul><li>Kader aktif IPNU/IPPNU minimal 1 tahun</li><li>IPK minimal 3.0 atau nilai rapor rata-rata 80</li><li>Aktif berorganisasi (dibuktikan dengan surat keterangan PAC/PR)</li><li>Surat rekomendasi dari pengurus PAC</li><li>Esai \"Kontribusi Saya untuk Organisasi\" (500-1000 kata)</li></ul><p><strong>Pendaftaran:</strong> 1-30 April 2026 melalui link: dasi.ipnuippnukediri.or.id/beasiswa</p><p><strong>Pengumuman:</strong> 15 Mei 2026</p>', 'PC IPNU IPPNU Kediri membuka pendaftaran beasiswa pendidikan bagi kader berprestasi. Tersedia 20 kuota untuk jenjang SMA/SMK/MA dan perguruan tinggi.', 456, NULL, 'Published', 0, '2026-03-16', '2026-03-18 02:47:08', '2026-03-18 02:47:08'),
(15, 6, 'pengumuman', 'use001', 'Jadwal Rapat Rutin Bulanan PC IPNU IPPNU Kediri Bulan April 2026', 'jadwal-rapat-rutin-bulanan-pc-ipnu-ippnu-kediri-bulan-april-2026-Myw2B', NULL, '<p><strong>Jadwal Rapat Rutin April 2026:</strong></p><p><strong>1. Rapat Pleno PC</strong><br>Hari/Tanggal: Sabtu, 5 April 2026<br>Waktu: 19.30 WIB<br>Tempat: Aula PCNU Kabupaten Kediri<br>Wajib hadir: Seluruh BPH dan Koordinator Departemen/Lembaga/Badan</p><p><strong>2. Rapat Koordinasi PAC</strong><br>Hari/Tanggal: Sabtu, 12 April 2026<br>Waktu: 13.00 WIB<br>Tempat: Aula PCNU Kabupaten Kediri<br>Wajib hadir: Seluruh Ketua dan Sekretaris PAC</p><p><strong>3. Rapat Evaluasi Departemen</strong><br>Hari/Tanggal: Sabtu, 19 April 2026<br>Waktu: 15.00 WIB<br>Tempat: Aula PCNU Kabupaten Kediri</p><p>Kehadiran wajib. Ketidakhadiran tanpa keterangan akan dicatat dalam evaluasi kinerja pengurus.</p>', 'Informasi jadwal rapat rutin bulanan untuk seluruh pengurus PC, PAC, dan lembaga/badan pada bulan April 2026.', 89, NULL, 'Published', 0, '2026-03-17', '2026-03-18 02:47:08', '2026-03-18 02:47:08'),
(16, 6, 'pengumuman', 'use001', 'Lowongan: Tim Redaksi LPP IPNU Kediri Cari Kontributor Muda', 'lowongan-tim-redaksi-lpp-ipnu-kediri-cari-kontributor-muda-Y38DB', NULL, '<p>Lembaga Pers dan Penerbitan (LPP) PC IPNU Kabupaten Kediri membuka kesempatan bagi kader muda yang memiliki minat di bidang jurnalistik untuk bergabung sebagai kontributor.</p><p><strong>Posisi yang dibutuhkan:</strong></p><ul><li>Reporter Lapangan (5 orang)</li><li>Penulis Opini (3 orang)</li><li>Fotografer/Videografer (3 orang)</li><li>Editor Konten (2 orang)</li></ul><p><strong>Syarat:</strong></p><ul><li>Kader aktif IPNU/IPPNU</li><li>Memiliki kemampuan menulis yang baik</li><li>Bersedia mengikuti pelatihan jurnalistik dasar</li><li>Mampu bekerja dalam deadline</li></ul><p>Kirim CV dan portofolio ke email: lpp@ipnuippnukediri.or.id paling lambat 25 April 2026.</p>', 'Lembaga Pers dan Penerbitan (LPP) IPNU Kediri membuka rekrutmen kontributor muda untuk mengisi konten portal berita DASI Pelajar.', 167, NULL, 'Published', 0, '2026-03-14', '2026-03-18 02:47:08', '2026-03-18 02:47:08'),
(17, 7, 'berita', 'use001', 'Turnamen Futsal Santri Cup 2026: PAC Pare Juara Bertahan', 'turnamen-futsal-santri-cup-2026-pac-pare-juara-bertahan-uiZm2', NULL, '<p>PAC IPNU Pare berhasil mempertahankan gelar juara dalam Turnamen Futsal Santri Cup 2026 yang diselenggarakan oleh Departemen Seni, Budaya, dan Olahraga PC IPNU Kabupaten Kediri.</p><p>Pertandingan final yang berlangsung seru di GOR Kecamatan Gampengrejo pada Minggu, 2 Maret 2026, berakhir dengan kemenangan PAC Pare atas PAC Gurah dengan skor 4-2.</p><p>Turnamen yang diikuti oleh 24 tim dari PAC se-Kabupaten Kediri ini berlangsung selama dua pekan dengan sistem gugur. Selain gelar juara, panitia juga memberikan penghargaan pemain terbaik dan pencetak gol terbanyak.</p><p>\"Olahraga adalah media yang efektif untuk mempererat ukhuwah antar kader dari berbagai PAC,\" ujar Koordinator Departemen Seni, Budaya, dan Olahraga.</p>', 'PAC IPNU Pare berhasil mempertahankan gelar juara Turnamen Futsal Santri Cup setelah mengalahkan PAC Gurah di final dengan skor 4-2.', 267, NULL, 'Published', 0, '2026-03-02', '2026-03-18 02:47:08', '2026-03-18 02:47:08'),
(18, 7, 'berita', 'use001', 'Fun Run 5K Hari Jadi IPNU: Ratusan Kader Berlari untuk Kebersamaan', 'fun-run-5k-hari-jadi-ipnu-ratusan-kader-berlari-untuk-kebersamaan-N6AE6', NULL, '<p>Dalam rangka memperingati Harlah IPNU ke-72, PC IPNU Kabupaten Kediri menyelenggarakan Fun Run 5K pada Minggu pagi, 24 Februari 2026.</p><p>Sebanyak 300 peserta yang terdiri dari kader aktif, alumni, dan simpatisan mengikuti rute yang dimulai dari Alun-alun Kabupaten Kediri, melewati beberapa landmark kota, dan berakhir di titik start.</p><p>Acara dimeriahkan dengan doorprize, senam bersama, dan penampilan musik akustik dari kader-kader berbakat.</p>', 'Memperingati Hari Lahir IPNU ke-72, ratusan kader mengikuti Fun Run 5K yang berlangsung meriah di pusat kota Kediri.', 189, NULL, 'Published', 0, '2026-02-24', '2026-03-18 02:47:08', '2026-03-18 02:47:08'),
(19, 3, 'berita', 'use001', 'Workshop Desain Grafis untuk Pengurus Media IPNU IPPNU Se-Kabupaten Kediri', 'workshop-desain-grafis-untuk-pengurus-media-ipnu-ippnu-se-kabupaten-kediri-WaSV2', NULL, '<p>Departemen Media dan Digitalisasi Organisasi PC IPPNU berkolaborasi dengan LPP PC IPNU Kabupaten Kediri menyelenggarakan Workshop Desain Grafis pada Sabtu, 15 Februari 2026.</p><p>Workshop yang diikuti oleh perwakilan pengurus media dari 26 PAC ini membahas teknik desain menggunakan Canva Pro dan Figma untuk keperluan publikasi organisasi.</p><p>Materi meliputi pembuatan poster kegiatan, infografis data organisasi, template media sosial, serta tips personal branding digital untuk organisasi.</p>', 'Departemen Media IPPNU berkolaborasi dengan LPP IPNU mengadakan workshop desain grafis menggunakan Canva dan Figma untuk pengurus media di setiap PAC.', 143, NULL, 'Published', 0, '2026-02-15', '2026-03-18 02:47:08', '2026-03-18 02:47:08'),
(20, 3, 'berita', 'use001', 'Bakti Sosial IPNU IPPNU di Panti Asuhan Yatim Piatu Al-Hikmah Kediri', 'bakti-sosial-ipnu-ippnu-di-panti-asuhan-yatim-piatu-al-hikmah-kediri-rHcIy', NULL, '<p>PC IPNU IPPNU Kabupaten Kediri mengadakan kegiatan bakti sosial di Panti Asuhan Yatim Piatu Al-Hikmah, Kecamatan Ngadiluwih, pada Minggu, 9 Februari 2026.</p><p>Sebanyak 40 kader mengunjungi panti tersebut dengan membawa donasi berupa perlengkapan sekolah, buku bacaan, pakaian layak pakai, dan bahan makanan pokok.</p><p>Selain menyerahkan donasi, para kader juga mengadakan berbagai kegiatan bersama anak-anak panti, termasuk bimbingan belajar, permainan edukatif, dan sesi storytelling.</p>', 'Puluhan kader IPNU IPPNU mengunjungi Panti Asuhan Al-Hikmah membawa donasi dan mengadakan kegiatan edukatif bersama anak-anak panti.', 112, NULL, 'Published', 0, '2026-02-09', '2026-03-18 02:47:08', '2026-03-18 02:47:08'),
(21, 3, 'berita', 'use001', 'Pelatihan Jurnalistik Pelajar NU: Mengasah Nalar Kritis di Era Digital', 'pelatihan-jurnalistik-pelajar-nu-mengasah-nalar-kritis-di-era-digital-zXlWT', NULL, '<p>Lembaga Pers dan Penerbitan (LPP) PC IPNU Kabupaten Kediri menggelar Pelatihan Jurnalistik Pelajar NU pada Sabtu-Minggu, 1-2 Februari 2026, di Gedung PCNU Kabupaten Kediri.</p><p>Pelatihan yang diikuti oleh 80 kader muda dari berbagai PAC ini menghadirkan narasumber dari kalangan jurnalis profesional dan akademisi komunikasi.</p><p>Materi yang disampaikan meliputi teknik penulisan berita, etika jurnalistik, fotografi dasar, pengelolaan media sosial organisasi, serta literasi media dan cara menangkal hoaks.</p><p>\"Di era informasi ini, setiap kader harus punya kemampuan dasar jurnalistik untuk bisa menyaring dan menyebarkan informasi yang benar,\" tegas Koordinator LPP.</p>', 'LPP IPNU Kediri menggelar pelatihan jurnalistik dasar bagi 80 kader muda dari berbagai PAC untuk meningkatkan kemampuan literasi media.', 156, NULL, 'Published', 0, '2026-02-01', '2026-03-18 02:47:08', '2026-03-18 02:47:08'),
(22, 5, 'berita', 'use001', 'Safari Dakwah Ramadan: IPNU IPPNU Keliling 26 Kecamatan', 'safari-dakwah-ramadan-ipnu-ippnu-keliling-26-kecamatan-G2yBK', NULL, '<p>Menyambut bulan suci Ramadan 1447 H, PC IPNU IPPNU Kabupaten Kediri meluncurkan program Safari Dakwah Ramadan yang akan mengunjungi seluruh 26 kecamatan di Kabupaten Kediri.</p><p>Program ini menugaskan kader-kader muda yang telah terlatih sebagai penceramah untuk mengisi kegiatan-kegiatan keagamaan di musholla dan masjid selama bulan Ramadan.</p><p>\"Ini adalah bentuk kontribusi nyata organisasi kepada masyarakat sekaligus wadah bagi kader untuk mengasah kemampuan dakwah mereka,\" ujar Koordinator Departemen Dakwah.</p>', 'Program Safari Dakwah Ramadan menyasar seluruh kecamatan di Kabupaten Kediri dengan menghadirkan penceramah muda dari kalangan kader.', 198, NULL, 'Published', 0, '2026-03-12', '2026-03-18 02:47:08', '2026-03-18 02:47:08'),
(23, 2, 'opini', 'use001', 'Digitalisasi Organisasi: Bukan Sekedar Gaya, Tapi Kebutuhan', 'digitalisasi-organisasi-bukan-sekedar-gaya-tapi-kebutuhan-HojNn', NULL, '<p>Ketika PC IPNU IPPNU Kabupaten Kediri memutuskan untuk membangun platform DASI Pelajar, tidak sedikit yang bertanya: \"Memangnya perlu?\"</p><p>Jawabannya sederhana: <strong>sangat perlu</strong>. Bayangkan mengelola data ribuan kader di 26 kecamatan hanya dengan buku tulis dan spreadsheet. Bayangkan mengkoordinasikan ratusan kegiatan tanpa sistem terpusat. Bayangkan memverifikasi kehadiran rapat 200 orang dengan absensi kertas.</p><p>Digitalisasi organisasi bukan tentang mengikuti tren teknologi. Ini tentang efisiensi, akuntabilitas, dan keberlanjutan. Pengurus berganti setiap dua tahun — tanpa sistem digital, pengetahuan dan data organisasi ikut pergi bersama pengurus lama.</p><p>DASI Pelajar adalah jawaban untuk masalah ini. Sebuah sistem yang memastikan kontinuitas organisasi melampaui pergantian kepengurusan.</p>', 'Mengapa transformasi digital bukan pilihan tapi keharusan bagi organisasi kepemudaan seperti IPNU IPPNU untuk tetap relevan dan efektif.', 234, NULL, 'Published', 0, '2026-03-09', '2026-03-18 02:47:08', '2026-03-18 02:47:08'),
(24, 3, 'foto', 'use001', 'Galeri Foto: Suasana Rakercab PC IPNU IPPNU Kediri 2026', 'galeri-foto-suasana-rakercab-pc-ipnu-ippnu-kediri-2026-1mjhv', NULL, '<p>Berikut dokumentasi foto kegiatan Rakercab PC IPNU IPPNU Kabupaten Kediri yang berlangsung pada 15-16 Maret 2026 di Aula Gedung NU Kabupaten Kediri.</p><p>Kegiatan dihadiri lebih dari 200 delegasi dari 26 PAC se-Kabupaten Kediri. Suasana berlangsung penuh semangat dan antusiasme dari seluruh peserta.</p><p><em>Foto oleh: Tim Dokumentasi LPP PC IPNU Kediri</em></p>', 'Kumpulan foto dokumentasi kegiatan Rapat Kerja Cabang PC IPNU IPPNU Kabupaten Kediri yang berlangsung meriah selama dua hari.', 99, NULL, 'Published', 0, '2026-03-15', '2026-03-18 02:47:08', '2026-06-16 07:49:47'),
(25, 3, 'berita', 'use001', 'LEKAS IPNU Kediri Gelar Bazar Ekonomi Kreatif Santri', 'lekas-ipnu-kediri-gelar-bazar-ekonomi-kreatif-santri-TJQmX', NULL, '<p>Lembaga Ekonomi, Kewirausahaan, dan Koperasi (LEKAS) PC IPNU Kabupaten Kediri menyelenggarakan Bazar Ekonomi Kreatif Santri pada Sabtu-Minggu, 22-23 Februari 2026, di halaman Masjid Agung Kediri.</p><p>Bazar yang diikuti oleh 30 UMKM dari kalangan santri dan pelajar ini menampilkan berbagai produk mulai dari makanan olahan, kerajinan tangan, fashion muslim, hingga produk digital.</p><p>\"Kami ingin menunjukkan bahwa santri dan pelajar NU juga punya potensi ekonomi yang luar biasa,\" ujar Koordinator LEKAS.</p>', 'Lembaga Ekonomi dan Kewirausahaan (LEKAS) IPNU Kediri menyelenggarakan bazar yang menampilkan produk-produk UMKM dari kalangan santri dan pelajar.', 145, NULL, 'Published', 0, '2026-02-22', '2026-03-18 02:47:08', '2026-03-18 02:47:08'),
(26, 3, 'berita', 'use001', 'Konseling Pelajar Putri: IPPNU Buka Layanan Curhat Anonim Online', 'konseling-pelajar-putri-ippnu-buka-layanan-curhat-anonim-online-aeAo1', NULL, '<p>Lembaga Konseling Pelajar Putri PC IPPNU Kabupaten Kediri meluncurkan layanan konseling anonim online melalui platform digital pada Senin, 10 Februari 2026.</p><p>Layanan ini bertujuan menyediakan ruang aman bagi pelajar putri untuk berkonsultasi mengenai berbagai permasalahan, mulai dari masalah akademik, keluarga, pertemanan, hingga kesehatan mental.</p><p>Tim konselor terdiri dari kader IPPNU yang telah mengikuti pelatihan konseling dasar serta didampingi oleh psikolog profesional sebagai supervisor.</p>', 'Lembaga Konseling Pelajar Putri IPPNU meluncurkan layanan konseling anonim online untuk membantu pelajar putri yang menghadapi masalah.', 178, NULL, 'Published', 0, '2026-02-10', '2026-03-18 02:47:08', '2026-03-18 02:47:08'),
(27, 3, 'berita', 'use001', 'LAN IPNU Kediri Sosialisasi Bahaya Narkoba di Kalangan Pelajar', 'lan-ipnu-kediri-sosialisasi-bahaya-narkoba-di-kalangan-pelajar-9PxeC', NULL, '<p>Lembaga Anti Narkoba (LAN) PC IPNU Kabupaten Kediri bekerjasama dengan Badan Narkotika Nasional (BNN) Kabupaten Kediri mengadakan rangkaian sosialisasi bahaya narkoba di kalangan pelajar.</p><p>Program yang berlangsung sepanjang bulan Februari 2026 ini menyasar 10 sekolah menengah di Kabupaten Kediri dengan total peserta lebih dari 2.000 pelajar.</p><p>Metode sosialisasi yang digunakan tidak hanya ceramah, tapi juga simulasi, pemutaran film dokumenter, dan diskusi interaktif agar pesan anti-narkoba lebih mudah dipahami oleh kalangan remaja.</p>', 'Lembaga Anti Narkoba (LAN) IPNU Kediri bekerjasama dengan BNN Kabupaten Kediri mengadakan sosialisasi bahaya narkoba di 10 sekolah.', 167, NULL, 'Published', 0, '2026-02-06', '2026-03-18 02:47:08', '2026-03-18 02:47:08');

-- --------------------------------------------------------

--
-- Table structure for table `berita_tag`
--

CREATE TABLE `berita_tag` (
  `berita_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `berita_tag`
--

INSERT INTO `berita_tag` (`berita_id`, `tag_id`) VALUES
(1, 1),
(1, 2),
(1, 10),
(1, 14),
(2, 1),
(2, 2),
(2, 11),
(2, 14),
(3, 1),
(3, 9),
(3, 15),
(4, 2),
(4, 9),
(4, 15),
(5, 1),
(5, 2),
(5, 6),
(5, 14),
(6, 4),
(6, 14),
(6, 18),
(7, 1),
(7, 2),
(7, 3),
(7, 5),
(8, 1),
(8, 3),
(8, 9),
(8, 15),
(9, 3),
(9, 5),
(9, 12),
(9, 19),
(10, 1),
(10, 2),
(10, 5),
(10, 9),
(11, 5),
(11, 12),
(11, 13),
(11, 19),
(12, 4),
(12, 5),
(12, 17),
(13, 4),
(13, 5),
(13, 19),
(14, 1),
(14, 2),
(14, 5),
(14, 16),
(15, 1),
(15, 2),
(15, 10),
(16, 1),
(16, 15),
(16, 19),
(17, 1),
(17, 7),
(17, 14),
(18, 1),
(18, 7),
(18, 14),
(19, 2),
(19, 15),
(19, 19),
(20, 1),
(20, 2),
(20, 6),
(20, 14),
(21, 1),
(21, 5),
(21, 15),
(21, 19),
(22, 1),
(22, 2),
(22, 4),
(22, 17),
(23, 1),
(23, 2),
(23, 19),
(24, 1),
(24, 2),
(24, 10),
(24, 14),
(25, 1),
(25, 13),
(25, 14),
(26, 2),
(26, 5),
(26, 6),
(27, 1),
(27, 5),
(27, 6),
(27, 14);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departemens`
--

CREATE TABLE `departemens` (
  `id` varchar(255) NOT NULL,
  `nama_departemen` varchar(255) NOT NULL,
  `jenis` enum('departemen','lembaga','badan') NOT NULL DEFAULT 'departemen',
  `kategori` enum('IPNU','IPPNU','Joint') NOT NULL DEFAULT 'Joint',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departemens`
--

INSERT INTO `departemens` (`id`, `nama_departemen`, `jenis`, `kategori`, `created_at`, `updated_at`) VALUES
('dep007', 'Organisasi', 'departemen', 'Joint', '2026-01-02 23:25:18', '2026-02-19 09:02:40'),
('dep008', 'Kaderisasi', 'departemen', 'Joint', '2026-01-02 23:25:18', '2026-02-19 09:02:40'),
('dep009', 'DJSP', 'departemen', 'IPNU', '2026-01-02 23:25:18', '2026-02-19 09:02:40'),
('dep010', 'Dakwah', 'departemen', 'Joint', '2026-01-02 23:25:18', '2026-02-19 09:02:40'),
('dep011', 'Desbor', 'departemen', 'Joint', '2026-01-02 23:25:18', '2026-02-19 09:02:40'),
('dep012', 'Jarkom', 'departemen', 'IPPNU', '2026-01-02 23:25:18', '2026-01-02 23:25:18'),
('dep013', 'CBP', 'lembaga', 'IPNU', '2026-01-02 23:25:18', '2026-02-19 09:02:40'),
('dep014', 'PERS', 'lembaga', 'IPNU', '2026-01-02 23:25:18', '2026-02-19 09:02:40'),
('dep015', 'LAN', 'lembaga', 'IPNU', '2026-01-02 23:25:18', '2026-02-19 09:02:40'),
('dep016', 'LEKAS', 'lembaga', 'IPNU', '2026-01-02 23:25:18', '2026-02-19 09:02:40'),
('dep017', 'LKPT', 'lembaga', 'IPNU', '2026-01-02 23:25:18', '2026-02-19 09:02:40'),
('dep018', 'BSRC', 'badan', 'IPNU', '2026-01-02 23:25:18', '2026-02-19 09:02:40'),
('dep019', 'BSCC', 'badan', 'IPNU', '2026-01-02 23:25:18', '2026-02-19 09:02:40'),
('dep020', 'KPP', 'lembaga', 'IPPNU', '2026-01-02 23:25:18', '2026-01-02 23:25:18'),
('dep021', 'LKP', 'lembaga', 'IPPNU', '2026-01-02 23:25:18', '2026-02-19 09:02:40'),
('dep022', 'LKDC', 'lembaga', 'IPPNU', '2026-01-02 23:25:18', '2026-02-19 09:02:40'),
('dep023', 'LEK', 'lembaga', 'IPPNU', '2026-01-02 23:25:18', '2026-02-19 09:02:40'),
('dep024', 'DJSMPP', 'departemen', 'IPPNU', '2026-02-19 09:02:40', '2026-02-19 09:02:40');

-- --------------------------------------------------------

--
-- Table structure for table `dokumen_arsips`
--

CREATE TABLE `dokumen_arsips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `kategori` enum('sk','pedoman','undangan','lainnya') NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_kegiatans`
--

CREATE TABLE `form_kegiatans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kegiatan` varchar(255) NOT NULL,
  `judul_form` varchar(255) DEFAULT NULL,
  `organisasi_id` bigint(20) UNSIGNED DEFAULT NULL,
  `program_kerja_id` varchar(10) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `is_open` tinyint(1) NOT NULL DEFAULT 1,
  `tgl_buka` datetime DEFAULT NULL,
  `tgl_tutup` datetime DEFAULT NULL,
  `custom_fields` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`custom_fields`)),
  `link_sukses` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `form_kegiatans`
--

INSERT INTO `form_kegiatans` (`id`, `nama_kegiatan`, `judul_form`, `organisasi_id`, `program_kerja_id`, `slug`, `is_open`, `tgl_buka`, `tgl_tutup`, `custom_fields`, `link_sukses`, `created_at`, `updated_at`) VALUES
(1, 'LAKUT', 'PENDAFTARAN LAKUT', NULL, 'proker002', 'lakut-qwu0j', 1, '2026-03-27 13:11:00', '2026-04-30 13:11:00', '[{\"label\":\"test\",\"type\":\"text\",\"required\":true,\"options\":\"\"},{\"label\":\"test\",\"type\":\"text\",\"required\":false,\"options\":\"\"},{\"label\":\"tetetetet\",\"type\":\"text\",\"required\":false,\"options\":\"\"},{\"label\":\"tewtetwe\",\"type\":\"textarea\",\"required\":false,\"options\":\"\"},{\"label\":\"etwetwetwet\",\"type\":\"number\",\"required\":false,\"options\":\"\"},{\"label\":\"wetwetwetwe\",\"type\":\"select\",\"required\":false,\"options\":\"satu,dua,tiga\"},{\"label\":\"esgsdgsdg\",\"type\":\"file\",\"required\":false,\"options\":\"\"}]', 'https://monkeytype.com/', '2026-03-27 23:12:42', '2026-04-20 07:15:04');

-- --------------------------------------------------------

--
-- Table structure for table `hero_sliders`
--

CREATE TABLE `hero_sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul_utama` varchar(255) DEFAULT NULL,
  `sub_judul` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `gambar_path` varchar(255) NOT NULL,
  `link_tombol` varchar(255) DEFAULT NULL,
  `teks_tombol` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `show_button` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hero_sliders`
--

INSERT INTO `hero_sliders` (`id`, `judul_utama`, `sub_judul`, `label`, `gambar_path`, `link_tombol`, `teks_tombol`, `is_active`, `urutan`, `created_at`, `updated_at`, `show_button`) VALUES
(6, 'test', 'wweee', 'wewewewewe', 'sliders/VCGoEcj8wX7sYsP6HhLiOANvkVrMvDc7f1dYIJiO.jpg', NULL, NULL, 1, 1, '2026-03-19 08:19:56', '2026-06-15 22:43:12', 1),
(7, 'weqeqweqwe', 'eeee', '123123123', 'sliders/tijSRsyn46iRHXzqHhirY2M3HBjaBg11dYR1l2J5.jpg', 'https://youtube.com/', NULL, 1, 2, '2026-03-19 08:20:43', '2026-03-19 08:20:43', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inventaris`
--

CREATE TABLE `inventaris` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `kondisi` enum('baik','rusak_ringan','rusak_berat') NOT NULL,
  `tgl_pengadaan` date NOT NULL,
  `sumber_dana` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) NOT NULL,
  `foto_barang` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventaris`
--

INSERT INTO `inventaris` (`id`, `nama_barang`, `kode_barang`, `kondisi`, `tgl_pengadaan`, `sumber_dana`, `lokasi`, `foto_barang`, `created_at`, `updated_at`) VALUES
(1, 'printer', '911', 'baik', '2026-02-20', NULL, 'kantor', NULL, '2026-02-20 00:32:00', '2026-02-20 00:32:00');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kaders`
--

CREATE TABLE `kaders` (
  `id` varchar(255) NOT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `foto_path` varchar(255) DEFAULT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `alamat_jalan` varchar(255) DEFAULT NULL,
  `dusun` varchar(255) DEFAULT NULL,
  `desa` varchar(255) DEFAULT NULL,
  `kecamatan` varchar(255) DEFAULT NULL,
  `kabupaten` varchar(255) DEFAULT 'Kediri',
  `no_hp` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `quote` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kaders`
--

INSERT INTO `kaders` (`id`, `nik`, `nama_lengkap`, `foto_path`, `tempat_lahir`, `tgl_lahir`, `jenis_kelamin`, `alamat_jalan`, `dusun`, `desa`, `kecamatan`, `kabupaten`, `no_hp`, `created_at`, `updated_at`, `quote`) VALUES
('kdr001', '1.54E+15', 'Muhammad Bangkit Ali Wafa', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81223344556', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Pelajar NU harus cerdas, kritis, dan berakhlak mulia.'),
('kdr002', '3.51E+16', 'Airulanang Lambang F', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '-', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Bersama kita bisa membangun organisasi yang lebih kuat.'),
('kdr003', '3.11E+15', 'Muhammad Yahya Nuril Anwar', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '-', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Kaderisasi adalah nafas organisasi.'),
('kdr004', '4.11E+15', 'Muhamat Miftahul Huda', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390505', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Ikhtiar maksimal, tawakkal sepenuhnya.'),
('kdr005', '5.11E+15', 'Mohammad Septian Zulkarnain', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390506', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Pelajar yang baik adalah yang bermanfaat bagi sesama.'),
('kdr006', '6.11E+15', 'M. Khoirul Ibad', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390507', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Iman, ilmu, dan amal — tiga pilar kader NU.'),
('kdr007', '7.11E+15', 'Moch. Irfan Wahyudi', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390508', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Administrasi yang rapi adalah cermin organisasi yang sehat.'),
('kdr008', '8.11E+15', 'M. Farkhan Fahmi Zuhri', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390509', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Setiap langkah kecil menuju tujuan besar.'),
('kdr009', '9.11E+15', 'Hilman Nuriel Mustafa', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390510', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Jaga semangat, jaga ukhuwah.'),
('kdr010', '1.01E+16', 'Krisna Putra Aji Purnama', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390511', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Disiplin adalah kunci kesuksesan organisasi.'),
('kdr011', '1.11E+16', 'Much. Zaenal Fanani', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390512', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr012', '1.21E+16', 'M. Syahrul Ahmal', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390513', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr013', '1.31E+16', 'M. Sukron Akbar Ridhoi', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390514', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Transparansi keuangan adalah amanah.'),
('kdr014', '1.41E+16', 'M. Ubaidillah', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390515', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Hemat pangkal kuat, teliti pangkal tepat.'),
('kdr015', '1.51E+16', 'Moh. Khoiru Rosyadi', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390516', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr016', '1.61E+16', 'M Yunan Hilmy', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390517', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr017', '1.71E+16', 'Hoego Nelsa Dhewa', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390518', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr018', '1.81E+16', 'Miftahul Kafi', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390519', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr019', '1.91E+16', 'Akhmad Wildan Baehaqi', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390520', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr020', '2.01E+16', 'M. Sandi Nur Huda', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390521', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr021', '2.11E+16', 'Irsyad Zainun N', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390522', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Satu tekad, satu langkah bersama.'),
('kdr022', '2.21E+16', 'M Firman Tauhid', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390523', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr023', '2.31E+16', 'Mokhamad Ilham Maulana', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390524', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr024', '2.41E+16', 'M Syahrul Munir', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390525', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr025', '2.51E+16', 'Al Zamzami Bahrur Rizky', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390526', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr026', '2.61E+16', 'M Misbachul Munir', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390527', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr027', '2.71E+16', 'Ilham Fadila', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390528', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr028', '2.81E+16', 'Rizky Bekti Setiawan', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390529', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr029', '2.91E+16', 'Ahmad Kharish Fauzan', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390530', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Kontribusi nyata lebih bermakna dari sekedar wacana.'),
('kdr030', '3.01E+16', 'Faisal Aji Setya Ramadani', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390531', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr031', '3.11E+16', 'Rudi Prasetyo', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390532', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Siap bergerak untuk organisasi dan umat.'),
('kdr032', '3.21E+16', 'Lukman Hakim', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390533', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Dengan ilmu kita maju, dengan iman kita kokoh.'),
('kdr033', '3.31E+16', 'Fayakun Anhar Prayogo', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390534', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr034', '3.41E+16', 'Roni Dwi Firnanda', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390535', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Pengabdian terbaik adalah yang memberi dampak nyata.'),
('kdr036', '3.61E+16', 'Muhammad Radit Raf Sanjani', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390537', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Amanah itu berat, tapi itulah yang membuatnya bermakna.'),
('kdr037', '3.71E+16', 'Iman Ihfanadi Afka Assalamy', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390538', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr038', '3.81E+16', 'M Maksum Falaki', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390539', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr039', '3.91E+16', 'M. Tajul Muluk', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390540', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr040', '4.01E+16', 'Muhamad Solihin', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390541', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr041', '4.11E+16', 'Muhammad Wildan Azizi', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390542', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Pelajar militan adalah harapan bangsa.'),
('kdr042', '4.21E+16', 'Niko Ardiawan', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390543', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr043', '4.31E+16', 'Rizky Tegar Adigdiya', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390544', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr044', '4.41E+16', 'M. Badrus', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390545', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Berjuang tanpa lelah, bekerja tanpa pamrih.'),
('kdr045', '4.51E+16', 'Mohamad Arif', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390546', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr046', '4.61E+16', 'Chafidz Nur Asy’ari', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390547', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr047', '4.71E+16', 'Ferry Efendi', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390548', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr048', '4.81E+16', 'Mohammad Sibtu Mubarok', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390549', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr049', '4.91E+16', 'M. Ilham Harits Al Fairus', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390550', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr050', '5.01E+16', 'Moh. Hadziq Maulana Rohman', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390551', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr051', '5.11E+16', 'M Faizul Fathoni', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390552', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr052', '5.21E+16', 'Muhammad Miftahur Rohman', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390553', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Disiplin, tegas, dan bertanggung jawab.'),
('kdr053', '5.31E+16', 'Mohammad Reno Nur Renata', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390554', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr054', '5.41E+16', 'Nicky Arianda Armanda', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390555', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr055', '5.51E+16', 'Muhammad Syukron Ma\'mun', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390556', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr056', '5.61E+16', 'Robin Tri Aprilianto', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390557', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr057', '5.71E+16', 'M. Nafingudin', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390558', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr058', '5.81E+16', 'Hariyanto', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390559', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr059', '5.91E+16', 'Rizal Zusli Qusaini', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390560', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr060', '6.01E+16', 'Riski Pandu Winata', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390561', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr061', '6.11E+16', 'Nandhito Okta Pratama', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390562', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Riset dan inovasi untuk kejayaan pelajar NU.'),
('kdr062', '6.21E+16', 'Saifudin Zuhri', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390563', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr063', '6.31E+16', 'Moh. Sobirin', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390564', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr064', '6.41E+16', 'Leonardo Eko kistio Nugroho', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390565', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr065', '6.51E+16', 'Ahmad Khoirul Arifin', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390566', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr066', '6.61E+16', 'As\'ad Ibnu Fajar', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390567', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr067', '6.71E+16', 'Emil Tri Ilham', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390568', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr068', '6.81E+16', 'M. Syauqi Hilmi Muntaha', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390569', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr069', '6.91E+16', 'Benny Prilanzareza', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390570', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr070', '7.01E+16', 'Moh. Dai Robi', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390571', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr071', '7.11E+16', 'Catur Hariyono', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390572', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr072', '7.21E+16', 'Haffana Rohman', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390573', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr073', '7.31E+16', 'M. Faza Fi Kaunaini', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390574', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr074', '7.41E+16', 'Fahrul Rizal Muhaimin', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390575', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr075', '7.51E+16', 'Budi Darmawan', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390576', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr076', '7.61E+16', 'Affan Maula Izzy', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390577', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr077', '7.71E+16', 'Agus Setiawan', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390578', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Seni dan budaya adalah identitas bangsa yang harus dijaga.'),
('kdr078', '7.81E+16', 'Krisna Andrean', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390579', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Dakwah itu merangkul, bukan memukul.'),
('kdr079', '7.91E+16', 'Jibril Adam Faizuna', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390580', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr080', '8.01E+16', 'Muhammad Kusnul Khulud', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390581', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Tulis, sebarkan, dan jadikan berita sebagai alat perubahan.'),
('kdr081', '8.11E+16', 'Agna Ismed Hubail', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390582', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr082', '8.21E+16', 'Fajar Romadhon', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390583', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr083', '8.31E+16', 'Moch Faizul Muttaqin', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390584', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr084', '8.41E+16', 'Muhsin Fathar Rohman', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390585', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr085', '8.51E+16', 'Ikhwan Rosadi', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390586', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr086', '8.61E+16', 'Muhammad Yusuf', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390587', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr087', '8.71E+16', 'Wisnu Aji Sasongko', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390588', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr088', '8.81E+16', 'Fajar Adi Kurniawan', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390589', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr089', '8.91E+16', 'Ahmad Soli', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390590', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr090', '9.01E+16', 'Biliona Syakura Ahmad', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390591', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr091', '9.11E+16', 'Malvin Nugroho', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390592', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr092', '9.21E+16', 'Ahmad Yusuf Prayogi', NULL, 'KEDIRI', '0000-00-00', 'L', NULL, NULL, '-', '-', 'Kediri', '81358390593', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr093', '9.31E+16', 'Defina Erjuniar', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390594', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr094', '9.41E+16', 'Neisya Previ Ayu Nur Hidayah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390595', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr095', '9.51E+16', 'Sinta Amanatul Khoiriyah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390596', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr096', '9.61E+16', 'Ainul Mardziyah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390597', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr097', '9.71E+16', 'Mita Dwi Rizqi Alfiyah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390598', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr098', '9.81E+16', 'Devi Aryanti', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390599', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr099', '9.91E+16', 'Intan Mar\'atus Sholikhah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390600', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr100', '1.00E+17', 'Adinda Khusnul Khotimah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390601', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr101', '1.01E+17', 'Vina Insanul Kamelia', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390602', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr102', '1.02E+17', 'Redista Nazriana', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390603', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr103', '1.03E+17', 'Khoirun Nisa\'', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390604', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr104', '1.04E+17', 'Binti Khasanatun Nisa\'', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390605', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr105', '1.05E+17', 'Cinta Ananda Putri R.', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390606', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr106', '1.06E+17', 'Dian Luluk Isrotin', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390607', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr107', '1.07E+17', 'Miftahul Hasanah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390608', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr108', '1.08E+17', 'Vivi Alaida Najihatul Fadliyah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390609', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr109', '1.09E+17', 'Warda Rifa\'atul Khusna', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390610', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr110', '1.10E+17', 'Sayyidah Cahya Nengrum', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390611', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr111', '1.11E+17', 'Linna Fitria', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390612', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr112', '1.12E+17', 'Masda Nur Asna', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390613', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr113', '1.13E+17', 'Serly Imranian Syah Putri', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390614', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr114', '1.14E+17', 'Diawati Sri Nur Indah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390615', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr115', '1.15E+17', 'Zidni Ilma Nafi\'a', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390616', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr116', '1.16E+17', 'Siti Rukmananingsih Agustina', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390617', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr117', '1.17E+17', 'Wardatus Sa\'aadah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390618', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr118', '1.18E+17', 'Indah Sulistiyo Ningsih', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390619', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr119', '1.19E+17', 'Sephiananta Fatimatus Sya’baniyah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390620', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr120', '1.20E+17', 'Firza Waliyyani Rimanda', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390621', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr121', '1.21E+17', 'Deni Novita Sari', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390622', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr122', '1.22E+17', 'Fatma Abizza', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390623', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr123', '1.23E+17', 'Risma Nur Aini', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390624', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr124', '1.24E+17', 'Dwi Nur Afika', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390625', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr125', '1.25E+17', 'Yohana Nailal Muna', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390626', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr126', '1.26E+17', 'Arifatul Khasanah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390627', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr127', '1.27E+17', 'Silvi Nur Aini', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390628', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr128', '1.28E+17', 'Septi Lusiana Putri', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390629', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr129', '1.29E+17', 'Annisa Fazhira Devina', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390630', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr130', '1.30E+17', 'Khotim Putri Nurjanah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390631', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr131', '1.31E+17', 'Iin Rizka Amalia', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390632', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr132', '1.32E+17', 'Dewi Asviau Rohmah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390633', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr133', '1.33E+17', 'Risky Nor Azizah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390634', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr134', '1.34E+17', 'Anis Ulwiyatun Ni\'mah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390635', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr135', '1.35E+17', 'Inayatul Fardhiyah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390636', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr136', '1.36E+17', 'Zahratun Nafi’ah R. J', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390637', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr137', '1.37E+17', 'Fadhila Rizkiayuli', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390638', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr138', '1.38E+17', 'Puspita Amelia', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390639', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr139', '1.39E+17', 'Faradila Novia Ananta', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390640', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr140', '1.40E+17', 'Nurul Rohmatul Abidah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390641', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr141', '1.41E+17', 'Aghitsna Rahma Husnaya A.', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390642', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr142', '1.42E+17', 'Pratiwi Zainur Rochimah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390643', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr143', '1.43E+17', 'Lingga Nur Fu’ana', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390644', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr144', '1.44E+17', 'Nailya Putri Rahma Sari', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390645', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr145', '1.45E+17', 'Elok Himmatul Aliyah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390646', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr146', '1.46E+17', 'Abida Khoirunisa\'', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390647', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr147', '1.47E+17', 'Nabilla Awalina', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390648', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr148', '1.48E+17', 'Hesti Meriastina', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390649', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr149', '1.49E+17', 'Pingki Ismasari', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390650', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr150', '1.50E+17', 'Nisaul fauziyah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390651', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr151', '1.51E+17', 'Oktaelvira Putri Prayitno', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390652', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr152', '1.52E+17', 'Lailatul Maskurun', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390653', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr153', '1.53E+17', 'Ayu Dwi Lestari', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390654', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr154', '1.54E+17', 'Deshinta Nuraini Zhuan Alifian', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390655', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr155', '1.55E+17', 'Yhanik Wahyuning I.', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390656', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr156', '1.56E+17', 'Lailatul Fitri', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390657', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr157', '1.57E+17', 'Miftahul \'Abdiyah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390658', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr158', '1.58E+17', 'Yulia Nuraini', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390659', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr159', '1.59E+17', 'Riska Eliana', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390660', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr160', '1.60E+17', 'Aminah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390661', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr161', '1.61E+17', 'Anita Nur Atika', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390662', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr162', '1.62E+17', 'Zalfa\'zain Aqillah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390663', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr163', '1.63E+17', 'Prihatna Suci Lambangsary', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390664', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr164', '1.64E+17', 'Fitria Alfia Rochmah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390665', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr165', '1.65E+17', 'Sholeli Unka Ababila', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390666', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr166', '1.66E+17', 'Nova Ulfah Sari', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390667', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr167', '1.67E+17', 'Siti Nur Syafaatin', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390668', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr168', '1.68E+17', 'Faizatul Ainiyah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390669', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr169', '1.69E+17', 'Ridha Amaliana', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390670', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr170', '1.70E+17', 'Nia Wulansari', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390671', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr171', '1.71E+17', 'Rizka Alifia Ramadhani', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390672', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr172', '1.72E+17', 'Hani Ro\'ifatul Khasanah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390673', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr173', '1.73E+17', 'Anggun Dwi Rana', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390674', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr174', '1.74E+17', 'Binti Roissatun Nafiah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390675', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr175', '1.75E+17', 'Nikmah Lailatus Sholichah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390676', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr176', '1.76E+17', 'Clora Janika Putri', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390677', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr177', '1.77E+17', 'Putri Nur Rahma', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390678', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr178', '1.78E+17', 'Triana Puji Rahayu', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390679', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr179', '1.79E+17', 'Mutimatul Fadlilah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390680', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr180', '1.80E+17', 'Hanis Ramadhani', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390681', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr181', '1.81E+17', 'Firdausi Nuzula', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390682', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr182', '1.82E+17', 'Husna Rahmawati', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390683', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr183', '1.83E+17', 'Siti Faridatul Wachidah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390684', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr184', '1.84E+17', 'Sinta Nur Azizah', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390685', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr185', '3.506E+16', 'Iqlima Nuril Aulia', NULL, 'KEDIRI', '0000-00-00', 'P', NULL, NULL, '-', '-', 'Kediri', '81358390686', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
('kdr186', '698020', 'bangkit', NULL, NULL, NULL, 'L', NULL, NULL, NULL, NULL, 'Kediri', NULL, '2026-02-19 09:43:50', '2026-02-19 09:43:50', NULL),
('kdr187', '171768', 'buwangket', NULL, NULL, NULL, 'L', NULL, NULL, NULL, NULL, 'Kediri', NULL, '2026-02-19 10:05:12', '2026-02-19 10:05:12', NULL),
('kdr188', '354981', 'irsya', NULL, NULL, NULL, 'L', NULL, NULL, NULL, NULL, 'Kediri', NULL, '2026-02-20 00:08:10', '2026-02-20 00:08:10', NULL),
('kdr189', NULL, 'Nur Azizah Fitriani', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-17 21:56:01', '2026-03-17 21:56:01', 'Perempuan yang kuat adalah perempuan yang terus belajar.'),
('kdr190', NULL, 'Siti Maimunah', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-17 21:56:01', '2026-03-17 21:56:01', 'Berdaya, berprestasi, berakhlak mulia.'),
('kdr191', NULL, 'Lailatul Qomariyah', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-17 21:56:01', '2026-03-17 21:56:01', ''),
('kdr192', NULL, 'Dewi Masithoh', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-17 21:56:01', '2026-03-17 21:56:01', 'Organisasi adalah sekolah kehidupan terbaik.'),
('kdr193', NULL, 'Rizky Amalia Putri', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-17 21:56:01', '2026-03-17 21:56:01', ''),
('kdr194', NULL, 'Faridatul Ulfah', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-17 21:56:01', '2026-03-17 21:56:01', 'Lillah, ikhlas berjuang untuk sesama.'),
('kdr195', NULL, 'Nila Rohmatus Sholihah', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-17 21:56:01', '2026-03-17 21:56:01', ''),
('kdr196', NULL, 'Ainun Jariyah', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-17 21:56:01', '2026-03-17 21:56:01', 'Maju bersama, tumbuh bersama.'),
('kdr197', NULL, 'Khoirunnisa Rahmawati', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-17 21:56:01', '2026-03-17 21:56:01', ''),
('kdr198', NULL, 'Umi Hanik', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-17 21:56:01', '2026-03-17 21:56:01', 'Pelajar putri NU: cerdas, tangguh, berakhlak.'),
('kdr199', NULL, 'Zulaikha Nurfadhilah', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-17 21:56:01', '2026-03-17 21:56:01', ''),
('kdr200', NULL, 'Maulida Hasanah', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-17 21:56:01', '2026-03-17 21:56:01', 'Ilmu dan amal, dua sayap untuk terbang.'),
('kdr201', NULL, 'Siti Nurhaliza', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', 'Berkarya dalam kebersamaan.'),
('kdr202', NULL, 'Fitri Rahmawati', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', 'Digital untuk dakwah, media untuk umat.'),
('kdr203', NULL, 'Aisyah Putri Nabila', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', ''),
('kdr204', NULL, 'Dian Safitri', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', 'Seni adalah ekspresi jiwa.'),
('kdr205', NULL, 'Laila Nur Aini', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', ''),
('kdr206', NULL, 'Risa Amelia', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', ''),
('kdr207', NULL, 'Intan Permatasari', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', 'Amanah adalah tanggung jawab.'),
('kdr208', NULL, 'Nurul Hidayah', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', ''),
('kdr209', NULL, 'Salsabila Azzahra', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', ''),
('kdr210', NULL, 'Anisa Rahma', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', 'Organisasi mengajarkan arti tanggung jawab.'),
('kdr211', NULL, 'Putri Wulandari', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', ''),
('kdr212', NULL, 'Naila Husna', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', 'Jaringan yang kuat, organisasi yang kokoh.'),
('kdr213', NULL, 'Halimatus Sadiyah', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', ''),
('kdr214', NULL, 'Lutfiana Dewi', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', 'Seni budaya cerminan peradaban.'),
('kdr215', NULL, 'Maharani Putri', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', ''),
('kdr216', NULL, 'Zahra Aulia', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', ''),
('kdr217', NULL, 'Safira Indah', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', ''),
('kdr218', NULL, 'Ayu Lestari', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', ''),
('kdr219', NULL, 'Nadia Fitriana', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', ''),
('kdr220', NULL, 'Bella Oktaviani', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', ''),
('kdr221', NULL, 'Citra Dewi', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', ''),
('kdr222', NULL, 'Rina Agustina', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', 'KPP: pelajar putri tangguh dan mandiri.'),
('kdr223', NULL, 'Yuni Kartika', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', 'Mendengarkan adalah kunci konseling.'),
('kdr224', NULL, 'Mega Silvia', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', 'Ekonomi kreatif untuk kemandirian.'),
('kdr225', NULL, 'Dewi Lailatul Badriyah', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', ''),
('kdr226', NULL, 'Hana Pertiwi', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', ''),
('kdr227', NULL, 'Sari Melati', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', ''),
('kdr228', NULL, 'Indri Wahyuni', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', ''),
('kdr229', NULL, 'Ratna Sari', NULL, 'Kediri', NULL, 'P', NULL, NULL, '-', '-', 'Kediri', NULL, '2026-03-18 08:10:13', '2026-03-18 08:10:13', '');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_beritas`
--

CREATE TABLE `kategori_beritas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_beritas`
--

INSERT INTO `kategori_beritas` (`id`, `nama`, `slug`, `created_at`, `updated_at`) VALUES
(2, 'Opini', 'opini', '2026-01-10 00:54:25', '2026-01-10 00:54:25'),
(3, 'Kegiatan', 'kegiatan', '2026-01-10 02:00:04', '2026-01-10 02:00:04'),
(4, 'Kaderisasi', 'kaderisasi', '2026-03-18 02:46:38', '2026-03-18 02:46:38'),
(5, 'Dakwah', 'dakwah', '2026-03-18 02:46:38', '2026-03-18 02:46:38'),
(6, 'Pengumuman', 'pengumuman', '2026-03-18 02:46:38', '2026-03-18 02:46:38'),
(7, 'Olahraga', 'olahraga', '2026-03-18 02:46:38', '2026-03-18 02:46:38');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_program`
--

CREATE TABLE `kategori_program` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `departemen_id` varchar(255) NOT NULL,
  `organisasi_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_verifikasi` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_program`
--

INSERT INTO `kategori_program` (`id`, `nama_kategori`, `slug`, `departemen_id`, `organisasi_id`, `status_verifikasi`, `created_at`, `updated_at`) VALUES
(9, 'Agenda Wajib', 'agenda-wajib', 'dep007', NULL, 1, '2026-01-25 06:29:09', '2026-01-25 06:29:09'),
(10, 'Pengembangan Sumber Daya Kader (Psdk)', 'pengembangan-sumber-daya-kader-psdk', 'dep007', NULL, 1, '2026-01-26 06:02:55', '2026-01-26 06:02:55'),
(11, 'Penghargaan Dan Apresiasi Kinerja', 'penghargaan-dan-apresiasi-kinerja', 'dep007', NULL, 1, '2026-01-26 06:16:08', '2026-01-26 06:16:08'),
(12, 'Penguatan Silaturahmi Antar Komisariat', 'penguatan-silaturahmi-antar-komisariat', 'dep009', NULL, 1, '2026-01-26 07:34:39', '2026-01-26 07:34:39'),
(13, 'Koordinasi', 'koordinasi', 'dep009', NULL, 1, '2026-01-26 07:43:59', '2026-01-26 07:43:59'),
(14, 'Evaluasi Organisasi', 'evaluasi-organisasi', 'dep009', NULL, 1, '2026-01-26 07:45:17', '2026-01-26 07:45:17'),
(15, 'Pelantikan', 'pelantikan', 'dep007', NULL, 1, '2026-01-26 22:04:11', '2026-01-26 22:04:11'),
(21, 'Mengenang Para Wali Dan Muasis Nu', 'mengenang-para-wali-dan-muasis-nu', 'dep010', NULL, 1, '2026-01-27 08:26:31', '2026-01-27 08:26:31'),
(22, 'Memperingati Hari Besar Islam', 'memperingati-hari-besar-islam', 'dep010', NULL, 1, '2026-01-27 08:37:17', '2026-01-27 08:37:17'),
(23, 'Sholawat Diba\' Dan Berzanji', 'sholawat-diba-dan-berzanji', 'dep010', NULL, 1, '2026-01-27 21:01:26', '2026-01-27 21:01:26'),
(24, 'Silaturahmi', 'silaturahmi', 'dep010', NULL, 1, '2026-01-28 03:49:53', '2026-01-28 03:49:53'),
(25, 'Rutinan', 'rutinan', 'dep010', NULL, 1, '2026-01-28 03:55:40', '2026-01-28 03:55:40'),
(26, 'Forum Permusyawaratan', 'forum-permusyawaratan', 'dep007', NULL, 1, '2026-01-28 04:02:22', '2026-01-28 04:02:22'),
(27, 'Pengarsipan', 'pengarsipan', 'dep012', NULL, 1, '2026-01-28 04:09:31', '2026-01-28 04:09:31'),
(28, 'Pendirian Ranting', 'pendirian-ranting', 'dep007', NULL, 1, '2026-01-28 06:42:23', '2026-01-28 06:42:23'),
(29, 'Ekonomi Kreatif', 'ekonomi-kreatif', 'dep016', NULL, 1, '2026-01-28 06:47:08', '2026-01-28 06:47:08'),
(31, 'Pendirian Pk', 'pendirian-pk', 'dep009', NULL, 1, '2026-01-28 10:16:00', '2026-01-28 10:16:00'),
(32, 'Edukasi', 'edukasi', 'dep012', NULL, 1, '2026-01-28 10:26:55', '2026-01-28 10:26:55'),
(34, 'Ziaroh', 'ziaroh', 'dep010', NULL, 1, '2026-01-28 11:07:41', '2026-01-28 11:07:41'),
(35, 'Rakerancab', 'rakerancab', 'dep007', NULL, 1, '2026-01-28 11:10:44', '2026-01-28 11:10:44'),
(36, 'Porseni', 'porseni', 'dep011', NULL, 1, '2026-01-28 11:24:24', '2026-01-28 11:24:24'),
(37, 'Sparing', 'sparing', 'dep011', NULL, 1, '2026-01-28 11:28:52', '2026-01-28 11:28:52'),
(38, 'Tindak Lanjut (Tl)', 'tindak-lanjut-tl', 'dep008', NULL, 1, '2026-01-28 11:40:05', '2026-01-28 11:40:05'),
(39, 'Pendalaman Organisasi', 'pendalaman-organisasi', 'dep007', NULL, 1, '2026-01-28 21:41:14', '2026-01-28 21:41:14'),
(40, 'Daya Tarik Kader Milenial', 'daya-tarik-kader-milenial', 'dep007', NULL, 1, '2026-01-28 21:46:59', '2026-01-28 21:46:59'),
(41, 'Perlombaan', 'perlombaan', 'dep011', NULL, 1, '2026-01-29 06:10:13', '2026-01-29 06:10:13'),
(42, 'Foto Resmi Pengurus', 'foto-resmi-pengurus', 'dep012', NULL, 1, '2026-01-29 06:39:34', '2026-01-29 06:39:34'),
(43, 'Orientasi Pengurus Pac', 'orientasi-pengurus-pac', 'dep007', NULL, 1, '2026-01-29 16:53:13', '2026-01-29 16:53:13'),
(44, 'Sholawat', 'sholawat', 'dep011', NULL, 1, '2026-01-29 23:21:14', '2026-01-29 23:21:14'),
(46, 'Branding', 'branding', 'dep012', NULL, 1, '2026-01-30 04:40:14', '2026-01-30 04:40:14'),
(47, 'Peringatan Hari Besar Nasional', 'peringatan-hari-besar-nasional', 'dep011', NULL, 1, '2026-01-30 06:09:07', '2026-01-30 06:09:07'),
(48, 'Quotes Motivasi', 'quotes-motivasi', 'dep011', NULL, 1, '2026-01-30 06:11:06', '2026-01-30 06:11:06'),
(49, 'Khataman Al - Qur\'an', 'khataman-al-quran', 'dep010', NULL, 1, '2026-01-30 06:20:14', '2026-01-30 06:20:14'),
(50, 'Konferancab', 'konferancab', 'dep007', NULL, 1, '2026-01-30 08:12:04', '2026-01-30 08:12:04'),
(51, 'Turba', 'turba', 'dep007', NULL, 1, '2026-01-31 07:42:49', '2026-01-31 07:42:49'),
(52, 'Buka Bersama', 'buka-bersama', 'dep010', NULL, 1, '2026-01-31 18:27:33', '2026-01-31 18:27:33'),
(53, 'Safari Ramadhan', 'safari-ramadhan', 'dep010', NULL, 1, '2026-01-31 18:28:45', '2026-01-31 18:28:45');

-- --------------------------------------------------------

--
-- Table structure for table `kepanitiaans`
--

CREATE TABLE `kepanitiaans` (
  `id` varchar(255) NOT NULL,
  `program_kerja_id` varchar(255) NOT NULL,
  `kader_id` varchar(255) DEFAULT NULL,
  `nama_manual` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kepanitiaans`
--

INSERT INTO `kepanitiaans` (`id`, `program_kerja_id`, `kader_id`, `nama_manual`, `jabatan`, `created_at`, `updated_at`) VALUES
('pan001', 'proker002', 'kdr146', NULL, 'Ketua Panitia', '2026-03-20 00:41:11', '2026-03-20 00:41:11'),
('pan002', 'proker002', 'kdr076', NULL, 'Sekretaris', '2026-03-20 00:41:11', '2026-03-20 00:41:11'),
('pan003', 'proker002', 'kdr077', NULL, 'Bendahara', '2026-03-20 00:41:11', '2026-03-20 00:41:11'),
('pan004', 'proker002', 'kdr002', NULL, 'CO Sie Acara', '2026-03-20 00:41:11', '2026-03-20 00:41:11'),
('pan005', 'proker002', 'kdr173', NULL, 'Anggota Sie Acara', '2026-03-20 00:41:11', '2026-03-20 00:41:11'),
('pan006', 'proker002', 'kdr196', NULL, 'CO Sie Konsumsi', '2026-03-20 00:41:11', '2026-03-20 00:41:11'),
('pan007', 'proker002', 'kdr203', NULL, 'Anggota Sie Konsumsi', '2026-03-20 00:41:11', '2026-03-20 00:41:11'),
('pan008', 'proker002', 'kdr160', NULL, 'CO Sie Dokumentasi', '2026-03-20 00:41:11', '2026-03-20 00:41:11'),
('pan009', 'proker002', 'kdr124', NULL, 'Anggota Sie Dokumentasi', '2026-03-20 00:41:11', '2026-03-20 00:41:11'),
('pan010', 'proker002', 'kdr160', NULL, 'CO Sie Perkap', '2026-03-20 00:41:11', '2026-03-20 00:41:11'),
('pan011', 'proker002', 'kdr176', NULL, 'Anggota Sie Perkap', '2026-03-20 00:41:11', '2026-03-20 00:41:11'),
('pan012', 'proker002', 'kdr089', NULL, 'CO Sie Humas', '2026-03-20 00:41:11', '2026-03-20 00:41:11'),
('pan013', 'proker002', 'kdr019', NULL, 'Anggota Sie Humas', '2026-03-20 00:41:11', '2026-03-20 00:41:11'),
('pan014', 'proker002', 'kdr200', NULL, 'CO Sie Sekretariatan', '2026-03-20 00:41:11', '2026-03-20 00:41:11'),
('pan015', 'proker002', 'kdr173', NULL, 'Anggota Sie Sekretariatan', '2026-03-20 00:41:11', '2026-03-20 00:41:11'),
('pan016', 'proker002', 'kdr080', NULL, 'CO Sie Keamanan', '2026-03-20 00:41:11', '2026-03-20 00:41:11'),
('pan017', 'proker002', 'kdr070', NULL, 'Anggota Sie Keamanan', '2026-03-20 00:41:11', '2026-03-20 00:41:11'),
('pan018', 'proker002', 'kdr159', NULL, 'CO Sie Kesehatan', '2026-03-20 00:41:11', '2026-03-20 00:41:11'),
('pan019', 'proker002', 'kdr119', NULL, 'Anggota Sie Kesehatan', '2026-03-20 00:41:11', '2026-03-20 00:41:11');

-- --------------------------------------------------------

--
-- Table structure for table `komentar_beritas`
--

CREATE TABLE `komentar_beritas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `berita_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `konten` text NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `komentar_beritas`
--

INSERT INTO `komentar_beritas` (`id`, `berita_id`, `nama`, `email`, `konten`, `is_approved`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ahmad Fauzi', 'ahmad@test.com', 'Artikel yang sangat bermanfaat, terima kasih sudah berbagi informasi.', 1, NULL, '2026-03-18 03:24:06', '2026-03-18 03:24:06'),
(2, 1, 'Siti Aisyah', NULL, 'Setuju, semoga kegiatan ini terus berlanjut.', 1, 1, '2026-03-18 03:24:18', '2026-03-18 03:24:18'),
(4, 1, 'fahmi', 'fahmifahmi@gmail.com', 'halo kkaal', 1, NULL, '2026-06-15 22:15:21', '2026-06-15 22:36:10');

-- --------------------------------------------------------

--
-- Table structure for table `layanans`
--

CREATE TABLE `layanans` (
  `id` varchar(10) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `kategori` enum('Template Surat','Pedoman','Peraturan','Formulir','Doa & Dzikir','Lainnya') NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `ukuran_file` varchar(255) DEFAULT NULL,
  `jumlah_download` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `layanans`
--

INSERT INTO `layanans` (`id`, `judul`, `deskripsi`, `kategori`, `file_path`, `ukuran_file`, `jumlah_download`, `is_active`, `created_at`, `updated_at`) VALUES
('lay001', 'Template Surat Undangan Rapat', 'Template surat undangan rapat resmi untuk PAC, PR, dan PK. Format standar IPNU-IPPNU siap pakai.', 'Template Surat', 'layanan/template-surat-undangan-rapat.docx', '45 KB', 34, 1, '2026-03-24 08:56:11', '2026-03-24 08:56:11'),
('lay002', 'Template Surat Rekomendasi Kader', 'Surat rekomendasi resmi untuk kader yang mengikuti kegiatan di luar organisasi, pelantikan, atau perpindahan.', 'Template Surat', 'layanan/template-surat-rekomendasi-kader.docx', '38 KB', 21, 1, '2026-03-24 08:56:11', '2026-03-24 08:56:11'),
('lay003', 'Template Surat Permohonan Izin Kegiatan', 'Surat permohonan izin kegiatan kepada instansi pemerintah, sekolah, atau ponpes.', 'Template Surat', 'layanan/template-surat-izin-kegiatan.docx', '52 KB', 18, 1, '2026-03-24 08:56:11', '2026-03-24 08:56:11'),
('lay004', 'Pedoman Kaderisasi IPNU 2024', 'Panduan lengkap sistem kaderisasi IPNU meliputi MAKESTA, LAKMUD, dan LAKUT beserta kurikulumnya.', 'Pedoman', 'layanan/pedoman-kaderisasi-ipnu-2024.pdf', '2.1 MB', 87, 1, '2026-03-24 08:56:11', '2026-03-24 08:56:11'),
('lay005', 'Juklak Masa Kesetiaan Anggota (MAKESTA)', 'Petunjuk pelaksanaan MAKESTA lengkap: tujuan, materi, metode, dan evaluasi untuk panitia penyelenggara.', 'Pedoman', 'layanan/juklak-makesta.pdf', '1.8 MB', 63, 1, '2026-03-24 08:56:11', '2026-03-24 08:56:11'),
('lay006', 'Panduan Administrasi Organisasi', 'Panduan lengkap tata kelola administrasi organisasi IPNU-IPPNU dari tingkat PC hingga PK.', 'Pedoman', 'layanan/panduan-administrasi-organisasi.pdf', '3.2 MB', 45, 1, '2026-03-24 08:56:11', '2026-03-24 08:56:11'),
('lay007', 'AD/ART IPNU Hasil Kongres 2021', 'Anggaran Dasar dan Anggaran Rumah Tangga IPNU yang disahkan pada Kongres IPNU XVII tahun 2021.', 'Peraturan', 'layanan/adart-ipnu-2021.pdf', '4.5 MB', 112, 1, '2026-03-24 08:56:11', '2026-03-24 08:56:11'),
('lay008', 'Peraturan Perkumpulan IPNU', 'Peraturan perkumpulan yang mengatur tata kelola organisasi, sanksi, dan mekanisme penyelesaian sengketa internal.', 'Peraturan', 'layanan/peraturan-perkumpulan-ipnu.pdf', '2.8 MB', 56, 1, '2026-03-24 08:56:11', '2026-03-24 08:56:11'),
('lay009', 'Formulir Pendaftaran Kader Baru', 'Formulir registrasi anggota baru IPNU-IPPNU. Wajib diisi sebelum mengikuti MAKESTA.', 'Formulir', 'layanan/formulir-pendaftaran-kader-baru.pdf', '120 KB', 74, 1, '2026-03-24 08:56:11', '2026-03-24 08:56:11'),
('lay010', 'Kumpulan Doa Harian IPNU', 'Kumpulan doa harian, doa pembuka dan penutup kegiatan, serta dzikir yang dibaca dalam setiap pertemuan resmi IPNU.', 'Doa & Dzikir', 'layanan/kumpulan-doa-harian-ipnu.pdf', '280 KB', 93, 1, '2026-03-24 08:56:11', '2026-03-24 08:56:11'),
('lay011', 'Kalender Program Kerja 2025', 'Kalender tahunan program kerja PC IPNU-IPPNU Kab. Kediri masa khidmat 2025-2027.', 'Lainnya', 'layanan/kalender-program-kerja-2025.pdf', '580 KB', 39, 1, '2026-03-24 08:56:11', '2026-03-24 08:56:11');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_16_022253_create_kaders_table', 1),
(5, '2025_12_16_022303_create_surat_keputusans_table', 1),
(6, '2025_12_16_022327_create_pengurus_table', 1),
(7, '2025_12_16_022337_create_riwayat_pelatihans_table', 1),
(8, '2025_12_16_022345_create_program_kerjas_table', 1),
(9, '2025_12_16_024216_create_hero_sliders_table', 1),
(10, '2025_12_16_024230_create_kategori_beritas_table', 1),
(11, '2025_12_16_024237_create_beritas_table', 1),
(12, '2025_12_16_024243_create_pengaturan_webs_table', 1),
(13, '2025_12_16_151933_add_columns_to_pengaturan_webs_and_hero_sliders', 1),
(14, '2025_12_17_161209_add_quote_to_kaders_table', 1),
(15, '2025_12_17_162631_add_active_and_urutan_to_pengurus_table', 1),
(16, '2025_12_17_165233_add_parent_id_to_pengurus_table', 1),
(17, '2025_12_18_123107_add_lokasi_to_program_kerjas_table', 1),
(18, '2025_12_18_153827_add_views_to_beritas_table', 1),
(19, '2025_12_28_054837_create_departemens_table', 1),
(20, '2025_12_28_054838_add_columns_to_users_table', 1),
(21, '2025_12_28_054838_create_surat_masuks_table', 1),
(22, '2025_12_28_054839_create_surat_keluars_table', 1),
(23, '2025_12_28_054840_create_file_managers_table', 1),
(24, '2025_12_28_054840_create_inventaris_table', 1),
(25, '2025_12_28_054841_create_absensis_table', 1),
(26, '2025_12_28_054842_create_absensi_records_table', 1),
(27, '2025_12_28_073028_add_header_news_to_pengaturan_webs_table', 1),
(28, '2025_12_29_034857_add_label_to_hero_sliders_table', 1),
(29, '2025_12_29_153820_modify_role_enum_in_users_table', 1),
(30, '2025_12_30_065636_add_departemen_columns_to_users_and_prokers', 1),
(31, '2025_12_30_100631_create_proker_execution_tables', 1),
(32, '2026_01_10_091100_make_kader_fields_nullable', 2),
(33, '2026_01_17_031049_create_manajemen_proker_tables', 3),
(34, '2026_01_17_034550_add_pac_role_to_users_table', 4),
(35, '2026_01_23_085213_add_index_to_realisasi_program_pac_id', 5),
(36, '2026_01_23_094314_add_dep_organisasi_role_to_users_table', 6),
(37, '2026_02_04_085659_add_id_kategori_baru_to_realisasi_program_table', 7),
(38, '2026_02_09_101500_force_id_kategori_baru_nullable', 7),
(39, '2026_02_19_133449_fix_pengurus_table_structure', 8),
(40, '2026_02_19_155414_add_kategori_to_departemens_table', 9),
(41, '2026_02_19_160301_add_kategori_to_pengurus_table', 10),
(42, '2026_02_24_071216_create_organisasis_table', 11),
(43, '2026_02_24_071218_update_users_and_pengurus_for_multi_tenant', 11),
(44, '2026_02_24_074141_add_organisasi_id_to_sks_and_proker', 11),
(45, '2026_02_24_081420_add_organisasi_id_to_users_table', 11),
(46, '2026_02_24_091242_add_status_and_organisasi_id_to_surat_keputusans_table', 11),
(47, '2026_03_06_082057_create_form_kegiatans_table', 11),
(48, '2026_03_06_082057_create_peserta_kegiatans_table', 11),
(49, '2026_03_13_001139_add_dep_kaderisasi_role_to_users_table', 11),
(50, '2026_03_18_045246_add_jenis_to_departemens_table', 12),
(51, '2026_03_18_092634_enhance_berita_system', 13),
(52, '2026_03_18_101220_create_komentar_beritas_table', 14),
(53, '2026_03_19_000001_drop_status_from_departemens_table', 15),
(54, '2026_03_19_100000_create_banner_iklans_table', 16),
(55, '2026_03_19_151844_add_label_to_hero_sliders', 17),
(56, '2026_03_19_200000_enhance_absensi_system', 18),
(57, '2026_03_19_200001_enhance_program_kerja_workflow', 18),
(58, '2026_03_20_065714_add_departemen_id_to_users_table', 19),
(59, '2026_03_24_000001_create_layanans_table', 20),
(60, '2026_03_28_043846_add_program_kerja_id_to_form_kegiatans', 21),
(61, '2026_04_20_135638_add_judul_form_and_link_sukses_to_form_kegiatans', 22),
(62, '2026_06_01_000001_add_indexes_to_beritas_table', 23);

-- --------------------------------------------------------

--
-- Table structure for table `organisasis`
--

CREATE TABLE `organisasis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tingkat` enum('PC','PAC','PR','PK') NOT NULL DEFAULT 'PAC',
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `alamat_sekretariat` varchar(255) DEFAULT NULL,
  `zona_wilayah` varchar(255) DEFAULT NULL,
  `nomor_sp` varchar(255) DEFAULT NULL,
  `masa_khidmat_mulai` date DEFAULT NULL,
  `masa_khidmat_selesai` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organisasis`
--

INSERT INTO `organisasis` (`id`, `nama`, `tingkat`, `parent_id`, `alamat_sekretariat`, `zona_wilayah`, `nomor_sp`, `masa_khidmat_mulai`, `masa_khidmat_selesai`, `created_at`, `updated_at`) VALUES
(1, 'PC IPNU IPPNU Kabupaten Kediri', 'PC', NULL, NULL, 'Kediri', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(2, 'PAC IPNU IPPNU Badas', 'PAC', 1, NULL, 'Badas', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(3, 'PAC IPNU IPPNU Banyakan', 'PAC', 1, NULL, 'Banyakan', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(4, 'PAC IPNU IPPNU Gampengrejo', 'PAC', 1, NULL, 'Gampengrejo', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(5, 'PAC IPNU IPPNU Grogol', 'PAC', 1, NULL, 'Grogol', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(6, 'PAC IPNU IPPNU Gurah', 'PAC', 1, NULL, 'Gurah', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(7, 'PAC IPNU IPPNU Kandangan', 'PAC', 1, NULL, 'Kandangan', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(8, 'PAC IPNU IPPNU Kandat', 'PAC', 1, NULL, 'Kandat', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(9, 'PAC IPNU IPPNU Kayen Kidul', 'PAC', 1, NULL, 'Kayen Kidul', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(10, 'PAC IPNU IPPNU Kepung', 'PAC', 1, NULL, 'Kepung', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(11, 'PAC IPNU IPPNU Kras', 'PAC', 1, NULL, 'Kras', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(12, 'PAC IPNU IPPNU Kunjang', 'PAC', 1, NULL, 'Kunjang', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(13, 'PAC IPNU IPPNU Mojo', 'PAC', 1, NULL, 'Mojo', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(14, 'PAC IPNU IPPNU Ngadiluwih', 'PAC', 1, NULL, 'Ngadiluwih', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(15, 'PAC IPNU IPPNU Ngancar', 'PAC', 1, NULL, 'Ngancar', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(16, 'PAC IPNU IPPNU Pagu', 'PAC', 1, NULL, 'Pagu', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(17, 'PAC IPNU IPPNU Papar', 'PAC', 1, NULL, 'Papar', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(18, 'PAC IPNU IPPNU Pare', 'PAC', 1, NULL, 'Pare', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(19, 'PAC IPNU IPPNU Plemahan', 'PAC', 1, NULL, 'Plemahan', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(20, 'PAC IPNU IPPNU Plosoklaten', 'PAC', 1, NULL, 'Plosoklaten', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(21, 'PAC IPNU IPPNU Puncu', 'PAC', 1, NULL, 'Puncu', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(22, 'PAC IPNU IPPNU Purwoasri', 'PAC', 1, NULL, 'Purwoasri', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(23, 'PAC IPNU IPPNU Ringinrejo', 'PAC', 1, NULL, 'Ringinrejo', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(24, 'PAC IPNU IPPNU Semen', 'PAC', 1, NULL, 'Semen', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(25, 'PAC IPNU IPPNU Tarokan', 'PAC', 1, NULL, 'Tarokan', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(26, 'PAC IPNU IPPNU Wates', 'PAC', 1, NULL, 'Wates', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(27, 'PAC IPNU IPPNU Kasembon', 'PAC', 1, NULL, 'Kasembon', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(28, 'PR IPNU IPPNU Desa Paron', 'PR', 14, NULL, 'Ngadiluwih', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(29, 'PR IPNU IPPNU Desa Bedali', 'PR', 15, NULL, 'Ngancar', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(30, 'PR IPNU IPPNU Desa Purwoasri', 'PR', 22, NULL, 'Purwoasri', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(31, 'PR IPNU IPPNU Desa Bulusari', 'PR', 25, NULL, 'Tarokan', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(32, 'PR IPNU IPPNU Desa Kras', 'PR', 11, NULL, 'Kras', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(33, 'PR IPNU IPPNU Desa Purworejo', 'PR', 8, NULL, 'Kandat', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(34, 'PR IPNU IPPNU Desa Papar', 'PR', 17, NULL, 'Papar', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(35, 'PR IPNU IPPNU Desa Wates', 'PR', 26, NULL, 'Wates', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(36, 'PR IPNU IPPNU Desa Semen', 'PR', 24, NULL, 'Semen', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(37, 'PR IPNU IPPNU Desa Kepung', 'PR', 10, NULL, 'Kepung', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(38, 'PR IPNU IPPNU Desa Gurah', 'PR', 6, NULL, 'Gurah', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(39, 'PR IPNU IPPNU Desa Grogol', 'PR', 5, NULL, 'Grogol', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(40, 'PR IPNU IPPNU Desa Badas', 'PR', 2, NULL, 'Badas', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(41, 'PR IPNU IPPNU Desa Pare', 'PR', 18, NULL, 'Pare', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(42, 'PR IPNU IPPNU Desa Kandangan', 'PR', 7, NULL, 'Kandangan', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(43, 'PR IPNU IPPNU Desa Plosoklaten', 'PR', 20, NULL, 'Plosoklaten', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(44, 'PR IPNU IPPNU Desa Puncu', 'PR', 21, NULL, 'Puncu', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(45, 'PR IPNU IPPNU Desa Pagu', 'PR', 16, NULL, 'Pagu', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(46, 'PR IPNU IPPNU Desa Ringinrejo', 'PR', 23, NULL, 'Ringinrejo', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(47, 'PR IPNU IPPNU Desa Plemahan', 'PR', 19, NULL, 'Plemahan', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(48, 'PR IPNU IPPNU Desa Mojo', 'PR', 13, NULL, 'Mojo', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(49, 'PR IPNU IPPNU Desa Kunjang', 'PR', 12, NULL, 'Kunjang', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(50, 'PR IPNU IPPNU Desa Gampengrejo', 'PR', 4, NULL, 'Gampengrejo', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(51, 'PR IPNU IPPNU Desa Kayen Kidul', 'PR', 9, NULL, 'Kayen Kidul', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(52, 'PR IPNU IPPNU Desa Banyakan', 'PR', 3, NULL, 'Banyakan', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(53, 'PR IPNU IPPNU Desa Kasembon', 'PR', 27, NULL, 'Kasembon', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(54, 'PR IPNU IPPNU Desa Ngancar', 'PR', 15, NULL, 'Ngancar', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(55, 'PR IPNU IPPNU Desa Tarokan', 'PR', 25, NULL, 'Tarokan', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(56, 'PR IPNU IPPNU Desa Grogol Selatan', 'PR', 5, NULL, 'Grogol', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(57, 'PR IPNU IPPNU Desa Kepuh Kencono', 'PR', 10, NULL, 'Kepung', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(58, 'PK MA Al-Azhar Kediri', 'PK', 18, NULL, 'Pare', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(59, 'PK SMA Negeri 1 Pare', 'PK', 18, NULL, 'Pare', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(60, 'PK MAN 2 Kediri', 'PK', 4, NULL, 'Gampengrejo', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(61, 'PK Ponpes Lirboyo', 'PK', 14, NULL, 'Ngadiluwih', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(62, 'PK Ponpes Al-Falah Ploso', 'PK', 13, NULL, 'Mojo', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(63, 'PK UNISKA Kediri', 'PK', 5, NULL, 'Grogol', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(64, 'PK IAIN Kediri', 'PK', 5, NULL, 'Grogol', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35'),
(65, 'PK SMK Negeri 2 Kediri', 'PK', 4, NULL, 'Gampengrejo', NULL, NULL, NULL, '2026-03-17 22:36:35', '2026-03-17 22:36:35');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendaftarans`
--

CREATE TABLE `pendaftarans` (
  `id` varchar(255) NOT NULL,
  `program_kerja_id` varchar(255) NOT NULL,
  `kader_id` varchar(255) NOT NULL,
  `status` enum('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  `tipe_daftar` enum('internal','umum') NOT NULL DEFAULT 'internal',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan_webs`
--

CREATE TABLE `pengaturan_webs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_website` varchar(255) NOT NULL DEFAULT 'PC IPNU IPPNU Kediri',
  `deskripsi_singkat` text DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `no_wa` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `tiktok` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `profil_singkat` text DEFAULT NULL,
  `visi` text DEFAULT NULL,
  `misi` text DEFAULT NULL,
  `header_news_title` varchar(255) DEFAULT 'Suara Pelajar Kediri',
  `header_news_desc` text DEFAULT 'Informasi terkini kegiatan, opini, dan pergerakan pelajar NU di Kabupaten Kediri.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengaturan_webs`
--

INSERT INTO `pengaturan_webs` (`id`, `nama_website`, `deskripsi_singkat`, `logo_path`, `email`, `no_wa`, `alamat`, `facebook`, `instagram`, `youtube`, `tiktok`, `created_at`, `updated_at`, `profil_singkat`, `visi`, `misi`, `header_news_title`, `header_news_desc`) VALUES
(1, 'PC IPNU IPPNU KEDIRI', 'Pelajar NU Kediri Berdaya', NULL, 'admin@dasi.org', '08123456789', NULL, NULL, NULL, NULL, NULL, '2026-01-02 15:32:40', '2026-01-02 15:32:40', 'IPNU (Ikatan Pelajar Nahdlatul Ulama) dan IPPNU (Ikatan Pelajar Putri Nahdlatul Ulama) adalah badan otonom NU yang menjadi wadah kaderisasi pelajar dan mahasiswa, bertujuan membentuk pelajar religius, berilmu, berakhlak mulia, serta cinta tanah air berdasarkan Pancasila dan Aswaja. IPNU khusus untuk pelajar putra (berdiri 1954) dan IPPNU untuk pelajar putri (berdiri 1955), keduanya merupakan organisasi kepelajaran, kekeluargaan, kemasyarakatan, dan keagamaan yang berfokus pada pendidikan, pengkaderan, dan pengabdian masyarakat.', 'Mewujudkan pelajar bangsa yang bertaqwa, berilmu, berakhlakul karimah, dan berwawasan kebangsaan, yang bertanggung jawab menegakkan syariat Islam Ahlussunnah Wal Jama\'ah berdasarkan Pancasila dan UUD 1945, serta menjadi wadah pengembangan potensi pelajar Nahdlatul Ulama untuk membangun peradaban bangsa yang berkeadilan', 'Membangun kader NU berkualitas yang religius (bertaqwa, berakhlak mulia), intelektual (berilmu, menguasai IPTEK), berwawasan kebangsaan (demokratis, cinta NKRI, berwawasan kebhinekaan), serta mengembangkan potensi kader menjadi pribadi yang dinamis, kreatif, inovatif, dan mandiri, dengan landasan Islam Ahlussunnah Wal Jama\'ah, untuk menciptakan pelajar berdaya guna bagi agama, bangsa, dan negara', 'Suara Pelajar Kediri', 'Informasi terkini kegiatan, opini, dan pergerakan pelajar NU di Kabupaten Kediri.');

-- --------------------------------------------------------

--
-- Table structure for table `pengurus`
--

CREATE TABLE `pengurus` (
  `id` varchar(255) NOT NULL,
  `kader_id` varchar(255) NOT NULL,
  `organisasi_id` bigint(20) UNSIGNED DEFAULT NULL,
  `parent_id` varchar(255) DEFAULT NULL,
  `surat_keputusan_id` bigint(20) UNSIGNED NOT NULL,
  `tingkatan` enum('Cabang','Anak Cabang','Ranting','Komisariat') NOT NULL,
  `kategori` enum('IPNU','IPPNU','Joint') NOT NULL DEFAULT 'Joint',
  `nama_tingkatan` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `urutan_tampil` int(11) NOT NULL DEFAULT 99,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `departemen_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengurus`
--

INSERT INTO `pengurus` (`id`, `kader_id`, `organisasi_id`, `parent_id`, `surat_keputusan_id`, `tingkatan`, `kategori`, `nama_tingkatan`, `jabatan`, `urutan_tampil`, `is_active`, `departemen_id`, `created_at`, `updated_at`) VALUES
('pgr004', 'kdr002', NULL, 'pgr012', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Wakil Ketua', 10, 1, 'dep007', '2026-02-19 18:37:07', '2026-02-20 00:08:17'),
('pgr005', 'kdr019', NULL, 'pgr004', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Koordinator', 40, 1, 'dep007', '2026-02-19 18:37:07', '2026-02-20 00:08:17'),
('pgr006', 'kdr008', NULL, 'pgr013', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Wakil Sekretaris', 20, 1, 'dep007', '2026-02-19 18:37:07', '2026-02-20 00:08:17'),
('pgr007', 'kdr014', NULL, 'pgr014', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Wakil Bendahara', 30, 1, 'dep007', '2026-02-19 18:37:07', '2026-02-20 00:08:17'),
('pgr008', 'kdr003', NULL, 'pgr012', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Wakil Ketua', 11, 1, 'dep008', '2026-02-19 18:37:07', '2026-02-20 00:08:17'),
('pgr009', 'kdr078', NULL, 'pgr008', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Koordinator', 41, 1, 'dep008', '2026-02-19 18:37:07', '2026-02-20 00:08:17'),
('pgr010', 'kdr009', NULL, 'pgr013', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Wakil Sekretaris', 21, 1, 'dep008', '2026-02-19 18:37:07', '2026-02-20 00:08:17'),
('pgr011', 'kdr021', NULL, 'pgr014', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Wakil Bendahara', 31, 1, 'dep008', '2026-02-19 18:37:07', '2026-02-20 00:08:17'),
('pgr012', 'kdr001', NULL, NULL, 1, 'Cabang', 'IPNU', 'PC IPNU', 'Ketua', 1, 1, NULL, '2026-02-19 18:39:13', '2026-02-20 00:08:17'),
('pgr013', 'kdr007', NULL, 'pgr012', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Sekretaris', 2, 1, NULL, '2026-02-19 18:39:13', '2026-02-20 00:08:17'),
('pgr014', 'kdr013', NULL, 'pgr012', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Bendahara', 3, 1, NULL, '2026-02-19 18:39:13', '2026-02-20 00:08:17'),
('pgr016', 'kdr031', NULL, 'pgr009', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Anggota', 61, 1, 'dep008', '2026-02-19 21:43:12', '2026-02-20 00:08:17'),
('pgr017', 'kdr004', NULL, 'pgr012', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Wakil Ketua', 12, 1, 'dep009', '2026-02-19 21:43:13', '2026-02-20 00:08:17'),
('pgr018', 'kdr032', NULL, 'pgr017', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Koordinator', 42, 1, 'dep009', '2026-02-19 21:43:13', '2026-02-20 00:08:17'),
('pgr019', 'kdr010', NULL, 'pgr013', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Wakil Sekretaris', 22, 1, 'dep009', '2026-02-19 21:43:13', '2026-02-20 00:08:17'),
('pgr020', 'kdr029', NULL, 'pgr014', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Wakil Bendahara', 32, 1, 'dep009', '2026-02-19 21:43:13', '2026-02-20 00:08:17'),
('pgr021', 'kdr025', NULL, 'pgr018', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Anggota', 62, 1, 'dep009', '2026-02-19 21:43:13', '2026-02-20 00:08:17'),
('pgr022', 'kdr005', NULL, 'pgr012', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Wakil Ketua', 13, 1, 'dep010', '2026-02-19 21:43:13', '2026-02-20 00:08:17'),
('pgr023', 'kdr077', NULL, 'pgr022', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Koordinator', 43, 1, 'dep010', '2026-02-19 21:43:13', '2026-02-20 00:08:17'),
('pgr024', 'kdr080', NULL, 'pgr013', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Wakil Sekretaris', 23, 1, 'dep010', '2026-02-19 21:43:13', '2026-02-20 00:08:17'),
('pgr025', 'kdr036', NULL, 'pgr014', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Wakil Bendahara', 33, 1, 'dep010', '2026-02-19 21:43:13', '2026-02-20 00:08:17'),
('pgr026', 'kdr041', NULL, 'pgr023', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Anggota', 63, 1, 'dep010', '2026-02-19 21:43:13', '2026-02-20 00:08:17'),
('pgr027', 'kdr006', NULL, 'pgr012', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Wakil Ketua', 14, 1, 'dep011', '2026-02-19 21:43:13', '2026-02-20 00:08:17'),
('pgr028', 'kdr044', NULL, 'pgr027', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Koordinator', 44, 1, 'dep011', '2026-02-19 21:43:13', '2026-02-20 00:08:17'),
('pgr029', 'kdr020', NULL, 'pgr013', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Wakil Sekretaris', 24, 1, 'dep011', '2026-02-19 21:43:13', '2026-02-20 00:08:17'),
('pgr030', 'kdr069', NULL, 'pgr014', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Wakil Bendahara', 34, 1, 'dep011', '2026-02-19 21:43:13', '2026-02-20 00:08:17'),
('pgr031', 'kdr075', NULL, 'pgr028', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Anggota', 64, 1, 'dep011', '2026-02-19 21:43:13', '2026-02-20 00:08:17'),
('pgr032', 'kdr052', NULL, 'pgr012', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Komandan', 50, 1, 'dep013', '2026-02-19 21:43:13', '2026-02-20 00:08:17'),
('pgr033', 'kdr066', NULL, 'pgr032', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Anggota', 70, 1, 'dep013', '2026-02-19 21:43:13', '2026-02-20 00:08:17'),
('pgr034', 'kdr061', NULL, 'pgr012', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Direktur', 51, 1, 'dep014', '2026-02-19 21:43:13', '2026-02-20 00:08:17'),
('pgr035', 'kdr071', NULL, 'pgr034', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Anggota', 71, 1, 'dep014', '2026-02-19 21:43:13', '2026-02-20 00:08:17'),
('pgr036', 'kdr034', NULL, 'pgr012', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Direktur', 52, 1, 'dep015', '2026-02-19 21:43:13', '2026-02-20 00:08:17'),
('pgr037', 'kdr089', NULL, 'pgr036', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Anggota', 72, 1, 'dep015', '2026-02-19 21:43:13', '2026-02-20 00:08:17'),
('pgr038', 'kdr021', NULL, 'pgr005', 1, 'Cabang', 'IPNU', 'PC IPNU', 'Anggota', 60, 1, 'dep007', '2026-02-20 00:08:10', '2026-02-20 00:08:17'),
('pgr039', 'kdr189', NULL, NULL, 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Ketua', 1, 1, NULL, '2026-03-17 21:56:01', '2026-03-17 21:56:01'),
('pgr040', 'kdr190', NULL, 'pgr039', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Wakil Ketua', 4, 1, 'dep007', '2026-03-17 21:56:01', '2026-03-17 21:56:01'),
('pgr041', 'kdr191', NULL, 'pgr039', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Wakil Ketua', 4, 1, 'dep008', '2026-03-17 21:56:01', '2026-03-17 21:56:01'),
('pgr042', 'kdr192', NULL, 'pgr039', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Wakil Ketua', 4, 1, 'dep012', '2026-03-17 21:56:01', '2026-03-17 21:56:01'),
('pgr043', 'kdr193', NULL, 'pgr039', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Wakil Ketua', 4, 1, 'dep010', '2026-03-17 21:56:01', '2026-03-17 21:56:01'),
('pgr044', 'kdr194', NULL, 'pgr039', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Sekretaris', 2, 1, NULL, '2026-03-17 21:56:01', '2026-03-17 21:56:01'),
('pgr045', 'kdr195', NULL, 'pgr044', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Wakil Sekretaris', 7, 1, 'dep007', '2026-03-17 21:56:01', '2026-03-17 21:56:01'),
('pgr046', 'kdr196', NULL, 'pgr044', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Wakil Sekretaris', 8, 1, 'dep008', '2026-03-17 21:56:01', '2026-03-17 21:56:01'),
('pgr047', 'kdr197', NULL, 'pgr044', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Wakil Sekretaris', 9, 1, 'dep012', '2026-03-17 21:56:01', '2026-03-17 21:56:01'),
('pgr048', 'kdr198', NULL, 'pgr039', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Bendahara', 3, 1, NULL, '2026-03-17 21:56:01', '2026-03-17 21:56:01'),
('pgr049', 'kdr199', NULL, 'pgr048', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Wakil Bendahara', 13, 1, 'dep007', '2026-03-17 21:56:01', '2026-03-17 21:56:01'),
('pgr050', 'kdr200', NULL, 'pgr048', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Wakil Bendahara', 14, 1, 'dep008', '2026-03-17 21:56:01', '2026-03-17 21:56:01'),
('pgr051', 'kdr201', NULL, 'pgr039', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Wakil Ketua', 5, 1, 'dep011', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr052', 'kdr202', NULL, 'pgr039', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Wakil Ketua', 6, 1, 'dep024', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr053', 'kdr203', NULL, 'pgr044', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Wakil Sekretaris', 10, 1, 'dep010', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr054', 'kdr204', NULL, 'pgr044', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Wakil Sekretaris', 11, 1, 'dep011', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr055', 'kdr205', NULL, 'pgr044', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Wakil Sekretaris', 12, 1, 'dep024', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr056', 'kdr206', NULL, 'pgr048', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Wakil Bendahara', 13, 1, 'dep012', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr057', 'kdr207', NULL, 'pgr048', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Wakil Bendahara', 14, 1, 'dep010', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr058', 'kdr208', NULL, 'pgr048', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Wakil Bendahara', 15, 1, 'dep011', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr059', 'kdr209', NULL, 'pgr048', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Wakil Bendahara', 16, 1, 'dep024', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr060', 'kdr210', NULL, 'pgr040', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Koordinator', 40, 1, 'dep007', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr061', 'kdr211', NULL, 'pgr041', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Koordinator', 41, 1, 'dep008', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr062', 'kdr212', NULL, 'pgr042', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Koordinator', 42, 1, 'dep012', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr063', 'kdr213', NULL, 'pgr043', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Koordinator', 43, 1, 'dep010', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr064', 'kdr214', NULL, 'pgr051', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Koordinator', 44, 1, 'dep011', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr065', 'kdr215', NULL, 'pgr052', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Koordinator', 45, 1, 'dep024', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr066', 'kdr216', NULL, 'pgr060', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Anggota', 60, 1, 'dep007', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr067', 'kdr217', NULL, 'pgr061', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Anggota', 61, 1, 'dep008', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr068', 'kdr218', NULL, 'pgr062', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Anggota', 62, 1, 'dep012', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr069', 'kdr219', NULL, 'pgr063', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Anggota', 63, 1, 'dep010', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr070', 'kdr220', NULL, 'pgr064', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Anggota', 64, 1, 'dep011', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr071', 'kdr221', NULL, 'pgr065', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Anggota', 65, 1, 'dep024', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr072', 'kdr222', NULL, 'pgr039', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Direktur', 50, 1, 'dep020', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr073', 'kdr223', NULL, 'pgr039', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Direktur', 51, 1, 'dep021', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr074', 'kdr224', NULL, 'pgr039', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Direktur', 52, 1, 'dep023', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr075', 'kdr225', NULL, 'pgr039', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Direktur', 53, 1, 'dep022', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr076', 'kdr226', NULL, 'pgr072', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Anggota', 70, 1, 'dep020', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr077', 'kdr227', NULL, 'pgr073', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Anggota', 71, 1, 'dep021', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr078', 'kdr228', NULL, 'pgr074', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Anggota', 72, 1, 'dep023', '2026-03-18 08:10:13', '2026-03-18 08:10:13'),
('pgr079', 'kdr229', NULL, 'pgr075', 1, 'Cabang', 'IPPNU', 'PC IPPNU', 'Anggota', 73, 1, 'dep022', '2026-03-18 08:10:13', '2026-03-18 08:10:13');

-- --------------------------------------------------------

--
-- Table structure for table `peserta_kegiatans`
--

CREATE TABLE `peserta_kegiatans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_kegiatan_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `jenis_kelamin` varchar(10) DEFAULT NULL,
  `no_wa` varchar(255) DEFAULT NULL,
  `asal_instansi` varchar(255) DEFAULT NULL,
  `custom_answers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`custom_answers`)),
  `status` enum('pending','approved','rejected','attended') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `peserta_kegiatans`
--

INSERT INTO `peserta_kegiatans` (`id`, `form_kegiatan_id`, `user_id`, `nama_lengkap`, `jenis_kelamin`, `no_wa`, `asal_instansi`, `custom_answers`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'use002', 'bagaiooo', 'Laki-Laki', '911911911919119', 'dfsdfdfsdf', '{\"test\":\"d\",\"tetetetet\":null,\"tewtetwe\":null,\"etwetwetwet\":null,\"wetwetwetwe\":null,\"esgsdgsdg\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/pendaftaran_files\\/RLVVCXYOBojPbCQ1kctorgs7KxEEjmrH3sUEqvtg.jpg\"}', 'pending', '2026-04-20 06:48:59', '2026-04-20 06:48:59'),
(2, 1, 'use002', 'SDASDADASD', 'Laki-Laki', '123', 'SDF', '{\"test\":null,\"tetetetet\":null,\"tewtetwe\":null,\"etwetwetwet\":null,\"wetwetwetwe\":null}', 'pending', '2026-04-20 07:03:38', '2026-04-20 07:03:38'),
(3, 1, 'use002', 'qweqweqweqwe', 'Laki-Laki', '12323123', 'sdf', '{\"test\":null,\"tetetetet\":null,\"tewtetwe\":null,\"etwetwetwet\":null,\"wetwetwetwe\":null}', 'pending', '2026-04-20 07:14:54', '2026-04-20 07:14:54'),
(4, 1, 'use002', 'adfasdf', 'Laki-Laki', '12323', 'fsdaf', '{\"test\":null,\"tetetetet\":null,\"tewtetwe\":null,\"etwetwetwet\":null,\"wetwetwetwe\":null}', 'pending', '2026-04-20 07:15:21', '2026-04-20 07:15:21');

-- --------------------------------------------------------

--
-- Table structure for table `program_kerjas`
--

CREATE TABLE `program_kerjas` (
  `id` varchar(255) NOT NULL,
  `nama_proker` varchar(255) NOT NULL,
  `deskripsi_kegiatan` text DEFAULT NULL,
  `departemen_id` varchar(255) NOT NULL,
  `tgl_pelaksanaan` date NOT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `penanggung_jawab` varchar(255) DEFAULT NULL,
  `path_lpj` varchar(255) DEFAULT NULL,
  `lpj_catatan` text DEFAULT NULL,
  `status_lpj` enum('Belum','Draft','Verified') NOT NULL DEFAULT 'Belum',
  `verified_by` varchar(255) DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `status_pelaksanaan` enum('Perencanaan','Persiapan','Pelaksanaan','Selesai') NOT NULL DEFAULT 'Perencanaan',
  `current_step` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `catatan_pelaksanaan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `program_kerjas`
--

INSERT INTO `program_kerjas` (`id`, `nama_proker`, `deskripsi_kegiatan`, `departemen_id`, `tgl_pelaksanaan`, `lokasi`, `penanggung_jawab`, `path_lpj`, `lpj_catatan`, `status_lpj`, `verified_by`, `verified_at`, `status_pelaksanaan`, `current_step`, `catatan_pelaksanaan`, `created_at`, `updated_at`) VALUES
('proker002', 'LAKUT', NULL, 'dep008', '2026-08-17', NULL, 'Yahya', 'lpj/Q59CC8s1Z8NjggqnbD00Pd68TwROgld1NEuoyTny.pdf', 'kurang lengkap', 'Belum', NULL, NULL, 'Pelaksanaan', 5, NULL, '2026-01-10 02:20:09', '2026-03-24 03:32:53'),
('proker003', 'Pelantikan', NULL, 'dep007', '2026-01-10', NULL, 'Airulanang', NULL, NULL, 'Belum', NULL, NULL, 'Perencanaan', 1, NULL, '2026-01-10 02:20:29', '2026-01-10 02:20:29'),
('proker004', 'Porseni', NULL, 'dep011', '2026-12-08', NULL, 'Ibad', NULL, NULL, 'Belum', NULL, NULL, 'Perencanaan', 1, NULL, '2026-01-10 02:20:59', '2026-01-10 02:20:59'),
('proker005', 'Rakercab', NULL, 'dep007', '2026-02-21', NULL, 'tebe', NULL, NULL, 'Belum', NULL, NULL, 'Perencanaan', 1, NULL, '2026-01-10 02:21:26', '2026-01-10 02:21:26');

-- --------------------------------------------------------

--
-- Table structure for table `realisasi_program`
--

CREATE TABLE `realisasi_program` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisasi_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kategori_program_id` bigint(20) UNSIGNED NOT NULL,
  `id_kategori_baru` int(11) DEFAULT NULL,
  `departemen_id` varchar(10) DEFAULT NULL,
  `nama_lokal` varchar(255) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `status` enum('Rencana','Pasti','Terlaksana') NOT NULL DEFAULT 'Rencana',
  `is_fix` tinyint(1) NOT NULL DEFAULT 0,
  `target_peserta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`target_peserta`)),
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `realisasi_program`
--

INSERT INTO `realisasi_program` (`id`, `organisasi_id`, `kategori_program_id`, `id_kategori_baru`, `departemen_id`, `nama_lokal`, `tgl_mulai`, `tgl_selesai`, `status`, `is_fix`, `target_peserta`, `deskripsi`, `created_at`, `updated_at`) VALUES
(7, NULL, 9, 2, 'dep007', 'Pelantikan dan rakercab 1', '2025-08-24', '2025-08-24', 'Terlaksana', 1, '[\"Internal PAC\"]', 'Program ini adalah agenda wajib untuk pengurus baru pac pare', '2026-01-25 06:29:09', '2026-01-25 06:29:09'),
(9, NULL, 11, 5, 'dep007', 'IPNU IPPNU Awards', '2027-02-11', '2027-02-11', 'Rencana', 0, '[\"Pengurus Ranting\"]', NULL, '2026-01-26 06:16:08', '2026-01-26 06:16:08'),
(18, NULL, 24, 3, 'dep010', 'Buka Bersama', '2026-03-01', '2026-03-01', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', 'Rutin 1 tahun sekali setiap Bulan Ramadhan', '2026-01-26 06:51:14', '2026-01-29 21:54:46'),
(19, NULL, 24, 3, 'dep010', 'Safari Syawal', '2027-03-28', '2027-03-30', 'Rencana', 0, '[\"Alumni\",\"Masyarakat\"]', 'Tujuan : Alumni dan lain sebagainya', '2026-01-26 06:52:20', '2026-01-29 21:53:19'),
(20, NULL, 25, 3, 'dep010', 'Khataman Al-Qur\'an', '2026-02-15', '2026-02-15', 'Rencana', 0, '[\"Internal PAC\"]', '- Via Online \r\n- Setiap 2 bulan sekali', '2026-01-26 06:53:55', '2026-01-29 21:52:01'),
(21, NULL, 23, 3, 'dep010', 'Sholawat Diba\' atau Berjanji', '2026-03-22', '2026-03-22', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', '- Tempat bergilir\r\n- dilaksanakan 2 bulan sekali', '2026-01-26 06:55:17', '2026-01-29 21:51:15'),
(23, NULL, 9, 2, 'dep007', 'Feed Motivasi', '2026-02-01', '2027-02-01', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-26 07:00:23', '2026-01-26 07:00:23'),
(24, NULL, 9, 2, 'dep007', 'Ramadhan Story', '2026-02-20', '2026-03-21', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-26 07:01:11', '2026-01-26 07:01:11'),
(25, NULL, 9, 2, 'dep007', 'Pamflet PHBN', '2026-02-12', '2026-02-12', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\",\"Banom NU Lain\"]', NULL, '2026-01-26 07:01:50', '2026-01-26 07:35:07'),
(27, NULL, 10, 1, 'dep007', 'Resap Masalah (Remas)', '2026-05-04', '2026-05-04', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-26 07:04:26', '2026-01-26 07:04:26'),
(29, NULL, 10, 4, 'dep007', 'Podcast Bulanan Collab Media', '2026-05-02', '2026-05-02', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-26 07:06:11', '2026-01-26 07:06:11'),
(32, NULL, 12, 2, 'dep009', 'Back To School', '2026-07-01', '2026-07-01', 'Rencana', 0, '[\"Pelajar\"]', NULL, '2026-01-26 07:09:48', '2026-01-26 08:24:02'),
(33, NULL, 10, 1, 'dep007', 'Upgrade Komisariat', '2026-07-01', '2026-07-01', 'Rencana', 0, '[\"Pelajar\"]', 'Pendampingan, pengarahan, dan membantu penyelesaian permasalahan yang ada di PK', '2026-01-26 07:10:48', '2026-01-26 07:31:28'),
(34, NULL, 10, 1, 'dep007', 'COD (Curhat Obrolan DKAC)', '2026-06-01', '2026-06-01', 'Rencana', 0, '[\"Internal PAC\"]', 'Evaluasi dan koordinasi (dilaksanakan 3 bulan sekali)', '2026-01-26 07:13:09', '2026-01-26 07:40:19'),
(35, NULL, 32, 1, 'dep012', 'TRABASANS (Tadabbur alam)', '2026-05-17', '2026-05-17', 'Rencana', 0, '[\"Internal PAC\"]', 'Dilaksanakan 1 bulan sekali', '2026-01-26 07:14:16', '2026-01-29 21:56:03'),
(36, NULL, 32, 1, 'dep012', 'CBP-KPP Peduli', '2026-05-16', '2026-05-16', 'Rencana', 0, '[\"Internal PAC\",\"Masyarakat\"]', 'Galang dana, penyaluran bantuan untuk korban bencana alam (kondisional)', '2026-01-26 07:15:31', '2026-01-29 21:55:39'),
(38, NULL, 12, 2, 'dep009', 'Srawung Komisariat', '2026-04-01', '2026-04-01', 'Rencana', 0, '[\"Pelajar\"]', NULL, '2026-01-26 07:34:39', '2026-01-26 07:34:39'),
(46, NULL, 26, 2, 'dep007', 'Resap Masalah ( Remas )', '2026-03-17', '2026-03-17', 'Rencana', 0, '[\"Pengurus Ranting\"]', NULL, '2026-01-26 08:19:16', '2026-01-29 21:55:05'),
(47, NULL, 9, 2, 'dep007', 'Evaluasi dan Koordinasi', '2026-01-07', '2026-01-07', 'Pasti', 1, '[\"Internal PAC\"]', 'Waktu Opsional ( 1 bulan 1x ) selama kepengurusan', '2026-01-26 21:53:34', '2026-01-26 22:00:14'),
(48, NULL, 9, 1, 'dep007', 'sinau bareng', '2025-11-15', '2025-11-15', 'Terlaksana', 1, '[\"Pengurus Ranting\"]', NULL, '2026-01-26 22:00:50', '2026-01-26 22:00:50'),
(49, NULL, 9, 2, 'dep007', 'Rutinan Ahad kliwon', '2025-09-01', '2027-04-30', 'Pasti', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\",\"Masyarakat\"]', 'Setiap satu bulan 1 kali dengan keliling ke ranting rantingg se kecamatan Banyakan', '2026-01-26 22:01:02', '2026-01-26 22:01:02'),
(50, NULL, 15, 2, 'dep007', 'pelantikan', '2025-12-12', '2025-12-12', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\",\"Banom NU Lain\"]', 'pelantikan pengurus pac', '2026-01-26 22:04:11', '2026-01-26 22:04:42'),
(52, NULL, 9, 3, 'dep007', 'Safari syawal', '2026-03-21', '2026-03-31', 'Pasti', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Banom NU Lain\"]', 'Agenda wajib', '2026-01-26 22:07:49', '2026-01-26 22:21:49'),
(53, NULL, 13, 2, 'dep009', 'rapat anggota', '2026-01-14', '2026-01-14', 'Terlaksana', 1, '[\"Pengurus Ranting\"]', NULL, '2026-01-26 22:08:37', '2026-01-26 22:08:37'),
(54, NULL, 10, 1, 'dep007', 'Mengisi Matsama', '2026-07-13', '2026-07-18', 'Rencana', 0, '[\"Pelajar\"]', NULL, '2026-01-26 22:08:48', '2026-01-26 22:08:48'),
(55, NULL, 9, 3, 'dep007', 'Ziarah makam auliya kediri', '2026-02-07', '2026-02-14', 'Pasti', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', 'Ziarah makam auliya sesepuh kab kediri', '2026-01-26 22:10:59', '2026-01-26 22:10:59'),
(56, NULL, 9, 2, 'dep007', 'Pelatihan Administrasi', '2026-02-16', '2026-02-16', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', '1 periode 3 kali', '2026-01-26 22:11:03', '2026-01-26 22:11:03'),
(57, NULL, 9, 2, 'dep007', 'raker 1', '2025-12-23', '2025-12-23', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', NULL, '2026-01-26 22:12:14', '2026-01-26 22:12:14'),
(59, NULL, 13, 2, 'dep009', 'rapat anggota', '2026-01-04', '2026-01-04', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', 'rapat anggota PR Selotopeng', '2026-01-26 22:15:21', '2026-01-26 22:15:21'),
(60, NULL, 13, 2, 'dep009', 'rapat anggota', '2026-01-20', '2026-01-20', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', 'rapat anggota PR sambirejo', '2026-01-26 22:16:40', '2026-01-26 22:16:40'),
(61, NULL, 9, 1, 'dep007', 'sinau bareng', '2026-02-15', '2027-02-14', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', NULL, '2026-01-26 22:17:30', '2026-01-26 22:41:00'),
(62, NULL, 9, 2, 'dep007', 'Mentoring', '2025-08-01', '2027-06-01', 'Pasti', 1, '[\"Internal PAC\"]', '24/7 \r\nSetiap hari', '2026-01-26 22:18:08', '2026-01-26 22:18:08'),
(66, NULL, 9, 1, 'dep007', 'Upgrading Pengurus', '2026-04-01', '2026-12-01', 'Rencana', 0, '[\"Internal PAC\"]', '4 bulan 1x mulai April - Desember', '2026-01-26 22:22:03', '2026-01-26 22:22:03'),
(67, NULL, 9, 2, 'dep007', 'Iuran Pengurusan', '2026-01-01', '2026-01-01', 'Pasti', 1, '[\"Internal PAC\"]', 'Waktu opsional', '2026-01-26 22:23:53', '2026-01-26 22:23:53'),
(69, NULL, 9, 2, 'dep007', 'Ahad Kliwon', '2026-01-01', '2027-04-01', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\",\"Banom NU Lain\"]', 'Tanggal Opsional sesuai Ahad Kliwon', '2026-01-26 22:27:04', '2026-01-26 22:27:04'),
(71, NULL, 14, 2, 'dep009', 'Basa Basi (Bincang santai bahas kaderisasi)', '2026-01-01', '2026-04-30', 'Pasti', 1, '[\"Internal PAC\"]', 'Opsional dilaksanakan 3 kali', '2026-01-26 22:29:43', '2026-01-26 22:29:43'),
(72, NULL, 9, 3, 'dep007', 'Tahlilan arwah', '2026-02-08', '2026-02-15', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Masyarakat\"]', 'Bisa di laksanakan dalam kegiatan rutin ahad kliwon', '2026-01-26 22:33:43', '2026-01-26 22:33:43'),
(74, NULL, 9, 2, 'dep007', 'rapat anggota', '2026-02-14', '2027-04-12', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', 'rapat anggota', '2026-01-26 22:36:25', '2026-01-26 22:37:30'),
(79, NULL, 9, 2, 'dep007', 'turba', '2026-04-19', '2027-04-30', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-26 22:39:43', '2026-01-26 22:39:43'),
(81, NULL, 9, 2, 'dep007', 'Apel Sapa', '2026-01-01', '2027-04-01', 'Pasti', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', 'Tanggal Opsional, apel sapa bersamaan sama Ahad kliwon', '2026-01-26 22:41:04', '2026-01-26 22:41:04'),
(82, NULL, 10, 1, 'dep007', 'Pengembangan usaha mikro', '2025-12-21', '2027-04-25', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\",\"Masyarakat\"]', 'Untuk kegiatan ini di rencanakan setiap 3 bulan 1 kali', '2026-01-26 22:42:17', '2026-01-26 22:44:30'),
(83, NULL, 13, 2, 'dep009', 'rakerancab 2', '2026-09-17', '2026-09-17', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', NULL, '2026-01-26 22:42:19', '2026-01-26 22:42:19'),
(84, NULL, 13, 2, 'dep009', 'Sedekah rosok bersama', '2025-12-21', '2027-06-20', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Masyarakat\"]', 'Dilaksanakan secara opsional', '2026-01-26 22:44:09', '2026-01-26 22:44:09'),
(85, NULL, 9, 2, 'dep007', 'Roadshow PK', '2026-06-01', '2026-12-01', 'Rencana', 0, '[\"Pelajar\"]', 'Tanggal Opsional, bulan Juni & Desember \r\nDepartemen yang bertanggung jawab CBP KPP', '2026-01-26 22:44:29', '2026-01-26 22:44:29'),
(86, NULL, 9, 2, 'dep007', 'konferancab', '2027-06-20', '2027-06-20', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Banom NU Lain\"]', NULL, '2026-01-26 22:44:52', '2026-01-26 22:44:52'),
(87, NULL, 9, 1, 'dep007', 'Orientasi Pengurus PAC', '2025-11-02', '2025-11-02', 'Terlaksana', 1, '[\"Internal PAC\"]', 'Merupakan langkah awal pengenalan pengurus dan pengenalan jobdisk masing-masing departemen dan lembaga', '2026-01-26 22:46:37', '2026-01-26 22:46:37'),
(88, NULL, 13, 2, 'dep009', 'Temu kangen', '2026-02-01', '2026-02-01', 'Pasti', 1, '[\"Internal PAC\"]', 'Tanggal Opsional', '2026-01-26 22:46:47', '2026-01-26 22:46:47'),
(91, NULL, 9, 2, 'dep007', 'Dokumentasi', '2025-07-01', '2027-06-30', 'Pasti', 1, '[\"Internal PAC\"]', 'Wajib selama ada kegiatan', '2026-01-26 22:48:16', '2026-01-26 22:48:16'),
(92, NULL, 9, 4, 'dep007', 'badminton', '2026-01-18', '2027-04-30', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\"]', 'beberapa sudah terlaksana', '2026-01-26 22:49:47', '2026-01-26 22:49:47'),
(93, NULL, 9, 2, 'dep007', 'Rapat kerja anak cabang 1 ( RAKERANCAB 1)', '2025-11-23', '2025-11-23', 'Terlaksana', 1, '[\"Internal PAC\"]', 'Pemaparan, pendeskripsian, dan Fiksasi Dari program kerja masing-masing departemen dan lembaga yang telah di susun sebelumnya', '2026-01-26 22:50:23', '2026-01-26 22:50:23'),
(94, NULL, 9, 4, 'dep007', 'futsal', '2026-01-01', '2027-04-30', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\"]', 'beberapa sudah terlaksana', '2026-01-26 22:50:33', '2026-01-26 22:50:33'),
(95, NULL, 9, 2, 'dep007', 'Membuat pamflet', '2025-07-01', '2027-06-30', 'Pasti', 1, '[\"Internal PAC\"]', 'Membuat pamflet peringatan hari besar, pamflet ucapan dan pamflet kegiatan pac', '2026-01-26 22:50:37', '2026-01-26 22:50:37'),
(96, NULL, 15, 2, 'dep007', 'Pelantikan pengurus anak cabang', '2025-12-28', '2025-12-28', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\",\"Banom NU Lain\"]', 'Prosesi baiat dan serah terima jabatan dari demisioner ketua sebelumnya', '2026-01-26 22:52:10', '2026-01-26 22:52:10'),
(97, NULL, 10, 4, 'dep007', 'Sinau Desain', '2026-09-01', '2026-09-30', 'Pasti', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', NULL, '2026-01-26 22:52:13', '2026-01-26 22:52:37'),
(98, NULL, 10, 4, 'dep007', 'porseni', '2027-03-20', '2027-03-21', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\"]', NULL, '2026-01-26 22:52:28', '2026-01-26 22:52:28'),
(99, NULL, 14, 2, 'dep009', 'Monitoring dan evaluasi', '2026-01-24', '2026-01-24', 'Terlaksana', 1, '[\"Internal PAC\"]', 'Program kerja ini adalah kegiatan rutin yang dilaksanakan setiap 2 bulan sekali, maka dalam tanggal hanya formalitas', '2026-01-26 22:54:53', '2026-01-26 22:54:53'),
(100, NULL, 9, 2, 'dep007', 'Pembukaan Rutinan Ahad Pelajar Nu Tarokan', '2025-11-02', '2025-11-02', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', 'Wadah silaturahmi seluruh pelajar NU di Tarokan, yang di adakah 1 bulan sekali', '2026-01-26 22:57:14', '2026-01-26 22:57:14'),
(101, NULL, 15, 2, 'dep007', 'Pelantikan PAC IPNU IPPNU BADAS', '2026-04-19', '2026-04-19', 'Pasti', 1, '[\"Internal PAC\"]', NULL, '2026-01-27 05:56:56', '2026-01-27 05:56:56'),
(102, NULL, 14, 2, 'dep009', 'Rakerancab 1', '2006-04-19', '2026-04-19', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-27 05:59:42', '2026-02-04 06:49:58'),
(103, NULL, 14, 2, 'dep009', 'Rakerancab 2', '2027-01-10', '2027-01-10', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-27 06:01:03', '2026-01-27 06:01:03'),
(104, NULL, 13, 2, 'dep009', 'Turun Ranting (Turing)', '2026-05-01', '2026-06-01', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-27 06:02:53', '2026-01-27 06:02:53'),
(105, NULL, 9, 2, 'dep007', 'Konferancab', '2027-11-21', '2027-11-21', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-27 06:04:28', '2026-01-27 06:04:28'),
(106, NULL, 10, 1, 'dep007', 'Pelatihan Instruktur dan Pelatih (PIP)', '2026-06-01', '2026-07-01', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', NULL, '2026-01-27 06:07:14', '2026-01-27 06:07:14'),
(111, NULL, 9, 3, 'dep007', 'Safari Romadhon', '2026-02-19', '2026-03-20', 'Pasti', 1, '[\"Internal PAC\",\"Pelajar\"]', NULL, '2026-01-27 06:14:02', '2026-01-27 06:14:02'),
(112, NULL, 15, 1, 'dep007', 'Orientasi PAC Badas', '2026-02-15', '2026-02-15', 'Pasti', 1, '[\"Internal PAC\"]', NULL, '2026-01-27 06:15:14', '2026-01-27 06:15:14'),
(113, NULL, 10, 1, 'dep007', 'Skill Training Fair Jilid 2', '2025-05-18', '2025-05-18', 'Terlaksana', 1, '[\"Pengurus Ranting\",\"Pelajar\"]', NULL, '2026-01-27 06:16:21', '2026-01-27 06:16:21'),
(114, NULL, 10, 4, 'dep007', 'PORSENI PAC', '2027-09-01', '2027-09-30', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', NULL, '2026-01-27 06:16:39', '2026-01-27 06:16:39'),
(115, NULL, 9, 1, 'dep007', 'Orientasi Pengurus PAC IPNU IPPNU Wates', '2025-11-15', '2025-11-15', 'Terlaksana', 1, '[\"Internal PAC\"]', 'Pengenalan Tupoksi, Culture, Sistem kerja dari PAC', '2026-01-27 06:17:13', '2026-01-27 06:17:13'),
(117, NULL, 9, 2, 'dep007', 'Rakerancab 1', '2025-11-16', '2025-11-16', 'Terlaksana', 1, '[\"Internal PAC\"]', 'Forum resmi penyusunan pembahasan dan pengesahan program kerja seluruh departemen di PAC IPNU IPPNU Wates. Dan kegiatan ini juga menjadi langkah awal menentukan Arah Gerak organisasi selama 1 periode kedepan.', '2026-01-27 06:20:24', '2026-01-27 06:20:24'),
(118, NULL, 10, 2, 'dep007', 'Turba / Kunjungan Ranting', '2025-12-13', '2026-06-06', 'Pasti', 1, '[\"Pengurus Ranting\"]', 'Agenda kunjungan langsung ke seluruh ranting IPNU–IPPNU seKecamatan Wates.', '2026-01-27 06:23:14', '2026-01-27 06:23:14'),
(119, NULL, 12, 2, 'dep009', 'Studi Banding', '2026-07-26', '2026-07-26', 'Rencana', 0, '[\"Pelajar\"]', 'Kegiatan kunjungan ke PAC lain yang di rasa memiliki sistem kerja dan program yang baik di area korcam selatan', '2026-01-27 06:26:19', '2026-01-27 06:26:19'),
(120, NULL, 14, 2, 'dep009', 'Rapat Triwulan Pengurus PAC IPNU IPPNU Wates', '2026-01-29', '2026-01-29', 'Pasti', 1, '[\"Internal PAC\"]', 'Forum Evaluasi Internal', '2026-01-27 06:28:02', '2026-01-27 06:28:02'),
(122, NULL, 13, 2, 'dep009', 'Triwulan Kaderisasi', '2026-04-25', '2026-04-25', 'Rencana', 0, '[\"Pengurus Ranting\"]', 'Forum untuk memfollow up kader pada tiap ranting, dan akan dilaksanakan 3 bulan sekali', '2026-01-27 06:34:05', '2026-01-27 06:34:05'),
(123, NULL, 10, 2, 'dep007', 'Turba / Kunjungan Ranting', '2025-12-13', '2026-06-06', 'Rencana', 0, '[\"Pengurus Ranting\"]', 'ngaderr', '2026-01-27 06:36:11', '2026-01-27 06:36:11'),
(124, NULL, 10, 1, 'dep007', 'Ngaji kitab', '2026-01-07', '2026-12-30', 'Pasti', 1, '[\"Pelajar\"]', 'Mengkaji kitab “Kitabun Nikah”', '2026-01-27 06:45:39', '2026-01-27 06:45:39'),
(125, NULL, 9, 2, 'dep007', 'Sowan Sesepuh NU se-Kecamatan Ngancar', '2025-09-19', '2025-09-29', 'Terlaksana', 1, '[\"Alumni\",\"Banom NU Lain\"]', 'Sebagai bentuk silaturahmi dan perkenalan pengurus baru periode 2025-2027 kepada sesepuh NU se-Kecamatan Ngancar dan Alumni PAC Kecamatan Ngancar', '2026-01-27 06:47:06', '2026-01-27 06:47:06'),
(126, NULL, 9, 1, 'dep007', 'Masa Orientasi Pengurus', '2025-10-25', '2025-10-26', 'Terlaksana', 1, '[\"Internal PAC\"]', 'Sebagai bentuk Orientasi awal sesama pengurus, penguatan terhadap tugas pokok dan fungsi setiap departemen, dan media belajar pendalaman organisasi IPNU IPPNU', '2026-01-27 06:48:36', '2026-01-27 06:48:36'),
(127, NULL, 9, 3, 'dep007', 'Ziarah Wali terselubung', '2025-10-17', '2026-12-18', 'Pasti', 1, '[\"Pelajar\"]', 'Tujuan ziarah ke makam para kyai/tokoh agama di lingkungan Kec. Wates dan Kabupaten/Kota Kediri, diutamakan ke makan yang masih jarang dikunjungi masyarakat.', '2026-01-27 06:50:41', '2026-01-27 06:50:41'),
(128, NULL, 13, 2, 'dep009', 'Turun ke Bawah', '2025-12-09', '2026-01-25', 'Terlaksana', 1, '[\"Pengurus Ranting\",\"Pelajar\"]', 'Sebagai bentuk pengenalan IPNU IPPNU kepada Ranting, mengaktifkan kembali kepengurusan Ranting se-Kecamatan Ngancar, dan silaturahmi antara PAC dengan Pimpinan Ranting', '2026-01-27 06:51:07', '2026-01-29 05:00:24'),
(129, NULL, 9, 2, 'dep007', 'Pelantikan Pengurus PAC', '2026-01-11', '2026-01-11', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Banom NU Lain\"]', 'Sebagai bentuk legalitas kepengurusan Pimpinan Anak Cabang IPNU IPPNU Kecamatan Ngancar', '2026-01-27 06:52:17', '2026-01-27 06:52:17'),
(130, NULL, 9, 2, 'dep007', 'Rapat Kerja Anak Cabang I', '2026-01-18', '2026-01-18', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', 'Sebagai forum perumusan program kerja selama satu tahun pertama sesuai dengan kondisi dan kebutuhan Pimpinan Ranting', '2026-01-27 06:53:13', '2026-01-27 06:53:13'),
(131, NULL, 13, 2, 'dep009', 'Silaturahmi kepada alumni, pembina, dan stakeholder', '2026-05-02', '2026-05-17', 'Rencana', 0, '[\"Alumni\",\"Masyarakat\",\"Banom NU Lain\"]', 'Masih bersifat kondisional', '2026-01-27 06:54:48', '2026-01-27 06:54:48'),
(132, NULL, 13, 2, 'dep009', 'Ngopi bareng departemen Organisasi dan Kaderisasi', '2025-09-07', '2026-08-02', 'Pasti', 1, '[\"Internal PAC\"]', 'Dilaksanakan selama 3 bulan sekali sebagai bentuk forum evaluasi dan koordinasi antara departemen Organisasi dan Kaderisasi', '2026-01-27 06:56:42', '2026-01-27 06:56:42'),
(133, NULL, 9, 2, 'dep007', 'Rutinan Ahad Wage', '2025-11-01', '2026-12-27', 'Pasti', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', 'Dilaksanakan satu bulan sekali secara bergilir di rantingranting seKecamatan Wates.', '2026-01-27 06:58:27', '2026-01-30 03:47:37'),
(134, NULL, 14, 2, 'dep009', 'Monitoring dan Evaluasi', '2025-11-09', '2025-11-09', 'Pasti', 1, '[\"Internal PAC\"]', 'Kegiatan monitoring dan evaluasi kinerja organisasi dilaksanakan setiap akhir tahun sebagai bentuk pengukuran ketercapaian dan kebermanfaatan program', '2026-01-27 06:58:47', '2026-01-27 06:58:47'),
(135, NULL, 25, 3, 'dep010', 'Khotmil Qur`an', '2025-12-31', '2026-12-30', 'Pasti', 1, '[\"Internal PAC\"]', NULL, '2026-01-27 07:00:26', '2026-01-30 03:47:57'),
(136, NULL, 9, 3, 'dep007', 'Safari idul Fitri', '2026-03-29', '2026-03-29', 'Rencana', 0, '[\"Internal PAC\",\"Alumni\"]', 'Sebagai sarana saling mengenal antara pengurus PAC IPNU-IPPNU dengan Kyai/tokoh agama, Banom NU, dan Alumni.', '2026-01-27 07:03:35', '2026-01-27 07:03:35'),
(137, NULL, 34, 3, 'dep010', 'Ziarah Wali Jawa Timur / jawa tengah', '2027-07-24', '2027-07-25', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-27 07:08:25', '2026-01-30 03:47:24'),
(138, NULL, 10, 1, 'dep007', 'Pelatihan Administrasi', '2026-02-14', '2026-02-14', 'Pasti', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', 'Melatih peradministrasian bagi Wasek dan Sekretaris Ranting', '2026-01-27 07:13:57', '2026-01-27 07:13:57'),
(140, NULL, 10, 1, 'dep007', 'Orientasi pengurus PAC IPNU IPPNU KEC Ringinrejo', '2025-11-23', '2025-11-24', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-27 07:37:21', '2026-01-27 07:37:21'),
(141, NULL, 15, 2, 'dep007', 'Pelantikan', '2025-12-27', '2025-12-27', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Masyarakat\",\"Banom NU Lain\"]', NULL, '2026-01-27 07:39:34', '2026-01-27 07:39:34'),
(142, NULL, 14, 2, 'dep009', 'Rakerancab 1', '2025-12-27', '2025-12-27', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-27 07:40:47', '2026-01-27 07:40:47'),
(143, NULL, 14, 2, 'dep009', 'Rapim', '2026-02-08', '2026-02-08', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-27 07:41:48', '2026-01-27 07:41:48'),
(144, NULL, 13, 2, 'dep009', 'Turba ranting', '2026-04-01', '2026-04-30', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-27 07:42:40', '2026-01-27 07:42:40'),
(145, NULL, 9, 2, 'dep007', 'Database pengurus', '2026-05-01', '2026-05-31', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-27 07:44:54', '2026-01-27 07:44:54'),
(146, NULL, 11, 2, 'dep007', 'Konferancab', '2027-07-25', '2027-07-25', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Masyarakat\",\"Banom NU Lain\"]', NULL, '2026-01-27 07:46:16', '2026-01-27 07:46:16'),
(147, NULL, 10, 1, 'dep007', 'Makesta raya', '2026-04-11', '2026-04-12', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-27 07:48:00', '2026-01-27 07:48:00'),
(149, NULL, 9, 2, 'dep007', 'Rutinan ahad legi', '2026-02-08', '2026-02-08', 'Pasti', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', 'Setiap 1 bulan sekali', '2026-01-27 07:51:15', '2026-01-27 07:51:15'),
(150, NULL, 9, 3, 'dep007', 'Buka bersama dan bagi takjil', '2026-02-28', '2026-02-28', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-27 07:53:39', '2026-01-27 07:53:39'),
(151, NULL, 9, 3, 'dep007', 'Safari lebaran', '2026-03-24', '2026-03-24', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-27 07:55:05', '2026-01-27 07:55:05'),
(152, NULL, 9, 2, 'dep007', 'BSM on the road', '2026-05-01', '2026-05-31', 'Rencana', 0, '[\"Internal PAC\"]', 'Bakti sosial mushola keliling (setiap 1 bulan sekali)', '2026-01-27 08:00:08', '2026-01-27 08:00:08'),
(153, NULL, 10, 4, 'dep007', 'Rutinan badminton', '2026-01-23', '2026-01-23', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-27 08:04:07', '2026-01-27 08:04:07'),
(154, NULL, 10, 1, 'dep007', 'Mdp (mars dirijen public speaking)', '2026-07-19', '2026-07-19', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-27 08:05:16', '2026-01-27 08:05:16'),
(155, NULL, 10, 1, 'dep007', 'Studi budaya', '2026-12-01', '2026-12-01', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-27 08:08:44', '2026-01-27 08:08:44'),
(156, NULL, 11, 3, 'dep007', 'Ziaroh wali', '2027-04-24', '2027-04-25', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-27 08:09:51', '2026-01-27 08:09:51'),
(157, NULL, 9, 2, 'dep007', 'NGAMAR(NGAJI MALAM RABU)', '2026-01-06', '2026-01-06', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\",\"Banom NU Lain\"]', 'Mengkaji kitan mabadi fiqih', '2026-01-27 08:15:10', '2026-01-27 08:15:10'),
(158, NULL, 21, 3, 'dep010', 'Ziaroh', '2025-12-11', '2025-12-11', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', 'Jangan samapai kita melupakan para pendahulu kita, wa khususon para waliyullah dan muasis NU', '2026-01-27 08:26:31', '2026-01-27 08:26:31'),
(159, NULL, 9, 2, 'dep007', 'JAMDIQU', '2026-01-11', '2026-01-11', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', 'Luangkan waktumu untuk Al Qur\'an, karna ia tak pernah lalai menunggumu', '2026-01-27 08:33:50', '2026-01-27 08:33:50'),
(160, NULL, 22, 3, 'dep010', 'Pengajian akbar bersama (gus rizmi dan gus azmi)', '2025-11-02', '2025-11-02', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\",\"Banom NU Lain\"]', 'Memperingati hari besar islam', '2026-01-27 08:37:17', '2026-01-27 08:37:17'),
(161, NULL, 21, 3, 'dep010', 'ZIAROH WALI JAWA TENGAH', '2027-07-09', '2027-07-10', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', 'Mengenang para waliyullah dan muasis NU', '2026-01-27 08:40:25', '2026-01-27 08:40:25'),
(162, NULL, 9, 1, 'dep007', 'kajian Kitab', '2026-01-28', '2028-01-05', 'Pasti', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\"]', 'Rutinan yang dilaksanakan setiap malam kamis setiap seminggu sekali', '2026-01-27 17:53:55', '2026-01-27 17:53:55'),
(165, NULL, 9, 2, 'dep007', 'KONFERANCAB VIII', '2026-01-25', '2026-01-25', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\",\"Banom NU Lain\"]', NULL, '2026-01-27 20:11:11', '2026-01-27 20:11:11'),
(166, NULL, 21, 3, 'dep010', 'Ziarah Muassis Nahdlatul Ulama', '2026-01-18', '2026-01-18', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-27 20:12:20', '2026-01-27 20:12:29'),
(167, NULL, 22, 3, 'dep010', 'Pondok Romadhon SMPN 1 Ngasem', '2026-03-09', '2026-03-14', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\"]', NULL, '2026-01-27 20:20:31', '2026-01-27 20:20:31'),
(168, NULL, 23, 3, 'dep010', 'Majelis Emper Masjid', '2026-02-01', '2026-02-01', 'Rencana', 0, '[\"Pelajar\"]', NULL, '2026-01-27 21:01:26', '2026-01-27 21:01:26'),
(169, NULL, 24, 2, 'dep010', 'Sowan Pembina', '2025-02-25', '2025-02-27', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-28 03:49:53', '2026-01-28 03:49:53'),
(170, NULL, 25, 3, 'dep010', 'RA SABAR (Rutinan Ahad Pon dan Sarasehan Bareng)', '2025-03-23', '2026-12-27', 'Pasti', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Banom NU Lain\"]', NULL, '2026-01-28 03:55:40', '2026-01-28 03:55:40'),
(171, NULL, 24, 3, 'dep010', 'Safari Syawal', '2025-04-07', '2025-04-10', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-28 03:56:52', '2026-01-28 03:56:52'),
(173, NULL, 15, 2, 'dep007', 'Pelantikan', '2025-05-29', '2025-05-29', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Banom NU Lain\"]', NULL, '2026-01-28 03:59:59', '2026-01-28 03:59:59'),
(174, NULL, 35, 2, 'dep007', 'Raker (Rapat Kerja) 1', '2025-05-29', '2025-05-29', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 04:02:22', '2026-01-29 08:01:05'),
(175, NULL, 26, 2, 'dep007', 'RAPTA (Rapat Anggota)', '2025-02-22', '2026-05-30', 'Pasti', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', 'Pemilihan Ketua Ranting', '2026-01-28 04:06:33', '2026-01-28 04:06:33'),
(176, NULL, 42, 4, 'dep012', 'Pengambilan & Pengarsipan Digital Foto', '2025-07-01', '2025-07-04', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-28 04:09:31', '2026-01-29 08:00:38'),
(178, NULL, 24, 2, 'dep010', 'TURBA (Turun ke Bawah)', '2025-09-23', '2025-10-05', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 04:14:45', '2026-01-28 04:14:45'),
(179, NULL, 23, 3, 'dep010', 'Festival Seribu Terbang', '2025-10-25', '2025-10-25', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Banom NU Lain\"]', NULL, '2026-01-28 04:16:52', '2026-01-28 04:16:52'),
(181, NULL, 21, 3, 'dep010', 'Ziarah Muasis Kediri', '2025-12-14', '2025-12-14', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 04:22:39', '2026-01-28 04:22:39'),
(183, NULL, 26, 2, 'dep007', 'Rapat Pimpinan 1', '2025-09-14', '2025-09-14', 'Terlaksana', 1, '[\"Pengurus Ranting\"]', NULL, '2026-01-28 04:33:07', '2026-01-28 04:33:07'),
(185, NULL, 10, 1, 'dep007', 'Lawang Literasi 1', '2025-03-10', '2025-03-10', 'Terlaksana', 1, '[\"Internal PAC\",\"Pelajar\"]', NULL, '2026-01-28 04:42:02', '2026-01-28 04:42:02'),
(186, NULL, 10, 1, 'dep007', 'Lawang Literasi 2', '2025-09-11', '2025-09-11', 'Terlaksana', 1, '[\"Internal PAC\",\"Pelajar\"]', NULL, '2026-01-28 04:42:55', '2026-01-28 04:42:55'),
(190, NULL, 27, 2, 'dep012', 'Database', '2024-03-21', '2024-04-05', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-28 06:31:09', '2026-01-28 06:31:09'),
(191, NULL, 15, 2, 'dep007', 'Pelantikan', '2024-05-05', '2024-05-05', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-28 06:32:10', '2026-01-28 06:32:10'),
(192, NULL, 26, 2, 'dep007', 'RAKERANCAB I', '2024-05-05', '2024-05-05', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-28 06:33:02', '2026-01-28 06:33:02'),
(194, NULL, 10, 1, 'dep007', 'pelatihan dan pengembangan kader mojo (PKKMB) jilid 2', '2025-04-20', '2025-04-20', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 06:37:46', '2026-01-28 06:37:46'),
(196, NULL, 10, 1, 'dep007', 'membentuk tim paduan suara', '2025-06-23', '2025-06-23', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 06:38:40', '2026-01-28 06:38:40'),
(197, NULL, 24, 2, 'dep010', 'Turba', '2024-06-10', '2025-08-03', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', 'Turba dilaksanakan selama 4 kali yaitu pada tanggal 10 juni 2024 terlaksana di ranting Kranding, 10 juni 2024 Ranting Sukoanyar, 17 Oktober Ranting Ngadi, 2', '2026-01-28 06:38:43', '2026-01-28 06:38:43'),
(198, NULL, 10, 4, 'dep007', 'Pelatihan Design Grafis', '2024-12-22', '2024-12-22', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 06:40:03', '2026-01-28 06:41:11'),
(200, NULL, 24, 3, 'dep010', 'safari syawal', '2024-04-17', '2024-04-17', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\"]', NULL, '2026-01-28 06:41:57', '2026-01-28 06:41:57'),
(201, NULL, 28, 2, 'dep007', 'Pendirian Ranting', '2024-07-15', '2024-07-27', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', 'terlaksana mendirikan ranting Pamongan dan ranting maesan', '2026-01-28 06:42:23', '2026-01-28 06:42:23'),
(202, NULL, 12, 3, 'dep009', 'Safari Ramadhan', '2025-03-06', '2025-03-21', 'Terlaksana', 1, '[\"Pelajar\"]', NULL, '2026-01-28 06:43:40', '2026-01-28 06:43:40'),
(203, NULL, 21, 3, 'dep010', 'ziaroh wali kediri', '2024-10-04', '2024-10-04', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 06:43:59', '2026-01-28 06:43:59'),
(204, NULL, 26, 2, 'dep007', 'Rakercab II', '2025-01-29', '2025-01-29', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 06:44:01', '2026-01-28 06:44:01'),
(206, NULL, 26, 2, 'dep007', 'KONFERANCAB XX-XX', '2025-12-25', '2025-12-25', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 06:46:06', '2026-01-28 06:46:06'),
(207, NULL, 29, 4, 'dep016', 'Open order jas IPNU IPPNU', '2024-04-19', '2025-02-09', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 06:47:08', '2026-01-28 06:47:08'),
(208, NULL, 25, 3, 'dep010', 'Tawasul', '2025-03-28', '2025-03-28', 'Terlaksana', 1, '[\"Internal PAC\"]', 'setiap malam jumat', '2026-01-28 06:47:49', '2026-01-28 06:47:49'),
(209, NULL, 25, 3, 'dep010', 'Khotmil qur\'an', '2024-10-05', '2024-10-05', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 06:47:50', '2026-01-28 06:47:50'),
(210, NULL, 24, 3, 'dep010', 'buka bersama', '2025-03-21', '2025-03-21', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 06:49:44', '2026-01-28 06:49:44'),
(211, NULL, 22, 3, 'dep010', 'maulid nabi muhammad', '2025-09-19', '2025-09-19', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 06:53:20', '2026-01-28 06:53:20'),
(212, NULL, 22, 3, 'dep010', 'peringatan HSN 2025', '2025-10-21', '2025-10-21', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 06:54:49', '2026-01-28 06:54:49'),
(213, NULL, 9, 1, 'dep007', 'Orientasi Pengurus', '2025-11-02', '2025-11-02', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 07:56:37', '2026-01-28 07:56:37'),
(214, NULL, 9, 2, 'dep007', 'Rakerancab 1', '2025-11-23', '2025-11-23', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-28 07:58:10', '2026-01-28 07:58:10'),
(215, NULL, 15, 2, 'dep007', 'Pelantikan pengurus', '2025-12-28', '2025-12-28', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-28 07:59:20', '2026-01-28 07:59:20'),
(216, NULL, 9, 2, 'dep007', 'RAKERANCAB 1', '2025-02-09', '2025-02-09', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 09:10:36', '2026-01-28 09:10:36'),
(217, NULL, 9, 2, 'dep007', 'Pelantikan', '2025-01-27', '2025-01-27', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Banom NU Lain\"]', NULL, '2026-01-28 09:11:32', '2026-01-28 09:11:32'),
(218, NULL, 25, 3, 'dep010', 'Rutinan Ahad Legi', '2025-05-03', '2026-10-10', 'Pasti', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Banom NU Lain\"]', NULL, '2026-01-28 09:15:10', '2026-01-28 09:15:10'),
(219, NULL, 10, 1, 'dep007', 'Pondok Romadhon', '2025-03-03', '2026-02-21', 'Pasti', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', NULL, '2026-01-28 09:21:22', '2026-01-28 10:49:28'),
(221, NULL, 24, 3, 'dep010', 'Buka Bersama', '2026-03-07', '2026-03-07', 'Pasti', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Banom NU Lain\"]', NULL, '2026-01-28 09:29:43', '2026-01-28 10:48:12'),
(222, NULL, 9, 2, 'dep007', 'Donasi Alumni', '2025-03-01', '2026-11-01', 'Pasti', 1, '[\"Alumni\"]', NULL, '2026-01-28 09:31:33', '2026-01-28 09:31:33'),
(223, NULL, 9, 2, 'dep007', 'Kas Pengurus', '2026-03-01', '2026-11-01', 'Pasti', 1, '[\"Internal PAC\"]', 'Setiap bulan sekali', '2026-01-28 09:32:25', '2026-01-28 10:48:53'),
(224, NULL, 9, 2, 'dep007', 'Infaq', '2026-03-07', '2026-10-10', 'Pasti', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Banom NU Lain\"]', NULL, '2026-01-28 09:33:34', '2026-01-28 09:33:34'),
(225, NULL, 29, 4, 'dep016', 'Bank Sampah', '2025-02-09', '2026-11-22', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-28 09:36:56', '2026-01-28 09:36:56'),
(226, NULL, 24, 2, 'dep010', 'Turba Pra Rakerancab', '2025-10-11', '2025-11-15', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 09:40:24', '2026-01-28 09:40:24'),
(227, NULL, 24, 2, 'dep010', 'Turba Ranting Pra Rakerancab 2', '2025-10-11', '2025-11-15', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 09:42:24', '2026-01-28 09:42:24'),
(230, NULL, 24, 2, 'dep010', 'Sharing Kaderisasi', '2025-06-15', '2025-06-15', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 10:13:39', '2026-01-28 10:47:33'),
(231, NULL, 31, 2, 'dep009', 'Pembentukan dan Pendampingan PK', '2025-02-01', '2025-07-27', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-28 10:16:00', '2026-01-28 10:16:00'),
(232, NULL, 29, 4, 'dep016', 'Workshop Kewirausahaan', '2025-11-29', '2025-11-29', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Banom NU Lain\"]', NULL, '2026-01-28 10:17:29', '2026-01-28 10:17:29'),
(233, NULL, 24, 3, 'dep010', 'Safari Syawal', '2025-04-13', '2025-04-20', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Banom NU Lain\"]', NULL, '2026-01-28 10:20:07', '2026-01-28 10:20:07'),
(234, NULL, 24, 3, 'dep010', 'Halal Bi Halal', '2025-05-03', '2025-05-03', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Banom NU Lain\"]', NULL, '2026-01-28 10:21:25', '2026-01-28 10:21:25'),
(235, NULL, 29, 4, 'dep016', 'Pelajar Merch', '2025-01-27', '2026-11-30', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\",\"Banom NU Lain\"]', NULL, '2026-01-28 10:23:49', '2026-01-28 10:23:49'),
(236, NULL, 32, 4, 'dep012', 'Podcast', '2025-07-01', '2026-02-28', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-28 10:26:55', '2026-01-28 10:26:55'),
(237, NULL, 32, 1, 'dep012', 'Bedah Modul dan Tanam Pohon', '2025-05-31', '2025-05-31', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 10:29:38', '2026-01-28 10:29:38'),
(239, NULL, 9, 2, 'dep007', 'RAKERANCAB 2', '2026-01-23', '2026-01-23', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 10:32:25', '2026-01-28 10:32:25'),
(240, NULL, 32, 1, 'dep012', 'Sekolah Administrasi', '2026-05-01', '2026-05-31', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 10:33:17', '2026-01-28 10:33:17'),
(241, NULL, 32, 1, 'dep012', 'Tadabur Alam', '2026-04-01', '2026-04-30', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 10:34:15', '2026-01-28 10:34:15'),
(243, NULL, 9, 2, 'dep007', 'Rapimancab', '2026-10-01', '2026-10-31', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 10:36:05', '2026-01-28 10:36:05'),
(244, NULL, 26, 2, 'dep007', 'KONFERANCAB', '2026-11-01', '2026-11-30', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Banom NU Lain\"]', NULL, '2026-01-28 10:37:25', '2026-01-28 10:37:25'),
(246, NULL, 21, 3, 'dep010', 'Ziarah Kediri', '2026-01-31', '2026-01-31', 'Pasti', 1, '[\"Internal PAC\"]', NULL, '2026-01-28 10:38:42', '2026-01-28 10:38:42'),
(247, NULL, 32, 1, 'dep012', 'Seminar Pendidikan', '2026-01-23', '2026-10-31', 'Rencana', 0, '[\"Pelajar\",\"Masyarakat\"]', 'Kondisional', '2026-01-28 10:40:15', '2026-01-28 10:40:15'),
(252, NULL, 32, 4, 'dep012', 'Workshop Desain', '2026-06-27', '2026-06-27', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 10:44:50', '2026-01-28 10:44:50'),
(254, NULL, 32, 1, 'dep012', 'Headling Reptil', '2026-07-01', '2026-07-31', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 10:46:01', '2026-01-28 10:46:01'),
(256, NULL, 25, 2, 'dep010', 'Rakerancab I', '2024-03-31', '2024-03-31', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-28 10:58:53', '2026-01-28 10:58:53'),
(258, NULL, 15, 2, 'dep007', 'Pelantikan', '2024-03-03', '2024-03-03', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-28 10:59:58', '2026-01-28 10:59:58'),
(260, NULL, 24, 3, 'dep010', 'Safari Syawal', '2024-03-20', '2024-03-21', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 11:03:55', '2026-01-28 11:03:55'),
(261, NULL, 25, 3, 'dep010', 'Rutinan Ahad Wage', '2024-01-14', '2025-09-14', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Banom NU Lain\"]', NULL, '2026-01-28 11:05:32', '2026-01-28 11:05:32'),
(262, NULL, 34, 3, 'dep010', 'Ziaroh Sughro', '2025-01-02', '2025-01-02', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-28 11:07:41', '2026-01-28 11:07:41'),
(263, NULL, 35, 2, 'dep007', 'Rakerancab II', '2025-02-16', '2025-02-16', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 11:10:44', '2026-01-28 11:10:44'),
(265, NULL, 32, 1, 'dep012', 'Bedah Pedoman Kaderisasi', '2025-04-20', '2025-04-20', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 11:13:23', '2026-01-28 11:13:23'),
(267, NULL, 34, 3, 'dep010', 'Ziaroh Sughro II', '2025-06-19', '2025-06-19', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-28 11:15:39', '2026-01-28 11:15:39'),
(268, NULL, 25, 3, 'dep010', 'Safari Ramadhan', '2025-03-24', '2025-04-14', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-28 11:17:57', '2026-01-28 11:17:57'),
(269, NULL, 24, 3, 'dep010', 'Safari Syawal II', '2025-04-05', '2025-04-06', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Banom NU Lain\"]', NULL, '2026-01-28 11:19:43', '2026-01-28 11:19:43'),
(271, NULL, 34, 3, 'dep010', 'Ziaroh Kubro', '2025-11-15', '2025-11-16', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-28 11:22:52', '2026-01-28 11:22:52'),
(272, NULL, 36, 4, 'dep011', 'PORSENI', '2025-10-12', '2025-10-12', 'Terlaksana', 1, '[\"Pengurus Ranting\"]', NULL, '2026-01-28 11:24:24', '2026-01-28 11:24:24'),
(274, NULL, 37, 4, 'dep011', 'Badminton', '2024-07-13', '2024-07-13', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-28 11:28:52', '2026-01-28 11:28:52'),
(275, NULL, 24, 2, 'dep010', 'Quality Time', '2024-11-18', '2024-11-18', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-28 11:30:07', '2026-01-28 11:30:07'),
(276, NULL, 32, 1, 'dep012', 'Fiqih Kewanitaan', '2024-12-08', '2024-12-08', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 11:32:51', '2026-01-28 11:32:51'),
(277, NULL, 11, 5, 'dep007', 'Awarding I', '2024-12-10', '2024-12-14', 'Terlaksana', 1, '[\"Pengurus Ranting\"]', NULL, '2026-01-28 11:33:49', '2026-01-28 11:33:49'),
(278, NULL, 24, 3, 'dep010', 'Santunan & Khotmil', '2025-03-23', '2025-03-23', 'Terlaksana', 1, '[\"Pelajar\",\"Masyarakat\"]', NULL, '2026-01-28 11:36:52', '2026-01-28 11:36:52'),
(279, NULL, 9, 2, 'dep007', 'Konferancab', '2025-12-21', '2025-12-21', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-28 11:38:26', '2026-01-28 11:38:26'),
(280, NULL, 38, 1, 'dep008', 'TL 3 PIP', '2025-01-28', '2025-01-28', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-28 11:40:05', '2026-01-28 11:40:05'),
(281, NULL, 38, 1, 'dep008', 'TL 1 Lakmud', '2025-07-17', '2025-07-17', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-28 11:41:16', '2026-01-28 11:41:16'),
(282, NULL, 38, 1, 'dep008', 'TL 2 Lakmud', '2025-07-27', '2025-07-27', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-28 11:42:09', '2026-01-28 11:42:09'),
(283, NULL, 38, 1, 'dep008', 'TL 3 Lakmud', '2025-12-14', '2025-12-14', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-28 11:42:57', '2026-01-28 11:43:29'),
(284, NULL, 24, 1, 'dep010', 'Orientasi Pengurus', '2026-02-14', '2026-02-15', 'Pasti', 1, '[\"Internal PAC\"]', NULL, '2026-01-28 11:44:23', '2026-01-28 11:44:23'),
(285, NULL, 10, 1, 'dep007', 'Sport Activity 1', '2025-06-15', '2025-06-15', 'Terlaksana', 1, '[\"Internal PAC\",\"Pelajar\"]', NULL, '2026-01-28 19:42:17', '2026-01-28 20:10:56'),
(286, NULL, 10, 1, 'dep007', 'Sport Activity 2', '2025-11-09', '2025-11-09', 'Terlaksana', 1, '[\"Internal PAC\",\"Pelajar\"]', NULL, '2026-01-28 19:43:20', '2026-01-28 20:12:02'),
(287, NULL, 10, 1, 'dep007', 'Sport Activity 3', '2026-01-22', '2026-01-22', 'Terlaksana', 1, '[\"Internal PAC\",\"Pelajar\"]', NULL, '2026-01-28 19:43:44', '2026-01-28 20:12:24'),
(289, NULL, 39, 1, 'dep007', 'Rilis Buku Saku', '2026-04-05', '2026-04-19', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-28 21:41:14', '2026-01-28 21:41:14'),
(290, NULL, 14, 1, 'dep009', 'WIBU (Wadah Inspirasi Belajar kader NU)', '2026-05-24', '2026-05-31', 'Rencana', 0, '[\"Pengurus Ranting\"]', NULL, '2026-01-28 21:43:59', '2026-01-28 21:43:59'),
(291, NULL, 40, 1, 'dep007', 'Pengembangan Medsos Depor', '2026-03-22', '2027-06-27', 'Rencana', 0, '[\"Pelajar\",\"Masyarakat\"]', NULL, '2026-01-28 21:46:59', '2026-01-28 21:46:59'),
(293, NULL, 26, 2, 'dep007', 'Konferancab', '2027-07-25', '2027-07-25', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-28 21:53:28', '2026-01-28 21:53:28'),
(294, NULL, 39, 1, 'dep007', 'Orientasi PAC', '2026-04-19', '2026-04-19', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 02:56:44', '2026-01-29 02:56:44'),
(295, NULL, 15, 2, 'dep007', 'Pelantikan PAC IPNU IPNNU Kunjang', '2026-02-28', '2026-03-08', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Banom NU Lain\"]', NULL, '2026-01-29 03:07:48', '2026-01-30 07:23:16'),
(296, NULL, 32, 1, 'dep012', 'Syafari Ramadhan', '2026-03-12', '2026-03-14', 'Rencana', 0, '[\"Pelajar\"]', NULL, '2026-01-29 03:09:23', '2026-01-29 03:09:23'),
(298, NULL, 39, 1, 'dep007', 'upgrading pengurus', '2026-05-31', '2026-05-31', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 05:02:28', '2026-01-29 05:02:46'),
(299, NULL, 10, 1, 'dep007', 'pengawalan makesta ranting/pk', '2026-08-10', '2026-08-10', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', NULL, '2026-01-29 05:04:12', '2026-01-29 05:04:12'),
(300, NULL, 32, 1, 'dep012', 'forum kaderisasi', '2026-02-12', '2026-02-12', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 05:05:30', '2026-01-29 05:05:30'),
(301, NULL, 32, 1, 'dep012', 'Orientasi', '2025-08-31', '2025-08-31', 'Terlaksana', 1, '[\"Internal PAC\"]', 'Untuk mempererat tali silaturahmi antar pengurus PAC pare', '2026-01-29 05:22:55', '2026-01-29 05:22:55'),
(302, NULL, 9, 3, 'dep007', 'PHBI isra mi\'raj', '2026-01-17', '2026-01-18', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\"]', NULL, '2026-01-29 05:24:26', '2026-01-29 05:24:37'),
(303, NULL, 9, 3, 'dep007', 'harlah IPNU', '2026-02-24', '2026-02-24', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', NULL, '2026-01-29 05:25:43', '2026-01-29 05:25:43'),
(304, NULL, 9, 3, 'dep007', 'HARLAH IPPNU', '2026-03-02', '2026-03-02', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', NULL, '2026-01-29 05:26:55', '2026-01-29 05:26:55'),
(305, NULL, 32, 1, 'dep012', 'Seminar kepemimpinan, administrasi,dan kaderisasi', '2026-12-06', '2026-12-06', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', 'Untuk edukasi kepada rekan dan rekanita khususnya di PR danPK', '2026-01-29 05:27:32', '2026-01-29 05:27:32'),
(306, NULL, 9, 2, 'dep007', 'PONDOK ROMADHON', '2026-03-07', '2026-03-08', 'Rencana', 0, '[\"Pengurus Ranting\",\"Pelajar\"]', NULL, '2026-01-29 05:28:01', '2026-01-29 05:28:01'),
(307, NULL, 13, 3, 'dep009', 'BUKA BERSAMA', '2026-03-11', '2026-03-11', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 05:29:00', '2026-01-29 05:29:12'),
(308, NULL, 13, 2, 'dep009', 'Pembentukan ika (ikatan alumni', '2026-05-31', '2026-05-31', 'Rencana', 0, '[\"Internal PAC\",\"Alumni\"]', 'Untuk koordinasi terus bersama alumni dan menjalin tali silahturahmi', '2026-01-29 05:29:57', '2026-01-29 05:29:57'),
(309, NULL, 9, 2, 'dep007', 'SYAFARI SYAWAL', '2026-03-24', '2026-03-26', 'Rencana', 0, '[\"Alumni\",\"Masyarakat\"]', NULL, '2026-01-29 05:30:52', '2026-01-29 05:30:52'),
(310, NULL, 9, 2, 'dep007', 'RUTINAN AHAD LEGI', '2026-01-21', '2026-01-21', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\"]', NULL, '2026-01-29 05:32:15', '2026-01-29 05:32:15'),
(311, NULL, 35, 2, 'dep007', 'Rakerancab ll', '2026-07-25', '2026-07-25', 'Rencana', 0, '[\"Internal PAC\"]', 'Untuk rencana kerja dan mematangkan kembali program yang belum terlaksana di pac', '2026-01-29 05:32:27', '2026-01-29 05:32:27'),
(312, NULL, 21, 3, 'dep010', 'ZIAROH', '2026-06-13', '2026-06-14', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\"]', NULL, '2026-01-29 05:33:22', '2026-01-29 05:33:22'),
(313, NULL, 22, 3, 'dep010', 'PHBI MAULID NABI', '2026-08-25', '2026-08-25', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 05:34:24', '2026-01-29 05:34:24'),
(314, NULL, 39, 1, 'dep007', 'Upgrading', '2026-12-26', '2026-12-26', 'Rencana', 0, '[\"Internal PAC\"]', 'Mematangkan kembali program² di pac', '2026-01-29 05:35:26', '2026-01-29 05:35:26'),
(315, NULL, 10, 2, 'dep007', 'TURBA KOMISARIAT', '2026-09-10', '2026-09-10', 'Rencana', 0, '[\"Pelajar\"]', NULL, '2026-01-29 05:37:24', '2026-01-29 05:37:24'),
(316, NULL, 25, 2, 'dep010', 'Rapat pac ( PH dan pengurus)', '2026-01-18', '2026-01-18', 'Terlaksana', 1, '[\"Internal PAC\"]', 'Rapat evaluasi untuk pengurus PAC pare', '2026-01-29 05:37:57', '2026-01-29 05:37:57'),
(319, NULL, 9, 2, 'dep007', 'pelantikan', '2024-02-25', '2024-02-25', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-29 05:39:10', '2026-01-29 05:40:11'),
(320, NULL, 35, 2, 'dep007', 'Rakerancab 1', '2024-02-25', '2024-02-25', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-29 05:39:52', '2026-01-29 05:39:52'),
(321, NULL, 28, 2, 'dep007', 'Rapta dan pembentukan PR dan ranting', '2025-11-23', '2025-11-23', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', 'Pembentukan PR dan PK', '2026-01-29 05:40:02', '2026-01-29 05:40:02'),
(322, NULL, 11, 5, 'dep007', 'FUN GAME', '2026-02-15', '2026-02-15', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', NULL, '2026-01-29 05:40:17', '2026-01-29 05:40:17'),
(323, NULL, 13, 2, 'dep009', 'Turba ranting', '2025-10-26', '2025-10-26', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', 'Untuk mengkoordinasikan ranting dan PK', '2026-01-29 05:41:18', '2026-01-29 05:41:18'),
(324, NULL, 13, 2, 'dep009', 'Turba ranting', '2025-10-26', '2025-10-26', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', 'Untuk mengkoordinasikan ranting dan PK', '2026-01-29 05:42:08', '2026-01-29 05:42:08'),
(325, NULL, 40, 4, 'dep007', 'PORSENI 1', '2026-02-28', '2026-03-01', 'Rencana', 0, '[\"Pengurus Ranting\",\"Pelajar\",\"Masyarakat\"]', NULL, '2026-01-29 05:42:31', '2026-01-29 05:42:31'),
(326, NULL, 9, 2, 'dep007', 'RAPAT INTERNAL DEPARTEMEN DESBOR', '2026-02-08', '2026-02-08', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 05:43:48', '2026-01-29 05:43:48'),
(328, NULL, 40, 1, 'dep007', 'pemaksimalam media sosial', '2026-02-22', '2026-02-22', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-29 05:46:39', '2026-01-29 05:46:39'),
(329, NULL, 40, 1, 'dep007', 'peliputan kegiatan', '2026-02-22', '2026-02-22', 'Rencana', 0, '[\"Internal PAC\"]', 'setiap setelah kegiatan', '2026-01-29 05:47:56', '2026-01-29 05:47:56'),
(330, NULL, 40, 1, 'dep007', 'pembuatan pamflet tiap kegiatan', '2026-02-22', '2026-02-22', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 05:48:41', '2026-01-29 05:48:41'),
(331, NULL, 10, 1, 'dep007', 'Pondok Ramadhan', '2024-03-26', '2024-04-05', 'Terlaksana', 1, '[\"Pelajar\"]', NULL, '2026-01-29 05:49:15', '2026-01-29 05:49:15'),
(332, NULL, 40, 1, 'dep007', 'pengaktifan medsos se kecamatan', '2026-02-22', '2026-02-22', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 05:49:25', '2026-01-29 05:49:25'),
(333, NULL, 40, 4, 'dep007', 'foto pengurus dan departemen', '2026-02-22', '2026-02-22', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 05:50:09', '2026-01-29 05:50:09');
INSERT INTO `realisasi_program` (`id`, `organisasi_id`, `kategori_program_id`, `id_kategori_baru`, `departemen_id`, `nama_lokal`, `tgl_mulai`, `tgl_selesai`, `status`, `is_fix`, `target_peserta`, `deskripsi`, `created_at`, `updated_at`) VALUES
(334, NULL, 40, 2, 'dep007', 'rapat internal anggota pers', '2026-02-22', '2026-02-22', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 05:50:51', '2026-01-29 05:50:51'),
(336, NULL, 35, 2, 'dep007', 'Rakerancab 2', '2025-01-19', '2025-01-19', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-29 05:52:37', '2026-01-29 05:52:37'),
(337, NULL, 9, 2, 'dep007', 'Konferancab', '2025-11-29', '2025-11-30', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Banom NU Lain\"]', NULL, '2026-01-29 05:54:13', '2026-01-29 05:54:13'),
(338, NULL, 24, 2, 'dep010', 'Sapa Kader', '2024-07-04', '2024-07-04', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-29 05:57:23', '2026-01-29 05:57:23'),
(340, NULL, 9, 2, 'dep007', 'Penyusunan Administrasi', '2026-02-06', '2026-02-07', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 05:59:35', '2026-01-29 05:59:35'),
(342, NULL, 27, 2, 'dep012', 'Pengelolaan Arsip', '2026-02-07', '2026-02-08', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 06:02:14', '2026-01-29 06:02:14'),
(343, NULL, 24, 2, 'dep010', 'Syafari Syawal', '2024-04-14', '2024-04-15', 'Terlaksana', 1, '[\"Alumni\",\"Banom NU Lain\"]', NULL, '2026-01-29 06:02:20', '2026-01-29 06:02:20'),
(344, NULL, 24, 2, 'dep010', 'Syafari Syawal', '2025-04-04', '2025-04-04', 'Terlaksana', 1, '[\"Alumni\",\"Banom NU Lain\"]', NULL, '2026-01-29 06:02:53', '2026-01-29 06:02:53'),
(345, NULL, 9, 2, 'dep007', 'Pengelolaan Data Anggota', '2026-02-07', '2026-02-08', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 06:05:12', '2026-01-29 06:05:12'),
(346, NULL, 21, 3, 'dep010', 'khotmil qur\'an', '2025-05-25', '2025-05-25', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-29 06:07:56', '2026-01-29 06:07:56'),
(347, NULL, 9, 2, 'dep007', 'Pembuatan Surat Menyurat', '2026-02-07', '2026-02-08', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-29 06:08:15', '2026-01-29 06:08:15'),
(348, NULL, 34, 3, 'dep010', 'Ziarah Wali', '2025-04-19', '2025-04-20', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-29 06:08:40', '2026-01-29 06:08:40'),
(350, NULL, 41, 4, 'dep011', 'GASPAK (Gebyar Seni Pelajar  Kreatif)', '2024-06-21', '2024-06-21', 'Terlaksana', 1, '[\"Pengurus Ranting\",\"Pelajar\"]', NULL, '2026-01-29 06:10:13', '2026-01-29 06:10:13'),
(351, NULL, 9, 2, 'dep007', 'Pengelolaan Keuangan', '2025-11-01', '2027-05-01', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 06:11:53', '2026-01-30 00:01:35'),
(352, NULL, 9, 2, 'dep007', 'Pelaporan Keuangan', '2025-11-01', '2027-05-01', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 06:13:29', '2026-01-29 23:58:00'),
(353, NULL, 9, 2, 'dep007', 'Pendapatan dan  Pengumpulan Dana', '2025-11-01', '2026-05-01', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 06:14:54', '2026-01-30 00:01:06'),
(354, NULL, 9, 4, 'dep007', 'Digitalisasi Administrasi', '2025-11-01', '2027-05-01', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 06:16:15', '2026-01-30 00:00:35'),
(357, NULL, 39, 1, 'dep007', 'Gerakan 1 Kader 1 Ranting', '2025-11-01', '2027-05-01', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 06:21:46', '2026-01-29 23:57:01'),
(359, NULL, 40, 1, 'dep007', 'Reward dan Punishment', '2025-11-01', '2027-05-01', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 06:23:15', '2026-01-29 23:55:30'),
(360, NULL, 9, 2, 'dep007', 'Laporan Mingguan via Grup Online', '2025-11-01', '2027-05-01', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 06:24:01', '2026-01-29 23:53:59'),
(361, NULL, 37, 4, 'dep011', 'sparing futsal', '2025-02-09', '2025-02-09', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-29 06:24:19', '2026-01-29 06:24:19'),
(362, NULL, 9, 2, 'dep007', 'RAKER II', '2026-05-15', '2026-05-15', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 06:25:14', '2026-01-29 06:25:14'),
(363, NULL, 9, 2, 'dep007', 'KONFERCAB VII', '2027-05-03', '2027-05-03', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 06:26:28', '2026-01-29 06:26:28'),
(364, NULL, 37, 4, 'dep011', 'sparing futsal', '2025-08-26', '2025-08-26', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-29 06:30:20', '2026-01-29 06:33:23'),
(367, NULL, 40, 4, 'dep007', 'Mengelola sosmed pac', '2025-08-24', '2027-07-24', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\",\"Banom NU Lain\"]', 'Mengelola media sosial pac', '2026-01-29 06:35:11', '2026-01-29 06:35:11'),
(368, NULL, 38, 1, 'dep008', 'TL LAKMUD 1', '2025-07-06', '2025-07-06', 'Terlaksana', 1, '[\"Pengurus Ranting\"]', NULL, '2026-01-29 06:37:50', '2026-01-29 06:37:50'),
(369, NULL, 42, 2, 'dep012', 'Pemotretan anggota dan departemen pac', '2026-02-01', '2026-02-01', 'Pasti', 1, '[\"Internal PAC\"]', 'Foto Resmi pengurus', '2026-01-29 06:39:34', '2026-01-29 06:39:34'),
(370, NULL, 38, 1, 'dep008', 'TL LAKMUD 2', '2025-07-13', '2025-07-13', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-29 06:41:02', '2026-01-29 06:41:02'),
(371, NULL, 39, 4, 'dep007', 'Video profil organisasi', '2026-09-15', '2026-09-15', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\",\"Banom NU Lain\"]', 'Untuk memperkenalkan organisasi', '2026-01-29 06:41:57', '2026-01-29 06:41:57'),
(372, NULL, 32, 4, 'dep012', 'Meningkatkan jumlah pengikut sosmed', '2025-08-24', '2025-08-24', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\",\"Banom NU Lain\"]', 'Mengenalkan organisasi', '2026-01-29 06:44:28', '2026-01-29 06:44:28'),
(373, NULL, 32, 4, 'dep012', 'Vidio/foto dokumentasi setiap kegiatan', '2025-08-24', '2027-07-24', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\",\"Banom NU Lain\"]', 'Sebagai dokumentasi setiap kegiatan', '2026-01-29 06:46:17', '2026-01-29 06:46:17'),
(374, NULL, 9, 4, 'dep007', 'Publikasi kegiatan di sosmed', '2025-08-24', '2027-08-24', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\",\"Banom NU Lain\"]', 'Sebagai dokumentasi di sosmed', '2026-01-29 06:49:27', '2026-01-29 06:49:27'),
(375, NULL, 35, 2, 'dep007', 'RAKERANCAB 1', '2025-03-15', '2025-03-15', 'Terlaksana', 1, '[\"Pengurus Ranting\"]', NULL, '2026-01-29 06:59:07', '2026-01-30 05:48:15'),
(378, NULL, 14, 2, 'dep009', 'MAKRAB (Malam Keakraban)', '2025-09-27', '2025-09-28', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-29 07:12:47', '2026-01-30 05:44:12'),
(379, NULL, 15, 2, 'dep007', 'PELANTIKAN PIMPINAN RANTING SERENTAK', '2025-07-28', '2025-07-28', 'Terlaksana', 1, '[\"Pengurus Ranting\"]', NULL, '2026-01-29 07:17:46', '2026-01-30 05:37:37'),
(384, NULL, 37, 4, 'dep011', 'MABAR FUN FUTSAL (Main Bareng Futsal)', '2025-02-25', '2025-11-08', 'Terlaksana', 1, '[\"Pelajar\"]', NULL, '2026-01-29 07:41:10', '2026-01-30 05:36:01'),
(387, NULL, 40, 1, 'dep007', 'Mengunjungi Sekolah dan Pesantren', '2025-09-07', '2025-09-07', 'Terlaksana', 1, '[\"Pelajar\"]', NULL, '2026-01-29 07:47:08', '2026-01-29 07:47:08'),
(390, NULL, 31, 2, 'dep009', 'PENDIRIAN PIMPINAN KOMISARIAT', '2025-07-19', '2025-12-18', 'Terlaksana', 1, '[\"Pengurus Ranting\"]', NULL, '2026-01-29 07:50:27', '2026-01-30 05:35:06'),
(391, NULL, 25, 3, 'dep010', 'NGASHO (Rutinan ngaji dan sholawat)', '2024-05-05', '2025-09-21', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\",\"Banom NU Lain\"]', NULL, '2026-01-29 07:50:32', '2026-01-29 07:50:32'),
(392, NULL, 34, 3, 'dep010', 'Ziarah Wali Kediri', '2024-12-14', '2024-12-15', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-29 07:56:04', '2026-01-29 07:56:04'),
(393, NULL, 40, 1, 'dep007', 'IPNU IPPNU MENGABDI', '2025-03-13', '2025-03-22', 'Terlaksana', 1, '[\"Masyarakat\"]', NULL, '2026-01-29 07:57:44', '2026-01-29 07:57:44'),
(394, NULL, 23, 3, 'dep010', 'Rutinan Sholawat', '2026-02-05', '2026-02-05', 'Pasti', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', NULL, '2026-01-29 07:59:24', '2026-01-29 07:59:24'),
(395, NULL, 9, 3, 'dep007', 'BUKBER & HARLAH IPNU IPPNU', '2025-03-15', '2025-03-15', 'Terlaksana', 1, '[\"Pengurus Ranting\"]', NULL, '2026-01-29 08:02:09', '2026-01-30 05:34:34'),
(396, NULL, 24, 3, 'dep010', 'SAFARI SYAWAL', '2025-04-06', '2025-04-13', 'Terlaksana', 1, '[\"Banom NU Lain\"]', NULL, '2026-01-29 08:04:13', '2026-01-29 08:04:13'),
(397, NULL, 23, 3, 'dep010', 'RUTINAN MAULID SAMAWA', '2025-05-30', '2026-01-19', 'Terlaksana', 1, '[\"Masyarakat\"]', NULL, '2026-01-29 08:09:16', '2026-01-29 08:09:16'),
(398, NULL, 34, 3, 'dep010', 'ZIARAH BULANAN', '2025-04-30', '2025-11-30', 'Rencana', 0, '[\"Pengurus Ranting\"]', NULL, '2026-01-29 08:20:05', '2026-01-29 08:20:05'),
(400, NULL, 24, 3, 'dep010', 'safari syawal', '2025-04-05', '2025-04-12', 'Terlaksana', 1, '[\"Alumni\",\"Banom NU Lain\"]', NULL, '2026-01-29 17:32:31', '2026-01-29 17:32:31'),
(401, NULL, 24, 3, 'dep010', 'bagi bagi takjil', '2025-03-22', '2025-03-22', 'Terlaksana', 1, '[\"Internal PAC\",\"Pelajar\",\"Masyarakat\"]', NULL, '2026-01-29 17:35:04', '2026-01-29 17:35:04'),
(402, NULL, 24, 3, 'dep010', 'bagi bagi takjil', '2025-03-22', '2025-03-22', 'Terlaksana', 1, '[\"Internal PAC\",\"Pelajar\",\"Masyarakat\"]', NULL, '2026-01-29 17:35:05', '2026-01-29 17:35:05'),
(403, NULL, 37, 4, 'dep011', 'voli', '2025-08-16', '2025-08-17', 'Terlaksana', 1, '[\"Pengurus Ranting\",\"Pelajar\"]', NULL, '2026-01-29 17:38:40', '2026-01-29 17:38:40'),
(404, NULL, 35, 2, 'dep007', 'konferancab', '2026-01-18', '2026-01-18', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Banom NU Lain\"]', NULL, '2026-01-29 17:42:36', '2026-01-29 17:42:36'),
(405, NULL, 35, 2, 'dep007', 'konferancab', '2026-01-18', '2026-01-18', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Banom NU Lain\"]', NULL, '2026-01-29 17:42:37', '2026-01-29 17:42:37'),
(406, NULL, 36, 4, 'dep011', 'Porseni', '2027-05-29', '2027-05-30', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', 'Menguatkan kader kreatif', '2026-01-29 21:10:27', '2026-01-29 21:10:27'),
(408, NULL, 25, 4, 'dep010', 'Liga persahabatan', '2025-12-13', '2025-12-13', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\"]', 'Mempererat silaturrahmi antar pengurus pr PAC dan PAC luar', '2026-01-29 21:15:40', '2026-01-29 21:15:40'),
(409, NULL, 40, 4, 'dep007', 'Badminton', '2025-12-20', '2025-12-20', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\"]', NULL, '2026-01-29 21:17:35', '2026-01-29 21:17:35'),
(410, NULL, 40, 4, 'dep007', 'Futsal', '2026-02-08', '2026-02-08', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\"]', NULL, '2026-01-29 21:18:41', '2026-01-29 21:18:41'),
(411, NULL, 40, 1, 'dep007', 'Teater', '2026-04-12', '2026-04-12', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\",\"Masyarakat\"]', NULL, '2026-01-29 21:19:35', '2026-01-29 21:19:35'),
(412, NULL, 29, 4, 'dep016', 'Pembuatan dan penjualan jas,pdh dan batik ipnu ippnu', '2025-09-07', '2027-05-31', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-29 21:23:26', '2026-01-29 21:23:26'),
(413, NULL, 29, 4, 'dep016', 'Sekolah ekonomi', '2026-07-26', '2026-07-26', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\"]', NULL, '2026-01-29 21:24:24', '2026-01-29 21:24:24'),
(414, NULL, 29, 4, 'dep016', 'Student anterpreneur atau buka stand', '2026-07-05', '2027-05-02', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 21:25:39', '2026-01-29 21:25:39'),
(418, NULL, 26, 2, 'dep007', 'Forum kaderisasi', '2025-10-05', '2027-06-30', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', NULL, '2026-01-29 21:31:01', '2026-01-29 21:31:01'),
(419, NULL, 43, 1, 'dep007', 'Orientasi', '2026-01-24', '2026-01-25', 'Terlaksana', 1, '[\"Internal PAC\"]', 'Pengenalan dan Pendalaman Organisasi', '2026-01-29 22:54:45', '2026-01-29 22:54:45'),
(420, NULL, 15, 2, 'dep007', 'Pelantikan', '2026-04-01', '2026-04-01', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 23:11:59', '2026-01-29 23:11:59'),
(421, NULL, 35, 2, 'dep007', 'Rakerancab', '2026-09-28', '2026-09-28', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 23:13:51', '2026-01-29 23:13:51'),
(422, NULL, 21, 4, 'dep010', 'Digitalisasi Manuskrip', '2026-06-05', '2026-06-05', 'Rencana', 0, '[\"Pengurus Ranting\"]', NULL, '2026-01-29 23:20:04', '2026-01-29 23:20:04'),
(423, NULL, 44, 3, 'dep011', 'Festival Banjari', '2026-12-10', '2026-12-10', 'Rencana', 0, '[\"Pelajar\"]', NULL, '2026-01-29 23:21:14', '2026-01-29 23:21:14'),
(425, NULL, 37, 4, 'dep011', 'Futsal', '2026-02-01', '2026-02-01', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 23:22:33', '2026-01-29 23:22:33'),
(426, NULL, 40, 4, 'dep007', 'Porseni', '2026-12-10', '2026-12-10', 'Rencana', 0, '[\"Pengurus Ranting\"]', NULL, '2026-01-29 23:23:02', '2026-01-29 23:32:28'),
(427, NULL, 10, 1, 'dep007', 'Learning Trip', '2026-03-07', '2026-03-07', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-29 23:33:02', '2026-01-29 23:33:02'),
(431, NULL, 9, 1, 'dep007', 'Pendampingan Makesta', '2026-07-17', '2026-07-18', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-29 23:40:03', '2026-01-29 23:40:03'),
(432, NULL, 40, 4, 'dep007', 'Lomba  Memperingati  Tahun Baru Islam', '2026-06-17', '2026-06-19', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', NULL, '2026-01-29 23:41:21', '2026-01-29 23:41:21'),
(433, NULL, 23, 3, 'dep010', 'Rutinan Diba\'iyyah', '2026-01-01', '2027-05-01', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\",\"Masyarakat\"]', NULL, '2026-01-29 23:42:34', '2026-01-29 23:42:34'),
(436, NULL, 34, 3, 'dep010', 'Ziarah', '2027-03-17', '2027-03-18', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\",\"Masyarakat\",\"Banom NU Lain\"]', NULL, '2026-01-30 00:03:16', '2026-01-30 00:03:16'),
(437, NULL, 40, 1, 'dep007', 'Ngopi Bareng (Ngobar)', '2025-11-01', '2027-05-01', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\",\"Masyarakat\"]', NULL, '2026-01-30 00:04:50', '2026-01-30 00:04:50'),
(438, NULL, 40, 1, 'dep007', 'Dolan Bareng (Dolbar)', '2026-06-05', '2026-06-07', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\",\"Masyarakat\"]', NULL, '2026-01-30 00:07:58', '2026-01-30 00:07:58'),
(441, NULL, 40, 4, 'dep007', 'Manajemen Konten Sosial Media', '2025-11-01', '2027-05-01', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-30 00:13:06', '2026-01-30 00:13:06'),
(442, NULL, 9, 2, 'dep007', 'Liputan &  Dokumentasi  Kegiatan', '2025-11-01', '2027-05-01', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-30 00:14:10', '2026-01-30 00:14:10'),
(443, NULL, 32, 4, 'dep012', 'Edukasi Literasi Digital Pelajar', '2026-06-13', '2026-06-15', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\",\"Masyarakat\"]', NULL, '2026-01-30 00:15:27', '2026-01-30 00:15:27'),
(444, NULL, 29, 4, 'dep016', 'Monitoring & Evaluasi', '2025-11-01', '2027-05-01', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-30 00:19:21', '2026-01-30 00:19:21'),
(446, NULL, 13, 2, 'dep009', 'Pengawalan Penyusunan SPP', '2024-08-11', '2025-12-28', 'Terlaksana', 1, '[\"Pengurus Ranting\"]', 'Program kerja dengan tujuan membersamai dan mengawal ranting serta komisariat dalam menyusun administrasi SPP', '2026-01-30 02:59:54', '2026-01-30 02:59:54'),
(447, NULL, 11, 5, 'dep007', 'PAC Award', '2025-12-30', '2026-03-29', 'Pasti', 1, '[\"Pengurus Ranting\"]', 'Awarding ranting dan komisariat seKecamatan Kepung guna memberikan apresiasi dan evaluasi kinerja masing masing pimpinan', '2026-01-30 03:01:43', '2026-01-30 03:01:43'),
(448, NULL, 9, 2, 'dep007', 'Turba', '2026-04-19', '2026-04-26', 'Rencana', 0, '[\"Pengurus Ranting\"]', 'Proker dengan sasaran ranting se kecamatan Kepung guna menjalin silaturrahim dan evaluasi progres ranting', '2026-01-30 03:04:25', '2026-01-30 03:04:25'),
(449, NULL, 9, 2, 'dep007', 'KONFERANCAB', '2026-05-02', '2026-05-03', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', 'Agenda wajib diakhir kepengurusan guna regenerasi pengurus', '2026-01-30 03:05:53', '2026-01-30 03:06:26'),
(450, NULL, 35, 2, 'dep007', 'RAKERANCAB 1', '2024-08-04', '2024-08-04', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', 'Forum rapat kerja guna membahas dan mengesahkan program kerja tahunan di PAC Kepung', '2026-01-30 03:07:55', '2026-01-30 03:07:55'),
(451, NULL, 35, 2, 'dep007', 'RAKERANCAB 2', '2025-03-16', '2025-03-16', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', 'forum rapat kerja guna evaluasi progres kerja satu tahun pertama dan pengesahan program kerja tahun kedua', '2026-01-30 03:09:30', '2026-01-30 03:09:30'),
(452, NULL, 32, 1, 'dep012', 'Sosialisasi Makesta', '2025-05-18', '2025-05-18', 'Terlaksana', 1, '[\"Pengurus Ranting\",\"Pelajar\"]', 'Proker dengan tujuan menambah wawasan terkait pengkaderan ditingkat ranting dan komisariat', '2026-01-30 03:12:21', '2026-01-30 03:12:21'),
(456, NULL, 25, 3, 'dep010', 'Rutinan Dibaiyah dan Ngaji', '2025-03-16', '2026-02-08', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\",\"Masyarakat\"]', 'Agenda Wajib PAC guna menumbuhkan dan meneguhkan nilai nilai aswaja dalam diri kader', '2026-01-30 03:16:30', '2026-01-30 03:24:00'),
(458, NULL, 24, 2, 'dep010', 'Syafari Syawwal', '2025-04-12', '2025-04-15', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', 'Silaturahim ke Pembina, Masyayikh, dan alumni PAC', '2026-01-30 03:18:31', '2026-01-30 03:18:31'),
(460, NULL, 34, 3, 'dep010', 'Ziaroh Pra KONFERANCAB', '2026-02-14', '2026-02-15', 'Pasti', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\"]', 'Memperkenalkan kader kepada para pendiri IPNU IPPNU dan menumbuhkan nilai kebersamaan antar kader', '2026-01-30 03:20:19', '2026-01-30 03:23:44'),
(461, NULL, 10, 1, 'dep007', 'PSD(Point of Student Development)', '2027-03-14', '2027-03-28', 'Rencana', 0, '[\"Internal PAC\",\"Pelajar\"]', NULL, '2026-01-30 03:22:09', '2026-01-30 03:22:09'),
(462, NULL, 21, 3, 'dep010', 'Tabarukan Meraih kejayaan', '2026-02-22', '2027-04-25', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-30 03:23:34', '2026-01-30 03:23:34'),
(463, NULL, 25, 4, 'dep010', 'Rutinan Bulu Tangkis dan Futsal', '2024-05-12', '2026-01-18', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\",\"Masyarakat\"]', 'Rutinan bidang Olahraga untuk menguatkan dan menambah daya tarik kader', '2026-01-30 03:25:51', '2026-01-30 03:25:51'),
(464, NULL, 13, 2, 'dep009', 'Sharing And Hearing Ranting Experience', '2026-04-05', '2026-04-26', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-30 03:26:33', '2026-01-30 03:26:33'),
(465, NULL, 9, 2, 'dep007', 'PELANTIKAN', '2024-03-03', '2024-03-03', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Banom NU Lain\"]', 'Agenda wajib diawal kepengurusan', '2026-01-30 03:26:56', '2026-01-30 03:26:56'),
(466, NULL, 22, 3, 'dep010', 'Tarokan Festival', '2026-10-18', '2026-10-18', 'Rencana', 0, '[\"Pengurus Ranting\",\"Pelajar\",\"Masyarakat\"]', NULL, '2026-01-30 03:28:00', '2026-01-30 03:28:00'),
(467, NULL, 41, 4, 'dep011', 'FETSPA 2026', '2026-01-01', '2026-04-26', 'Pasti', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', 'Festival Pra KONFERANCAB', '2026-01-30 03:28:52', '2026-01-30 03:28:52'),
(468, NULL, 25, 2, 'dep010', 'RAPATAR', '2026-02-01', '2027-06-27', 'Pasti', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-30 03:29:24', '2026-01-30 03:29:24'),
(469, NULL, 32, 1, 'dep012', 'LEGACY', '2025-04-20', '2025-04-20', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', 'Pelatihan Mars dan MC', '2026-01-30 03:30:49', '2026-01-30 03:30:49'),
(470, NULL, 22, 3, 'dep010', 'Safari Ramadhan', '2026-02-23', '2026-03-16', 'Rencana', 0, '[\"Pelajar\",\"Masyarakat\"]', NULL, '2026-01-30 03:31:12', '2026-01-30 03:31:12'),
(471, NULL, 32, 1, 'dep012', 'Sharing Media', '2025-04-13', '2026-01-25', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', 'Proker guna memberikan wadah komunikasi dan koordinasi tim media', '2026-01-30 03:32:01', '2026-01-30 03:32:01'),
(472, NULL, 24, 3, 'dep010', 'Safari Syawal', '2026-03-29', '2026-03-30', 'Rencana', 0, '[\"Internal PAC\",\"Banom NU Lain\"]', NULL, '2026-01-30 03:32:27', '2026-01-30 03:32:27'),
(473, NULL, 25, 3, 'dep010', 'Rutinan Darul Hidayah', '2024-05-06', '2025-12-01', 'Terlaksana', 1, '[\"Internal PAC\",\"Pelajar\"]', 'Rutinan pembekalan dan penyampaian materi di PKPP Darul Hidayah Sumbersari Kepung', '2026-01-30 03:33:25', '2026-01-30 03:33:25'),
(474, NULL, 34, 3, 'dep010', 'Ziaroh Muasis', '2027-06-12', '2027-06-14', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-30 03:33:34', '2026-01-30 03:33:34'),
(475, NULL, 24, 3, 'dep010', 'Halal Bihalal', '2026-03-29', '2026-03-29', 'Rencana', 0, '[\"Internal PAC\",\"Alumni\"]', NULL, '2026-01-30 03:34:38', '2026-01-30 03:34:38'),
(476, NULL, 32, 3, 'dep012', 'SAFARI ROMADHON', '2024-03-18', '2026-02-26', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', 'Mengawal dan mengisi materi pada kegiatan pondok romadhon di lembaga', '2026-01-30 03:35:00', '2026-01-30 03:35:00'),
(477, NULL, 40, 4, 'dep007', 'Konten Dakwah', '2026-02-01', '2027-07-18', 'Rencana', 0, '[\"Pengurus Ranting\",\"Pelajar\",\"Masyarakat\"]', NULL, '2026-01-30 03:36:21', '2026-01-30 03:36:21'),
(478, NULL, 22, 3, 'dep010', 'PHBI', '2026-10-22', '2026-10-25', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\",\"Banom NU Lain\"]', NULL, '2026-01-30 03:37:29', '2026-01-30 03:37:29'),
(482, NULL, 29, 4, 'dep016', 'Open PO Seragam', '2025-09-30', '2025-10-14', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-30 03:50:52', '2026-01-30 03:50:52'),
(483, NULL, 29, 4, 'dep016', 'Bazar', '2026-01-01', '2026-12-31', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\"]', 'untuk pelaksanaan nya Menyesuaikan kalau ada event kegiatan dari MWC NU Wates', '2026-01-30 03:53:40', '2026-01-30 03:53:40'),
(484, NULL, 29, 4, 'dep016', 'Open PO Kalender', '2025-10-20', '2025-11-10', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\"]', NULL, '2026-01-30 03:55:28', '2026-01-30 03:55:28'),
(485, NULL, 29, 4, 'dep016', 'Open PO Atribut Kegiatan', '2026-01-01', '2026-12-31', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', 'untuk pelaksanaannya menyesuaikan saat ada kegiatan saja', '2026-01-30 03:57:01', '2026-01-30 03:57:01'),
(487, NULL, 40, 1, 'dep007', 'pembuatan Logo Baru PAC IPNU IPPNU Wates', '2025-09-28', '2025-09-28', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-30 04:02:25', '2026-01-30 04:02:25'),
(488, NULL, 46, 4, 'dep012', 'Mendirikan saluran resmi PAC IPNU IPPNU Wates', '2025-09-29', '2025-09-29', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\",\"Masyarakat\"]', NULL, '2026-01-30 04:40:14', '2026-01-30 04:41:47'),
(489, NULL, 46, 4, 'dep012', 'Mendirikan Akun Tiktok Resmi PAC IPNU IPPNU Wates', '2025-09-30', '2025-09-30', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Masyarakat\"]', NULL, '2026-01-30 04:41:36', '2026-01-30 04:41:36'),
(490, NULL, 40, 1, 'dep007', 'Share postingan berisi motivasi dan inspirasi di saluran wa', '2026-01-05', '2026-12-31', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Masyarakat\"]', 'kegiatannya masih rencana dan untuk waktunya fleksibel dilihat dari sikonnya', '2026-01-30 04:43:32', '2026-01-30 04:43:32'),
(491, NULL, 46, 4, 'dep012', 'Foto individu dan foto grup Pengurus PAC Wates', '2025-09-26', '2025-09-26', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-30 04:45:56', '2026-01-30 04:45:56'),
(493, NULL, 37, 4, 'dep011', 'Sparing Olahraga', '2026-01-01', '2026-12-31', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', 'untuk terkait waktunya bisa fleksibel bisa sebulan sekali atau 2 bulan sekali', '2026-01-30 04:50:05', '2026-01-30 04:50:05'),
(494, NULL, 29, 4, 'dep016', 'Bulan Festival', '2026-04-26', '2026-04-26', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\",\"Masyarakat\"]', 'Sebuah rangkaian kompetisi seni, budaya, dan olahraga yang digelar dalam satu bulan untuk menggali bakat kader dan meningkatkan semangatberkompetisi secara positif.', '2026-01-30 04:57:12', '2026-01-30 04:57:12'),
(496, NULL, 41, 4, 'dep011', 'Peringatan Hari Santri', '2026-10-25', '2026-10-25', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', 'Kegiatan peringatan Hari Santri Nasional dengan mengadakan upacara, kirab, lomba-lomba, atau kegiatan keagamaan untuk memeriahkan momentum besar santri Indonesia.', '2026-01-30 05:02:36', '2026-01-30 05:02:36'),
(497, NULL, 22, 3, 'dep010', 'PERINGATAN HARI BESAR ISLAM', '2025-06-21', '2025-06-21', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-30 05:55:33', '2026-01-30 06:16:14'),
(499, NULL, 47, 3, 'dep011', 'PERINGATAN HARI BESAR NASIONAL', '2025-08-30', '2025-08-30', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-30 06:09:07', '2026-01-30 06:16:03'),
(500, NULL, 48, 4, 'dep011', 'LENTERA HIKMAH', '2025-05-02', '2025-05-02', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-30 06:11:06', '2026-01-30 06:15:49'),
(501, NULL, 43, 1, 'dep007', 'ORIENTASI', '2025-01-27', '2025-01-27', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-30 06:15:16', '2026-01-30 06:15:38'),
(502, NULL, 49, 3, 'dep010', 'KHOTMIL QUR\'AN', '2025-04-24', '2025-04-24', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-30 06:20:14', '2026-01-30 06:20:14'),
(504, NULL, 23, 3, 'dep010', 'Rutinan  majelis ke ranting', '2026-01-30', '2028-01-25', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\",\"Banom NU Lain\"]', NULL, '2026-01-30 08:03:50', '2026-01-30 08:03:50'),
(505, NULL, 43, 1, 'dep007', 'Orientasi Pengurus Masa Khidmat 2023-2025', '2024-02-04', '2024-02-05', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-30 08:04:42', '2026-01-30 08:04:42'),
(506, NULL, 15, 2, 'dep007', 'Pelantikan Pengurus Masa Khidmat 2023-2025', '2024-04-28', '2024-04-28', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-30 08:06:07', '2026-01-30 08:06:07'),
(507, NULL, 35, 2, 'dep007', 'RAKERANCAB 1', '2024-06-09', '2024-06-09', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-30 08:07:30', '2026-01-30 08:07:30'),
(508, NULL, 28, 2, 'dep007', 'Pembentukan dan Tilik Ranting', '2024-12-01', '2025-01-30', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-30 08:08:56', '2026-01-30 08:08:56'),
(509, NULL, 35, 2, 'dep007', 'RAKERANCAB 2', '2025-02-23', '2025-02-23', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-30 08:10:37', '2026-01-30 08:10:37'),
(510, NULL, 50, 2, 'dep007', 'KONFERANCAB VII', '2026-01-25', '2026-01-25', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Banom NU Lain\"]', NULL, '2026-01-30 08:12:04', '2026-01-30 08:12:04'),
(511, NULL, 39, 1, 'dep007', 'Bedah Buku Kaderisasi', '2025-03-02', '2025-03-02', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-30 08:13:23', '2026-01-30 08:13:23'),
(512, NULL, 37, 4, 'dep011', 'sparing', '2024-07-17', '2024-07-17', 'Pasti', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', 'kondisional', '2026-01-30 08:14:38', '2026-01-30 08:14:38'),
(514, NULL, 22, 3, 'dep010', 'pemateri pondok romadhon', '2024-04-02', '2024-04-04', 'Terlaksana', 1, '[\"Internal PAC\",\"Pelajar\"]', NULL, '2026-01-30 08:16:39', '2026-01-30 08:16:39'),
(515, NULL, 14, 2, 'dep009', 'Rapat Rutin Kaderisasi', '2024-04-07', '2025-12-21', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-30 08:16:41', '2026-01-30 08:16:41'),
(516, NULL, 21, 3, 'dep010', 'Ziarah Wali', '2024-12-15', '2024-12-15', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-30 08:18:21', '2026-01-30 08:18:21'),
(517, NULL, 40, 1, 'dep007', 'Sapa kader Tarokan', '2026-02-22', '2027-07-25', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\",\"Masyarakat\"]', NULL, '2026-01-30 08:40:36', '2026-01-30 08:40:36'),
(518, NULL, 40, 1, 'dep007', 'Quis NU 1 Bulan sekali', '2026-02-01', '2027-07-25', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', NULL, '2026-01-30 08:42:01', '2026-01-30 08:42:01'),
(520, NULL, 29, 4, 'dep016', 'Penjualan Atribut IPNU IPPNU', '2026-11-15', '2027-07-04', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-30 08:44:24', '2026-01-30 08:44:24'),
(522, NULL, 26, 2, 'dep007', 'Rapat Tahunan', '2026-12-20', '2026-12-24', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-30 08:47:15', '2026-01-30 08:47:15'),
(524, NULL, 26, 2, 'dep007', 'Musyawarah 1 bulan 2 kali', '2026-02-08', '2027-07-04', 'Pasti', 1, '[\"Internal PAC\"]', NULL, '2026-01-30 08:54:39', '2026-01-30 08:54:39'),
(525, NULL, 26, 2, 'dep007', 'musyawarah 1 bulan sekali Pengurus PAC', '2026-02-22', '2027-07-25', 'Pasti', 1, '[\"Internal PAC\"]', NULL, '2026-01-30 08:55:58', '2026-01-30 08:55:58'),
(526, NULL, 27, 2, 'dep012', 'Pendataan Pengurus PAC & Kader se-kecamtan tarokan', '2025-10-26', '2025-12-21', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', NULL, '2026-01-30 08:58:02', '2026-01-30 08:58:02'),
(529, NULL, 46, 2, 'dep012', 'Pendataan Inventaris Pac', '2026-03-28', '2026-04-26', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-30 09:03:06', '2026-01-30 09:03:06'),
(530, NULL, 9, 2, 'dep007', 'Kas Pengurus PAC', '2025-10-01', '2027-07-31', 'Pasti', 1, '[\"Internal PAC\"]', NULL, '2026-01-30 09:04:20', '2026-01-30 09:04:20'),
(531, NULL, 29, 4, 'dep016', 'Infaq Rutinan 1 bulan sekali', '2026-02-01', '2027-07-25', 'Pasti', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-30 09:05:19', '2026-01-30 09:05:19'),
(532, NULL, 29, 4, 'dep016', 'Gemati (Gerakan Amal Dari hati)', '2026-10-04', '2027-06-27', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\",\"Banom NU Lain\"]', NULL, '2026-01-30 09:06:19', '2026-01-30 09:06:19'),
(533, NULL, 29, 4, 'dep016', 'Gemati (Gerakan Amal Dari hati)', '2026-10-04', '2027-06-27', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\",\"Banom NU Lain\"]', NULL, '2026-01-30 09:06:33', '2026-01-30 09:06:33'),
(536, NULL, 10, 1, 'dep007', 'Tutor pondok romadhon', '2026-03-01', '2026-03-07', 'Rencana', 0, '[\"Pelajar\"]', 'Pengembangan sumber daya kader', '2026-01-30 21:06:31', '2026-01-30 21:06:31'),
(537, NULL, 32, 2, 'dep012', 'Sosialisasi dan koordinasi dengan pk', '2025-10-10', '2025-11-08', 'Terlaksana', 1, '[\"Pelajar\"]', 'Melaksanakan sosialisasi dan melihat perkembangan pk', '2026-01-30 21:09:44', '2026-01-30 21:09:44'),
(539, NULL, 31, 2, 'dep009', 'Membentuk PK di sekolah dalam naungan LP Ma\'arif', '2025-11-24', '2025-11-29', 'Terlaksana', 1, '[\"Pelajar\"]', 'Membentuk PK di sekolah dalam naungan LP Ma\'arif', '2026-01-30 21:16:03', '2026-01-30 21:16:03'),
(540, NULL, 43, 1, 'dep007', 'Orientasi dan Upgrading', '2026-01-25', '2026-01-25', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-30 23:42:00', '2026-01-30 23:42:00'),
(541, NULL, 34, 3, 'dep010', 'Tawasulan Wali Kediri', '2026-02-01', '2027-06-01', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\",\"Banom NU Lain\"]', NULL, '2026-01-31 06:32:09', '2026-01-31 06:32:09'),
(542, NULL, 41, 3, 'dep011', 'Kegiatan ramadhan buka bersama', '2026-02-20', '2027-02-08', 'Pasti', 1, '[\"Pengurus Ranting\",\"Banom NU Lain\"]', NULL, '2026-01-31 06:37:30', '2026-01-31 06:37:30'),
(543, NULL, 9, 3, 'dep007', 'Syafari syawal dan halal bihalal antar pengurus PAC', '2026-02-18', '2027-02-08', 'Pasti', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Banom NU Lain\"]', NULL, '2026-01-31 06:39:02', '2026-01-31 06:39:02'),
(544, NULL, 26, 2, 'dep007', 'Sharing bersama pembina', '2026-04-01', '2027-06-01', 'Pasti', 1, '[\"Internal PAC\",\"Banom NU Lain\"]', NULL, '2026-01-31 06:44:46', '2026-01-31 06:44:46'),
(545, NULL, 26, 2, 'dep007', 'Sharing antar pengurus PAC', '2026-04-01', '2027-06-01', 'Pasti', 1, '[\"Internal PAC\"]', NULL, '2026-01-31 06:48:00', '2026-01-31 06:48:00'),
(548, NULL, 22, 3, 'dep010', 'Mengadakan peringatan PHBI dan PHBN', '2026-04-01', '2027-06-01', 'Pasti', 1, '[\"Pengurus Ranting\",\"Pelajar\",\"Masyarakat\"]', NULL, '2026-01-31 07:06:21', '2026-01-31 07:06:21'),
(549, NULL, 34, 3, 'dep010', 'Mengadakan ziarah wali kenceng di akhir periode', '2027-03-01', '2027-06-01', 'Pasti', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\",\"Banom NU Lain\"]', NULL, '2026-01-31 07:07:43', '2026-01-31 07:07:43'),
(551, NULL, 39, 1, 'dep007', 'Masa Orientasi Pengurus', '2024-07-14', '2024-07-14', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-31 07:18:11', '2026-01-31 07:18:11'),
(552, NULL, 15, 2, 'dep007', 'Pelantikan Pengurus PAC', '2024-07-21', '2024-07-21', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-31 07:19:29', '2026-01-31 07:19:29'),
(553, NULL, 35, 2, 'dep007', 'Rakerancab 1', '2024-07-21', '2024-07-21', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-31 07:19:57', '2026-01-31 07:19:57'),
(554, NULL, 26, 2, 'dep007', 'Rapimancab', '2024-08-24', '2024-08-24', 'Terlaksana', 1, '[\"Pengurus Ranting\"]', NULL, '2026-01-31 07:22:14', '2026-01-31 07:22:14'),
(555, NULL, 50, 2, 'dep007', 'Konferancab', '2026-04-19', '2026-04-26', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Banom NU Lain\"]', NULL, '2026-01-31 07:27:46', '2026-01-31 07:27:46'),
(556, NULL, 35, 2, 'dep007', 'Rakerancab 2', '2025-05-17', '2025-05-18', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-31 07:29:46', '2026-01-31 07:29:46'),
(557, NULL, 28, 2, 'dep007', 'Pembentukan Ranting Kawedusan Utara', '2025-12-06', '2025-12-06', 'Terlaksana', 1, '[\"Pengurus Ranting\"]', NULL, '2026-01-31 07:31:43', '2026-01-31 07:31:43'),
(558, NULL, 28, 2, 'dep007', 'Pembentukan Ranting Sumberagung', '2025-09-21', '2025-09-21', 'Terlaksana', 1, '[\"Pengurus Ranting\"]', NULL, '2026-01-31 07:36:42', '2026-01-31 07:36:42'),
(559, NULL, 28, 2, 'dep007', 'Pembentukan Ranting Kawedusan Selatan', '2025-12-21', '2025-12-21', 'Terlaksana', 1, '[\"Pengurus Ranting\"]', NULL, '2026-01-31 07:37:50', '2026-01-31 07:45:45'),
(560, NULL, 51, 2, 'dep007', 'Turba Korwas Tengah', '2025-03-23', '2025-03-23', 'Terlaksana', 1, '[\"Pengurus Ranting\"]', NULL, '2026-01-31 07:42:49', '2026-01-31 07:42:49'),
(561, NULL, 51, 2, 'dep007', 'Turba Korwas Timur', '2024-11-03', '2024-11-03', 'Terlaksana', 1, '[\"Pengurus Ranting\"]', NULL, '2026-01-31 07:44:06', '2026-01-31 07:44:06'),
(563, NULL, 51, 2, 'dep007', 'Turba Korwas Selatan', '2025-04-13', '2025-04-13', 'Terlaksana', 1, '[\"Pengurus Ranting\"]', NULL, '2026-01-31 07:45:10', '2026-01-31 07:45:10'),
(571, NULL, 51, 2, 'dep007', 'Turba Ranting Plosolor', '2026-02-11', '2026-02-11', 'Pasti', 1, '[\"Pengurus Ranting\"]', NULL, '2026-01-31 07:53:56', '2026-01-31 07:53:56'),
(572, NULL, 51, 2, 'dep007', 'Turba Ranting Sumberagung', '2026-02-04', '2026-02-04', 'Pasti', 1, '[\"Pengurus Ranting\"]', NULL, '2026-01-31 07:55:07', '2026-01-31 07:55:07'),
(573, NULL, 51, 2, 'dep007', 'Turba Ranting Kawedusan Selatan', '2026-02-07', '2026-02-07', 'Pasti', 1, '[\"Pengurus Ranting\"]', NULL, '2026-01-31 07:56:07', '2026-01-31 07:56:07'),
(574, NULL, 51, 2, 'dep007', 'Turba Ranting Gondang', '2026-02-16', '2026-02-16', 'Pasti', 1, '[\"Pengurus Ranting\"]', NULL, '2026-01-31 07:56:41', '2026-01-31 07:56:41'),
(575, NULL, 25, 3, 'dep010', 'Radar Pagi (Road Sholawat dan Dialog Pelajar Setiap Ahad Legi)', '2024-10-06', '2025-11-23', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\",\"Banom NU Lain\"]', 'Rutinan setiap Ahad Legi', '2026-01-31 07:57:01', '2026-01-31 07:57:01'),
(577, NULL, 24, 2, 'dep010', 'Syafari Syawal', '2025-04-06', '2025-04-06', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Banom NU Lain\"]', NULL, '2026-01-31 08:00:32', '2026-01-31 08:00:32'),
(578, NULL, 22, 3, 'dep010', 'Tasyakuran Hari Santri', '2025-10-25', '2025-10-25', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-31 08:00:44', '2026-01-31 08:00:44'),
(579, NULL, 25, 3, 'dep010', 'Rutinan Tahlil', '2024-09-28', '2025-06-02', 'Terlaksana', 1, '[\"Internal PAC\"]', 'Dilaksanakan setiap satu bulan sekali', '2026-01-31 08:03:11', '2026-01-31 08:03:11'),
(581, NULL, 22, 3, 'dep010', 'Semarak Hari Santri', '2024-10-12', '2024-10-13', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Masyarakat\",\"Banom NU Lain\"]', NULL, '2026-01-31 08:05:54', '2026-01-31 08:05:54'),
(582, NULL, 31, 2, 'dep009', 'Pendirian PK SMK Al Muwazanah', '2025-11-15', '2025-11-15', 'Terlaksana', 1, '[\"Pelajar\"]', NULL, '2026-01-31 08:08:02', '2026-01-31 08:20:40'),
(583, NULL, 31, 2, 'dep009', 'Pendirian PK MA Al Muwazanah', '2025-02-06', '2025-02-06', 'Terlaksana', 1, '[\"Pelajar\"]', NULL, '2026-01-31 08:11:54', '2026-01-31 08:21:23'),
(584, NULL, 34, 3, 'dep010', 'Ziarah Ke Makam Pendiri IPNU IPPNU', '2026-02-14', '2026-02-15', 'Pasti', 1, '[\"Internal PAC\"]', NULL, '2026-01-31 08:13:47', '2026-01-31 08:13:47'),
(585, NULL, 46, 4, 'dep012', 'Mengisi Materi MPLS', '2025-07-24', '2025-07-24', 'Terlaksana', 1, '[\"Pelajar\"]', NULL, '2026-01-31 08:16:51', '2026-01-31 08:16:51'),
(586, NULL, 40, 3, 'dep007', 'Safari Ramadhan', '2025-03-14', '2025-03-20', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\",\"Alumni\",\"Pelajar\",\"Banom NU Lain\"]', 'mengisi materi pondok ramadhan di smpn 1 Plosoklaten, mi belung, panti asuhan budi mulia pranggang', '2026-01-31 08:18:18', '2026-01-31 08:18:18'),
(587, NULL, 26, 2, 'dep007', 'Rapat PH', '2025-10-10', '2025-10-10', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-31 09:14:59', '2026-01-31 09:14:59'),
(588, NULL, 32, 1, 'dep012', 'Pembukaan Rutinan', '2025-11-09', '2025-11-09', 'Terlaksana', 1, '[\"Pengurus Ranting\"]', NULL, '2026-01-31 09:20:08', '2026-01-31 09:20:08'),
(589, NULL, 9, 2, 'dep007', 'Rapat PH', '2025-12-10', '2025-12-10', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-31 09:21:41', '2026-01-31 09:21:41'),
(590, NULL, 26, 2, 'dep007', 'Rapat Pengurus PAC', '2025-11-14', '2025-11-14', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-31 09:22:43', '2026-01-31 09:22:43'),
(591, NULL, 26, 2, 'dep007', 'Rapat PH', '2025-11-26', '2025-11-26', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-31 09:23:37', '2026-01-31 09:23:37'),
(592, NULL, 26, 2, 'dep007', 'Rapat PH', '2025-11-26', '2025-11-26', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-01-31 09:23:38', '2026-01-31 09:23:38'),
(593, NULL, 39, 1, 'dep007', 'Orientasi ranting', '2026-02-09', '2026-02-09', 'Rencana', 0, '[\"Pengurus Ranting\"]', NULL, '2026-01-31 09:28:49', '2026-01-31 09:28:49'),
(594, NULL, 15, 2, 'dep007', 'Pelantikan Raya', '2026-02-11', '2026-02-11', 'Rencana', 0, '[\"Pengurus Ranting\"]', NULL, '2026-01-31 09:31:06', '2026-01-31 09:31:06'),
(596, NULL, 10, 1, 'dep007', 'ATOM', '2026-03-29', '2026-03-29', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\",\"Pelajar\"]', NULL, '2026-01-31 09:34:02', '2026-01-31 09:34:02'),
(597, NULL, 24, 2, 'dep010', 'Hiking', '2026-04-05', '2026-04-05', 'Rencana', 0, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-31 09:35:29', '2026-01-31 09:35:29'),
(600, NULL, 50, 2, 'dep007', 'Konferensi', '2027-02-06', '2027-02-06', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-31 09:39:40', '2026-01-31 09:39:40'),
(601, NULL, 52, 3, 'dep010', 'Buka Bersama', '2025-03-22', '2025-03-22', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-31 18:27:33', '2026-01-31 18:27:33'),
(602, NULL, 53, 3, 'dep010', 'Safari Ramadhan', '2025-03-23', '2025-03-23', 'Terlaksana', 1, '[\"Internal PAC\",\"Pengurus Ranting\"]', NULL, '2026-01-31 18:28:45', '2026-01-31 18:28:45'),
(603, NULL, 24, 3, 'dep010', 'Safari Syawal', '2025-04-05', '2025-04-07', 'Terlaksana', 1, '[\"Internal PAC\",\"Alumni\"]', NULL, '2026-01-31 18:29:35', '2026-01-31 18:29:35'),
(604, NULL, 22, 3, 'dep010', 'Pemateri Pondok Romadhon', '2024-04-02', '2024-04-04', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-31 18:31:01', '2026-01-31 18:31:01'),
(605, NULL, 25, 3, 'dep010', 'Rutinan Tahlil', '2024-04-01', '2025-12-01', 'Rencana', 0, '[\"Internal PAC\"]', NULL, '2026-01-31 18:32:39', '2026-01-31 18:32:39'),
(607, NULL, 32, NULL, 'dep009', 'Pendampingan Pondok Ramadhan', '2025-03-03', '2025-03-21', 'Terlaksana', 1, '[\"Pelajar\"]', NULL, '2026-02-08 21:22:43', '2026-02-08 21:22:55'),
(608, NULL, 32, NULL, 'dep009', 'Pendampingan MPLS', '2025-07-14', '2025-07-17', 'Terlaksana', 1, '[\"Pelajar\"]', NULL, '2026-02-08 21:24:48', '2026-02-08 21:24:48'),
(609, NULL, 48, NULL, 'dep012', 'Kultum Ramadhan', '2025-03-01', '2025-03-29', 'Terlaksana', 1, '[\"Internal PAC\"]', NULL, '2026-02-08 21:27:31', '2026-02-08 21:27:31'),
(610, NULL, 32, NULL, 'dep008', 'Sosialisasi Makesta', '2026-04-01', '2026-04-30', 'Pasti', 1, '[\"Pengurus Ranting\",\"Pelajar\"]', 'kondisional', '2026-02-09 00:23:49', '2026-02-09 00:23:49'),
(611, NULL, 15, NULL, 'dep007', 'Pelantikan Pengurus', '2026-02-14', '2026-02-14', 'Pasti', 1, '[\"Pelajar\"]', NULL, '2026-02-09 00:29:45', '2026-02-09 00:30:10'),
(612, NULL, 35, NULL, 'dep007', 'Rapat Kerja I PAC IPNU IPPNU Kecamatan Gurah (Rakerancab I)', '2026-03-01', '2026-03-01', 'Pasti', 1, '[\"Internal PAC\"]', NULL, '2026-02-09 00:34:46', '2026-02-09 01:29:01'),
(614, NULL, 51, NULL, 'dep007', 'Turba ( Turun Ke bawah)', '2026-11-01', '2026-12-31', 'Rencana', 0, '[\"Pelajar\"]', 'Waktu kondisional', '2026-02-09 00:46:23', '2026-02-09 01:25:10'),
(615, NULL, 14, 2, 'dep007', 'Rapat Ph dan co pengurus PAC', '2026-03-02', '2026-12-31', 'Pasti', 1, '[\"Internal PAC\"]', 'Waktu setiap awal Bulan pada tanggal 09', '2026-02-09 00:50:10', '2026-02-09 00:50:10'),
(616, NULL, 13, NULL, 'dep007', 'Rapat Internal pengurus  depertemen organisasi dan Departemen Pengembangan Organisasi', '2026-03-02', '2026-12-31', 'Pasti', 1, '[\"Internal PAC\"]', 'Waktu kondisional', '2026-02-09 00:56:59', '2026-02-09 00:56:59'),
(617, NULL, 35, NULL, 'dep007', 'Rapat Kerja II PAC IPNU IPPNU Kecamatan Gurah (Rakerancab II)', '2027-01-01', '2027-12-31', 'Pasti', 1, '[\"Pengurus Ranting\"]', 'Waktu kondisional di bulan Januari', '2026-02-09 00:59:14', '2026-02-09 00:59:27'),
(618, NULL, 14, 2, 'dep007', 'Rapat pengurus PAC IPNU IPPNU', '2026-03-02', '2027-12-31', 'Pasti', 1, '[\"Internal PAC\"]', 'Waktu pelaksanaan kondisional', '2026-02-09 01:01:47', '2026-02-09 01:01:47'),
(619, NULL, 41, 4, 'dep007', 'Database Pimpinan Rating dan Pimpinan Komisariat Sekecamatan Gurah', '2026-03-02', '2026-04-30', 'Pasti', 1, '[\"Pengurus Ranting\"]', 'Waktu pelaksanaan kondisional dibulan Maret - April', '2026-02-09 01:21:19', '2026-02-09 01:21:19'),
(620, NULL, 39, 2, 'dep007', 'Diklat Teknik Diskusi dan Persidangan', '2026-07-01', '2026-07-31', 'Pasti', 1, '[\"Internal PAC\"]', 'Waktu kondisional di Bulan Juli', '2026-02-09 01:24:47', '2026-02-09 01:26:32'),
(621, NULL, 26, NULL, 'dep007', 'Rapat Pimpinan Anak Cabang', '2026-11-01', '2027-11-30', 'Pasti', 1, '[\"Internal PAC\"]', 'Waktu kondisional di Bulan November', '2026-02-09 01:28:31', '2026-02-09 01:28:31');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_pelatihans`
--

CREATE TABLE `riwayat_pelatihans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kader_id` varchar(255) NOT NULL,
  `nama_pelatihan` varchar(255) NOT NULL,
  `jenis` enum('Formal','Non-Formal') NOT NULL,
  `penyelenggara` varchar(255) NOT NULL,
  `tahun` year(4) NOT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `nomor_sertifikat` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('amgOrNKLk8qQinQ4EfZqkPMBLvbrZ95CiRLc3oNi', NULL, '202.58.78.133', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaWoyU0JvMVNRaDdWTzQ0amtXZlpWSEQwcDlPU1BySXphVk95a0JlSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vaXBudWlwcG51a2VkaXJpLm15LmlkL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1769162539),
('bASZui3Rv9yV4GkI3ST10ETx4efBsfyOKpd5gMpP', NULL, '202.58.78.135', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicDJ2SnNrNFJXN3F1S203VHFTOHdnZkhSSnRwQlBGT2xTakJ0S1hzTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vaXBudWlwcG51a2VkaXJpLm15LmlkL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1769163040),
('DELQHC9XDfBzlFP9E8EKjpbI7HdwfVz6hmVMEx0s', NULL, '202.58.78.133', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVFM0b1RnRHZEaUYweDdMbjRaSXJ0dzlqNElGM3NZVDExT0wwMzdETiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1MDoiaHR0cHM6Ly9pcG51aXBwbnVrZWRpcmkubXkuaWQvZGFzaGJvYXJkL3BhYy9wcm9rZXIiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozNToiaHR0cHM6Ly9pcG51aXBwbnVrZWRpcmkubXkuaWQvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1769163406),
('exySYHNfpdYeoOvjiGwz0ebFz9wZxehzfTU6wqc1', NULL, '202.58.78.133', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiclpzS1RJYmRuTWJzWWlETjJ1YlRUNG8zOTJzTXV1b0E0M25KSHdYUSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozOToiaHR0cHM6Ly9pcG51aXBwbnVrZWRpcmkubXkuaWQvZGFzaGJvYXJkIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vaXBudWlwcG51a2VkaXJpLm15LmlkL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1769163691),
('ndfEZk558He2pVZnfKUO0dPUE10euJozbtIirvTI', NULL, '182.4.132.206', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSktwdG1rYjBTd0ZCMlF0M0tZVkl4Q1JETHlNTThpdjZxY1FZajRuaSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozOToiaHR0cHM6Ly9pcG51aXBwbnVrZWRpcmkubXkuaWQvZGFzaGJvYXJkIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vaXBudWlwcG51a2VkaXJpLm15LmlkL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1769163482),
('TJ8jYYeBpfet7ZWUploikLis9n8FXg0poZzKTzlM', NULL, '182.4.132.206', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUGIzY0pWbnprSnpXZ044Nm9nZ0VENElzMGVMOUZIY29Wa05tZEk3eCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozOToiaHR0cHM6Ly9pcG51aXBwbnVrZWRpcmkubXkuaWQvZGFzaGJvYXJkIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vaXBudWlwcG51a2VkaXJpLm15LmlkL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1769163780),
('waiLo4u2KHc5QOAMQtkK6sKle7YXZkdya7nov5Yn', NULL, '149.57.180.16', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN3E2R3hZNktPNE5zSkZnbEM3dThiNWZGd3F5QmRrNEg3WnFQcFN1NyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vaXBudWlwcG51a2VkaXJpLm15LmlkL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1769163275),
('wsu60xTJsyW3TOAyAFxefA2c2Q1d9iwQVRFxgLeG', NULL, '202.58.78.133', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiUlVZUjhKTjBwSEVmeE5zRkhoRHdUNGJHeEtIRFRQSmdlSzlzZ3NqaiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1769163108);

-- --------------------------------------------------------

--
-- Table structure for table `surat_keluars`
--

CREATE TABLE `surat_keluars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_surat` varchar(255) NOT NULL,
  `departemen_id` varchar(255) DEFAULT NULL,
  `tujuan` varchar(255) NOT NULL,
  `perihal` varchar(255) NOT NULL,
  `tgl_surat` date NOT NULL,
  `file_arsip` varchar(255) DEFAULT NULL,
  `pembuat_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_keputusans`
--

CREATE TABLE `surat_keputusans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisasi_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nomor_sk` varchar(255) NOT NULL,
  `judul_sk` varchar(255) NOT NULL,
  `tgl_berlaku` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `file_sk_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Aktif' COMMENT 'Draft, Menunggu Pengesahan PC, Aktif, Demisioner, Ditolak'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `surat_keputusans`
--

INSERT INTO `surat_keputusans` (`id`, `organisasi_id`, `nomor_sk`, `judul_sk`, `tgl_berlaku`, `tgl_selesai`, `file_sk_path`, `created_at`, `updated_at`, `status`) VALUES
(1, NULL, '05/pw/XXVI/XII/25', 'SK PC', '2025-11-20', '2027-12-22', NULL, '2026-01-02 22:07:26', '2026-01-02 22:07:26', 'Aktif'),
(3, NULL, '01/PC/009/001/0101', 'PENGESAHAN PAC MOJO', '2025-11-12', '2026-01-10', NULL, '2026-01-03 01:49:40', '2026-01-03 01:49:40', 'Aktif'),
(4, NULL, '09/09/09/09/09', 'PENGESAHAN PAC KANDAT', '2025-11-19', '2025-12-26', NULL, '2026-01-03 01:50:13', '2026-01-03 01:50:13', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `surat_masuks`
--

CREATE TABLE `surat_masuks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_surat` varchar(255) NOT NULL,
  `pengirim` varchar(255) NOT NULL,
  `perihal` varchar(255) NOT NULL,
  `tgl_surat` date NOT NULL,
  `tgl_diterima` date NOT NULL,
  `file_scan` varchar(255) DEFAULT NULL,
  `disposisi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `nama`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Ipnu', 'ipnu', '2026-03-18 02:46:38', '2026-03-18 02:46:38'),
(2, 'Ippnu', 'ippnu', '2026-03-18 02:46:38', '2026-03-18 02:46:38'),
(3, 'Kaderisasi', 'kaderisasi', '2026-03-18 02:46:38', '2026-03-18 02:46:38'),
(4, 'Dakwah', 'dakwah', '2026-03-18 02:46:38', '2026-03-18 02:46:38'),
(5, 'Pendidikan', 'pendidikan', '2026-03-18 02:46:38', '2026-03-18 02:46:38'),
(6, 'Sosial', 'sosial', '2026-03-18 02:46:38', '2026-03-18 02:46:38'),
(7, 'Olahraga', 'olahraga', '2026-03-18 02:46:38', '2026-03-18 02:46:38'),
(8, 'Seni budaya', 'seni-budaya', '2026-03-18 02:46:38', '2026-03-18 02:46:38'),
(9, 'Kepemimpinan', 'kepemimpinan', '2026-03-18 02:46:38', '2026-03-18 02:46:38'),
(10, 'Rapat', 'rapat', '2026-03-18 02:46:38', '2026-03-18 02:46:38'),
(11, 'Pelantikan', 'pelantikan', '2026-03-18 02:46:38', '2026-03-18 02:46:38'),
(12, 'Pesantren', 'pesantren', '2026-03-18 02:46:38', '2026-03-18 02:46:38'),
(13, 'Santri', 'santri', '2026-03-18 02:46:38', '2026-03-18 02:46:38'),
(14, 'Kediri', 'kediri', '2026-03-18 02:46:38', '2026-03-18 02:46:38'),
(15, 'Pelatihan', 'pelatihan', '2026-03-18 02:46:38', '2026-03-18 02:46:38'),
(16, 'Beasiswa', 'beasiswa', '2026-03-18 02:46:38', '2026-03-18 02:46:38'),
(17, 'Ramadan', 'ramadan', '2026-03-18 02:46:38', '2026-03-18 02:46:38'),
(18, 'Maulid', 'maulid', '2026-03-18 02:46:38', '2026-03-18 02:46:38'),
(19, 'Literasi', 'literasi', '2026-03-18 02:46:38', '2026-03-18 02:46:38'),
(20, 'Lingkungan', 'lingkungan', '2026-03-18 02:46:38', '2026-03-18 02:46:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','pengurus','anggota','sekretaris','bendahara','dep_organisasi','dep_kaderisasi','dep_jaringan','dep_dakwah','dep_seni','dep_media','dep_pengorg','lmb_lpp','lmb_lekas','lmb_lan','lmb_lkpt','lmb_cbp','lmb_kpp','lmb_konseling','lmb_ekraf','lmb_kdc','bdn_bscc','bdn_bsrc','pac','pr','pk','pk_pt','anggota_biasa','pers','departemen') NOT NULL DEFAULT 'anggota',
  `departemen_id` varchar(10) DEFAULT NULL,
  `kader_id` varchar(255) DEFAULT NULL,
  `organisasi_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `departemen_id`, `kader_id`, `organisasi_id`) VALUES
('use001', 'Super Administrator', 'admin@dasi.org', NULL, '$2y$12$FU0Gn6FovehZOaVEIGt15es4BEMHyNBHdKiYl3/TrmhkPAb4/herK', 'iA5OQoWgI3z1PM1DF8juTRD5fsjWC8R9cCvap44wSl7XiaBOPI0kGI89ihrB', '2026-01-02 15:32:38', '2026-06-15 06:57:44', 'admin', NULL, NULL, NULL),
('use002', 'Admin Departemen Kaderisasi', 'departemen-kaderisasi@dasi.org', NULL, '$2y$12$QrHvRnunBLY3Tp/Vih5o6eleBJ8zL0kamsooLbZYuYe1R.xtRhudG', NULL, '2026-01-02 15:32:39', '2026-06-15 06:57:44', 'dep_kaderisasi', 'dep008', NULL, NULL),
('use004', 'Admin Departemen Media & Informasi', 'departemen-media-informasi@dasi.org', NULL, '$2y$12$UVxpWLyTOYMLfS.lbE6STeCB63G6Mr/DR1EMWVn1VjQTpxCZ8aXDu', NULL, '2026-01-02 15:32:39', '2026-06-15 06:57:45', 'dep_media', 'dep024', NULL, NULL),
('use005', 'Admin Departemen Dakwah', 'departemen-dakwah@dasi.org', NULL, '$2y$12$FXDjkMP3dxgOc4JbuJYereegn/8RVSMNcNGzfQf8fYlfPeyMP5sny', NULL, '2026-01-02 15:32:40', '2026-06-15 06:57:44', 'dep_dakwah', 'dep010', NULL, NULL),
('use007', 'Admin Lembaga Pers', 'pers@dasi.org', NULL, '$2y$12$9uc1ppbiE.1mZmVBR1zB1OSYODLJgq26iPRR4szC7VXOZoYkkucUa', NULL, '2026-01-02 15:32:40', '2026-06-15 06:57:45', 'lmb_lpp', 'dep014', NULL, NULL),
('use008', 'PAC IPNU IPPNU GURAH', 'gurah@dasi.org', NULL, '$2y$12$H.3ZUggRH0YeNYpM.yBW3uLsBsvGYAmac6Q5sK2ODX9UStpm975He', 'PNLnztDDn1f8nvp92jDXSKpmxZiDD3qXZFlIdqKrzC9yQrSQa4KRHEpXXTdL', '2026-01-23 20:10:35', '2026-01-27 06:27:54', 'pac', NULL, NULL, NULL),
('use009', 'PAC IPNU IPPNU RINGINREJO', 'ringinrejo@dasi.org', NULL, '$2y$12$KniaxgiyFJOZMUxQUzoNGOU.2gYe71XXZTtOsYrc.BO6HNBDm4tfu', NULL, '2026-01-23 23:46:21', '2026-01-24 09:22:34', 'pac', NULL, NULL, NULL),
('use010', 'PAC IPNU IPPNU KRAS', 'kras@dasi.org', NULL, '$2y$12$JQTRpQp2UMX.3rU8BrrUvOzS9BYf8olLeK2MxPYTbjEI35d3jSZna', NULL, '2026-01-23 23:47:10', '2026-01-24 09:22:10', 'pac', NULL, NULL, NULL),
('use011', 'PAC IPNU IPPNU NGADILUWIH', 'ngadiluwih@dasi.org', NULL, '$2y$12$xU/yZXiGMCsZGc6kQt7V9ObeiJR7RwACyCzmmCxGTLfUDO5o7EHye', NULL, '2026-01-23 23:47:58', '2026-01-24 09:21:47', 'pac', NULL, NULL, NULL),
('use012', 'PAC IPNU IPPNU KANDAT', 'kandat@dasi.org', NULL, '$2y$12$yuZW0qKjT3I/3UcH.Z5h..rSmWMlswG4SAemvOdQKYDphlGxyPhri', '0S7hMjjRlSbSEQ8ojtBVwWxiYcAxaVj90HD90zgRMvZatwOdvaeR5LhhoF76', '2026-01-23 23:48:34', '2026-01-25 04:51:36', 'pac', NULL, NULL, NULL),
('use013', 'PAC IPNU IPPNU NGANCAR', 'ngancar@dasi.org', NULL, '$2y$12$j7A5GtGpNEDRvtykDuMjhehpbnxUaNilyyceb8jxEzAL3sp7oBgji', 'NiJBKBuS8uBNpWHqGuUidNNEAEH8iPydJ9O6YTHFRJ75BLsjK6KaDWDrpgbb', '2026-01-23 23:49:13', '2026-01-24 09:20:57', 'pac', NULL, NULL, NULL),
('use014', 'PAC IPNU IPPNU WATES', 'wates@dasi.org', NULL, '$2y$12$OP9psS/IcY1Zfb1nCCr9vOmhIHiIZbXygNRIgY9A6bUhCWqOwY2Uy', '1D3AhkWeSO5bHuuZ46uET8gMBztoz5PMQy6eJLptJ5S9LK4rlIFWxz6PTn0u', '2026-01-23 23:49:38', '2026-01-24 09:20:22', 'pac', NULL, NULL, NULL),
('use015', 'PAC IPNU IPPNU PAGU', 'pagu@dasi.org', NULL, '$2y$12$Kz5vypE7FKIKhNKssRtc.u4ihVYKIZT/ri9hez7kO2Bj/JR5yHd6G', 'QXL05Z99Y0kX2r93S88F5KACK2RApp6ogVkjt4n2OvWX7Ha5MWgIxJbReuBL', '2026-01-23 23:51:32', '2026-01-24 09:22:20', 'pac', NULL, NULL, NULL),
('use016', 'PAC IPNU IPPNU NGASEM', 'ngasem@dasi.org', NULL, '$2y$12$JlJaffI1Zcwezr6wvvoQS.RIjyXhHOpI7xO0ILks8nScPZ3hkn/fq', 'LzjkvmaElglniWePtVSorRLxwn49KPTya1Zyo8ya0Md2aNstk9jK53PY5srN', '2026-01-23 23:52:13', '2026-01-27 17:45:08', 'pac', NULL, NULL, NULL),
('use017', 'PAC IPNU IPPNU PLOSOKLATEN', 'plosoklaten@dasi.org', NULL, '$2y$12$CuJ.O2RBUJFPiAsw6lA8b.ob6Jb6yD1pN/A0ex8lsx213qLwAiSMW', 'qVRG7PREbtVaRfRIwRgV3N0QBzCDqK58c5tb5gNfdTPk0s1sW1HLrh7uq2TM', '2026-01-23 23:52:46', '2026-01-24 09:21:16', 'pac', NULL, NULL, NULL),
('use018', 'PAC IPNU IPPNU GAMPENGREJO', 'gampengrejo@dasi.org', NULL, '$2y$12$2cE2dJDMKtzzDEwO95HdduVANVLKCXiY5p9lmr83RiGmLB3hIrMSC', NULL, '2026-01-23 23:53:23', '2026-01-24 09:20:29', 'pac', NULL, NULL, NULL),
('use019', 'PAC IPNU IPPNU MOJO', 'mojo@dasi.org', NULL, '$2y$12$SroR3ai21xH4JQlZYDHSDeeUqXjjtM.dgdY8lxnn95VtArMK0dgye', 't1r2uzIm1IbymdvJNOaUMtpqVbcnnzOjq6GWAdBbmVc0gnj2Mgw6JPz49LAh', '2026-01-23 23:53:58', '2026-01-24 09:24:12', 'pac', NULL, NULL, NULL),
('use020', 'PAC IPNU IPPNU SEMEN', 'semen@dasi.org', NULL, '$2y$12$XXnHle.f.DtCO3eph63EkeLaeeb4bg1P13dTLuRHo/Vnv2UEkdC9O', '6EiXRAgKjM25PKWTOjL0c6pZs5PkujGtDyscLtJXnZWAtPnMJIsGk8Eollsj', '2026-01-23 23:54:18', '2026-01-24 09:23:34', 'pac', NULL, NULL, NULL),
('use021', 'PAC IPNU IPPNU TAROKAN', 'tarokan@dasi.org', NULL, '$2y$12$L0kPft4BOqsnr00ylsQKYO2WrNEEZYqFar4AH8luzvc8/nOUzc8x.', 'pqbTIhR8N9fPoVh4ubJs1IewQ8Hq32TxdAuNLDKK8PSCZBWz1V7XIIi0pPGe', '2026-01-23 23:54:54', '2026-01-24 09:22:34', 'pac', NULL, NULL, NULL),
('use022', 'PAC IPNU IPPNU GROGOL', 'grogol@dasi.org', NULL, '$2y$12$dtabyx3PvkD3TPKRTAATRuOej8wicZD86jhQtli6OkfgU.p0po9Pm', 'pu05Cyfidcme20vz5l37W47s1u2aNRJx2JQOGwZgIxO7fqLlNArNwonhwlek', '2026-01-23 23:55:21', '2026-01-24 09:21:50', 'pac', NULL, NULL, NULL),
('use023', 'PAC IPNU IPPNU BANYAKAN', 'banyakan@dasi.org', NULL, '$2y$12$a03bWW8uy1QOK7JxE/QmkenfwC.bu2KIGioGoi7cMpRPE/RPTB9Ja', '9a7H1QDlvIYQC90OLCRZkrsVWA0TYe0RaIMNchUlBM4cWU17sQwJsmXBjYwV', '2026-01-23 23:55:48', '2026-01-24 09:21:02', 'pac', NULL, NULL, NULL),
('use024', 'PAC IPNU IPPNU BADAS', 'badas@dasi.org', NULL, '$2y$12$ASXqxen0ww9RMq42xE3/4e2YOlFb4Nz75FO10hDNDe82eP1.AsUji', 'te0vE4nDFOvcxI1fc1PoTYsn1gd7P8XRLhrwxJvcdUBqT1M1ytTbPa2c8Xzj', '2026-01-23 23:56:31', '2026-01-26 07:27:11', 'pac', NULL, NULL, NULL),
('use025', 'PAC IPNU IPPNU KAYEN KIDUL', 'kayenkidul@dasi.org', NULL, '$2y$12$wYcqcgZ1z8SGF9MdXRnNq.cYarbQOS0YKoGDLW41KUFyxFRHoNana', NULL, '2026-01-23 23:57:25', '2026-01-24 09:24:52', 'pac', NULL, NULL, NULL),
('use026', 'PAC IPNU IPPNU KUNJANG', 'kunjang@dasi.org', NULL, '$2y$12$O/bxhqCOweOedpYm7ppgCOGZ0KB.ZKS7VOVKzwH7PvKGGLCY4uxWG', NULL, '2026-01-23 23:58:03', '2026-01-24 09:24:10', 'pac', NULL, NULL, NULL),
('use027', 'PAC IPNU IPPNU PLEMAHAN', 'plemahan@dasi.org', NULL, '$2y$12$YZyZv.xuqdYgmC27l3oMROLhmkpyvY8ntKiQy4yy0dWnMglvJ7dWG', 'LQYgdJXDmlUU4zpZJT5aQNM2mvRNp5KPvq2wIyLU1nb95v8tsEHo8hIpjHZX', '2026-01-23 23:58:43', '2026-01-29 03:15:35', 'pac', NULL, NULL, NULL),
('use028', 'PAC IPNU IPPNU PAPAR', 'papar@dasi.org', NULL, '$2y$12$IotmxrPbvSboi1DQ3vivWe5NDq0rddJeLus0Aj./xscuG33u3gdTe', 'tgp1X01sfGoUJyLIzHADksP6UxV39GAoTSkpFCSmTB9HBETxeuG1XiCi9wWP', '2026-01-24 00:00:46', '2026-01-24 09:23:29', 'pac', NULL, NULL, NULL),
('use029', 'PAC IPNU IPPNU PURWOASRI', 'purwoasri@dasi.org', NULL, '$2y$12$S5.zQUd/CTTfYwVsqrte0.oZgv4R6GnW5sXbahY5CrwYsLQ82UcMG', 'l9tYNGU6I4zwnSpAJaSybi2EnOafmY5xlmcQ6ZXSU2Wf2QMlr14LwWagHfZd', '2026-01-24 00:01:10', '2026-01-24 09:23:07', 'pac', NULL, NULL, NULL),
('use030', 'PAC IPNU IPPNU PARE', 'pare@dasi.org', NULL, '$2y$12$8fCxY//0dUUSxO3AICQD/eCQcFR0z2Pc0O8NVUgHDdt9NIriA.QB.', 'BKwUoFi85Eofd2DIIjOXdoJRIIDVLoejheuwnhs5ETNQHgEr8fqVvvmu93FS', '2026-01-24 00:01:39', '2026-01-24 09:24:44', 'pac', NULL, NULL, NULL),
('use031', 'PAC IPNU IPPNU KEPUNG', 'kepung@dasi.org', NULL, '$2y$12$LuEENYNNGYxXhgyLtmB/We.dAY5TEx8VRdmnwSf5Z8ou9h8yLY7HC', 'oj4EN0JM8RO4pVQ6dhna9q0sSJCDuoQveb6JvSYL4CdGHWHxmbeH7JqovBfD', '2026-01-24 00:02:07', '2026-01-26 21:48:52', 'pac', NULL, NULL, NULL),
('use032', 'PAC IPNU IPPNU KANDANGAN', 'kandangan@dasi.org', NULL, '$2y$12$fWUSzdcppNA5VWmMxNdaruXgIA61V0LosAxBjnxsKp6CLqiluXGcW', 'eLULL5CLBEuniuZMNyUmBwMF3OInmPHqtlu2McIQ5QCdfXZ7SvONhgnnjFOY', '2026-01-24 00:02:37', '2026-01-24 09:23:42', 'pac', NULL, NULL, NULL),
('use033', 'PAC IPNU IPPNU PUNCU', 'puncu@dasi.org', NULL, '$2y$12$wcVDuh0AzrlC9KCoHzH2T.wp684B70p1xO8CaZTQnCqhZm9r1L7T6', 'NPSV7XqakK5wyQQyzcBcgM9k54KPULCmMqNLSgcbfu1K4bWj75vzg716o6le', '2026-01-24 00:03:56', '2026-01-24 09:23:08', 'pac', NULL, NULL, NULL),
('use034', 'Departemen Organisasi', 'depor@dasi.org', NULL, '$2y$12$laU.tbz2ULxsSyIYYi/DGefiAbBY//W/i7x/23Ji3AjACXCdVruhK', 'z62CjEepFCdUodiXvb8n99BzaTQ1M0r8EaO1x9djk2sd039IRdc9IhTgQJKV', '2026-01-24 00:03:56', '2026-06-15 06:57:44', 'dep_organisasi', 'dep007', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensis`
--
ALTER TABLE `absensis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `absensis_program_kerja_id_foreign` (`program_kerja_id`),
  ADD KEY `absensis_departemen_id_foreign` (`departemen_id`),
  ADD KEY `absensis_created_by_foreign` (`created_by`),
  ADD KEY `absensis_organisasi_id_foreign` (`organisasi_id`);

--
-- Indexes for table `absensi_records`
--
ALTER TABLE `absensi_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `absensi_records_absensi_id_foreign` (`absensi_id`),
  ADD KEY `absensi_records_kader_id_foreign` (`kader_id`);

--
-- Indexes for table `banner_iklans`
--
ALTER TABLE `banner_iklans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `banner_iklans_posisi_unique` (`posisi`);

--
-- Indexes for table `beritas`
--
ALTER TABLE `beritas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `beritas_slug_unique` (`slug`),
  ADD KEY `beritas_kategori_berita_id_foreign` (`kategori_berita_id`),
  ADD KEY `beritas_user_id_foreign` (`user_id`),
  ADD KEY `beritas_status_index` (`status`),
  ADD KEY `beritas_tgl_publish_index` (`tgl_publish`),
  ADD KEY `beritas_is_headline_index` (`is_headline`),
  ADD KEY `beritas_views_index` (`views`),
  ADD KEY `beritas_status_tgl_publish_index` (`status`,`tgl_publish`);

--
-- Indexes for table `berita_tag`
--
ALTER TABLE `berita_tag`
  ADD PRIMARY KEY (`berita_id`,`tag_id`),
  ADD KEY `berita_tag_tag_id_foreign` (`tag_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `departemens`
--
ALTER TABLE `departemens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dokumen_arsips`
--
ALTER TABLE `dokumen_arsips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `form_kegiatans`
--
ALTER TABLE `form_kegiatans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `form_kegiatans_slug_unique` (`slug`),
  ADD UNIQUE KEY `form_kegiatans_program_kerja_id_unique` (`program_kerja_id`),
  ADD KEY `form_kegiatans_organisasi_id_foreign` (`organisasi_id`);

--
-- Indexes for table `hero_sliders`
--
ALTER TABLE `hero_sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventaris`
--
ALTER TABLE `inventaris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kaders`
--
ALTER TABLE `kaders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kaders_nik_unique` (`nik`);

--
-- Indexes for table `kategori_beritas`
--
ALTER TABLE `kategori_beritas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kategori_beritas_slug_unique` (`slug`);

--
-- Indexes for table `kategori_program`
--
ALTER TABLE `kategori_program`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kategori_program_nama_kategori_unique` (`nama_kategori`),
  ADD UNIQUE KEY `kategori_program_slug_unique` (`slug`),
  ADD KEY `kategori_program_departemen_id_foreign` (`departemen_id`),
  ADD KEY `kategori_program_organisasi_id_foreign` (`organisasi_id`);

--
-- Indexes for table `kepanitiaans`
--
ALTER TABLE `kepanitiaans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kepanitiaans_program_kerja_id_foreign` (`program_kerja_id`),
  ADD KEY `kepanitiaans_kader_id_foreign` (`kader_id`);

--
-- Indexes for table `komentar_beritas`
--
ALTER TABLE `komentar_beritas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `komentar_beritas_parent_id_foreign` (`parent_id`),
  ADD KEY `komentar_beritas_berita_id_is_approved_index` (`berita_id`,`is_approved`);

--
-- Indexes for table `layanans`
--
ALTER TABLE `layanans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organisasis`
--
ALTER TABLE `organisasis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organisasis_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pendaftarans`
--
ALTER TABLE `pendaftarans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pendaftarans_program_kerja_id_foreign` (`program_kerja_id`),
  ADD KEY `pendaftarans_kader_id_foreign` (`kader_id`);

--
-- Indexes for table `pengaturan_webs`
--
ALTER TABLE `pengaturan_webs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengurus`
--
ALTER TABLE `pengurus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengurus_kader_id_foreign` (`kader_id`),
  ADD KEY `pengurus_surat_keputusan_id_foreign` (`surat_keputusan_id`),
  ADD KEY `pengurus_parent_id_foreign` (`parent_id`),
  ADD KEY `pengurus_departemen_id_index` (`departemen_id`),
  ADD KEY `pengurus_parent_id_index` (`parent_id`),
  ADD KEY `pengurus_organisasi_id_foreign` (`organisasi_id`);

--
-- Indexes for table `peserta_kegiatans`
--
ALTER TABLE `peserta_kegiatans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peserta_kegiatans_form_kegiatan_id_foreign` (`form_kegiatan_id`),
  ADD KEY `peserta_kegiatans_user_id_foreign` (`user_id`);

--
-- Indexes for table `program_kerjas`
--
ALTER TABLE `program_kerjas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `program_kerjas_verified_by_foreign` (`verified_by`);

--
-- Indexes for table `realisasi_program`
--
ALTER TABLE `realisasi_program`
  ADD PRIMARY KEY (`id`),
  ADD KEY `realisasi_program_kategori_program_id_foreign` (`kategori_program_id`),
  ADD KEY `realisasi_program_organisasi_id_foreign` (`organisasi_id`);

--
-- Indexes for table `riwayat_pelatihans`
--
ALTER TABLE `riwayat_pelatihans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `riwayat_pelatihans_kader_id_foreign` (`kader_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `surat_keluars`
--
ALTER TABLE `surat_keluars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surat_keluars_departemen_id_foreign` (`departemen_id`),
  ADD KEY `surat_keluars_pembuat_id_foreign` (`pembuat_id`);

--
-- Indexes for table `surat_keputusans`
--
ALTER TABLE `surat_keputusans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `surat_keputusans_nomor_sk_unique` (`nomor_sk`),
  ADD KEY `surat_keputusans_organisasi_id_foreign` (`organisasi_id`);

--
-- Indexes for table `surat_masuks`
--
ALTER TABLE `surat_masuks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tags_slug_unique` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_kader_id_foreign` (`kader_id`),
  ADD KEY `users_organisasi_id_foreign` (`organisasi_id`),
  ADD KEY `users_departemen_id_foreign` (`departemen_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi_records`
--
ALTER TABLE `absensi_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `banner_iklans`
--
ALTER TABLE `banner_iklans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `beritas`
--
ALTER TABLE `beritas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `dokumen_arsips`
--
ALTER TABLE `dokumen_arsips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_kegiatans`
--
ALTER TABLE `form_kegiatans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hero_sliders`
--
ALTER TABLE `hero_sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `inventaris`
--
ALTER TABLE `inventaris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori_beritas`
--
ALTER TABLE `kategori_beritas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kategori_program`
--
ALTER TABLE `kategori_program`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `komentar_beritas`
--
ALTER TABLE `komentar_beritas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `organisasis`
--
ALTER TABLE `organisasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `pengaturan_webs`
--
ALTER TABLE `pengaturan_webs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `peserta_kegiatans`
--
ALTER TABLE `peserta_kegiatans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `realisasi_program`
--
ALTER TABLE `realisasi_program`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=622;

--
-- AUTO_INCREMENT for table `riwayat_pelatihans`
--
ALTER TABLE `riwayat_pelatihans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_keluars`
--
ALTER TABLE `surat_keluars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_keputusans`
--
ALTER TABLE `surat_keputusans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `surat_masuks`
--
ALTER TABLE `surat_masuks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensis`
--
ALTER TABLE `absensis`
  ADD CONSTRAINT `absensis_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `absensis_departemen_id_foreign` FOREIGN KEY (`departemen_id`) REFERENCES `departemens` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `absensis_organisasi_id_foreign` FOREIGN KEY (`organisasi_id`) REFERENCES `organisasis` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `absensis_program_kerja_id_foreign` FOREIGN KEY (`program_kerja_id`) REFERENCES `program_kerjas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `absensi_records`
--
ALTER TABLE `absensi_records`
  ADD CONSTRAINT `absensi_records_absensi_id_foreign` FOREIGN KEY (`absensi_id`) REFERENCES `absensis` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `absensi_records_kader_id_foreign` FOREIGN KEY (`kader_id`) REFERENCES `kaders` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `beritas`
--
ALTER TABLE `beritas`
  ADD CONSTRAINT `beritas_kategori_berita_id_foreign` FOREIGN KEY (`kategori_berita_id`) REFERENCES `kategori_beritas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `beritas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `berita_tag`
--
ALTER TABLE `berita_tag`
  ADD CONSTRAINT `berita_tag_berita_id_foreign` FOREIGN KEY (`berita_id`) REFERENCES `beritas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `berita_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `form_kegiatans`
--
ALTER TABLE `form_kegiatans`
  ADD CONSTRAINT `form_kegiatans_organisasi_id_foreign` FOREIGN KEY (`organisasi_id`) REFERENCES `organisasis` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `form_kegiatans_program_kerja_id_foreign` FOREIGN KEY (`program_kerja_id`) REFERENCES `program_kerjas` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `kategori_program`
--
ALTER TABLE `kategori_program`
  ADD CONSTRAINT `kategori_program_departemen_id_foreign` FOREIGN KEY (`departemen_id`) REFERENCES `departemens` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kategori_program_organisasi_id_foreign` FOREIGN KEY (`organisasi_id`) REFERENCES `organisasis` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `kepanitiaans`
--
ALTER TABLE `kepanitiaans`
  ADD CONSTRAINT `kepanitiaans_kader_id_foreign` FOREIGN KEY (`kader_id`) REFERENCES `kaders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `kepanitiaans_program_kerja_id_foreign` FOREIGN KEY (`program_kerja_id`) REFERENCES `program_kerjas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `komentar_beritas`
--
ALTER TABLE `komentar_beritas`
  ADD CONSTRAINT `komentar_beritas_berita_id_foreign` FOREIGN KEY (`berita_id`) REFERENCES `beritas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `komentar_beritas_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `komentar_beritas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `organisasis`
--
ALTER TABLE `organisasis`
  ADD CONSTRAINT `organisasis_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `organisasis` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pendaftarans`
--
ALTER TABLE `pendaftarans`
  ADD CONSTRAINT `pendaftarans_kader_id_foreign` FOREIGN KEY (`kader_id`) REFERENCES `kaders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pendaftarans_program_kerja_id_foreign` FOREIGN KEY (`program_kerja_id`) REFERENCES `program_kerjas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengurus`
--
ALTER TABLE `pengurus`
  ADD CONSTRAINT `pengurus_organisasi_id_foreign` FOREIGN KEY (`organisasi_id`) REFERENCES `organisasis` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `peserta_kegiatans`
--
ALTER TABLE `peserta_kegiatans`
  ADD CONSTRAINT `peserta_kegiatans_form_kegiatan_id_foreign` FOREIGN KEY (`form_kegiatan_id`) REFERENCES `form_kegiatans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peserta_kegiatans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `program_kerjas`
--
ALTER TABLE `program_kerjas`
  ADD CONSTRAINT `program_kerjas_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `realisasi_program`
--
ALTER TABLE `realisasi_program`
  ADD CONSTRAINT `realisasi_program_kategori_program_id_foreign` FOREIGN KEY (`kategori_program_id`) REFERENCES `kategori_program` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `realisasi_program_organisasi_id_foreign` FOREIGN KEY (`organisasi_id`) REFERENCES `organisasis` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `surat_keputusans`
--
ALTER TABLE `surat_keputusans`
  ADD CONSTRAINT `surat_keputusans_organisasi_id_foreign` FOREIGN KEY (`organisasi_id`) REFERENCES `organisasis` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_departemen_id_foreign` FOREIGN KEY (`departemen_id`) REFERENCES `departemens` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_organisasi_id_foreign` FOREIGN KEY (`organisasi_id`) REFERENCES `organisasis` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
