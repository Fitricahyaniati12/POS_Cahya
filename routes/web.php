<?php

use App\Http\Controllers\PenjualanDetailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\WelcomeController;
use App\Models\PenjualanDetailModel;
use App\Http\Controllers\AuthController;

Route::pattern('id','[0-9]+');

// Public routes
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'postregister']);

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', [WelcomeController::class, 'index']);
    
    // Profile routes
    Route::get('/profile', [UserController::class, 'profile']);
    Route::post('/profile/update-picture', [UserController::class, 'updateProfilePicture']);

    // Admin only routes
    Route::middleware(['authorize:ADM'])->group(function () {
        Route::prefix('user')
            ->controller(UserController::class)
            ->group(function () {
                Route::get('/', 'index');
                Route::post('/list', 'list');
                Route::get('/create', 'create');
                Route::post('/', 'store');
                Route::get('/create_ajax', 'create_ajax');
                Route::post('/ajax', 'store_ajax');
                Route::get('/{id}', 'show');
                Route::get('/{id}/edit', 'edit');
                Route::put('/{id}', 'update');
                Route::get('/{id}/edit_ajax', 'edit_ajax');
                Route::put('/{id}/update_ajax', 'update_ajax');
                Route::get('/{id}/delete_ajax', 'confirm_ajax');
                Route::delete('/{id}/delete_ajax', 'delete_ajax');
                Route::delete('/{id}', 'destroy');
                Route::get('/{id}/show_ajax', 'show_ajax');
            });
    });

    // Admin and Manager routes
    Route::middleware(['authorize:ADM'])->group(function () {
        Route::prefix('level')
            ->controller(LevelController::class)
            ->group(function () {
                Route::get('/', 'index');
                Route::post('/list', 'list');
                Route::get('/create', 'create');
                Route::post('/', 'store');
                Route::get('/create_ajax', 'create_ajax');
                Route::post('/store_ajax', 'store_ajax');
                Route::get('/{id}', 'show');
                Route::get('/{id}/edit', 'edit');
                Route::put('/{id}', 'update');
                Route::get('/{id}/show_ajax', 'show_ajax');
                Route::get('/{id}/edit_ajax', 'edit_ajax');
                Route::put('/{id}/update_ajax', 'update_ajax');
                Route::get('/{id}/delete_ajax', 'confirm_ajax');
                Route::delete('/{id}/delete_ajax', 'delete_ajax');
                Route::delete('/{id}', 'destroy');
            });
    });

    Route::prefix('kategori')
        ->middleware(['authorize:ADM,MNG,STF'])
        ->controller(KategoriController::class)
        ->group(function () {
            Route::get('/', 'index');
            Route::post('/list', 'list');
            Route::get('/create', 'create');
            Route::post('/', 'store');
            Route::get('/create_ajax', 'create_ajax');
            Route::post('/store_ajax', 'store_ajax');
            Route::get('/{id}', 'show');
            Route::get('/{id}/edit', 'edit');
            Route::put('/{id}', 'update');
            Route::get('/{id}/show_ajax', 'show_ajax');
            Route::get('/{id}/edit_ajax', 'edit_ajax');
            Route::put('/{id}/update_ajax', 'update_ajax');
            Route::get('/{id}/delete_ajax', 'confirm_ajax');
            Route::delete('/{id}/delete_ajax', 'delete_ajax');
            Route::delete('/{id}', 'destroy');
        });

    Route::prefix('barang')
        ->middleware(['authorize:ADM,MNG,STF'])
        ->controller(BarangController::class)
        ->group(function () {
            Route::get('/', 'index');
            Route::post('/list', 'list');
            Route::get('/create', 'create');
            Route::post('/', 'store');
            Route::get('/create_ajax', 'create_ajax');
            Route::post('/ajax', 'store_ajax');
            Route::get('/{id}', 'show');
            Route::get('/{id}/edit', 'edit');
            Route::put('/{id}', 'update');
            Route::get('/{id}/edit_ajax', 'edit_ajax');
            Route::put('/{id}/update_ajax', 'update_ajax');
            Route::get('/{id}/delete_ajax', 'confirm_ajax');
            Route::delete('/{id}/delete_ajax', 'delete_ajax');
            Route::get('/{id}/show_ajax', 'show_ajax');
            Route::delete('/{id}', 'destroy');
            Route::get('/import', 'import')->name('barang.import');
            Route::post('/import_ajax', 'import_ajax')->name('barang.import_ajax');
            //Route::post('/import_ajax',[BarangController::class, 'import_ajax']);
            Route::get('/export_excel', 'export_excel')->name('barang.export_excel');
            Route::get('/export_pdf', 'export_pdf');
        });

    // Admin and Staff routes
    Route::middleware(['authorize:ADM,STF'])->group(function () {
        Route::prefix('penjualan')
            ->controller(PenjualanController::class)
            ->group(function () {
                Route::get('/', 'index');
                Route::post('/list', 'list');
                Route::get('/create', 'create');
                Route::post('/', 'store');
                Route::get('/create_ajax', 'create_ajax');
                Route::post('/ajax', 'store_ajax');
                Route::get('/{id}/show_ajax', 'show_ajax');
                Route::get('/{id}', 'show');
                Route::get('/{id}/edit', 'edit');
                Route::put('/{id}', 'update');
                Route::get('/{id}/edit_ajax', 'edit_ajax');
                Route::put('/{id}/update_ajax', 'update_ajax');
                Route::get('/{id}/delete_ajax', 'confirm_ajax');
                Route::delete('/{id}/delete_ajax', 'delete_ajax');
                Route::delete('/{id}', 'destroy');
            });

        Route::prefix('penjualan_detail')
            ->controller(PenjualanDetailController::class)
            ->group(function () {
                Route::get('/', 'index');
                Route::post('/list', 'list');
                Route::get('/create', 'create');
                Route::post('/', 'store');
                Route::get('/create_ajax', 'create_ajax');
                Route::post('/ajax', 'store_ajax');
                Route::get('/{id}/show_ajax', 'show_ajax');
                Route::get('/{id}', 'show');
                Route::get('/{id}/edit', 'edit');
                Route::put('/{id}', 'update');
                Route::get('/{id}/edit_ajax', 'edit_ajax');
                Route::put('/{id}/update_ajax', 'update_ajax');
                Route::get('/{id}/delete_ajax', 'confirm_ajax');
                Route::delete('/{id}/delete_ajax', 'delete_ajax');
                Route::delete('/{id}', 'destroy');
            });
    });

    // Admin, Manager, and Staff routes for stok
    Route::prefix('stok')
        ->middleware(['authorize:ADM,MNG,STF'])
        ->controller(StokController::class)
        ->group(function () {
            Route::get('/', 'index');
            Route::post('/list', 'list');
            Route::get('/create', 'create');
            Route::post('/', 'store');
            Route::get('/create_ajax', 'create_ajax');
            Route::post('/store_ajax', 'store_ajax');
            Route::get('/{id}', 'show');
            Route::get('/{id}/edit', 'edit');
            Route::put('/{id}', 'update');
            Route::get('/{id}/show_ajax', 'show_ajax');
            Route::get('/{id}/edit_ajax', 'edit_ajax');
            Route::put('/{id}/update_ajax', 'update_ajax');
            Route::get('/{id}/delete_ajax', 'confirm_ajax');
            Route::delete('/{id}/delete_ajax', 'delete_ajax');
            Route::delete('/{id}', 'destroy');
            Route::post('/ajax', [BarangController::class, 'store_ajax']);

          
});
            Route::get('/profile', [UserController::class, 'profile']);
            Route::post('/profile/update-picture', [UserController::class, 'updateProfilePicture']);
});