<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiCategoryController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('login', [ApiAuthController::class, 'login']);
    Route::post('admin-login', [ApiAuthController::class, 'adminLogin']);
    Route::post('forget-password', [ApiAuthController::class, 'forgetPassword'])->name('user.forget.password');
    Route::post('reset-password', [ApiAuthController::class, 'resetPassword'])->name('user.reset.password');
});

Route::prefix('auth')->middleware('auth:api')->group(function () {
    Route::get('logout', [ApiAuthController::class, 'logout']);
});

Route::middleware('auth:api')->group(function () {
    Route::apiResource('category', ApiCategoryController::class);
});
