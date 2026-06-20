# CONTEXT — DASI Pelajar
_Updated: 2026-06-16 oleh Claudian_

---

## Task Aktif

**Task:** task-011 — Tag Clickable + Halaman Arsip per Tag

**Brief:**
- Apa: Ubah tag `<span>` → `<a>` di berita/show + index, buat route `/berita/tag/{slug}`, build view arsip-tag
- Scope: 1 controller method, 1 route, 1 view baru, edit 2 view existing
- ⚠️ Route `/berita/tag/{slug}` HARUS sebelum `/berita/{slug}` — risk conflict!
- Spec lengkap: `Brain/30.Projects/DasiPelajar/06-Features/tasks/task-011-tag-clickable-dan-arsip-tag.md`

## Recommended Model
**→ SONNET**

---

## Status Terakhir
- Task-010 (Arsip kategori berita) ✅ selesai — arsipKategori() method, route, view, fix "Lihat Semua →" di index + sidebar
- Task-001 s/d Task-009 ✅ semua selesai

---

## Investigasi WAJIB Sebelum Code
```bash
# Cek relasi Tag di Berita model
grep -n "tags\|belongsToMany\|berita_tag" app/Models/Berita.php

# Cek apakah Tag model sudah punya slug
grep -n "slug\|fillable" app/Models/Tag.php
```

---

## Jangan Lupa
- View standalone HTML (tidak extend layout) — konsisten dengan berita/show dan index
- Gunakan CSS variables `var(--dp-*)` — jangan hardcode warna
- Route `/berita/tag/{slug}` HARUS sebelum `/berita/{slug}` di routes/web.php
- Tag findBySlug: `Tag::where('slug', $slug)->firstOrFail()`
- Append hasil ke `14-Debug-Log.md` + update `12-Status.md`

---

## Next Action
Execute task-011 dengan Sonnet model. Investigasi Tag model dulu, lalu buat arsipTag() method, route, view, dan ubah span→a di show + index.
