<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Cuenta as Controller;

/*
|--------------------------------------------------------------------------
| Cuenta Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function(){
    return redirect()->route('cuenta.editar-perfil.view');
});

Route::get('edit-profile', [Controller\EditProfileController::class, 'view'])->name('editar-perfil.view');
Route::post('edit-profile', [Controller\EditProfileController::class, 'post'])->name('editar-perfil.post');

Route::get('change-password', [Controller\ChangePasswordController::class, 'view'])->name('cambiar-contraseña.view');
Route::post('change-password', [Controller\ChangePasswordController::class, 'post'])->name('cambiar-contraseña.post');
