<?php

use App\Http\Controllers\OAuthController;
use App\Http\Controllers\Web\AppealWebController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CartWebController;
use App\Http\Controllers\Web\CatalogWebController;
use App\Http\Controllers\Web\NewsWebController;
use App\Http\Controllers\Web\OrderWebController;
use App\Http\Controllers\Web\PageWebController;
use App\Http\Controllers\Web\ProductWebController;
use App\Http\Controllers\Web\ProfileWebController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/catalog/product/{slug}', [ProductWebController::class, 'index'])->name('product');
Route::get('/catalog/{slug?}', [CatalogWebController::class, 'index'])->name('catalog');
Route::get('/pages', [PageWebController::class, 'index']);
Route::get('/pages/{slug}', [PageWebController::class, 'show']);
Route::get('/news', [NewsWebController::class, 'index']);
Route::get('/news/{slug}', [NewsWebController::class, 'show']);

Route::get('/appeal',[AppealWebController::class, 'form'])->name('appeal.form');
Route::post('/appeal',[AppealWebController::class, 'send'])->name('appeal.send');

Route::get('/profile', [ProfileWebController::class, 'show'])
    ->middleware('auth')
    ->name('profile');

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'regiserForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::prefix('oauth')->group(function () {
    Route::get('/{provider}/redirect', [OAuthController::class, 'redirectToservice'])->name('oauth.redirect');
    Route::get('/{provider}/login', [OAuthController::class, 'login'])->name('oauth.login');
});

Route::get('/cart', CartWebController::class)->middleware('auth.optional');
Route::get('/checkout', [OrderWebController::class, 'create']);
Route::post('/checkout', [OrderWebController::class, 'store'])->name('checkout.store');
