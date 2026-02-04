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
use App\Http\Controllers\SliderAdminController;
use App\Http\Controllers\PengaturanWebAdminController;

//Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/berita', [\App\Http\Controllers\HomeController::class, 'indexBerita'])->name('berita.index');
Route::get('/berita/{slug}', [\App\Http\Controllers\HomeController::class, 'showBerita'])->name('berita.show');
Route::get('/struktur-organisasi', [\App\Http\Controllers\HomeController::class, 'struktur'])->name('struktur-organisasi');
Route::get('/profil', [\App\Http\Controllers\HomeController::class, 'profil'])->name('profil');
Route::get('/agenda', [\App\Http\Controllers\HomeController::class, 'agenda'])->name('agenda');
Route::get('/layanan', function () {
    return view('layanan.index');
})->name('layanan');

// Public Event Registration
Route::get('/event/{token}', [\App\Http\Controllers\EventController::class, 'show'])->name('public.event.register');
Route::post('/event/{token}', [\App\Http\Controllers\EventController::class, 'store'])->name('public.event.store');
Route::get('/api/check-nia', [\App\Http\Controllers\EventController::class, 'checkNia'])->name('public.check-nia');

// Auth Routes
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Routes (Protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Lembaga Pers Modules
    Route::resource('dashboard/berita', BeritaAdminController::class, ['as' => 'dashboard']);
    Route::resource('dashboard/kategori', KategoriAdminController::class, ['as' => 'dashboard']);
    Route::resource('dashboard/slider', SliderAdminController::class, ['as' => 'dashboard']);

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
        Route::resource('departemen', \App\Http\Controllers\Sekretariat\DepartemenController::class);
        Route::resource('inventaris', \App\Http\Controllers\Sekretariat\InventarisController::class);

        // Admin Features (New)
        Route::resource('pengurus', \App\Http\Controllers\Sekretariat\PengurusController::class);
        Route::resource('absensi', \App\Http\Controllers\Sekretariat\AbsensiController::class);
        Route::resource('sk', \App\Http\Controllers\Sekretariat\SuratKeputusanController::class);
    });

    // Departemen Modules
    Route::group(['prefix' => 'dashboard/departemen', 'as' => 'dashboard.departemen.'], function () {
        Route::get('/', [\App\Http\Controllers\Departemen\DashboardController::class, 'index'])->name('index');
        Route::get('/proker', [\App\Http\Controllers\Departemen\ProgramKerjaController::class, 'index'])->name('proker.index');
        Route::get('/proker/{id}', [\App\Http\Controllers\Departemen\ProgramKerjaController::class, 'show'])->name('proker.show');
        Route::put('/proker/{id}/status', [\App\Http\Controllers\Departemen\ProgramKerjaController::class, 'updateStatus'])->name('proker.update-status');

        // Sub-features
        Route::get('/proker/{id}/panitia', [\App\Http\Controllers\Departemen\ProgramKerjaController::class, 'indexPanitia'])->name('proker.panitia');
        Route::post('/proker/{id}/panitia', [\App\Http\Controllers\Departemen\ProgramKerjaController::class, 'storePanitia'])->name('proker.panitia.store');
        Route::delete('/proker/{id}/panitia/{panitiaId}', [\App\Http\Controllers\Departemen\ProgramKerjaController::class, 'destroyPanitia'])->name('proker.panitia.destroy');

        Route::get('/proker/{id}/agenda', [\App\Http\Controllers\Departemen\ProgramKerjaController::class, 'indexAgenda'])->name('proker.agenda.index');
        Route::post('/proker/{id}/agenda', [\App\Http\Controllers\Departemen\ProgramKerjaController::class, 'storeAgenda'])->name('proker.agenda.store');
        Route::delete('/proker/{id}/agenda/{agendaId}', [\App\Http\Controllers\Departemen\ProgramKerjaController::class, 'destroyAgenda'])->name('proker.agenda.destroy');

        Route::post('/proker/{id}/lpj', [\App\Http\Controllers\Departemen\ProgramKerjaController::class, 'updateLpj'])->name('proker.lpj.update');

        Route::get('/proker/{id}/pendaftaran', [\App\Http\Controllers\Departemen\ProgramKerjaController::class, 'indexPendaftaran'])->name('proker.pendaftaran');
        Route::put('/proker/{id}/pendaftaran', [\App\Http\Controllers\Departemen\ProgramKerjaController::class, 'updatePendaftaran'])->name('proker.pendaftaran.update');
    });

    // PAC Modules
    Route::group(['prefix' => 'dashboard/pac', 'as' => 'dashboard.pac.'], function () {
        Route::resource('proker', \App\Http\Controllers\Pac\RealisasiProgramController::class);
    });

    // Admin Modules (Custom View)
    Route::group(['prefix' => 'dashboard/admin', 'as' => 'dashboard.admin.', 'middleware' => 'role:admin,dep_organisasi'], function () {
        Route::resource('proker', \App\Http\Controllers\Admin\ProgramKerjaController::class);
        Route::get('/analisa', [\App\Http\Controllers\Admin\AnalisaController::class, 'index'])->name('analisa.index');
        Route::get('/analisa/date/{date}', [\App\Http\Controllers\Admin\AnalisaController::class, 'programsByDate'])->name('analisa.date');
        Route::get('/analisa/departemen/{id}', [\App\Http\Controllers\Admin\AnalisaController::class, 'programsByDepartemen'])->name('analisa.departemen');
        Route::get('/analisa/kategori/{id}', [\App\Http\Controllers\Admin\AnalisaController::class, 'programsByKategori'])->name('analisa.kategori');
        Route::get('/analisa/kategori-baru/{id}', [\App\Http\Controllers\Admin\AnalisaController::class, 'programsByKategoriBaru'])->name('analisa.kategori_baru');
        Route::get('/analisa/{id}', [\App\Http\Controllers\Admin\AnalisaController::class, 'detail'])->name('analisa.detail');
        Route::resource('pac', \App\Http\Controllers\Admin\PacManagementController::class);
    });
});
