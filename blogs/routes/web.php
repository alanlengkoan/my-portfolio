<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ProfilController;
use App\Http\Controllers\admin\ProjectController;
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

        // begin:: category
        Route::prefix('/category')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('category');
            Route::get('/get', [CategoryController::class, 'get'])->name('category.get');
            Route::get('/get_all', [CategoryController::class, 'get_all'])->name('category.get_all');
            Route::get('/get_data_dt', [CategoryController::class, 'get_data_dt'])->name('category.get_data_dt');
            Route::post('/save', [CategoryController::class, 'save'])->name('category.save');
            Route::post('/del', [CategoryController::class, 'del'])->name('category.del');
        });
        // end:: category

        // begin:: project
        Route::prefix('/project')->group(function () {
            Route::get('/', [ProjectController::class, 'index'])->name('project');
            Route::get('/add', [ProjectController::class, 'add'])->name('project.add');
            Route::get('/upd/{id}', [ProjectController::class, 'upd'])->name('project.upd');
            Route::get('/det/{id}', [ProjectController::class, 'det'])->name('project.det');
            Route::get('/get_data_dt', [ProjectController::class, 'get_data_dt'])->name('project.get_data_dt');
            Route::get('/get_stack_detail/{id}', [ProjectController::class, 'get_stack_detail'])->name('project.get_stack_detail');
            Route::get('/get_picture_detail/{id}', [ProjectController::class, 'get_picture_detail'])->name('project.get_picture_detail');
            Route::post('/del_picture_detail', [ProjectController::class, 'del_picture_detail'])->name('project.del_picture_detail');
            Route::post('/save', [ProjectController::class, 'save'])->name('project.save');
            Route::post('/del', [ProjectController::class, 'del'])->name('project.del');
        });
        // end:: project
    });
    // end:: admin
});
