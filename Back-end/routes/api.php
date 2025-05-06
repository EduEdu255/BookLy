<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordRecoveryController;


Route::get('/', function () {
    return response()->json(['message' => 'Hello World, Bookly!']);
});

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/user/{id}', [UserController::class, 'findById'])->name('findById');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/me', [UserController::class, 'show']);
    Route::put('/me', [UserController::class, 'update']);
    Route::delete('/me', [UserController::class, 'delete']);

    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/{id}', [BookController::class, 'show']);
    Route::post('/books', [BookController::class, 'store']);
    
    Route::get('/books/{book}/notes', [NoteController::class, 'index']);

    Route::get('/notes/{id}', [NoteController::class, 'show']);
    Route::post('/notes', [NoteController::class, 'store']);
    Route::delete('/notes/{id}', [NoteController::class, 'delete']);

    Route::post('/send-password-recovery', [PasswordRecoveryController::class, 'sendPasswordRecoveryEmail']);
});
