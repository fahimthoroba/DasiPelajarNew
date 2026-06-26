# CONTEXT — DASI Pelajar
_Updated: 2026-06-25 oleh Claudian_

---

## 🚦 Aturan Eksekusi: Server vs Lokal

| Jenis Perubahan | Eksekusi Di |
|------------------|-------------|
| CSS/Blade/view saja, tanpa migration baru | **Server langsung** |
| Migration baru + logic counter/business rule kompleks | **Device lokal (XAMPP) dulu** — test, pastikan jalan, baru replikasi ke server |

---

## ✅ ADR-019 Selesai 100% di Lokal (task-029, 029b, 030, 031) — Belum Direplikasi ke Server

Semua terverifikasi bersih (kode dicek langsung). `kode_surat_kepanitiaan` final ditaruh di `program_kerjas` (BUKAN `kepanitiaans` — tabel itu 1 row per anggota, di-delete+recreate tiap `bulkStorePanitia()`, tidak cocok untuk field yang harus persist).

## 🔴 Task Aktif SEKARANG: task-039 — Fix Otorisasi Kritis `SuratKeluarController`

**Ditemukan saat evaluasi task-032 s/d 037 (sudah dieksekusi):** `create()`/`store()` di `SuratKeluarController` TIDAK punya guard role sama sekali (hanya `auth` global) — `scopeView()`/`scopeWrite()` sudah benar tapi tidak dipanggil di 2 method ini. Akun `role='anggota'` biasa bisa langsung generate nomor surat buku agenda utama (seharusnya eksklusif Sekretaris), dan Departemen A bisa pakai `program_kerja_id` milik Departemen B tanpa ditolak.

**Detail lengkap:** `Brain/30.Projects/DasiPelajar/06-Features/tasks/task-039-fix-otorisasi-surat-keluar.md`

**PRIORITAS DI ATAS lanjutan task-038** — ini lubang keamanan di kode yang sudah berjalan, bukan fitur belum selesai.

---

## Status Manajemen Nomor Surat — 7 Task (032-038), Eksekusi Melompat Lebih Cepat dari Rencana

**Audit ulang dokumen desain (2026-06-25) menemukan 1 bug desain warisan:** `nomor_surat_kepanitiaan_counters.kepanitiaan_id` dan `surat_keluars.kepanitiaan_id` (desain lama) masih menunjuk ke `kepanitiaans` — sudah diperbaiki di dokumen jadi `program_kerja_id` (FK ke `program_kerjas`), konsisten dengan keputusan `kode_surat_kepanitiaan`.

**Urutan eksekusi (semua lokal dulu, lihat detail per file):**
1. **task-032** — `NomorSuratFormatter` (pure, no DB) — bisa duluan, tidak depend apa pun
2. **task-033** — `periode_kepengurusans` + `nomor_surat_counters` + Flow B (Master Data)
3. **task-034** — `NomorSuratGenerator` (locking wajib, `lockForUpdate()`+`DB::transaction()`) + restrukturisasi `surat_keluars` — **rekomendasi OPUS**
4. **task-035** — Flow C (form Buat Surat, 4 jenis)
5. **task-036** — `nomor_surat_kepanitiaan_counters` (FK `program_kerja_id`) + trigger otomatis di `bulkStorePanitia()`
6. **task-037** — Freelist (`nomor_surat_dibatalkan`) + Flow D (Batalkan Surat) — **rekomendasi OPUS**
7. **task-038** — Menu "Buku Agenda" (scoping Sekretaris vs Departemen/Lembaga/Badan) — task terakhir

**Detail lengkap tiap task:** `Brain/30.Projects/DasiPelajar/06-Features/tasks/task-03[2-8]-*.md`

**Eksekusi:** Lokal dulu, semua 7 task — TIDAK perlu menunggu replikasi server ADR-019 selesai untuk mulai development.

---

## Replikasi ke Server — Urutan WAJIB

1. Replikasi 4 migration ADR-019 (029, 029b, 030, 031) ke server DULU, verifikasi stabil
2. **BARU SETELAH ITU** replikasi 6 migration Manajemen Nomor Surat (task-032 s/d 038) sekaligus — schema-nya depend langsung ke kolom yang ditambahkan ADR-019
3. Jangan campur/lompat urutan — kalau migration nomor surat jalan duluan di server tanpa ADR-019, FK ke `program_kerjas.kode_surat_kepanitiaan` akan gagal

---

## Ditunda — Menunggu Akses Gmail (User)

- SMTP Gmail (task-021 Part 6)
- Backup offsite (rclone remote)
- MFA Sekretaris/Admin

---

## Constraints Aktif
- JANGAN ubah struktur DB tanpa konfirmasi eksplisit
- JANGAN commit ke main branch langsung
- Gunakan `var(--dp-*)` CSS variables — jangan hardcode warna baru
- Custom string ID (`HasCustomId` trait) — FK pakai string, bukan integer
