<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NIMController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function() {
    return response()->json(['message' => 'API is working']);
});

Route::post('/checktoken', [NIMController::class, 'inputToken']);
Route::post('/vote', [NIMController::class, 'inputChoice']);
Route::post('/getToken', [NIMController::class, 'inputNIM'])->name('nim.input');
