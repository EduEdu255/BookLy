<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/teste', function () {
    return response()->json(['message' => 'API funcionando!']);
});
