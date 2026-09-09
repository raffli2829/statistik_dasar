<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\StatistikController;
use Illuminate\Support\Facades\Route;

// =========================================================================
// 1. HALAMAN PUBLIK SUB-MODUL STATISTIK DASAR
// =========================================================================
Route::get('/', [StatistikController::class, 'index'])->name('statistik.index');
Route::get('/statistik-dasar', [StatistikController::class, 'index'])->name('statistik.subpage');

// API Endpoints untuk Interaktivitas AJAX / Chart.js
Route::get('/api/sektor/{id}', [StatistikController::class, 'getSectorData'])->name('api.sektor');
Route::get('/api/kecamatan', [StatistikController::class, 'getKecamatanData'])->name('api.kecamatan');

// Export Data (CSV & JSON)
Route::get('/download/csv/{sektor}/{tahun}', [StatistikController::class, 'downloadCsv'])->name('download.csv');
Route::get('/download/json/{sektor}/{tahun}', [StatistikController::class, 'downloadJson'])->name('download.json');

// =========================================================================
// 2. AUTENTIKASI ADMIN
// =========================================================================
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// =========================================================================
// 3. PANEL ADMIN (TERPROTEKSI AUTH)
// =========================================================================
Route::prefix('admin')->middleware('auth')->group(function () {
    // Dashboard Ringkasan
    Route::get('/', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');

    // Manajemen Indikator Makro & Sektoral
    Route::get('/indikator', [AdminDashboardController::class, 'indicators'])->name('admin.indicators');
    Route::get('/indikator/{id}/edit', [AdminDashboardController::class, 'editIndicator'])->name('admin.indicators.edit');
    Route::post('/indikator/{id}/update', [AdminDashboardController::class, 'updateIndicator'])->name('admin.indicators.update');

    // Manajemen Data 8 Kecamatan
    Route::get('/kecamatan', [AdminDashboardController::class, 'kecamatan'])->name('admin.kecamatan');
    Route::get('/kecamatan/{id}/edit', [AdminDashboardController::class, 'editKecamatan'])->name('admin.kecamatan.edit');
    Route::post('/kecamatan/{id}/update', [AdminDashboardController::class, 'updateKecamatan'])->name('admin.kecamatan.update');

    // Import CSV Massal & Sinkronisasi API
    Route::get('/import-sync', [AdminDashboardController::class, 'importExport'])->name('admin.import');
    Route::post('/import-csv', [AdminDashboardController::class, 'processImport'])->name('admin.import.process');
    Route::get('/template/{type}', [AdminDashboardController::class, 'downloadTemplate'])->name('admin.template.download');
    Route::post('/sync-api', [AdminDashboardController::class, 'syncApi'])->name('admin.sync');
});
