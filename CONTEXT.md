# CONTEXT.md — Working Memory DASI Pelajar
# Baca file ini SETELAH CLAUDE.md.
# Claude Code WAJIB mengisi bagian "HASIL SESI" di akhir setiap sesi.

---

## STATUS TERAKHIR
**Sesi:** 2026-06-01 — Claudian (Performance Tier 1)
**Yang dikerjakan:**
- Cache `PengaturanWeb::first()` TTL 1 jam (6 lokasi di HomeController)
- Fix N+1 `indexBerita()`: load semua berita sekali, group/slice di PHP
- Cache QR SVG per `absensi_id` TTL 24 jam + `Cache::forget` di close/reopen
- Fix `DashboardController`: routing semua dept/lmb/bdn roles via `in_array` (18 roles + alias)
- Migration `2026_06_01_000001_add_indexes_to_beritas_table.php` — 5 indexes

**Pending dari sesi lalu:**
- `php artisan migrate` BELUM dijalankan — indexes belum aktif

---

## TASK AKTIF

**Task-001 — Role Scoping Berita + Badge Komentar Pending**

Dua perubahan dalam satu task:
1. Pasang `CheckRole:lmb_lpp` ke route `dashboard/berita/*` dan `dashboard/kategori/*`
2. Menu Berita di sidebar conditional — hanya muncul untuk role `lmb_lpp`
3. Badge counter komentar pending (`KomentarBerita::where('is_approved', false)->count()`) di menu Berita

**Detail lengkap ada di:** `.claude/context/` tidak perlu dibaca — spec sudah lengkap di sini.

### 1. `routes/web.php`
Cari blok route `dashboard/berita` dan `dashboard/kategori`. Pisahkan ke group middleware baru:

```php
Route::middleware(['auth', 'role:lmb_lpp'])->group(function () {
    Route::resource('dashboard/berita', BeritaAdminController::class);
    Route::post('dashboard/berita/upload-image', [BeritaAdminController::class, 'uploadImage']);
    Route::resource('dashboard/kategori', KategoriAdminController::class);
    Route::post('dashboard/kategori/quick-store', [KategoriAdminController::class, 'quickStore']);
});
```

### 2. Sidebar Dashboard
Grep dulu untuk temukan file sidebar:
```bash
grep -rl "dashboard/berita\|dashboard\.berita" resources/views/
```
Kemungkinan: `resources/views/layouts/dashboard.blade.php`

Tambahkan kondisi dan badge:
```blade
@php
    $komentarPending = 0;
    if (auth()->check() && auth()->user()->role === 'lmb_lpp') {
        $komentarPending = \App\Models\KomentarBerita::where('is_approved', false)->count();
    }
@endphp

{{-- Menu Berita — hanya untuk lmb_lpp --}}
@if(auth()->user()->role === 'lmb_lpp')
<a href="{{ route('berita.index') }}" class="...">
    Berita
    @if($komentarPending > 0)
    <span class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold
                 text-white bg-[#e8463a] rounded-full ml-auto">
        {{ $komentarPending > 99 ? '99+' : $komentarPending }}
    </span>
    @endif
</a>
@endif
```

### Business Rules
- Hanya `lmb_lpp` yang akses CRUD berita/kategori — tidak ada role lain termasuk `admin`
- Role lain akses URL langsung → 403 dari `CheckRole` middleware
- Query badge hanya dijalankan jika role `lmb_lpp` (jangan query untuk semua role)

### Acceptance Criteria
- [ ] `php artisan route:list | grep dashboard/berita` menunjukkan middleware `role:lmb_lpp`
- [ ] Login sebagai `lmb_lpp` → menu Berita tampil di sidebar
- [ ] Login sebagai role lain → menu Berita tidak muncul di sidebar
- [ ] Akses `/dashboard/berita` dengan role non-LPP via URL langsung → 403
- [ ] Ada komentar `is_approved=false` → badge merah muncul. Tidak ada → badge tidak muncul
- [ ] Tidak ada error 500 di halaman dashboard role apapun

---

## JANGAN LUPA (Sesi Ini)

- `CACHE_STORE=file` — Redis belum aktif, jangan assume Redis
- File upload belum ke MinIO — jangan ubah storage logic
- Role `pers` dan `departemen` = alias lama, **jangan hapus**
- Jangan sentuh: `BeritaAdminController`, `KategoriAdminController`, `CheckRole` middleware
- Setelah task selesai: jalankan `php artisan migrate` untuk aktifkan indexes berita (dari sesi lalu)

---

## HASIL SESI 2026-06-15

**Yang dikerjakan:**
- Task-001 selesai: route `dashboard/berita/*` dan `dashboard/kategori/*` (termasuk `upload-image` dan `kategori/quick-store`) dipindah ke group baru `Route::middleware(['auth', 'role:lmb_lpp'])`, dipisah dari group `auth` umum, dengan `['as' => 'dashboard']` dipertahankan agar nama route tetap `dashboard.berita.*` / `dashboard.kategori.*`
- Sidebar `layouts/dashboard.blade.php`: section "Lembaga Pers" sekarang hanya tampil untuk `auth()->user()->role === 'lmb_lpp'` (sebelumnya `admin, pers, lmb_lpp`) — termasuk link Berita, Kategori, Media Visual
- Tambah badge merah jumlah komentar pending (`KomentarBerita::where('is_approved', false)->count()`) di menu Berita, query hanya dijalankan saat role `lmb_lpp` (di dalam `@if` yang sama), cap "99+"
- `php artisan route:list -v` dikonfirmasi: semua route `dashboard/berita` & `dashboard/kategori` punya middleware `Authenticate` + `CheckRole:lmb_lpp`
- `php artisan migrate --force` dijalankan — hasil "Nothing to migrate", migration `2026_06_01_000001_add_indexes_to_beritas_table` sudah Ran (batch 23) dari sesi sebelumnya, 5 index aktif

**File yang diubah:**
- `routes/web.php` — pindah route berita/kategori ke group `role:lmb_lpp` baru di luar group `auth` umum
- `resources/views/layouts/dashboard.blade.php` — conditional sidebar `lmb_lpp` + badge komentar pending

**Masalah ditemukan:**
- Tidak ada

**Next action:**
- Acceptance criteria checklist di atas perlu diverifikasi manual via browser (login sebagai `lmb_lpp` vs role lain) — belum bisa ditest otomatis dari sesi ini
- Role `admin`/`pers` yang sebelumnya bisa lihat menu Lembaga Pers di sidebar sekarang tidak lagi — sesuai ADR-011, tapi pastikan tidak ada akun `admin` yang masih bergantung pada akses ini sebelum go-live
- File cleanup (`public/test-lpj.pdf`, `public/faviconn.png`) dari diskusi sebelumnya masih belum dieksekusi — bisa jadi task selanjutnya
