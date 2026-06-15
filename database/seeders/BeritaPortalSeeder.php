<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\KategoriBerita;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BeritaPortalSeeder extends Seeder
{
    public function run(): void
    {
        $userId = DB::table('users')->value('id') ?? 'use001';

        // ============================================
        // KATEGORI BERITA
        // ============================================
        $kategoris = [
            'Kegiatan'    => 'kegiatan',
            'Kaderisasi'  => 'kaderisasi',
            'Opini'       => 'opini',
            'Dakwah'      => 'dakwah',
            'Pengumuman'  => 'pengumuman',
            'Olahraga'    => 'olahraga',
        ];

        $katIds = [];
        foreach ($kategoris as $nama => $slug) {
            $kat = KategoriBerita::firstOrCreate(['slug' => $slug], ['nama' => $nama]);
            $katIds[$slug] = $kat->id;
        }

        // ============================================
        // TAGS
        // ============================================
        $tagNames = [
            'ipnu', 'ippnu', 'kaderisasi', 'dakwah', 'pendidikan', 'sosial',
            'olahraga', 'seni-budaya', 'kepemimpinan', 'rapat', 'pelantikan',
            'pesantren', 'santri', 'kediri', 'pelatihan', 'beasiswa',
            'ramadan', 'maulid', 'literasi', 'lingkungan',
        ];

        $tagIds = [];
        foreach ($tagNames as $name) {
            $tag = Tag::firstOrCreate(['slug' => $name], ['nama' => ucfirst(str_replace('-', ' ', $name))]);
            $tagIds[$name] = $tag->id;
        }

        // ============================================
        // BERITA — 28 artikel
        // ============================================
        $articles = [
            // === KEGIATAN ===
            [
                'judul' => 'Rakercab PC IPNU IPPNU Kabupaten Kediri 2026: Menyatukan Visi Gerakan Pelajar',
                'kategori' => 'kegiatan', 'jenis' => 'berita', 'is_headline' => true,
                'ringkasan' => 'Rapat Kerja Cabang tahunan PC IPNU IPPNU Kabupaten Kediri resmi digelar di Aula Gedung NU Kediri. Lebih dari 200 delegasi dari 26 PAC hadir membahas program kerja strategis tahun 2026.',
                'konten' => '<p>Rapat Kerja Cabang (Rakercab) tahunan PC IPNU IPPNU Kabupaten Kediri resmi digelar pada Sabtu-Minggu, 15-16 Maret 2026, bertempat di Aula Gedung NU Kabupaten Kediri.</p><p>Kegiatan yang dihadiri lebih dari 200 delegasi dari 26 Pimpinan Anak Cabang (PAC) se-Kabupaten Kediri ini membahas evaluasi program kerja tahun sebelumnya serta merancang program strategis untuk tahun 2026.</p><p>Ketua PC IPNU Kabupaten Kediri menyampaikan bahwa Rakercab tahun ini mengangkat tema "Menyatukan Visi, Menguatkan Aksi: Gerakan Pelajar untuk Kediri Bermartabat".</p><p>"Kami ingin memastikan setiap PAC memiliki peta jalan yang jelas dalam menjalankan program kaderisasi, dakwah, dan pemberdayaan pelajar di tingkat kecamatan," ungkapnya dalam sambutan pembukaan.</p><p>Beberapa poin penting yang dihasilkan antara lain: penetapan target 1000 kader baru melalui program MAKESTA di setiap PAC, peluncuran aplikasi DASI Pelajar sebagai sistem informasi digital organisasi, serta pembentukan tim relawan tanggap bencana yang terkoordinasi dengan BPBD Kabupaten Kediri.</p>',
                'tags' => ['ipnu', 'ippnu', 'rapat', 'kediri'],
                'views' => 287, 'days_ago' => 3,
            ],
            [
                'judul' => 'Pelantikan Pengurus Baru PC IPNU IPPNU Kediri Masa Khidmat 2024-2026',
                'kategori' => 'kegiatan', 'jenis' => 'berita', 'is_headline' => true,
                'ringkasan' => 'Prosesi pelantikan pengurus baru berlangsung khidmat di Pendopo Kabupaten Kediri. Bupati Kediri turut hadir memberikan amanat kepada jajaran pengurus.',
                'konten' => '<p>Pelantikan pengurus baru PC IPNU IPPNU Kabupaten Kediri masa khidmat 2024-2026 berlangsung khidmat di Pendopo Kabupaten Kediri pada Minggu, 10 Maret 2026.</p><p>Acara yang dihadiri oleh Bupati Kediri, Ketua PCNU Kabupaten Kediri, serta ratusan kader dari seluruh penjuru kabupaten ini menandai babak baru kepemimpinan organisasi pelajar terbesar di Kediri.</p><p>Dalam sambutannya, Bupati Kediri menyampaikan apresiasi terhadap peran IPNU IPPNU dalam membina generasi muda. "Saya yakin pengurus baru ini akan membawa organisasi ke level yang lebih baik, terutama dalam menghadapi tantangan era digital," ujarnya.</p><p>Ketua terpilih menyampaikan visi untuk menjadikan IPNU IPPNU Kediri sebagai organisasi pelajar yang adaptif terhadap perkembangan zaman namun tetap berpegang pada nilai-nilai Ahlussunnah wal Jamaah.</p>',
                'tags' => ['ipnu', 'ippnu', 'pelantikan', 'kediri'],
                'views' => 342, 'days_ago' => 8,
            ],
            [
                'judul' => 'CBP IPNU Kediri Gelar Latihan Disiplin dan Bela Negara di Lereng Gunung Kelud',
                'kategori' => 'kegiatan', 'jenis' => 'berita',
                'ringkasan' => 'Corps Brigade Pembangunan (CBP) IPNU Kediri mengadakan latihan fisik dan mental selama tiga hari di kawasan lereng Gunung Kelud.',
                'konten' => '<p>Lembaga Corps Brigade Pembangunan (CBP) PC IPNU Kabupaten Kediri menggelar kegiatan Latihan Disiplin dan Bela Negara pada 5-7 Maret 2026 di kawasan lereng Gunung Kelud, Kecamatan Ngancar.</p><p>Sebanyak 75 peserta dari berbagai PAC mengikuti kegiatan yang meliputi baris-berbaris, survival training, outbound kepemimpinan, serta materi wawasan kebangsaan.</p><p>"Kegiatan ini bertujuan membentuk karakter kader yang disiplin, tangguh, dan cinta tanah air," ujar Koordinator CBP PC IPNU Kediri.</p><p>Peserta juga dibekali materi pertolongan pertama dan teknik evakuasi dasar yang dapat diaplikasikan saat terjadi bencana alam di wilayah Kediri.</p>',
                'tags' => ['ipnu', 'pelatihan', 'kepemimpinan'],
                'views' => 156, 'days_ago' => 13,
            ],
            [
                'judul' => 'KPP IPPNU Kediri Adakan Pelatihan Kepemimpinan Perempuan Muda',
                'kategori' => 'kegiatan', 'jenis' => 'berita',
                'ringkasan' => 'Korps Pelajar Putri (KPP) IPPNU Kediri bekerjasama dengan Dinas Pemberdayaan Perempuan mengadakan pelatihan kepemimpinan yang diikuti 120 kader putri.',
                'konten' => '<p>Lembaga Korps Pelajar Putri (KPP) PC IPPNU Kabupaten Kediri mengadakan Pelatihan Kepemimpinan Perempuan Muda pada Sabtu, 1 Maret 2026, di Gedung Serbaguna Kecamatan Pare.</p><p>Kegiatan yang diikuti oleh 120 kader putri dari 20 PAC ini menghadirkan narasumber dari Dinas Pemberdayaan Perempuan dan Perlindungan Anak Kabupaten Kediri serta aktivis perempuan dari kalangan NU.</p><p>Materi yang disampaikan meliputi public speaking, manajemen konflik, advokasi kebijakan, serta pemberdayaan ekonomi perempuan berbasis komunitas.</p><p>"Kami ingin kader IPPNU tidak hanya aktif di organisasi, tapi juga mampu menjadi agen perubahan di masyarakat," tegas Ketua IPPNU Kediri.</p>',
                'tags' => ['ippnu', 'kepemimpinan', 'pelatihan'],
                'views' => 198, 'days_ago' => 17,
            ],
            [
                'judul' => 'IPNU IPPNU Kediri Salurkan Bantuan untuk Korban Banjir Kecamatan Kandat',
                'kategori' => 'kegiatan', 'jenis' => 'berita',
                'ringkasan' => 'Tim relawan IPNU IPPNU Kediri bergerak cepat menyalurkan bantuan logistik dan kebutuhan dasar bagi warga terdampak banjir di tiga desa Kecamatan Kandat.',
                'konten' => '<p>Merespon bencana banjir yang melanda tiga desa di Kecamatan Kandat pada Jumat, 28 Februari 2026, tim relawan PC IPNU IPPNU Kabupaten Kediri bergerak cepat melakukan aksi kemanusiaan.</p><p>Sebanyak 50 relawan yang tergabung dalam Satgas Tanggap Bencana diberangkatkan dengan membawa bantuan berupa sembako, air bersih, selimut, dan perlengkapan kebersihan.</p><p>Koordinator Satgas menyampaikan bahwa bantuan dikumpulkan dari donasi kader dan simpatisan dalam waktu kurang dari 24 jam. "Solidaritas kader luar biasa. Kami berhasil mengumpulkan bantuan senilai lebih dari Rp 15 juta," ungkapnya.</p><p>Selain bantuan material, tim relawan juga membantu proses evakuasi dan pembersihan rumah warga yang terendam banjir.</p>',
                'tags' => ['ipnu', 'ippnu', 'sosial', 'kediri'],
                'views' => 234, 'days_ago' => 18,
            ],
            [
                'judul' => 'Gebyar Sholawat dan Pengajian Akbar Memperingati Maulid Nabi di Pare',
                'kategori' => 'kegiatan', 'jenis' => 'berita',
                'ringkasan' => 'Ribuan warga dan kader memadati lapangan Kecamatan Pare dalam acara Gebyar Sholawat dan Pengajian Akbar memperingati Maulid Nabi Muhammad SAW.',
                'konten' => '<p>PAC IPNU IPPNU Pare berkolaborasi dengan MWC NU Pare menyelenggarakan Gebyar Sholawat dan Pengajian Akbar dalam rangka memperingati Maulid Nabi Muhammad SAW pada Sabtu malam, 22 Februari 2026.</p><p>Acara yang berlangsung di Lapangan Kecamatan Pare ini dihadiri ribuan jamaah dari berbagai kalangan. Grup sholawat dari Ponpes Lirboyo dan Al-Falah Ploso turut memeriahkan acara.</p><p>Pengajian akbar diisi oleh KH. Ahmad Muzammil dari Ponpes Lirboyo yang menyampaikan tausiyah tentang meneladani akhlak Rasulullah SAW dalam kehidupan sehari-hari.</p>',
                'tags' => ['dakwah', 'maulid', 'kediri'],
                'views' => 312, 'days_ago' => 24,
            ],

            // === KADERISASI ===
            [
                'judul' => 'MAKESTA Angkatan 47: Mencetak 150 Kader Baru IPNU IPPNU Kediri',
                'kategori' => 'kaderisasi', 'jenis' => 'berita', 'is_headline' => true,
                'ringkasan' => 'Masa Kesetiaan Anggota (MAKESTA) angkatan ke-47 resmi dilaksanakan selama dua hari. Sebanyak 150 calon kader baru mengikuti proses kaderisasi awal organisasi.',
                'konten' => '<p>PC IPNU IPPNU Kabupaten Kediri resmi melaksanakan Masa Kesetiaan Anggota (MAKESTA) angkatan ke-47 pada 8-9 Maret 2026 di Pondok Pesantren Al-Falah Ploso, Kecamatan Mojo.</p><p>Sebanyak 150 calon kader baru yang berasal dari berbagai SMA, SMK, MA, dan pondok pesantren di Kabupaten Kediri mengikuti rangkaian kegiatan yang meliputi materi ke-NU-an, ke-IPNU/IPPNU-an, wawasan kebangsaan, serta praktik organisasi.</p><p>Departemen Kaderisasi PC IPNU Kediri menyampaikan bahwa MAKESTA tahun ini menggunakan metode pembelajaran yang lebih interaktif. "Kami mengurangi ceramah satu arah dan lebih banyak menggunakan diskusi kelompok, studi kasus, dan simulasi," jelasnya.</p><p>Para peserta juga diperkenalkan dengan sistem DASI Pelajar sebagai platform digital organisasi yang akan mereka gunakan sebagai kader resmi.</p>',
                'tags' => ['kaderisasi', 'ipnu', 'ippnu', 'pendidikan'],
                'views' => 189, 'days_ago' => 10,
            ],
            [
                'judul' => 'Lakmud IPNU Kediri: Membangun Kapasitas Kader Tingkat Madya',
                'kategori' => 'kaderisasi', 'jenis' => 'berita',
                'ringkasan' => 'Latihan Kader Muda (Lakmud) digelar untuk meningkatkan kapasitas 60 kader yang telah melewati jenjang MAKESTA.',
                'konten' => '<p>Departemen Kaderisasi PC IPNU Kabupaten Kediri menyelenggarakan Latihan Kader Muda (Lakmud) pada 22-24 Februari 2026 di Wisma Haji Kabupaten Kediri.</p><p>Sebanyak 60 kader yang telah melewati jenjang MAKESTA mengikuti pelatihan intensif selama tiga hari yang membahas kepemimpinan organisasi, manajemen konflik, analisis sosial, serta teknik advokasi.</p><p>Kegiatan ini juga menghadirkan alumni IPNU IPPNU yang kini berkiprah di berbagai bidang sebagai motivator dan mentor bagi para peserta.</p>',
                'tags' => ['kaderisasi', 'ipnu', 'pelatihan', 'kepemimpinan'],
                'views' => 124, 'days_ago' => 24,
            ],

            // === OPINI ===
            [
                'judul' => 'Merawat Tradisi Intelektual di Era Digital: Tantangan Kader NU Milenial',
                'kategori' => 'opini', 'jenis' => 'opini',
                'ringkasan' => 'Refleksi mendalam tentang bagaimana kader muda NU dapat mempertahankan tradisi keilmuan pesantren sambil beradaptasi dengan revolusi digital yang mengubah cara berpikir generasi muda.',
                'konten' => '<p>Di tengah deras arus informasi digital, kader muda Nahdlatul Ulama menghadapi dilema yang tidak sederhana: bagaimana mempertahankan tradisi intelektual pesantren yang kaya dan mendalam, sambil tetap relevan di era yang serba cepat dan serba instan?</p><p>Tradisi <em>bahtsul masail</em>, pengajian kitab kuning, dan diskusi-diskusi intelektual yang menjadi ciri khas pesantren adalah kekayaan yang tidak dimiliki oleh tradisi pendidikan manapun. Namun, metode-metode ini kerap dianggap "lambat" dan "ketinggalan zaman" oleh generasi yang terbiasa dengan informasi instan dari media sosial.</p><p>Tugas kader IPNU IPPNU adalah menjadi jembatan — menerjemahkan kedalaman tradisi pesantren ke dalam bahasa dan medium yang dipahami generasi digital, tanpa mengorbankan substansinya.</p><p>Inilah yang disebut sebagai <em>al-muhafadzah ala al-qadim al-shalih wa al-akhdzu bi al-jadid al-ashlah</em> — memelihara tradisi lama yang baik dan mengambil tradisi baru yang lebih baik.</p>',
                'tags' => ['kaderisasi', 'pendidikan', 'pesantren', 'literasi'],
                'views' => 178, 'days_ago' => 5,
            ],
            [
                'judul' => 'Mengapa Organisasi Pelajar Masih Relevan di Tahun 2026?',
                'kategori' => 'opini', 'jenis' => 'opini',
                'ringkasan' => 'Di era ketika semua bisa dipelajari secara online, apakah organisasi pelajar tradisional seperti IPNU IPPNU masih punya tempat? Artikel ini menjawab dengan tegas: ya, justru semakin relevan.',
                'konten' => '<p>Pertanyaan ini kerap muncul, terutama dari kalangan yang melihat organisasi kepemudaan sebagai entitas usang yang gagal beradaptasi. Namun data menunjukkan sebaliknya.</p><p>Organisasi pelajar seperti IPNU IPPNU menyediakan sesuatu yang tidak bisa diberikan oleh platform digital manapun: <strong>pengalaman langsung</strong> dalam berinteraksi, bernegosiasi, memimpin, dan bertanggung jawab.</p><p>Soft skills seperti kepemimpinan, komunikasi, dan manajemen konflik hanya bisa diasah melalui praktik nyata — bukan melalui video tutorial atau kursus online.</p><p>Justru di era atomisasi sosial yang dipicu media sosial, organisasi pelajar menjadi salah satu ruang terakhir di mana generasi muda bisa membangun solidaritas genuine dan belajar tentang kehidupan kolektif.</p>',
                'tags' => ['ipnu', 'ippnu', 'pendidikan', 'kepemimpinan'],
                'views' => 145, 'days_ago' => 12,
            ],
            [
                'judul' => 'Catatan dari Pesantren: Belajar Sabar dari Kitab Kuning',
                'kategori' => 'opini', 'jenis' => 'opini',
                'ringkasan' => 'Seorang santri berbagi pengalamannya belajar kesabaran melalui proses mengaji kitab kuning yang panjang dan mendalam di pesantren tradisional.',
                'konten' => '<p>Ada sebuah pelajaran yang tidak tertulis di kurikulum manapun namun menjadi fondasi utama pendidikan pesantren: kesabaran. Bukan kesabaran pasif yang hanya menunggu, melainkan kesabaran aktif yang terus berproses.</p><p>Ketika duduk di hadapan kiai, membaca baris demi baris kitab kuning dengan metode <em>bandongan</em>, seorang santri belajar bahwa ilmu tidak bisa diunduh secara instan. Ada proses, ada waktu, ada pengulangan yang tampaknya membosankan namun sesungguhnya membentuk karakter.</p><p>Di era serba cepat ini, kemampuan untuk sabar dalam berproses adalah keunggulan kompetitif yang luar biasa. Dan pesantren, dengan segala kesederhanaannya, telah mengajarkan itu selama berabad-abad.</p>',
                'tags' => ['pesantren', 'santri', 'pendidikan', 'literasi'],
                'views' => 201, 'days_ago' => 20,
            ],

            // === DAKWAH ===
            [
                'judul' => 'Kajian Ramadan: Fiqih Puasa Kontemporer untuk Pelajar',
                'kategori' => 'dakwah', 'jenis' => 'berita',
                'ringkasan' => 'Departemen Dakwah PC IPNU Kediri mengadakan seri kajian Ramadan yang membahas fiqih puasa kontemporer khusus untuk kalangan pelajar.',
                'konten' => '<p>Menyambut bulan Ramadan 1447 H, Departemen Dakwah PC IPNU Kabupaten Kediri menggelar seri Kajian Ramadan bertajuk "Fiqih Puasa Kontemporer untuk Pelajar" pada setiap Ahad pagi selama bulan Sya\'ban.</p><p>Kajian yang dilaksanakan secara hybrid (luring di Aula PCNU Kediri dan daring via Zoom) ini membahas berbagai persoalan fiqih puasa yang relevan dengan kehidupan pelajar masa kini.</p><p>Beberapa topik yang dibahas antara lain: hukum puasa bagi pelajar yang mengikuti ujian berat, penggunaan infus vitamin saat puasa, serta etika bermedia sosial di bulan Ramadan.</p>',
                'tags' => ['dakwah', 'ramadan', 'pendidikan'],
                'views' => 167, 'days_ago' => 7,
            ],
            [
                'judul' => 'Ngaji Filsafat: Diskusi Rutin yang Memadukan Tradisi dan Modernitas',
                'kategori' => 'dakwah', 'jenis' => 'berita',
                'ringkasan' => 'Forum diskusi "Ngaji Filsafat" menjadi wadah kader muda mempelajari pemikiran Islam klasik dan kontemporer dengan pendekatan kritis.',
                'konten' => '<p>Setiap Kamis malam, puluhan kader IPNU IPPNU Kediri berkumpul di sebuah warung kopi di Pare untuk mengikuti forum diskusi bertajuk "Ngaji Filsafat".</p><p>Forum yang digagas oleh Departemen Dakwah ini membahas karya-karya pemikir Islam klasik seperti Imam Al-Ghazali, Ibn Rushd, dan Ibn Khaldun, serta pemikir kontemporer seperti Gus Dur, Said Nursi, dan Tariq Ramadan.</p><p>"Kami ingin menunjukkan bahwa tradisi intelektual Islam sangat kaya dan bisa menjadi referensi untuk menjawab tantangan-tantangan kontemporer," ujar fasilitator diskusi.</p>',
                'tags' => ['dakwah', 'literasi', 'pendidikan'],
                'views' => 134, 'days_ago' => 14,
            ],

            // === PENGUMUMAN ===
            [
                'judul' => 'Pendaftaran Beasiswa Kader Berprestasi IPNU IPPNU Kediri Tahun 2026 Dibuka',
                'kategori' => 'pengumuman', 'jenis' => 'pengumuman',
                'ringkasan' => 'PC IPNU IPPNU Kediri membuka pendaftaran beasiswa pendidikan bagi kader berprestasi. Tersedia 20 kuota untuk jenjang SMA/SMK/MA dan perguruan tinggi.',
                'konten' => '<p><strong>Pengumuman Resmi</strong></p><p>PC IPNU IPPNU Kabupaten Kediri membuka pendaftaran Beasiswa Kader Berprestasi Tahun 2026 bagi kader aktif yang memenuhi kriteria.</p><p><strong>Kuota:</strong> 20 penerima (10 jenjang SMA/SMK/MA, 10 jenjang Perguruan Tinggi)</p><p><strong>Persyaratan:</strong></p><ul><li>Kader aktif IPNU/IPPNU minimal 1 tahun</li><li>IPK minimal 3.0 atau nilai rapor rata-rata 80</li><li>Aktif berorganisasi (dibuktikan dengan surat keterangan PAC/PR)</li><li>Surat rekomendasi dari pengurus PAC</li><li>Esai "Kontribusi Saya untuk Organisasi" (500-1000 kata)</li></ul><p><strong>Pendaftaran:</strong> 1-30 April 2026 melalui link: dasi.ipnuippnukediri.or.id/beasiswa</p><p><strong>Pengumuman:</strong> 15 Mei 2026</p>',
                'tags' => ['beasiswa', 'pendidikan', 'ipnu', 'ippnu'],
                'views' => 456, 'days_ago' => 2,
            ],
            [
                'judul' => 'Jadwal Rapat Rutin Bulanan PC IPNU IPPNU Kediri Bulan April 2026',
                'kategori' => 'pengumuman', 'jenis' => 'pengumuman',
                'ringkasan' => 'Informasi jadwal rapat rutin bulanan untuk seluruh pengurus PC, PAC, dan lembaga/badan pada bulan April 2026.',
                'konten' => '<p><strong>Jadwal Rapat Rutin April 2026:</strong></p><p><strong>1. Rapat Pleno PC</strong><br>Hari/Tanggal: Sabtu, 5 April 2026<br>Waktu: 19.30 WIB<br>Tempat: Aula PCNU Kabupaten Kediri<br>Wajib hadir: Seluruh BPH dan Koordinator Departemen/Lembaga/Badan</p><p><strong>2. Rapat Koordinasi PAC</strong><br>Hari/Tanggal: Sabtu, 12 April 2026<br>Waktu: 13.00 WIB<br>Tempat: Aula PCNU Kabupaten Kediri<br>Wajib hadir: Seluruh Ketua dan Sekretaris PAC</p><p><strong>3. Rapat Evaluasi Departemen</strong><br>Hari/Tanggal: Sabtu, 19 April 2026<br>Waktu: 15.00 WIB<br>Tempat: Aula PCNU Kabupaten Kediri</p><p>Kehadiran wajib. Ketidakhadiran tanpa keterangan akan dicatat dalam evaluasi kinerja pengurus.</p>',
                'tags' => ['rapat', 'ipnu', 'ippnu'],
                'views' => 89, 'days_ago' => 1,
            ],
            [
                'judul' => 'Lowongan: Tim Redaksi LPP IPNU Kediri Cari Kontributor Muda',
                'kategori' => 'pengumuman', 'jenis' => 'pengumuman',
                'ringkasan' => 'Lembaga Pers dan Penerbitan (LPP) IPNU Kediri membuka rekrutmen kontributor muda untuk mengisi konten portal berita DASI Pelajar.',
                'konten' => '<p>Lembaga Pers dan Penerbitan (LPP) PC IPNU Kabupaten Kediri membuka kesempatan bagi kader muda yang memiliki minat di bidang jurnalistik untuk bergabung sebagai kontributor.</p><p><strong>Posisi yang dibutuhkan:</strong></p><ul><li>Reporter Lapangan (5 orang)</li><li>Penulis Opini (3 orang)</li><li>Fotografer/Videografer (3 orang)</li><li>Editor Konten (2 orang)</li></ul><p><strong>Syarat:</strong></p><ul><li>Kader aktif IPNU/IPPNU</li><li>Memiliki kemampuan menulis yang baik</li><li>Bersedia mengikuti pelatihan jurnalistik dasar</li><li>Mampu bekerja dalam deadline</li></ul><p>Kirim CV dan portofolio ke email: lpp@ipnuippnukediri.or.id paling lambat 25 April 2026.</p>',
                'tags' => ['ipnu', 'literasi', 'pelatihan'],
                'views' => 167, 'days_ago' => 4,
            ],

            // === OLAHRAGA ===
            [
                'judul' => 'Turnamen Futsal Santri Cup 2026: PAC Pare Juara Bertahan',
                'kategori' => 'olahraga', 'jenis' => 'berita',
                'ringkasan' => 'PAC IPNU Pare berhasil mempertahankan gelar juara Turnamen Futsal Santri Cup setelah mengalahkan PAC Gurah di final dengan skor 4-2.',
                'konten' => '<p>PAC IPNU Pare berhasil mempertahankan gelar juara dalam Turnamen Futsal Santri Cup 2026 yang diselenggarakan oleh Departemen Seni, Budaya, dan Olahraga PC IPNU Kabupaten Kediri.</p><p>Pertandingan final yang berlangsung seru di GOR Kecamatan Gampengrejo pada Minggu, 2 Maret 2026, berakhir dengan kemenangan PAC Pare atas PAC Gurah dengan skor 4-2.</p><p>Turnamen yang diikuti oleh 24 tim dari PAC se-Kabupaten Kediri ini berlangsung selama dua pekan dengan sistem gugur. Selain gelar juara, panitia juga memberikan penghargaan pemain terbaik dan pencetak gol terbanyak.</p><p>"Olahraga adalah media yang efektif untuk mempererat ukhuwah antar kader dari berbagai PAC," ujar Koordinator Departemen Seni, Budaya, dan Olahraga.</p>',
                'tags' => ['olahraga', 'ipnu', 'kediri'],
                'views' => 267, 'days_ago' => 16,
            ],
            [
                'judul' => 'Fun Run 5K Hari Jadi IPNU: Ratusan Kader Berlari untuk Kebersamaan',
                'kategori' => 'olahraga', 'jenis' => 'berita',
                'ringkasan' => 'Memperingati Hari Lahir IPNU ke-72, ratusan kader mengikuti Fun Run 5K yang berlangsung meriah di pusat kota Kediri.',
                'konten' => '<p>Dalam rangka memperingati Harlah IPNU ke-72, PC IPNU Kabupaten Kediri menyelenggarakan Fun Run 5K pada Minggu pagi, 24 Februari 2026.</p><p>Sebanyak 300 peserta yang terdiri dari kader aktif, alumni, dan simpatisan mengikuti rute yang dimulai dari Alun-alun Kabupaten Kediri, melewati beberapa landmark kota, dan berakhir di titik start.</p><p>Acara dimeriahkan dengan doorprize, senam bersama, dan penampilan musik akustik dari kader-kader berbakat.</p>',
                'tags' => ['olahraga', 'ipnu', 'kediri'],
                'views' => 189, 'days_ago' => 22,
            ],

            // === MORE KEGIATAN ===
            [
                'judul' => 'Workshop Desain Grafis untuk Pengurus Media IPNU IPPNU Se-Kabupaten Kediri',
                'kategori' => 'kegiatan', 'jenis' => 'berita',
                'ringkasan' => 'Departemen Media IPPNU berkolaborasi dengan LPP IPNU mengadakan workshop desain grafis menggunakan Canva dan Figma untuk pengurus media di setiap PAC.',
                'konten' => '<p>Departemen Media dan Digitalisasi Organisasi PC IPPNU berkolaborasi dengan LPP PC IPNU Kabupaten Kediri menyelenggarakan Workshop Desain Grafis pada Sabtu, 15 Februari 2026.</p><p>Workshop yang diikuti oleh perwakilan pengurus media dari 26 PAC ini membahas teknik desain menggunakan Canva Pro dan Figma untuk keperluan publikasi organisasi.</p><p>Materi meliputi pembuatan poster kegiatan, infografis data organisasi, template media sosial, serta tips personal branding digital untuk organisasi.</p>',
                'tags' => ['ippnu', 'pelatihan', 'literasi'],
                'views' => 143, 'days_ago' => 31,
            ],
            [
                'judul' => 'Bakti Sosial IPNU IPPNU di Panti Asuhan Yatim Piatu Al-Hikmah Kediri',
                'kategori' => 'kegiatan', 'jenis' => 'berita',
                'ringkasan' => 'Puluhan kader IPNU IPPNU mengunjungi Panti Asuhan Al-Hikmah membawa donasi dan mengadakan kegiatan edukatif bersama anak-anak panti.',
                'konten' => '<p>PC IPNU IPPNU Kabupaten Kediri mengadakan kegiatan bakti sosial di Panti Asuhan Yatim Piatu Al-Hikmah, Kecamatan Ngadiluwih, pada Minggu, 9 Februari 2026.</p><p>Sebanyak 40 kader mengunjungi panti tersebut dengan membawa donasi berupa perlengkapan sekolah, buku bacaan, pakaian layak pakai, dan bahan makanan pokok.</p><p>Selain menyerahkan donasi, para kader juga mengadakan berbagai kegiatan bersama anak-anak panti, termasuk bimbingan belajar, permainan edukatif, dan sesi storytelling.</p>',
                'tags' => ['ipnu', 'ippnu', 'sosial', 'kediri'],
                'views' => 112, 'days_ago' => 37,
            ],
            [
                'judul' => 'Pelatihan Jurnalistik Pelajar NU: Mengasah Nalar Kritis di Era Digital',
                'kategori' => 'kegiatan', 'jenis' => 'berita',
                'ringkasan' => 'LPP IPNU Kediri menggelar pelatihan jurnalistik dasar bagi 80 kader muda dari berbagai PAC untuk meningkatkan kemampuan literasi media.',
                'konten' => '<p>Lembaga Pers dan Penerbitan (LPP) PC IPNU Kabupaten Kediri menggelar Pelatihan Jurnalistik Pelajar NU pada Sabtu-Minggu, 1-2 Februari 2026, di Gedung PCNU Kabupaten Kediri.</p><p>Pelatihan yang diikuti oleh 80 kader muda dari berbagai PAC ini menghadirkan narasumber dari kalangan jurnalis profesional dan akademisi komunikasi.</p><p>Materi yang disampaikan meliputi teknik penulisan berita, etika jurnalistik, fotografi dasar, pengelolaan media sosial organisasi, serta literasi media dan cara menangkal hoaks.</p><p>"Di era informasi ini, setiap kader harus punya kemampuan dasar jurnalistik untuk bisa menyaring dan menyebarkan informasi yang benar," tegas Koordinator LPP.</p>',
                'tags' => ['ipnu', 'literasi', 'pelatihan', 'pendidikan'],
                'views' => 156, 'days_ago' => 45,
            ],

            // === MORE DAKWAH ===
            [
                'judul' => 'Safari Dakwah Ramadan: IPNU IPPNU Keliling 26 Kecamatan',
                'kategori' => 'dakwah', 'jenis' => 'berita',
                'ringkasan' => 'Program Safari Dakwah Ramadan menyasar seluruh kecamatan di Kabupaten Kediri dengan menghadirkan penceramah muda dari kalangan kader.',
                'konten' => '<p>Menyambut bulan suci Ramadan 1447 H, PC IPNU IPPNU Kabupaten Kediri meluncurkan program Safari Dakwah Ramadan yang akan mengunjungi seluruh 26 kecamatan di Kabupaten Kediri.</p><p>Program ini menugaskan kader-kader muda yang telah terlatih sebagai penceramah untuk mengisi kegiatan-kegiatan keagamaan di musholla dan masjid selama bulan Ramadan.</p><p>"Ini adalah bentuk kontribusi nyata organisasi kepada masyarakat sekaligus wadah bagi kader untuk mengasah kemampuan dakwah mereka," ujar Koordinator Departemen Dakwah.</p>',
                'tags' => ['dakwah', 'ramadan', 'ipnu', 'ippnu'],
                'views' => 198, 'days_ago' => 6,
            ],

            // === MORE OPINI ===
            [
                'judul' => 'Digitalisasi Organisasi: Bukan Sekedar Gaya, Tapi Kebutuhan',
                'kategori' => 'opini', 'jenis' => 'opini',
                'ringkasan' => 'Mengapa transformasi digital bukan pilihan tapi keharusan bagi organisasi kepemudaan seperti IPNU IPPNU untuk tetap relevan dan efektif.',
                'konten' => '<p>Ketika PC IPNU IPPNU Kabupaten Kediri memutuskan untuk membangun platform DASI Pelajar, tidak sedikit yang bertanya: "Memangnya perlu?"</p><p>Jawabannya sederhana: <strong>sangat perlu</strong>. Bayangkan mengelola data ribuan kader di 26 kecamatan hanya dengan buku tulis dan spreadsheet. Bayangkan mengkoordinasikan ratusan kegiatan tanpa sistem terpusat. Bayangkan memverifikasi kehadiran rapat 200 orang dengan absensi kertas.</p><p>Digitalisasi organisasi bukan tentang mengikuti tren teknologi. Ini tentang efisiensi, akuntabilitas, dan keberlanjutan. Pengurus berganti setiap dua tahun — tanpa sistem digital, pengetahuan dan data organisasi ikut pergi bersama pengurus lama.</p><p>DASI Pelajar adalah jawaban untuk masalah ini. Sebuah sistem yang memastikan kontinuitas organisasi melampaui pergantian kepengurusan.</p>',
                'tags' => ['ipnu', 'ippnu', 'literasi'],
                'views' => 234, 'days_ago' => 9,
            ],

            // === FOTO ===
            [
                'judul' => 'Galeri Foto: Suasana Rakercab PC IPNU IPPNU Kediri 2026',
                'kategori' => 'kegiatan', 'jenis' => 'foto',
                'ringkasan' => 'Kumpulan foto dokumentasi kegiatan Rapat Kerja Cabang PC IPNU IPPNU Kabupaten Kediri yang berlangsung meriah selama dua hari.',
                'konten' => '<p>Berikut dokumentasi foto kegiatan Rakercab PC IPNU IPPNU Kabupaten Kediri yang berlangsung pada 15-16 Maret 2026 di Aula Gedung NU Kabupaten Kediri.</p><p>Kegiatan dihadiri lebih dari 200 delegasi dari 26 PAC se-Kabupaten Kediri. Suasana berlangsung penuh semangat dan antusiasme dari seluruh peserta.</p><p><em>Foto oleh: Tim Dokumentasi LPP PC IPNU Kediri</em></p>',
                'tags' => ['ipnu', 'ippnu', 'rapat', 'kediri'],
                'views' => 98, 'days_ago' => 3,
            ],

            // === MORE ===
            [
                'judul' => 'LEKAS IPNU Kediri Gelar Bazar Ekonomi Kreatif Santri',
                'kategori' => 'kegiatan', 'jenis' => 'berita',
                'ringkasan' => 'Lembaga Ekonomi dan Kewirausahaan (LEKAS) IPNU Kediri menyelenggarakan bazar yang menampilkan produk-produk UMKM dari kalangan santri dan pelajar.',
                'konten' => '<p>Lembaga Ekonomi, Kewirausahaan, dan Koperasi (LEKAS) PC IPNU Kabupaten Kediri menyelenggarakan Bazar Ekonomi Kreatif Santri pada Sabtu-Minggu, 22-23 Februari 2026, di halaman Masjid Agung Kediri.</p><p>Bazar yang diikuti oleh 30 UMKM dari kalangan santri dan pelajar ini menampilkan berbagai produk mulai dari makanan olahan, kerajinan tangan, fashion muslim, hingga produk digital.</p><p>"Kami ingin menunjukkan bahwa santri dan pelajar NU juga punya potensi ekonomi yang luar biasa," ujar Koordinator LEKAS.</p>',
                'tags' => ['ipnu', 'kediri', 'santri'],
                'views' => 145, 'days_ago' => 24,
            ],
            [
                'judul' => 'Konseling Pelajar Putri: IPPNU Buka Layanan Curhat Anonim Online',
                'kategori' => 'kegiatan', 'jenis' => 'berita',
                'ringkasan' => 'Lembaga Konseling Pelajar Putri IPPNU meluncurkan layanan konseling anonim online untuk membantu pelajar putri yang menghadapi masalah.',
                'konten' => '<p>Lembaga Konseling Pelajar Putri PC IPPNU Kabupaten Kediri meluncurkan layanan konseling anonim online melalui platform digital pada Senin, 10 Februari 2026.</p><p>Layanan ini bertujuan menyediakan ruang aman bagi pelajar putri untuk berkonsultasi mengenai berbagai permasalahan, mulai dari masalah akademik, keluarga, pertemanan, hingga kesehatan mental.</p><p>Tim konselor terdiri dari kader IPPNU yang telah mengikuti pelatihan konseling dasar serta didampingi oleh psikolog profesional sebagai supervisor.</p>',
                'tags' => ['ippnu', 'sosial', 'pendidikan'],
                'views' => 178, 'days_ago' => 36,
            ],
            [
                'judul' => 'LAN IPNU Kediri Sosialisasi Bahaya Narkoba di Kalangan Pelajar',
                'kategori' => 'kegiatan', 'jenis' => 'berita',
                'ringkasan' => 'Lembaga Anti Narkoba (LAN) IPNU Kediri bekerjasama dengan BNN Kabupaten Kediri mengadakan sosialisasi bahaya narkoba di 10 sekolah.',
                'konten' => '<p>Lembaga Anti Narkoba (LAN) PC IPNU Kabupaten Kediri bekerjasama dengan Badan Narkotika Nasional (BNN) Kabupaten Kediri mengadakan rangkaian sosialisasi bahaya narkoba di kalangan pelajar.</p><p>Program yang berlangsung sepanjang bulan Februari 2026 ini menyasar 10 sekolah menengah di Kabupaten Kediri dengan total peserta lebih dari 2.000 pelajar.</p><p>Metode sosialisasi yang digunakan tidak hanya ceramah, tapi juga simulasi, pemutaran film dokumenter, dan diskusi interaktif agar pesan anti-narkoba lebih mudah dipahami oleh kalangan remaja.</p>',
                'tags' => ['ipnu', 'pendidikan', 'sosial', 'kediri'],
                'views' => 167, 'days_ago' => 40,
            ],
        ];

        // ============================================
        // INSERT BERITA
        // ============================================
        // Hapus data lama dari seeder sebelumnya
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('berita_tag')->truncate();
        Berita::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        foreach ($articles as $art) {
            $berita = Berita::create([
                'kategori_berita_id' => $katIds[$art['kategori']],
                'jenis'              => $art['jenis'],
                'user_id'            => $userId,
                'judul'              => $art['judul'],
                'slug'               => Str::slug($art['judul']) . '-' . Str::random(5),
                'thumbnail'          => null,
                'konten'             => $art['konten'],
                'ringkasan'          => $art['ringkasan'],
                'status'             => 'Published',
                'is_headline'        => $art['is_headline'] ?? false,
                'tgl_publish'        => now()->subDays($art['days_ago']),
                'views'              => $art['views'],
                'sumber'             => null,
            ]);

            // Attach tags
            $beritaTagIds = [];
            foreach ($art['tags'] as $tagSlug) {
                if (isset($tagIds[$tagSlug])) {
                    $beritaTagIds[] = $tagIds[$tagSlug];
                }
            }
            $berita->tags()->attach($beritaTagIds);
        }
    }
}
