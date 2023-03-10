<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Route;
use Module\Users\Infraestructure\Http\Controllers\Illuminate\FindByEmailController;
use Module\Users\Infrastructure\Http\Controllers\Illuminate\RegisterController;

Route::prefix('user')->group(function () {
    Route::post('/register', [RegisterController::class, 'post'])->name('user.register');
    Route::get('/by-email', [FindByEmailController::class, 'get'])->name('user.findByEmail');
    Route::patch('/change-email/{currentEmail}', [ChangeEmailController::class, 'patch'])->name('user.changeEmail');
    Route::patch('/change-password', [ChangePasswordController::class, 'patch'])->name('user.changePassword');
});
