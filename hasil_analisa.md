# Audit Modul Berita — DASI Pelajar
**Tanggal:** 2026-06-15
**Lingkup:** `app/Models/Berita.php`, `Tag.php`, `KategoriBerita.php`, `KomentarBerita.php`, `BeritaAdminController.php`, `KategoriAdminController.php`, `HomeController.php` (indexBerita/showBerita/storeKomentar), `resources/views/berita/*`, `resources/views/dashboard/berita/*`, routes, migrations.

**Konteks pembanding:** Detik, Kompas, BBC — portal berita kelas atas dengan SEO matang, performa tinggi, dan engagement tools lengkap.

---

## Ringkasan Eksekutif

Modul berita DASI Pelajar **sudah punya fondasi CMS yang solid**: kategori, tag many-to-many, status (Draft/Published/Archived), headline, view counter, komentar berjenjang, share button, related articles, dark mode, dan editor TinyMCE dengan upload gambar. Eager loading sebagian sudah diterapkan dan ada index database dasar.

Namun dibanding standar Detik/Kompas/BBC, **gap terbesar ada di SEO (meta description, schema.org, sitemap, canonical) dan optimasi gambar (lazy load, srcset)** — dua area ini langsung berdampak pada trafik organik dan kecepatan halaman, yang merupakan inti bisnis sebuah portal berita.

Total **26 fitur/komponen teridentifikasi tidak ada**, dikelompokkan dan diurutkan di bawah berdasarkan dampak vs. effort.

---

## 🔴 PRIORITAS 1 — KRITIS (SEO & dampak trafik langsung)

### 1. Meta description tidak ada
- Halaman `/berita` (index) dan `/berita/{slug}` (show) **tidak memiliki tag `<meta name="description">`**. Show page hanya punya `og:description`.
- **Dampak:** Google menampilkan snippet acak dari konten (sering tidak relevan/terpotong aneh) → CTR hasil pencarian turun.
- **Rekomendasi:** Tambah field `meta_description` (atau fallback ke `ringkasan_or_excerpt`) ke `<head>` di `berita/show.blade.php` dan `berita/index.blade.php`.

### 2. Tidak ada Schema.org / JSON-LD (NewsArticle, BreadcrumbList)
- Tidak ditemukan structured data sama sekali di `berita/show.blade.php`.
- **Dampak:** Artikel tidak eligible untuk rich snippet, Google Discover, Top Stories carousel — yang adalah sumber trafik besar untuk portal berita.
- **Rekomendasi:** Tambah `<script type="application/ld+json">` dengan tipe `NewsArticle` (headline, image, datePublished, dateModified, author, publisher) + `BreadcrumbList` untuk breadcrumb yang sudah ada di line 67-75.

### 3. Tidak ada sitemap.xml
- `public/sitemap.xml` tidak ditemukan.
- **Dampak:** Crawler bergantung pada internal linking saja untuk discover artikel baru — indexing lambat, terutama untuk artikel lama yang tidak lagi muncul di homepage.
- **Rekomendasi:** Generate sitemap dinamis (route `/sitemap.xml`) berisi semua berita Published + kategori + halaman statis, update otomatis via job/cache.

### 4. robots.txt kosong / tidak mengarahkan sitemap
- `public/robots.txt` isinya `User-agent: *\nDisallow:` — allow all tapi tidak ada `Sitemap:` directive, dan tidak ada exclude untuk halaman draft/dashboard.
- **Rekomendasi:** Tambahkan `Sitemap: https://domain/sitemap.xml` dan disallow `/dashboard`.

### 5. Tidak ada Canonical URL
- Tidak ada `<link rel="canonical">` di index maupun show.
- **Dampak:** Risiko duplicate content jika ada parameter query (`?q=`, `?page=`) atau slug berubah.
- **Rekomendasi:** Tambah canonical tag mengarah ke URL bersih (`route('berita.show', $berita->slug)`).

### 6. Tidak ada Twitter Card
- OG tags ada tapi minimal (title, description, image) — `og:url`, `og:type`, `og:site_name`, `article:published_time`, `article:author` juga belum ada. Twitter Card (`twitter:card`, `twitter:title`, dst.) tidak ada sama sekali.
- **Dampak:** Link preview di WhatsApp/Twitter/Telegram kurang optimal — padahal share buttons sudah ada di show page, jadi ini "buang" traffic sosial yang sudah berhasil didapat.
- **Rekomendasi:** Lengkapi OG set + tambah Twitter Card meta tags di layout/head berita/show.

---

## 🟠 PRIORITAS 2 — TINGGI (Performa)

### 7. Tidak ada lazy loading gambar
- Tidak ditemukan `loading="lazy"` di thumbnail index, featured image show, related articles, atau sidebar.
- **Dampak:** Halaman index dengan puluhan thumbnail memuat semua gambar sekaligus → Largest Contentful Paint (LCP) buruk, terutama di mobile/koneksi lambat (relevan untuk target pengguna pelajar).
- **Rekomendasi:** Tambah `loading="lazy"` pada semua `<img>` kecuali hero/headline pertama (gunakan `loading="eager"` atau `fetchpriority="high"` untuk LCP image).

### 8. Tidak ada responsive image (srcset) / optimasi ukuran
- Thumbnail di-upload dan ditampilkan dalam ukuran asli tanpa resize/variant.
- **Dampak:** Mobile mendownload gambar ukuran desktop — boros bandwidth, terutama untuk pengguna dengan kuota terbatas.
- **Rekomendasi:** Generate thumbnail multi-resolusi saat upload (intervention/image atau Laravel's built-in), gunakan `srcset`/`sizes`.

### 9. N+1 query risk pada `showBerita()`
- `berita_lainnya`, `rekomendasi`, `komentars` masing-masing query terpisah (HomeController ~line 140-162) — bukan N+1 klasik tapi 3-4 query terpisah per page load yang bisa dikonsolidasi.
- **Inefficient grouping di `indexBerita()`:** ambil semua berita lalu `groupBy` di PHP per kategori (line ~202-213) — tidak scalable saat jumlah berita bertambah.
- **Rekomendasi:** Refactor grouping kategori dengan query per-kategori yang sudah `take(N)`, atau gunakan window function/subquery.

### 10. Tidak ada caching untuk list berita (headline, populer, tags)
- Hanya `PengaturanWeb` yang di-cache (1 jam). Headlines, berita populer, tags populer di-query ulang setiap request.
- **Rekomendasi:** Cache headline/populer/tags populer dengan TTL pendek (5-15 menit) + invalidasi saat berita baru di-publish (pola sama seperti cache `pengurus_cabang` yang sudah ada).

### 11. Tidak ada pagination komentar
- Semua komentar approved + reply dimuat sekaligus di show page.
- **Dampak:** Artikel viral dengan ratusan komentar → halaman jadi sangat berat.
- **Rekomendasi:** Paginate komentar top-level (mis. 10 per page) dengan "load more" via AJAX/Alpine.

---

## 🟡 PRIORITAS 3 — MENENGAH (Fitur & UX kompetitif)

### 12. Tidak ada halaman kategori/tag (archive page)
- Sidebar tags di index ditampilkan sebagai `<span>`, **tidak clickable** ke halaman tag. Kategori hanya anchor scroll (`#slug`) di halaman yang sama, bukan halaman terpisah dengan pagination.
- **Dampak:** Kehilangan struktur navigasi penting + peluang SEO long-tail (mis. `/berita/kategori/dakwah`, `/berita/tag/lpj`).
- **Rekomendasi:** Tambah route `berita.kategori` dan `berita.tag` dengan listing + pagination per kategori/tag.

### 13. Search hanya berdasarkan judul
- Search box di sidebar hanya filter `judul` (param `q`), tidak full-text, tidak mencakup `konten`/`ringkasan`/tags.
- **Rekomendasi:** Tambah full-text search (MariaDB FULLTEXT index pada `judul`, `ringkasan`, `konten`) atau minimal `LIKE` di multiple kolom + tag matching.

### 14. Tidak ada estimasi waktu baca (reading time)
- Standar di semua portal modern (Detik, Kompas, BBC menampilkan "3 menit baca").
- **Rekomendasi:** Hitung dari word count konten (`str_word_count(strip_tags($konten)) / 200`), tampilkan di metadata artikel (dekat author/tanggal).

### 15. Tidak ada halaman profil penulis
- `user_id` ada di model tapi tidak ada halaman "semua artikel oleh penulis X".
- **Rekomendasi (opsional, low effort):** Link nama author di show page ke `/berita?penulis=slug` atau halaman profil sederhana.

### 16. Tidak ada newsletter/subscription
- Tidak ada mekanisme capture email untuk update berita baru.
- **Rekomendasi:** Form sederhana di footer/sidebar → simpan ke tabel `subscribers`, kirim digest mingguan (low priority untuk fase awal).

### 17. Related articles hanya berbasis kategori
- 6 berita terkait diambil dari kategori yang sama saja — tidak mempertimbangkan tag overlap atau popularitas.
- **Rekomendasi:** Kombinasikan kategori + tag matching untuk relevansi lebih baik.

---

## 🟢 PRIORITAS 4 — RENDAH / TEKNIS (Hardening, bukan fitur)

### 18. `{!! $berita->konten !!}` — raw HTML output
- Konten TinyMCE dirender tanpa sanitasi di sisi output.
- **Risiko:** XSS jika ada user dengan akses CRUD berita yang ter-compromise, atau jika di masa depan ada multi-author dengan trust level berbeda.
- **Rekomendasi:** Sanitasi saat **save** (HTMLPurifier) — bukan saat render, agar konten lama tetap aman dan performa render tidak terdampak.

### 19. Slug generation `{slug-random(5)}`
- Kombinasi 36^5 ≈ 60 juta — risiko collision sangat rendah untuk skala organisasi ini, tapi random suffix membuat URL kurang "bersih"/SEO-friendly dibanding slug murni.
- **Catatan:** Bukan masalah mendesak untuk skala PC IPNU-IPPNU, tapi dicatat sebagai best-practice gap dibanding Kompas/Detik yang pakai slug bersih + ID numerik di URL.

### 20. Tidak ada rate limiting pada komentar & view counter
- `storeKomentar` dan `increment('views')` tidak ada throttle.
- **Dampak:** Spam komentar otomatis, atau view count bisa di-inflate via refresh berulang/bot.
- **Rekomendasi:** Tambah Laravel rate limiter (`throttle`) pada route komentar; untuk views, gunakan session/cookie debounce (1 increment per session per artikel per X menit).

### 21. Tidak ada artikel scheduling (publish terjadwal)
- `tgl_publish` di-set otomatis saat status berubah ke Published — tidak bisa set tanggal publish di masa depan untuk auto-publish.
- **Rekomendasi:** Tambah scheduled command yang mengubah status Draft→Published saat `tgl_publish` <= now (jika field ini diizinkan diisi manual saat draft).

### 22. RSS/Atom feed tidak ada
- **Dampak:** Minor untuk target audiens pelajar, tapi beberapa aggregator/embed masih mengandalkan RSS.
- **Rekomendasi:** Low priority — bisa dilakukan setelah sitemap.

---

## Tabel Perbandingan Ringkas vs. Standar Modern

| Aspek | Detik/Kompas/BBC | DASI Pelajar | Gap |
|---|---|---|---|
| Meta description | ✅ | ❌ | Kritis |
| Schema.org NewsArticle | ✅ | ❌ | Kritis |
| Sitemap.xml | ✅ | ❌ | Kritis |
| Canonical URL | ✅ | ❌ | Kritis |
| Twitter Card | ✅ | ❌ | Kritis |
| Lazy load gambar | ✅ | ❌ | Tinggi |
| Responsive image (srcset) | ✅ | ❌ | Tinggi |
| Caching list berita | ✅ | ⚠️ Parsial | Tinggi |
| Pagination komentar | ✅ | ❌ | Tinggi |
| Halaman kategori/tag | ✅ | ❌ | Menengah |
| Full-text search | ✅ | ⚠️ Judul saja | Menengah |
| Reading time | ✅ | ❌ | Menengah |
| Related articles | ✅ (kategori+tag) | ⚠️ Kategori saja | Menengah |
| Share buttons | ✅ | ✅ (4 platform) | OK |
| Komentar berjenjang | ✅ | ✅ | OK |
| Dark mode | Bervariasi | ✅ | OK |
| Status Draft/Published/Archived | ✅ | ✅ | OK |

---

## Rekomendasi Urutan Eksekusi (Quick Wins → Investasi Besar)

1. **Quick wins (1 sesi, no migration):** meta description, OG tags lengkap, Twitter Card, canonical URL, `loading="lazy"`, robots.txt fix → langsung perbaiki SEO & LCP tanpa ubah struktur DB.
2. **Sesi berikutnya (perlu sedikit logic baru):** JSON-LD NewsArticle + BreadcrumbList, reading time, cache headline/populer.
3. **Investasi menengah (perlu route/controller baru):** sitemap.xml dinamis, halaman kategori/tag archive, full-text search.
4. **Hardening (bisa paralel kapan saja):** sanitasi konten saat save, rate limiting komentar & views, pagination komentar.
5. **Opsional/jangka panjang:** newsletter, halaman profil penulis, scheduling artikel, RSS feed.

---

# BAGIAN 2 — ANALISIS UX MENDALAM (Publik vs Dashboard Admin)

**Lingkup:** `berita/index.blade.php`, `berita/show.blade.php`, `dashboard/berita/index.blade.php`, `dashboard/berita/create.blade.php`, `dashboard/berita/edit.blade.php`.

**Pembanding:** Workflow newsroom CMS modern (WordPress/Ghost-tier untuk skala kecil, hingga CMS internal Detik/Kompas untuk skala besar). Fokus: seberapa nyaman alur kerja **wartawan/admin** menulis-publish berita, dan seberapa nyaman **pembaca** mengonsumsi berita.

---

## A. UX SISI PUBLIK (Pembaca)

### A1. Hal yang sudah baik
- **Hierarki visual jelas**: ticker breaking news → hero slider → bento headline → per-kategori → grid semua berita → sidebar. Pola ini meniru Kompas/Detik dengan baik.
- **Dark mode** konsisten via CSS variables — banyak portal nasional belum punya ini.
- **Sticky sidebar** di halaman detail (`show.blade.php:402` `.sticky-sidebar`) — pola umum BBC/Kompas agar sidebar (ad, related) selalu terlihat saat scroll panjang.
- **Breadcrumb** di show page (line 67-75) — membantu orientasi.
- **Share buttons** 3 platform + copy link — sudah cukup untuk kebutuhan organisasi pelajar.
- **Komentar berjenjang** dengan reply — fitur yang bahkan beberapa portal kecil tidak punya.

### A2. Friksi UX yang ditemukan

1. **Tag tidak bisa diklik di mana pun** (index sidebar line 450-454, show page line 158-163, 461-465)
   - Semua tag dirender sebagai `<span>`, bukan `<a>`. Pembaca yang tertarik topik "#LPJ" tidak bisa "explore more" — dead-end UX.
   - **Standar pembanding:** Di Kompas/Detik, klik tag → halaman daftar artikel dengan tag tersebut. Ini salah satu mekanisme discovery utama.

2. **Kategori sidebar di index hanya anchor scroll** (`href="#{{ $kat->slug }}"`, line 428)
   - Klik "Dakwah" di sidebar hanya scroll ke section yang sama di halaman index — bukan halaman khusus kategori dengan SEMUA berita kategori itu + pagination.
   - Jika kategori punya 50 artikel, user hanya melihat 4 di section tersebut tanpa cara melihat sisanya.
   - **Standar pembanding:** Setiap kategori punya landing page sendiri (`/indeks/news`, `/tag/...`).

3. **"Lihat Semua →" pada section kategori tidak berfungsi** (index line 215-218)
   - `href="#"` — link kosong/placeholder. User klik tapi tidak terjadi apa-apa atau halaman scroll ke atas.
   - Ini adalah **broken affordance** — UX paling fatal karena terlihat seperti tombol tapi tidak bekerja.

4. **Pencarian tanpa feedback saat hasil kosong khusus search**
   - Search box mengirim `q` ke index, tapi hasil kosong ditampilkan dengan pesan generik "Belum Ada Berita" (line 345) — tidak membedakan "belum ada berita sama sekali" vs "tidak ada hasil untuk pencarian Anda". User bisa bingung apakah pencarian benar-benar berjalan.
   - **Standar pembanding:** Kompas/Detik menampilkan "Hasil pencarian untuk '...': 0 ditemukan" + saran kata kunci lain.

5. **Tidak ada indikator "artikel baru dibaca" / breadcrumb di index**
   - Index page tidak punya breadcrumb sama sekali (langsung loncat ke ticker). Minor, tapi show page punya — inkonsistensi kecil antar halaman.

6. **Reply komentar: form tersembunyi via `classList.toggle`** (show.blade.php line 282-289)
   - Bekerja, tapi tidak ada animasi/transisi — terasa "kasar" dibanding standar modern (smooth expand). Juga form reply tidak auto-focus ke textarea saat dibuka, sehingga user harus klik manual lagi.

7. **Tidak ada "scroll to comment" dari notifikasi/CTA**
   - Setelah submit komentar, redirect back — apakah scroll otomatis ke section komentar (`#komentar`)? Form action tidak menyertakan anchor (`route('berita.komentar.store', ...)` tanpa `#komentar`), sehingga setelah submit user kembali ke atas halaman dan harus scroll manual untuk melihat komentar mereka / flash message.

8. **Related articles & berita per kategori pakai placeholder generik berbeda-beda**
   - `placehold.co/800x600`, `600x400`, `480x300`, `160x120`, `320x240` — banyak variasi ukuran placeholder eksternal. Selain dependensi ke layanan luar (jika offline/down, gambar broken), juga tidak konsisten secara visual.
   - **Saran arah:** Satu placeholder lokal (asset bawaan) dengan beberapa ukuran preset, bukan API eksternal.

9. **Loading state tidak ada untuk pagination / search**
   - Klik pagination atau search — full page reload tanpa indikator loading. Untuk koneksi lambat (target: pelajar di pedesaan Kediri), ini terasa "macet" tanpa feedback.

10. **Ad space placeholder terlihat di production-ready state**
    - "Space Iklan 300x250" dengan border dashed (index line 460-468, show line 405-413, 471-479) — jika ini tampil ke publik sebelum iklan terisi, terlihat tidak profesional/belum jadi. Perlu fallback konten (misal: promo internal organisasi) saat slot kosong.

### A3. Perbandingan UX Publik vs Standar

| Elemen UX | Detik/Kompas/BBC | DASI Pelajar | Status |
|---|---|---|---|
| Tag → halaman tag | ✅ | ❌ (span statis) | Gap |
| Kategori → halaman kategori + pagination | ✅ | ❌ (anchor scroll) | Gap |
| "Lihat Semua" berfungsi | ✅ | ❌ (`href="#"`) | **Broken** |
| Search dengan feedback hasil | ✅ | ⚠️ Parsial | Gap |
| Smooth reply/comment interaction | ✅ | ⚠️ Instan tanpa transisi | Minor |
| Dark mode | Bervariasi | ✅ | OK |
| Sticky sidebar | ✅ | ✅ | OK |
| Breadcrumb konsisten semua halaman | ✅ | ⚠️ Hanya di show | Minor |
| Placeholder gambar konsisten/lokal | ✅ | ❌ (eksternal, beragam) | Minor |

---

## B. UX SISI ADMIN (Dashboard Manajemen Berita)

### B1. Hal yang sudah baik
- **Stats cards** (Total/Published/Draft/Arsip) di atas — admin langsung dapat overview tanpa harus filter manual.
- **Filter kombinasi** (judul + status + kategori) dengan tombol Reset kontekstual — pola umum admin panel modern (mirip WordPress Posts list).
- **Layout form create/edit 2-kolom** (konten kiri besar, metadata kanan) — ini **persis pola WordPress Gutenberg/Ghost editor** dan juga mirip backend Kompas/Detik (split antara editor utama dan "publish box").
- **Live image preview** sebelum upload (Alpine `imagePreview()`).
- **Tag input UX**: kombinasi chip-pilih-dari-existing + tambah-baru via Enter/koma — ini UX modern, lebih baik dari sekadar input teks biasa.
- **TinyMCE dengan upload gambar inline** — setara editor WYSIWYG newsroom standar.
- **Empty state yang membantu** (index line 230-259) — pesan berbeda untuk "belum ada berita" vs "tidak ada hasil filter", dengan CTA yang sesuai.
- **Konfirmasi delete** via `confirm()` — basic tapi mencegah klik tidak sengaja.

### B2. Friksi & Gap UX Admin

1. **Tidak ada preview "Lihat sebagai pembaca" sebelum publish**
   - Admin baru bisa cek tampilan setelah klik "Simpan Berita" lalu buka tab baru "Lihat di Website" (hanya muncul jika status published, edit.blade.php line 21-30). Tidak ada **draft preview** — padahal di WordPress/Kompas CMS, preview tersedia bahkan untuk draft.
   - **Dampak:** Admin harus publish dulu untuk tahu tampilan akhir, atau menebak-nebak.

2. **Tidak ada auto-save / draft recovery**
   - Form panjang (judul, ringkasan, konten TinyMCE, tags, thumbnail) — jika browser crash/koneksi putus sebelum submit, semua hilang.
   - **Standar pembanding:** WordPress auto-save setiap beberapa menit + "revisi tersimpan".

3. **Tidak ada word count / character count visual untuk konten**
   - TinyMCE punya plugin `wordcount` (sudah di-load, line 296/313: `plugins: '...wordcount...'`) tapi **tidak ditampilkan di UI** — tidak ada elemen yang menunjukkan jumlah kata. Padahal plugin sudah aktif, hanya tidak displayed.
   - **Dampak:** Admin tidak tahu estimasi panjang artikel / reading time saat menulis.

4. **Validasi client-side minim — semua divalidasi server-side via reload**
   - Submit form besar (dengan upload gambar) lalu error validasi → halaman reload, TinyMCE content kembali ke `old('konten')`. Tidak ada indikasi visual real-time (misal: counter ringkasan "320/500 karakter" yang update live).
   - Untuk `ringkasan` (textarea maxlength 500, create.blade line 55) — tidak ada live character counter, padahal `maxlength` HTML attribute sudah ada (mudah ditambah counter JS).

5. **Tidak ada bulk actions di list berita**
   - Admin tidak bisa pilih multiple berita lalu "Ubah status ke Arsip" / "Hapus banyak sekaligus". Untuk arsip akhir tahun atau bersih-bersih draft lama, ini akan sangat membantu.
   - **Standar pembanding:** WordPress Posts list punya bulk actions (checkbox + dropdown action).

6. **Slug tidak ditampilkan/tidak bisa diedit**
   - Slug di-generate otomatis (`{slug-random(5)}`) tanpa ditampilkan ke admin di form create/edit. Admin tidak tahu URL final artikel sebelum publish, dan tidak bisa custom slug untuk SEO (mis. menghindari random suffix yang kurang rapi).
   - **Standar pembanding:** WordPress/Kompas CMS menampilkan & mengizinkan edit "permalink" di bawah judul.

7. **Tidak ada riwayat/log perubahan (revision history)**
   - Jika 2 admin (misal Wasek + Koordinator LPP) edit artikel yang sama, tidak ada cara melihat siapa mengubah apa dan kapan, atau rollback ke versi sebelumnya.
   - Relevan karena di DASI banyak role berbagi akses dashboard yang sama (per CLAUDE.md, role departemen berbagi dashboard).

8. **Form create/edit sangat panjang dalam satu halaman tanpa tab/step**
   - Semua section (Judul, Ringkasan, Konten, Publikasi, Gambar, Tags) tampil sekaligus dalam scroll panjang. Untuk mobile, kolom kanan (Publikasi/Gambar/Tags) jatuh ke bawah — admin harus scroll jauh melewati editor TinyMCE (yang `min_height: 450`) untuk sampai ke tombol "Simpan".
   - **Dampak mobile:** Tombol submit ada di card "Publikasi" yang letaknya di kolom kanan — di mobile (1 kolom), itu artinya scroll lewat seluruh konten + ringkasan + editor dulu. Tidak ada sticky "Simpan" button.

9. **Status "Archived" ada di model tapi tidak ada workflow jelas kapan dipakai**
   - Dropdown status punya 3 opsi (Draft/Published/Archived) tapi tidak ada penjelasan/help text kapan harus pilih Archived vs Draft. Admin baru bisa bingung perbedaannya.

10. **Tidak ada indikasi "artikel ini sedang di-edit admin lain"**
    - Karena banyak role berbagi dashboard (sesuai struktur role di CLAUDE.md — Waka/Wasek/Wabend/Koordinator satu departemen sama), risiko **dua admin edit artikel yang sama bersamaan** dan saling overwrite cukup nyata, tanpa warning apa pun.

11. **Thumbnail requirement tidak dipaksa tapi tidak ada warning**
    - Thumbnail optional (validasi `nullable` kemungkinan, sesuai laporan sebelumnya) — jika admin publish tanpa thumbnail, artikel tampil dengan placeholder generik `placehold.co` di publik. Tidak ada warning "artikel tanpa gambar akan terlihat kurang menarik" saat submit.

12. **Tidak ada shortcut keyboard untuk publish (Ctrl+S / Ctrl+Enter)**
    - Minor, tapi banyak editor modern (Ghost, Notion-style CMS) mendukung save cepat via keyboard.

### B3. Perbandingan UX Admin vs Standar Newsroom CMS

| Elemen UX Admin | WordPress/Kompas-tier CMS | DASI Pelajar | Status |
|---|---|---|---|
| Stats overview | ✅ | ✅ | OK |
| Filter & search list | ✅ | ✅ | OK |
| 2-kolom editor (konten + publish box) | ✅ | ✅ | OK |
| Tag chip selector | ✅ | ✅ | OK |
| Live image preview | ✅ | ✅ | OK |
| Draft preview (lihat sebelum publish) | ✅ | ❌ | Gap |
| Auto-save / draft recovery | ✅ | ❌ | Gap |
| Word count / reading time saat menulis | ✅ | ⚠️ Plugin aktif, tidak ditampilkan | Gap kecil |
| Live character counter (ringkasan) | ✅ | ❌ | Gap kecil |
| Bulk actions | ✅ | ❌ | Gap |
| Slug visible & editable | ✅ | ❌ | Gap |
| Revision history | ✅ | ❌ | Gap |
| Sticky publish button (mobile) | ⚠️ Bervariasi | ❌ | Minor |
| Lock/warning saat edit bersamaan | ⚠️ Bervariasi (Kompas ya) | ❌ | Gap (relevan krn shared dashboard) |
| Empty state membantu | ✅ | ✅ | OK |

---

## C. PRIORITAS PERBAIKAN UX (Gabungan Publik + Admin)

### 🔴 Kritis — Broken/Misleading UX
1. **Fix link "Lihat Semua →" yang `href="#"`** (index.blade.php line 215-218) — saat ini benar-benar broken, harus diarahkan ke halaman kategori (terkait dengan Prioritas SEO #12 di Bagian 1: butuh halaman kategori dulu).
2. **Tag jadi clickable** ke halaman filter tag — dead-end UX di banyak tempat (index sidebar, show page 2x).

### 🟠 Tinggi — Friksi Admin yang Sering Dipakai
3. **Tampilkan word count + reading time estimate** saat menulis (plugin sudah aktif, tinggal display).
4. **Live character counter untuk ringkasan** (500 char) — quick win, hanya JS.
5. **Sticky "Simpan" button** di mobile form create/edit — agar admin tidak perlu scroll panjang.
6. **Tampilkan slug** (read-only minimal) di form, agar admin tahu URL final.

### 🟡 Menengah — Engagement & Navigasi Publik
7. **Halaman kategori dengan pagination** (terhubung ke fix #1).
8. **Preview draft** sebelum publish — link "Preview" yang membuka show page dalam mode khusus (bypass `status='Published'` filter untuk pemilik/admin).
9. **Feedback pencarian** ("0 hasil untuk 'xxx'") + saran.
10. **Smooth transition untuk reply form** + auto-focus textarea.

### 🟢 Rendah — Hardening Proses Editorial
11. **Bulk actions** (ubah status massal, hapus massal) di dashboard list.
12. **Auto-save draft** (localStorage minimal, atau interval AJAX save).
13. **Warning edit bersamaan** — minimal: tampilkan "terakhir diedit oleh X, Y menit lalu" di form edit (pakai `updated_at` + relasi user terakhir, jika field tersedia).
14. **Placeholder gambar lokal** seragam, bukan `placehold.co` eksternal.
15. **Ad space fallback** konten saat slot iklan kosong.

---

# BAGIAN 3 — TEMUAN TAMBAHAN UNTUK DISKUSI (Di Luar Lingkup Berita)

Bagian ini dibuat setelah membaca dokumentasi project di Obsidian (`12-Status.md`, `13-Backlog.md`, `11-Decisions.md`, `14-Debug-Log.md`) untuk memastikan tidak duplikasi dengan yang sudah tercatat. Fokus: hal-hal yang **belum ada di backlog** atau **berdampak ke pengalaman publik secara keseluruhan**, bukan hanya modul berita.

> Catatan: beberapa temuan di Bagian 1 & 2 (filter kategori berita, dark mode publik persisten) **sudah tercatat** di `13-Backlog.md` — tidak diulang di sini kecuali ada nuansa tambahan.

---

## D. Isu Lintas-Halaman / Infrastruktur yang Berdampak ke Publik

### D1. `APP_DEBUG=true` & `APP_ENV=local` di `.env.example`
- Default `.env.example` masih `APP_ENV=local`, `APP_DEBUG=true`, `LOG_LEVEL=debug`.
- **Dampak jika ke production tanpa diubah:** Setiap error Laravel menampilkan **stack trace lengkap** ke publik — bisa membocorkan path server, query SQL, bahkan `.env` variable di beberapa kasus (Whoops debug page).
- **Tidak ada di backlog Obsidian** — perlu ditambahkan sebagai checklist go-live wajib (`APP_ENV=production`, `APP_DEBUG=false`).
- Relevan dengan target Cloudflare Tunnel (akses publik dari rumah) di CLAUDE.md — kebocoran ini langsung visible ke internet.

### D2. `APP_LOCALE=en` / `APP_FAKER_LOCALE=en_US` padahal seluruh UI Bahasa Indonesia
- Default Laravel locale masih English. Validasi error bawaan Laravel (`required`, `email`, dll — termasuk di form komentar berita dan form kegiatan) bisa muncul dalam **bahasa Inggris** jika belum ada file lang `id` yang lengkap atau `APP_LOCALE` belum di-set ke `id`.
- **Cek cepat untuk diskusi:** apakah `resources/lang/id` atau `lang/id` sudah ada dan lengkap? Jika tidak, pesan error seperti "The nama field is required." bisa muncul campur dengan UI Bahasa Indonesia — terasa tidak profesional untuk target audiens pelajar.

### D3. File `test-lpj.pdf` di `public/`
- Ada file `public/test-lpj.pdf` — sepertinya file testing yang tertinggal di folder publik (accessible langsung via URL).
- **Dampak:** Minor, tapi termasuk "sampah development" yang terindex/accessible publik. Perlu dicek isinya — jika berisi data dummy LPJ yang menyerupai data asli, bisa membingungkan atau (jika tidak disengaja berisi data nyata) jadi kebocoran data.
- **Rekomendasi:** Hapus jika memang file testing, atau pindah ke `storage/` jika perlu untuk dev.

### D4. File favicon ganda (`favicon.ico`, `favicon.png`, `faviconn.png`)
- Tiga file favicon di `public/` — `faviconn.png` terlihat seperti typo/file duplikat yang tertinggal.
- Minor cleanup, tapi konsisten dengan pola "file lama tidak dihapus" yang juga disebut di `CLAUDE.md` ("JANGAN hapus file yang ada — tambahkan saja") — kemungkinan inilah sumber akumulasi file usang. Worth didiskusikan apakah aturan ini perlu pengecualian untuk file statis/asset yang jelas typo.

---

## E. Isu yang Relevan dengan Visi "Mengendalikan Pergerakan Organisasi" (dari `01-Overview.md`)

Visi project: *"menertibkan dan mengendalikan pergerakan organisasi lewat sistem"* — bukan sekadar tampilan. Beberapa gap berikut relevan dengan visi ini tapi belum tercatat:

### E1. Tidak ada audit trail untuk konten publik (berita, halaman, komentar)
- Backlog sudah punya "Soft delete model kritis" (Kader, ProgramKerja, Pengurus) tapi **Berita & KomentarBerita tidak termasuk**.
- Untuk organisasi yang "menertibkan pergerakan" — siapa publish/edit/hapus berita kapan adalah jejak akuntabilitas penting, terutama karena banyak role berbagi 1 dashboard (LPP, Wasek, dll bisa semua punya akses CRUD berita).
- **Untuk diskusi:** apakah perlu `activity_log` sederhana (siapa-apa-kapan) khusus untuk konten publik, sebelum full revision history?

### E2. Moderasi komentar tidak punya notifikasi
- `KomentarBerita.is_approved` default false — admin harus tahu ada komentar baru menunggu approval. Saat ini **tidak ada cara admin tahu** kecuali membuka tiap artikel manual.
- **Untuk diskusi:** badge counter "X komentar pending" di sidebar dashboard (mirip pattern badge proker pending yang sudah direncanakan di `13-Backlog.md` untuk Ketua) — bisa pakai pattern yang sama, cukup tambah query count.

### E3. Konsistensi role LPP vs role lain dalam CRUD berita
- CLAUDE.md menyebutkan `lmb_lpp` "juga kelola berita publik" — tapi dari `BeritaAdminController` tidak terlihat ada **pembatasan role** sama sekali (catatan di Bagian 1: "Tidak ada middleware role/permission check yang terlihat").
- **Pertanyaan untuk didiskusikan:** apakah semua role yang bisa masuk dashboard otomatis bisa CRUD semua berita (termasuk berita departemen lain)? Jika iya, ini bertentangan dengan prinsip "menertibkan" — departemen Dakwah seharusnya tidak bisa menghapus berita yang ditulis LPP/Departemen lain.
- Ini berkaitan dengan **ADR-002** (RBAC string role) — mungkin perlu kolom `user_id` (sudah ada) dipakai untuk **scope edit/delete**: penulis asli + LPP + admin saja yang bisa edit/hapus, role lain hanya bisa lihat draft sendiri.

---

## F. Hal Positif yang Perlu Diapresiasi (Konteks untuk Diskusi Prioritas)

Agar diskusi prioritas berimbang — beberapa hal sudah **di atas rata-rata** untuk project skala organisasi pelajar:

- **ADR-009** (load semua berita sekali, group di PHP) adalah trade-off yang tepat untuk skala data saat ini (ratusan artikel) — tidak perlu "diperbaiki" sampai data benar-benar besar (>10rb row sudah diantisipasi di ADR).
- **Index database sudah ditambahkan** (ADR-010) — tinggal jalankan migrate (item ini sudah tercatat sebagai action item di `12-Status.md` line 23).
- Sistem cache `Cache::remember()` dengan file driver sebagai interim (ADR-008) sudah pola yang benar — upgrade ke Redis nanti tidak perlu ubah kode.
- Dark mode, design system CSS variables, dan tag chip UI di admin sudah di atas standar rata-rata CMS internal organisasi sejenis.

---

## G. Keputusan Hasil Diskusi (2026-06-15)

| # | Topik | Keputusan |
|---|---|---|
| 1 | Go-Live Checklist | Dibuat sebagai Bagian H di bawah |
| 2 | Role scoping CRUD berita | **Hanya `lmb_lpp` yang kelola berita.** Admin akan login menggunakan akun LPP, bukan akun `admin` umum. → Implikasi: route `dashboard/berita` & `dashboard/kategori` perlu middleware `CheckRole:lmb_lpp` (+ `admin` untuk superuser/override, jika diperlukan) |
| 3 | Cleanup file (D3, D4) | Ikuti rekomendasi — lihat sub-bagian G1 |
| 4 | Activity log konten publik (E1) | **Masuk Phase 2** — dijadwalkan setelah item Tier 1/2 performa selesai |

### G1. Rekomendasi Cleanup File (untuk item #3)

| File | Rekomendasi | Alasan |
|---|---|---|
| `public/test-lpj.pdf` | **Hapus** (setelah konfirmasi bukan data nyata) | File testing tertinggal, accessible publik via URL langsung |
| `public/faviconn.png` | **Hapus** | Typo duplikat dari `favicon.png`, tidak direferensikan di kode manapun (cek dulu dengan grep sebelum hapus) |
| `public/favicon.ico` vs `favicon.png` | **Pertahankan keduanya** | `.ico` untuk browser lama/tab, `.png` untuk modern — keduanya valid, bukan duplikat |

> Catatan soal aturan "JANGAN hapus file" di CLAUDE.md: aturan tersebut ditujukan untuk **kode/fitur** (controller, view, model) agar tidak kehilangan pekerjaan in-progress. File statis di `public/` yang jelas typo/testing (bukan kode fungsional) aman dihapus — tapi tetap **grep referensi dulu** sebelum delete untuk memastikan tidak dipakai di Blade manapun.

### G2. Implementasi Role Scoping LPP (untuk item #2) — Catatan Teknis untuk Sesi Berikutnya

Temuan teknis terkait keputusan #2 (perlu konfirmasi eksplisit sebelum eksekusi sesuai CLAUDE.md):

- **Saat ini** (`routes/web.php:47-49`): route `dashboard/berita/*` dan `dashboard/kategori/*` hanya dibungkus middleware `auth` — **siapapun yang login ke dashboard bisa CRUD semua berita**, tanpa cek role sama sekali.
- **Middleware `CheckRole`** (`app/Http/Middleware/CheckRole.php`) sudah ada dan generik (`in_array($user->role, $roles)`) — tinggal pasang ke route, contoh: `Route::middleware('role:lmb_lpp,admin')->group(...)`.
- **Yang perlu didiskusikan saat eksekusi:**
  - Apakah `admin` (Ketua PC) tetap punya akses penuh sebagai override/superuser, atau benar-benar eksklusif `lmb_lpp`?
  - Apakah perlu update `DashboardController` agar role lain (selain `lmb_lpp`/`admin`) tidak melihat menu "Berita" di sidebar sama sekali (saat ini kemungkinan menu tetap muncul tapi akan 403 jika diklik)?
  - Sidebar dashboard perlu dicek — apakah link ke `dashboard.berita.index` sudah conditional per role, atau tampil untuk semua?

---

# BAGIAN 4 — GO-LIVE CHECKLIST

Checklist ini untuk memastikan aplikasi siap diakses publik via Cloudflare Tunnel (sesuai infrastruktur di `CLAUDE.md`). Dikelompokkan per kategori, dengan referensi ke temuan terkait di laporan ini.

## H1. Environment & Konfigurasi (KRITIS — Keamanan)

- [ ] `APP_ENV=production` (bukan `local`)
- [ ] `APP_DEBUG=false` — **wajib**, lihat temuan **D1**. Jika lupa, stack trace error (path server, query SQL) tampil ke publik
- [ ] `APP_URL` di-set ke domain final (bukan `http://localhost`)
- [ ] `LOG_LEVEL` diturunkan dari `debug` ke `error` atau `warning` di production
- [ ] `APP_LOCALE=id` + `APP_FALLBACK_LOCALE=id` — lihat temuan **D2**, cek juga apakah file `lang/id/validation.php` (atau setara) sudah lengkap agar pesan error form (komentar, form kegiatan) konsisten Bahasa Indonesia
- [ ] `APP_KEY` di-generate ulang untuk production (`php artisan key:generate`) — jangan reuse key dari dev
- [ ] Cek `.gitignore` memastikan `.env` tidak ter-commit ke repo

## H2. Database & Storage

- [ ] Jalankan `php artisan migrate` — termasuk migration index `2026_06_01_000001_add_indexes_to_beritas_table` yang sudah dibuat tapi belum dijalankan (ref: `12-Status.md` line 23)
- [ ] `DB_CONNECTION` production pakai MariaDB (bukan `sqlite` default dev)
- [ ] Backup awal database sebelum go-live (sesuai strategi backup di CLAUDE.md — `spatie/laravel-backup`)
- [ ] Konfirmasi `FILESYSTEM_DISK` — MinIO masih pending setup (ADR-005, status "implementasi pending"). Jika go-live sebelum MinIO siap, pastikan disk `local`/`public` punya permission & disk space cukup, dan rencanakan migrasi file ke MinIO setelahnya

## H3. SEO & Discoverability (ref Bagian 1)

- [ ] `public/robots.txt` — tambahkan `Sitemap:` directive + disallow `/dashboard` (temuan #4, Bagian 1)
- [ ] Sitemap.xml dasar (minimal: halaman statis + daftar berita published) — temuan #3
- [ ] Meta description di halaman index & show berita — temuan #1
- [ ] OG tags lengkap + Twitter Card di show berita — temuan #6
- [ ] Canonical URL — temuan #5

> Catatan: H3 bisa jalan paralel/setelah go-live (tidak blocking), tapi `robots.txt` sebaiknya benar **sejak hari pertama** agar Google tidak meng-index halaman draft/dashboard sejak awal.

## H4. Bug & UX Kritis (ref Bagian 2)

- [ ] Fix link **"Lihat Semua →"** yang `href="#"` di `berita/index.blade.php:215-218` — broken link tidak boleh tayang ke publik
- [ ] Pasang middleware role `lmb_lpp` (+ `admin` jika disepakati) ke route `dashboard/berita/*` dan `dashboard/kategori/*` — sesuai keputusan G/#2, sebelum LPP mulai dipakai sebagai akun produksi utama untuk berita

## H5. File & Asset Cleanup (ref G1)

- [ ] Hapus `public/test-lpj.pdf` (setelah konfirmasi isi bukan data sensitif/nyata)
- [ ] Hapus `public/faviconn.png` (cek dulu tidak ada referensi, lalu hapus)
- [ ] Audit folder `public/` untuk file dev/testing lain yang mungkin tertinggal (grep nama-nama mencurigakan seperti `test*`, `dummy*`, `*-old.*`)

## H6. Performa Dasar (ref `12-Status.md` Tier 1, sudah selesai — verifikasi saja)

- [ ] Verifikasi cache `PengaturanWeb` aktif (sudah dikerjakan, Tier 1)
- [ ] Verifikasi N+1 fix `indexBerita()` aktif (sudah dikerjakan, Tier 1)
- [ ] `loading="lazy"` pada gambar index/show berita — temuan Bagian 1 #7 (belum dikerjakan, low-risk quick win sebelum go-live)

## H7. Smoke Test Sebelum Publish ke Domain

- [ ] Buka `/berita` — pastikan tidak ada error 500/N+1 lambat dengan data riil
- [ ] Buka `/berita/{slug}` — cek share buttons, komentar, related articles tampil benar
- [ ] Submit komentar dari sisi publik — cek masuk ke moderasi (`is_approved=false`) dan tidak langsung tampil
- [ ] Login sebagai akun LPP — cek hanya menu Berita & Kategori yang relevan accessible (setelah H4 role scoping selesai)
- [ ] Akses `/dashboard/berita` dengan akun **non-LPP** — pastikan 403 (setelah H4)
- [ ] Cek halaman 404 & 500 custom (jika `APP_DEBUG=false`, Laravel pakai halaman error generik — pastikan tidak nampak "raw" / kosong)
- [ ] Test dari perangkat mobile asli (bukan hanya devtools) — terutama form admin (ref Bagian 2 B2 #8, kolom kanan jatuh ke bawah)

---

*Catatan: Laporan ini bersifat analisis temuan & checklist untuk diskusi/eksekusi bertahap. Setiap perubahan pada struktur database (migration), role/permission, atau storage tetap memerlukan konfirmasi eksplisit sesuai aturan di `CLAUDE.md` sebelum dieksekusi.*
