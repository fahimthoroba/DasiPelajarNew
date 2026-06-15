# ERRORS.md — DASI Pelajar
# Catat setiap bug signifikan agar tidak terulang.

---

## BUG AKTIF (Belum Difix)

### [BUG-002] MinIO belum terkonfigurasi
- **Gejala:** Upload file masih ke local storage, bukan MinIO
- **Penyebab:** `.env` belum diisi config MinIO, Docker MinIO belum setup
- **Fix:** Setup MinIO Docker dulu, lalu update `.env` (lihat `.claude/context/debugging.md` bagian "MinIO — Setup Docker" atau `10-Environment.md` di Obsidian)

### [BUG-006] Role `departemen` (alias lama) di DashboardController belum direfactor
- **File:** `app/Http/Controllers/DashboardController.php` line 19
- **Gejala:** User dengan role lama `departemen` redirect ke `dashboard.departemen.index` — route ada tapi role tidak akan ditemukan di CheckRole middleware
- **Penyebab:** Role `departemen` adalah alias sementara, belum di-replace ke role spesifik per dept
- **Status:** Pending — tunggu Phase 2I Role Refactor

---

## CLEANUP YANG SUDAH DILAKUKAN

### [CLEANUP-001] Dead code audit & purge — 2026-04-20
- **Dipicu:** Audit integrasi antar komponen (routes vs controller vs Blade)
- **Temuan:** 1 bug redirect, 5 file/folder dead code, 1 model orphan
- **Tindakan:**
  - **Fix bug:** `DashboardController` — `dep_kaderisasi` redirect dari `dashboard.kaderisasi.form.index` (tidak ada) → `dashboard.departemen.index`
  - **Hapus:** `app/Http/Controllers/SliderAdminController.php` — digantikan `MediaVisualController` sejak sesi 2026-03-19
  - **Hapus:** `resources/views/dashboard/slider/` (3 file) — route `dashboard.slider.*` sudah tidak terdaftar, views tidak dipakai
  - **Hapus:** `resources/views/welcome_old.blade.php` — backup homepage lama (versi sebelum redesign 2026-03-18)
  - **Hapus:** `resources/views/dashboard/kategori/create.blade.php` — kategori sudah inline edit, view ini tidak pernah di-return controller
  - **Hapus:** `app/Models/Meeting.php` — model orphan, tidak digunakan di controller/route/seeder manapun
  - **Hapus:** `resources/views/dashboard/sekretariat/departemen/` (2 file) — `Sekretariat/DepartemenController` tidak punya route terdaftar

---

## BUG YANG SUDAH DIFIX

### [BUG-008] `judul_form` dan `link_sukses` tidak tersimpan ke database
- **File:** `app/Http/Controllers/FormKegiatanController.php` — method `store()` dan `update()`
- **Gejala:** Field Judul Form dan Link Setelah Daftar bisa diisi di form dashboard, tapi setelah disimpan nilainya hilang (selalu `null`)
- **Penyebab:** Kolom `judul_form` dan `link_sukses` sudah ada di migration dan `$fillable` model, tapi kedua method controller tidak menyertakan field tersebut di array `create()` / `update()` — field diterima dari request tapi tidak diteruskan ke DB
- **Solusi:** Tambah `'judul_form' => $request->judul_form ?: null` dan `'link_sukses' => $request->link_sukses ?: null` di array `store()` dan `update()`
- **Status:** Fixed — 2026-04-20

### [BUG-007] Font berubah saat browser berganti bahasa / Google Translate aktif
- **File:** `tailwind.config.js` baris 16
- **Gejala:** Font tampilan berubah ke system font saat browser translate aktif atau bahasa diganti
- **Penyebab:** `font-sans` di Tailwind didefinisikan sebagai `Figtree` — font yang tidak di-load di Google Fonts URL manapun. Elemen HTML default dan elemen yang diinjeksi browser translate mewarisi `font-sans`, bukan `font-body` (Inter). Karena Figtree tidak tersedia, browser fallback ke system font.
- **Solusi:** Ganti `font-sans: ['Figtree', ...]` → `font-sans: ['Inter', ...]` agar Inter menjadi font default semua elemen, termasuk yang diinjeksi browser translate
- **Status:** Fixed — 2026-04-20

### [BUG-005] `status_pelaksanaan` tidak direset saat LPJ Ditolak
- **File:** `app/Http/Controllers/Sekretariat/ProgramKerjaController.php` — method `verifikasi()`
- **Gejala:** Setelah sekretaris klik Tolak, pesan catatan penolakan muncul benar di `show.blade.php`, tapi badge LPJ masih menampilkan "Terverifikasi" dan list departemen masih menampilkan status "Selesai"
- **Penyebab:** Action `tolak` hanya update `current_step → 5` dan `lpj_catatan`, tapi tidak reset `status_pelaksanaan`. Karena sebelumnya action `terima` sudah set `status_pelaksanaan = 'Selesai'`, nilai ini tidak berubah setelah ditolak
- **Solusi:** Tambah `status_pelaksanaan => 'Pelaksanaan'`, `verified_by => null`, `verified_at => null` di update block action tolak
- **Status:** Fixed — 2026-03-24

### [BUG-004] `QROutputInterface::OUTPUT_MARKUP_SVG` — constant tidak ditemukan
- **File:** `app/Http/Controllers/Departemen/ProgramKerjaController.php` line 152
- **Gejala:** Error `Undefined constant chillerlan\QRCode\Output\QROutputInterface::OUTPUT_MARKUP_SVG` saat membuka halaman Agenda
- **Penyebab:** Konstanta `QROutputInterface::OUTPUT_MARKUP_SVG` adalah API v4.x. Library yang terinstall adalah v5.0.5 — konstanta dipindah ke class `QRCode` langsung (`QRCode::OUTPUT_MARKUP_SVG`)
- **Solusi:** Ganti `\chillerlan\QRCode\Output\QROutputInterface::OUTPUT_MARKUP_SVG` → `\chillerlan\QRCode\QRCode::OUTPUT_MARKUP_SVG`
- **Status:** Fixed — 2026-03-20

### [BUG-003] Nama kolom LPJ salah — `lpj_path` vs `path_lpj`
- **File:** `Departemen/ProgramKerjaController.php`, `departemen/proker/show.blade.php`, `sekretariat/proker/show.blade.php`
- **Gejala:** Upload LPJ berhasil (tidak error) tapi file tidak tersimpan. Badge "Menunggu Verifikasi" tidak muncul. Link unduh LPJ di halaman verifikasi selalu hilang.
- **Penyebab:** Gemini menggunakan `lpj_path` (field request name) sebagai nama kolom DB, padahal kolom sebenarnya adalah `path_lpj` (sesuai migration dan model fillable).
- **Solusi:** Ganti semua referensi `$proker->lpj_path` dan `'lpj_path' =>` menjadi `path_lpj` di 3 file (4 lokasi).
- **Status:** Fixed — 2026-03-20

---

## FORMAT PENCATATAN
```
### [BUG-XXX] Nama Bug
- **File:** nama file
- **Gejala:** apa yang terjadi
- **Penyebab:** kenapa terjadi
- **Solusi:** apa yang berhasil
- **Status:** Fixed / Pending
```
