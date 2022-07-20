<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ProfilController;
use App\Http\Controllers\admin\StackController;
use App\Http\Controllers\AuthController;
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

        // begin:: stack
        Route::prefix('/stack')->group(function () {
            Route::get('/', [StackController::class, 'index'])->name('stack');
            Route::get('/get', [StackController::class, 'get'])->name('stack.get');
            Route::get('/get_all', [StackController::class, 'get_all'])->name('stack.get_all');
            Route::get('/get_data_dt', [StackController::class, 'get_data_dt'])->name('stack.get_data_dt');
            Route::post('/save', [StackController::class, 'save'])->name('stack.save');
            Route::post('/del', [StackController::class, 'del'])->name('stack.del');
        });
        // end:: stack
    });
    // end:: admin
});
