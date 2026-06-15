Saya ingin redesign tampilan: $ARGUMENTS

Aturan WAJIB dari design system (CLAUDE.md + .claude/context/conventions.md):
- Warna: #08332c (hijau tua) + #ba9e6f (emas) + #f4f4f4 (putih gading)
- Font: Outfit (display/heading, font-display) + Inter (body, font-body / font-sans)
- CSS Variables: gunakan --dp-* variables, JANGAN hardcode warna sembarangan
- Gaya: portal berita (Kompas, Tirto) + elegan organisasi Islam
- Dark mode: WAJIB ada di semua komponen (.dark { ... } atau x-data dengan toggle)
- Mobile-first: mulai dari 375px ke atas

Langkah:
1. Tampilkan struktur HTML/Blade yang akan dibuat
2. Sebutkan komponen Tailwind yang digunakan
3. Pastikan semua gambar pakai Storage::disk('s3')->url()
4. Pastikan tidak ada font atau warna hardcode di luar design system
5. TUNGGU konfirmasi sebelum eksekusi

Lihat contoh komponen di .claude/context/conventions.md bagian "Tailwind & Blade Patterns".
