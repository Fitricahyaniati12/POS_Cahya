<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;



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
    return view('welcome');
});

Route::get('/', [HomeController::class, 'index']);

// Halaman Products dengan Prefix Route
Route::prefix('category')->group(function () {
    Route::get('/food-beverage', [ProductController::class, 'foodBeverage']);
    Route::get('/beauty-health', [ProductController::class, 'beautyHealth']);
    Route::get('/home-care', [ProductController::class, 'homeCare']);
    Route::get('/baby-kid', [ProductController::class, 'babyKid']);
});

Route::get('/user/{id}/name/{name}', [UserController::class, 'profile']);

Route::get('/sales', [SalesController::class, 'index']);

Route::get('/level', [LevelController::class, 'index']);

Route ::get('/Kategori', [KategoriController::class, 'index']);

Route::get('/user', [UserController::class, 'index']);

//Route::get('/user/tambah', [UserController::class, 'tambah'])->name('user.tambah');


Route::get('/user', [UserController::class, 'index'])->name('user');
Route::get('/user/tambah', [UserController::class, 'tambah'])->name('user.tambah');
Route::get('/user/ubah/{id}', [UserController::class, 'ubah'])->name('user.ubah');
Route::get('/user/hapus/{id}', [UserController::class, 'hapus'])->name('user.hapus');
Route::post('/user/tambah_simpan', [UserController::class, 'simpan'])->name('user.tambah_simpan');
Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubahSimpan'])->name('user.ubah_simpan');