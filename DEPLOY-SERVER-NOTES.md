# Catatan Migrasi Server — ADR-019 + Manajemen Nomor Surat

> Dibuat 2026-06-25, sebelum push branch ini ke GitHub. Baca ini SEBELUM menjalankan `php artisan migrate` di server. Tujuannya: minimalkan risiko code yang tidak sinkron dengan migration yang sudah berjalan di server, dan cegah error replay migration yang menumpuk dari beberapa sesi development lokal.

---

## 1. WAJIB: Cek Dulu Sebelum Migrasi Apa Pun

Jangan langsung `php artisan migrate`. Jalankan urutan ini dulu di server:

```bash
# 1. Lihat status migration SAAT INI di server (sebelum pull apa pun)
php artisan migrate:status

# 2. Backup database SEBELUM pull/migrate apa pun — non-negotiable
php artisan backup:run --only-db
# atau manual: mysqldump -u [user] -p [database] > backup_sebelum_migrasi_$(date +%Y%m%d_%H%M%S).sql

# 3. Pull kode baru
git fetch origin
git log HEAD..origin/main --oneline   # lihat dulu commit apa yang akan masuk, jangan blind pull
git pull origin main

# 4. Cek migration yang PENDING (belum jalan) vs yang sudah ada di server
php artisan migrate:status
```

**Kalau ada migration yang statusnya "Pending" tapi nama filenya TIDAK ADA di daftar di bawah (section 3) — STOP, jangan migrate. Itu berarti ada migration dari sumber lain yang tidak dikenal sesi ini. Laporkan dulu sebelum lanjut.**

---

## 2. Konteks: Kenapa 9 Migration Ini Saling Bergantung

Migration di bawah dibuat dalam 1 rangkaian besar 2 hari (2026-06-24 s/d 06-25): dulu **ADR-019** (fondasi tipe proker, 3 migration), lalu **Manajemen Nomor Surat** (7 task, 032-038, 6 migration) yang depend langsung ke kolom yang ditambahkan ADR-019, plus 1 fix keamanan (task-039, TIDAK ada migration, cuma ubah controller — disebut di sini supaya tidak dikira terlewat).

**Urutan dependency (WAJIB diikuti, jangan di-skip atau dibalik):**

```
ADR-019 (3 migration) — program_kerjas dapat kolom tipe_pelaksanaan + kode_surat_kepanitiaan
        ↓
Manajemen Nomor Surat (6 migration) — semuanya baca/tulis ke kolom yang baru ditambah ADR-019
```

Kalau migration Manajemen Nomor Surat dijalankan SEBELUM ADR-019 selesai di server, FK ke `program_kerjas.kode_surat_kepanitiaan` akan gagal karena kolomnya belum ada.

---

## 3. Daftar Lengkap 9 Migration Baru (Urutan Sudah Benar Secara Timestamp)

Laravel menjalankan migration berdasarkan nama file (timestamp), jadi `php artisan migrate` otomatis akan mengikuti urutan ini — **TAPI tetap verifikasi manual** dengan `migrate:status` sebelum dan sesudah, jangan asumsikan otomatis benar.

### Kelompok A — ADR-019 (Fondasi `ProgramKerja.tipe_pelaksanaan`)
| # | File Migration | Apa yang Ditambah |
|---|---|---|
| 1 | `2026_06_24_223616_add_tipe_pelaksanaan_to_program_kerjas_table.php` | `program_kerjas.tipe_pelaksanaan` (enum `kepanitiaan`/`penanggung_jawab`, default `kepanitiaan`) + `penanggung_jawab_pengurus_id` (FK ke `pengurus.id`, nullable) |
| 2 | `2026_06_25_000001_create_proker_catatan_files_table.php` | Tabel baru `proker_catatan_files` (append-only, FK `program_kerja_id`+`uploaded_by`) |
| 3 | `2026_06_25_000002_add_kode_surat_kepanitiaan_to_program_kerjas_table.php` | `program_kerjas.kode_surat_kepanitiaan` (string, nullable) — **kolom ini krusial, jadi dependency utama semua migration di Kelompok B** |

### Kelompok B — Manajemen Nomor Surat (depend ke Kelompok A)
| # | File Migration | Apa yang Ditambah |
|---|---|---|
| 4 | `2026_06_25_000003_create_periode_kepengurusans_table.php` | Tabel baru `periode_kepengurusans` |
| 5 | `2026_06_25_000004_create_nomor_surat_counters_table.php` | Tabel baru `nomor_surat_counters` (FK ke `periode_kepengurusans`) |
| 6 | `2026_06_25_000005_add_columns_to_surat_keluars_table.php` | 9 kolom baru ke `surat_keluars` (`organisasi_id`, `jenis_surat`, `jenis_organisasi`, `kode_indeks`, `program_kerja_id`, `nama_kepanitiaan`, `nomor_urut`, `nomor_urut_pasangan`, `status_arsip`) + **backfill otomatis** data lama jadi `jenis_surat='reguler'`, `status_arsip='lengkap'` |
| 7 | `2026_06_25_000006_create_nomor_surat_kepanitiaan_counters_table.php` | Tabel baru `nomor_surat_kepanitiaan_counters` (FK `program_kerja_id` — **BUKAN** ke `kepanitiaans`, lihat catatan desain di bawah) |
| 8 | `2026_06_25_000007_create_nomor_surat_dibatalkan_table.php` | Tabel baru `nomor_surat_dibatalkan` (freelist, polymorphic ke 2 tabel counter) |
| 9 | `2026_06_25_000008_add_status_to_surat_keluars_table.php` | `surat_keluars.status` (enum `aktif`/`dibatalkan`, default `aktif`) |

**Catatan:** task-029b dan task-039 TIDAK menambah migration baru sama sekali (task-029b cuma fix Blade/controller di task-029, task-039 cuma fix otorisasi controller) — keduanya disebut di sini supaya tidak dikira terlewat saat membandingkan jumlah task vs jumlah migration. **9 file di atas adalah jumlah pasti.** Verifikasi mandiri (jangan percaya angka ini begitu saja):
```bash
git log --name-only --diff-filter=A origin/main..HEAD -- database/migrations/ | grep "\.php$"
```

---

## 4. Masalah yang SUDAH Ditemukan & Diperbaiki di Lokal (Jangan Terulang di Server)

Kalau migration di server gagal dengan error yang MIRIP salah satu di bawah, itu kemungkinan regresi — bukan masalah baru, karena sudah diperbaiki sebelum push:

| Error yang Pernah Muncul di Lokal | Penyebab | Status |
|---|---|---|
| `errno 150 Foreign key constraint is incorrectly formed` | Kolom FK dideklarasikan tanpa `->nullable()` padahal pakai `->nullOnDelete()` | ✅ Sudah diperbaiki di migration `proker_catatan_files` sebelum push |
| `1059 Identifier name ... is too long` | Nama unique index auto-generate Laravel melebihi 64 karakter MySQL | ✅ Sudah diperbaiki — migration `nomor_surat_counters` & `nomor_surat_kepanitiaan_counters` sudah pakai nama index eksplisit pendek (`nsc_org_jenis_periode_unique`, `nskc_proker_jenis_unique`) |
| `1146 Table ... doesn't exist` (nama tabel salah konvensi pluralize) | Model `NomorSuratDibatalkan` butuh `protected $table = 'nomor_surat_dibatalkan'` eksplisit karena migration pakai nama singular | ✅ Sudah diperbaiki di model sebelum push |

**Kalau salah satu error ini muncul lagi di server** → berarti ada file yang TIDAK ter-pull dengan benar (cek `git status`/`git diff` setelah pull, bandingkan dengan commit yang seharusnya masuk), bukan masalah baru yang perlu didiagnosis dari nol.

---

## 5. Cek Wajib SEBELUM `php artisan migrate --force` di Server

```bash
# A. Pastikan semua file migration di atas benar-benar ada setelah git pull
ls -la database/migrations/2026_06_2[4-5]*.php

# B. Pastikan model-model baru juga ikut ter-pull (bukan cuma migration)
ls -la app/Models/ | grep -E "PeriodeKepengurusan|NomorSurat|ProkerCatatanFile"
ls -la app/Services/ | grep -E "NomorSurat|RomawiHelper"

# C. Cek composer/vendor tidak perlu update khusus untuk task ini —
#    TIDAK ada package baru ditambahkan di seluruh rangkaian ini, murni native Laravel.
#    Kalau composer.json berubah, itu di luar scope migrasi ini — investigasi terpisah.
git diff origin/main..HEAD -- composer.json composer.lock

# D. JANGAN langsung --force di production tanpa lihat dulu apa yang akan jalan
php artisan migrate --pretend
# baca outputnya, pastikan SQL yang akan dieksekusi masuk akal sebelum lanjut beneran
```

---

## 6. Eksekusi Migrasi (Setelah Semua Cek di Atas Lolos)

```bash
# Backup SEKALI LAGI tepat sebelum eksekusi nyata (kalau ada gap waktu dari backup di section 1)
php artisan backup:run --only-db

# Jalankan migrate (BUKAN migrate:fresh, BUKAN migrate:refresh — ini akan HAPUS data production)
php artisan migrate --force

# Verifikasi semua migration baru sudah "Ran"
php artisan migrate:status | tail -15
```

---

## 7. Verifikasi Setelah Migrasi (Wajib, Jangan Skip)

```bash
php artisan tinker --execute="
// 1. Pastikan data ProgramKerja lama otomatis dapat tipe_pelaksanaan='kepanitiaan', tidak ada NULL
echo 'ProgramKerja total: ' . App\Models\ProgramKerja::count() . PHP_EOL;
echo 'NULL tipe_pelaksanaan (harus 0): ' . App\Models\ProgramKerja::whereNull('tipe_pelaksanaan')->count() . PHP_EOL;

// 2. Pastikan data SuratKeluar lama (kalau ada) otomatis backfill benar
echo 'SuratKeluar total: ' . App\Models\SuratKeluar::count() . PHP_EOL;
echo 'SuratKeluar jenis_surat NULL (harus 0): ' . App\Models\SuratKeluar::whereNull('jenis_surat')->count() . PHP_EOL;
echo 'SuratKeluar status_arsip NULL (harus 0): ' . App\Models\SuratKeluar::whereNull('status_arsip')->count() . PHP_EOL;

// 3. Pastikan tabel counter baru kosong (lazy creation, BUKAN tanda error)
echo 'nomor_surat_counters (boleh 0, normal): ' . App\Models\NomorSuratCounter::count() . PHP_EOL;
echo 'nomor_surat_kepanitiaan_counters (boleh 0, normal): ' . App\Models\NomorSuratKepanitiaanCounter::count() . PHP_EOL;

// 4. Smoke test: pastikan halaman dashboard sekretariat tidak 500
echo 'Schema check selesai, tidak ada exception = OK.';
"
```

**Verifikasi via browser/curl juga:**
```bash
curl -s -o /dev/null -w "%{http_code}\n" https://[domain]/dashboard/sekretariat/surat-keluar
# Login dulu via browser dulu kalau mau test manual penuh — endpoint ini butuh auth
```

---

## 8. Hal yang TIDAK Perlu Dilakukan (Hindari Over-Action)

- **Jangan** jalankan `php artisan migrate:fresh` atau `migrate:refresh` — akan menghapus SEMUA data production
- **Jangan** generate ulang `APP_KEY` — tidak ada perubahan terkait itu di rangkaian ini
- **Jangan** jalankan seeder apa pun — tidak ada seeder baru dibuat, data lama tidak perlu di-reset
- **Jangan** ubah `.env` kecuali memang ada instruksi terpisah soal itu — rangkaian ini murni schema+kode, tidak ada config baru yang wajib

---

## 9. Kalau Ada Error yang TIDAK Ada di Daftar Section 4

Jangan langsung coba fix sendiri dengan asumsi. Lakukan ini dulu:
1. Catat PERSIS error message + nama migration yang gagal
2. Cek apakah error itu terjadi SEBELUM atau SETELAH tabel/kolom berhasil dibuat sebagian (`Schema::hasTable()`/`Schema::hasColumn()` via tinker) — beberapa migration di rangkaian ini (lihat section 4) pernah gagal di tengah jalan (CREATE TABLE sukses, lalu ALTER index gagal), meninggalkan tabel partial yang harus di-drop manual sebelum retry
3. Kalau migration sempat tercatat "Ran" di tabel `migrations` padahal gagal sebagian — hapus row itu manual dulu (`DB::table('migrations')->where('migration', '...')->delete()`) sebelum retry, supaya tidak silent-skip
4. Baru retry migration spesifik itu saja (`php artisan migrate --path=database/migrations/[nama_file].php --force`), JANGAN retry seluruh rangkaian dari awal

---

## 10. Referensi Detail Lengkap (Kalau Perlu Konteks Lebih Dalam)

Setiap keputusan desain, bug yang ditemukan, dan hasil verifikasi lengkap untuk SETIAP migration di atas sudah didokumentasikan di Obsidian vault (kalau tersedia di server/akses terpisah):
- `14-Debug-Log.md` — entry tanggal 2026-06-24 s/d 2026-06-25, urut dari task-029 sampai task-039
- `manajemen-nomor-surat.md` — desain lengkap fitur + status implementasi per task
- `11-Decisions.md` ADR-019 — keputusan arsitektur `tipe_pelaksanaan`

Kalau dokumen itu tidak bisa diakses dari server, minimal section 1-9 di file ini sudah cukup untuk eksekusi migrasi dengan aman.
