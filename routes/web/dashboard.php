<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Dashboard as Dashboard;
use App\Http\Controllers\Web\Resources as Resources;
use App\Http\Controllers as Controllers;


Route::get('/', function() {
    return redirect()->route('web.dashboard.inicio');
});

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    return "Cleared!";
});


Route::match(['GET', 'POST','PUT','DELETE'],'eliminar_wp/{id}', [Resources\WorkPlayController::class,'destroy'])->name('eliminar_wp');
Route::get('edit_ajax/{id}', [Resources\FotosController::class, 'edit_ajax'])->name('edit_ajax');
Route::get('tcs_json/{id}', [Resources\FotosController::class, 'datatable'])->name('tcs_json');
Route::get('inicio', [Dashboard\DashboardController::class, 'inicio'])->name('inicio');
Route::get('ajax_success/{id}', [Resources\TicketsController::class, 'UpdateStatusNoti'])->name('ajax_success');
Route::get('offline', [Resources\TicketsController::class, 'offline'])->name('offline');
Route::get('imagenes', [Resources\FotosController::class, 'imagenes'])->name('imagenes');
Route::get('imagenes_finales', [Resources\FotosController::class, 'imagenes_finales'])->name('imagenes_finales');
Route::get('imagenes_proceso', [Resources\FotosController::class, 'imagenes_proceso'])->name('imagenes_proceso');
Route::get('firmas', [Resources\FotosController::class, 'firmas'])->name('firmas');
Route::get('generarPDF/{id}', [Resources\PDFController::class, 'generarPDF'])->name('generarPDF');
Route::get('lang/{lang}', [Controllers\LanguageController::class, 'swap'])->name('lang.swap');
Route::resource('tickets', Resources\TicketsController::class)->names('tickets');
Route::resource('tcs_monalisa', Resources\Tcs_Monalisa_Controller::class)->names('tcs_monalisa');
Route::resource('tcs_proyectos9', Resources\Proyectos9Controller::class)->names('tcs_proyectos9');
Route::resource('accor', Resources\AccorController::class)->names('accor');
Route::resource('ems', Resources\EMSController::class)->names('ems');
Route::resource('workplay', Resources\WorkPlayController::class)->names('workplay');
Route::get('remember_monalisa', [Resources\Tcs_Monalisa_Controller::class,'remember']);
Route::get('filtro', [Resources\TicketsController::class, 'filtro'])->name('filtro');
Route::get('filtro_monalisa', [Resources\Tcs_Monalisa_Controller::class, 'filtro'])->name('filtro_monalisa');
Route::get('filtro_proyectos9', [Resources\Proyectos9Controller::class, 'filtro'])->name('filtro_proyectos9');
Route::get('filtro_accor', [Resources\AccorController::class, 'filtro'])->name('filtro_accor');
Route::get('filtro_ems', [Resources\EMSController::class, 'filtro'])->name('filtro_ems');
Route::get('filtro_workplay', [Resources\WorkPlayController::class, 'filtro'])->name('filtro_workplay');
Route::match(['GET', 'POST','PUT'],'filtrograficas', [Resources\TicketsController::class, 'filtrograficas'])->name('filtrograficas');
Route::match(['GET', 'POST','PUT'],'UpdateStatusNotidenied', [Resources\TicketsController::class, 'UpdateStatusNotidenied'])->name('UpdateStatusNotidenied');
Route::match(['GET', 'POST','PUT'],'update_ajax', [Resources\FotosController::class, 'update_ajax'])->name('update_ajax');
Route::match(['GET', 'POST','PUT'],'update_ajax_comentario', [Resources\Tcs_Monalisa_Controller::class, 'update_ajax_comentario'])->name('update_ajax_comentario');
Route::match(['GET', 'POST','PUT'],'update_ajax_monalisa', [Resources\Tcs_Monalisa_Controller::class, 'update_ajax_monalisa'])->name('update_ajax_monalisa');
Route::match(['GET', 'POST','PUT'],'update_ajax_ems', [Resources\EMSController::class, 'update_ajax_ems'])->name('update_ajax_ems');
Route::match(['GET', 'POST','PUT'],'update_ajax_lsm', [Resources\WorkPlayController::class, 'update_ajax_lsm'])->name('update_ajax_lsm');
Route::match(['GET', 'POST','PUT'],'update_fotos/{id}', [Resources\WorkPlayController::class, 'update_fotos'])->name('update_fotos');
Route::get('pdf', [Dashboard\DashboardController::class, 'pdf'])->name('pdf');
Route::get('pdf_lsm', [Dashboard\DashboardController::class, 'pdf_lsm'])->name('pdf_lsm');