<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\PesertaImportController;
use App\Http\Controllers\PesertaPrintController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\DashboardController;

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('/data-peserta/preview', [PesertaImportController::class, 'preview'])->name('peserta.preview');
    Route::post('/data-peserta/import', [PesertaImportController::class, 'processImport'])->name('peserta.processImport');
    Route::get('/data-peserta', [PesertaController::class, 'index'])->name('peserta.index');
    Route::resource('users', UsersController::class);
    Route::resource('peserta', PesertaController::class);
});
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::resource('scan', ScanController::class);
Route::get('/cetak-kartu', [PesertaController::class, 'cetakKartu'])->name('cetak.kartu');
Route::get('peserta/print/{id}', [PesertaPrintController::class, 'print'])->name('peserta.print');
Route::post('/scan/store', [ScanController::class, 'store'])->name('scan.store');
Route::get('/scan/belum-scan', [ScanController::class, 'getBelumScan']);
Route::resource('scan', ScanController::class)->only(['index', 'store']);

