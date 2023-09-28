<?php

use App\Http\Controllers\SessionController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * 会话管理
 */
Route::prefix('session')->group(function () {
    Route::post("register", [SessionController::class, 'register']);
    Route::post('login', [SessionController::class, 'login']);
    Route::delete('/', [SessionController::class, 'destroy']);
});
