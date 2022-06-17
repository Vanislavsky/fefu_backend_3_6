<?php

use App\Http\Controllers\Api\AppealApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CartApiController;
use App\Http\Controllers\Api\CatalogApiController;
use App\Http\Controllers\Api\NewsApiController;
use App\Http\Controllers\Api\PageApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\UserApiController;
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

Route::post('register', [AuthApiController::class, 'register']);
Route::post('login', [AuthApiController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', [UserApiController::class, 'show']);
Route::middleware('auth:sanctum')->post('/logout', [AuthApiController::class, 'logout']);

Route::apiResource('pages', PageApiController::class)->only([
    'index',
    'show',
]);

Route::apiResource('news', NewsApiController::class)->only([
    'index',
    'show',
]);

Route::apiResource('product_category', CatalogApiController::class)->only([
    'index',
    'show',
]);

Route::post('appeal', [AppealApiController::class, 'send']);

Route::prefix('catalog')->group(function () {
    Route::get('products/list', [ProductApiController::class, 'index']);
    Route::get('products/details', [ProductApiController::class, 'show']);
});

Route::post('/cart/set_quantity', CartApiController::class)->middleware('auth.optional');
