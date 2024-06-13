<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NIMController;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/getToken', [NIMController::class, 'inputNIM'])->name('nim.input');
