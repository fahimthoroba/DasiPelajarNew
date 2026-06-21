# DEPLOY.md — Panduan Go-Live DASI Pelajar
# Baca file ini SEBELUM mengerjakan task-015/016/017.
# Ditulis untuk dua pembaca berbeda: User (manual) dan Claude Code yang jalan di server.

---

## RINGKASAN ARSITEKTUR DEPLOY

```
Domain baru (DASI Pelajar) ──► Cloudflare DNS ──► Tunnel EXISTING (shared dengan app lama)
                                                         │
                                                         ▼
                                         Server fisik (Xubuntu 25.10, sama dgn app lama)
                                                         │
                                         ┌───────────────┴───────────────┐
                                         │                               │
                                  docker-compose app lama      docker-compose DASI Pelajar
                                  (network terpisah)           (network terpisah, project baru)
```

**Poin kritis:** Tunnel Cloudflare TIDAK dibuat baru — DASI Pelajar menumpang tunnel yang sudah dipakai domain lama. Yang baru hanya: domain baru di Cloudflare DNS, Public Hostname baru di tunnel existing, dan docker-compose project baru (terpisah dari app lama, tidak boleh ganggu/replace app lama).

---

## SIAPA MENGERJAKAN APA

### 🙋 USER — wajib manual, tidak bisa didelegasikan ke Claude Code

| # | Tugas | Di mana |
|---|-------|---------|
| 1 | Pindah nameserver domain baru ke Cloudflare (task-015 Langkah A1) | Browser — dashboard registrar + Cloudflare |
| 2 | Set SSL/TLS mode = Full, Always Use HTTPS, Automatic HTTPS Rewrites (task-015 Langkah A2) | Browser — Cloudflare dashboard |
| 3 | Tambah Public Hostname baru ke tunnel **existing** (bukan buat tunnel baru) — domain baru → service `nginx:80` (task-015 Langkah A3 Revisi) | Browser — Cloudflare Zero Trust dashboard |
| 4 | Catat `TUNNEL_TOKEN` existing (sama dengan app lama) untuk dipakai di `.env` server | Cloudflare dashboard / config existing |
| 5 | Generate password DB production (`DB_PASSWORD`, `DB_ROOT_PASSWORD`) — jangan dipilih oleh Claude Code, pilih sendiri & simpan di password manager | — |
| 6 | Export database lokal (`mysqldump`) dan upload (`scp`) ke server | Terminal Windows (XAMPP) → server |
| 7 | SSH ke server pertama kali, pastikan akses jalan | Terminal |
| 8 | Final sanity check di browser publik: buka domain, test login, dst (task-017 Part 6 "Test di Browser") | Browser, dari device manapun |

> User TIDAK perlu mengetik command Docker satu-satu. Begitu masuk terminal server, **serahkan ke Claude Code di server** dengan menempel isi `DEPLOY-SERVER.md` (file baru, lihat di bawah) sebagai instruksi kerja.

---

### 🤖 CLAUDE CODE (di komputer ini / repo) — disiapkan sekarang, sebelum ke server

| # | Tugas |
|---|-------|
| 1 | Buat `Dockerfile`, `nginx.conf`, `docker-compose.prod.yml` di root project ini (task-016 Part 3) |
| 2 | Pastikan `docker-compose.prod.yml` pakai **network/project name unik** (`dasipelajar_prod`) agar tidak bentrok dengan docker-compose app lama di server yang sama |
| 3 | Pastikan service `cloudflared` di compose file ini **TIDAK dipakai** — karena tunnel sudah jalan di compose app lama. Compose DASI Pelajar cukup expose `nginx:80` ke internal Docker network; routing dari tunnel ke container ini diatur lewat Public Hostname (langkah user #3) yang perlu bisa resolve `nginx:80` milik DASI Pelajar — lihat catatan jaringan di bawah |
| 4 | Update `.env.example` dengan placeholder yang relevan (`CLOUDFLARE_TUNNEL_TOKEN` dihapus dari compose DASI Pelajar jika tunnel tidak di-run dari compose ini) |
| 5 | Commit & push semua file Docker baru ke repo (BUKAN ke main langsung — sesuai aturan CLAUDE.md) |

### 🤖 CLAUDE CODE (di server, setelah clone repo) — lihat `DEPLOY-SERVER.md`

Semua command teknis (install Docker, build image, migrate DB, verifikasi go-live) didelegasikan ke Claude Code yang berjalan langsung di server, dipandu oleh `DEPLOY-SERVER.md`. User tinggal menyalakan sesi Claude Code di server dan menunjuk file itu.

---

## CATATAN JARINGAN PENTING (shared tunnel, app terpisah)

Karena tunnel `cloudflared` sudah berjalan sebagai bagian dari docker-compose **app lama**, dan compose DASI Pelajar adalah project Docker Compose **terpisah**, container `cloudflared` (app lama) tidak otomatis bisa menjangkau container `nginx` (DASI Pelajar) — beda Docker network secara default.

**Pilihan solusi (putuskan saat eksekusi task-016, bukan diasumsikan sekarang):**
1. **External network bersama** — buat satu Docker network eksternal (misal `shared_tunnel_net`), lalu attach container `cloudflared` (app lama) DAN container `nginx` (DASI Pelajar) ke network itu. Public Hostname tunnel mengarah ke `nginx:80` lewat network ini.
2. **Tunnel ke host IP/port** — alih-alih `nginx:80` (nama service Docker), arahkan Public Hostname ke `http://localhost:<port>` jika nginx DASI Pelajar di-publish ke port host yang unik (misal `8081:80`), dan `cloudflared` jalan di mode host network atau bisa akses `localhost` host.

Opsi 1 lebih bersih dan idiomatic Docker. Keputusan final dan eksekusi (cek docker network app lama dulu dengan `docker network ls` & `docker inspect`) didelegasikan ke Claude Code di server — jangan dikerjakan blind dari sini karena konfigurasi app lama belum diketahui detailnya.

---

## URUTAN EKSEKUSI

1. User: task-015 (Cloudflare, manual) ✅ prasyarat
2. Claude Code (lokal): siapkan file Docker di repo, commit, push
3. User: clone repo ke server (atau Claude Code di server yang clone, jika user sudah beri akses git)
4. Claude Code (server): jalankan `DEPLOY-SERVER.md` dari awal sampai go-live verification
5. User: final check di browser + simpan kredensial production di tempat aman

---

## REFERENSI
- Spec lengkap: `C:\Brain\Brain\Brain\30.Projects\DasiPelajar\06-Features\tasks\task-015-deploy-phase-a-cloudflare.md`
- Spec lengkap: `C:\Brain\Brain\Brain\30.Projects\DasiPelajar\06-Features\tasks\task-016-deploy-phase-b-docker-setup.md`
- Spec lengkap: `C:\Brain\Brain\Brain\30.Projects\DasiPelajar\06-Features\tasks\task-017-deploy-phase-c-go-live.md`
- Panduan detail: `C:\Brain\Brain\Brain\30.Projects\DasiPelajar\15-Deployment-Guide.md`
- Instruksi eksekusi server: `DEPLOY-SERVER.md` (file ini, di root repo yang sama — akan ikut ter-clone ke server)
