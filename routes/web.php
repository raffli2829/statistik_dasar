<?php

use App\Http\Controllers\StatistikController;
use Illuminate\Support\Facades\Route;

// Halaman Utama Sub-Modul Statistik Dasar
Route::get('/', [StatistikController::class, 'index'])->name('statistik.index');
Route::get('/statistik-dasar', [StatistikController::class, 'index'])->name('statistik.subpage');

// API Endpoints untuk Interaktivitas AJAX / Chart.js
Route::get('/api/sektor/{id}', [StatistikController::class, 'getSectorData'])->name('api.sektor');
Route::get('/api/kecamatan', [StatistikController::class, 'getKecamatanData'])->name('api.kecamatan');

// Export Data (CSV & JSON)
Route::get('/download/csv/{sektor}/{tahun}', [StatistikController::class, 'downloadCsv'])->name('download.csv');
Route::get('/download/json/{sektor}/{tahun}', [StatistikController::class, 'downloadJson'])->name('download.json');
