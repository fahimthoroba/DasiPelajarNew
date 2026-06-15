# CLAUDE.md — DASI Pelajar
# Baca file ini di SETIAP sesi sebelum mengerjakan apapun.

---

## IDENTITAS PROYEK
- **Nama:** DASI Pelajar (Digitalisasi Administrasi & Sistem Informasi Pelajar)
- **Organisasi:** PC IPNU-IPPNU Kabupaten Kediri
- **Domain:** TBD (update saat sudah ditentukan)
- **Visi:** Platform operasional organisasi — bukan sekadar website profil. Tujuan utama: menertibkan dan mengendalikan pergerakan organisasi lewat sistem digital.

---

## INFRASTRUKTUR & SERVER

### Environment
```
Home Server   : Intel i3 gen 10, RAM 8GB DDR4
OS/Container  : CasaOS (Docker)
Internet      : 900mbps
Tunnel        : Cloudflare Zero Trust (tidak buka port di router)
SSL           : Otomatis via Cloudflare
```

### Stack Docker (semua containerized)
```
nginx/caddy      ← reverse proxy
php-fpm          ← Laravel app
mariadb          ← database utama
redis            ← cache + session
minio            ← object storage (file upload)
cloudflare-tunnel ← akses internet
```

### MinIO — Object Storage
- Self-hosted via Docker, S3-compatible
- Semua file upload disimpan ke MinIO (bukan local disk Laravel)
- Laravel menggunakan driver `s3` dengan endpoint MinIO
- Bucket naming: `dasi-public` (foto profil, gambar berita) | `dasi-private` (dokumen, LPJ, surat)
- **JANGAN** simpan file ke `storage/app/public` — selalu pakai MinIO
- Config ada di `.env`: `MINIO_ENDPOINT`, `MINIO_KEY`, `MINIO_SECRET`, `MINIO_BUCKET`

### Backup Strategy (WAJIB sebelum go live)
- Database: dump MariaDB harian otomatis via `spatie/laravel-backup`
- Files: sync MinIO bucket ke Cloudflare R2 / Backblaze B2 mingguan
- Config: backup `.env` dan `docker-compose.yml` ke external storage

---

## TECH STACK (JANGAN ganti tanpa konfirmasi)

| Layer | Teknologi | Versi |
|-------|-----------|-------|
| Backend | Laravel | 11.31 |
| Admin Panel | Filament | 4.3 |
| PHP | PHP | 8.2+ |
| Database | MariaDB | MySQL compatible |
| Cache/Session | Redis | latest |
| Object Storage | MinIO | latest (Docker) |
| CSS | Tailwind CSS | 3.4 |
| JS | Alpine.js | 3.14 |
| Animasi | AOS | 2.3 |
| Slider | Swiper.js | 12.1 |
| Build | Vite | 6.0 |
| WYSIWYG | TinyEditor (Filament plugin) | 4.0 |

---

## DESIGN SYSTEM (WAJIB konsisten di semua halaman)

### Tiga Warna Acuan (Tidak Boleh Diubah)
```
#08332c  — Hijau tua, warna primer utama IPNU
#ba9e6f  — Emas, aksen dan highlight
#f4f4f4  — Putih gading, background dasar light mode
```

### CSS Variables — Light Mode
```css
--dp-bg-page:          #f4f4f4;
--dp-bg-surface:       #ffffff;
--dp-bg-surface-2:     rgba(8,51,44,0.04);
--dp-bg-primary:       #08332c;
--dp-bg-primary-hover: #0f4a3a;
--dp-text-primary:     #1a1a1a;
--dp-text-secondary:   #4a6b60;
--dp-text-on-primary:  #f4f4f4;
--dp-text-gold:        #ba9e6f;
--dp-text-gold-bright: #d4bc91;
--dp-border:           rgba(8,51,44,0.10);
--dp-border-strong:    rgba(8,51,44,0.20);
--dp-border-gold:      rgba(186,158,111,0.40);
--dp-gold:             #ba9e6f;
--dp-gold-light:       #d4bc91;
--dp-gold-tint:        rgba(186,158,111,0.12);
--dp-primary-tint:     rgba(8,51,44,0.08);
--dp-danger:           #e8463a;
--dp-danger-tint:      #fde8e7;
--dp-status-done:      #08332c;
--dp-status-on:        #ba9e6f;
--dp-status-plan:      rgba(8,51,44,0.20);
--dp-status-fail:      #e8463a;
```

### CSS Variables — Dark Mode
```css
/* Di dalam .dark { } atau [data-theme="dark"] { } */
--dp-bg-page:          #051a12;
--dp-bg-surface:       #0f2a1e;
--dp-bg-surface-2:     rgba(186,158,111,0.05);
--dp-bg-primary:       #051a12;
--dp-bg-primary-hover: #0a1f16;
--dp-text-primary:     #e8e8e8;
--dp-text-secondary:   #7aab96;
--dp-text-on-primary:  #f4f4f4;
--dp-text-gold:        #ba9e6f;
--dp-text-gold-bright: #d4bc91;
--dp-border:           rgba(186,158,111,0.12);
--dp-border-strong:    rgba(186,158,111,0.25);
--dp-border-gold:      rgba(186,158,111,0.30);
--dp-gold:             #ba9e6f;
--dp-gold-light:       #d4bc91;
--dp-gold-tint:        rgba(186,158,111,0.15);
--dp-primary-tint:     rgba(8,51,44,0.50);
--dp-danger:           #e8463a;
--dp-danger-tint:      rgba(232,70,58,0.15);
--dp-status-done:      #7aab96;
--dp-status-on:        #ba9e6f;
--dp-status-plan:      rgba(186,158,111,0.20);
--dp-status-fail:      #e8463a;
```

### Tipografi
```
Display (judul, heading) : 'Outfit', sans-serif  — weight 700, 900  (Tailwind: font-display)
Body (teks umum)         : 'Inter', sans-serif   — weight 300, 400, 600 (Tailwind: font-body)

Google Fonts:
  https://fonts.googleapis.com/css2?family=Outfit:wght@400;700;900&family=Inter:wght@300;400;600&display=swap

Tailwind config: fontFamily.display = ['Outfit'], fontFamily.body = ['Inter']
JANGAN gunakan: Playfair Display, Roboto, Arial, atau system font
```

### Karakter Visual
- Gaya: Portal berita/media (Kompas, Tirto) + elegan organisasi Islam
- Layout berita: Bento grid
- Section header: border-top 3px solid #08332c + judul Playfair + garis + "Lihat Semua →" emas
- TIDAK BOLEH: gradien berlebihan, warna pastel, tampilan generik

### Token Komponen Standar
```css
Navbar        : bg #08332c, border-bottom 3px solid #ba9e6f
Ticker        : bg #08332c, label bg #ba9e6f color #08332c
Badge kateg.  : bg #08332c, color #ba9e6f, 10px uppercase tracking-widest
Badge emas    : bg #ba9e6f, color #08332c
Stat angka    : Playfair Display 900, color #08332c (light) / #ba9e6f (dark)
Card berita   : bg surface, border 0.5px dp-border, radius 4px
Proker header : bg #08332c, teks putih, sub teks #ba9e6f
Status dot    : Terlaksana=#08332c | Berjalan=#ba9e6f | Rencana=muted | Gagal=#e8463a
```

---

## STRUKTUR APLIKASI

### Dua Sisi Utama
```
DASI Pelajar
├── Sisi Publik (/)
│   ├── Homepage              ← welcome.blade.php (perlu redesign)
│   ├── Portal Berita         ← /berita
│   ├── Struktur Kepengurusan ← /struktur (hanya PC)
│   ├── Program Kerja         ← /program-kerja (dari model ProgramKerja)
│   └── Layanan / Download    ← /layanan (model baru)
│
└── Sisi Pengurus (/dashboard)
    ← Satu dashboard, dibedakan field kategori (IPNU/IPPNU) pada user
    ← Login tunggal, semua role masuk dashboard yang sama
```

### Hierarki Organisasi
```
PC IPNU/IPPNU (Kab. Kediri)          ← Fokus utama
 ├── PAC (~26 kecamatan)
 │    ├── PR (~318 desa)              ← PR TIDAK punya PK di bawahnya
 │    └── PK Sekolah/Ponpes           ← parent_id = PAC
 │         jenis_pk: 'sekolah'/'ponpes'
 │
 └── PK Perguruan Tinggi              ← parent_id = PC
      jenis_pk: 'perguruan_tinggi'
      Dikoordinasi LKPT, akses setara PAC

Field di tabel organisasis:
  tingkat  : 'PC' / 'PAC' / 'PR' / 'PK'
  jenis_pk : NULL / 'perguruan_tinggi' / 'sekolah' / 'ponpes'
  kategori : 'IPNU' / 'IPPNU'
```

### Daftar Departemen, Lembaga, Badan Resmi

**IPNU — Departemen:**
```
dep_organisasi  → Departemen Organisasi
dep_kaderisasi  → Departemen Kaderisasi
dep_jaringan    → Departemen Jaringan Sekolah dan Pesantren
dep_dakwah      → Departemen Dakwah
dep_seni        → Departemen Seni, Budaya, dan Olahraga
```

**IPNU — Lembaga (jenis: 'lembaga'):**
```
lmb_lpp   → Lembaga Pers dan Penerbitan (LPP)       ← kelola berita publik
lmb_lekas → Lembaga Ekonomi, Kewirausahaan, Koperasi (LEKAS)
lmb_lan   → Lembaga Anti Narkoba (LAN)
lmb_lkpt  → Lembaga Komisariat Perguruan Tinggi (LKPT) ← koordinasi PK-PT
lmb_cbp   → Lembaga Corps Brigade Pembangunan (CBP)
```

**IPNU — Badan (jenis: 'badan'):**
```
bdn_bscc  → Badan Student Crisis Center (BSCC)
bdn_bsrc  → Badan Student Research Center (BSRC)
```

**IPPNU — Departemen:**
```
dep_pengorg  → Departemen Pengembangan Organisasi
dep_kaderisasi → Departemen Kaderisasi
dep_jaringan → Departemen Jaringan Sekolah, Madrasah, dan Pondok Pesantren
dep_dakwah   → Departemen Dakwah dan Sosial Kemasyarakatan
dep_seni     → Departemen Seni Budaya dan Olahraga
dep_media    → Departemen Media dan Digitalisasi Organisasi
```

**IPPNU — Lembaga (jenis: 'lembaga'):**
```
lmb_kpp       → Lembaga Korps Pelajar Putri (KPP)
lmb_konseling → Lembaga Konseling Pelajar Putri
lmb_ekraf     → Lembaga Ekonomi Kreatif
lmb_kdc       → Komisariat Development Center (KDC)
```

**Catatan penting tabel departemens:**
- Field `jenis`: 'departemen' / 'lembaga' / 'badan'
- Field `kategori`: 'IPNU' / 'IPPNU'
- Nama IPNU ≠ IPPNU — JANGAN samakan meski bidangnya mirip
- dep_kaderisasi, dep_jaringan, dep_dakwah, dep_seni: kode sama tapi data berbeda per kategori

---

## SISTEM ROLE & AKSES

Wakil Ketua/Sekretaris/Bendahara yang membidangi departemen mendapat role SAMA dengan koordinator departemennya — mereka berbagi dashboard yang sama.

### BPH
| Role | Jabatan | Akses |
|------|---------|-------|
| `admin` | Ketua PC | Semua modul + manajemen user |
| `sekretaris` | Sekretaris PC | Surat, inventaris, program kerja publik, layanan, absensi rapat rutin |
| `bendahara` | Bendahara PC | Keuangan |

### Departemen IPNU
| Role | Departemen | Mendapat akses: Waka, Wasek, Wabend, Koordinator |
|------|-----------|--------------------------------------------------|
| `dep_organisasi` | Dep. Organisasi | Waka1+Wasek1+Wabend1+Koordinator |
| `dep_kaderisasi` | Dep. Kaderisasi | Waka2+Wasek2+Wabend2+Koordinator |
| `dep_jaringan` | Dep. Jaringan | Waka3+Wasek3+Wabend3+Koordinator |
| `dep_dakwah` | Dep. Dakwah | Waka4+Wasek4+Wabend4+Koordinator |
| `dep_seni` | Dep. Seni, Budaya, Olahraga | Waka5+Wasek5+Wabend5+Koordinator |

### Departemen IPPNU
| Role | Departemen | Mendapat akses: Waka, Wasek, Wabend, Koordinator |
|------|-----------|--------------------------------------------------|
| `dep_pengorg` | Dep. Pengembangan Organisasi | Waka1+Wasek1+Wabend1+Koordinator |
| `dep_kaderisasi` | Dep. Kaderisasi | Waka2+Wasek2+Wabend2+Koordinator |
| `dep_jaringan` | Dep. Jaringan | Waka3+Wasek3+Wabend3+Koordinator |
| `dep_dakwah` | Dep. Dakwah & Sosial | Waka4+Wasek4+Wabend4+Koordinator |
| `dep_seni` | Dep. Seni Budaya | Waka5+Wasek5+Wabend5+Koordinator |
| `dep_media` | Dep. Media & Digitalisasi | Waka6+Wasek6+Wabend6+Koordinator |

### Lembaga & Badan
| Role | Unit |
|------|------|
| `lmb_lpp` | LPP IPNU — juga kelola berita publik |
| `lmb_lekas` | LEKAS IPNU |
| `lmb_lan` | LAN IPNU |
| `lmb_lkpt` | LKPT IPNU |
| `lmb_cbp` | CBP IPNU |
| `lmb_kpp` | KPP IPPNU |
| `lmb_konseling` | Konseling IPPNU |
| `lmb_ekraf` | Ekraf IPPNU |
| `lmb_kdc` | KDC IPPNU |
| `bdn_bscc` | BSCC IPNU |
| `bdn_bsrc` | BSRC IPNU |

### Sub-Unit & Anggota
| Role | Akses |
|------|-------|
| `pac` | Realisasi program + absensi rapat PAC |
| `pr` | Input realisasi program |
| `pk` | Input realisasi program (PK Sekolah/Ponpes) |
| `pk_pt` | Input realisasi program (PK PT, setara PAC) — belum dibangun |
| `anggota` | Profil diri + riwayat kegiatan — Phase 3 |

### Role Lama (Alias Sementara — jangan hapus dulu)
```
'pers'       → alias untuk lmb_lpp (hapus saat Phase 2 refactor)
'departemen' → alias umum (hapus saat Phase 2 refactor, route belum ada)
```

### Siapa Bisa Buat Sesi Absensi
| Role | Bisa Buat? | Jenis Sesi |
|------|-----------|-----------|
| `dep_organisasi` | ✅ | Rapat Rutin PC + Rapat Dept + Rapat Panitia |
| Semua `dep_*` lain | ✅ | Rapat Dept + Rapat Panitia |
| Semua `lmb_*` | ✅ | Rapat Lembaga + Rapat Panitia |
| Semua `bdn_*` | ✅ | Rapat Badan + Rapat Panitia |
| `sekretaris` | ✅ | Rapat Rutin PC |
| `pac` | ✅ | Rapat PAC |
| `admin` | ✅ | Semua jenis |
| `pr`, `pk`, `pk_pt`, `anggota` | ❌ | Hanya scan |

---

## MODEL DATABASE

### Model yang Sudah Ada (JANGAN ubah tanpa konfirmasi)
| Model | Tabel | Catatan |
|-------|-------|---------|
| User | users | login, role, kader_id, organisasi_id |
| Kader | kaders | data anggota |
| Pengurus | pengurus | jabatan, departemen_id, parent_id (self-ref), is_active |
| Organisasi | organisasis | PC/PAC/PR/PK + jenis_pk |
| Departemen | departemens | dept/lembaga/badan, field jenis + kategori |
| ProgramKerja | program_kerjas | milik PC/Dept — current_step 1-6, status_lpj, verified_by |
| RealisasiProgram | realisasi_programs | milik PAC/PK-PT — hanya analitik |
| Kepanitiaan | kepanitiaans | panitia per proker, custom ID pan001 |
| Absensi | absensis | sesi absensi QR — status buka/tutup, qr_token |
| AbsensiRecord | absensi_records | record per peserta (kader_id nullable, umum via nama_peserta) |
| Berita | beritas | artikel publik, is_headline, tags many-to-many |
| Tag | tags | tag berita (many-to-many via pivot berita_tag) |
| KategoriBerita | kategori_beritas | kategori artikel |
| KomentarBerita | komentar_beritas | komentar publik (parent_id self-ref, 1 level) |
| HeroSlider | hero_sliders | gambar slider homepage |
| BannerIklan | banner_iklans | banner berita 3 posisi fixed |
| SuratKeputusan | surat_keputusans | SK kepengurusan, custom ID sk001 |
| SuratMasuk | surat_masuks | arsip surat masuk |
| SuratKeluar | surat_keluars | arsip surat keluar |
| Inventaris | inventaris | aset organisasi |
| FormKegiatan | form_kegiatans | custom_fields JSON, program_kerja_id nullable unique |
| PesertaKegiatan | peserta_kegiatans | peserta dari form kegiatan |
| Layanan | layanans | file download publik, custom ID lay001 |
| Pendaftaran | pendaftarans | pendaftaran event (EventController) |
| PengaturanWeb | pengaturan_webs | konfigurasi website (singleton) |
| RiwayatPelatihan | riwayat_pelatihans | riwayat pelatihan kader |

### Dua Model Program — JANGAN campur
```
ProgramKerja     → milik PC/Departemen → tampil di /program-kerja publik
RealisasiProgram → milik PAC/PK-PT    → hanya analitik dashboard admin
```

### Custom ID Pattern
```
Kader        → kdr001    | User         → use001
ProgramKerja → proker001 | Kepanitiaan  → pan001
SuratKeputusan → sk001   | Layanan      → lay001
```
Logic: `app/Traits/HasCustomId.php` — JANGAN modifikasi tanpa konfirmasi

### Cache
- Key: `'pengurus_cabang'` | TTL: 24 jam
- Auto-clear: saat Kader atau Pengurus disimpan/dihapus
- JANGAN hapus atau bypass cache ini

---

## ATURAN CODING (WAJIB)

### Larangan Keras
- JANGAN ubah struktur database (migrasi) tanpa konfirmasi eksplisit
- JANGAN hapus atau overwrite file yang ada — tambahkan saja
- JANGAN simpan file upload ke local disk — selalu ke MinIO
- JANGAN campur ProgramKerja dengan RealisasiProgram
- JANGAN bypass middleware CheckRole.php
- JANGAN commit ke main branch langsung
- JANGAN hardcode warna di luar CSS variables design system
- JANGAN gunakan font selain Outfit (display/heading) dan Inter (body)

### Konvensi Wajib
- PHP: PSR-12
- Blade: snake_case nama file
- Route names: kebab-case (berita.show, program-kerja.index)
- Eager loading: selalu `->with('relasi')`, jangan lazy load
- Cache pengurus: selalu pakai `Cache::remember('pengurus_cabang', ...)`
- File upload: selalu `Storage::disk('minio')->put(...)`
- Mobile-first di semua Blade template baru

### Sebelum Mengubah Kode
1. Sebutkan file apa yang akan dibuat/diubah
2. Jelaskan apa yang akan dilakukan
3. Tunggu konfirmasi jika menyangkut: database, role, storage, atau relasi antar model

---

## STRUKTUR FOLDER
```
app/Http/Controllers/
├── HomeController.php
├── AuthController.php
├── DashboardController.php
├── EventController.php
├── Sekretariat/
├── Departemen/
├── Pac/
├── Kaderisasi/
├── Admin/
├── Layanan/          ← sudah ada (Phase 1 selesai)
├── FormKegiatanController.php ← standalone, bukan di subfolder
└── Absensi/          ← belum ada sebagai modul tersendiri (Phase 2)

resources/views/
├── welcome.blade.php           ← perlu redesign (Phase 1)
├── struktur-organisasi.blade.php ← perlu redesign (Phase 1)
├── berita/
├── dashboard/
├── layouts/dashboard.blade.php
└── layouts/public.blade.php    ← cek apakah sudah ada
```

---

## KNOWN ISSUES
- Role `departemen` & `pers` masih ada di kode sebagai alias sementara — jangan hapus dulu (tunggu Phase 2I)
- Multi-tenant (organisasi_id) belum konsisten di semua modul
- Mobile responsive belum dioptimalkan di semua halaman publik
- MinIO belum dikonfigurasi — masih pakai local storage sementara
- `php artisan migrate` belum dijalankan untuk migration `add_indexes_to_beritas_table` (sudah dibuat, belum aktif)
- Route `dashboard/berita` dan `dashboard/kategori` belum punya middleware role (task-001 akan fix ini)

---

## REFERENSI DOKUMENTASI (Source of Truth)

> Dokumentasi lengkap ada di Obsidian vault (`C:\Brain\Brain\Brain\30.Projects\DasiPelajar\`).
> Untuk tugas sesi ini — baca **CONTEXT.md** (sudah berisi spec lengkap, tidak perlu buka file lain).
> Untuk referensi cepat selama coding — gunakan `.claude/context/` di root project ini.

| Topik | File di .claude/context/ |
|-------|--------------------------|
| Database schema, model, enum values | `.claude/context/schema.md` |
| Semua routes & middleware | `.claude/context/api.md` |
| Laravel patterns, Blade/Tailwind patterns | `.claude/context/conventions.md` |
| Error umum & debug commands | `.claude/context/debugging.md` |
