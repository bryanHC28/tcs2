<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Resources as ResourcesControllers;

/*
|--------------------------------------------------------------------------
| API [Resources]
|--------------------------------------------------------------------------
Route::group(['middleware'=>'auth:api'],function(){


});
*/
Route::get('mail', [ResourcesControllers\QrController::class, 'mails'])->name('mail');
Route::get('areas/{id_sucursal}', [ResourcesControllers\AreasController::class, 'index'])->name('areas');
Route::get('areas_lsm', [ResourcesControllers\AreasController::class, 'areas_lsm'])->name('areas_lsm');
Route::get('responzable/{id_sucursal}', [ResourcesControllers\AreasController::class, 'responzable'])->name('responzable');
Route::get('niveles/{id_area}', [ResourcesControllers\AreasController::class, 'niveles'])->name('niveles');
Route::get('tcs-nvl-trbl/{id_subarea}', [ResourcesControllers\AreasController::class, 'niveles_trbl'])->name('tcs-nvl-trbl');
Route::get('subareas/{id_sucursal}/{id_area}', [ResourcesControllers\TCSSubareasController::class, 'index'])->name('subareas');
Route::get('tcs-categorias/{id_sucursal}', [ResourcesControllers\TCSCategoriasController::class, 'index'])->name('tcs_categorias');
Route::get('categorias_lsm/{id_area}', [ResourcesControllers\TCSCategoriasController::class, 'categorias_lsm'])->name('categorias_lsm');
Route::get('tcs-categoriasAccor/{id_area}', [ResourcesControllers\TCSCategoriasController::class, 'categariasAccor'])->name('tcs-categoriasAccor');
Route::get('tcs-subcategorias/{id_sucursal}/{id_categoria}', [ResourcesControllers\TCSSubcategoriasController::class, 'index'])->name('tcs_subcategorias');
Route::get('tickets_pilot', [ResourcesControllers\QrController::class, 'tickets_pilot'])->name('tickets_pilot');
Route::get('cron', [ResourcesControllers\QrController::class, 'cron'])->name('cron');
Route::get('/tickets',[ResourcesControllers\TicketsController::class,'index']);
Route::post('/tickets',[ResourcesControllers\TicketsController::class,'store']);
Route::post('/offline',[ResourcesControllers\TicketsController::class,'offline']);
Route::get('/tickets/{folio}',[ResourcesControllers\TicketsController::class,'show']);
Route::get('show_proyectos9/{id}',[ResourcesControllers\TicketsController::class,'show_9']);
Route::get('show_monalisa/{id}',[ResourcesControllers\TicketsController::class,'show_monalisa']);
Route::get('/mostrar_ticket/{ticket}',[ResourcesControllers\TicketsController::class,'mostrar_ticket']);
Route::put('/tickets/{folio}',[ResourcesControllers\TicketsController::class,'update']);
Route::delete('/tickets/{folio}',[ResourcesControllers\TicketsController::class,'destroy']);
Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    return "Cleared!";
});
