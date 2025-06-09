<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('lp'));

Route::get('/register', fn() => view('auth.register'))->name('register');
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('/my-library', [LibraryController::class, 'index'])->name('home');

    Route::get('/books/search', fn() => view('app.books.search', ['books' => []]));
    Route::get('/books/search/result', [BookController::class, 'search'])->name('books.search.result');
    Route::get('/books/{external_id}', [BookController::class, 'info']);
    Route::post('/books', [BookController::class, 'addToLib'])->name('books.add');
    Route::patch('/books/status', [BookController::class, 'setStatus'])->name('books.status');
    Route::delete('/books', [BookController::class, 'removeFromLib'])->name('books.remove');

    Route::get('/notes/{book_id}', [NoteController::class, 'index']);
    Route::post('/notes', [NoteController::class, 'store']);
    Route::delete('/notes/{note}', [NoteController::class, 'delete']);
});
