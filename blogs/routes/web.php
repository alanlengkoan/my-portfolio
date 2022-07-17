<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\DinasController;
use App\Http\Controllers\admin\KegiatanBeritaAcaraController;
use App\Http\Controllers\admin\KegiatanController;
use App\Http\Controllers\admin\KegiatanPencairanDanaController;
use App\Http\Controllers\admin\LaporanController;
use App\Http\Controllers\admin\OperatorController;
use App\Http\Controllers\admin\ProfilController;
use App\Http\Controllers\admin\TtdController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\operator\KegiatanBeritaAcaraController as OperatorKegiatanBeritaAcaraController;
use App\Http\Controllers\operator\KegiatanController as OperatorKegiatanController;
use App\Http\Controllers\operator\KegiatanPencairanDanaController as OperatorKegiatanPencairanDanaController;
use App\Http\Controllers\operator\LaporanController as OperatorLaporanController;
use App\Http\Controllers\operator\ProfilController as OperatorProfilController;
use App\Http\Controllers\operator\TtdController as OperatorTtdController;
use Illuminate\Support\Facades\Route;

// begin:: auth
Route::get('/', [AuthController::class, 'login'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('/check', [AuthController::class, 'check'])->name('auth.check');
// end:: auth

Route::group(['middleware' => ['session.auth', 'prevent.back.history']], function () {
    // begin:: admin
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // begin:: profil
        Route::prefix('/profil')->group(function () {
            Route::get('/', [ProfilController::class, 'index'])->name('profil');
            Route::post('/save_picture', [ProfilController::class, 'save_picture'])->name('profil.save_picture');
            Route::post('/save_account', [ProfilController::class, 'save_account'])->name('profil.save_account');
            Route::post('/save_security', [ProfilController::class, 'save_security'])->name('profil.save_security');
        });
        // end:: profil
    });
    // end:: admin
});
