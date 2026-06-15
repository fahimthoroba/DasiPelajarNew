Sesi selesai. Lakukan ini secara berurutan:

---

## STEP 1 — Update CONTEXT.md

Tulis hasil sesi di bagian bawah CONTEXT.md:

```
---
## HASIL SESI [tanggal hari ini]

**Dikerjakan:**
- [list apa yang berhasil dikerjakan]

**File dibuat/diubah:**
- `path/file.php` — [perubahan singkat]

**Keputusan teknis baru:**
- [keputusan yang diambil saat implementasi, jika ada]

**Masalah ditemukan:**
- [bug/issue yang ditemukan: sudah fix atau pending]

**Next action (eksplisit — sebutkan file dan method spesifik):**
- [langkah konkret berikutnya, bukan "lanjutkan"]
---
```

Jika ada bug baru → catat di ERRORS.md dengan format yang sudah ada.

---

## STEP 2 — Ingatkan User untuk Sync ke Obsidian

Setelah update CONTEXT.md, tampilkan pesan ini ke user:

> ✅ **CONTEXT.md sudah diupdate.**
>
> **Langkah selanjutnya (wajib):** Buka Obsidian dan minta Claudian untuk:
> 1. Catat hasil sesi ini ke `07-Dev-Log/Dev-Log.md`
> 2. Update status task di `08-Tasks/Tasks.md`
> 3. Catat keputusan teknis baru (jika ada) ke `Decisions.md`
>
> Kalimat untuk Claudian: *"Sesi Claude Code selesai. Sync hasil dari CONTEXT.md ke Obsidian."*

---

Tampilkan ringkasan singkat apa yang sudah selesai di sesi ini.
