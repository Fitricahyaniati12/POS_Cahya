<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\UserController;
use FontLib\Table\Type\name;

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::post('/register', RegisterController::class)->name('register');
Route::post('/login', LoginController::class)->name('login');
Route::post('/logout', LogoutController::class)->name('logout');

Route::get('level', [LevelController::class, 'index']);
Route::post('level', [LevelController::class, 'store']);
Route::get('level/{level}', [LevelController::class, 'show']);
Route::put('level/{level}', [LevelController::class, 'update']);
Route::delete('level/{level}', [LevelController::class, 'destroy']);

Route::get('/user', [UserController::class, 'index']);
Route::post('/user', [UserController::class, 'store']);
Route::get('/user/{user}', [UserController::class, 'show']);
Route::put('/user/{user}', [UserController::class, 'update']);
Route::delete('/user/{user}', [UserController::class, 'destroy']);

Route::get('/kategori', [KategoriController::class, 'index']);
Route::post('/kategori', [KategoriController::class, 'store']);
Route::get('/kategori/{kategori}', [KategoriController::class, 'show']);
Route::put('/kategori/{kategori}', [KategoriController::class, 'update']);
Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy']);

Route::get('/barang', [BarangController::class, 'index']);
Route::post('/barang', [BarangController::class, 'store']);
Route::get('/barang/{barang}', [BarangController::class, 'show']);
Route::put('/barang/{barang}', [BarangController::class, 'update']);
Route::delete('/barang/{barang}', [BarangController::class, 'destroy']);


Route::post('/barang/image', [BarangController::class, 'add_image'])->name('image');
Route::post('/register', RegisterController::class)->name('register');