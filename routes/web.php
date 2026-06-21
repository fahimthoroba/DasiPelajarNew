<?php

use Illuminate\Support\Facades\Route;

use App\Models\Berita;
use App\Models\Kader;
use App\Models\ProgramKerja;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BeritaAdminController;
use App\Http\Controllers\KategoriAdminController;
use App\Http\Controllers\MediaVisualController;
use App\Http\Controllers\PengaturanWebAdminController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\Dashboard\KomentarAdminController;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/berita', [\App\Http\Controllers\HomeController::class, 'indexBerita'])->name('berita.index');
// ⚠️ HARUS sebelum /berita/{slug} — agar tidak tertangkap sebagai slug berita
Route::get('/berita/kategori/{slug}', [\App\Http\Controllers\HomeController::class, 'arsipKategori'])->name('berita.arsip-kategori');
Route::get('/berita/tag/{slug}', [\App\Http\Controllers\HomeController::class, 'arsipTag'])->name('berita.arsip-tag');
Route::get('/berita/{slug}', [\App\Http\Controllers\HomeController::class, 'showBerita'])->name('berita.show');
Route::post('/berita/{slug}/komentar', [\App\Http\Controllers\HomeController::class, 'storeKomentar'])->name('berita.komentar.store');
Route::get('/struktur-organisasi', [\App\Http\Controllers\HomeController::class, 'struktur'])->name('struktur-organisasi');
Route::get('/profil', [\App\Http\Controllers\HomeController::class, 'profil'])->name('profil');
Route::get('/agenda', [\App\Http\Controllers\HomeController::class, 'agenda'])->name('agenda');
Route::get('/layanan', [LayananController::class, 'index'])->name('layanan');
Route::get('/layanan/{id}/download', [LayananController::class, 'download'])->name('layanan.download');

// Public Event Registration
Route::get('/event/{token}', [\App\Http\Controllers\EventController::class, 'show'])->name('public.event.register');
Route::post('/event/{token}', [\App\Http\Controllers\EventController::class, 'store'])->name('public.event.store');
Route::get('/api/check-nia', [\App\Http\Controllers\EventController::class, 'checkNia'])->name('public.check-nia');

// Public Form Pendaftaran Kegiatan
Route::get('/form/{slug}', [\App\Http\Controllers\Layanan\FormPendaftaranController::class, 'show'])->name('layanan.form.show');
Route::post('/form/{slug}', [\App\Http\Controllers\Layanan\FormPendaftaranController::class, 'submit'])->name('layanan.form.submit');

// Auth Routes
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Dashboard Routes (Protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil & Ganti Password
    Route::get('dashboard/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('dashboard.profile.edit');
    Route::put('dashboard/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('dashboard.profile.password.update');

    // Media Visual (Hero Slider + Banner Iklan) — menggantikan /slider
    Route::get('dashboard/media-visual', [\App\Http\Controllers\MediaVisualController::class, 'index'])->name('dashboard.media-visual.index');
    Route::get('dashboard/media-visual/slider/create', [\App\Http\Controllers\MediaVisualController::class, 'sliderCreate'])->name('dashboard.media-visual.slider.create');
    Route::post('dashboard/media-visual/slider', [\App\Http\Controllers\MediaVisualController::class, 'sliderStore'])->name('dashboard.media-visual.slider.store');
    Route::get('dashboard/media-visual/slider/{slider}/edit', [\App\Http\Controllers\MediaVisualController::class, 'sliderEdit'])->name('dashboard.media-visual.slider.edit');
    Route::put('dashboard/media-visual/slider/{slider}', [\App\Http\Controllers\MediaVisualController::class, 'sliderUpdate'])->name('dashboard.media-visual.slider.update');
    Route::delete('dashboard/media-visual/slider/{slider}', [\App\Http\Controllers\MediaVisualController::class, 'sliderDestroy'])->name('dashboard.media-visual.slider.destroy');
    Route::post('dashboard/media-visual/banner/{posisi}', [\App\Http\Controllers\MediaVisualController::class, 'bannerUpdate'])->name('dashboard.media-visual.banner.update');
    Route::delete('dashboard/media-visual/banner/{posisi}', [\App\Http\Controllers\MediaVisualController::class, 'bannerClear'])->name('dashboard.media-visual.banner.clear');

    // Settings
    Route::get('/dashboard/pengaturan', [PengaturanWebAdminController::class, 'index'])->name('dashboard.pengaturan.index');
    Route::put('/dashboard/pengaturan', [PengaturanWebAdminController::class, 'update'])->name('dashboard.pengaturan.update');

    // Sekretariat Modules
    Route::group(['prefix' => 'dashboard/sekretariat', 'as' => 'dashboard.sekretariat.'], function () {
        Route::get('/master-data', [\App\Http\Controllers\Sekretariat\MasterDataController::class, 'index'])->name('master-data.index');
        Route::resource('surat-masuk', \App\Http\Controllers\Sekretariat\SuratMasukController::class);
        Route::resource('surat-keluar', \App\Http\Controllers\Sekretariat\SuratKeluarController::class);

        // Master Data Resources
        Route::resource('kader', \App\Http\Controllers\Sekretariat\KaderController::class);
        Route::resource('inventaris', \App\Http\Controllers\Sekretariat\InventarisController::class);

        // Program Kerja Input & Verifikasi
        Route::post('proker/{id}/verifikasi', [\App\Http\Controllers\Sekretariat\ProgramKerjaController::class, 'verifikasi'])->name('proker.verifikasi');
        Route::resource('proker', \App\Http\Controllers\Sekretariat\ProgramKerjaController::class);

        // Admin Features (New)
        Route::post('pengurus/bulk-store', [\App\Http\Controllers\Sekretariat\PengurusController::class, 'bulkStore'])->name('pengurus.bulk-store');
        Route::resource('pengurus', \App\Http\Controllers\Sekretariat\PengurusController::class);
        Route::resource('absensi', \App\Http\Controllers\Sekretariat\AbsensiController::class);
        Route::resource('sk', \App\Http\Controllers\Sekretariat\SuratKeputusanController::class);
        Route::patch('sk/{id}/status', [\App\Http\Controllers\Sekretariat\SuratKeputusanController::class, 'updateStatus'])->name('sk.update-status');
        Route::resource('organisasi', \App\Http\Controllers\Sekretariat\OrganisasiController::class);
    });

    // Departemen Modules
    Route::group(['prefix' => 'dashboard/departemen', 'as' => 'dashboard.departemen.'], function () {
        Route::get('/', [\App\Http\Controllers\Departemen\DashboardController::class, 'index'])->name('index');
        Route::get('/proker', [\App\Http\Controllers\Departemen\ProgramKerjaController::class, 'index'])->name('proker.index');
        Route::get('/proker/{id}', [\App\Http\Controllers\Departemen\ProgramKerjaController::class, 'show'])->name('proker.show');
        Route::put('/proker/{id}/status', [\App\Http\Controllers\Departemen\ProgramKerjaController::class, 'updateStatus'])->name('proker.update-status');

        // Sub-features
        Route::get('/proker/{id}/panitia', [\App\Http\Controllers\Departemen\ProgramKerjaController::class, 'indexPanitia'])->name('proker.panitia');
        Route::post('/proker/{id}/panitia/bulk', [\App\Http\Controllers\Departemen\ProgramKerjaController::class, 'bulkStorePanitia'])->name('proker.panitia.bulk-store');
        Route::delete('/proker/{id}/panitia/{panitiaId}', [\App\Http\Controllers\Departemen\ProgramKerjaController::class, 'destroyPanitia'])->name('proker.panitia.destroy');

        Route::get('/proker/{id}/agenda', [\App\Http\Controllers\Departemen\ProgramKerjaController::class, 'indexAgenda'])->name('proker.agenda.index');
        Route::post('/proker/{id}/agenda', [\App\Http\Controllers\Departemen\ProgramKerjaController::class, 'storeAgenda'])->name('proker.agenda.store');
        Route::post('/proker/{id}/agenda/{agendaId}/close', [\App\Http\Controllers\Departemen\ProgramKerjaController::class, 'closeAgenda'])->name('proker.agenda.close');
        Route::post('/proker/{id}/agenda/{agendaId}/notulensi', [\App\Http\Controllers\Departemen\ProgramKerjaController::class, 'uploadNotulensi'])->name('proker.agenda.notulensi');
        Route::delete('/proker/{id}/agenda/{agendaId}', [\App\Http\Controllers\Departemen\ProgramKerjaController::class, 'destroyAgenda'])->name('proker.agenda.destroy');

        Route::post('/proker/{id}/lpj', [\App\Http\Controllers\Departemen\ProgramKerjaController::class, 'updateLpj'])->name('proker.lpj.update');
    });

    // PAC Modules
    Route::group(['prefix' => 'dashboard/pac', 'as' => 'dashboard.pac.'], function () {
        Route::resource('proker', \App\Http\Controllers\Pac\RealisasiProgramController::class);
    });

    // Form Kegiatan — standalone, accessible by all departments/lembaga/badan
    Route::group(['prefix' => 'dashboard/form-kegiatan', 'as' => 'dashboard.form-kegiatan.'], function () {
        Route::get('/',              [\App\Http\Controllers\FormKegiatanController::class, 'index'])->name('index');
        Route::get('/create',        [\App\Http\Controllers\FormKegiatanController::class, 'create'])->name('create');
        Route::post('/',             [\App\Http\Controllers\FormKegiatanController::class, 'store'])->name('store');
        Route::get('/{id}',          [\App\Http\Controllers\FormKegiatanController::class, 'show'])->name('show');
        Route::get('/{id}/edit',     [\App\Http\Controllers\FormKegiatanController::class, 'edit'])->name('edit');
        Route::put('/{id}',          [\App\Http\Controllers\FormKegiatanController::class, 'update'])->name('update');
        Route::delete('/{id}',       [\App\Http\Controllers\FormKegiatanController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/toggle', [\App\Http\Controllers\FormKegiatanController::class, 'toggleOpen'])->name('toggle');
        Route::get('/{id}/export-excel',   [\App\Http\Controllers\FormKegiatanController::class, 'exportExcel'])->name('export-excel');
        Route::get('/{id}/download-files', [\App\Http\Controllers\FormKegiatanController::class, 'downloadFiles'])->name('download-files');
    });

    // Kaderisasi Modules
    Route::group(['prefix' => 'dashboard/kaderisasi', 'as' => 'dashboard.kaderisasi.', 'middleware' => 'role:admin,pac,dep_kaderisasi,pr,pk'], function () {
        // Absensi Mandiri
        Route::get('absensi', [\App\Http\Controllers\Kaderisasi\AbsensiController::class, 'index'])->name('absensi.index');
        Route::get('absensi/create', [\App\Http\Controllers\Kaderisasi\AbsensiController::class, 'create'])->name('absensi.create');
        Route::post('absensi', [\App\Http\Controllers\Kaderisasi\AbsensiController::class, 'store'])->name('absensi.store');
        Route::get('absensi/{id}', [\App\Http\Controllers\Kaderisasi\AbsensiController::class, 'show'])->name('absensi.show');
        Route::post('absensi/{id}/manual', [\App\Http\Controllers\Kaderisasi\AbsensiController::class, 'addManual'])->name('absensi.add-manual');
        Route::patch('absensi/{id}/close', [\App\Http\Controllers\Kaderisasi\AbsensiController::class, 'close'])->name('absensi.close');
        Route::patch('absensi/{id}/reopen', [\App\Http\Controllers\Kaderisasi\AbsensiController::class, 'reopen'])->name('absensi.reopen');
        Route::delete('absensi/{id}', [\App\Http\Controllers\Kaderisasi\AbsensiController::class, 'destroy'])->name('absensi.destroy');
        Route::get('absensi/{id}/attendees', [\App\Http\Controllers\Kaderisasi\AbsensiController::class, 'attendees'])->name('absensi.attendees');
    });

    // Public scan route (requires login)
    Route::get('/absensi/scan/{kode}', [\App\Http\Controllers\Kaderisasi\AbsensiController::class, 'scan'])->name('absensi.scan');
    Route::post('/absensi/scan/{kode}', [\App\Http\Controllers\Kaderisasi\AbsensiController::class, 'processScan'])->name('absensi.process-scan');

    // Admin Modules (Custom View)
    Route::group(['prefix' => 'dashboard/admin', 'as' => 'dashboard.admin.', 'middleware' => 'role:admin,dep_organisasi'], function () {
        Route::resource('proker', \App\Http\Controllers\Admin\ProgramKerjaController::class);
        Route::get('/analisa', [\App\Http\Controllers\Admin\AnalisaController::class, 'index'])->name('analisa.index');
        Route::get('/analisa/date/{date}', [\App\Http\Controllers\Admin\AnalisaController::class, 'programsByDate'])->name('analisa.date');
        Route::get('/analisa/departemen/{id}', [\App\Http\Controllers\Admin\AnalisaController::class, 'programsByDepartemen'])->name('analisa.departemen');
        Route::get('/analisa/kategori/{id}', [\App\Http\Controllers\Admin\AnalisaController::class, 'programsByKategori'])->name('analisa.kategori');
        Route::get('/analisa/kategori-baru/{id}', [\App\Http\Controllers\Admin\AnalisaController::class, 'programsByKategoriBaru'])->name('analisa.kategori_baru');
        Route::get('/analisa/{id}', [\App\Http\Controllers\Admin\AnalisaController::class, 'detail'])->name('analisa.detail');
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    });
});

// Lembaga Pers Modules — eksklusif role lmb_lpp (ADR-011)
Route::middleware(['auth', 'role:lmb_lpp'])->group(function () {
    // Komentar moderation — HARUS sebelum resource berita agar tidak tertangkap {beritum}
    Route::get('dashboard/berita/komentar', [KomentarAdminController::class, 'index'])->name('dashboard.berita.komentar.index');
    Route::post('dashboard/berita/komentar/{komentar}/approve', [KomentarAdminController::class, 'approve'])->name('dashboard.berita.komentar.approve');
    Route::post('dashboard/berita/komentar/{komentar}/reject', [KomentarAdminController::class, 'reject'])->name('dashboard.berita.komentar.reject');

    Route::post('dashboard/berita/upload-image', [BeritaAdminController::class, 'uploadImage'])->name('dashboard.berita.upload_image');
    Route::resource('dashboard/berita', BeritaAdminController::class, ['as' => 'dashboard']);
    Route::resource('dashboard/kategori', KategoriAdminController::class, ['as' => 'dashboard']);
    Route::post('dashboard/kategori/quick-store', [KategoriAdminController::class, 'quickStore'])->name('dashboard.kategori.quick-store');
});
