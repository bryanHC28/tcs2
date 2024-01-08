<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;

class RolExcept
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, String $rol)
    {
        if ($request->user()->rol_tickets == $rol) {
            return abort(403);
        }

        return $next($request);
    }
}
