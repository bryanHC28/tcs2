<?php

use App\Http\Controllers\Old as Controllers;
use Illuminate\Support\Facades\Auth;
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

Route::resource('tickets', Controllers\TicketsController::class)->names('tickets');
Route::post('subcategoria', [Controllers\TicketsController::class, 'subcategoria'])->name('subcategoria.post');
Route::post('area', [Controllers\TicketsController::class, 'area'])->name('area.post');
Route::get('filtrograficas', [Resources\TicketsController::class, 'filtrograficas'])->name('filtrograficas');


