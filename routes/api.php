<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Module\Users\Infrastructure\Http\Controllers\Illuminate\ChangeEmailController;
use Module\Users\Infrastructure\Http\Controllers\Illuminate\FindByEmailController;
use Module\Users\Infrastructure\Http\Controllers\Illuminate\RegisterController;

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
    Route::get('/by-email/{userEmail}', [FindByEmailController::class, 'get'])->name('user.findByEmail');
    Route::patch('/{userId}/change-email', [ChangeEmailController::class, 'patch'])->name('user.changeEmail');
    Route::patch('/{userId}/change-password', [ChangePasswordController::class, 'patch'])->name('user.changePassword');
});
