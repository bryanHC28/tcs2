<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Auth as Controller;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('web.auth.login.view');
});


Route::prefix('login')->name('login.')->group(function () {
    Route::get('/', [Controller\AuthController::class, 'login'])->name('view');
    Route::post('/', [Controller\AuthController::class, 'login_post'])->name('post');

    Route::name('outside.')->prefix('outside')->group(function () {
        Route::get('qr/{id_empresa}/{id_sucursal}', [Controller\LoginOutsideController::class, 'qr'])->name('qr');
    });
    Route::name('logueo.')->prefix('logueo')->group(function () {
        Route::get('invitado/{id_empresa}/{id_sucursal}', [Controller\LoginOutsideController::class, 'logueo'])->name('logueo');
    });
});

if (config('app.mail_toggle.reset_password')) {
    Route::prefix('reset-password')->name('reset_password.')->group(function () {
        Route::get('/', [Controller\ResetPasswordController::class, 'view'])->name('view');
        Route::post('/', [Controller\ResetPasswordController::class, 'send_email'])->name('post');
        Route::get('token/{token}', [Controller\ResetPasswordController::class, 'get_token'])->name('token_view');
        Route::post('token', [Controller\ResetPasswordController::class, 'reset'])->name('token_post');
    });
}


Route::middleware('auth')->group(function () {
    Route::get('logout', [Controller\AuthController::class, 'logout'])->name('logout');
});
