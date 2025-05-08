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
Route:: get ('/', [WelcomeController :: class,'index' ]);
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
Route::pattern('id','[0-9]+');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    
/*Route::get('/', function () {
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
*/

/*Route::get('/user', [UserController::class, 'index'])->name('user');
Route::get('/user/tambah', [UserController::class, 'tambah'])->name('user.tambah');
Route::get('/user/ubah/{id}', [UserController::class, 'ubah'])->name('user.ubah');
Route::get('/user/hapus/{id}', [UserController::class, 'hapus'])->name('user.hapus');
Route::post('/user/tambah_simpan', [UserController::class, 'simpan'])->name('user.tambah_simpan');
Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubahSimpan'])->name('user.ubah_simpan');
Route::get('/', [WelcomeController::class, 'index']);
*/
Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/list', [UserController::class, 'list']);
    Route::get('/create', [UserController::class, 'create']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/create_ajax', [UserController::class, 'create_ajax']);
    Route::post('/ajax', [UserController::class, 'store_ajax']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::get('/{id}/edit', [UserController::class, 'edit']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);
    Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']);

    Route::delete('/{id}', [UserController::class, 'destroy']);
});

Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']);
    Route::post('/list', [LevelController::class, 'list']);
    Route::get('/create', [LevelController::class, 'create']);
    Route::post('/', [LevelController::class, 'store']);
    Route::get('/create_ajax', [LevelController::class, 'create_ajax']);
    Route::post('/store_ajax', [LevelController::class, 'store_ajax']);
    Route::get('/{id}', [LevelController::class, 'show']);
    Route::get('/{id}/edit', [LevelController::class, 'edit']);
    Route::put('/{id}', [LevelController::class, 'update']);
    Route::get('/{id}/show_ajax', [LevelController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
    Route::delete('/{id}', [LevelController::class, 'destroy']);
});


Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']);
    Route::post('/list', [KategoriController::class, 'list']);
    Route::get('/create', [KategoriController::class, 'create']);
    Route::post('/', [KategoriController::class, 'store']);
    Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
    Route::post('/store_ajax', [KategoriController::class, 'store_ajax']);
    Route::get('/{id}', [KategoriController::class, 'show']);
    Route::get('/{id}/edit', [KategoriController::class, 'edit']);
    Route::put('/{id}', [KategoriController::class, 'update']);
    Route::get('/{id}/show_ajax', [KategoriController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);
    Route::delete('/{id}', [KategoriController::class, 'destroy']);
});

Route::group(['prefix' => 'barang'], function () {
    Route::get('/', [BarangController::class, 'index']);
    Route::post('/list', [BarangController::class, 'list']);
    Route::get('/create', [BarangController::class, 'create']);
    Route::post('/', [BarangController::class, 'store']);
    Route::get('/create_ajax', [BarangController::class, 'create_ajax']);
    Route::post('/ajax', [BarangController::class, 'store_ajax']);
    Route::get('/{id}', [BarangController::class, 'show']);
    Route::get('/{id}/edit', [BarangController::class, 'edit']);
    Route::put('/{id}', [BarangController::class, 'update']);
    Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);
    Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']);
    Route::delete('/{id}', [BarangController::class, 'destroy']);
});

Route::group(['prefix' => 'stok'], function () {
    Route::get('/', [StokController::class, 'index']);
    Route::post('/list', [StokController::class, 'list']);
    Route::get('/create', [StokController::class, 'create']);
    Route::post('/', [StokController::class, 'store']);
    Route::get('/create_ajax', [StokController::class, 'create_ajax']);
    Route::post('/store_ajax', [StokController::class, 'store_ajax']);
    Route::get('/{id}', [StokController::class, 'show']);
    Route::get('/{id}/edit', [StokController::class, 'edit']);
    Route::put('/{id}', [StokController::class, 'update']);
    Route::get('/{id}/show_ajax', [StokController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [StokController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [StokController::class, 'delete_ajax']);
    Route::delete('/{id}', [StokController::class, 'destroy']);
    Route::post('/ajax', [BarangController::class, 'store_ajax']);

});

Route::group(['prefix' => 'penjualan'], function () {
    Route::get('/', [PenjualanController::class, 'index']);
    Route::post('/list', [PenjualanController::class, 'list']);
    Route::get('/create', [PenjualanController::class, 'create']);
    Route::post('/', [PenjualanController::class, 'store']);
    Route::get('/create_ajax', [PenjualanController::class, 'create_ajax']);
    Route::get('/penjualan/create_ajax', [PenjualanController::class, 'create_ajax'])->name('penjualan.create_ajax');
    Route::post('/ajax', [PenjualanController::class, 'store_ajax']);
    Route::get('/{id}', [PenjualanController::class, 'show']);
    Route::get('/{id}/show', [PenjualanController::class, 'show'])->name('penjualan.show');
    Route::get('/{id}/edit', [PenjualanController::class, 'edit']);
    Route::put('/{id}', [PenjualanController::class, 'update']);
    Route::get('/{id}/edit_ajax', [PenjualanController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [PenjualanController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [PenjualanController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax']);
    Route::get('/{id}/show_ajax', [PenjualanController::class, 'show_ajax']);
    Route::delete('/{id}', [PenjualanController::class, 'destroy']);
});

Route::group(['prefix' => 'penjualan_detail'], function () {
    Route::get('/', [PenjualanDetailController::class, 'index']);
    Route::post('/list', [PenjualanDetailController::class, 'list']);
    Route::get('/create', [PenjualanDetailController::class, 'create']);
    Route::post('/', [PenjualanDetailController::class, 'store']);
    Route::get('/create_ajax', [PenjualanDetailController::class, 'create_ajax']);
    Route::post('/ajax', [PenjualanDetailController::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [PenjualanDetailController::class, 'show_ajax']);
    Route::get('/{id}', [PenjualanDetailController::class, 'show']);
    Route::get('/{id}/edit', [PenjualanDetailController::class, 'edit']);
    Route::put('/{id}', [PenjualanDetailController::class, 'update']);
    Route::get('/{id}/edit_ajax', [PenjualanDetailController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [PenjualanDetailController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [PenjualanDetailController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [PenjualanDetailController::class, 'delete_ajax']);
    Route::delete('/{id}', [PenjualanDetailController::class, 'destroy']);
});


});
