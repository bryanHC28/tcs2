<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routing
|--------------------------------------------------------------------------
*/

Route::prefix('resources')
    ->name('resources.')
    ->group(base_path('routes/api/resources.php'));
