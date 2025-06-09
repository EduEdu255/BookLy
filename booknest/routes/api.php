<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiBookController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => response()->json('Hello World, BookNest API!'));

Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/books/search', [ApiBookController::class, 'search']); // quando submeter o form de pesquisa
    Route::get('/books', [ApiBookController::class, 'index']); // listar livros da biblioteca do usuário
    Route::get('/books/{external_id}', [ApiBookController::class, 'info']); // informações de um livro
    Route::post('/books', [ApiBookController::class, 'addToLib']); // adicionar livro à biblioteca
    Route::delete('/books/{external_id}', [ApiBookController::class, 'removeFromLib']); // remover livro da biblioteca
    
    Route::post('/logout', [ApiAuthController::class, 'logout']);
});
