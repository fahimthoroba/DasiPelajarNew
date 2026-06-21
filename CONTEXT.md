# CONTEXT — DASI Pelajar
_Updated: 2026-06-20 oleh Claudian_

---

## Task Aktif

**Task:** task-015 → task-016 → task-017 — Production Deployment

**Urutan eksekusi:**
1. **task-015** — Setup Cloudflare (MANUAL di browser, tidak perlu Claude Code)
2. **task-016** — Docker setup di server + buat file Dockerfile/nginx.conf/docker-compose.prod.yml → **SONNET**
3. **task-017** — Build + migrate + go-live verification → **HAIKU**

**Deployment guide lengkap:** `Brain/30.Projects/DasiPelajar/15-Deployment-Guide.md`

---

## Stack Production
- Docker Compose: Nginx + PHP-FPM 8.3 + MariaDB 10.11 + Cloudflared
- Redis + MinIO: commented out di compose, aktifkan Phase 2 nanti
- SSL: Cloudflare (mode Full)
- Tunnel: Cloudflare Tunnel (tidak perlu buka port 80/443 di router)

---

## Yang Perlu Disiapkan Dulu (Sebelum task-016)
1. ✅ Domain sudah dibeli
2. [ ] Pindah nameserver ke Cloudflare (task-015)
3. [ ] Buat Cloudflare Tunnel → dapat TUNNEL_TOKEN (task-015)
4. [ ] SSH access ke server sudah bisa dari mesin lokal

---

## Constraints Aktif
- JANGAN buka port 80/443 di router — traffic lewat Cloudflare Tunnel
- DB_HOST di .env production = `mariadb` (nama service Docker), BUKAN `localhost`
- FILESYSTEM_DISK=public (local storage) — MinIO belum aktif
- APP_DEBUG=false di production — wajib
- ⚠️ Ubuntu 25.10 support berakhir Juli 2026 — plan upgrade ke 26.04 LTS setelah deploy stabil
