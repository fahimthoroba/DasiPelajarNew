# Routes Ringkasan — DASI Pelajar
# Sync dari: Obsidian 05-API-Endpoints.md
# Semua route ada di routes/web.php — tidak ada REST API terpisah

## Middleware Stack
```
web → auth → role:[...]
CheckRole: in_array($user->role, $allowedRoles)
```

---

## Public Routes (tanpa auth)

```
GET  /                        HomeController@index
GET  /berita                  HomeController@indexBerita
GET  /berita/{slug}           HomeController@showBerita
POST /berita/{slug}/komentar  HomeController@storeKomentar
GET  /struktur-organisasi     HomeController@struktur
GET  /profil                  HomeController@profil
GET  /agenda                  HomeController@agenda
GET  /layanan                 LayananController@index
GET  /layanan/{id}/download   LayananController@download
GET  /form/{slug}             FormPendaftaranController@show
POST /form/{slug}             FormPendaftaranController@submit
GET  /event/{token}           EventController@show    ← legacy
POST /event/{token}           EventController@store   ← legacy
GET  /api/check-nia           EventController@checkNia  ← JSON
GET  /absensi/scan/{kode}     AbsensiController@scan  ← mobile, tanpa auth
```

---

## Auth Routes

```
GET  /login   AuthController@index
POST /login   AuthController@authenticate
POST /logout  AuthController@logout
```

---

## Dashboard Routes (auth required)

### Core
```
GET  /dashboard               DashboardController@index  ← router ke view per role
GET  /dashboard/pengaturan    PengaturanWebAdminController
PUT  /dashboard/pengaturan    PengaturanWebAdminController@update
```

### Berita & Media (lmb_lpp, admin)
```
CRUD /dashboard/berita
POST /dashboard/berita/upload-image         ← JSON, upload TinyMCE
CRUD /dashboard/kategori
POST /dashboard/kategori/quick-store        ← JSON AJAX
GET  /dashboard/media-visual
CRUD /dashboard/media-visual/slider/*
POST /dashboard/media-visual/banner/{posisi}
DEL  /dashboard/media-visual/banner/{posisi}
```

### Sekretariat (sekretaris, admin)
```
CRUD /dashboard/sekretariat/surat-masuk
CRUD /dashboard/sekretariat/surat-keluar
CRUD /dashboard/sekretariat/kader
CRUD /dashboard/sekretariat/inventaris
CRUD /dashboard/sekretariat/proker
POST /dashboard/sekretariat/proker/{id}/verifikasi  ← terima/tolak LPJ
CRUD /dashboard/sekretariat/pengurus
POST /dashboard/sekretariat/pengurus/bulk-store
CRUD /dashboard/sekretariat/absensi
CRUD /dashboard/sekretariat/sk
CRUD /dashboard/sekretariat/organisasi
GET  /dashboard/sekretariat/master-data
```

### Departemen (semua dep_*, lmb_*, bdn_*, departemen)
```
GET  /dashboard/departemen
GET  /dashboard/departemen/proker
GET  /dashboard/departemen/proker/{id}
PUT  /dashboard/departemen/proker/{id}/status
GET  /dashboard/departemen/proker/{id}/panitia
POST /dashboard/departemen/proker/{id}/panitia/bulk
DEL  /dashboard/departemen/proker/{id}/panitia/{pid}
GET  /dashboard/departemen/proker/{id}/agenda
POST /dashboard/departemen/proker/{id}/agenda
POST /dashboard/departemen/proker/{id}/agenda/{aid}/close
POST /dashboard/departemen/proker/{id}/agenda/{aid}/notulensi
DEL  /dashboard/departemen/proker/{id}/agenda/{aid}
POST /dashboard/departemen/proker/{id}/lpj           ← upload LPJ Step 5
```

### Form Kegiatan Standalone
```
CRUD  /dashboard/form-kegiatan
PATCH /dashboard/form-kegiatan/{id}/toggle
GET   /dashboard/form-kegiatan/{id}/export-excel
GET   /dashboard/form-kegiatan/{id}/download-files
```

### Kaderisasi & Absensi (dep_kaderisasi, pac, admin, sekretaris)
```
GET   /dashboard/kaderisasi/absensi
CRUD  /dashboard/kaderisasi/absensi/{id}
POST  /dashboard/kaderisasi/absensi/{id}/manual
PATCH /dashboard/kaderisasi/absensi/{id}/close
PATCH /dashboard/kaderisasi/absensi/{id}/reopen
GET   /dashboard/kaderisasi/absensi/{id}/attendees   ← JSON polling Alpine.js 5 detik
```

### PAC & Admin
```
CRUD /dashboard/pac/proker
CRUD /dashboard/admin/proker
CRUD /dashboard/admin/users
GET  /dashboard/admin/analisa/*
```

---

## Catatan Penting

- CSRF protection aktif di semua POST/PUT/PATCH/DELETE
- SESSION_DOMAIN harus kosong string (bukan literal 'null') — bisa 419 Page Expired
- Hanya 2 endpoint JSON: /api/check-nia dan /attendees
- File upload sementara local — akan migrasi ke MinIO
