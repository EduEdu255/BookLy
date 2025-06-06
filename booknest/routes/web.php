<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LibraryController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('lp'));

Route::get('/register', fn() => view('auth.register'))->name('register');
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('/my-library', [LibraryController::class, 'index']);
});
