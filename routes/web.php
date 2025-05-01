<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\PesertaImportController;
use App\Http\Controllers\PesertaPrintController;
use App\Http\Controllers\PesertaController;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('users', UsersController::class);
Route::resource('scan', ScanController::class);
Route::get('peserta', [PesertaImportController::class, 'index'])->name('peserta.index');
Route::post('peserta/import', [PesertaImportController::class, 'import'])->name('peserta.import');
Route::get('peserta/print/{id}', [PesertaPrintController::class, 'print'])->name('peserta.print');
Route::get('/cetak-kartu', [PesertaController::class, 'cetakKartu'])->name('cetak.kartu');