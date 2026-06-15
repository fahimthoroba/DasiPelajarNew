# Conventions & Code Patterns — DASI Pelajar
# Sync dari: Obsidian 09-Conventions.md + SKILL-laravel-backend + SKILL-frontend-blade

---

## ❌ Larangan Keras

```
Jangan ubah schema DB tanpa migrasi baru + konfirmasi eksplisit
Jangan simpan file ke local disk — selalu ke MinIO (Storage::disk())
Jangan campur ProgramKerja dengan RealisasiProgram
Jangan bypass middleware CheckRole.php
Jangan hardcode warna di luar CSS variables
Jangan gunakan font selain Outfit (display/heading) dan Inter (body)
Jangan install package baru tanpa konfirmasi eksplisit
Jangan refactor kode di luar scope task
Jangan hapus role alias 'pers' dan 'departemen' sampai refactor 2I selesai
Jangan commit ke main branch langsung
```

---

## Laravel Patterns

### Eager Loading — Wajib, tidak ada N+1
```php
// BENAR
$prokers = ProgramKerja::with(['departemen', 'kepanitiaans'])->get();

// SALAH — N+1
$prokers = ProgramKerja::all();
foreach ($prokers as $p) { $p->departemen->nama; } // ❌

// ProgramKerja state methods — eager load sebelum view
$proker = ProgramKerja::with([
    'kepanitiaans',
    'absensis' => fn($q) => $q->where('jenis', 'rapat_panitia'),
])->findOrFail($id);
```

### Cache Pattern
```php
// Selalu pakai TTL eksplisit
Cache::remember('pengaturan_web', 3600, fn() => PengaturanWeb::first());
Cache::remember('pengurus_cabang', 86400, fn() => Pengurus::with([...])->get());
Cache::remember("qr_absensi_{$id}", 86400, fn() => /* generate QR SVG */);
Cache::remember("attendees_{$id}", 5, fn() => /* attendees query */);

// Invalidate wajib saat data berubah
Cache::forget('pengaturan_web');   // di PengaturanWebAdminController::update()
Cache::forget("qr_absensi_{$id}"); // di AbsensiController::close() & reopen()
```

### MinIO — File Upload & Retrieve
```php
// Upload
$path = $request->file('foto')->store('berita', 's3');          // public
$path = $request->file('lpj')->store('lpj', 'minio-private');   // private

// URL publik
$url = Storage::disk('s3')->url($berita->foto_path);

// Signed URL untuk private (TTL 5 menit)
$url = Storage::disk('s3')->temporaryUrl($layanan->file_path, now()->addMinutes(5));

// Hapus file
Storage::disk('s3')->delete($oldPath);
```

**Config MinIO di config/filesystems.php:**
```php
's3' => [
    'driver' => 's3',
    'key'    => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    'bucket' => env('AWS_BUCKET', 'dasi-public'),
    'endpoint' => env('AWS_ENDPOINT'),
    'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', true),
],
```

### Custom ID — HasCustomId
```php
// Prefix per model: use, kdr, proker, pan, sk, lay, pgr, dep
$proker = ProgramKerja::findOrFail($id);  // $id = 'proker001' (string)
$proker = ProgramKerja::find(1);          // ❌ SALAH — ID bukan integer
```

### Role Check
```php
// Di route:
Route::middleware(['auth', 'role:admin,sekretaris'])->group(fn() => ...);

// Di controller:
if (!in_array(auth()->user()->role, ['admin', 'dep_kaderisasi'])) {
    abort(403);
}
```

### Query Patterns Umum
```php
// Berita publik
Berita::with('kategori')->where('status', 'published')->latest()->paginate(12);

// Program kerja publik (GUNAKAN ProgramKerja, BUKAN RealisasiProgram)
ProgramKerja::with('departemen')
    ->when($request->departemen, fn($q, $v) => $q->where('departemen_id', $v))
    ->latest('tgl_pelaksanaan')->get();

// Statistik homepage — cache ini
$stats = Cache::remember('stats_homepage', 3600, fn() => [
    'anggota' => Kader::where('is_active', true)->count(),
    'pac'     => Organisasi::where('tingkat', 'PAC')->count(),
]);
```

### Migrasi — Format Wajib
```php
// Tambah indexes via migration baru, JANGAN ubah migration lama
Schema::table('beritas', function (Blueprint $table) {
    $table->index('status');
    $table->index(['status', 'tgl_publish']);  // composite
});

// Custom ID untuk tabel baru
Schema::create('layanans', function (Blueprint $table) {
    $table->string('id', 10)->primary();  // 'lay001'
    // ...
});
```

---

## Tailwind & Blade Patterns

### Design System — 3 Warna Utama
```
#08332c  Hijau tua — navbar, badge, bg primary
#ba9e6f  Emas — aksen, gold, highlight
#f4f4f4  Putih gading — bg page light mode
```

**CSS Variables — gunakan ini, jangan hardcode:**
```css
var(--dp-bg-primary)      /* #08332c */
var(--dp-text-gold)       /* #ba9e6f */
var(--dp-bg-page)         /* #f4f4f4 */
var(--dp-danger)          /* #e8463a */
```

### Navbar (Sticky, Desktop + Mobile)
```blade
<nav class="sticky top-0 z-50 bg-[#08332c] border-b-3 border-[#ba9e6f]">
  {{-- Mobile: hamburger --}}
  <div class="flex md:hidden items-center justify-between px-4 py-3">
    <div>Logo</div>
    <button x-data @click="$dispatch('toggle-nav')">☰</button>
  </div>
  {{-- Desktop --}}
  <div class="hidden md:flex items-center justify-between px-8 py-3">
    <a class="text-[#f4f4f4] text-sm hover:text-[#ba9e6f] transition">Beranda</a>
  </div>
  {{-- Mobile menu Alpine --}}
  <div x-data="{ open: false }" @toggle-nav.window="open = !open"
       x-show="open" x-transition class="md:hidden bg-[#062620] px-4 pb-4">
    <a class="block text-[#f4f4f4] py-2 border-b border-[#ba9e6f]/20">Beranda</a>
  </div>
</nav>
```

### Section Header
```blade
<div class="flex items-center gap-4 mb-6 border-t-4 border-[#08332c] pt-4">
  <h2 class="font-display text-xl font-bold text-[#08332c] dark:text-[#ba9e6f]">
    Judul Section
  </h2>
  <div class="flex-1 h-px bg-gray-200 dark:bg-[#ba9e6f]/20"></div>
  <a href="#" class="text-sm font-semibold text-[#ba9e6f] hover:text-[#d4bc91] transition">
    Lihat Semua →
  </a>
</div>
```

### Badge Kategori & Status
```blade
{{-- Badge hijau --}}
<span class="inline-block bg-[#08332c] text-[#ba9e6f] text-[10px] font-semibold
             px-2 py-1 tracking-[1.5px] uppercase">Organisasi</span>

{{-- Badge emas --}}
<span class="inline-block bg-[#ba9e6f] text-[#08332c] text-[10px] font-semibold
             px-2 py-1 tracking-[1.5px] uppercase">Kaderisasi</span>

{{-- Badge status proker --}}
@php $statusClass = match($proker->status_pelaksanaan) {
    'Selesai'             => 'text-[#08332c] dark:text-[#7aab96]',
    'Pelaksanaan'         => 'text-[#ba9e6f]',
    'Direncanakan'        => 'text-gray-400',
    'Tidak Terlaksana'    => 'text-[#e8463a]',
    default               => 'text-gray-400'
}; @endphp
<span class="text-xs font-semibold {{ $statusClass }}">{{ $proker->status_pelaksanaan }}</span>
```

### Gambar dari Storage
```blade
{{-- Public bucket --}}
<img src="{{ Storage::disk('s3')->url($berita->foto_path) }}" alt="...">

{{-- Private (signed URL) --}}
<a href="{{ Storage::disk('s3')->temporaryUrl($layanan->file_path, now()->addMinutes(5)) }}">
  Download
</a>
```

### Alpine.js — Polling Attendees (5 detik)
```blade
<div x-data="{ attendees: [] }"
     x-init="setInterval(() => {
       fetch('/dashboard/kaderisasi/absensi/{{ $id }}/attendees')
         .then(r => r.json())
         .then(data => attendees = data)
     }, 5000)">
  <template x-for="a in attendees" :key="a.id">
    <tr><td x-text="a.nama"></td></tr>
  </template>
</div>
```

---

## Checklist Sebelum Selesai

**Backend:**
- [ ] Tidak ada N+1 (semua relasi pakai with())
- [ ] File upload ke MinIO, bukan local
- [ ] Cache dipakai untuk data berat + ada invalidation
- [ ] Migrasi tidak mengubah kolom yang sudah ada (tambah migration baru)
- [ ] Route baru di web.php dengan middleware role yang benar
- [ ] Custom ID: pakai findOrFail($id) bukan find(1)

**Frontend:**
- [ ] Test di 375px (mobile)
- [ ] Test di 768px (tablet)
- [ ] Dark mode tidak rusak
- [ ] Tidak ada hardcoded warna di luar design system
- [ ] Font: Outfit (display) + Inter (body) — bukan Playfair Display atau Figtree
- [ ] Gambar via Storage::disk('s3')->url() bukan hardcode path
