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
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::post('/custom-url', [ShortUrlController::class, 'customUrl']);
        Route::get('/my-url', [UserUrlController::class, 'index']);
        Route::get('/visit/{shortUrlId}', [UserUrlController::class, 'visit']);
    });
    
    Route::post('/short-url', [ShortUrlController::class, 'shortUrl']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});