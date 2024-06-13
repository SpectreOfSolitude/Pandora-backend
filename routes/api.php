<?php

use App\Http\Controllers\NIMController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/test', function() {
    return response()->json(['message' => 'API is working']);
});

Route::post('/checktoken', [NIMController::class, 'inputToken']);
Route::post('/vote', [NIMController::class, 'inputChoice']);
Route::post('/getToken', [NIMController::class, 'inputNIM']);


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
