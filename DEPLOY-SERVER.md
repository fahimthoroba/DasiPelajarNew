# DEPLOY-SERVER.md
# Instruksi untuk Claude Code yang berjalan DI KOMPUTER SERVER (Xubuntu 25.10).
# Baca file ini secara berurutan dan eksekusi sesuai tahapnya.
# Konteks lengkap lebih luas ada di DEPLOY.md (ikut ter-clone di repo ini).

---

## STATUS AWAL YANG WAJIB DIVERIFIKASI DULU (jangan asumsikan)

Sebelum mengeksekusi apapun, jalankan dan baca hasilnya:

```bash
docker compose version
docker --version
docker ps -a
docker network ls
docker compose ls
```

Tujuan: pahami app lama yang sudah jalan di server ini — nama project compose-nya, network apa yang dipakai container `cloudflared` miliknya, dan service apa saja yang sudah eksis. **Jangan stop atau ubah container app lama** kecuali diminta eksplisit.

Cari compose file app lama (biasanya di `/home/$USER/apps/<nama-app-lama>/docker-compose*.yml`) dan baca isinya untuk tahu:
- Nama network yang dipakai `cloudflared` (`docker inspect <container_cloudflared> --format '{{json .NetworkSettings.Networks}}'`)
- Port yang sudah dipakai host (supaya DASI Pelajar tidak bentrok port)

Laporkan temuan ini ke user sebelum lanjut ke Part 1, supaya keputusan jaringan (lihat DEPLOY.md bagian "Catatan Jaringan Penting") bisa diambil dengan data nyata.

---

## PART 1 — Persiapan Server

Jalankan task-016 Part 1 (B1, B2, B3) dari spec Obsidian — **kecuali Docker sudah terinstall** (cek dulu via `docker --version`, jangan install ulang kalau sudah ada, karena app lama sudah pakai Docker yang sama).

```bash
sudo apt update && sudo apt upgrade -y
sudo apt install -y git curl unzip

# SKIP instalasi Docker jika docker --version sudah jalan dan compose v2 tersedia
docker --version
docker compose version

sudo ufw status
# Pastikan hanya port 22 (SSH) open. Jangan ubah firewall app lama yang sudah jalan.
```

---

## PART 2 — Clone / Pull Project

```bash
mkdir -p /home/$USER/apps
cd /home/$USER/apps

# Jika repo sudah pernah di-clone sebelumnya, cukup pull
# Jika belum, clone (user akan beri URL repo)
git clone <URL_REPO> dasipelajar
cd dasipelajar
```

Pastikan file-file Docker (`Dockerfile`, `nginx.conf`, `docker-compose.prod.yml`) sudah ada di root — ini dibuat oleh Claude Code di komputer lokal sebelum repo di-push. Jika belum ada, **STOP** dan informasikan ke user — jangan membuatnya sendiri tanpa konteks dari `DEPLOY.md`.

---

## PART 3 — Resolusi Jaringan Shared-Tunnel

Berdasarkan temuan "STATUS AWAL" di atas, putuskan satu dari dua opsi (detail di `DEPLOY.md`):

**Opsi A — External Docker network bersama (direkomendasikan):**
```bash
docker network create shared_tunnel_net

# Attach ke compose app lama: tambahkan network shared_tunnel_net sebagai "external: true"
# di docker-compose app lama (service cloudflared), lalu:
cd /path/to/app-lama
docker compose up -d  # re-create agar network baru attached

# Di docker-compose.prod.yml DASI Pelajar, service nginx juga join shared_tunnel_net
```

**Opsi B — Publish port host + tunnel akses localhost:**
Hanya jika Opsi A tidak memungkinkan (misal app lama pakai compose version lama yang tidak support easy network attach). Diskusikan dengan user sebelum pakai opsi ini karena perlu ubah konfigurasi tunnel app lama juga.

Setelah jaringan beres, baru lanjut ke setup `.env`.

---

## PART 4 — Setup `.env` Production

```bash
cd /home/$USER/apps/dasipelajar
cp .env.example .env
nano .env
```

Isi (minta value dari user untuk yang sensitif — JANGAN generate password sendiri tanpa konfirmasi):

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://[domain-dari-user].com

DB_HOST=mariadb
DB_DATABASE=dasi_pelajar
DB_USERNAME=dasi_user
DB_PASSWORD=[minta dari user — jangan generate sendiri]
DB_ROOT_PASSWORD=[minta dari user]

CLOUDFLARE_TUNNEL_TOKEN=[hanya isi jika compose DASI Pelajar punya service cloudflared sendiri — biasanya TIDAK, karena shared tunnel. Cek docker-compose.prod.yml dulu]
```

```bash
docker compose -f docker-compose.prod.yml run --rm php-fpm php artisan key:generate --force
```

---

## PART 5 — Import Database

User akan upload file SQL export (dari `mysqldump` lokal) ke `/home/$USER/dasi_export.sql`. Verifikasi file itu ada sebelum lanjut:

```bash
ls -la /home/$USER/dasi_export.sql
```

Jika tidak ada, **tanya user** — jangan jalankan fresh migrate+seed sebagai default diam-diam (itu akan menghasilkan database kosong, bukan data produksi asli).

```bash
docker compose -f docker-compose.prod.yml build php-fpm
docker compose -f docker-compose.prod.yml up -d mariadb
sleep 15

docker compose -f docker-compose.prod.yml exec -T mariadb \
  mysql -u dasi_user -p"$DB_PASSWORD" dasi_pelajar \
  < /home/$USER/dasi_export.sql

docker compose -f docker-compose.prod.yml exec mariadb \
  mysql -u dasi_user -p"$DB_PASSWORD" -e "SHOW TABLES;" dasi_pelajar
```

---

## PART 6 — Storage Link, Permissions, Jalankan Semua Service

```bash
docker compose -f docker-compose.prod.yml run --rm php-fpm php artisan storage:link

docker compose -f docker-compose.prod.yml run --rm php-fpm \
  sh -c "chown -R www-data:www-data storage bootstrap/cache && chmod -R 755 storage bootstrap/cache"

docker compose -f docker-compose.prod.yml up -d

docker compose -f docker-compose.prod.yml ps
# nginx, php-fpm, mariadb harus "running". cloudflared TIDAK ada di compose ini (shared tunnel).

docker compose -f docker-compose.prod.yml logs --tail=50 php-fpm
docker compose -f docker-compose.prod.yml logs --tail=50 nginx
```

---

## PART 7 — Optimize & Verifikasi

```bash
docker compose -f docker-compose.prod.yml exec php-fpm php artisan optimize
docker compose -f docker-compose.prod.yml exec php-fpm php artisan about
# Cek: Environment = production, Debug = OFF
```

---

## PART 8 — Go-Live Verification

Tunggu konfirmasi dari user bahwa Public Hostname tunnel sudah aktif (task-015, dikerjakan user di browser) sebelum test domain publik.

```bash
curl -s -o /dev/null -w "%{http_code}\n" https://[domain].com/
curl -s -o /dev/null -w "%{http_code}\n" https://[domain].com/berita
curl -s -o /dev/null -w "%{http_code}\n" https://[domain].com/agenda
curl -s -o /dev/null -w "%{http_code}\n" https://[domain].com/struktur-organisasi

# Security check — .env TIDAK boleh exposed
curl -s -o /dev/null -w "%{http_code}\n" https://[domain].com/.env
# Expected: 403/404, BUKAN 200 dengan isi file

# HTTPS redirect
curl -s -o /dev/null -w "%{http_code}\n" http://[domain].com
# Expected: 301
```

Semua harus 200 (kecuali `.env` yang harus 403/404, dan HTTP root yang harus 301). Jika ada yang gagal, cek tabel Troubleshooting di `task-017-deploy-phase-c-go-live.md`.

---

## PART 9 — Laporan ke User

Setelah semua acceptance criteria task-016 dan task-017 terpenuhi:
1. Update `12-Status.md` di Obsidian (task-015/016/017 → ✅ Selesai)
2. Append entry ke `14-Debug-Log.md` — termasuk keputusan jaringan (Opsi A/B) yang diambil di Part 3, dan kendala apapun yang ditemui
3. Sampaikan ke user: domain mana yang live, kredensial apa yang perlu disimpan di password manager (jangan tampilkan password di log/chat biasa — beri tahu lokasinya saja)

---

## ATURAN KERAS SELAMA EKSEKUSI DI SERVER

- **JANGAN** stop, restart, atau ubah container/compose project app lama tanpa izin eksplisit user
- **JANGAN** generate password DB sendiri — selalu minta dari user
- **JANGAN** expose port 80/443 langsung ke firewall — traffic harus selalu lewat Cloudflare Tunnel
- **JANGAN** commit `.env` atau kredensial apapun ke git
- Jika ragu soal keputusan jaringan (Part 3) atau ada resource app lama yang ambigu — **tanya user**, jangan asumsikan
