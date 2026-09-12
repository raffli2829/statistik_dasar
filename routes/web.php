<?php

use App\Http\Controllers\PublikasiController;
use App\Http\Controllers\StatistikController;
use Illuminate\Support\Facades\Route;

// =========================================================================
// 1. HALAMAN PUBLIK SUB-MODUL STATISTIK DASAR
// =========================================================================
Route::get('/', [StatistikController::class, 'index'])->name('statistik.index');
Route::get('/statistik-dasar', [StatistikController::class, 'index'])->name('statistik.subpage');

// =========================================================================
// 2. HALAMAN PUBLIKASI (Berita, Artikel, Infografis, Statistik Sektoral)
// =========================================================================
Route::prefix('publikasi')->name('publikasi.')->group(function () {
    Route::redirect('/', '/publikasi/berita')->name('index');
    Route::get('/berita', [PublikasiController::class, 'berita'])->name('berita');
    Route::get('/artikel', [PublikasiController::class, 'artikel'])->name('artikel');
    Route::get('/infografis', [PublikasiController::class, 'infografis'])->name('infografis');
    Route::get('/statistik-sektoral-opd', [PublikasiController::class, 'statistikSektoralOpd'])->name('statistik-sektoral-opd');
    Route::get('/statistik-sektoral-kabupaten', [PublikasiController::class, 'statistikSektoralKabupaten'])->name('statistik-sektoral-kabupaten');
});

// API Endpoints untuk Interaktivitas AJAX / Chart.js
Route::get('/api/sektor/{id}', [StatistikController::class, 'getSectorData'])->name('api.sektor');
Route::get('/api/kecamatan', [StatistikController::class, 'getKecamatanData'])->name('api.kecamatan');

// Export Data (CSV & JSON)
Route::get('/download/csv/{sektor}/{tahun}', [StatistikController::class, 'downloadCsv'])->name('download.csv');
Route::get('/download/json/{sektor}/{tahun}', [StatistikController::class, 'downloadJson'])->name('download.json');
