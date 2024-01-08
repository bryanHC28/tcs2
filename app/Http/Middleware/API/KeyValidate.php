<?php

namespace App\Http\Middleware\API;

use App\Helpers\ApiValidation;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Rules;

class KeyValidate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $validator = Validator::make(['api_key' => $request->api_key], [
            'api_key' => [new Rules\ApiKey()]
        ]);

        if ($validator->fails()) {
            return ApiValidation::sendErrors($validator->errors());
        }

        return $next($request);
    }
}
