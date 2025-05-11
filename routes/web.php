<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\PesertaImportController;
use App\Http\Controllers\PesertaPrintController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DatascanController;
use App\Http\Controllers\DataexportController;

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('/data-peserta/preview', [PesertaImportController::class, 'preview'])->name('peserta.preview');
    Route::post('/data-peserta/import', [PesertaImportController::class, 'processImport'])->name('peserta.processImport');
    Route::get('/data-peserta', [PesertaController::class, 'index'])->name('peserta.index');
    Route::resource('users', UsersController::class);
    Route::resource('peserta', PesertaController::class);
    Route::get('/data-scan', [DatascanController::class, 'index'])->name('datascan.index');
    Route::delete('/data-scan/{id_scan}', [DatascanController::class, 'destroy'])->name('scan.destroy');
    Route::post('/data-scan/rekap', [DataScanController::class, 'rekap'])->name('datascan.rekap');
    Route::get('/data-export', [DataexportController::class, 'index'])->name('dataexport.index');
    Route::delete('/data-export/{nama}', [DataexportController::class, 'destroy'])->name('dataexport.destroy');
    Route::get('/data-export/export/{nama}/{format}', [DataexportController::class, 'export'])->name('dataexport.export');
});
Route::get('/admin-users', [AdminUserController::class, 'index'])->name('admin-users.index');
Route::post('/admin-users', [AdminUserController::class, 'store'])->name('admin-users.store');
Route::put('/admin-users/{id}', [AdminUserController::class, 'update'])->name('admin-users.update');
Route::delete('/admin-users/{id}', [AdminUserController::class, 'destroy'])->name('admin-users.destroy');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::resource('scan', ScanController::class);
Route::get('/cetak-kartu', [PesertaController::class, 'cetakKartu'])->name('cetak.kartu');
Route::get('peserta/print/{id}', [PesertaPrintController::class, 'print'])->name('peserta.print');
Route::post('/scan/store', [ScanController::class, 'store'])->name('scan.store');
Route::get('/scan/belum-scan', [ScanController::class, 'getBelumScan']);
Route::resource('scan', ScanController::class)->only(['index', 'store']);
