<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routing
|--------------------------------------------------------------------------
*/

/**
 * Redirect '/' [HOME]
 */
Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('web.auth.login.view');
    }

    $auth = auth()->user();
    switch ($auth->rol_tickets) {
        case 'Invitado':
            return redirect()->route('web.invitado.index');
            break;

        default:
            return redirect()->route('web.dashboard.inicio');
            break;
    }
})->name('redirect');


/**
 * Rutas de autenticación
 */
Route::prefix('auth')
    ->name('auth.')
    ->group(base_path('routes/web/auth.php'));

/**
 * Rutas de cuenta
 */
Route::prefix('cuenta')
    ->name('cuenta.')
    ->middleware('auth', 'rol_except:Invitado')
    ->group(base_path('routes/web/cuenta.php'));

/**
 * Rutas de dashboard
 */
Route::prefix('dashboard')
    ->name('dashboard.')
    ->middleware('auth', 'rol_except:Invitado')
    ->group(base_path('routes/web/dashboard.php'));

/**
 * Rutas de invitado
 */
Route::prefix('invitado')
    ->name('invitado.')
    ->middleware('auth', 'rol:Invitado')
    ->group(base_path('routes/web/invitado.php'));

