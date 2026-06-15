# Debugging Guide — DASI Pelajar
# Merge dari: SKILL-debugging.md + SKILL-minio-storage.md

---

## Urutan Diagnosa (Selalu Ikuti Ini)
1. Baca error message sampai habis
2. Cek `storage/logs/laravel.log`
3. Isolasi — jangan ubah banyak hal sekaligus
4. Satu perubahan = satu test
5. Catat bug baru di ERRORS.md

---

## Error Umum & Solusi

### "Undefined variable" di Blade
```
Controller tidak passing variabel → cek return view('...', compact('var'))
```

### "Call to a member function on null"
```
Relasi tidak di-load → tambah ->with('relasi') di query
Atau data null → gunakan $model->relasi?->field
```

### 419 Page Expired
```
SESSION_DOMAIN diisi 'null' (literal) → kosongkan (string kosong)
SESSION_DRIVER=file — jangan ganti ke cookie
```

### File upload tidak muncul / error
```
Cek FILESYSTEM_DISK di .env (dev: public, prod: s3)
Cek AWS_ENDPOINT=http://minio:9000 (bukan localhost di dalam Docker)
Cek bucket sudah ada di MinIO Console
Test: php artisan tinker → Storage::disk('s3')->put('test.txt', 'hello')
```

### Cache data lama masih muncul
```bash
php artisan cache:clear
# atau spesifik:
# php artisan tinker → Cache::forget('pengaturan_web')
```

### Route tidak ditemukan (404)
```bash
php artisan route:list | grep nama-route
# Cek middleware role sudah diizinkan?
# Cek prefix route group sudah benar?
```

### QR Code tidak muncul
```
Cek Cache::remember("qr_absensi_{$id}") — jika cache corrupt, forget dulu
Cek chillerlan/php-qrcode v5: QRCode::OUTPUT_MARKUP_SVG (bukan OUTPUT_MARKUP_SVG dari v4)
```

### QR tidak terbaca di browser mobile
```
Halaman scan harus diakses via HTTPS (Cloudflare tunnel)
Kamera browser hanya jalan di HTTPS atau localhost
Cek izin kamera di browser mobile
```

### MinIO — connection refused
```bash
docker ps | grep minio              # Cek container jalan
# Cek AWS_ENDPOINT=http://minio:9000 (bukan localhost dalam Docker)
# Test:
php artisan tinker
>>> Storage::disk('s3')->put('test.txt', 'hello')
>>> Storage::disk('s3')->url('test.txt')
```

### N+1 queries di telescope/debugbar
```
Identifikasi model dengan relasi yang di-load di loop
Tambah ->with(['relasi1', 'relasi2']) di query utama
Untuk ProgramKerja: eager load kepanitiaans + absensis sebelum view
```

---

## Debug Commands

```bash
# Log real-time
tail -f storage/logs/laravel.log

# Cek semua route
php artisan route:list
php artisan route:list --path=dashboard/departemen

# Clear semua cache
php artisan cache:clear && php artisan config:clear && php artisan view:clear

# Test query via tinker
php artisan tinker
>>> ProgramKerja::with('departemen')->find('proker001')
>>> Cache::get('pengaturan_web')
>>> Cache::forget('pengurus_cabang')

# Cek container Docker
docker ps
docker logs dasi-minio
```

---

## MinIO — Setup Docker

```yaml
# docker-compose.yml
minio:
  image: minio/minio:latest
  container_name: dasi-minio
  ports:
    - "9000:9000"   # S3 API
    - "9001:9001"   # Web Console
  environment:
    MINIO_ROOT_USER: ${MINIO_ROOT_USER}
    MINIO_ROOT_PASSWORD: ${MINIO_ROOT_PASSWORD}
  volumes:
    - ./minio-data:/data
  command: server /data --console-address ":9001"
  restart: unless-stopped
```

### Setup Awal MinIO (Lakukan Sekali)
1. Jalankan container MinIO
2. Buka console: `http://[server-ip]:9001`
3. Login dengan MINIO_ROOT_USER + MINIO_ROOT_PASSWORD
4. Buat bucket `dasi-public` → set policy: **Public**
5. Buat bucket `dasi-private` → biarkan **Private** (signed URL)
6. Buat Access Key untuk Laravel → simpan di `.env`

### .env MinIO
```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your-minio-access-key
AWS_SECRET_ACCESS_KEY=your-minio-secret-key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=dasi-public
AWS_ENDPOINT=http://minio:9000
AWS_USE_PATH_STYLE_ENDPOINT=true
```

### Struktur Bucket
```
dasi-public/          ← akses URL langsung
  avatars/            foto profil kader
  berita/             foto artikel
  slider/             hero slider

dasi-private/         ← signed URL 5 menit
  surat/              PDF surat masuk/keluar
  lpj/                LPJ proker
  notulensi/          notulensi rapat
  sk/                 Surat Keputusan
  layanan/            file download center
  uploads/            file upload peserta form
```

---

## Checklist Sebelum Lapor Bug ke ERRORS.md

- [ ] Sudah baca full error message + laravel.log
- [ ] Sudah isolasi ke satu komponen
- [ ] Sudah test satu perubahan
- [ ] Bug baru belum ada di ERRORS.md
