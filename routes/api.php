<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestoController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AuthenticationController;

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

Route::post('/auth/login', [AuthenticationController::class, 'login'])->name('auth.login')->middleware('guest');
Route::post('/auth/register', [AuthenticationController::class, 'register'])->name('auth.register')->middleware('guest');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/profile', [AuthenticationController::class, 'profile'])->name('auth.profile');
    Route::get('/auth/logout', [AuthenticationController::class, 'logout'])->name('auth.logout');
    
    Route::apiResource('reviews', ReviewController::class);
    Route::get('/restos/profile/{id}', [RestoController::class, 'show_resto_profile'])->name('restos.profile');
});
Route::apiResource('restos', RestoController::class);
Route::get('/restos/{resto}/reviews', [RestoController::class, 'reviews'])->name('restos.reviews');