<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\UserUrlController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('/v1')->group(function() {
    Route::middleware('auth:api')->group(function ()
    {
        Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::post('/refresh', [AuthController::class, 'refresh'])->name('auth.refresh');
        Route::post('/custom-url', [ShortUrlController::class, 'customUrl'])->name('short-url.custom');
        Route::get('/my-url', [UserUrlController::class, 'index'])->name('user-url.index');
        Route::get('/visit/{shortUrlId}', [UserUrlController::class, 'urlVisits'])->name('user-url.visit');
    });
    
    Route::post('/short-url', [ShortUrlController::class, 'store'])->name('short-url.short');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});