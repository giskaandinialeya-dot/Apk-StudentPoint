<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Guru\{
    DashboardController as GuruDashboardController,
    PelanggaranController,
    PrestasiController,
    AbsensiController,
};
use App\Http\Controllers\Siswa\{
    DashboardController as SiswaDashboardController,
    ProfilController as SiswaProfilController,
};
use App\Http\Controllers\OrangTua\{
    DashboardController as OrangTuaDashboardController,
};
use App\Http\Controllers\Admin\{
    DashboardController as AdminDashboardController,
    SiswaController as AdminSiswaController,
    GuruController as AdminGuruController,
    KelasController as AdminKelasController,
    JenisPerlangaranController as AdminJenisPerlangaranController,
};

// Include authentication routes
require __DIR__ . '/auth.php';

// Debug routes
if (app()->isLocal()) {
    require __DIR__ . '/debug-pelanggaran.php';
}

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect('/dashboard');
});

// Authenticated Routes
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Redirect ke dashboard sesuai role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ============================================================================
    // ADMIN ROUTES
    // ============================================================================
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('siswa', AdminSiswaController::class);
        Route::resource('guru', AdminGuruController::class);
        Route::resource('kelas', AdminKelasController::class);
        Route::resource('jenis-pelanggaran', AdminJenisPerlangaranController::class);
    });

    // ============================================================================
    // GURU ROUTES
    // ============================================================================
    Route::middleware(['role:guru'])->prefix('guru')->name('guru.')->group(function () {
        Route::get('/', [GuruDashboardController::class, 'index'])->name('dashboard');
        Route::resource('pelanggaran', PelanggaranController::class);
        Route::resource('prestasi', PrestasiController::class);
        Route::resource('absensi', AbsensiController::class);
        Route::get('absensi-hari-ini', [AbsensiController::class, 'bulkToday'])->name('absensi.bulk-today');
        // Guru dapat membuat jenis pelanggaran custom
        Route::post('jenis-pelanggaran/quick-add', [PelanggaranController::class, 'quickAddJenis'])->name('jenis-pelanggaran.quick-add');
    });

    // ============================================================================
    // SISWA ROUTES (READ-ONLY)
    // ============================================================================
    Route::middleware(['role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/', [SiswaDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profil', [SiswaProfilController::class, 'show'])->name('profil.show');
        Route::get('/profil/edit', [SiswaProfilController::class, 'edit'])->name('profil.edit');
        Route::put('/profil', [SiswaProfilController::class, 'update'])->name('profil.update');
        // Siswa dapat input absensi
        Route::post('/absensi/input-hari-ini', [\App\Http\Controllers\Siswa\AbsensiController::class, 'inputHariIni'])->name('absensi.input-hari-ini');
        Route::get('/absensi/riwayat', [\App\Http\Controllers\Siswa\AbsensiController::class, 'riwayat'])->name('absensi.riwayat');
    });
});
