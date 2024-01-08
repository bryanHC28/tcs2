<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Invitado;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [Invitado\InvitadoController::class, 'index'])->name('index');
Route::post('generar', [Invitado\InvitadoController::class, 'generar'])->name('generar');
