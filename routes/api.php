<?php

use Illuminate\Support\Facades\Route;
use Module\Users\Infrastructure\Http\Controllers\Illuminate\RegisterController;
use Module\Users\Infraestructure\Http\Controllers\Illuminate\FindByEmailController;

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

Route::prefix('user')->group(function () {
    Route::post('/register', [RegisterController::class, 'post'])->name('user.register');
    Route::get('/by-email', [FindByEmailController::class, 'get'])->name('user.findByEmail');
});
