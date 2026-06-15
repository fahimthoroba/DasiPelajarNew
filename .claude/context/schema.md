# Schema Ringkasan — DASI Pelajar
# Sync dari: Obsidian 04-Database-Schema.md
# Update file ini jika ada perubahan schema di Obsidian

## 26 Model & Tabel

| Model | Tabel | Custom ID | Keterangan |
|-------|-------|-----------|-----------|
| User | users | use001 | Akun pengurus — 1 user = 1 role |
| Kader | kaders | kdr001 | Data anggota/kader |
| Organisasi | organisasis | — | IPNU/IPPNU + tingkatan |
| Pengurus | pengurus | pgr001 | Struktur kepengurusan (self-ref) |
| Departemen | departemens | dep001 | Dept/Lembaga/Badan |
| SuratKeputusan | surat_keputusans | sk001 | SK kepengurusan |
| ProgramKerja | program_kerjas | proker001 | Proker PC — state machine 6-step |
| RealisasiProgram | realisasi_program | — | Proker PAC/PK — analitik saja |
| KategoriProgram | kategori_program | — | Kategori program kerja |
| Kepanitiaan | kepanitiaans | pan001 | Panitia per proker (Step 1) |
| Absensi | absensis | — | Sesi absensi QR |
| AbsensiRecord | absensi_records | — | Record hadir per peserta |
| FormKegiatan | form_kegiatans | — | Form pendaftaran (custom_fields JSON) |
| PesertaKegiatan | peserta_kegiatans | — | Peserta form kegiatan |
| Pendaftaran | pendaftarans | — | Legacy event controller |
| Berita | beritas | — | Artikel berita |
| KategoriBerita | kategori_beritas | — | Kategori berita |
| Tag | tags | — | Tag berita (pivot: berita_tag) |
| KomentarBerita | komentar_beritas | — | Komentar publik (self-ref 1 level) |
| HeroSlider | hero_sliders | — | Gambar slider homepage |
| BannerIklan | banner_iklans | — | Banner 3 posisi fixed |
| PengaturanWeb | pengaturan_webs | — | Config website (singleton ::first()) |
| Layanan | layanans | lay001 | File download center |
| SuratMasuk | surat_masuks | — | Arsip surat masuk |
| SuratKeluar | surat_keluars | — | Arsip surat keluar |
| Inventaris | inventaris | — | Aset organisasi |
| RiwayatPelatihan | riwayat_pelatihans | — | Riwayat pelatihan kader |

---

## Custom ID — HasCustomId Trait

```php
// BENAR — selalu pakai string
$proker = ProgramKerja::findOrFail($id);  // $id = 'proker001'

// SALAH — jangan pakai integer
$proker = ProgramKerja::find(1);  // ❌ tidak akan bekerja
```

---

## Enum Values Penting

### users.role (28 role + 2 alias)
```
# BPH
admin | sekretaris | bendahara

# Dept IPNU
dep_organisasi | dep_kaderisasi | dep_jaringan | dep_dakwah | dep_seni

# Dept IPPNU
dep_pengorg | dep_kaderisasi | dep_jaringan | dep_dakwah | dep_seni | dep_media

# Lembaga IPNU
lmb_lpp | lmb_lekas | lmb_lan | lmb_lkpt | lmb_cbp

# Badan IPNU
bdn_bscc | bdn_bsrc

# Lembaga IPPNU
lmb_kpp | lmb_konseling | lmb_ekraf | lmb_kdc

# Sub-unit
pac | pr | pk | pk_pt

# Alias lama — JANGAN HAPUS sebelum refactor 2I selesai
pers | departemen
```

### absensis.jenis
```
rapat_rutin | rapat_departemen | rapat_panitia | pelaksanaan | rapat_pac | pelatihan | lainnya
```

### program_kerjas.current_step + status_pelaksanaan
```
current_step: 1→2→3→4→5→6 (kepanitiaan→rapat→form→pelaksanaan→lpj→verifikasi)
status_pelaksanaan: Direncanakan | Persiapan | Pelaksanaan | Menunggu Verifikasi | Selesai | Tidak Terlaksana
```

### banner_iklans.posisi (3 posisi fixed)
```
leaderboard_berita | between_categories | sidebar_berita
```

---

## Relasi Kunci

```
ProgramKerja → hasMany Kepanitiaan, Absensi | hasOne FormKegiatan
Absensi → hasMany AbsensiRecord (kader_id nullable)
Berita → belongsToMany Tag (pivot berita_tag)
Pengurus → self-ref parent_id (hierarki jabatan)
PengaturanWeb → singleton: selalu PengaturanWeb::first() — JANGAN ::all() atau ::find(x)
```

---

## ProgramKerja — State Machine Methods

```php
// Semua method ini query ke DB — eager load dulu di controller
$proker = ProgramKerja::with([
    'kepanitiaans',
    'absensis',
    'absensis.records',
])->findOrFail($id);

isStep1Complete()           → kepanitiaans()->count() > 0
canCreateNewRapatPanitia()  → semua rapat_panitia tutup + punya notulensi
isStep5Locked()             → belum ada sesi pelaksanaan yang closed
isStep4Locked()             → !canProceedToPelaksanaan()
```

---

## Cache Keys

```php
'pengaturan_web'        TTL 3600   → PengaturanWeb::first() — forget di update()
'pengurus_cabang'       TTL 86400  → Pengurus query struktur
"qr_absensi_{$id}"      TTL 86400  → QR SVG — forget di close() & reopen()
"attendees_{$id}"       TTL 5      → Polling attendees (Tier 2, belum implemented)
```
