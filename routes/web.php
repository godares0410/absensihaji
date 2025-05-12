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
use App\Http\Controllers\CetakkartuController;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Login routes (tanpa middleware auth)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Protected routes (require auth)
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Peserta import
    Route::post('/data-peserta/preview', [PesertaImportController::class, 'preview'])->name('peserta.preview');
    Route::post('/data-peserta/import', [PesertaImportController::class, 'processImport'])->name('peserta.processImport');

    // Peserta
    Route::get('/data-peserta', [PesertaController::class, 'index'])->name('peserta.index');
    Route::post('/peserta/bulk-delete', [PesertaController::class, 'bulkDelete'])->name('peserta.bulkDelete');
    Route::resource('peserta', PesertaController::class);
    Route::get('/cetak-kartu', [PesertaController::class, 'cetakKartu'])->name('cetak.kartu');
    Route::get('peserta/print/{id}', [PesertaPrintController::class, 'print'])->name('peserta.print');

    // Data Scan
    Route::get('/data-scan', [DatascanController::class, 'index'])->name('datascan.index');
    Route::delete('/data-scan/{id_scan}', [DatascanController::class, 'destroy'])->name('scan.destroy');
    Route::post('/data-scan/rekap', [DatascanController::class, 'rekap'])->name('datascan.rekap');

    // Data Export
    Route::get('/data-export', [DataexportController::class, 'index'])->name('dataexport.index');
    Route::delete('/data-export/{nama}', [DataexportController::class, 'destroy'])->name('dataexport.destroy');
    Route::get('/data-export/export/{nama}/{format}', [DataexportController::class, 'export'])->name('dataexport.export');

    // Cetak Kartu
    Route::resource('data-cetak', CetakkartuController::class);
    Route::get('/data-cetak/cetak', [CetakkartuController::class, 'cetakKartu'])->name('peserta.cetakKartu');
    Route::get('/get-regu/{rombongan}', [CetakkartuController::class, 'getRegu']);

    // Users & Admin
    Route::resource('users', UsersController::class);
    Route::get('/admin-users', [AdminUserController::class, 'index'])->name('admin-users.index');
    Route::post('/admin-users', [AdminUserController::class, 'store'])->name('admin-users.store');
    Route::put('/admin-users/{id}', [AdminUserController::class, 'update'])->name('admin-users.update');
    Route::delete('/admin-users/{id}', [AdminUserController::class, 'destroy'])->name('admin-users.destroy');
});

// Scan routes (accessible without login)
Route::resource('scan', ScanController::class)->only(['index', 'store']);
Route::post('/scan/store', [ScanController::class, 'store'])->name('scan.store');
Route::get('/scan/belum-scan', [ScanController::class, 'getBelumScan']);
