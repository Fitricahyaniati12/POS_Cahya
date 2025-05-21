<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\LevelController;


Route::post('/register', RegisterController::class)->name('register');
Route::post('/login', LoginController::class)->name('login');
Route::post('/logout', LogoutController::class)->name('logout');
Route::get('level', [LevelController::class, 'index']);
Route::post('level', [LevelController::class, 'store']);
Route::get('level/{level}', [LevelController::class, 'show']);
Route::put('level/{level}', [LevelController::class, 'update']);
Route::delete('level/{level}', [LevelController::class, 'destroy']);



Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});