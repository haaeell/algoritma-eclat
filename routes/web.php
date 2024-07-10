<?php

use App\Http\Controllers\EclatController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProsesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::post('/import', [MahasiswaController::class, 'importMahasiswa'])->name('import');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/proses', [EclatController::class, 'configure'])->name('proses.index');
    Route::put('/proses', [EclatController::class, 'updateConfiguration'])->name('proses.updateConfiguration');
    Route::get('/hasil', [EclatController::class, 'index'])->name('hasil.index');
    Route::get('/hasil/pdf', [EclatController::class, 'cetakPdf'])->name('hasil.pdf');
});
