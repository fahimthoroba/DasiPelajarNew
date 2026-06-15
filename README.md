# DASI Pelajar — Sistem Manajemen Organisasi

**Platform digital untuk PC IPNU-IPPNU Kabupaten Kediri.**
Bukan sekadar website profil — sistem untuk menertibkan dan mengendalikan pergerakan organisasi.

---

## Stack

| Layer | Teknologi |
|-------|-----------|
| Backend | Laravel 11 + PHP 8.2 |
| Admin Panel | Filament 4.3 |
| Frontend | Blade + TailwindCSS + Alpine.js |
| Build | Vite |
| Database | MariaDB / MySQL |
| Cache/Session | Redis (production) / File (dev) |
| Storage | MinIO (production) / Local (dev) |

---

## Quick Start (Development)

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
# Setup DB di .env, lalu:
php artisan migrate --seed
php artisan storage:link
composer run dev   # serve + queue + vite sekaligus
```

**Akses:** `http://localhost:8000`

---

## Panduan Session Claude Code

1. Baca `CLAUDE.md` — permanent brief (tech stack, rules, design system)
2. Baca `CONTEXT.md` — tugas aktif untuk sesi ini
3. Konfirmasi scope pekerjaan sebelum menulis kode
4. Di akhir sesi: update `CONTEXT.md` dengan hasil kerja

> Dokumentasi lengkap (fitur, database, arsitektur) ada di Obsidian vault:
> `C:\Brain\Brain\Brain\30.Projects\DasiPelajar\`

---

## Lokasi Penting

```
app/Http/Controllers/   ← Controller per role (Admin/, Departemen/, Sekretariat/, dst)
app/Models/             ← 26 Eloquent model
app/Traits/HasCustomId  ← Custom string ID generator (lay001, pan001, dst)
resources/views/        ← Blade templates (dashboard/, berita/, layouts/)
resources/css/app.css   ← Design system CSS variables (light + dark mode)
routes/web.php          ← Semua route
database/migrations/    ← 60+ migrasi bertahap
```
